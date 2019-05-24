<?php

namespace App;

class DecoratorTeam extends Team
{
    /** @var int */
    private $matchesPlayed = 0;

    public function getMatchesPlayed(): int
    {
        return $this->matchesPlayed;
    }

    public function incrementMatchesPlayed(): self
    {
        $this->matchesPlayed++;

        return $this;
    }

}
