<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Lead;
use App\Models\News;
use App\Models\User;
use App\Models\Module;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Package;
use App\Models\Customer;
use App\Models\LeadSetting;
use App\Models\SocialMedia;
use Illuminate\Support\Arr;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\StatusHistory;
use App\Models\StatusSetting;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function package()
    {
        $companies = Company::where('parent_id', auth()->user()->company_id)->get();
        $modules = Module::where('parent_module_id', null)->get();
        $packages = Package::all();
        return view('backend.package.viewpackage', compact('modules', 'companies', 'packages'));
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        try {
            User::where('id', auth()->id())->update([
                'password' => bcrypt($data['new_pwd'])
            ]);
            Alert::success('Success', 'Password Changed');
            Auth::logout();
            return redirect()->route('login');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function verifyPassword(Request $request)
    {
        $data = $request->all();
        $auth_user = auth()->user();
        try {
            if (Hash::check($data['pwd'], $auth_user['password'])) {
                return response()->json([
                    'response' => true,
                ]);
            } else {
                return response()->json([
                    'response' => false,
                    'message' => 'Password did not match'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        $companies = Company::all();
        $user = User::all();
        $projects = 0;
        $tasks = 0;
        $completedTask = 50;
        $remainingTask = 50;
        $data = [
            'noOfCompany' => count($companies),
            'noOfUsers' => count($user) - 1,
            'noOfProject' => $projects,
            'noOfTasks' => $tasks,
            'completedPercentage' => $completedTask,
            'remainingPercentage' => $remainingTask
        ];
        return view('home')->with('data', $data);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        try {
            $user = auth()->user();
            return view('backend.profile.index', compact('user'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        return view('backend.profile.index');
    }

    public function company()
    {
        $auth_user = auth()->user();
        $company = Company::where('id', $auth_user['company_id'])->first();
        $packages = Package::all();
        return view('backend.company.index', compact('company', 'packages'));
    }

    public function lead()
    {
        $categories = StatusSetting::where('company_id', auth()->user()->company_id)->where('module', 'lead')->get();
        $organizations = Organization::where('company_id', auth()->user()->company_id)->get();
        $contacts = Contact::where('company_id', auth()->user()->company_id)->get();
        return view('backend.lead.index', compact('categories', 'organizations', 'contacts'));
    }

    public function projectManager()
    {
        $users = User::where('company_id', auth()->user()->company_id)->get();
        $categories = StatusSetting::where('company_id', auth()->user()->company_id)->where('module', 'pm')->get();
        return view('backend.project_manager.index', compact('categories', 'users'));
    }

    public function customer()
    {

        $deals = Lead::where('is_converted', 1)->where('creator_user', auth()->id())->get();
        $customerArr = [];
        foreach ($deals as $key => $deal) {
            $contact_person = Contact::where('id', $deal['contact_id'])->with('organization', 'deals')->first();
            $contact_person['organization_data'] = $contact_person['organization'] == null ? null : $contact_person['organization']->toArray();
            $contact_person['deal_data'] = $contact_person['deals'] == null ? null : $contact_person['deals']->toArray();
            array_push($customerArr, $contact_person);
        }
        $leads = array_unique($customerArr);
        return view('backend.customer.index', compact('leads'));

    }

    public function customerAll()
    {
        $deals = Lead::where('is_converted', 1)->where('company_id', auth()->user()->company_id)->get();
        $customerArr = [];
        foreach ($deals as $key => $deal) {
            $contact_person = Contact::where('id', $deal['contact_id'])->with('organization', 'deals')->first();
            $contact_person['organization_data'] = $contact_person['organization'] == null ? null : $contact_person['organization']->toArray();
            $contact_person['deal_data'] = $contact_person['deals'] == null ? null : $contact_person['deals']->toArray();
            array_push($customerArr, $contact_person);
        }
        $leads = array_unique($customerArr);
        return view('backend.customer.index', compact('leads'));
    }

    public function customerDetails($id)
    {
        $company = Company::findOrFail(auth()->user()->company_id);
        $contact = Contact::with('deals')->findOrFail($id);
        $organization = Organization::where('id', $contact->organization_id)->first();
        if ($organization != null) {
            $allleads = Lead::with('settings', 'organization', 'creator', 'activities')->where('organization_id', $organization->id)->get();
        } else {
            $allleads = Lead::with('settings', 'organization', 'creator', 'activities')->where('contact_id', $id)->get();
        }

        $data = $this->getDataForLead($contact, $organization);
        return view('backend.customer.details', compact('data', 'company', 'allleads', 'contact', 'organization'));
    }

    private function getDataForLead($contact, $organization)
    {
        $data = [
            'contact_numbers' => [],
            'contact_emails' => [],
            'og_contacts' => [],
            'organization_numbers' => [],
            'organization_emails' => [],
            'organization_address' => [],
            'organization' => [],
            'primary_contact' => []
        ];
        if ($organization != null) {
            $data['organization'] = Organization::where('id', $organization->id)->first();
            $data['og_contacts'] = Contact::where('organization_id', $data['organization']['id'])->get();
            if (count($data['og_contacts']) > 0) {
                foreach ($data['og_contacts'] as $key => $contact) {
                    if ($contact->is_primary == 1) {
                        $data['contact'] = $contact;
                    }
                    $data['org_contact_numbers'] = [];
                    $data['org_contact_emails'] = [];
                    $numbers = DB::table('contact_phone')->where('contact_id', $contact->id)->get();
                    foreach ($numbers as $key => $value) {
                        array_push($data['org_contact_numbers'], $value->phone_number);
                    }
                    $emails = DB::table('contact_email')->where('contact_id', $contact->id)->get();
                    foreach ($emails as $key => $value) {
                        array_push($data['org_contact_emails'], $value->email);
                    }
                    $contact->phones = $data['org_contact_numbers'];
                    $contact->emails = $data['org_contact_emails'];
                }
            } else {
                $data['contact'] = null;
            }
            $numbers = DB::table('organization_number')->where('organization_id', $organization->id)->get();
            foreach ($numbers as $key => $value) {
                array_push($data['organization_numbers'], $value->contact_number);
            }
            $emails = DB::table('organization_email')->where('organization_id', $organization->id)->get();
            foreach ($emails as $key => $value) {
                array_push($data['organization_emails'], $value->email);
            }
            $address = DB::table('organization_address')->where('organization_id', $organization->id)->get();
            foreach ($address as $key => $value) {
                array_push($data['organization_address'], $value->address);
            }
            $data['owner'] = User::findOrFail($data['organization']->creator_user);
        } elseif ($contact) {
            $data['contact'] = Contact::with('organization')->findOrFail($contact->id);
            $numbers = DB::table('contact_phone')->where('contact_id', $data['contact']['id'])->get();
            foreach ($numbers as $key => $value) {
                array_push($data['contact_numbers'], $value->phone_number);

            }
            $data['contact']->phones = $data['contact_numbers'];
            $emails = DB::table('contact_email')->where('contact_id', $data['contact']['id'])->get();
            foreach ($emails as $key => $value) {
                array_push($data['contact_emails'], $value->email);
            }
            $data['contact']->emails = $data['contact_emails'];
            $data['organization'] = Organization::where('id', $data['contact']['organization_id'])->first();
            if ($data['contact']['organization_id'] != null) {
                $data['og_contacts'] = Contact::where('organization_id', $data['organization']['id'])->get();
                if (count($data['og_contacts']) > 0) {
                    foreach ($data['og_contacts'] as $key => $contact) {
                        $data['org_contact_numbers'] = [];
                        $data['org_contact_emails'] = [];
                        $numbers = DB::table('contact_phone')->where('contact_id', $contact->id)->get();
                        foreach ($numbers as $key => $value) {
                            array_push($data['org_contact_numbers'], $value->phone_number);
                        }
                        $emails = DB::table('contact_email')->where('contact_id', $contact->id)->get();
                        foreach ($emails as $key => $value) {
                            array_push($data['org_contact_emails'], $value->email);
                        }
                        $contact->phones = $data['org_contact_numbers'];
                        $contact->emails = $data['org_contact_emails'];
                    }
                }
                if ($data['organization']) {
                    $numbers = DB::table('organization_number')->where('organization_id', $data['organization']['id'])->get();
                    foreach ($numbers as $key => $value) {
                        array_push($data['organization_numbers'], $value->contact_number);
                    }
                    $emails = DB::table('organization_email')->where('organization_id', $data['organization']['id'])->get();
                    foreach ($emails as $key => $value) {
                        array_push($data['organization_emails'], $value->email);
                    }
                    $address = DB::table('organization_address')->where('organization_id', $data['organization']['id'])->get();
                    foreach ($address as $key => $value) {
                        array_push($data['organization_address'], $value->address);
                    }
                }
            }
            $data['owner'] = User::findOrFail($data['contact']->creator_user);
        } else {
            $data = [];
        }

        return $data;
    }

    public function dealStatusDetail($id)
    {
        $lead = Lead::findOrFail($id);
        $status_histories = StatusHistory::where('lead_id', $id)->with('from', 'to')->get();
        try {
            return response()->json([
                'page' => view('backend.components.statusViewDeal', compact('status_histories', 'lead'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function contract()
    {
        return view('backend.contract.index');
    }

    public function payment()
    {
        return view('backend.payment.index');
    }

    public function organization()
    {
        return view('backend.organization.index');
    }


    public function report()
    {
        return view('backend.report.index');
    }

    public function appointment()
    {
        return view('backend.appointment.index');
    }


    public function campaign()
    {
        return view('backend.campaign.index');
    }

    public function inventory()
    {
        return view('backend.inventory.index');
    }

    public function role()
    {
        if (Auth::user()->hasRole('Super Admin')) {
            $roles = Role::where('company_id', auth()->user()->company_id)->cursorPaginate(10);
        } else {

            $roles = Role::whereNotIn('name', ['Super Admin'])->where('company_id', auth()->user()->company_id)->cursorPaginate(10);
        }
        $users = User::where('company_id', auth()->user()->company_id)->get();
        return view('backend.role.index', compact('roles', 'users'));
    }
}
