<?php

namespace App\Jobs;

use App\Events\GamblingProcessedEvent;
use App\Interfaces\GamblingInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGamblingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId;
    /**
     * Create a new job instance.
     */
    public function __construct(private readonly GamblingInterface $gamblingService, int $id)
    {
        $this->userId = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->gamblingService->setAuthUserId($this->userId);
        $this->gamblingService->gamble();
        GamblingProcessedEvent::dispatch($this->gamblingService->getGambledResult());
        $this->gamblingService->saveToHistory();
        $this->gamblingService->updateHistoryCash();
    }
}
