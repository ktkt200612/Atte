<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function index()
    {
        $date = Carbon::today()->format('Y-m-d');
        $user = Auth::user();
        $pastRest = Rest::getPastRest();
        $pastAttendance = Attendance::getPastAttendance();
        $latestAttendance = Attendance::getLatestAttendance();
        
        // 休憩したまま日を跨いだ場合、rest_outを'23:59:59'に更新 
        if (($pastRest)  && $pastRest->rest_out == null) {
            $pastRest->update([
                'rest_out' => '23:59:59',
            ]);
        }

        // 出勤したまま日を跨いだ場合、attendance_outを'23:59:59'に更新
        // attendance_outに'23:59:59'が入ったら、出勤中を継続するため日を跨いだ当日の'attendance_in'に'00:00:00'を格納する
        if (($pastAttendance) && $pastAttendance->attendance_out == null) {
            $pastAttendance->update([
                'attendance_out' => '23:59:59',
            ]);
            Attendance::create([
                'user_id' => $user->id,
                'date'  => $date,
                'attendance_in' => '00:00:00',
            ]);            
        }

        $attendance_in = false;
        $attendance_out = false;
        $rest_in = false;
        $rest_out = false;
        
        if ($latestAttendance !== null ) { //勤務データがあり
            if ($latestAttendance->attendance_out == null ) {//退勤データがなく
                $rest = Rest::where('attendance_id', $latestAttendance->id)->latest()->first();
                if ($rest!== null ) { //休憩データがあり
                    if ($rest->rest_out !== null) { // 休憩終了していて
                        $attendance_out = true;
                        $rest_in = true;
                    } else { // 休憩中で                        
                        $rest_out = true;
                    }
                }else{//勤務データがなく
                    $attendance_out = true;
                    $rest_in = true;
                }
            }
        }else{
            $attendance_in = true;    
        }

        $btn = [
            'attendance_in' => $attendance_in,
            'attendance_out' => $attendance_out,
            'rest_in' => $rest_in,
            'rest_out' => $rest_out,
        ];
        return view('index', ['btn' => $btn]);
    }
    public function attendancein()
    {
        $user = Auth::user();
        $date = Carbon::today()->format('Y-m-d');
        $time = Carbon::now()->toTimeString();
        $form = [
            'user_id' => $user->id,
            'date'  => $date,
            'attendance_in' => $time,
        ];
        Attendance::create($form);
        return redirect('/index');
    }

    public function attendanceout()
    {
        $date = Carbon::today()->format('Y-m-d');
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->whereDate('date',$date)->latest()->first();
        $latestAttendance->update([
            'attendance_out' => Carbon::now()->toTimeString()
        ]);
        return redirect('/index');
    }

    public function dateindex(Request $request)
    {
        $date = $request->input("date")?: Carbon::today()->format("Y-m-d");
        $attendances = Attendance::whereDate('date', $date)->paginate(5);
        foreach ($attendances as $attendance) {
            $rests = $attendance->rests;
            $total_rest_time = 0; 
            foreach ($rests as $rest) {
                $total_rest_time = $total_rest_time + strtotime($rest->rest_out) - strtotime($rest->rest_in);
            }
            $rest_hour = floor($total_rest_time / 3600); // 時を算出（1時間＝300秒）
            $rest_minute = floor(($total_rest_time / 60) % 60); // 分を算出（1分＝60秒）
            $rest_seconds = floor($total_rest_time % 60); //秒を算出
            $attendance->rest_time = sprintf('%02d:%02d:%02d', $rest_hour, $rest_minute, $rest_seconds);

            $restraint_time = strtotime($attendance->attendance_out) - strtotime($attendance->attendance_in);//就業開始時間と就業終了時間の差(拘束時間)
            $total_work_time = $restraint_time - $total_rest_time;//拘束時間と合計休憩時間の差
            $work_hour = floor($total_work_time / 3600);
            $work_minute = floor(($total_work_time / 60) % 60);
            $work_second = floor($total_work_time % 60);
            $attendance->work_time = sprintf('%02d:%02d:%02d', $work_hour, $work_minute, $work_second);
        }
        return view('date', compact("date", "attendances"));
    }

    public function otherday(Request $request)
    {
        // 一日前（'>'ボタン
        if ($request->input('before') != null) {
            $date = date('Y-m-d', strtotime('-1day', strtotime($request->input('date'))));
            $attendances = Attendance::whereDate('date', $date)->paginate(5);
        }
        // 一日後（'>'ボタン）
        if ($request->input('next')  != null) {
            $date = date('Y-m-d', strtotime('+1day', strtotime($request->input('date'))));
            $attendances = Attendance::whereDate('date', $date)->paginate(5);
        }

        foreach ($attendances as $attendance) {
            $rests = $attendance->rests;
            $total_rest_time = 0;
            foreach ($rests as $rest) {
                $total_rest_time = $total_rest_time + strtotime($rest->rest_out) - strtotime($rest->rest_in);
            }
            $rest_hour = floor($total_rest_time / 3600); // 時を算出（1時間＝300秒）
            $rest_minute = floor(($total_rest_time / 60) % 60); // 分を算出（1分＝60秒）
            $rest_seconds = floor($total_rest_time % 60); //秒を算出
            $attendance->rest_time = sprintf('%02d:%02d:%02d', $rest_hour, $rest_minute, $rest_seconds);
            $restraint_time = strtotime($attendance->attendance_out) - strtotime($attendance->attendance_in);//就業開始時間と就業終了時間の差(拘束時間)
            $total_work_time = $restraint_time - $total_rest_time; //拘束時間と合計休憩時間の差
            $work_hour = floor($total_work_time / 3600);
            $work_minute = floor(($total_work_time / 60) % 60);
            $work_second = floor($total_work_time % 60);
            $attendance->work_time = sprintf('%02d:%02d:%02d', $work_hour, $work_minute, $work_second);
        }
        return view('date', compact("date", "attendances"));
    } 
}
