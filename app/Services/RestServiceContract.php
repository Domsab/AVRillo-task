<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

abstract class RestServiceContract{

    abstract public function getQuotes(int $numberOfQuotes = 5): array;

    abstract public function refreshQuotes(int $numberOfQuotes = 5): array;

    abstract protected function getQuote(): ?string;

    protected function saveQuotesToDb(array $quotes): self
    {
        $user = Auth::user();

        $user->quotes()->delete();

        $user->quotes()->createMany(
            array_map(fn($quote) => ['quote' => $quote], $quotes)
        );

        return $this;
    }
}
