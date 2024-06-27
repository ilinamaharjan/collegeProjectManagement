<?php

namespace App\Repositories;

use App\Models\LeadFile;
use App\Models\LeadFileType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LeadFileTypeRepository implements LeadFileTypeRepositoryInterface
{

    public function store($data)
    {
        try {

            DB::transaction(function () use ($data) {
                if (array_key_exists('has_multiple', $data)) {
                    $data['has_multiple'] = 1;
                } else {
                    $data['has_multiple'] = 0;
                }
                $data['creator_user'] = auth()->id();
                $data['company_id'] = auth()->user()->company_id;
                LeadFileType::create($data);
            });
            return response()->json([
                'success' => true,
                'message' => 'Stored Successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
