<?php

namespace App\Http\Controllers;

use App\Models\LeadFileType;
use App\Repositories\LeadFileTypeRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LeadFileTypeController extends Controller
{
    protected $leadfiletype;

    public function __construct(LeadFileTypeRepositoryInterface $leadfiletype)
    {
        $this->leadfiletype = $leadfiletype;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        // 'has_multiple' => 'required'


        $result = $this->leadfiletype->store($request->all());
        if ($result) {
            Alert::success('Success', 'Stored successfully');
            return redirect()->back();
        } else {
            Alert::error('Error', $request['message']);
            return redirect()->back();
        }
    }
    public function index()
    {

        // try {
        //     return response()->json([
        //         'page' => view('backend.components.filetypeIndex')->render(),
        //         'response' => true
        //     ]);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'message' => $th->getMessage(),
        //         'response' => false
        //     ]);
        // }
        $filetypes = LeadFileType::all();
        return view('backend.leadfiletype.index', compact('filetypes'));
    }
}
