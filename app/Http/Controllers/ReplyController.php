<?php

namespace App\Http\Controllers;

use App\Events\NewReplyPosted;
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

        $reply = $thread->replies()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        $reply->load('user');
        
        \Log::info('Broadcasting NewReplyPosted event', [
            'reply_id' => $reply->id,
            'thread_id' => $reply->thread_id,
        ]);
        
        event(new NewReplyPosted($reply));

        return redirect()->back()->with('toast', ['type' => 'success', 'message' => 'Ответ добавлен!']);
    }

    public function destroy(Reply $reply) {
        $this->authorize('delete', $reply);
        $reply->delete();
        return back()->with('toast', ['type' => 'success', 'message' => 'Ответ удален!']);
    }
}
