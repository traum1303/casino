<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\GamblingHistory;

class GamblingHistoryRepository extends Repository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        parent::__construct(new GamblingHistory());
    }
}
