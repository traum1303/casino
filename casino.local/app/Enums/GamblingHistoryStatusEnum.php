<?php

namespace App\Enums;

enum GamblingHistoryStatusEnum: int
{
    case LOSE = 0;
    case WIN = 1;

    public static function toText(GamblingHistoryStatusEnum $status)
    {
        return match ($status){
            self::LOSE => 'lose',
            self::WIN => 'won'
        };
    }
}
