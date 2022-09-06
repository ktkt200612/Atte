@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="css/date.css">
  <header class="header">
    <h1 class = "header__title">Atte</h1>
    <nav class="header_nav">
      <ul>
        <li class="header__nav--list"><a href="/index">ホーム</a></li>
        <li class="header__nav--list"><a href="/date">日付一覧</a></li>
        <li class="header__nav--list">
          <form method="POST" action="{{ route('logout') }}">
          @csrf
            <x-dropdown-link :href="route('logout')"
              onclick="event.preventDefault();
              this.closest('form').submit();">
              {{ __('ログアウト') }}
            </x-dropdown-link>
          </form></a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <div class="date">
      <form action="/date" method="POST">
      @csrf
        <input type="hidden"  name="date" value="{{ $date }}">
        <input type="submit" class="date__button" name="before" value="<">
      </form>
      <p class="date--today">{{ $date }}</p>
      <form action="/date" method="POST">
      @csrf
        <input type="hidden"  name="date" value="{{ $date }}">
        <input type="submit" class="date__button" name="next" value=">">
      </form>
    </div>
    <div class="wrapper">
      <table class="attendance">
        <tr>
          <th>名前</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr>
          <td>{{$attendance->user->name}}</td>
          <td>{{$attendance->attendance_in}}</td>
          <td>{{$attendance->attendance_out}}</td>
          <td>{{$attendance->rest_time}}</td>
          <td>{{$attendance->work_time}}</td>
        </tr>
        @endforeach
      </table>
    </div>
    <div>
      {{ $attendances->appends(compact("date", "attendances"))->links('pagination::bootstrap-4') }}
    </div>
  </div>
  <footer>
    Atte,inc.
  </footer>
@endsection
