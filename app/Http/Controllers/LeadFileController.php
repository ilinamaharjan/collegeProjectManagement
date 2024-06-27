<?php

namespace App\Http\Controllers;

use App\Models\LeadFile;
use App\Repositories\LeadFileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Support\MediaStream;

class LeadFileController extends Controller
{
    protected $leadfile;

    public function __construct(LeadFileRepositoryInterface $leadfile) {
        $this->leadfile= $leadfile;
    }

    public function download(LeadFile $file){
        $downloads = $file->getMedia('lead-files');
        return MediaStream::create('lead-files.zip')->addMedia($downloads);
    }

    public function linkActivity(Request $request){
        $data = $request->all();
        try {
            LeadFile::where('id',$data['id'])->update([
                'activity_id' => $data['activity_id']
            ]);
            return response()->json([
                'response' => true,
                'message' => 'Linked Successfully'
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
        try {
            DB::transaction(function () use($data) {
                $lead_file_data = Arr::except($data,['files']);
                $lead_file = LeadFile::create($lead_file_data);
                if (array_key_exists('files',$data)) {
                    foreach ($data['files'] as $key => $file) {
                        $lead_file->addMedia($file)->toMediaCollection('lead-files');
                    }
                }
            });
            return response()->json([
                'response' => true,
                'typeId' => $data['field_type_id'],
                'message' => 'Successfully Added' 
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage() 
            ]);
        }
    }
}
