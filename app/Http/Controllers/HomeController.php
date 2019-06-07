<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Tournament\Repositories\TeamRepository;

final class HomeController extends Controller
{
    public function index(TeamRepository $teamRepository)
    {
        $teams = $teamRepository->getAllWith('images');

        return view('home', [
            'teams' => $teams,
        ]);
    }
}
