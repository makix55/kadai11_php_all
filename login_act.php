<?php
session_start();

// POST値を受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

// 1. DB接続
require_once('funcs.php');
$pdo = db_conn();

// 2. データ登録SQL作成
// gs_user_tableに、IDとPWがあるか確認する。
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid = :lid;');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->execute();

// 3. SQL実行時にエラーがある場合STOP
if ($stmt->errorCode() !== '00000') {
    // エラー発生時の処理（例えばログ出力など）
    echo "データベースエラー: " . $stmt->errorInfo()[2];
    exit();
}

// 4. 抽出データ数を取得
$val = $stmt->fetch();

// パスワードが正しいか確認
if ($val['id'] != '') {
    // パスワードが一致した場合（管理者と閲覧者の区別をする）
    $_SESSION['chk_ssid'] = session_id(); // セッションIDを保存
    $_SESSION['kanri_flg'] = $val['kanri_flg']; // 管理者フラグをセッションに保存

    if ($val['kanri_flg'] == 1) {
        // 管理者の場合
        header('Location: admin_dashboard.php'); // 管理者用ダッシュボードにリダイレクト
    } else {
        // 閲覧者の場合
        header('Location: viewer_dashboard.php'); // 閲覧者用ダッシュボードにリダイレクト
    }
} else {
    // Login失敗時（Logout経由）
    header('Location: login.php'); // ログインページにリダイレクト
}
exit();


