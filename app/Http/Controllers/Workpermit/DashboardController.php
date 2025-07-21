<?php

namespace App\Http\Controllers\Workpermit;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $view = "workpermit.$role.dashboard";

        if (view()->exists($view)) {
            return view($view);
        }

        return view('workpermit.dashboard');
    }
}
