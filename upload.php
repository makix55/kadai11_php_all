<?php
session_start();
require_once('funcs.php');
loginCheck();  // ログインチェックを追加

// CSVファイルがアップロードされた場合
if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['upload_file']['tmp_name'];

    // CSVを開く
    if (($handle = fopen($fileTmpPath, 'r')) !== false) {
        // ヘッダー行をスキップ
        $header = fgetcsv($handle);

        // データベース接続
        $pdo = db_conn();

        // CSVの各行を読み込んでデータベースに挿入
        while (($row = fgetcsv($handle)) !== false) {
            // 文字コードを UTF-8 に変換（CSVが Shift_JIS の場合）
            $row = array_map(function ($value) {
                return mb_convert_encoding($value, 'UTF-8', 'SJIS-win');
            }, $row);

            // 必要なデータを取得
            $category = $row[13] ?? '';
            $teacher_name = $row[14] ?? '';
            $teacher_contact = $row[15] ?? '';
            $reception_no = $row[0] ?? '';

            // SQLの準備
            $sql = "UPDATE gs_bm_table SET 
                        category = :category, 
                        teacher_name = :teacher_name, 
                        teacher_contact = :teacher_contact
                    WHERE id = :no";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
            $stmt->bindValue(':teacher_name', $teacher_name, PDO::PARAM_STR);
            $stmt->bindValue(':teacher_contact', $teacher_contact, PDO::PARAM_STR);
            $stmt->bindValue(':no', $reception_no, PDO::PARAM_INT);

            // 実行
            $stmt->execute();
        }

        // ファイルを閉じる
        fclose($handle);
    }
}

// アップロード完了後に select.php へリダイレクト
header("Location: select.php");
exit;
