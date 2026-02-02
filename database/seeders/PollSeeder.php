<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('polls')->count() > 0) {
            return;
        }

        $pollId = DB::table('polls')->insertGetId([
            'question' => 'Which programming language do you like most?',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('poll_options')->insert([
            ['poll_id' => $pollId, 'option_text' => 'PHP', 'created_at' => now(), 'updated_at' => now()],
            ['poll_id' => $pollId, 'option_text' => 'JavaScript', 'created_at' => now(), 'updated_at' => now()],
            ['poll_id' => $pollId, 'option_text' => 'Python', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
