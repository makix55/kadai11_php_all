<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="css/style3.css">
</head>

<body style="background-color: #f9f0f6;">
    <div class="login-container">
        <h2>管理者専用ログイン</h2>

        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">データ登録</a>
                    </div>
                </div>
            </nav>
        </header>

        <!-- login_act.php に送信してログイン処理を実行 -->
        <form name="form1" action="login_act.php" method="post">
            ID: <input type="text" name="lid" required /><br>
            PW: <input type="password" name="lpw" required /><br>
            <input type="submit" value="LOGIN" />
        </form>
    </div>
</body>

</html>