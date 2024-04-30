<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\RestServiceContract;

class KanyeRestService extends RestServiceContract {
    const KANYE_REST_ENDPOINT = "https://api.kanye.rest/text";

    public function getQuotes(int $numberOfQuotes = 5): array
    {
        $uniqueQuotes = [];
        $user = Auth::user();
        return $user->quotes()->pluck('quote')->toArray();
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
        $response = Http::get(self::KANYE_REST_ENDPOINT);

        $response->throw();

        if($response->successful()){
            return $response->body();
        }

        return null;
    }

}
