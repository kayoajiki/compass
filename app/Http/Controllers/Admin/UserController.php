<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('profile');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('profile');
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'is_admin']);
        $data['is_admin'] = $request->has('is_admin');

        // パスワードが入力された場合のみ更新
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'ユーザー情報が正常に更新されました。');
    }

    public function destroy(User $user)
    {
        // 自分自身は削除できない
        if ($user->id === auth('admin')->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', '自分自身を削除することはできません。');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'ユーザーが正常に削除されました。');
    }
}
