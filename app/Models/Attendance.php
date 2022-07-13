<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;


    protected $guarded = [
        'id'
    ];
    //ホワイトリスト.$fillableに指定したカラムのみ、create()やfill()、update()で値が代入されます。
    //ブラックリスト。$guardedに指定したカラムのみ、create()やfill()、update()で値が代入されません。
    public function user(){ 
        return $this->belongsTo('App\Models\User');
    }

}
