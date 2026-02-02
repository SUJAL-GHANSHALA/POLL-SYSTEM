<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function vote(Request $request)
    {
        $pollId   = $request->poll_id;
        $optionId = $request->option_id;
        $ip       = $request->ip();

        $alreadyVoted = DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->exists();

        if ($alreadyVoted) {
            return response()->json([
                'status'  => 'blocked',
                'message' => 'You have already voted from this IP'
            ]);
        }

        DB::table('votes')->insert([
            'poll_id'        => $pollId,
            'poll_option_id' => $optionId,
            'ip_address'     => $ip,
            'voted_at'       => now()
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Vote submitted successfully'
        ]);
    }
}

