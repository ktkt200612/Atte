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
        $time = Carbon::now()->toTimeString();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first(); // $user->idと同じuser_idをもつログインユーザーのAttendanceの最新のレコードのみを取得
        
        $form = [
            'attendance_id' => $latestAttendance->id,
            'rest_in' => $time,
        ];
        Rest::create($form);//Restクラスという型に沿って、データを作成
        return redirect('/index');
    }

    public function restout()
    {
        $user = Auth::user();//Authのuserカラム全て取得
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first(); //ログイン中のユーザーのidと一致するidをもつユーザーの、Attendanceの最新のレコードのみを取得(restとuserは直接繋がっていないため、Attendanceから検索)
        $attendanceId = $latestAttendance->id;
        $latestRest = Rest::where('attendance_id', $attendanceId)->latest()->first(); //このattendance_idを持つrestの最新のレコードのみを取得
        $latestRest->update([
            'rest_out' => Carbon::now()->toTimeString()
        ]);     //$restの中のrest_outを書き換える
        return redirect('/index');
    }
}
