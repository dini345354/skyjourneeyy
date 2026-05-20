<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->withCount('orders')->latest()->paginate(10)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders.orderItems.product']);
        return view('admin.users.show', compact('user'));
    }
}
