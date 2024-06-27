<?php

namespace App\Http\Controllers;

use App\Repositories\LeadActivityRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LeadActivityController extends Controller
{
    protected $leadactivity;

    public function __construct(LeadActivityRepositoryInterface $leadactivity) {
        $this->leadactivity= $leadactivity;
    }

    public function store(Request $request){
        $response = $this->leadactivity->store($request->all());
        if ($response['response'] == true) {
            Alert::toast($response['message'],'success');
            return back();
        } else {
            Alert::error('Error',$response['message']);
            return back();
        }
    }
}
