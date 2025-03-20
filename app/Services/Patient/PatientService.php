<?php

namespace App\Services\Patient;

use App\Jobs\SomeJob;
use App\Services\Patient\Cache\PatientCache;
use App\Services\Patient\Repository\PatientRepository;
use Carbon\Carbon;

class PatientService
{
    public function __construct(
        public readonly PatientRepository $repository,
        private readonly PatientCache $cache,
    ){}

    public function cache()
    {
        return $this->cache;
    }

    public function store(
        string $firstName,
        string $lastName,
        Carbon $birthdate,
    )
    {
        $ageType = 'день';

        $days = now()->diffInDays($birthdate);
        $age = $days;

        $monthDays = 30;

        if ($days > $monthDays) {
            $ageType = 'месяц';
            $age = floor($days / $monthDays);
        }

        $yearsMonths = 12;

        if ($days > $yearsMonths) {
            $ageType = 'год';
            $age = floor($days / ($monthDays * $yearsMonths));
        }

        // Можно сделать какой нибудь вызов здесь $this->>cache->revalidate($patient)

        $patient = $this->repository->create(
            $firstName,
            $lastName,
            $birthdate,
            $age,
            $ageType
        );

        // Можно сделать какой нибудь вызов здесь $this->>cache->revalidate($patient)
        // 1) в случае ревалидации через конкатенацию массивов в оперативной памяти нам может не хватить оперативки и отсутствует должная сортировка
        // 2) можно делать ревалидацию здесь через запрос записей всех из базы данных если синхронно то будет очень долго и поэтому в любом случае нужно отправлять в очередь то есть делать асинхронно
        // я сделал это изяшно через паттерн Observer
        // 3) Мы вообще можем собирать кеш по cron job через каждую минуту например

        // Я не совсем понял в какую джобу и зачем отправлять пациента поэтому назвал ее по своему
        // и соответственно необходио выставить CACHE_STORE=redis,memcache по требованию чтобы пользоваться соответсвующим кеш провайдером
        // и соответственно что бы менеджером очередей был кеш нужно также выставить в env QUEUE_CONNECTION=redis,memcache
        SomeJob::dispatch($patient);

        return $patient;
    }

    public function list()
    {
        return $this->cache->list();
    }
}
