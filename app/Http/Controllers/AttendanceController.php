<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function attendancein()
    {
        $user = Auth::id();//Authのidのみ取得）
        $date = Carbon::today()->format('Y-m-d');
        $time = Carbon::now();
        
        $form = [
            'user_id' => $user,
            'date'  => $date,
            'attendance_in' => $time,
        ];
        Attendance::create($form);
        return redirect('/index');
    }

    public function attendanceout()
    {
        $user = Auth::user();//Authのuserカラム全て取得(userのとこがidならidのみ取得)
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first(); //このログインユーザーのAttendanceの最新のレコードのみを取得
        $latestAttendance->update([
            'attendance_out' => Carbon::now()
        ]);     //$attendanceの中のattendance_outを書き換える
        return redirect('/index');
    }

    
}
