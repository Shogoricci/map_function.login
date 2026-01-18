<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新規登録</title>
    <style>
        body { background: #0b1117; color: #fff; text-align: center; padding-top: 50px; }
        .box { display: inline-block; background: #161b22; padding: 30px; border: 1px solid #30363d; border-radius: 8px; }
        input { display: block; width: 250px; padding: 10px; margin: 15px 0; background: #0d1117; color: #fff; border: 1px solid #30363d; }
        input[type="submit"] { background: #58a6ff; color: #000; font-weight: bold; cursor: pointer; border: none; }
    </style>
</head>
<body>
    <h1>CREATE NEW USER</h1>
    <div class="box">
        <form action="user_insert.php" method="post">
            名前：<input type="text" name="name" required>
            ログインID：<input type="text" name="lid" required>
            パスワード：<input type="password" name="lpw" required>
            <input type="submit" value="登録する">
        </form>
        <a href="login.php" style="color:#58a6ff;">ログイン画面へ</a>
    </div>
</body>
</html>