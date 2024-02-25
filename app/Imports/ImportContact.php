<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class ImportContact implements ToModel
{
    public function  __construct($tagid)
    {
        $this->tagid    = $tagid;
    }

    public function model(array $row)
    {
        if($row[1] != 'NOMOR' && $row[1] != ''){
            

            $number = preg_replace('/\D/', '', $row[1]);
            if(substr($number,0,1) == '0'){
                $number = str_replace_first('0', '62', $number);
            }

            return new Contact([
                'tag_id'    => $this->tagid,
                'user_id'   => auth()->user()->id,
                'name'      => $row[0],
                'number'    => $number
            ]);
        }
    }
}
