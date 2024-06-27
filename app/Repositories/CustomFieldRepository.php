<?php

namespace App\Repositories;

use App\Models\CustomField;
use App\Models\DropdownOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomFieldRepository implements CustomFieldRepositoryInterface {
    public function store($data)
    {
        try {
            DB::transaction(function () use($data) {
                $type = $data['type'];
                $custom_field['field_name'] = $data['field_name'];
                $custom_field['type'] = $type;
                $custom_field['company_id'] = auth()->user()->company_id;
                $custom_field['field_type_id'] = (int)$data['field_type_id'];
                $custom_field['status'] = 'Show';
                $custom_field['creator_user'] = auth()->id();
                $exploded_field_name = explode(' ',$data['field_name']);
                $html_name = Str::lower(implode('_',$exploded_field_name));

                switch ($type) {
                    case 'text':
                        $html_string = '<input type="text" class="form-control" name="'.$html_name.'">';
                        $custom_field['html_element'] = $html_string;
                        break;
                    case 'dropdown':
                        $options = explode(',',$data['options']);
                        $option_string = '';
                        foreach ($options as $key => $option) {
                            $option_string .= '<option value="'.$option.'">'.$option.'</option>
                            ';
                        }

                
                        $html_string = '<select name="'.$html_name.'[]" class="form-control" id="" multiple>'.$option_string.'</select>';
                        $custom_field['html_element'] = $html_string;
                    default:
                        # code...
                        break;
                }
                $c_f = CustomField::create($custom_field);
                if (array_key_exists('options',$data)) {
                    $options_data = [];
                    foreach ( explode(',',$data['options']) as $key => $opt) {
                        $options_data[] = [
                            'custom_field_id' => $c_f['id'],
                            'option_value' => $opt
                        ];
                    }
                    DropdownOption::insert($options_data);
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
}