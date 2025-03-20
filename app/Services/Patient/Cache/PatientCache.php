<?php

namespace App\Services\Patient\Cache;

use App\Models\Patient;
use App\Services\Patient\PatientService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PatientCache implements PatientCacheInterface
{
    public function __construct(private readonly PatientService $service)
    {
    }

    public const TAG = 'patients';
    public const LIST_KEY = 'list';
    public const LIST_TTL = 300;

    public function list(): array
    {
        return Cache::tags(self::TAG)->get(self::LIST_KEY);
    }

    public function revalidate(): array
    {
        $collection = $this->service->repository->all();

        $result = $collection->map(fn (Patient $patient) => [
            'name'      => $patient->first_name . " " . $patient->last_name,
            'birthdate' => $patient->birthdate->format('d.m.Y'),
            'age'       => $patient->age . " " . $patient->age_type
        ])->toArray();

        Cache::tags(self::TAG)->put(self::LIST_KEY, $result, self::LIST_TTL);

        return $result;
    }
}
