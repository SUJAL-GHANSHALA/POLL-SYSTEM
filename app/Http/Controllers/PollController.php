<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function index()
    {
        $polls = DB::table('polls')
            ->where('is_active', 1)
            ->get();

        return view('polls.index', compact('polls'));
    }

    public function show($id)
    {
        $poll = DB::table('polls')->where('id', $id)->first();
        $options = DB::table('poll_options')->where('poll_id', $id)->get();

        return view('polls.show', compact('poll', 'options'));
    }

    public function results($id)
    {
        $results = DB::table('poll_options')
            ->leftJoin('votes', 'poll_options.id', '=', 'votes.poll_option_id')
            ->where('poll_options.poll_id', $id)
            ->select(
                'poll_options.option_text',
                DB::raw('COUNT(votes.id) as total_votes')
            )
            ->groupBy('poll_options.id', 'poll_options.option_text')
            ->get();

        return response()->json($results);
    }
}

