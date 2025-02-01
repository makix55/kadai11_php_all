<?php
session_start();
require_once('funcs.php');
loginCheck();  // ログインチェックを追加

// データベース接続
$pdo = db_conn();

// SQL作成
$sql = "SELECT * FROM gs_bm_table WHERE is_deleted = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// データ取得
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CSV出力
header('Content-Type: text/csv; charset=SJIS-win');  // CSVの文字コードをSJISに指定
header('Content-Disposition: attachment; filename="data_export.csv"');

// ファイルを出力するためのハンドル
$output = fopen('php://output', 'w');

// ヘッダー行をSJISに変換してCSVに書き込む
$header = array('受付No.', '学校名', '郵便番号', '所在地', '最寄駅・バス停', 'Email', '電話番号', 'FAX番号', '担当の先生名', '授業希望日', '希望の講師', 'その他ご要望', '登録日', '区分', '講師名', '講師連絡先');
$header = array_map(function ($value) {
    return mb_convert_encoding($value, 'SJIS-win', 'UTF-8'); // SJISに変換
}, $header);
fputcsv($output, $header);

// データ行をSJISに変換してCSVに書き込む
foreach ($result as $row) {
    // データ部分もSJISに変換してから出力
    $row = array_map(function ($value) {
        return mb_convert_encoding($value, 'SJIS-win', 'UTF-8'); // SJISに変換
    }, $row);
    fputcsv($output, $row);
}

// ファイルのクローズ
fclose($output);
exit;
