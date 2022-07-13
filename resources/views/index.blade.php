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
  <form action="/attendancein" method="POST">
  @csrf
    <div>
      <input type="submit"  value="勤務開始"　>
    <div>
  </form>
  <form action="/attendanceout" method="POST">
  @csrf
    <div>
      <input type="submit"  value="勤務終了"　>
    <div>
  </form>
  
</body>
</html>
