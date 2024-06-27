<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\CustomFieldType;
use App\Repositories\CustomFieldRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomFieldController extends Controller
{
    protected $customfield;

    public function __construct(CustomFieldRepositoryInterface $customfield) {
        $this->customfield= $customfield;
    }

    public function index($field_type){
        $type = CustomFieldType::where('type',$field_type)->first();
        $custom_fields = CustomField::where('company_id',auth()->user()->company_id)->where('field_type_id',$type->id)->get();
        return view('backend.custom_field.index',compact('custom_fields','type'));
    }

    public function create($type_id){
        try {
            return response()->json([
                'page' => view('backend.components.createCustomField',compact('type_id'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function store(Request $request){
        $data = $request->all();
        $response = $this->customfield->store($data);
        if ($response['response'] == true) {
            Alert::success('Success',$response['message']);
            return back();
        } else {
            Alert::error('Error',$response['message']);
            return back();
        }
        
    }
}
