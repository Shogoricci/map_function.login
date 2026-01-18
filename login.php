<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <style>
        body { background: #0b1117; color: #fff; font-family: sans-serif; text-align: center; padding-top: 100px; }
        .login-box { display: inline-block; background: #161b22; padding: 40px; border: 1px solid #58a6ff; border-radius: 12px; }
        input { display: block; width: 300px; padding: 12px; margin: 15px 0; background: #0d1117; color: #fff; border: 1px solid #30363d; }
        input[type="submit"] { background: #58a6ff; color: #000; font-weight: bold; cursor: pointer; border: none; }
        a { color: #58a6ff; text-decoration: none; }
    </style>
</head>
<body>
    <h1>NEO-MARK LOGIN</h1>
    <div class="login-box">
        <form action="login_act.php" method="post">
            <input type="text" name="lid" placeholder="ログインID">
            <input type="password" name="lpw" placeholder="パスワード">
            <input type="submit" value="ログイン">
        </form>
        <p><a href="user.php">新規ユーザー登録</a></p>
    </div>
</body>
</html>