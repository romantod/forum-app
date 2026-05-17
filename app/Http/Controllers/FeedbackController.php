<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|min:2',
            'message' => 'required|min:10'
        ]);

        return redirect()->back();
    }
}