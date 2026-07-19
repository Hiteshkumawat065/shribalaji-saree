@extends('backend.layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notifications</h1>
                    <div class="text-muted small">Unread: {{ $unreadCount }}</div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Notifications</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                    @csrf
                    <button class="btn btn-outline-success" type="submit">Mark all read</button>
                </form>
            </div>

            <div class="card">
                <div class="card-body">
                    @forelse($notifications as $n)
                        @php
                            $data = $n->data ?? [];
                        @endphp
                        <div class="d-flex justify-content-between align-items-start border rounded p-3 mb-2 {{ $n->read_at ? 'bg-light' : '' }}">
                            <div>
                                <div class="font-weight-bold">{{ $data['title'] ?? class_basename($n->type) }}</div>
                                <div class="text-muted">{{ $data['message'] ?? '' }}</div>
                                <div class="text-muted small mt-1">{{ optional($n->created_at)->format('d M, Y H:i') }}</div>
                            </div>
                            <div class="text-end">
                                @if(!$n->read_at)
                                    <span class="badge bg-warning text-dark mb-2">Unread</span>
                                    <form method="POST" action="{{ route('admin.notifications.read', $n->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Mark read</button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Read</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No notifications.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </section>
@endsection

