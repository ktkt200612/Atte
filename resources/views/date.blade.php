<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>日付一覧</title>
</head>
<body>
  <h1>Atte</h1>

  <form action="/date" method="POST">
  @csrf
    <input type="hidden"  name="date" value="{{ $today }}">
    {{-- 表示中の日付の隠しデータを送る↑ --}}
    <input type="submit"  name="before" value="<">
  </form>
  <p>{{ $today }}</p>
  <form action="/date" method="POST">
  @csrf
    <input type="hidden"  name="date" value="{{ $today }}">
    <input type="submit"  name="next" value=">">
  </form>

  <div>
    <table>
      <tr>
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
      </tr>
      @foreach($attendances as $attendance)
      <tr>
        <td>{{$attendance->user->name}}</td> {{-- //FK効果 --}}
        <td>{{$attendance->attendance_in}}</td>
        <td>{{$attendance->attendance_out}}</td>
        <td>{{$attendance->rest_time}}</td>
        <td>{{$attendance->work_time}}</td>
      </tr>
      @endforeach
    </table>
    <div>
      {{ $attendances->links('pagination::bootstrap-4') }}
    </div>
  </div>
</body>
</html>
