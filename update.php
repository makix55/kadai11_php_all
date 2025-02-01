<?php
session_start();
require_once('funcs.php');
$pdo = db_conn();

// 管理者フラグをセッションから取得
$kanri_flg = isset($_SESSION['kanri_flg']) ? $_SESSION['kanri_flg'] : 0;  // 管理者フラグがセットされていなければ閲覧者とする

// POSTまたはGETでIDを取得
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームが送信された場合の処理
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $address = $_POST['address'];
    $station = $_POST['station'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $fax = $_POST['fax'];
    $teacher = $_POST['teacher'];
    $schedule = $_POST['schedule'];
    $soroteacher = $_POST['soroteacher'];
    $content = $_POST['content'];
    $category = $_POST['category'];  // 区分（category）
    $teacher_name = $_POST['teacher_name'];  // 講師名
    $teacher_contact = $_POST['teacher_contact'];  // 講師連絡先

    // データ更新
    $stmt = $pdo->prepare("UPDATE gs_bm_table SET name = :name, code = :code, address = :address, station = :station, email = :email, tel = :tel, fax = :fax, teacher = :teacher, schedule = :schedule, soroteacher = :soroteacher, content = :content, category = :category, teacher_name = :teacher_name, teacher_contact = :teacher_contact WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':code', $code, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':station', $station, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindValue(':fax', $fax, PDO::PARAM_STR);
    $stmt->bindValue(':teacher', $teacher, PDO::PARAM_STR);
    $stmt->bindValue(':schedule', $schedule, PDO::PARAM_STR);
    $stmt->bindValue(':soroteacher', $soroteacher, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);  // 区分（category）
    $stmt->bindValue(':teacher_name', $teacher_name, PDO::PARAM_STR);  // 講師名
    $stmt->bindValue(':teacher_contact', $teacher_contact, PDO::PARAM_STR);  // 講師連絡先
    $status = $stmt->execute();

    // 更新成功した場合、管理者と閲覧者で遷移先を分ける
    if ($status) {
        // 管理者の場合、select.phpにリダイレクト
        if ($kanri_flg == 1) {
            header("Location: select.php?updated=true");  // 更新完了のメッセージを表示するため
        } else {
            // 閲覧者の場合、viewer_dashboard.phpにリダイレクト
            header("Location: viewer_dashboard.php");
        }
        exit;
    } else {
        echo "更新に失敗しました。";
    }
} else {
    // GETでIDを取得してデータを取得
    $id = $_GET['id'];

    // IDに基づいたデータを取得
    $stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status === false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery: " . $error[2]);
    } else {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>データ編集</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="main">
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="select.php">データ一覧</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h2>講師派遣申込内容編集ページ</h2>

        <!-- 編集フォーム -->
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= h($row['id']) ?>">

            <div>
                <label for="name">学校名:</label>
                <input type="text" id="name" name="name" value="<?= h($row['name']) ?>">
            </div>
            <div>
                <label for="code">郵便番号:</label>
                <input type="text" id="code" name="code" value="<?= h($row['code']) ?>">
            </div>
            <div>
                <label for="address">所在地:</label>
                <input type="text" id="address" name="address" value="<?= h($row['address']) ?>">
            </div>
            <div>
                <label for="station">最寄駅・バス停:</label>
                <input type="text" id="station" name="station" value="<?= h($row['station']) ?>">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= h($row['email']) ?>">
            </div>
            <div>
                <label for="tel">電話番号:</label>
                <input type="text" id="tel" name="tel" value="<?= h($row['tel']) ?>">
            </div>
            <div>
                <label for="fax">FAX番号:</label>
                <input type="text" id="fax" name="fax" value="<?= h($row['fax']) ?>">
            </div>
            <div>
                <label for="teacher">担当の先生名:</label>
                <input type="text" id="teacher" name="teacher" value="<?= h($row['teacher']) ?>">
            </div>
            <div>
                <label for="schedule">授業希望日:</label>
                <input type="text" id="schedule" name="schedule" value="<?= h($row['schedule']) ?>">
            </div>
            <div>
                <label for="soroteacher">希望の講師:</label>
                <input type="text" id="soroteacher" name="soroteacher" value="<?= h($row['soroteacher']) ?>">
            </div>
            <div>
                <label for="content">その他ご要望:</label>
                <textarea id="content" name="content"><?= h($row['content']) ?></textarea>
            </div>
            <!-- 追加部分 -->
            <div>
                <label for="category">区分:</label>
                <select id="category" name="category">
                    <option value="東" <?= $row['category'] == '東' ? 'selected' : ''; ?>>東</option>
                    <option value="全" <?= $row['category'] == '全' ? 'selected' : ''; ?>>全</option>
                    <option value="学" <?= $row['category'] == '学' ? 'selected' : ''; ?>>学</option>
                    <option value="その他" <?= $row['category'] == 'その他' ? 'selected' : ''; ?>>その他</option>
                    <option value="断" <?= $row['category'] == '断' ? 'selected' : ''; ?>>断</option>
                </select>
            </div>
            <div>
                <label for="teacher_name">講師名:</label>
                <input type="text" id="teacher_name" name="teacher_name" value="<?= h($row['teacher_name']) ?>">
            </div>
            <div>
                <label for="teacher_contact">講師連絡先:</label>
                <input type="text" id="teacher_contact" name="teacher_contact" value="<?= h($row['teacher_contact']) ?>">
            </div>
            <!-- ここまで追加 -->

            <div>
                <button type="submit">更新</button>
            </div>
        </form>
    </div>
</body>

</html>