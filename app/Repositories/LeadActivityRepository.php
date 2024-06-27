<?php

namespace App\Repositories;

use App\Models\LeadActivity;

class LeadActivityRepository implements LeadActivityRepositoryInterface {
    public function store($data)
    {
        $data['creator_user'] = auth()->id();
        try {
            LeadActivity::create($data);
            return [
                'response' => true,
                'message' => 'Successfully Added'
            ];
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}