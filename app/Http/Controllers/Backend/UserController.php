<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserController extends Controller
{
    // Display a listing of the users
    public function index()
    {
        try {
            $users = User::with('userDetails')->orderBy('id', 'asc')->get();
            $data['userData'] = $users;
            return view('backend.users.index', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching users: ' . $e->getMessage());
        }
    }

    // Show the form for creating a new user
    public function createUser()
    {
        return view('backend.users.create');
    }

    // Store a newly created user in the database
    public function storeUser(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $validator = Validator::make($request->all(), [
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|unique:users,email', 
                'password'      => 'required|string|min:6|confirmed',
                'mobile_no'     => 'nullable|digits_between:8,15',
                'role'          => 'required',
                'gender'        => 'required|in:male,female,other',
                'dob'           => 'nullable|date',
                'country'       => 'nullable|string|max:255',
                'address'       => 'nullable|string',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
            ]);

            // If validation fails 
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role'       => $request->role,
                'created_by' => Auth::user()->id,
            ]); 
            
            $filePath = null; 
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $originalFilename = time() . preg_replace('/\s+/', '', $file->getClientOriginalName());
                $filePath = $file->storeAs('uploads/user', $originalFilename, 'public');
            }
            
            UserDetail::create([
                'user_id'    => $user->id,
                'mobile_no'  => $request->mobile_no,
                'address'    => $request->address,
                'dob'        => $request->dob,
                'gender'     => $request->gender,
                'country'    => $request->country,
                'profile_image'    => $filePath,
                'ip_address' => request()->ip(),
                'device_type'=> 'web',
                'timezone'   => 'UTC',
                'created_by' => Auth::user()->id,
            ]); 
            
            \Log::info('Creating user:', $request->all());

            DB::commit(); 

            return redirect()->route('admin.users')
                ->with('success', 'User created successfully'); 

        } catch (ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    
    }

    // Show the form for editing the specified user
    public function editUser($id)
    {
        try {
            $user = User::with('userDetails')->findOrFail($id); 
            return view('backend.users.edit', compact('user'));

        } catch (Exception $e) {
            return redirect()->route('users.index')
                ->with('error', $e->getMessage());
        }
    }

    // Update the specified user in the database
    public function updateUser(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|unique:users,email,' . $user->id,
                // 'password'   => 'nullable|string|min:6|confirmed', // commented
                'mobile_no'     => 'nullable|digits_between:8,15',
                'role'          => 'required',
                'gender'        => 'required|in:male,female,other',
                'dob'           => 'nullable|date',
                'country'       => 'nullable|string|max:255',
                'address'       => 'nullable|string',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // 🔹 Update users table (password excluded)
            $user->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'role'       => $request->role,
                'updated_by' => Auth::user()->id,
            ]);

            // 🔹 Profile Image Upload (optional)
            $filePath = $user->userDetail->profile_image ?? null;

            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $originalFilename = time() . preg_replace('/\s+/', '', $file->getClientOriginalName());
                $filePath = $file->storeAs('uploads/user', $originalFilename, 'public');
            }

            // 🔹 Update or Create user_details
            UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'mobile_no'   => $request->mobile_no,
                    'address'     => $request->address,
                    'dob'         => $request->dob,
                    'gender'      => $request->gender,
                    'country'     => $request->country,
                    'profile_image' => $filePath,
                    'ip_address'  => request()->ip(),
                    'device_type' => 'web',
                    'timezone'    => 'UTC',
                    'updated_by'  => Auth::user()->id,
                ]
            );

            \Log::info('Updating user:', $request->except(['profile_image']));

            DB::commit();

            return redirect()
                ->route('admin.users')
                ->with('success', 'User updated successfully');

        } catch (Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    // Display the specified user
    public function show($id)
    {
        $user = User::findOrFail($id); // Find the user or throw a 404 error
        return view('backend.users.show', compact('user'));
    }

    // Remove the specified user from the database
    public function delete(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $user->update([
                'is_active'  => 0,
                'deleted_at' => 1, // flag based delete
            ]);

            if($user->userDetails) {
                $user->userDetails->update([
                    'is_active'   => 0,
                    'deleted_at'  => 1,
                    'ip_address'  => $request->ip(),
                    'device_type' => 'web',
                    'timezone'    => 'UTC',
                    'updated_by'  => Auth::user()->id,
                ]);
            } 

            \Log::info('User Deleted', [
                'user_id' => $user->id,
                'by'      => Auth::user()->id,
            ]);
    
            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'User deleted successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
