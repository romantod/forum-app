<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Category $category, Thread $thread) {
        $validated = $request->validate([
            'body' => 'required|min:3'
        ]);

        $thread->replies()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('toast', ['type' => 'success', 'message' => 'Ответ добавлен!']);
    }

    public function destroy(Reply $reply) {
        $this->authorize('delete', $reply);
        $reply->delete();
        return back()->with('toast', ['type' => 'seccess', 'message' => 'Ответ удален!']);
    }
}
