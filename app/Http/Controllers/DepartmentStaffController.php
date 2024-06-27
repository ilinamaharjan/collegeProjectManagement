<?php

namespace App\Http\Controllers;

use App\Repositories\DepartmentStaffRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentStaffController extends Controller
{
    protected $departmentstaff;

    public function __construct(DepartmentStaffRepositoryInterface $departmentstaff) {
        $this->departmentstaff= $departmentstaff;
    }
}
