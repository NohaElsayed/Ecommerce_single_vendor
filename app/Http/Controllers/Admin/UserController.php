<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepo;
    protected $roleRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        RoleRepositoryInterface $roleRepo
    ) {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        $users = $this->userRepo->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roleRepo->all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array',
            'is_active' => 'boolean',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);
        $user->syncRoles($data['roles']);

        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم');
    }

    public function edit(int $id)
    {
        $user = $this->userRepo->find($id);
        $roles = $this->roleRepo->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array',
            'is_active' => 'boolean',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->userRepo->update($id, $data);
        $user->syncRoles($data['roles']);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث المستخدم');
    }

    public function destroy(int $id)
    {
        $this->userRepo->delete($id);
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم');
    }
}
