<?php declare(strict_types=1);

namespace App\Modules\Tournament\Repositories;

use App\Team;

final class EloquentTeam implements TeamRepository
{
    /** @var Team */
    private $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function getAll(): array
    {
        return $this->team->all()->all();
    }

    public function getAllWith(string $with): array
    {
        return $this->team->with($with)->get()->all();
    }

    public function getById(int $id): Team
    {
        return $this->team->findOrFail($id);
    }

    public function create(array $attributes): Team
    {
        return $this->team->create($attributes);
    }

    public function update(int $id, array $attributes): Team
    {
        return $this->getById($id)->update($attributes);
    }

    public function delete(int $id): bool
    {
        return $this->getById($id)->delete();
    }
}