<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Tournament\Repositories\TeamRepository;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    /** @var TeamRepository */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index(Request $request)
    {
        $teams = $this->teamRepository->getAllWith('images');

        return view('home', [
            'teams' => $teams,
        ]);
    }
}
