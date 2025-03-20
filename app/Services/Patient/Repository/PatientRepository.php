<?php

namespace App\Services\Patient\Repository;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PatientRepository
{
    public function __construct(private readonly Patient $model)
    {
    }

    public function create(
        string $firstName,
        string $lastName,
        Carbon $birthdate,
        int $age,
        string $ageType,
    ): Patient
    {
        return $this->model::query()->create([
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'birthdate'    => $birthdate,
            'age'          => $age,
            'age_type'     => $ageType,
        ]);
    }

    public function all(): Collection
    {
        return $this->model::query()->select(
            'first_name',
            'last_name',
            'birthdate',
            'age',
            'age_type'
        )->get();
    }
}
