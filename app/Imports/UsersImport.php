<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'      => $row[0],
            'f_name'    => strtoupper($row[1]),
            'email'     => $row[2], 
            'division'  => $row[3],   
            'position'  => $row[4],   
            'password'  => \Hash::make('12345678'),
        ]);
    }
}
