<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\CustomField;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OrganizationRepositoryInterface;


class OrganizationController extends Controller
{
    protected $organization;

    public function __construct(OrganizationRepositoryInterface $organization)
    {
        $this->organization = $organization;
    }

    public function showModal(Organization $organization)
    {
        try {
            return response()->json([
                'page' => view('backend.components.viewOrganizationModal')->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function updateModal(Contact $contact)
    {

        $emails = json_decode(DB::table('contact_email')->where('contact_id', $contact['id'])->pluck('email'), true);
        $phone_numbers = json_decode(DB::table('contact_phone')->where('contact_id', $contact['id'])->pluck('phone_number'), true);

        $org = null;
        $or_contact=[];
        if ($contact->organization_id != null) {
            $org['organization'] = Organization::where('id', $contact->organization_id)->first();
            $org['emails'] = json_decode(DB::table('organization_email')->where('organization_id', $contact->organization_id)->pluck('email'), true);
            $org['address'] = json_decode(DB::table('organization_address')->where('organization_id', $contact->organization_id)->pluck('address'), true);
            $org['contact_number'] = json_decode(DB::table('organization_number')->where('organization_id', $contact->organization_id)->pluck('contact_number'), true);
            $or_contact=Contact::where('organization_id', $org['organization']['id'])->where('is_primary',0)->get();
            if(count($or_contact)>0){
                
                foreach ($or_contact as $key => $con) {
                    $org_con['emails']=json_decode(DB::table('contact_email')->where('contact_id', $con['id'])->pluck('email'), true);
                    $org_con['phone_numbers']=json_decode(DB::table('contact_phone')->where('contact_id', $con['id'])->pluck('phone_number'), true);
                    $con['emails']= $org_con['emails'];
                    $con['numbers']= $org_con['phone_numbers'];
                }
             
            }
        }
        try {
            return response()->json([
                'page' => view('backend.components.updateOrganizationModal', compact('emails', 'phone_numbers', 'contact', 'org','or_contact'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }
    public function addContactOrganization(Contact $contact)
    {
        try {
            return response()->json([
                'page' => view('backend.components.addContactOrganization', compact('contact'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if(array_key_exists('organization_id',$data)){
            $validator = Validator::make($request->all(), [
                'organization.name' => 'required|unique:organizations,name,' .$data['organization_id'] . ',id,company_id,' . auth()->user()->company_id,
            ]);
            if ($validator->fails()) {
                Alert::error('Error', 'Organization name already taken');
                return back();
            }
        }
        $response = $this->organization->update($data);
        if ($response['response'] == true) {
            Alert::success('Success', ' Updated successfully');
            return back();
        } else {
            Alert::success('Success', $response['message']);
            return back();
        }
    }

    public function index()
    {
        // $contacts = Contact::with('organization')->where('company_id', auth()->user()->company_id)->where('is_primary',1)->where('creator_user',auth()->id())->get();

        // foreach ($contacts as $key => $contact) {
        //     $email = $this->organization->getFieldsContact('email', $contact['id']);
        //     $number = $this->organization->getFieldsContact('phone', $contact['id']);
        //     $contact['phone'] = $number;
        //     $contact['email'] = $email;
        //     $contact['contact'] = null;
        // }
        return view('backend.organization.index');
    }
    public function getAllContact()
    {
        try{

            $contacts = Contact::with('organization')->where('company_id', auth()->user()->company_id)->where('is_primary',1)->where('creator_user',auth()->id())->get();

            foreach ($contacts as $key => $contact) {
                $email = $this->organization->getFieldsContact('email', $contact['id']);
                $number = $this->organization->getFieldsContact('phone', $contact['id']);
                $contact['phone'] = $number;
                $contact['email'] = $email;
                $contact['contact'] = null;
            }
            return response()->json([
                'response'=>true,
                'view'=>view('backend.organization.components.ViewTableList',compact('contacts'))->render(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage()
            ]);
        }
       
    }
    public function indexAllView()
    {
       
        try{

            $contacts = Contact::with('organization')->where('company_id', auth()->user()->company_id)->where('is_primary',1)->get();

            foreach ($contacts as $key => $contact) {
                $email = $this->organization->getFieldsContact('email', $contact['id']);
                $number = $this->organization->getFieldsContact('phone', $contact['id']);
                $contact['phone'] = $number;
                $contact['email'] = $email;
                $contact['contact'] = null;
            }
            return response()->json([
                'response'=>true,
                'view'=>view('backend.organization.components.ViewTableList',compact('contacts'))->render(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function review($id)
    {
        $contact = Contact::with('organization')->findOrFail($id);
        $user=User::findOrFail($contact->creator_user);
        $contact_numbers = [];
        $contact_emails = [];
        $numbers = DB::table('contact_phone')->where('contact_id', $contact->id)->get();
        if(count($numbers)>0){
            foreach ($numbers as $key => $value) {
                array_push($contact_numbers, $value->phone_number);
            }
        }
        $emails = DB::table('contact_email')->where('contact_id', $contact->id)->get();
        if(count($emails)>0){
            foreach ($emails as $key => $value) {
                array_push($contact_emails, $value->email);
            }
        }
        $organization_numbers = [];
        $organization_emails = [];
        $organization_address = [];
        $og_contacts = [];
        $organization = null;
        $leads=[];
      
        if ($contact->organization_id != null) {
            $response=$this->reviewOrganizationData($contact->organization_id,$leads,  $organization_numbers, $organization_emails , $organization_address);
            $organization_numbers=$response['organization_numbers'];
            $organization_address=$response['organization_address'];
            $organization_emails=$response['organization_emails'];
            $og_contacts=$response['og_contacts'];
            $leads=$response['leads'];
            // $organization = Organization::where('id', $contact->organization_id)->first();

                // $og_contacts = Contact::where('organization_id', $organization->id)->get();
                // if(count($og_contacts)>0){
                //     foreach ($og_contacts as $key => $cont) {
                //         $org_con['emails']=json_decode(DB::table('contact_email')->where('contact_id', $cont['id'])->pluck('email'), true);
                //         $org_con['phone_numbers']=json_decode(DB::table('contact_phone')->where('contact_id', $cont['id'])->pluck('phone_number'), true);
                //         $cont['emails']= $org_con['emails'];
                //         $cont['numbers']= $org_con['phone_numbers'];
                //     }
                // }
                
                // $numbers = DB::table('organization_number')->where('organization_id', $contact->organization_id)->get();
                // foreach ($numbers as $key => $value) {

                //     array_push($organization_numbers, $value->contact_number);
                // }
                // $emails = DB::table('organization_email')->where('organization_id', $contact->organization_id)->get();
                // foreach ($emails as $key => $value) {

                //     array_push($organization_emails, $value->email);
                // }
                // $address = DB::table('organization_address')->where('organization_id', $contact->organization_id)->get();
                // foreach ($address as $key => $value) {

                //     array_push($organization_emails, $value->address);
                // }
                
                // $org_lead = Lead::where('organization_id', $organization->id)->get();
                // if(count($org_lead)>0){
                //    foreach ($org_lead as $key => $value) {
                //     array_push($leads,$value->id);
                //    }
                // } 
                // foreach($og_contacts as $con){
                //     $led=Lead::with('settings', 'organization')->where('contact_id', $con->id)->first();
                //     if($led){
                //         array_push($leads,$led->id);
                //     }
            // } 
        }
        $con_leads  = Lead::where('contact_id', $contact->id)->get();
        if(count($con_leads)>0){
            foreach ($con_leads as $key => $value) {
                array_push($leads,$value->id);
            }
        }
        $newLeads= array_unique($leads);
        $company = Company::findOrFail(auth()->user()->company_id);
        $org_details=null;
        if($contact->organization!=null && $contact->organization_id != null){
            $org_details['name'] = $contact->organization->name;
            $org_details['email'] = $this->organization->getFields('email', $contact->organization->id);
            $org_details['number'] = $this->organization->getFields('number',  $contact->organization->id);
            $org_details['image'] = $contact->organization->hasMedia('organization-logo') ? $contact->organization->getMedia('organization-logo')[0]->getFullUrl() : '';
        }
        $latestLeads=Lead::with('settings', 'organization', 'creator', 'activities')->whereIn('id',$newLeads)->get();
        return view('backend.organization.review', compact('contact', 'org_details','og_contacts', 'company', 'contact_numbers', 'contact_emails', 'organization', 'organization_numbers', 'organization_emails', 'organization_address', 'latestLeads','user'));
    }

    public function reviewOrganizationData($orgId, $leads,  $organization_numbers, $organization_emails , $organization_address){
        $organization = Organization::where('id',$orgId)->first();

        $og_contacts = Contact::where('organization_id', $organization->id)->get();

        if(count($og_contacts)>0){
            foreach ($og_contacts as $key => $cont) {
                $org_con['emails']=json_decode(DB::table('contact_email')->where('contact_id', $cont['id'])->pluck('email'), true);
                $org_con['phone_numbers']=json_decode(DB::table('contact_phone')->where('contact_id', $cont['id'])->pluck('phone_number'), true);
                $cont['emails']= $org_con['emails'];
                $cont['numbers']= $org_con['phone_numbers'];
            }
        }
        
        $numbers = DB::table('organization_number')->where('organization_id',$orgId)->get();
        foreach ($numbers as $key => $value) {

            array_push($organization_numbers, $value->contact_number);
        }
        $emails = DB::table('organization_email')->where('organization_id',$orgId)->get();
        foreach ($emails as $key => $value) {

            array_push($organization_emails, $value->email);
        }
        $address = DB::table('organization_address')->where('organization_id',$orgId)->get();
        foreach ($address as $key => $value) {

            array_push($organization_address, $value->address);
        }
        
        $org_lead = Lead::where('organization_id', $organization->id)->get();
        if(count($org_lead)>0){
           foreach ($org_lead as $key => $value) {
            array_push($leads,$value->id);
           }
        } 
        foreach($og_contacts as $con){
            $led=Lead::with('settings', 'organization')->where('contact_id', $con->id)->first();
            if($led){
                array_push($leads,$led->id);
            }
        } 
        
        return [
            'og_contacts'=>$og_contacts,
            'organization_numbers'=>$organization_numbers,
            'organization_emails'=>$organization_emails,
            'organization_address'=>$organization_address,
            'leads'=>$leads,
        ] ;

    }

    public function checkbothdata()
    {
        return view('backend.components.customizedform');
    }

    public function create()
    {
        $organization_custom_fields = CustomField::where('field_type_id', 1)->where('company_id', auth()->user()->company_id)->get();
        try {
            return response()->json([
                'page' => view('backend.components.createOrganization', compact('organization_custom_fields'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate(
            [
                'contact.name' => 'required',
                'contact.email.*' => 'required|email',
                'contact.phone_number.*' => 'required',
            ],
            [
                'contact.email.*.required' => 'Contact email field is required',
                'contact.phone_number.*.required' => 'Contact address field is required',
            ]
        );
        $organizationName = $data['organization']['name'];
        $contactName = $data['contact']['name'];
        
       $res= $this->storeValidation( $organizationName,$contactName,$request);
        if($res['status']==false){
            Alert::error('Error',$res['message']);
            return back();
        }
        $response = $this->organization->store($data);
        if ($response['response'] == true) {
            Alert::success('Success', $response['message']);
            return back();
        } else {
            Alert::error('Error', $response['message']);
            return back();
        }
    }
  

    public function contactStore(Request $request)
    {
        $data = $request->all();
        try {
            $organization = Organization::findOrFail($data['organization_id']);
            if ($organization) {
                $this->storeContactPerson($data['contact'], $organization);
            }
            Alert::success('Success', 'Contact Added Successfully');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return back();
        }
    }
    public function organizationContactStore(Request $request)
    {
        $data = $request->all();
        try {
            $org=Organization::where('name', $data['organization']['name'])->where('company_id',auth()->user()->company_id)->first();
            if ($org) {
                Alert::error('Error', 'Organization name already taken');
                return back();
               
            }
            $contact = Contact::findOrFail($data['contact_id']);
            $this->storeOrganizationContact($data['organization'], $contact,$data['contact']);
            Alert::success('Success', 'Organization Added Successfully');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return back();
        }
    }
    public function storeContactPerson($contact, $org)
    {
        $contact_data = [
            'name' => $contact['name'],
            'organization_id' => $org['id'],
            'email' => $contact['email'],
            'company_id' => auth()->user()->company_id,
            'additional_fields' => null,
            'creator_user' => auth()->id(),
            'deal_type' => $org['deal_type'],
        ];
        $contact_person = Contact::create($contact_data);

        if (array_key_exists('person_img', $contact)) {
            $contact_person->addMedia($contact['person_img'])->toMediaCollection('contact_media');
        }

        if (array_key_exists('email', $contact)) {
            foreach ($contact['email'] as $key => $email) {
                DB::table('contact_email')->insert([
                    'contact_id' => $contact_person->id,
                    'email' => $email
                ]);
            }
        }
        if (array_key_exists('phone_number', $contact)) {
            foreach ($contact['phone_number'] as $key => $ph) {
                DB::table('contact_phone')->insert([
                    'contact_id' => $contact_person->id,
                    'phone_number' => $ph
                ]);
            }
        }
    }

    public function storeOrganizationContact($organization, $contact,$data)
    {
       
        DB::transaction(function () use ($organization, $contact,$data) {
            $organization_data['name'] = $organization['name'];
            $organization_data['company_id'] = auth()->user()->company_id;
            $organization_data['creator_user'] = auth()->id();
            $organization_data['address'] = $organization['address'];
            $organization_data['deal_type'] = $contact['deal_type'];

            $organization_data['email'] = $organization['email'];

            $organization_data['number'] = $organization['number'];

            $created_organization = Organization::create($organization_data);
            if (array_key_exists('email', $organization_data)) {
                foreach ($organization_data['email'] as $key => $org_email) {
                    DB::table('organization_email')->insert([
                        'organization_id' => $created_organization['id'],
                        'email' => $org_email
                    ]);
                }
            }
            if (array_key_exists('address', $organization)) {
                foreach ($organization['address'] as $key => $org_address) {
                    DB::table('organization_address')->insert([
                        'organization_id' => $created_organization['id'],
                        'address' => $org_address
                    ]);
                }
            }
            if (array_key_exists('number', $organization_data)) {
                foreach ($organization_data['number'] as $key => $org_number) {
                    DB::table('organization_number')->insert([
                        'organization_id' => $created_organization['id'],
                        'contact_number' => $org_number
                    ]);
                }
            }
            if (array_key_exists('logo', $organization)) {
                $created_organization->addMedia($organization['logo'])->toMediaCollection('organization-logo');
            }
            $contact->organization_id = $created_organization['id'];
            $contact->save();
            if(count($data)>0 &&$data['name']!=null){

                $this->storeContactPerson($data, $created_organization);
            }
        });
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        try {
            if ($contact ) {
                if ($contact->organization_id != null  && $contact->is_primary=="1" ) {
                    $org = Organization::where('id', $contact->organization_id)->first();
                    if ($org) {
                        DB::table('organization_number')->where('organization_id', $contact->organization_id)->delete();
                        DB::table('organization_email')->where('organization_id', $contact->organization_id)->delete();
                        DB::table('organization_address')->where('organization_id', $contact->organization_id)->delete();
                        $or_contacts = Contact::where("organization_id", $org->id)->where('is_primary', 0)->get();
                        if (count($or_contacts) > 0) {
                            foreach ($or_contacts as $key => $c) {
                                DB::table('contact_email')->where('contact_id', $c->id)->delete();
                                DB::table('contact_phone')->where('contact_id', $c->id)->delete();
                                $c->delete();
                            }
                        }
                    }
                }
                DB::table('contact_email')->where('contact_id', $contact->id)->delete();
                DB::table('contact_phone')->where('contact_id', $contact->id)->delete();

                $leads=Lead::where('contact_id',$contact->id)->get();
                foreach ($leads as $key => $lead) {
                   $lead->contact_id=null;
                   $lead->save();
                }
                $org = Organization::where('id', $contact->organization_id)->first();
                $contact->delete();
                if( $contact->is_primary=="1" && $org){
                    $org->delete();
                }
            }

            // Alert::success('Success', 'Contact Deleted Successfully');
            // return back();
            return response()->json([
                'response'=>true,
                'message'=>'Contact Book Deleted Successfully',
            ]);
        } catch (\Throwable $th) {
            // Alert::error('Error', $th->getMessage());
            // return back();
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
    }
      public function secondaryContactDelete(Request $request)
    {
      $data=$request->all();
      try{
        $contact = Contact::findOrFail($data['id']);
        if ($contact ) {
            DB::table('contact_email')->where('contact_id', $contact->id)->delete();
            DB::table('contact_phone')->where('contact_id', $contact->id)->delete();
            $leads=Lead::where('contact_id',$contact->id)->get();
            foreach ($leads as $key => $lead) {
                $lead->contact_id=null;
                $lead->save();
            }
            $contact->delete();
        }
        return response()->json([
            'status'=>true,
            'message'=>'Contact Deleted Successfully',
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
    }
    public function storeValidation($organizationName,$contactName,$request){
        $data=$request->all();
        if (empty($organizationName) && empty($contactName)) {
            return [
                'status'=>false,
                'message'=>'Organization Or Contact fields are required!'
            ];
        }
        $org=Organization::where('name',$data['organization']['name'])->where('company_id',auth()->user()->company_id)->first();
        if ($org) {
            return [
                'status'=>false,
                'message'=>' Organization name already taken'
            ];
        }
        return [
            'status'=>true,
        ];
        // if (!empty($organizationName)) {
        //     $request->validate(
        //         [
        //             'organization.email.*' => 'required|email',
        //             'organization.address.*' => 'required',
        //             'organization.number.*' => 'required',
        //         ],
        //         [
        //             'organization.email.*.required' => 'Organization email field is required',
        //             'organization.address.*.required' => 'Organization address field is required',
        //             'organization.number.*.required' => 'Organization number field is required',
        //         ]
        //     );
        // }
       
    }
}
