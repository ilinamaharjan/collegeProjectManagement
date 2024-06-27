<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Repositories\DepartmentRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $department;

    public function __construct(DepartmentRepositoryInterface $department) {
        $this->department= $department;
    }

    public function viewdepartments(){
        $department = Department::with('company')->get();
        foreach ($department as $dept){
            $dept->staffNumber = rand(1, 100);
        }
        return view('backend.department.viewDepartment',compact('department'));
    }
}
