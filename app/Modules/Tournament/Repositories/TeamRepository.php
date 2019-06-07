<?php declare(strict_types=1);

namespace App\Modules\Tournament\Repositories;

use App\Team;

interface TeamRepository
{
    public function getAll(): array;

    public function getAllWith(string $with): array;

    public function getById(int $id): Team;

    public function create(array $attributes): Team;

    public function update(int $id, array $attributes): Team;

    public function delete(int $id): bool;
}
