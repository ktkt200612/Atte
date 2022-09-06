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
        $date = Carbon::today()->format('Y-m-d');
        $user= Auth::user();
        $time = Carbon::now()->toTimeString();
        $latestAttendance = Attendance::where('user_id', $user->id)->whereDate('date',$date)->latest()->first();
        
        $form = [
            'attendance_id' => $latestAttendance->id,
            'rest_in' => $time,
        ];
        Rest::create($form);
        return redirect('/index');
    }

    public function restout()
    {
        $date = Carbon::today()->format('Y-m-d');
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->whereDate('date',$date)->latest()->first();
        $attendanceId = $latestAttendance->id;
        $latestRest = Rest::where('attendance_id', $attendanceId)->latest()->first();
        $latestRest->update([
            'rest_out' => Carbon::now()->toTimeString()
        ]);
        return redirect('/index');
    }
}
