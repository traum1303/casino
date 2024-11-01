<?php
declare(strict_types=1);

namespace App\Services;

use App\Enums\GamblingHistoryStatusEnum;
use App\Interfaces\GamblingInterface;
use App\Interfaces\RepositoryInterface;
use Illuminate\Support\Facades\Cache;

readonly class GamblingService implements GamblingInterface
{

    private string $msg;
    private int $authUserId;
    private int $amount;
    private GamblingHistoryStatusEnum $status;

    public function __construct(private RepositoryInterface $repository){}

    public function gamble():void
    {
        $randNumb = rand(0, 1000);
        $this->status = 0 === $randNumb || 1 === $randNumb % 2 ? GamblingHistoryStatusEnum::LOSE : GamblingHistoryStatusEnum::WIN;
        $status = GamblingHistoryStatusEnum::toText($this->status);
        $amount = $randNumb * 0.1;

        if($randNumb > 900) {
            $amount = $randNumb * 0.7;
        }elseif($randNumb > 600) {
            $amount = $randNumb * 0.5;
        }if($randNumb > 300) {
            $amount = $randNumb * 0.3;
        }
        $this->amount = (int) $amount*100;
        $this->msg = "You {$status} {$amount} virtual coins";
    }

    public function setAuthUserId(int $authUserId): void
    {
        $this->authUserId = $authUserId;
    }

    public function getGambledResult(): string
    {
        return $this->msg;
    }

    public function getGambledResultStatus(): GamblingHistoryStatusEnum
    {
        return $this->status;
    }

    public function saveToHistory(?string $msg = null)
    {
        $resultMsg = $msg ?? $this->msg ?? null;

        if ($resultMsg) {
           return $this->repository->create([
               'msg' => $resultMsg,
               'user_id' => $this->authUserId,
               'status' => $this->status,
               'amount' => $this->amount
           ]);
        }

        return null;
    }

    public function getCashedHistory(int $limit)
    {
        return Cache::remember("gambling_histories_user_{$this->authUserId}", 60, function () use ($limit) {
                return $this->getHistory($limit);
            });
    }

    public function updateHistoryCash(int $limit = 3): void
    {
        $data = $this->getHistory($limit);
        Cache::put("gambling_histories_user_{$this->authUserId}", $data, 60);
    }

    private function getHistory(int $limit)
    {
        return $this->repository
            ->where(['user_id'], [$this->authUserId], ['='])
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
