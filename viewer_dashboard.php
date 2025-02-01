<<?php
    //SESSION開始！！
    session_start();
    require_once('funcs.php');
    loginCheck();

    //データ登録SQL作成
    $pdo = db_conn();
    $stmt = $pdo->prepare('SELECT * FROM gs_bm_table');
    $status = $stmt->execute();

    // 検索条件
    $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
    $search_id = isset($_GET['search_id']) ? $_GET['search_id'] : '';
    $search_month = isset($_GET['search_month']) ? $_GET['search_month'] : ''; // 月の検索条件

    // データ取得のSQL準備
    $sql = "SELECT * FROM gs_bm_table WHERE is_deleted = 0";

    // 検索条件に基づいてSQL文を変更
    if ($search_name !== '') {
        $sql .= " AND name LIKE :search_name";
    }
    if ($search_id !== '') {
        $sql .= " AND id = :search_id";
    }
    if ($search_month !== '') {
        $sql .= " AND schedule LIKE :search_month"; // 授業希望月に基づいた検索条件追加
    }

    $stmt = $pdo->prepare($sql);

    // 検索パラメータのバインド
    if ($search_name !== '') {
        $stmt->bindValue(':search_name', '%' . $search_name . '%', PDO::PARAM_STR);
    }
    if ($search_id !== '') {
        $stmt->bindValue(':search_id', $search_id, PDO::PARAM_INT);
    }
    if ($search_month !== '') {
        $stmt->bindValue(':search_month', '%' . $search_month . '%', PDO::PARAM_STR); // 授業希望月に基づくバインド
    }

    $status = $stmt->execute();

    if ($status === false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery: " . $error[2]);
    } else {
        // データ取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>データ一覧</title>
        <link rel="stylesheet" href="css/style2.css">
        <style>
            .upload-container {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 10px;
            }
        </style>
    </head>

    <body id="main">
        <div class="logout-btn-container">
            <a href="logout.php"><button>ログアウト</button></a>
        </div>
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">データ登録画面</a>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container">
            <h2>講師派遣申込一覧表</h2>

            <!-- 検索フォーム -->
            <form action="select.php" method="GET">
                <label for="search_id">「受付番号」:</label>
                <input type="text" name="search_id" id="search_id" value="<?= isset($_GET['search_id']) ? h($_GET['search_id']) : '' ?>">

                <label for="search_name">「学校名」:</label>
                <input type="text" name="search_name" id="search_name" value="<?= isset($_GET['search_name']) ? h($_GET['search_name']) : '' ?>">

                <label for="search_month">早期授業希望:</label>
                <select name="search_month" id="search_month">
                    <option value="">選択してください</option>
                    <option value="11月" <?= isset($_GET['search_month']) && $_GET['search_month'] === '11月' ? 'selected' : '' ?>>11月中</option>
                    <option value="12月" <?= isset($_GET['search_month']) && $_GET['search_month'] === '12月' ? 'selected' : '' ?>>12月中</option>
                    <option value="オンライン" <?= isset($_GET['search_month']) && $_GET['search_month'] === 'オンライン' ? 'selected' : '' ?>>オンライン可</option>
                </select>

                <button type="submit">検 索</button>
                <button type="button" onclick="clearSearch()">全てのデータを表示</button>
            </form>

            <script>
                function clearSearch() {
                    window.location.href = "select.php";
                }
            </script>

            <!-- CSVダウンロードボタン ＆ アップロードフォーム -->
            <div class="upload-container">
                <a href="download.php"><button>CSVダウンロード</button></a>

                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="upload_file" id="upload_file" accept=".csv">
                    <button type="submit">CSVアップロード</button>
                </form>
            </div>

            <table class="styled-table">
                <thead>
                    <tr>
                        <th>受付No.</th>
                        <th>学校名</th>
                        <th>郵便番号</th>
                        <th>所在地</th>
                        <th>最寄駅・バス停</th>
                        <th>Email</th>
                        <th>電話番号</th>
                        <th>FAX番号</th>
                        <th>担当の先生名</th>
                        <th>授業希望日</th>
                        <th>希望の講師</th>
                        <th>その他ご要望</th>
                        <th>登録日</th>
                        <th>区分</th>
                        <th>講師名</th>
                        <th>講師連絡先</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= h($row['id']) ?></td>
                            <td><?= h($row['name']) ?></td>
                            <td><?= h($row['code']) ?></td>
                            <td><?= h($row['address']) ?></td>
                            <td><?= h($row['station']) ?></td>
                            <td><?= h($row['email']) ?></td>
                            <td><?= h($row['tel']) ?></td>
                            <td><?= h($row['fax']) ?></td>
                            <td><?= h($row['teacher']) ?></td>
                            <td><?= h($row['schedule']) ?></td>
                            <td><?= h($row['soroteacher']) ?></td>
                            <td><?= h($row['content']) ?></td>
                            <td><?= h($row['date']) ?></td>
                            <td><?= h($row['category']) ?></td>
                            <td><?= h($row['teacher_name']) ?></td>
                            <td><?= h($row['teacher_contact']) ?></td>
                            <td>
                                <!-- 編集ボタン -->
                                <form action="update.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= h($row['id']) ?>">
                                    <button type="submit">編 集</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

    </body>

    </html>