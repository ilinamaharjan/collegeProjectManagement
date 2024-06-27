<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Contact;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ContactImport implements  ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $userId=auth()->id();
            if($row[9]!=null){
                $user=User::where('username',$row[9])->first();
                if($user!=null){
                    $userId=$user->id;
                }
            }
            $orgId=null;
            $isPrimary=1;
            if($row[5]!=null){
                $org=Organization::where('name',$row[5])->where('company_id' ,auth()->user()->company_id)->first();
                if($org){
                    $orgId=$org;
                    $isPrimary=0;
                }else{
                    $organization=Organization::create([
                        'name'=>$row[5],
                        'company_id' => auth()->user()->company_id,
                        "creator_user" => $userId,
                        "deal_type" => $row[1],
                    ]);
                    $orgId=$organization;
                    if ($row[6]!=null) {
                        $org_email= DB::table('organization_email')->where('organization_id',$orgId['id'])->where('email',$row[6])->first();
                        if(!$org_email){
                            DB::table('organization_email')->insert([
                                'organization_id' => $organization->id,
                                'email' => $row[6]
                            ]);
                        }
                    }
                    if ($row[7]!=null) {
                        $org_contact_num= DB::table('organization_number')->where('organization_id',$orgId['id'])->where('contact_number',$row[7])->first();
                        if(!$org_contact_num){
                            DB::table('organization_number')->insert([
                                'organization_id' => $organization->id,
                                'contact_number' =>  $row[7]
                            ]);
                        }
                    }
                    if ($row[8]!=null) {
                        $org_address= DB::table('organization_address')->where('organization_id',$orgId['id'])->where('address',$row[8])->first();
                        if(!$org_address){
                        DB::table('organization_address')->insert([
                            'organization_id' => $organization->id,
                            'address' => $row[8]
                        ]);
                        }
                    }
                }
            }
            $old_contact=Contact::where('name',$row[2])->where('organization_id',$orgId['id'])->where('company_id', auth()->user()->company_id)->first();
            if($old_contact){
                $newContactId=$old_contact['id'];
            }else{
                $contact=Contact::create([
                    "name" => $row[2],
                    "organization_id" =>$orgId['id'],
                    "company_id" => auth()->user()->company_id,
                    "creator_user" => $userId,
                    "status" => "Active",
                    "created_at" => now(),
                    "updated_at" =>now(),
                    "is_primary" =>$isPrimary,
                    "deal_type" =>$orgId!=null ? $orgId['deal_type']:$row[1],
                ]);
                $newContactId=$contact['id'];
            }
            if($row[3]!=null){
                $contact_email= DB::table('contact_email')->where('contact_id',$newContactId)->where('email',$row[3])->first();
                if(!$contact_email){
                    DB::table('contact_email')->insert([
                        'contact_id' => $newContactId,
                        'email' => $row[3]
                    ]);
                }
            }
                    
            if($row[4]!=null) {
                $contact_phone= DB::table('contact_phone')->where('contact_id',$newContactId)->where('phone_number',$row[4])->first();
                if(!$contact_phone){
                    DB::table('contact_phone')->insert([
                        'contact_id' => $newContactId,
                        'phone_number' => $row[4]
                    ]);
                }
            }
        }
    }



    public function startRow(): int
    {
        return 2;
    }
}
