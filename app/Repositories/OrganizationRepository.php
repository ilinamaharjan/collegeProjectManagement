<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Organization;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function store($data)
    {
        $contact = $data['contact'];
        $organization = $data['organization'];
        try {
            if ($organization['name'] != null) {
                DB::transaction(function () use ($organization, $data) {
                    $organization_data['name'] = $organization['name'];
                    $organization_data['company_id'] = auth()->user()->company_id;
                    $organization_data['creator_user'] = auth()->id();
                    $organization_data['address'] = $organization['address'];
                    $organization_data['deal_type'] = $data['deal_type'];
                    $organization_data['email'] = $organization['email'];
                    $organization_data['number'] = $organization['number'];
                    $created_organization = Organization::create($organization_data);

                    if (array_key_exists('email', $organization_data)) {
                        foreach ($organization_data['email'] as $key => $org_email) {
                            DB::table('organization_email')->insert([
                                'organization_id' => $created_organization['id'],
                                'email' => $org_email
                            ]);
                        }
                    }
                    if (array_key_exists('address', $organization)) {
                        foreach ($organization['address'] as $key => $org_address) {
                            DB::table('organization_address')->insert([
                                'organization_id' => $created_organization['id'],
                                'address' => $org_address
                            ]);
                        }
                    }
                    if (array_key_exists('number', $organization_data)) {
                        foreach ($organization_data['number'] as $key => $org_number) {
                            DB::table('organization_number')->insert([
                                'organization_id' => $created_organization['id'],
                                'contact_number' => $org_number
                            ]);
                        }
                    }
                    if (array_key_exists('logo', $organization)) {
                        $created_organization->addMedia($organization['logo'])->toMediaCollection('organization-logo');
                    }
                    try {
                        $data['contact']['organization_id'] = $created_organization->id;
                        $this->storeContactPerson($data['contact'],$data['deal_type']);
                    } catch (\Throwable $th) {
                        dd($th->getMessage());
                    }
                });
            } else {
                try {
                    $data['contact']['organization_id'] = null;
                    $this->storeContactPerson($data['contact'],$data['deal_type']);
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }
            }
            return [
                'response' => true,
                'message' => 'Contact Added Successfully '
            ];
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => $th->getMessage()
            ];
        }
    }


    public function storeContactPerson($contact,$deal)
    {
        if ($contact['name'] != null) {
            $contact_data = [
                'name' => $contact['name'],
                'organization_id' => $contact['organization_id'],
                'email' => $contact['email'],
                'phone_number' => $contact['phone_number'],
                'company_id' => auth()->user()->company_id,
                'additional_fields' => null,
                'creator_user' => auth()->id(),
                'deal_type' => $deal,
                'is_primary'=> 1

            ];
            $contact_person = Contact::create($contact_data);
            if (array_key_exists('person_img', $contact)) {
                $contact_person->addMedia($contact['person_img'])->toMediaCollection('contact_media');
            }

            if (array_key_exists('email', $contact)) {
                foreach ($contact['email'] as $key => $email) {
                    DB::table('contact_email')->insert([
                        'contact_id' => $contact_person['id'],
                        'email' => $email
                    ]);
                }
            }
            if (array_key_exists('phone_number', $contact)) {
                foreach ($contact['phone_number'] as $key => $ph) {

                    DB::table('contact_phone')->insert([
                        'contact_id' => $contact_person['id'],
                        'phone_number' => $ph
                    ]);
                }
            }
        }
    }
    public function update($data)
    {
        try {
        if(array_key_exists('organization_id',$data)){
            $organization = Organization::where('id', $data['organization_id'])->first();
            $organization_data = $data['organization'];
            $additional_fields = json_encode(Arr::except($data, ['_token', 'organization_id', 'organization']));
            DB::transaction(function () use ($organization, $additional_fields, $organization_data, $data) {
                $organization->update([
                    'name' => $organization_data['name'],
                    'additional_fields' => $additional_fields,
                    'deal_type'=>$data['deal_type']
                ]);
                if (array_key_exists('logo', $organization_data)) {
                    if($organization->hasMedia('organization-logo')){
                        $organization->clearMediaCollection('organization-logo');
                    }
                    $organization->addMedia($organization_data['logo'])->toMediaCollection('organization-logo');
                }
                if (array_key_exists('email', $organization_data)) {
                    $var_data = [];
                    DB::table('organization_email')->where('organization_id', $data['organization_id'])->delete();
                    foreach ($organization_data['email'] as $key => $email) {
                        $var_data[] = [
                            'organization_id' => $data['organization_id'],
                            'email' => $email
                        ];
                    }
                    DB::table('organization_email')->insert($var_data);
                }
                if (array_key_exists('number', $organization_data)) {
                    $var_data = [];
                    DB::table('organization_number')->where('organization_id', $data['organization_id'])->delete();
                    foreach ($organization_data['number'] as $key => $num) {
                        $var_data[] = [
                            'organization_id' => $data['organization_id'],
                            'contact_number' => $num
                        ];
                    }
                    DB::table('organization_number')->insert($var_data);
                }
                if (array_key_exists('address', $organization_data)) {
                    $var_data = [];
                    DB::table('organization_address')->where('organization_id', $data['organization_id'])->delete();
                    foreach ($organization_data['address'] as $key => $ad) {
                        $var_data[] = [
                            'organization_id' => $data['organization_id'],
                            'address' => $ad
                        ];
                    }
                    DB::table('organization_address')->insert($var_data);
                }
            });
               
        }
        $contact = Contact::where('id', $data['contact_id'])->first();
        $contact_data = $data['contact'];
         $additional_fields = json_encode(Arr::except($data, ['_token', 'contact_id', 'contact']));
        DB::transaction(function () use ($contact, $additional_fields, $contact_data, $data) {
            $contact->update([
                'name' => $contact_data['name'],
                'additional_fields' => $additional_fields,
                'deal_type'=>$data['deal_type']
            ]);
            if (array_key_exists('person_img', $contact_data)) {
                if($contact->hasMedia('contact_media')){
                    $contact->clearMediaCollection('contact_media');
                }
                $contact->addMedia($contact_data['person_img'])->toMediaCollection('contact_media');
            }
            if (array_key_exists('email', $contact_data)) {
                $var_data = [];
                DB::table('contact_email')->where('contact_id',  $data['contact_id'])->delete();
                foreach ($contact_data['email'] as $key => $email) {
                    $var_data[] = [
                        'contact_id' =>  $data['contact_id'],
                        'email' => $email
                    ];
                }
                DB::table('contact_email')->insert($var_data);
            }
            if (array_key_exists('number', $contact_data)) {
                $var_data = [];
                DB::table('contact_phone')->where('contact_id',  $data['contact_id'])->delete();
                foreach ($contact_data['number'] as $key => $num) {
                    $var_data[] = [
                        'contact_id' =>  $data['contact_id'],
                        'phone_number' => $num
                    ];
                }
                DB::table('contact_phone')->insert($var_data);
            }
            if(array_key_exists('org_contact',$data)){
                foreach ($data['org_contact'] as $key => $og_contact) {
                  
                    $org_contact = Contact::where('id', $og_contact['id'])->first();
                    $org_contact->update([
                        'name' => $og_contact['name'],
                    ]);
                  
                    if (array_key_exists('person_img', $og_contact)) {
                        if($org_contact->hasMedia('contact_media')){
                            $org_contact->clearMediaCollection('contact_media');
                        }
                        $org_contact->addMedia($og_contact['person_img'])->toMediaCollection('contact_media');
                    }
                    if (array_key_exists('email', $og_contact)) {
                        $var_data = [];
                        DB::table('contact_email')->where('contact_id', $og_contact['id'])->delete();
                        foreach ($og_contact['email'] as $key => $email) {
                            $var_data[] = [
                                'contact_id' =>  $org_contact['id'],
                                'email' => $email
                            ];
                        }
                        DB::table('contact_email')->insert($var_data);
                    }
                    if (array_key_exists('number', $og_contact)) {
                        $var_data = [];
                        DB::table('contact_phone')->where('contact_id',  $og_contact['id'])->delete();
                        foreach ($og_contact['number'] as $key => $num) {
                            $var_data[] = [
                                'contact_id' =>  $og_contact['id'],
                                'phone_number' => $num
                            ];
                        }
                        DB::table('contact_phone')->insert($var_data);
                    }
                }
            }
        });
      
           
        return [
            'response' => true,
            'message' => 'Contact Updated Successfully'
        ];
    } catch (\Throwable $th) {
        return [
            'response' => false,
            'message' => $th->getMessage()
        ];
    }
       
    }

    public function getFields($type, $organization_id)
    {
        $db_name = 'organization_' . $type;
        if ($type == 'number') {
            $column_name = 'contact_number';
        } else {
            $column_name = $type;
        }

        try {
            $data = DB::table($db_name)->where('organization_id', $organization_id)->get();
            $column_value_arr = [];
            if (count($data) > 0) {
                foreach ($data as $key => $datum) {
                    $array_datum = (array)$datum;
                    array_push($column_value_arr, $array_datum[$column_name]);
                }
            }
            if (count($column_value_arr) > 1) {
                $column_value = implode(",", $column_value_arr);
            } else {
                $column_value = $column_value_arr == null ? '' : $column_value_arr[0];
            }
            return $column_value;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    public function getFieldsContact($type, $contact_id)
    {
        $db_name = 'contact_' . $type;
        if ($type == 'number') {
            $column_name = 'contact_number';
        } else {
            $column_name = $type;
        }

        try {
            $data = DB::table($db_name)->where('contact_id', $contact_id)->get();
            $column_value_arr = [];
            if (count($data) > 0) {
                if($column_name=="phone"){
                    $column_name="phone_number";
                }
                foreach ($data as $key => $datum) {
         

                    $array_datum = (array)$datum;
                    array_push($column_value_arr, $array_datum[$column_name]);
                }
            }

            if (count($column_value_arr) > 1) {
                $column_value = implode(",", $column_value_arr);
            } else {
                $column_value = $column_value_arr == null ? '' : $column_value_arr[0];
            }
            return $column_value;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
