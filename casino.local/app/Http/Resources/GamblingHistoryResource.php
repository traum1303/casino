<?php

namespace App\Http\Resources;

use App\Enums\GamblingHistoryStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property GamblingHistoryStatusEnum $status
 * @property string $msg
 * @property Carbon $created_at
 * @property int $amount
 */
class GamblingHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'msg' => $this->msg,
            'amount' => $this->amount/100,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'status' => $this->status->name
        ];
    }
}
