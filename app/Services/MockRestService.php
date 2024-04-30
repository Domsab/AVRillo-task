<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\RestServiceContract;

class MockRestService extends RestServiceContract{

    public function getQuotes(int $numberOfQuotes = 5): array
    {
        $uniqueQuotes = [];

        $uniqueQuotes = Auth::user()->quotes()->get();

        return $uniqueQuotes->pluck('quotes')->toArray();
    }

    public function refreshQuotes(int $numberOfQuotes = 5): array
    {
        $uniqueQuotes = [];

        while (count($uniqueQuotes) < $numberOfQuotes) {
            $uniqueQuotes[] = $this->getQuote();
            $uniqueQuotes = array_unique($uniqueQuotes);
        }

        $this->saveQuotesToDb($uniqueQuotes);

        return $uniqueQuotes;
    }

    protected function getQuote(): ?string
    {
        $response = Http::get($this->getEndpoint());

        $response->throw();

        if($response->successful()){
            return $response->body();
        }

        return null;
    }
}
