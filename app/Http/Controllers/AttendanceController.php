<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;


class AttendanceController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function attendancein(Request $request)
    {
        $form = $request->all();
        unset($form['_token_']);
        Attendance::create($form);
        return redirect('/index');
    }
}
