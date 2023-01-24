<?php

const DB_HOST = 'mysql:dbname=udemy_php;host=127.0.0.1;charset=utf8';
const DB_USER = 'php_user2';
const DB_PASSWORD = '2';

// DBと繋がっているのかどうかを判定する例外処理 Exception
// 『try{} catch(){}』はDB接続のお決まりの書き方で、
// try{}の中にDBに繋がった時の処理を書き、catch{}の中に繋がらなかった時の処理を書く
try{
    // PDOを使うために、インスタンス化しておく必要がある。
    $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // DBから取得したデータを連想配列で
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 例外
        PDO::ATTR_EMULATE_PREPARES => false,                // SQLインジェクション対策
    ]);
    echo '接続成功';

} catch(PDOException $e){
    echo '接続失敗' . $e->getMessage() . "\n";
    exit();
}