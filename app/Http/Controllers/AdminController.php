<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function ips($pollId)
    {
        $ips = DB::table('votes')
            ->where('poll_id', $pollId)
            ->select('ip_address', 'poll_option_id')
            ->get();

        return view('admin.ips', compact('ips', 'pollId'));
    }

    public function releaseIp(Request $request)
    {
        $pollId = $request->poll_id;
        $ip     = $request->ip_address;

        $vote = DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->first();

        if (!$vote) {
            return back()->with('error', 'Vote not found');
        }

        // AUDIT LOG (before delete)
        DB::table('vote_audits')->insert([
            'poll_id'       => $pollId,
            'ip_address'    => $ip,
            'old_option_id' => $vote->poll_option_id,
            'new_option_id' => null,
            'action_at'     => now()
        ]);

        DB::table('votes')
            ->where('poll_id', $pollId)
            ->where('ip_address', $ip)
            ->delete();

        return back()->with('success', 'IP released successfully');
    }
}

