<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function attendance(){ 
        return $this->belongsTo('App\Models\Attendance');
    }

    public static function getPastRest() //休憩したまま日を跨いだ場合に使用する関数
    {
        $date = Carbon::today()->format('Y-m-d');
        $pastRest = Rest::latest()->first();
        if (($pastRest) && $pastRest->created_at < $date) {
        return $pastRest;
        }
    }
}
