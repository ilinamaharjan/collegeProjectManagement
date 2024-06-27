<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Lead;
use App\Models\Organization;
use App\Models\StatusHistory;
use Illuminate\Support\Facades\DB;

class LeadRepository implements LeadRepositoryInterface {
    public function store($data){
        $leads = $data['lead'];
        try {
            DB::transaction(function () use($leads,$data) {
                $organization = $data['organization'];
                if ($leads['organization_id'] == 'createOrg') {
                    $json_data = null;
                    $organization_data['name'] = $organization['name'];
                    $organization_data['company_id'] = auth()->user()->company_id;
                    $organization_data['creator_user'] = auth()->id();
                    $organization_data['additional_fields'] = $json_data;
                    $created_organization = Organization::create($organization_data);
                    if (array_key_exists('email',$organization)) {
                        foreach ($organization['email'] as $key => $org_email) {
                            DB::table('organization_email')->insert([
                                'organization_id' => $created_organization['id'],
                                'email' => $org_email
                            ]);
                        }
                    }
                    if (array_key_exists('address',$organization)) {
                        foreach ($organization['address'] as $key => $org_address) {
                            DB::table('organization_address')->insert([
                                'organization_id' => $created_organization['id'],
                                'address' => $org_address
                            ]);
                        }
                    }
                    if (array_key_exists('number',$organization)) {
                        foreach ($organization['number'] as $key => $org_number) {
                            DB::table('organization_number')->insert([
                                'organization_id' => $created_organization['id'],
                                'contact_number' => $org_number
                            ]);
                        }
                    }

                    // For contact person;
                    
                    
                    $contact_person_data = storeContactPerson($organization['contact'],$created_organization,1,$organization);
                    $leads['organization_id'] = $created_organization['id'];
                    $leads['contact_id'] = $contact_person_data['id'];
                }elseif ($leads['contact_id'] == 'createContact') {
                    $contacts_data = $data['contact'];
                    $contacts_data['company_id'] = auth()->user()->company_id;
                    $contacts_data['creator_user'] = auth()->id();
                    $contacts_data['is_primary'] = 1;
                    $contact = Contact::create($contacts_data);
                    if (array_key_exists('email',$contacts_data)) {
                        foreach ($contacts_data['email'] as $key => $email) {
                            DB::table('contact_email')->insert([
                                'contact_id' => $contact['id'],
                                'email' => $email
                            ]);
                        }
                    }
                    if (array_key_exists('phone_number',$contacts_data)) {
                        foreach ($contacts_data['phone_number'] as $key => $number) {
                            DB::table('contact_phone')->insert([
                                'contact_id' => $contact['id'],
                                'phone_number' => $number
                            ]);
                        }
                    }
                    $leads['organization_id'] = null;
                    $leads['contact_id'] = $contact['id'];
                }else {
                    $leads['organization_id'] = $leads['organization_id'] == 'default' ? null : $leads['organization_id']; 
                }
                $leads['creator_user'] = auth()->id();
                $leads['company_id'] = auth()->user()->company_id;
                
                $lead_data = Lead::create($leads);
                try {
                    $status_history_data = [
                        'lead_id' => $lead_data['id'],
                        'from_status' => null,
                        'to_status' => $lead_data['status_id'],
                        'creator_user' => auth()->id()
                    ];
                    StatusHistory::create($status_history_data);
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }


            });
            return [
                'response' => true,
                'message' => 'Successfully Added',
            ];
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}