<?php

namespace App\Http\Controllers;

use App\Repositories\StatusHistoryRepositoryInterface;
use Illuminate\Http\Request;

class StatusHistoryController extends Controller
{
    protected $statushistory;

    public function __construct(StatusHistoryRepositoryInterface $statushistory) {
        $this->statushistory= $statushistory;
    }
}
