<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GamblingHistoryResource;
use App\Interfaces\GamblingInterface;
use App\Jobs\ProcessGamblingJob;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class GamblerController extends Controller
{
    public function __construct(private readonly GamblingInterface $service){}

    public function history(string $hash): AnonymousResourceCollection
    {
        $this->service->setAuthUserId(Auth::user()->id);
        return GamblingHistoryResource::collection($this->service->getCashedHistory(3));
    }

    public function gamble(string $hash): \Illuminate\Http\JsonResponse
    {
        ProcessGamblingJob::dispatch($this->service, Auth::user()->id);
        return response()->json(['your requst being processing']);
    }
}
