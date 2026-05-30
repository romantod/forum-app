<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index() {
        return Thread::with('user', 'category')->latest()->paginate(10);
    }
}
