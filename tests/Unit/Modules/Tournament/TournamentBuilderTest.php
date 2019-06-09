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
    private $team_one;

    /** @var Team */
    private $team_two;

    /** @var Team */
    private $team_three;

    /** @var Team */
    private $team_four;

    protected function setUp(): void
    {
        parent::setUp();
        $this->team_one = new Team(['id' => 1, 'name' => 'Team 1']);
        $this->team_two = new Team(['id' => 2, 'name' => 'Team 2']);
        $this->team_three = new Team(['id' => 3, 'name' => 'Team 3']);
        $this->team_four = new Team(['id' => 4, 'name' => 'Team 4']);
    }

    public function testTournamentTwoTeams()
    {
        $teams = [
            $this->team_one,
            $this->team_two,
        ];

        /** @var TournamentBuilder */
        $tournamentBuilder = TournamentBuilder::withTeams(...$teams);
        $result = $tournamentBuilder->build();

        $expected = [
            [
                [
                    TournamentBuilder::LOCAL => $this->team_one,
                    TournamentBuilder::VISITANT => $this->team_two,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_two,
                    TournamentBuilder::VISITANT => $this->team_one,
                ]
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testTournamentThreeTeams()
    {
        $teams = [
            $this->team_one,
            $this->team_two,
            $this->team_three,
        ];

        /** @var TournamentBuilder */
        $tournamentBuilder = TournamentBuilder::withTeams(...$teams);
        $result = $tournamentBuilder->build();

        $expected = [
            [
                [
                    TournamentBuilder::LOCAL => $this->team_two,
                    TournamentBuilder::VISITANT => $this->team_three,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_one,
                    TournamentBuilder::VISITANT => $this->team_two,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_three,
                    TournamentBuilder::VISITANT => $this->team_one,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_three,
                    TournamentBuilder::VISITANT => $this->team_two,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_two,
                    TournamentBuilder::VISITANT => $this->team_one,
                ]
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_one,
                    TournamentBuilder::VISITANT => $this->team_three,
                ]
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testTournamentFourTeams()
    {
        $teams = [
            $this->team_one,
            $this->team_two,
            $this->team_three,
            $this->team_four,
        ];

        /** @var TournamentBuilder */
        $tournamentBuilder = TournamentBuilder::withTeams(...$teams);
        $result = $tournamentBuilder->build();

        $expected = [
            [
                [
                    TournamentBuilder::LOCAL => $this->team_one,
                    TournamentBuilder::VISITANT => $this->team_four,
                ],
                [
                    TournamentBuilder::LOCAL => $this->team_two,
                    TournamentBuilder::VISITANT => $this->team_three,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_four,
                    TournamentBuilder::VISITANT => $this->team_three,
                ],
                [
                    TournamentBuilder::LOCAL => $this->team_one,
                    TournamentBuilder::VISITANT => $this->team_two,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_two,
                    TournamentBuilder::VISITANT => $this->team_four,
                ],
                [
                    TournamentBuilder::LOCAL => $this->team_three,
                    TournamentBuilder::VISITANT => $this->team_one,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_four,
                    TournamentBuilder::VISITANT => $this->team_one,
                ],
                [
                    TournamentBuilder::LOCAL => $this->team_three,
                    TournamentBuilder::VISITANT => $this->team_two,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_three,
                    TournamentBuilder::VISITANT => $this->team_four,
                ],
                [
                    TournamentBuilder::LOCAL => $this->team_two,
                    TournamentBuilder::VISITANT => $this->team_one,
                ],
            ],
            [
                [
                    TournamentBuilder::LOCAL => $this->team_four,
                    TournamentBuilder::VISITANT => $this->team_two,
                ],
                [
                    TournamentBuilder::LOCAL => $this->team_one,
                    TournamentBuilder::VISITANT => $this->team_three,
                ],
            ],
            
        ];

        $this->assertEquals($expected, $result);
    }

}
