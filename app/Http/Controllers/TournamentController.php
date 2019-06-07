<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Tournament\Repositories\TeamRepository;
use App\Modules\Tournament\TournamentBuilder;

final class TournamentController extends Controller
{
    public function index(TeamRepository $repository)
    {
        $teams = $repository->getAll();
        $tournamentBuilder = new TournamentBuilder($teams);
        $matchesPlayed = $tournamentBuilder->build();

        return view('tournament', [
            'matches' => $matchesPlayed,
        ]);
    }
}
