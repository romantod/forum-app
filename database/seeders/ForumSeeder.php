<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        Category::factory()->count(5)->create()->each(function ($category) use ($users) {
            Thread::factory()->count(rand(3, 8))->create([
                'category_id' => $category->id,
                'user_id' => $users->random()->id,
            ])->each(function ($thread) use ($users) {
                Reply::factory()->count(rand(2, 10))->create([
                    'thread_id' => $thread->id,
                    'user_id' => $users->random()->id,
                ]);
            });
        });
    }
}
