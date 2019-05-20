<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::with('images')->get();

        return view('home', [
            'teams' => $teams,
        ]);
    }
}
