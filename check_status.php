<?php
// データベース接続
require_once('funcs.php');
$pdo = db_conn();
$result = null;
$error_message = "";

// フォーム送信時の処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reception_no = $_POST["reception_no"];
    $phone_number = $_POST["phone_number"];

    // データベース検索
    $sql = "SELECT teacher_name, teacher_contact, category, id, name, code, address, station, email, tel, fax, teacher, schedule, soroteacher, content FROM gs_bm_table WHERE id = :id AND tel = :tel";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $reception_no, PDO::PARAM_STR);
    $stmt->bindParam(":tel", $phone_number, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        $error_message = "該当するデータが見つかりません。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>講師派遣 照会</title>
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
            padding: 50px;
            /* paddingを少し減らして、内部スペースを広く */
            width: 80%;
            /* 幅を100%にして、画面いっぱいに広げる */
            max-width: 700px;
            /* 最大幅を少し広げて、ボタンも大きく */
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

        input[type="text"] {
            width: 100%;
            /* 入力欄の幅を広げる */
            padding: 10px;
            font-size: 20px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .submit-button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 24px;
            width: 100%;
        }


        .submit-button:hover {
            background-color: #0056b3;
        }

        .info label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        .right-align {
            display: flex;
            justify-content: flex-end;
        }

        .right-align input {
            width: 70%;
        }

        .description {
            font-size: 14px;
            color: #666;
            text-align: left;
            margin-top: 5px;
        }

        /* 印刷プレビュー時に印刷ボタンを非表示 */
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>講師派遣 可否照会</h2>

        <?php if (!$result): ?>
            <!-- 照会フォーム -->
            <form method="POST" action="">
                <div class="info">
                    <label for="reception_no"><strong>受付No.:</strong></label>
                    <input type="text" id="reception_no" name="reception_no" placeholder="申込時の受付No." required>
                </div>
                <div class="info">
                    <label for="phone_number"><strong>電話番号:</strong></label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="申込時に入力した電話番号(ハイフンあり)" required>
                </div>
                <button type="submit" class="print-button">講師派遣 結果照会</button>
            </form>
        <?php elseif ($result): ?>
            <!-- 結果表示 -->
            <?php if ($result["category"] == "断"): ?>
                <p>講師派遣のお申し込みをいただき、昨日まで出講講師の調整を進めてまいりましたが、誠に遺憾ながら、本年度は貴校へ伺える講師を手配することができませんでした。何卒ご理解賜りますよう、よろしくお願い申し上げます。</p>
            <?php else: ?>
                <p>今回、派遣する講師は、以下のとおりです。</p>
                <div class="info"><strong>講師名:</strong> <?php echo htmlspecialchars($result["teacher_name"], ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="info"><strong>連絡先:</strong> <?php echo htmlspecialchars($result["teacher_contact"], ENT_QUOTES, 'UTF-8'); ?></div>
                <p><small>※ 講師から学校へご連絡いたしますが、お急ぎの場合は、上記の連絡先まで直接お問い合わせください。</small></p>

                <div class="info"><strong>受付No.:</strong> <?php echo htmlspecialchars($result["id"]); ?></div>
                <div class="info"><strong>学校名:</strong> <?php echo htmlspecialchars($result["name"]); ?></div>
                <div class="info"><strong>郵便番号:</strong> <?php echo htmlspecialchars($result["code"]); ?></div>
                <div class="info"><strong>所在地:</strong> <?php echo htmlspecialchars($result["address"]); ?></div>
                <div class="info"><strong>最寄駅・バス停:</strong> <?php echo htmlspecialchars($result["station"]); ?></div>
                <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($result["email"]); ?></div>
                <div class="info"><strong>電話番号:</strong> <?php echo htmlspecialchars($result["tel"]); ?></div>
                <div class="info"><strong>FAX番号:</strong> <?php echo htmlspecialchars($result["fax"]); ?></div>
                <div class="info"><strong>担当の先生:</strong> <?php echo htmlspecialchars($result["teacher"]); ?></div>
                <div class="info"><strong>授業希望日:</strong> <?php echo htmlspecialchars($result["schedule"]); ?></div>
                <div class="info"><strong>希望の講師:</strong> <?php echo htmlspecialchars($result["soroteacher"]); ?></div>
                <div class="info"><strong>その他ご要望:</strong> <?php echo nl2br(htmlspecialchars($result["content"])); ?></div>

                <button class="print-button" onclick="window.print()">印刷</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>