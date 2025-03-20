<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePatientRequest;
use App\Http\Resources\PatientResource;
use App\Services\Patient\PatientService;

class PatientController extends Controller
{
    public function __construct(private readonly PatientService $service)
    {
    }

    public function store(StorePatientRequest $request)
    {
        if (!$this->service->store(
            $request->validated('first_name'),
            $request->validated('last_name'),
            $request->validated('birthdate'),
        )) {
            // Здесь мы должны привести все форматы к одному стилю через какие то классы
            // Я сделал просто для экномии времени
            return response()->json([
                'message' => 'Непредвиденная ошибка!'
            ], 500);
        }

        // Здесь мы должны привести все форматы к одному стилю через какие то классы
        // Я сделал просто для экномии времени
        return response()->json([
            'message' => 'Ok'
        ]);
    }

    public function download()
    {
        return PatientResource::collection($this->service->list());
    }
}
