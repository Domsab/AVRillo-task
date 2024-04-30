<?php

namespace App;

use Illuminate\Support\Manager;
use App\Services\MockRestService;
use App\Services\KanyeRestService;

class QuotesManager extends Manager {

    protected function createKanyeRestDriver()
    {
        return $this->container->make(KanyeRestService::class);
    }

    protected function createMockRestDriver()
    {
        return $this->container->make(MockRestService::class);
    }

    public function getDefaultDriver(): string
    {
        return 'kanye-rest';
    }
}
