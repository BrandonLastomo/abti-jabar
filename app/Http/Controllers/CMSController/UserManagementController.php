<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display list of all users.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->get('role', 'all');
        $search = $request->get('search');

        $query = User::with('roles');

        if ($roleFilter !== 'all') {
            $query->role($roleFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('cms.users.index', [
            'page' => 'users',
            'users' => $users,
            'roles' => $roles,
            'roleFilter' => $roleFilter,
            'search' => $search,
        ]);
    }

    /**
     * Show user details with their documents.
     */
    public function show(User $user)
    {
        $user->load('roles', 'documents.verifier');

        return view('cms.users.show', [
            'page' => 'users',
            'user' => $user,
        ]);
    }

    /**
     * Show edit form.
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all();

        return view('cms.users.edit', [
            'page' => 'users',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update user data.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Sync role
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Create form.
     */
    public function create()
    {
        $roles = Role::all();

        return view('cms.users.create', [
            'page' => 'users',
            'roles' => $roles,
        ]);
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        // Delete user documents from storage
        foreach ($user->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
