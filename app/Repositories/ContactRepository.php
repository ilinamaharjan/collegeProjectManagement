<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ContactRepository implements ContactRepositoryInterface {
    public function store($data)
    {
        $organizationData = $data['organization'];
        $organizationId = null;

        if ($organizationData['name'] != null) {
            if ($organizationData['is_new'] == 1) {
                $orgData = [
                    'name' => $organizationData['name'],
                    'creator_user' => auth()->id(),
                    'company_id' => auth()->user()->company_id
                ];
                $createdOrganization = Organization::create($orgData);
                $organizationId = $createdOrganization->id;
            } else {
                $organizationId = $organizationData['id'];
            }
        }

        $contactData = [
            'name' => $data['contact']['name'],
            'company_id' => auth()->user()->company_id,
            'creator_user' => auth()->id(),
            'additional_fields' => json_encode(Arr::except($data, ['_token', 'contact','organization'])),
            'organization_id' => $organizationId
        ];

        try {
            DB::transaction(function () use ($contactData, $data) {
                $createdContact = Contact::create($contactData);

                if (array_key_exists('email', $data['contact'])) {
                    $emails = [];
                    foreach ($data['contact']['email'] as $orgEmail) {
                        $emails[] = [
                            'contact_id' => $createdContact->id,
                            'email' => $orgEmail
                        ];
                    }
                    DB::table('contact_email')->insert($emails);
                }

                if (array_key_exists('number', $data['contact'])) {
                    $numbers = [];
                    foreach ($data['contact']['number'] as $orgNumber) {
                        $numbers[] = [
                            'contact_id' => $createdContact->id,
                            'phone_number' => $orgNumber
                        ];
                    }
                    DB::table('contact_phone')->insert($numbers);
                }
            });

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

    public function update($data){
        $contact_person = Contact::where('id',$data['id'])->first();
        $contact_data = $data['contact'];
        $additional_fields = json_encode(Arr::except($data, ['_token','id','contact','organization']));
        try {
            DB::transaction(function() use($contact_person,$additional_fields,$data,$contact_data){
                $contact_person->update([
                    'name' => $contact_data['name'],
                    'additional_fields' => $additional_fields
                ]);
                if (array_key_exists('email',$contact_data)) {
                    $var_data = [];
                    DB::table('contact_email')->where('contact_id',$data['id'])->delete();
                    foreach ($contact_data['email'] as $key => $email) {
                        $var_data[] = [
                            'contact_id' => $data['id'],
                            'email' => $email
                        ];
                    }
                    DB::table('contact_email')->insert($var_data);
                }
                if (array_key_exists('number',$contact_data)) {
                    $var_data = [];
                    DB::table('contact_phone')->where('contact_id',$data['id'])->delete();
                    foreach ($contact_data['number'] as $key => $num) {
                        $var_data[] = [
                            'contact_id' => $data['id'],
                            'phone_number' => $num
                        ];
                    }
                    DB::table('contact_phone')->insert($var_data);
                }
            });
            return [
                'response' => true,
                'message' => 'Successfully Updated'
            ];
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}