<?php declare(strict_types=1);

namespace App\Modules\Tournament;

/**
 * Check the Round Robin (scheduling algorithm) to understand how it works. :)
 */
final class TournamentBuilder
{
    private const LOCAL = 'local';
    private const VISITANT = 'visitant';

    /** @var array $teams */
    private $teams;

    /** @var int */
    private $totalTeams;

    /** @var int */
    private $rounds;

    /** @var int */
    private $matchesPerRound;

    /** @var array */
    private $matchesPlayed = [];

    public function __construct(array $teams)
    {
        $this->teams = $teams;
        $this->totalTeams = count($this->teams);
        $this->rounds = $this->totalTeams;
        $this->matchesPerRound = floor($this->totalTeams / 2);
    }

    public function build(): array
    {
        if ($this->areTheyEvenTeams()) {
            $this->generateTournamentForEvenTeams();
        } else {
            $this->generateTournamentForOddTeams();
        }

        return $this->generateGoingAndComingMatches();
    }

    private function areTheyEvenTeams(): bool
    {
        return $this->totalTeams % 2 === 0;
    }

    private function generateTournamentForEvenTeams(): void
    {
        $this->rounds--;
        $this->fillLocalInAllMatchesEven();
        $this->fillFirstMatchEachRoundEven();
        $this->fillInRemainingRoundsEven();
    }

    private function generateTournamentForOddTeams(): void
    {
        $this->fillLocalInAllMatchesOdd();
        $this->fillInRemainingRoundsOdd();
    }

    private function fillLocalInAllMatchesOdd(): void
    {
        for ($round = 0, $teamNumber = 0; $round < $this->rounds; $round++) {
            for ($match = -1; $match < $this->matchesPerRound; $match++) {
                if ($match >= 0) {
                    $this->matchesPlayed[$round][$match][self::LOCAL] = $teamNumber;
                }

                $teamNumber++;

                if ($teamNumber === $this->totalTeams) {
                    $teamNumber = 0;
                }
            }
        }
    }

    private function fillInRemainingRoundsOdd(): void
    {
        $evenBiggestNumber = $this->rounds - 1;

        for ($round = 0, $teamNumber = $evenBiggestNumber; $round < $this->rounds; $round++) {
            for ($match = 0; $match < $this->matchesPerRound; $match++) {
                $this->matchesPlayed[$round][$match][self::VISITANT] = $teamNumber;

                $teamNumber--;

                if ($teamNumber === -1) {
                    $teamNumber = $evenBiggestNumber;
                }
            }
        }
    }

    private function fillLocalInAllMatchesEven(): void
    {
        for ($round = 0, $teamNumber = 0; $round < $this->rounds; $round++) {
            for ($match = 0; $match < $this->matchesPerRound; $match++) {
                $this->matchesPlayed[$round][$match][self::LOCAL] = $teamNumber;

                $teamNumber++;

                if ($teamNumber === $this->rounds) {
                    $teamNumber = 0;
                }
            }
        }
    }

    private function fillFirstMatchEachRoundEven(): void
    {
        for ($round = 0; $round < $this->rounds; $round++) {
            if ($round % 2 === 0) {
                $this->matchesPlayed[$round][0][self::VISITANT] = $this->totalTeams - 1;
            } else {
                $this->matchesPlayed[$round][0][self::VISITANT] = $this->matchesPlayed[$round][0][self::LOCAL];
                $this->matchesPlayed[$round][0][self::LOCAL] = $this->totalTeams - 1;
            }
        }
    }

    private function fillInRemainingRoundsEven(): void
    {
        // We use the biggest odd number because we have already
        //  use the biggest even number in the first round.
        $oddBiggestNumber = $this->rounds - 1;

        for ($round = 0, $teamNumber = $oddBiggestNumber; $round < $this->rounds; $round++) {
            for ($match = 1; $match < $this->matchesPerRound; $match++) {
                $this->matchesPlayed[$round][$match][self::VISITANT] = $teamNumber;

                $teamNumber--;

                if ($teamNumber === -1) {
                    $teamNumber = $oddBiggestNumber;
                }
            }
        }
    }

    /**
     * The going and coming matches are the same but they are inverted.
     */
    private function generateGoingAndComingMatches(): array
    {
        $matchGoing = [];
        $matchComing = [];

        for ($round = 0; $round < count($this->matchesPlayed); $round++) {
            for ($match = 0; $match < count($this->matchesPlayed[$round]); $match++) {

                $local = $this->matchesPlayed[$round][$match][self::LOCAL];
                $visitant = $this->matchesPlayed[$round][$match][self::VISITANT];

                $coming = [
                    'local' => $this->teams[$local],
                    'visitant' => $this->teams[$visitant],
                ];
                $going = [
                    'local' => $this->teams[$visitant],
                    'visitant' => $this->teams[$local],
                ];

                $matchComing[$round][$match] = $coming;
                $matchGoing[$round][$match] = $going;
            }
        }

        return array_merge($matchComing, $matchGoing);
    }

}
