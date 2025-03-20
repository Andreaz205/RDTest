<?php

namespace App\Jobs;

use App\Services\Patient\PatientService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RevalidateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly PatientService $service)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->service->cache()->revalidate();
    }
}
