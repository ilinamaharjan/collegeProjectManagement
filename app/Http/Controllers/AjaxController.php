<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Module;
use App\Models\Company;
use App\Models\Contact;
use App\Models\EmailSetting;
use App\Models\Package;
use App\Models\LeadFile;
use App\Models\LeadFileType;
use App\Models\LeadSetting;
use Illuminate\Support\Str;
use App\Models\LeadActivity;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\StatusHistory;
use App\Models\StatusSetting;
use App\Models\Task;
use App\Notifications\DBNotification;
use App\Notifications\NotifyTaskUpdate;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use App\Notifications\SendCredentialsToUser;
use App\Repositories\OrganizationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class AjaxController extends Controller
{

    public function storeTaskLog(Request $request){
        $data = $request->all();
        try {
            Task::where('id',$data['task_id'])->update([
                'actual_start_time' => $data['actual_start_time'],
                'actual_completed_time' => $data['actual_completed_time'],
                'log_time' => $data['log_time']
            ]);

            return response()->json([
                'response' => true,
                'message' => 'Time Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getNotificationDetails($id){
        $notification = DB::table('notifications')->where('id',$id)->first();
        if ($notification->read_at == null) {
            DB::table('notifications')->where('id', $id)->update([
                'read_at' => now()
            ]);
        }
        try {
            if(json_decode($notification->data)->type == 'task_updated'){
                $notif_data = collect(json_decode($notification->data))->toArray();
                $additional_data = collect($notif_data['additional'])->toArray();

                return response()->json([
                    'response' => true,
                    'page' => view('backend.components.notifications.taskNotificationDetail', compact('notif_data', 'additional_data'))->render()
                ]);
            }
            if(json_decode($notification->data)->type == 'task_created'){
                $notif_data = collect(json_decode($notification->data))->toArray();
                $additional_data = collect($notif_data['additional'])->toArray();

                return response()->json([
                    'response' => true,
                    'page' => view('backend.components.notifications.taskNotificationDetail', compact('notif_data', 'additional_data'))->render()
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }

    }

    public function getNotifications($status = null){
        if($status==null){
            $notifications = auth()->user()->unreadNotifications()
                ->orderBy('read_at', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
                $count = count(auth()->user()->unreadNotifications);
        }else{
            $notifications = auth()->user()->notifications()
            ->orderBy('read_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            $count = count(auth()->user()->notifications);
        }
        foreach ($notifications as $key => $notification) {
            if ($notification['data']['type'] == 'task_updated') {
                $task = Task::where('id', $notification['data']['unique_id'])->first();
                $notification['has_detail_modal']=true;
                $notification['notify_message']='';
                if($task){
                    $notification['notify_message'] = 'Task Updated from '. $notification['data']['additional']['from'] .' to '. $notification['data']['additional']['to'] .' by [ ' . $notification['data']['additional']['creator'] . ' ]. ';
                }else{
                    DB::table('notifications')->where('id',$notification['id'])->update(['read_at'=>now()]);
                }
            }
            if ($notification['data']['type'] == 'task_created') {
                $task = Task::where('id', $notification['data']['unique_id'])->first();
                $notification['has_detail_modal']=true;
                $notification['notify_message']='';
                if($task){
                    $notification['notify_message'] = 'Task created by '. $notification['data']['additional']['creator'] . '. ';
                }else{
                    DB::table('notifications')->where('id',$notification['id'])->update(['read_at'=>now()]);
                }
            }

            $notification['created_date'] = Carbon::parse($notification['created_at'], 'Asia/Kathmandu')->toDateString();
        }
        $unreadCount=count(auth()->user()->unreadNotifications);

        if($status==null){
            return response()->json([
                'page' => view('backend.components.notificationData', compact('notifications', 'count','unreadCount'))->render()
            ]);
        }else{
            return view('backend.components.allNotification', compact('notifications', 'count','unreadCount'));
        }
    }

    public function getTask(StatusSetting $category){
        $data_old = [];
        $data = [];
        if (count($category->leadSettings) > 0) {

            $lead_heirarchy_settings = LeadSetting::where('status_setting_id', $category['id'])->where('heirarchy_order', '!=', null)->orderBy('heirarchy_order')->with('tasks','tasks.creator','tasks.users')->get();
            if (count($lead_heirarchy_settings) > 0) {
                foreach ($lead_heirarchy_settings as $key => $l_s) {
                    array_push($data_old, $l_s->toArray());
                }
            }

            $first_setting = LeadSetting::where('status_setting_id', $category['id'])->where('notifier', 'First')->with('tasks','tasks.creator','tasks.users')->first()->toArray();
            $last_setting = LeadSetting::where('status_setting_id', $category['id'])->where('notifier', 'Last')->with('tasks','tasks.creator','tasks.users')->first()->toArray();
            if (($first_setting != null) || ($last_setting != null)) {
                isset($first_setting) ? array_unshift($data_old, $first_setting) : $data_old;
                isset($last_setting) ? array_push($data_old, $last_setting) : $data_old;
            }
        }
        foreach ($data_old as $key => $datum) {
            $dummy_data = Arr::except($datum,['tasks']);
            $tasks = [];
            foreach ($datum['tasks'] as $key => $task) {
                if ($task['parent_id'] == null) {
                    array_push($tasks,$task);
                }
            }
            $dummy_data['tasks'] = $tasks;
            array_push($data,$dummy_data);
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function getAssigneesTask(Request $request){
        $data = $request->all();
        $temp = [];
        $final_data = [];
        $category = StatusSetting::where('id',$data['status_setting_id'])->first();
        if (count($category->leadSettings) > 0) {
            $lead_heirarchy_settings = LeadSetting::where('status_setting_id', $category['id'])->where('heirarchy_order', '!=', null)->orderBy('heirarchy_order')->get();
            if (count($lead_heirarchy_settings) > 0) {
                foreach ($lead_heirarchy_settings as $key => $l_s) {
                    array_push($temp, $l_s->toArray());
                }
            }
            $first_setting = LeadSetting::where('status_setting_id', $category['id'])->where('notifier', 'First')->first()->toArray();
            $last_setting = LeadSetting::where('status_setting_id', $category['id'])->where('notifier', 'Last')->first()->toArray();
            if (($first_setting != null) || ($last_setting != null)) {
                isset($first_setting) ? array_unshift($temp, $first_setting) : $temp;
                isset($last_setting) ? array_push($temp, $last_setting) : $temp;
            }

            foreach ($temp as $key => $datum) {
                $s_task = [];
                $all_tasks = Task::where('status_id',$datum['id'])->where('parent_id',null)->get();
                foreach ($all_tasks as $key => $task) {
                    $specific_tasks = DB::table('tasks_users')->where('task_id',$task['id'])->where('user_id',$data['user_id'])->get();
                    $decoded_tasks = json_decode(json_encode($specific_tasks), true);
                    if (count($decoded_tasks) > 0) {
                        foreach ($decoded_tasks as $key => $d_t) {
                            $task = Task::where('id',$d_t['task_id'])->with('creator','users')->first()->toArray();
                            array_push($s_task , $task);
                        }
                    }

                }
                $datum['tasks'] = $s_task;
                array_push($final_data,$datum);
            }
        }
        return response()->json([
            'data' => $final_data
        ]);
    }

    public function updateTask(Request $request){
        $data = $request->all();
        $task = Task::where('id',$data['id'])->first();
        $previous_stats = $task['status_id'];
        $changed_stats = $data['status_id'];
        $status_setting_id = LeadSetting::where('id',$data['status_id'])->with('status_setting')->pluck('status_setting_id')->first();
        $final_status = LeadSetting::where('status_setting_id',$status_setting_id)->where('notifier','Last')->pluck('id')->first();
        $task_data = [];
        try {
            if ($data['status_id'] == $final_status) {
                $subtasks_exists = Task::where('parent_id',$task['id'])->where('is_completed',0)->exists();
                if ($subtasks_exists) {
                    throw new Exception("Subtasks must be completed", 1);
                }else {
                    $task_data['status_id'] = $data['status_id'];
                    $task_data['is_completed'] = 1;
                }
            }else {
                $task_data['status_id'] = $data['status_id'];
            }

            $task->update($task_data);

            $status_history_data = [
                'task_id' => $task['id'],
                'from_status' => $previous_stats,
                'to_status' => $changed_stats,
                'creator_user' => auth()->id()
            ];

            StatusHistory::create($status_history_data);

            // Fetch Email Settings
            $email_settings = EmailSetting::where('module_type','Project Management')->select('mail_to_creator','mail_to_assignees')->first();

            $users = [];
            $users_id = [];

            if ($email_settings['mail_to_creator'] == 1) {
                $user = User::where('id',$task['creator_user'])->first();
                array_push($users_id,$user['id']);
            }
            if ($email_settings['mail_to_assignees'] == 1) {
                $assignees = $task->users;
                if (count($assignees) > 0) {
                    foreach ($assignees as $key => $assignee) {
                        array_push($users_id,$assignee['id']);
                    }
                }
            }
            $unique_user_id = array_unique($users_id);
            foreach ($unique_user_id as $key => $u_id) {
                $user = User::where('id',$u_id)->first();
                array_push($users,$user);
            }
            // Mail template
            $mail_data = [
                'creator' => auth()->user()->name,
                'task' => $task,
                'from' => LeadSetting::where('id',$previous_stats)->pluck('status_name')->first(),
                'to' => LeadSetting::where('id',$changed_stats)->pluck('status_name')->first(),
                'created' => 0
            ];

            Notification::send($users, new NotifyTaskUpdate($mail_data));
            Notification::send($users, new DBNotification('task_updated',$task['id'],$mail_data));
            return response()->json([
                'response' => true,
                'message' => 'Status Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }



    }



    public function storeStatusSetting(Request $request)
    {
        $data = $request->all();
        $company_data = [
            'name' => $data['name'],
            'module' => $data['module'],
            'company_id' => auth()->user()->company_id
        ];
        try {
            $category_data = StatusSetting::create($company_data);
            return response()->json([
                'response' => true,
                'message' => 'Category Added',
                'data' => $category_data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateLead(Request $request)
    {
        $data = $request->all();
        $lead = Lead::where('id', $data['lead_id'])->first();
        $status_setting_id = LeadSetting::where('id',$data['status_id'])->with('status_setting')->pluck('status_setting_id')->first();
        $final_status = LeadSetting::where('status_setting_id',$status_setting_id)->where('notifier','Last')->pluck('id')->first();
        $draggable = true;
        if ((int)$data['status_id'] == $final_status) {
            $draggable = false;
            $lead_data['status_id'] = $data['status_id'];
            $lead_data['is_converted'] = 1;
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
        }else {
            $lead_data['status_id'] = $data['status_id'];
            $lead_data['is_converted'] = 0;
        }

        try {
            $status_history_data = [
                'lead_id' => $lead['id'],
                'from_status' => $lead['status_id'],
                'to_status' => $data['status_id'],
                'creator_user' => auth()->id()
            ];
            StatusHistory::create($status_history_data);

            $lead->update($lead_data);

            return response()->json([
                'response' => true,
                'message' => 'Status Updated',
                'draggable' => $draggable
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function changeActivityStatus(Request $request)
    {
        $data = $request->all();
        $activity = LeadActivity::where('id', $data['activity_id'])->first();
        try {
            $activity->update([
                'status' => $data['status']
            ]);
            return response()->json([
                'response' => true,
                'message' => 'Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getLeadFiles(Request $request)
    {
        $data = $request->all();
        $lead_id = $data['lead_id'];
        $file_type_id = $data['file_type_id'];
        $file_type = LeadFileType::where('id', $file_type_id)->first();
        $lead_activities = LeadActivity::where('lead_id', $lead_id)->get();
        if ($file_type_id == 'all') {
            $files = LeadFile::where('lead_id', $lead_id)->with('media')->get();
        } else {
            $files = LeadFile::where('lead_id', $lead_id)->where('field_type_id', $file_type_id)->with('media')->get();
        }
        return response()->json([
            'page' => view('backend.components.dynamicLeadFiles', compact('files', 'file_type', 'lead_id', 'lead_activities'))->render(),
            'response' => true,
        ]);
    }

    public function getLeadStatus($id)
    {
        $lead_settings = LeadSetting::where('status_setting_id', $id)->get();
        try {
            return response()->json([
                'page' => view('backend.components.dynamicDropdown', compact('lead_settings'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function getStatusSetting(StatusSetting $category)
    {
        // $lead_heirarchy_setting = LeadSetting::where('status_setting_id',$category['id'])->where('heirarchy_order','!=',null)->orderBy('heirarchy_order')->get();
        // dd($category->leadSettings);

        // $arr = count($lead_heirarchy_setting) > 0 ? $lead_heirarchy_setting->toArray() : null;
        // $first_setting = LeadSetting::where('status_setting_id',$category['id'])->where('notifier','First')->first()->toArray();
        // $last_setting = LeadSetting::where('status_setting_id',$category['id'])->where('notifier','Last')->first()->toArray();
        // array_unshift($arr,$first_setting);
        // array_push($arr,$last_setting);
        // $backend_data = [];
        // foreach ($arr as $key => $a) {
        //     $l_ds = Lead::where('status_id',$a['id'])->with('media')->get();
        //     $leads = [];
        //     if (count($l_ds) > 0) {
        //         foreach ($l_ds as $key => $l_d) {
        //             array_push($leads , $l_d);
        //         }
        //     }
        //     $a['lead_data'] = $leads;
        //     array_push($backend_data,$a);
        // }
        // dd($backend_data);
        $data = [];
        $organizationRepo = new OrganizationRepository();
        if (count($category->leadSettings) > 0) {

            $lead_heirarchy_settings = LeadSetting::where('status_setting_id', $category['id'])->where('heirarchy_order', '!=', null)->orderBy('heirarchy_order')->with('leads')->get();
            if (count($lead_heirarchy_settings) > 0) {
                foreach ($lead_heirarchy_settings as $key => $l_s) {
                    array_push($data, $l_s->toArray());
                }
            }

            $first_setting = LeadSetting::where('status_setting_id', $category['id'])->where('notifier', 'First')->with('leads')->first();
            $last_setting = LeadSetting::where('status_setting_id', $category['id'])->where('notifier', 'Last')->with('leads')->first();
            if (($first_setting != null) || ($last_setting != null)) {
                isset($first_setting) ? array_unshift($data, $first_setting->toArray()) : $data;
                isset($last_setting) ? array_push($data, $last_setting->toArray()) : $data;
            }
        }

        $new_data = [];
        foreach ($data as $key => $datum) {
            $new_lead = [];
            if (count($datum['leads']) > 0) {
                foreach ($datum['leads'] as $key1 => $lead) {
                    $emails = $organizationRepo->getFields('email', $lead['organization_id']);
                    $lead['emails'] = $emails;
                    $lead['relation'] = Lead::where('id', $lead['id'])->with('organization', 'contact')->first();
                    if ($lead['creator_user'] == auth()->id()) {
                        # code...
                        array_push($new_lead, $lead);
                    }
                }
            }
            $datum['leads'] = $new_lead;
            array_push($new_data, $datum);
        }
        return response()->json([
            'data' => $new_data
        ]);
    }

    public function storeUser(Request $request)
    {
        $data = $request->all();
        try {
            DB::transaction(function () use ($data) {
                $company_code = Company::where('id', $data['company_id'])->pluck('company_code')->first();
               
                $password = "asdfgh137";
                // $password = Str::random(8);
                $data['password'] = bcrypt($password);
                $data['username'] = $company_code . '-' . $data['username'];
                $data['email_verified_at'] = Carbon::now();
                $user = User::create($data);
                if (array_key_exists('photo', $data)) {
                    $user->addMedia($data['photo'])->toMediaCollection('profile-photo');
                }
                $company = Company::where('id', $data['company_id'])->first();
                $mail_data = [
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'password' => $password,
                    'company' => $company,
                    'id' => $user['id']
                ];
                Role::insert([
                    'name' => 'Admin',
                    'guard_name' => 'web',
                    'company_id' => $company->id
                ]);
                $role = Role::where('name', 'Admin')->where('company_id', $company->id)->first();
                $permission_ids = [];
                // $package = Package::where('id', $company->package_id)->with('modules')->first();
                $permission_arr = [];
                // foreach ($package->modules as $key => $module) {
                //     if ($module['name'] == 'Company') {
                //         $company_permissions = Permission::where('module_id', $module['id'])->where('name', '!=', 'Create|Company')->where('name', '!=', 'Delete|Company')->get();
                //         foreach ($company_permissions as $key => $c_permission) {
                //             array_push($permission_arr, $c_permission);
                //         }
                //     } else {
                //         $permissions = Permission::where('module_id', $module['id'])->get();
                //         foreach ($permissions as $key => $permission) {
                //             array_push($permission_arr, $permission);
                //         }
                //         if (count($module->subModules) > 0) {
                //             foreach ($module->subModules as $key => $sub_module) {
                //                 $sub_permissions = Permission::where('module_id', $sub_module['id'])->get();
                //                 foreach ($sub_permissions as $key => $s_permission) {
                //                     array_push($permission_arr, $s_permission);
                //                 }
                //             }
                //         }
                //     }
                // }
                // for dashboard
                $adminDashboards = Permission::where('name', 'Admin|Dashboard')->where('View All|Project
                Management')->get();
                
                foreach ($adminDashboards as $key => $adminDashboard) {
                   array_push($permission_arr, $adminDashboard);
                }
                
                foreach ($permission_arr as $key => $permission) {
                    array_push($permission_ids, $permission['id']);
                }
                $role->givePermissionTo($permission_ids);
                $user->assignRole($role);
                $user->notify(new SendCredentialsToUser($mail_data));
            });

            // Alert::toast('User Created Successfully!','success');
            Alert::success('Success', 'User Created Successfully');
            return redirect()->route('company.viewCompanies');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return back();
        }
    }

    public function getContacts($id)
    {
        if ($id == 'default') {
            $contacts = Contact::where('company_id', auth()->user()->company_id)->get();
            $page = view('backend.components.defaultContactsData',compact('contacts'));
        } else {
            $organization = Organization::where('id', $id)->with('contacts')->first();
            $contacts = $organization['contacts'];
            $page = view('backend.components.dropdownContactsData', compact('contacts'));
        }
        try {
            return response()->json([
                'page' => $page->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function getDropdown($word)
    {
        $organizations = Organization::where('name', 'LIKE', '%' . $word . '%')->get();
        try {
            return response()->json([
                'page' => view('backend.components.dropdown', compact('organizations'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function getDropdown2($word)
    {
        $organizations = Organization::where('name', 'LIKE', '%' . $word . '%')->get();
        try {
            return response()->json([
                'page' => view('backend.components.dropdown2', compact('organizations'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }
}
