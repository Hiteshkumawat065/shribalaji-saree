<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnRequest;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReturnService
{
    public function adminList(array $filters = []): LengthAwarePaginator
    {
        $query = ReturnRequest::with(['order', 'user', 'item'])->orderByDesc('id');

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($w) use ($q) {
                $w->where('reason', 'like', "%{$q}%")
                    ->orWhere('details', 'like', "%{$q}%")
                    ->orWhereHas('order', fn($o) => $o->where('order_number', 'like', "%{$q}%")->orWhere('id', $q))
                    ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$q}%")->orWhere('name', 'like', "%{$q}%"));
            });
        }

        return $query->paginate(20);
    }

    public function createForOrder(int $orderId, ?int $orderItemId, array $data): ReturnRequest
    {
        return DB::transaction(function () use ($orderId, $orderItemId, $data) {
            $order = Order::with('items')->findOrFail($orderId);

            if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
                throw new Exception('You are not allowed to return this order.');
            }

            if ($orderItemId) {
                $item = OrderItem::where('id', $orderItemId)->where('order_id', $orderId)->firstOrFail();
            }

            $existing = ReturnRequest::where('order_id', $orderId)
                ->when($orderItemId, fn($q) => $q->where('order_item_id', $orderItemId), fn($q) => $q->whereNull('order_item_id'))
                ->whereIn('status', ['requested', 'approved'])
                ->first();

            if ($existing) {
                throw new Exception('A return request already exists for this item/order.');
            }

            $rr = ReturnRequest::create([
                'order_id' => $orderId,
                'order_item_id' => $orderItemId,
                'user_id' => Auth::id(),
                'reason' => $data['reason'],
                'details' => $data['details'] ?? null,
                'status' => 'requested',
                'created_by' => Auth::id(),
            ]);

            Log::info('Return requested', [
                'return_request_id' => $rr->id,
                'order_id' => $orderId,
                'order_item_id' => $orderItemId,
                'user_id' => Auth::id(),
            ]);

            return $rr;
        });
    }

    public function updateStatus(int $id, array $data): ReturnRequest
    {
        return DB::transaction(function () use ($id, $data) {
            $rr = ReturnRequest::lockForUpdate()->findOrFail($id);

            $rr->update([
                'status' => $data['status'],
                'refund_amount' => $data['refund_amount'] ?? $rr->refund_amount,
                'refund_method' => $data['refund_method'] ?? $rr->refund_method,
                'admin_note' => $data['admin_note'] ?? $rr->admin_note,
                'updated_by' => Auth::id(),
            ]);

            Log::info('Return status updated', [
                'return_request_id' => $rr->id,
                'status' => $rr->status,
                'by' => Auth::id(),
            ]);

            return $rr;
        });
    }
}

