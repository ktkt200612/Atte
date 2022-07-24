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
        $time = Carbon::now()->toTimeString();
        
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
            'attendance_out' => Carbon::now()->toTimeString()
        ]);     //$attendanceの中のattendance_outを書き換える
        return redirect('/index');
    }

    public function dateindex(Request $request)
    {
        $date = Carbon::today()->format("Y-m-d");   
        $attendances = Attendance::where('date', $date)->paginate(5);
        foreach ($attendances as $attendance) {
            $rests = $attendance->rests; // このループのattendanceのidを持つrestデータを取得
            foreach ($rests as $rest) {
                $total_rest_time = strtotime($rest->rest_out) - strtotime($rest->rest_in); //計算する時はstrtotimeで秒に変換
            }

            $rest_hour = floor($total_rest_time / 3600); // 時を算出（1時間＝300秒）
            $rest_minute = floor(($total_rest_time / 60) % 60); // 分を算出（1分＝60秒）
            $rest_seconds = floor($total_rest_time % 60); //秒を算出
            $attendance->rest_time = sprintf('%02d:%02d:%02d', $rest_hour, $rest_minute, $rest_seconds);//sprintf関数で第一引数に指定したフォーマットで文字列を生成。$attendanceの中にrest_timeを作って、そこに、、、

            $restraint_time = strtotime($attendance->attendance_out) - strtotime($attendance->attendance_in);//就業開始時間と就業終了時間の差(拘束時間)
            $total_work_time = $restraint_time - $total_rest_time;//拘束時間と合計休憩時間の差

            $work_hour = floor($total_work_time / 3600);
            $work_minute = floor(($total_work_time / 60) % 60);
            $work_second = floor($total_work_time % 60);
            $attendance->work_time = sprintf('%02d:%02d:%02d', $work_hour, $work_minute, $work_second);
        }
        
        return view('date', ['today'=>$date, 'attendances' => $attendances]);
    }

    public function otherday(Request $request)
    {
        // 一日前（'>'ボタン）//date関数で日にちのみを取り出す
        if ($request->input('before') != null) {
            $date = date('Y-m-d', strtotime('-1day', strtotime($request->input('date'))));
            $attendances = Attendance::where('date', $date)->paginate(5);
        } //https://helog.jp/php/strtotime/　　　https://wepicks.net/phpfunction-date-strtotime/ (参考)
        
        // 一日後（'>'ボタン）
        if ($request->input('next')  != null) {
            $date = date('Y-m-d', strtotime('+1day', strtotime($request->input('date'))));
            $attendances = Attendance::where('date', $date)->paginate(5);
        }
        //↑同一フォームで複数のsubmitが送られてきている為、if ($request->input('　')  != null) {}で分ける

        foreach ($attendances as $attendance) {
            $rests = $attendance->rests;
            foreach ($rests as $rest) {
                $total_rest_time = strtotime($rest->rest_out) - strtotime($rest->rest_in); //strtotimeで秒に変換
            }
            $rest_hour = floor($total_rest_time / 3600); // 時を算出（1時間＝300秒）
            $rest_minute = floor(($total_rest_time / 60) % 60); // 分を算出（1分＝60秒）
            $rest_seconds = floor($total_rest_time % 60); //秒を算出
            $attendance->rest_time = sprintf('%02d:%02d:%02d', $rest_hour, $rest_minute, $rest_seconds);//sprintf関数で第一引数に指定したフォーマットで文字列を生成。$attendanceの中にrest_timeを作って、そこに、、、
            
            $restraint_time = strtotime($attendance->attendance_out) - strtotime($attendance->attendance_in);//就業開始時間と就業終了時間の差(拘束時間)
            $total_work_time = $restraint_time - $total_rest_time; //拘束時間と合計休憩時間の差
            
            $work_hour = floor($total_work_time / 3600);
            $work_minute = floor(($total_work_time / 60) % 60);
            $work_second = floor($total_work_time % 60);
            $attendance->work_time = sprintf('%02d:%02d:%02d', $work_hour, $work_minute, $work_second);
        }
        
        return view('date', ['today'=>$date, 'attendances' => $attendances]);
    }

    
}
