<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // フォームから送信されたパスワードを取得
    $password = $_POST['password'] ?? '';

    // パスワードが空でないかチェック
    if (!empty($password)) {
        // パスワードをハッシュ化
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

        // ハッシュ化されたパスワードを表示（デバッグ用）
        echo "ハッシュ化されたパスワード: " . htmlspecialchars($hashed_pw) . "<br>";

        // パスワード検証
        echo "<pre>";
        echo "検証結果（正しいパスワードの場合）: ";
        var_dump(password_verify($password, $hashed_pw));
        echo "</pre>";
    } else {
        echo "パスワードを入力してください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワードハッシュ化テスト</title>
</head>

<body>
    <h2>パスワードハッシュ化テスト</h2>
    <form action="" method="post">
        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">送信</button>
    </form>
</body>

</html>