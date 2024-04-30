<?php

namespace App\Http\Controllers;

use App\QuotesManager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KanyeRestController extends Controller
{
    public function index(request $request): JsonResponse
    {
        $quotesManager = app()->make(QuotesManager::class);
        $quotes = $quotesManager->getQuotes();

        return response()->json(data: $quotes);
    }

    public function create(request $request): JsonResponse
    {
        $quotesManager = app()->make(QuotesManager::class);
        $quotes = $quotesManager->refreshQuotes();

        return response()->json(data: $quotes);
    }
}
