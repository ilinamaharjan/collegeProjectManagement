<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartJsController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function indexChartJs()
    {
        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count', 'month_name');
 
        $labels = $users->keys();
        $data = $users->values();
              
        return view('chart', compact('labels', 'data'));
    }
}