<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>stamp.png</title>
</head>
<body>
  <h1>Atte</h1>
  <nav>
    <ul>
      <li><a href="/date">日付一覧</a></li>
    </ul>
  </nav>

  <form action="/attendancein" method="POST">
  @csrf
    <div>
      <input type="submit"  value="勤務開始">
    <div>
  </form>
  <form action="/attendanceout" method="POST">
  @csrf
    <div>
      <input type="submit"  value="勤務終了">
    <div>
  </form>
  <form action="/restin" method="POST">
  @csrf
    <div>
      <input type="submit"  value="休憩開始">
    <div>
  </form>
  <form action="/restout" method="POST">
  @csrf
    <div>
      <input type="submit"  value="休憩終了">
    <div>
  </form>  
</body>
</html>
