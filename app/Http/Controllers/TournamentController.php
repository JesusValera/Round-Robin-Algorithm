<?php

namespace App\Http\Controllers;

use App\DecoratorTeam;
use App\Modules\Tournament\TournamentBuilder;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(Request $request)
    {
        $teams = DecoratorTeam::all();
        $tournamentBuilder = new TournamentBuilder($teams);
        $matchesPlayed = $tournamentBuilder->build();

        return view('tournament', [
            'matches' => $matchesPlayed,
        ]);
    }
}
