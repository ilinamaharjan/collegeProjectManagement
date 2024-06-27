<?php

namespace App\Http\Controllers;

use App\Repositories\StatusSettingRepositoryInterface;
use Illuminate\Http\Request;

class StatusSettingController extends Controller
{
    protected $statussetting;

    public function __construct(StatusSettingRepositoryInterface $statussetting) {
        $this->statussetting= $statussetting;
    }
}
