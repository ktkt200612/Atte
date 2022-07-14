<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Rest;

class RestController extends Controller
{
    public function restin()
    {
        $user= Auth::user();
        $time = Carbon::now();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first(); // このログインユーザーのAttendanceの最新のレコードのみを取得
        
        $form = [
            'attendance_id' => $latestAttendance->id,
            'rest_in' => $time,
        ];
        Rest::create($form);
        return redirect('/index');
    }

    public function restout()
    {
        $user = Auth::user();//Authのuserカラム全て取得
        $rest = Rest::where('user_id', $user->id)->latest()->first(); //このログインユーザーのRestの最新のレコードのみを取得
        
        $rest->update([
            'rest_out' => Carbon::now()
        ]);     //$restの中のrest_outを書き換える
        return redirect('/index');
    }
}
