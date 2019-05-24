<?php

namespace App\Modules\Tournament;

use App\DecoratorTeam;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class TournamentBuilderTest extends TestCase
{
    /** @var TournamentBuilder */
    private $tournamentBuilder;

    /** @var Collection */
    private $eightTeams;

    protected function setUp()
    {
        parent::setUp();

        $this->eightTeams = new Collection([
            new DecoratorTeam(), new DecoratorTeam(), new DecoratorTeam(), new DecoratorTeam(),
            new DecoratorTeam(), new DecoratorTeam(), new DecoratorTeam(), new DecoratorTeam()
        ]);

        $this->tournamentBuilder = new TournamentBuilder($this->eightTeams);
    }

    public function testGetTotalGames()
    {
        $totalGames = $this->tournamentBuilder->getTotalGames($this->eightTeams->count());
        $this->assertEquals(56, $totalGames);

        $totalGames = $this->tournamentBuilder->getTotalGames($this->eightTeams->count() / 2);
        $this->assertEquals(12, $totalGames);
    }

    public function testGetNumberRounds()
    {
        $totalTeams = $this->eightTeams->count();
        $totalGames = $this->tournamentBuilder->getTotalGames($totalTeams);
        $numberRounds = $this->tournamentBuilder->getNumberRounds($totalGames, $totalTeams);
        $this->assertEquals(14, $numberRounds);

        $totalTeams = $this->eightTeams->count() / 2;
        $totalGames = $this->tournamentBuilder->getTotalGames($totalTeams);
        $numberRounds = $this->tournamentBuilder->getNumberRounds($totalGames, $totalTeams);
        $this->assertEquals(6, $numberRounds);

        $totalTeams = $this->eightTeams->count() * 2;
        $totalGames = $this->tournamentBuilder->getTotalGames($totalTeams);
        $numberRounds = $this->tournamentBuilder->getNumberRounds($totalGames, $totalTeams);
        $this->assertEquals(30, $numberRounds);
    }

}
