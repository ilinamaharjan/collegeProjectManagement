<?php

namespace App\Http\Controllers;

use App\Repositories\ActivityTypeRepositoryInterface;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{
    protected $activitytype;

    public function __construct(ActivityTypeRepositoryInterface $activitytype) {
        $this->activitytype= $activitytype;
    }
}
