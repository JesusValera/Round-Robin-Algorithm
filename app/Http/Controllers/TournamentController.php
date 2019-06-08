<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Tournament\Repositories\TeamRepository;
use App\Modules\Tournament\TournamentBuilder;
use Illuminate\Http\Request;

final class TournamentController extends Controller
{
    /** @var TeamRepository */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index(Request $request)
    {
        $teams = $this->teamRepository->getAll();
        $tournamentBuilder = new TournamentBuilder($teams);
        $matchesPlayed = $tournamentBuilder->build();

        return view('tournament', [
            'matches' => $matchesPlayed,
        ]);
    }
}
