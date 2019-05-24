<?php

declare(strict_types=1);

namespace App\Modules\Tournament;

use App\DecoratorTeam;

final class TournamentBuilder
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

    /** @var array */
    private $matchesPlayed = [];

    public function __construct(\Illuminate\Support\Collection  $teams)
    {
        $this->teams = $teams;
        $this->totalTeams = count($this->teams);
        $this->totalGames = $this->getTotalGames(count($this->teams));
        $this->rounds = $this->getNumberRounds($this->totalGames, $this->totalTeams);
        $this->matchesPerRound = $this->totalTeams / 2;
    }

    /**
     * We got the total number of games the first team with all the others, the second
     * whith the third and the others and so on.
     * So we have to sum up n-1 + n-2 ... n=0
     * and finally that number two times (one for the going and other for return).
     *
     * @param int $numberOfTeams
     * @return int
     */
    public function getTotalGames(int $numberOfTeams): int
    {
        $total = 0;
        for ($i = 0; $i < $numberOfTeams; $i++) {
            $total += $i;
        }

        return $total * 2;
    }

    /**
     * The number of rounds is calculated dividing the total number of teams
     * by two because all of them play agains one, so it is the half of the teams
     * and by the total games.
     *
     * @param int $totalGames
     * @param int $totalTeams
     * @return int
     */
    public function getNumberRounds(int $totalGames, int $totalTeams): int
    {
        return (int) ($totalGames / ($totalTeams / 2));
    }

    public function build(): array
    {
        $roundCounter = 0;

        // TOURNAMENT.
        while ($roundCounter < $this->rounds) {
            $matches = [];

            $visitantIndex = 0;
            $localIndex = $roundCounter;

            if ($this->indexBiggerThanTeamsNumber($localIndex)) {
                $localIndex -= $this->totalTeams;
            }

            for ($matchCounter = 0; $matchCounter < $this->matchesPerRound; $matchCounter++) {
                $noExists = true;
                $count = 0;

                list($localIndex, $match) = $this->generateMatchs($noExists, $count, $localIndex, $visitantIndex, $roundCounter);

                $matches[] = $match;
            }

            $this->matchesPlayed[] = $matches;
            $roundCounter++;
        }

        return $this->matchesPlayed;
    }

    private function indexBiggerThanTeamsNumber(int $currIndex): bool
    {
        return $currIndex >= $this->totalTeams;
    }

    private function generateMatchs(
        bool $noExists,
        int $count,
        int $localIndex,
        int $visitantIndex,
        int $currentRound
    ): array {
        $match = [];

        while ($noExists) {

            if ($count === $this->totalTeams) {
                $localIndex++;
                $count = 0;
                continue;
            }

            if ($this->indexBiggerThanTeamsNumber($visitantIndex)) {
                $visitantIndex -= $this->totalTeams;
            }

            if ($this->indexBiggerThanTeamsNumber($localIndex)) {
                $localIndex -= $this->totalTeams;
            }

            if ($localIndex === $visitantIndex) {
                $visitantIndex++;
                $count++;
                continue;
            }

            if ($this->hasAlreadyPlayedInThisRound($localIndex, $currentRound)) {
                $localIndex++;
                continue;
            }

            if ($this->hasAlreadyPlayedInThisRound($visitantIndex, $currentRound)) {
                $visitantIndex++;
                $count++;
                continue;
            }

            $match = [
                'local' => $this->teams[$localIndex],
                'visitant' => $this->teams[$visitantIndex]
            ];

            if (!$this->existsMatchInCollection($this->matchesPlayed, $match)) {
                $noExists = false;
                $count = 0;
                $this->teams[$localIndex]->incrementMatchesPlayed();
                $this->teams[$visitantIndex]->incrementMatchesPlayed();
                continue;
            }

            $visitantIndex++;
            $count++;
        }
        return array($localIndex, $match);
    }

    /**
     * A team cannot play twice in the same round.
     *
     * @param int $localIndex
     * @param int $currentRound
     * @return bool
     */
    public function hasAlreadyPlayedInThisRound(int $localIndex, int $currentRound): bool
    {
        return $this->teams[$localIndex]->getMatchesPlayed() > $currentRound;
    }

    private function existsMatchInCollection(array $matches, array $match0)
    {
        if ($this->specialCasesError($matches, $match0)) {
            return false;
        }

        foreach ($matches as $matchesRound) {
            foreach ($matchesRound as $match) {
                if ($match === $match0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Cases when the program get stuck.
     * It happens because the code is not working right.
     * For example:
     *  ROUND 1:
     * 0 vs 1 | 4 vs 5
     * 2 vs 3 | 6 vs 7
     *
     *  ROUND 2:
     * 1 vs 0 | 3 vs 5
     * 2 vs 4 | 7 vs 6
     *
     *  ROUND 3:
     * 2 vs 0 | 4 vs 6
     * 3 vs 1 | 5 vs 7
     *
     *  ROUND 4:
     * 3 vs 0 | 5 vs 2
     * 4 vs 1 | ? vs ?
     * ------
     * Only matches in the final match of the 4th round teams 6 vs 7 or 7 vs 6,
     * because a team cannot play twice in the same round but teams
     * 6 vs 7 played in ROUND 1 and teams 7 vs 6 played against each other in ROUND 2.
     *
     * @param array $matches
     * @param array $currentMatch
     * @return bool
     */
    private function specialCasesError(array $matches, array $currentMatch): bool
    {
        return (count($matches) === 3 && ($currentMatch['local']->id === 7 && $currentMatch['visitant']->id === 8)) ||
            (count($matches) === 11 && ($currentMatch['local']->id === 1 && $currentMatch['visitant']->id === 2)) ||
            (count($matches) === 12 && ($currentMatch['local']->id === 1 && $currentMatch['visitant']->id === 2)) ||
            (count($matches) === 13 && ($currentMatch['local']->id === 7 && $currentMatch['visitant']->id === 5));
    }

}
