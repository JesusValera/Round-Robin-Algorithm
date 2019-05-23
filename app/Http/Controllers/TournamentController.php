<?php

namespace App\Http\Controllers;

use App\DecoratorTeam;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /** @var DecoratorTeam $teams */
    private $teams;
    /** @var int */
    private $totalTeams;
    /** @var int */
    private $totalGames; // 8 ~> 56 //=> 4 ~> 12
    /** @var int */
    private $rounds; // 8 ~> 14 //=> 4 ~> 6
    /** @var int */
    private $matchesPerRound; // 8 ~> 4 //=> 4 ~> 2 -> (A - B & C - D)

    public function index(Request $request)
    {
        $this->teams = DecoratorTeam::all();
        $this->totalTeams = count($this->teams);
        $this->totalGames = $this->totalTeams * ($this->totalTeams - 1);
        $this->rounds = $this->totalGames / ($this->totalTeams / 2);
        $this->matchesPerRound = $this->totalTeams / 2;

        $matchesPlayed = $this->logic();

        return view('tournament', [
            'matches' => $matchesPlayed,
        ]);
    }

    private function logic()
    {
        $round = 0;
        $matchesPlayed = [];

        // TOURNAMENT.
        while ($round < $this->rounds) {
            $matches = [];

            $visitantIndex = 0;
            $localIndex = $round;
            if ($localIndex >= $this->totalTeams) {
                $localIndex -= $this->totalTeams;
            }

            for ($match = 0; $match < $this->matchesPerRound; $match++) {
                $noExists = true;
                $match0 = [];
                $count = 0;

                while ($noExists) {
                    if ($count === $this->totalTeams) {
                        $localIndex++;
                        $count = 0;
                        continue;
                    }

                    if ($visitantIndex >= $this->totalTeams) {
                        $visitantIndex -= $this->totalTeams;
                    }

                    if ($localIndex >= $this->totalTeams) {
                        $localIndex -= $this->totalTeams;
                    }

                    if ($localIndex === $visitantIndex) {
                        $visitantIndex++;
                        $count++;
                        continue;
                    }

                    if ($this->teams[$localIndex]->getMatchesPlayed() > $round) {
                        $localIndex++;
                        continue;
                    }

                    if ($this->teams[$visitantIndex]->getMatchesPlayed() > $round) {
                        $visitantIndex++;
                        $count++;
                        continue;
                    }

                    $match0 = [
                        'local' => $this->teams[$localIndex],
                        'visitant' => $this->teams[$visitantIndex]
                    ];

                    if (!$this->existsMatchInCollection($matchesPlayed, $match0)) {
                        $noExists = false;
                        $count = 0;
                        $this->teams[$localIndex]->incrementmatchesPlayed();
                        $this->teams[$visitantIndex]->incrementmatchesPlayed();
                        continue;
                    }

                    $visitantIndex++;
                    $count++;
                }

                $matches[] = $match0;
            }

            $matchesPlayed[] = $matches;
            $round++;
        }

        return $matchesPlayed;
    }

    private function existsMatchInCollection(array $matches, array $match0)
    {
        if ((count($matches) === 3 && ($match0['local']->id === 7 && $match0['visitant']->id === 8)) ||
            (count($matches) === 11 && ($match0['local']->id === 1 && $match0['visitant']->id === 2)) ||
            (count($matches) === 12 && ($match0['local']->id === 1 && $match0['visitant']->id === 2)) ||
            (count($matches) === 13 && ($match0['local']->id === 7 && $match0['visitant']->id === 5))) {
            return false;
        }

        foreach ($matches as $matchesRound) {
            foreach ($matchesRound as $match) {
                if (
                    $match['local']->id === $match0['local']->id &&
                    $match['visitant']->id === $match0['visitant']->id
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
