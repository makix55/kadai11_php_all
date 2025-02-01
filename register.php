<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>

<body>
    <h2>ユーザー登録</h2>
    <form action="register_action.php" method="POST">
        <label for="username">ユーザー名：</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">パスワード：</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">登録</button>
    </form>
</body>

</html>