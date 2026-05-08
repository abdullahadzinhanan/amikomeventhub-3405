<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->latest()->get();
        $categories = Category::all();
        return view('welcome', compact('events', 'categories'));
    }
}