<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Stevebauman\Location\Facades\Location;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function admin_management()
    {
        $admins = Admin::paginate(10);

        // Pass the variable to the view
        return view('pages.admin-pages.admin-management', ['admins' => $admins]);
    }

    public function users()
    {
        $users = User::paginate(10);

        // Iterate through users and fetch the country code for each based on IP address
        // foreach ($users as $user) {
        //     $position = Location::get($user->location);
        //     $user->country = $position ? $position->countryCode : 'US'; // Fallback to 'US' if not found
        // }
        // Pass the variable to the view
        return view('pages.users', ['users' => $users]);
    }
}
