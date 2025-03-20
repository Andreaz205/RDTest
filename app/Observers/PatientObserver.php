<?php

namespace App\Observers;

use App\Jobs\RevalidateJob;
use App\Models\Patient;

class PatientObserver
{
    public function __construct()
    {
    }

    public function created(Patient $patient)
    {
        RevalidateJob::dispatch();
    }

    public function updated(Patient $patient)
    {
        RevalidateJob::dispatch();
    }

    public function saved(Patient $patient)
    {
        RevalidateJob::dispatch();
    }

    public function deleted(Patient $patient)
    {
        RevalidateJob::dispatch();
    }
}
