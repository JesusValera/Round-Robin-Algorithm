<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Modules\Tournament\TournamentBuilder;
use App\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class TournamentBuilderTest extends TestCase
{
    /** @var Team */
    private $teamOne;

    /** @var Team */
    private $teamTwo;

    /** @var Team */
    private $teamThree;

    /** @var Team */
    private $teamFour;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teamOne = new Team(['id' => 1, 'name' => 'Team 1']);
        $this->teamTwo = new Team(['id' => 2, 'name' => 'Team 2']);
        $this->teamThree = new Team(['id' => 3, 'name' => 'Team 3']);
        $this->teamFour = new Team(['id' => 4, 'name' => 'Team 4']);
    }

    public function testTournamentTwoTeams()
    {
        $teams = [
            $this->teamOne,
            $this->teamTwo,
        ];

        $tournamentBuilder = TournamentBuilder::withTeams(...$teams);
        $result = $tournamentBuilder->build();

        $expected = [
            [
                [
                    TournamentBuilder::LOCAL => $this->teamOne,
                    TournamentBuilder::VISITANT => $this->teamTwo,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamTwo,
                    TournamentBuilder::VISITANT => $this->teamOne,
                ]
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testTournamentThreeTeams()
    {
        $teams = [
            $this->teamOne,
            $this->teamTwo,
            $this->teamThree,
        ];

        $tournamentBuilder = TournamentBuilder::withTeams(...$teams);
        $result = $tournamentBuilder->build();

        $expected = [
            [
                [
                    TournamentBuilder::LOCAL => $this->teamTwo,
                    TournamentBuilder::VISITANT => $this->teamThree,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamOne,
                    TournamentBuilder::VISITANT => $this->teamTwo,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamThree,
                    TournamentBuilder::VISITANT => $this->teamOne,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamThree,
                    TournamentBuilder::VISITANT => $this->teamTwo,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamTwo,
                    TournamentBuilder::VISITANT => $this->teamOne,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamOne,
                    TournamentBuilder::VISITANT => $this->teamThree,
                ]
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testTournamentFourTeams()
    {
        $teams = [
            $this->teamOne,
            $this->teamTwo,
            $this->teamThree,
            $this->teamFour,
        ];

        $tournamentBuilder = TournamentBuilder::withTeams(...$teams);
        $result = $tournamentBuilder->build();

        $expected = [
            [
                [
                    TournamentBuilder::LOCAL => $this->teamOne,
                    TournamentBuilder::VISITANT => $this->teamFour,
                ],
                [
                    TournamentBuilder::LOCAL => $this->teamTwo,
                    TournamentBuilder::VISITANT => $this->teamThree,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamFour,
                    TournamentBuilder::VISITANT => $this->teamThree,
                ],
                [
                    TournamentBuilder::LOCAL => $this->teamOne,
                    TournamentBuilder::VISITANT => $this->teamTwo,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamTwo,
                    TournamentBuilder::VISITANT => $this->teamFour,
                ],
                [
                    TournamentBuilder::LOCAL => $this->teamThree,
                    TournamentBuilder::VISITANT => $this->teamOne,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamFour,
                    TournamentBuilder::VISITANT => $this->teamOne,
                ],
                [
                    TournamentBuilder::LOCAL => $this->teamThree,
                    TournamentBuilder::VISITANT => $this->teamTwo,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamThree,
                    TournamentBuilder::VISITANT => $this->teamFour,
                ],
                [
                    TournamentBuilder::LOCAL => $this->teamTwo,
                    TournamentBuilder::VISITANT => $this->teamOne,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->teamFour,
                    TournamentBuilder::VISITANT => $this->teamTwo,
                ],
                [
                    TournamentBuilder::LOCAL => $this->teamOne,
                    TournamentBuilder::VISITANT => $this->teamThree,
                ],
            ],
            
        ];

        $this->assertEquals($expected, $result);
    }

}
