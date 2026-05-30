<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReplyPosted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public Reply $reply;

    /**
     * Create a new event instance.
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('thread.' . $this->reply->thread_id),
        ];
    }

    public function broadcastWith() {
        return [
            'reply' => [
                'id' => $this->reply->id,
                'body' => $this->reply->body,
                'created_at' => $this->reply->created_at,
                'user_id' => $this->reply->user_id,
                'user' => [
                    'name' => $this->reply->user->name,
                ],
            ],
        ];
    }
}
