<?php

namespace App\Models;

use App\Enums\GamblingHistoryStatusEnum;
use Illuminate\Database\Eloquent\Model;

class GamblingHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'msg',
        'user_id',
        'status',
        'amount'
    ];

    protected $casts = [
        'status' => GamblingHistoryStatusEnum::class
    ];
}
