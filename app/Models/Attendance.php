<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;


    protected $guarded = [
        'id', 'user_id', 'date',  'attendance_in',  'attendance_out','created_at', 'updated_at'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User');
    }

}
