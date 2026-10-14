<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RoleManagementController extends Controller
{
    public function index(): View
    {
        return view('pages.settings.role.index');
    }
}
