<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface {
    public function store($data){
        try {
            DB::transaction(function () use($data) {
                $data['user_id'] = auth()->id();
                $company = Company::create($data);
                if (array_key_exists('img',$data)) {
                    $company->addMedia($data['img'])->toMediaCollection('company-logo');
                }
            });

            return [
                'response' => true,
                'message' => 'Successfully added'
            ];
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}