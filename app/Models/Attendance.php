<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User');
    }
    public function rests(){
    return $this->hasMany('App\Models\Rest');
    }

    public static function getPastAttendance() //出勤したまま日を跨いだ場合に使用する関数
    {
        $user = Auth::id();
        $date = Carbon::today()->format('Y-m-d');
        $pastAttendance = Attendance::where('user_id',$user)->latest()->first();
        if (($pastAttendance) && $pastAttendance->date < $date) {
        return $pastAttendance;
        }
    }

    public static function getLatestAttendance() //ボタン押し条件分岐に使用する関数
    {
        $user = Auth::id();
        $date = Carbon::today()->format('Y-m-d');
        $latestAttendance = Attendance::where('user_id',$user)->whereDate('date',$date)->latest()->first();
        return $latestAttendance;
    }
}
