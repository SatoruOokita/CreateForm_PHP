<?php

require 'db_connection.php';

// ユーザー入力なし query
// 毎回同じような画面を表示する場合
$sql_1 = 'select * from contacts where id = 4';   // sql
$stmt_1 = $pdo->query($sql_1);  // sql実行

$result_1 = $stmt_1->fetchall();

echo '<pre>';
var_dump($result_1);
echo '</pre>';

// ユーザー入力あり
// 検索画面や問い合わせフォームなど prepare,bind,execute
$sql_2 = 'select * from contacts where id = :id';   // 名前付きプレースホルダー
$stmt_2 = $pdo->prepare($sql_2);    // プリペアードステートメント
$stmt_2->bindValue('id', 4, PDO::PARAM_INT);    // 紐付け（プレイスホルダーに値を設定）
$stmt_2->execute(); // 実行

$result_2 = $stmt_2->fetchall();


echo '<pre>';
var_dump($result_2);
echo '</pre>';

// トランザクション（まとまって処理）
// 3つのメソッドを使って書いていく。 beginTransaction, commit, rollback

$pdo->beginTransaction();   // トランザクションの始まり

try{
    // 処理を書く

    $pdo->commit(); // 問題なければコミット

} catch(PDOException $e){
    // 例外が起こったら...
    $pdo->rollback();   // 更新のキャンセル
};