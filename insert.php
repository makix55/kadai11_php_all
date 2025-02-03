<?php
// 1. POSTデータ取得
$name = $_POST['name'];
$code = $_POST['code'];
$address = $_POST['address'];
$station = $_POST['station'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$fax = $_POST['fax'];
$teacher = $_POST['teacher'];
$schedule = isset($_POST['schedule']) ? implode(',', $_POST['schedule']) : ''; // 配列をカンマ区切りの文字列に変換
$soroteacher = $_POST['soroteacher'];
$content = isset($_POST['content']) ? $_POST['content'] : '特になし';  // 空の場合、デフォルト値を設定
$category = isset($_POST['category']) ? $_POST['category'] : '未設定';
$teacher_name = isset($_POST['teacher_name']) ? $_POST['teacher_name'] : '未設定';
$teacher_contact= isset($_POST['teacher_contact']) ? $_POST['teacher_contact'] : '未設定';

// 2. DB接続
require_once('funcs.php');
$pdo = db_conn();

// 3. データ登録SQL作成
$stmt = $pdo->prepare(
  'INSERT INTO gs_bm_table (
        name, code, address, station, email, tel, fax, teacher, schedule, soroteacher, content, category, teacher_name,  teacher_contact, date
    ) VALUES (
        :name, :code, :address, :station, :email, :tel, :fax, :teacher, :schedule, :soroteacher, :content, :category, :teacher_name,  :teacher_contact, now()
    )'
);

// バインド変数を設定
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
$stmt->bindValue(':category', $teacher_name, PDO::PARAM_STR);
$stmt->bindValue(':teacher_name', $teacher_name, PDO::PARAM_STR);
$stmt->bindValue(':teacher_contact', $teacher_name, PDO::PARAM_STR);

// 実行
$status = $stmt->execute();

// SQL実行後にエラーが発生した場合、エラー内容を表示
if ($status === false) {
   $error = $stmt->errorInfo();
   exit('Error: ' . print_r($error, true));
}

// 4. データ登録処理後
$id = $pdo->lastInsertId();  // 挿入したデータのID（受付No.）を取得
$stmt = $pdo->prepare("SELECT date FROM gs_bm_table WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$date = $stmt->fetchColumn();


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>受付完了</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: white;
      padding: 30px;
      width: 80%;
      max-width: 600px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      border: 3px solid #007bff;
    }

    h2 {
      color: #007bff;
      margin-bottom: 20px;
    }

    .info {
      text-align: left;
      margin: 10px 0;
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }

    .info:last-child {
      border-bottom: none;
    }

    .info strong {
      color: #333;
    }

    .print-button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      transition: 0.3s;
    }

    .print-button:hover {
      background-color: #0056b3;
    }

    /* 印刷時にボタンを非表示 */
    @media print {
      .print-button {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <h2>受付完了</h2>
    <div class="info"><strong>受付日時:</strong> <?php echo htmlspecialchars($date); ?></div>
    <div class="info"><strong>受付No.:</strong> <?php echo htmlspecialchars($id); ?></div>
    <div class="info"><strong>学校名:</strong> <?php echo htmlspecialchars($name); ?></div>
    <div class="info"><strong>郵便番号:</strong> <?php echo htmlspecialchars($code); ?></div>
    <div class="info"><strong>所在地:</strong> <?php echo htmlspecialchars($address); ?></div>
    <div class="info"><strong>最寄駅・バス停:</strong> <?php echo htmlspecialchars($station); ?></div>
    <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></div>
    <div class="info"><strong>電話番号:</strong> <?php echo htmlspecialchars($tel); ?></div>
    <div class="info"><strong>FAX番号:</strong> <?php echo htmlspecialchars($fax); ?></div>
    <div class="info"><strong>担当の先生:</strong> <?php echo htmlspecialchars($teacher); ?></div>
    <div class="info"><strong>授業希望日:</strong> <?php echo htmlspecialchars($schedule); ?></div>
    <div class="info"><strong>希望の講師:</strong> <?php echo htmlspecialchars($soroteacher); ?></div>
    <div class="info"><strong>その他ご要望:</strong> <?php echo nl2br(htmlspecialchars($content)); ?></div>

    <button class="print-button" onclick="window.print()">印刷</button>
  </div>

</body>

</html>