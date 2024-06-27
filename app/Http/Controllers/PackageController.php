<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Module;
use App\Models\Package;
use App\Repositories\PackageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PackageController extends Controller
{
    protected $package,$commonController;

    public function __construct(PackageRepositoryInterface $package , CommonController $commonController) {
        $this->package= $package;
        $this->commonController= $commonController;
    }

    public function showModal(Package $package){
        $module_name_arr = [];
        foreach ($package->modules as $key => $module) {
            array_push($module_name_arr , $module['name']);
        }
        $module_name = implode(",",$module_name_arr);
        try {
            return response()->json([
                'page' => view('backend.components.viewPackageModal',compact('package','module_name_arr'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    } 

    public function update(Request $request){
        $data = $request->all();
        $rules = [
            'title' => 'required',
            'price' => 'required',
            'no_of_users' => 'required',
        ];

        $validation_response = $this->commonController->validator($data, $rules);

        if ($validation_response['response'] == false) {
            Alert::error('Error', $validation_response['error_message']);
            return back();
        } else {
            try {
                $modified_data = Arr::except($data, ['modules']);
                $is_specific = array_key_exists('company_id', $modified_data) ? 1 : 0;

                DB::transaction(function () use ($modified_data, $data, $is_specific) {
                    $modified_data['is_specific'] = $is_specific;
                    $package = Package::where('id', $data['package_id'])->first();
                    $package->update($modified_data);

                    if (array_key_exists('modules', $data)) {
                        $package->modules()->sync($data['modules']);
                    }

                    if ($is_specific == 1) {
                        foreach ($modified_data['company_id'] as $key => $id) {
                            Company::where('id', $id)->update([
                                'package_id' => $package['id']
                            ]);
                        }
                    }
                });

                Alert::success('Success', 'Package Updated');
                return redirect()->route('package.viewpackage');
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        

    }

    public function delete(Package $package){
        try {
            $package->modules()->detach();
            $package->delete();
            Alert::success('Deleted','Deleted Successfully');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Error',$th->getMessage());
            return back();
        }
    }

    public function index(){
        $packages = Package::all();
        return view('backend.package.index',compact('packages'));
    }
    
    public function viewpackage(){
        $packages = Package::all();
        return view('backend.package.viewpackage',compact('packages'));
    }

    public function configure(){
        $packages = Package::all();
        $companies = Company::where('parent_id',auth()->user()->company_id)->get();
        $modules = Module::where('parent_module_id',null)->where('name','!=','Company')->where('name','!=','Package')->get();
        return view('backend.package.configure',compact('packages','modules','companies'));
    }

    public function updateModal(Package $package){
        $companies = Company::where('parent_id',auth()->user()->company_id)->get();
        $modules = Module::where('parent_module_id',null)->where('name','!=','Company')->where('name','!=','Package')->get();
        $package_modules = $package->modules;
        $package_modules_name = [];
        foreach ($package_modules as $key => $pm) {
            array_push($package_modules_name,$pm['name']);
        }
        try {
            return response()->json([
                'page' => view('backend.components.updatePackage',compact('package','modules','companies','package_modules_name'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function getModules($id){
        try {
            $package = Package::where('id',$id)->with('modules')->first();
            $modules = $package['modules'];
            return response()->json([
                'page' => view('backend.components.getModules',compact('modules'))->render(),
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
        $rules = [
            'title' => 'required',
            'price' => 'required',
            'no_of_users' => 'required',
            'modules' => 'required'
        ];
        $validation_response = $this->commonController->validator($data,$rules);
        if ($validation_response['response'] == false) {
            Alert::error('Error',$validation_response['error_message']);
            return back();
        } else {
            try {
                $modified_data = Arr::except($data,['modules']);
                $is_specific = array_key_exists('company_id',$modified_data) ? 1 : 0;
                DB::transaction(function () use($modified_data , $data,$is_specific) {
                    $modified_data['is_specific'] = $is_specific; 
                    $package = Package::create($modified_data);
                    $package->modules()->attach($data['modules']);
                    if ($is_specific == 1) {
                        foreach ($modified_data['company_id'] as $key => $id) {
                            Company::where('id',$id)->update([
                                'package_id' => $package['id']
                            ]);
                        }
                    }
                    
                });
                Alert::success('Success','Package Added');
                return redirect()->route('package.viewpackage');
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
