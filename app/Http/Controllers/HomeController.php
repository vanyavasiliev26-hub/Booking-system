<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\MenuItem;

class HomeController extends Controller
{
    
    public function index()
    {
        $tables = Table::where('is_active', true)->get();
        $menuItems = MenuItem::where('is_available', true)->limit(6)->get();
        
        return view('welcome', compact('tables', 'menuItems'));
    }
    
    
}