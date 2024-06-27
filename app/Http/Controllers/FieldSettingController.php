<?php

namespace App\Http\Controllers;

use App\Repositories\FieldSettingRepositoryInterface;
use Illuminate\Http\Request;

class FieldSettingController extends Controller
{
    protected $fieldsetting;

    public function __construct(FieldSettingRepositoryInterface $fieldsetting) {
        $this->fieldsetting= $fieldsetting;
    }
}
