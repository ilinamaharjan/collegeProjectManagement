<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\LeadFileType;
use App\Models\LeadSetting;
use App\Models\Note;
use App\Models\Organization;
use App\Models\StatusHistory;
use App\Models\StatusSetting;
use App\Repositories\LeadRepositoryInterface;
use App\Repositories\OrganizationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LeadController extends Controller
{
    protected $lead;

    public function __construct(LeadRepositoryInterface $lead) {
        $this->lead= $lead;
    }

    public function convert(Lead $lead){
        try {
            DB::transaction(function () use($lead){
                $lead_setting = LeadSetting::where('id',$lead['status_id'])->first();
                $closing_lead_status = LeadSetting::where('notifier','Last')->where('status_setting_id',$lead_setting['status_setting_id'])->first();
                $lead->update([
                    'status_id' => $closing_lead_status['id'],
                    'is_converted' => 1
                ]);        
        
                if (isset($lead['organization_id'])) {
                    Organization::where('id',$lead['organization_id'])->update([
                        'deal_type' => 'Customer'
                    ]);
                }
        
                if (isset($lead['contact_id'])) {
                    Contact::where('id',$lead['contact_id'])->update([
                        'deal_type' => 'Customer'
                    ]);
                } 
            });
            return response()->json([
                'response' => true,
                'message' => 'Converted Successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }

    }

    public function store(Request $request){
        $data = $request->all();
        $response = $this->lead->store($request->all());
        
        if ($response['response'] == true) {
            $lead_setting = LeadSetting::where('id',$data['lead']['status_id'])->first();
            $category_id = StatusSetting::where('id',$lead_setting['status_setting_id'])->first();
            return response()->json([
                'response' => true,
                'message' => 'Successfully Added',
                'category_id' => $category_id['id']
            ]);
        } else {
            return response()->json([
                'response' => false,
                'message' => $response['message'],
                
            
            ]);
        }
    }


    public function index(){
       
        return view('backend.lead.index');
    }

    public function leadprofile($id){
        $organizationRepo = new OrganizationRepository();
        $lead = Lead::with('settings','organization','creator','activities')->findOrFail($id);
        $lead_setting = $lead['settings'];
        $organization_email = $lead['organization'] != null ? $organizationRepo->getFields('email',$lead['organization']['id']) : '';
        $organization_num =  $lead['organization'] != null ? $organizationRepo->getFields('number',$lead['organization']['id']) : '';
        $lead['email'] = $organization_email;
        $lead['num'] = $organization_num;
        $activities = $lead['activities']->toArray();
        $file_types = LeadFileType::where('company_id',auth()->user()->company_id)->get();
        $activity_types = ActivityType::all();
        $notes = Note::where('lead_id',$id)->get();
        //Status History 

        $status_histories = StatusHistory::where('lead_id',$id)->with('from','to')->get();

        return view('backend.lead.leadprofile',compact('lead','lead_setting','activities','file_types','status_histories','activity_types','notes'));
    }

    
}



