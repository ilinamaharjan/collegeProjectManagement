<?php

namespace App\Http\Controllers;

use App\Models\EmailSetting;
use App\Models\LeadSetting;
use App\Models\StatusHistory;
use App\Models\StatusSetting;
use App\Models\Task;
use App\Models\User;
use App\Notifications\DBNotification;
use App\Notifications\NotifyTaskUpdate;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;

class TaskController extends Controller
{
    protected $task;

    public function __construct(TaskRepositoryInterface $task) {
        $this->task= $task;
    }

    public function assignUser(Request $request){
        $data = $request->all();
        try {
            DB::transaction(function () use($data){
                $task = Task::findOrFail($data['task_id']);
                $assigned_users_str = $data['assignee'];
                $assigned_users = explode(",",$assigned_users_str);
                $task->users()->syncWithPivotValues($assigned_users,['status_setting_id' => $data['status_setting_id']]);
            });

            return response()->json([
                'response' => true,
                'message' => 'Task has been assigned'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function changeStatus(Request $request){
        $data = $request->all();
        $current_status = LeadSetting::where('id',$data['status_id'])->first();
        $completed_stat = LeadSetting::where('status_setting_id',$current_status['status_setting_id'])->where('notifier','Last')->first();

        try {
            DB::transaction(function() use($data,$current_status,$completed_stat) {
                $is_completed = ($current_status == $completed_stat) ? 1 : 0;
               ;
                Task::where('id',$data['task_id'])->update([
                    'is_completed' => $is_completed,
                    'status_id' => $current_status['id']
                ]);
            });
            $parent_id = Task::where('id',$data['task_id'])->pluck('parent_id')->first();
            $completed_status = $completed_stat['id'];
            $project = StatusSetting::where('id',$current_status['status_setting_id'])->with('leadSettings')->first();
            $sub_tasks = Task::where('parent_id',$parent_id)->get();
            return response()->json([
                'response' => true,
                'message' => ($current_status == $completed_stat) ? 'Completed' : 'Status Changed',
                'page' => view('backend.components.dynamicSubTask', compact('sub_tasks','project','completed_status'))->render()

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateDescription(Request $request){
        $data = $request->all();
        try {
            Task::where('id',$data['id'])->update([
                'description' => $data['description']
            ]);

            return response()->json([
                'response' => true,
                'message' => 'Successfully Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function storeSubTask(Request $request){
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        $data['creator_user'] = auth()->id();
        $data['is_completed'] = 0;
        $category_id = LeadSetting::where('id',$data['status_id'])->pluck('status_setting_id')->first();
        $data['is_assigned'] = array_key_exists('assignee',$data) ? 1 : 0;
        $task_data = Arr::except($data,['_token','assignee']);
        try {
            $task = Task::create($task_data);
            $task->users()->attach($data['assignee'],['status_setting_id' => $category_id]);
            $sub_tasks = Task::where('parent_id',$data['parent_id'])->get();
            $project_id = LeadSetting::where('id',$data['status_id'])->pluck('status_setting_id')->first();
            $completed_status = LeadSetting::where('status_setting_id',$project_id)->where('notifier','Last')->pluck('id')->first();
            $project = StatusSetting::where('id',$project_id)->with('leadSettings')->first();

            return response()->json([
                'response' => true,
                'message' => 'Successfully Created',
                'page' => view('backend.components.dynamicSubTask', compact('sub_tasks','project','completed_status'))->render()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function taskprofile($id){
        $task = Task::where('id',$id)->with('creator','company','histories','setting')->first();
        $sub_tasks = Task::where('parent_id',$id)->get();
        $users = User::where('company_id',auth()->user()->company_id)->get();
        $project_id = LeadSetting::where('id',$task['status_id'])->pluck('status_setting_id')->first();

        $completed_status = LeadSetting::where('status_setting_id',$project_id)->where('notifier','Last')->pluck('id')->first();

        // Assignees
        $assignees = [];
        $task_users_data = DB::table('tasks_users')->where('task_id',$id)->get();
        $decoded_tu = json_decode(json_encode($task_users_data,true));
        foreach ($decoded_tu as $key => $d_t) {
            $assigned_users = User::where('id',$d_t->user_id)->first();
            array_push($assignees,$assigned_users);
        }
        $assignees = array_unique($assignees);

        $project = StatusSetting::where('id',$project_id)->with('leadSettings')->first();
        $task['project_name'] = $project['name'];
        return view('backend.project_manager.taskprofile',compact('task','project','users','sub_tasks','completed_status','assignees','project_id'));
    }

    public function getAssignee($id){
        $data = [];
        $task_users_data = DB::table('tasks_users')->where('status_setting_id',$id)->get();
        $decoded_tu = json_decode(json_encode($task_users_data,true));
        foreach ($decoded_tu as $key => $d_t) {
            $users = User::where('id',$d_t->user_id)->first();
            $task_count = DB::table('tasks_users')->where('user_id',$users['id'])->where('status_setting_id',$id)->count();
            $users['task_count'] = $task_count;
            array_push($data,$users);
        }
        $data = array_unique($data);
        try {
            return response()->json([
                'page' => view('backend.components.assigneeModal',compact('data'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(Request $request){
        $data = $request->all();
        $task_data = Arr::except($data,'lead');

        $task_data['status_id'] = $data['lead']['status_id'];
        $task_data['creator_user'] = auth()->id();
        $task_data['company_id'] = auth()->user()->company_id;
        $task_data['is_completed'] = 0;

        $lead_setting = LeadSetting::where('id',$data['lead']['status_id'])->first();
        $category_id = StatusSetting::where('id',$lead_setting['status_setting_id'])->first();

        try {
            DB::transaction(function () use($task_data,$category_id) {
                $task_data['is_assigned'] = array_key_exists('assignee',$task_data) ? 1 : 0;
                $task = Task::create($task_data);
                if (array_key_exists('assignee',$task_data)) {
                    try {
                        $task->users()->attach($task_data['assignee'],['status_setting_id' => $category_id['id']]);
                    } catch (\Throwable $th) {
                        dd($th->getMessage());
                    }
                }
                $status_history_data = [
                    'task_id' => $task['id'],
                    'from_status' => null,
                    'to_status' => $task['status_id'],
                    'creator_user' => auth()->id(),
                ];


                StatusHistory::create($status_history_data);

                // Fetch Email Settings
                $email_settings = EmailSetting::where('module_type','Project Management')->select('mail_to_creator','mail_to_assignees')->first();
                $users = [];
                $users_id = [];


               if($email_settings != null){
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
                    'from' => null,
                    'to' => LeadSetting::where('id',$task['status_id'])->pluck('status_name')->first(),
                    'created' => 1
                ];


                Notification::send($users, new NotifyTaskUpdate($mail_data));
                Notification::send($users, new DBNotification('task_created',$task['id'],$mail_data));

            });
            return response()->json([
                'response' => true,
                'message' => 'Task Created',
                'category_id' => $category_id['id']
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
