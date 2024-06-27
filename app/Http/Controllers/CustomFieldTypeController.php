<?php

namespace App\Http\Controllers;

use App\Repositories\CustomFieldTypeRepositoryInterface;
use Illuminate\Http\Request;

class CustomFieldTypeController extends Controller
{
    protected $customfieldtype;

    public function __construct(CustomFieldTypeRepositoryInterface $customfieldtype) {
        $this->customfieldtype= $customfieldtype;
    }
}
