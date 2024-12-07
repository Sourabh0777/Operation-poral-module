<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Jobwork extends Model
{
    use HasFactory,SoftDeletes;  
    public static function getPossibleEnumValues(){
        // $results  = DB::select('SHOW COLUMNS FROM users WHERE Field = "emp_type"');
        $type = DB::select('SHOW COLUMNS FROM jobworks WHERE Field = "jobtype"')[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;
    }
    public function client()
    {
        return $this->belongsTo(Client::class); 
       
    }
    public function jobassign()
    {
        return $this->hash(Jobassign::class); 
       
    }
    
}
