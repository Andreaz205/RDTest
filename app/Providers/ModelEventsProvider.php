<?php

namespace App\Providers;

use App\Models\Patient;
use App\Observers\PatientObserver;
use Illuminate\Support\ServiceProvider;

class ModelEventsProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Patient::observe(PatientObserver::class);
    }
}
