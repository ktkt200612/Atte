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
        $user = Auth::user();
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
        $user = Auth::user();
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
}
