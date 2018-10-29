<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolData extends Model
{
    protected $table = 'tbldata';
    public $timestamps = false;
    protected $primaryKey = 'SRID';


    public function work_by()
    {
        return $this->belongsTo('App\UserMaster', 'WORK_DONE_BY');
    }
}
