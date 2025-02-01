-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-02-01 14:29:10
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_db_class`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_bm_table`
--

CREATE TABLE `gs_bm_table` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `station` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `tel` varchar(64) NOT NULL,
  `fax` varchar(64) NOT NULL,
  `teacher` varchar(128) NOT NULL,
  `schedule` varchar(128) NOT NULL,
  `soroteacher` varchar(128) NOT NULL,
  `content` varchar(535) NOT NULL,
  `date` datetime(6) NOT NULL,
  `category` varchar(255) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `teacher_contact` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `gs_bm_table`
--

INSERT INTO `gs_bm_table` (`id`, `name`, `code`, `address`, `station`, `email`, `tel`, `fax`, `teacher`, `schedule`, `soroteacher`, `content`, `date`, `category`, `teacher_name`, `teacher_contact`, `is_deleted`) VALUES
(2, '', '', '', '', '', '', '', '', '', '', '', '2024-12-20 11:24:56.000000', '', '', '', 1),
(3, '千代田区立九段小学校', '102-0075', '千代田区三番町16', '半蔵門線九段下駅', '', '03-5555-4444', '03-4444-5555', '算数少人数 石井', '12月中,２月中,オンライン授業可', 'なし', '特になし', '2024-12-20 11:26:16.000000', '断', '', '', 0),
(4, '北区立堀船小学校', '114-0004', '東京都北区堀船2-11-9', 'JR京浜東北線王子駅', 'test01@gmail.com', '03-3902-1234', '03-3902-9876', 'テスト➀➁', '0', '0', '特になし', '2024-12-20 11:43:55.000000', '', '', '', 1),
(5, '', '', '', '', '', '', '', '', '', '', '', '2024-12-20 11:47:41.000000', '', '', '', 1),
(7, '港区立港南小学校', '港区立港南小学校', '港区港南4-3-28', 'JR京浜東北線品川駅', 'test2@gmail.com', '03-8888-8888', '03-8888-1818', '３年担任 川', '3月中', '', 'たのしいそろばんDL可', '2025-01-13 23:02:23.000000', '全', '赤坂 貞子', '080-1192-8864', 0),
(8, '江戸川区立江戸川小学校', '132-0024', '江戸川区一之江1-2-4', '03-3333-3333', '', '03-7777-7777', '', '４年担任', '12月中,月中,オンライン授業可', '扇谷先生', '副教材冊子希望', '2025-01-15 21:45:22.000000', 'その他', '山田 花子', '075-666-1112', 0),
(9, '練馬区立北町小学校', '179-0081', '練馬区北町1-14-11', '東武東上線東武練馬駅', 'test16@yahoo.co.jp', '0120-444-444', '0120-444-445', '石倉', '1月中', '福田先生', '', '2025-01-15 23:47:42.000000', '断', '', '', 0),
(10, '立川市立第四小学校', '190-0013', '富士見町4-4-1', 'バス', '', '046-252-4568', '0462-52-4568', '立石', 'オンライン授業可', '', '', '2025-01-29 12:19:57.000000', '東', '菅野 圧', '03-1523-1545', 0),
(11, '世田谷区立第三小学校', '156-0041', '東京都世田谷区大原2-22-1', '京王線代田橋駅', 'test01@gmail.com', '03-1111-1111', '03-9999-9999', '３年担任 鈴木康之', '11月中,２月中,オンライン授業可', '特になし', '若手の先生だと嬉しいです。', '2025-01-29 12:24:14.000000', '全', '樋口 まさこ', '090-1234-5678', 0),
(12, '北区立堀船小学校', '114-0004', '北区堀船2-11-9', 'JR京浜東北線王子駅', 'test0@test.jp', '03-1234-5678', '03-9876-5432', 'チャッピー', '11月中,３月中,オンライン授業可', '谷先生希望', '早めに連絡をいただきたいです。', '2025-02-01 13:33:11.000000', '学', '高橋', '03-3333-3333', 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
