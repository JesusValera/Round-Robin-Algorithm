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
        $this->rounds = $this->totalTeams - 1;
        $this->matchesPerRound = $this->totalTeams / 2;
    }

    public function build()
    {
        $this->fillLocalInAllMatches();
        $this->fillFirstMatchEachRound();
        $this->fillInRemainingRounds();

        return $this->generateGoingAndComingMatches();
    }

    private function fillLocalInAllMatches(): void
    {
        for ($i = 0, $k = 0; $i < $this->rounds; $i++) {
            for ($j = 0; $j < $this->matchesPerRound; $j++) {
                $this->matchesPlayed[$i][$j][self::LOCAL] = $k;

                if (++$k === $this->rounds) {
                    $k = 0;
                }
            }
        }
    }

    private function fillFirstMatchEachRound(): void
    {
        for ($i = 0; $i < $this->rounds; $i++) {
            if ($i % 2 === 0) {
                $this->matchesPlayed[$i][0][self::VISITANT] = $this->totalTeams - 1;
            } else {
                $this->matchesPlayed[$i][0][self::VISITANT] = $this->matchesPlayed[$i][0][self::LOCAL];
                $this->matchesPlayed[$i][0][self::LOCAL] = $this->totalTeams - 1;
            }
        }
    }

    private function fillInRemainingRounds(): void
    {
        // We use the biggest odd number because we have already
        //  use the biggest even number in the first round.
        $oddBiggestNumber = $this->rounds - 1;

        for ($i = 0, $k = $oddBiggestNumber; $i < $this->rounds; $i++) {
            for ($j = 1; $j < $this->matchesPerRound; $j++) {
                $this->matchesPlayed[$i][$j][self::VISITANT] = $k;

                if (--$k === -1) {
                    $k = $oddBiggestNumber;
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

        for ($i = 0; $i < count($this->matchesPlayed); $i++) {
            for ($j = 0; $j < count($this->matchesPlayed[$i]); $j++) {

                $local = $this->matchesPlayed[$i][$j][self::LOCAL];
                $visitant = $this->matchesPlayed[$i][$j][self::VISITANT];

                $coming = [
                    'local' => $this->teams[$local],
                    'visitant' => $this->teams[$visitant],
                ];
                $going = [
                    'local' => $this->teams[$visitant],
                    'visitant' => $this->teams[$local],
                ];

                $matchComing[$i][$j] = $coming;
                $matchGoing[$i][$j] = $going;
            }
        }

        return array_merge($matchComing, $matchGoing);
    }

}
