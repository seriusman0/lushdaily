<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_users'    => User::count(),
            'admin_users'    => User::where('role', 'admin')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
