<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ensures user is logged in
    }
    public function index(Request $request)
    {
        try {
            $roles = Role::query()->where(function ($q) {
                $q->whereNull('deleted_at')->orWhere('deleted_at', 0);
            });

            if ($request->search) {
                $roles->where('name', 'like', '%'.$request->search.'%');
            }
            $roles = $roles->paginate(10);  // Apply pagination
            $data['roleData'] = $roles;
            
            return view('backend.role.index', $data);  // Return view 

        } catch (Exception $e) {

            // Error log
            Log::error('Role Index Error: '.$e->getMessage());
            return back()->with('error','Something went wrong');
        }
    }

    public function create()
    {
        try {
            $permissions = Permission::all();       // Fetch all permissions
            $data['allPermissions'] = $permissions;
            return view('backend.role.create', $data);

        } catch (Exception $e) {

            Log::error('Role Create Page Error: '.$e->getMessage());
            return back()->with('error','Page load failed');
        }
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Validate request data
            $request->validate(['name' => 'required|unique:roles,name']);
            
            // Create new role
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
           
            // Assign permissions to role
            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }
            \Log::info('Role Created', [
                'role_id' => $role->id,
                'by'      => Auth::user()->id,
            ]);

            DB::commit();
            return redirect()->route('admin.roles')->with('success', 'Role Created Successfully');
    
        } catch (Exception $e) {

            DB::rollBack();
            // Log error
            Log::error('Role Store Error: '.$e->getMessage());
            return back()->withInput()->with('error','Role Create Failed');
        }
    }

    public function edit($id)
    {
        try {
            // Admin area is already restricted by middleware (superAdmin)
            $role = Role::findOrFail($id);
            $permissions    = Permission::all();  // Get all permissions
            
            // Existing permissions
            $rolePermissions = $role->permissions->pluck('name')->toArray();
        
            return view('backend.role.edit', compact('role','permissions','rolePermissions'));

        } catch (Exception $e) {

            Log::error('Role Edit Error: '.$e->getMessage());
            return back()->with('error','Edit Page Failed : '.$e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,'.$id,
            ]);

            $role->update(['name' => $request->name]);

            \Log::info('Role Updated', [
                'role_id' => $role->id,
                'by'      => Auth::user()->id,
            ]); 

            // Update permissions
            $role->syncPermissions($request->permissions ?? []);
            DB::commit();

            return redirect()->route('admin.roles')->with('success','Role Updated Successfully');
        } catch (Exception $e) {

            // Rollback
            DB::rollBack();

            Log::error('Role Update Error: '.$e->getMessage());

            return back()->withInput()
                ->with('error','Role Update Failed : '.$e->getMessage());
        }
    }


    public function delete(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Include trashed if you want to allow restoring later
            $role = Role::findOrFail($id);

            if ($role->name === 'superAdmin') {
                return response()->json([
                    'status' => false,
                    'message' => 'The superAdmin role cannot be deleted.',
                ], 422);
            }

            // Soft-flag delete (custom columns on roles table)
            $role->update([
                'status' => 0,
                'deleted_at' => 1,
            ]);

            // Logging
            \Log::info('Role Deleted', [
                'role_id' => $role->id,
                'by'      => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Role deleted successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Role Delete Error: '.$e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
}
