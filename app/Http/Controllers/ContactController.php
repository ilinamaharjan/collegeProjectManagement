<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Models\CustomField;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Exports\ContactExcel;
use App\Imports\ContactImport;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\ContactRepositoryInterface;
use Excel;


class ContactController extends Controller
{
    protected $contact;

    public function __construct(ContactRepositoryInterface $contact) {
        $this->contact= $contact;
    }

    public function index(){
        $contacts = Contact::where('company_id' , auth()->user()->company_id)->get();
        return view('backend.contact.index',compact('contacts'));
    }

    public function uploadContactExcel(Request $request){
        $data = $request->all();
        $request->validate([
            'files' => 'required|mimes:xlsx,xls'
        ]);
        try {
            Excel::import(new ContactImport, $data['files']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        Alert::success('Success', 'Contact Imported Successfully');
        
        return redirect()->route('organization.index')->with('success', 'All good!');
    }
    public function downloadContactExcel(){
        return Excel::download(new ContactExcel, 'contact.xlsx');

    }

    public function update(Request $request){
        $data = $request->all();
        $response = $this->contact->update($data);
        if ($response['response'] == true) {
            Alert::toast($response['message'],'success');
            return back();
        } else {
            Alert::toast($response['message'],'error');
            return back();
        }
    }

    public function updateModal(Contact $contact){
        $emails = json_decode(DB::table('contact_email')->where('contact_id',$contact['id'])->pluck('email'),true);
        $phone_numbers = json_decode(DB::table('contact_phone')->where('contact_id',$contact['id'])->pluck('phone_number'),true);
        $custom_fields = CustomField::where('field_type_id',4)->where('company_id',auth()->user()->company_id)->get();
        $count = count($custom_fields);
        $additional_fields = json_decode($contact['additional_fields'],true);
        $helper_data = [];
        if ($count > 0) {
            foreach ($custom_fields as $key => $cf) {
                $exploded_field_name = explode(' ',$cf['field_name']);
                $html_name = Str::lower(implode('_',$exploded_field_name));
                if (array_key_exists($html_name,$additional_fields)) {
                    $type = $cf['type'];
                    switch ($type) {
                        case 'text':
                            $html_string = '<input type="text" class="form-control" name="'.$html_name.'" value="'.$additional_fields[$html_name].'">';
                            $helper_data[] = [
                                'label' => $cf['field_name'],
                                'html' => $html_string
                            ];
                            break;
                        case 'dropdown':
                            $dropdown_options = $cf->dropdownOptions()->pluck('option_value')->toArray();
                            $selected_options = $additional_fields[$html_name];
                            $option_string = '';
                            foreach ($dropdown_options as $key => $d_o) {
                                $selcted=in_array($d_o,$selected_options)?'selected':'';
                                $option_string.='<option value="'.$d_o.'" '.$selcted.'>'.$d_o.'</option>';
                            }
                            $html_string = '<select name="'.$html_name.'[]" class="form-control" id="" multiple>'.$option_string.'</select>';
                            $helper_data[] = [
                                'label' => $cf['field_name'],
                                'html' => $html_string
                            ];
                        default:
                            # code...
                            break;
                    }
                }else {
                    $helper_data[] = [
                        'label' => $cf['field_name'],
                        'html' => $cf['html_element']
                    ];
                }
            }
        }
        try {
            return response()->json([
                'page' => view('backend.components.updateContactModal',compact('emails','phone_numbers','contact','helper_data'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function disable(Contact $contact){
        try {
            $contact->update([
                'status' => 'Inactive'
            ]);
            Alert::toast('Contact Person Disabled','success');
            return back();
        } catch (\Throwable $th) {
            Alert::toast($th->getMessage(),'error');
            return back();
            
        }
    }

    public function create(){
        $contact_custom_fields = CustomField::where('field_type_id',4)->where('company_id',auth()->user()->company_id)->get();
        try {
            return response()->json([
                'page' => view('backend.components.createContact',compact('contact_custom_fields'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function showModal(Contact $contact){
        $contact_emails = DB::table('contact_email')->where('contact_id',$contact['id'])->pluck('email');
        $contact_phones = DB::table('contact_phone')->where('contact_id',$contact['id'])->pluck('phone_number');
        $decoded_emails = json_decode($contact_emails,true);
        $decoded_phones = json_decode($contact_phones,true);
        $additional_fields = json_decode($contact['additional_fields'],true);
        $helper_data = [];
        if (count($additional_fields) > 0) {
            foreach ($additional_fields as $key => $af) {
                $label_name = explode('_',$key);
                $l_name = ucfirst(implode(' ',$label_name));
                if (is_array($af)) {
                    $value = implode(',',$af);
                }else{
                    $value = $af;
                }
                $helper_data[] = [
                    'label' => $l_name,
                    'value' => $value
                ];
            }
        }
        try {
            return response()->json([
                'page' => view('backend.components.viewContactModal',compact('contact','decoded_emails','decoded_phones','helper_data'))->render(),
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
        $response = $this->contact->store($data);
        if ($response['response'] == true) {
            Alert::success('Success',$response['message']);
            return back();
        } else {
            Alert::error('Error',$response['message']);
            return back();
        }
    }
}
