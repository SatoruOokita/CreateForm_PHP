<?php
// DB接続 PDO
require 'db_connection.php';

// 入力 DB保存 prepare, bind, execute
// 今回は、入力されるデータが全て文字列か数値なので、bindは使わずに「execute(配列(全て文字列))」を使う。

// テスト用のパラメータを用意する
$params = [
    'id' => null,
    'your_name' => 'えええ',
    'email' => 'test@test.com',
    'url' => 'http://test.com',
    'gender' => '1',
    'age' => '2',
    'contact' => 'えええ',
    // 'createrd_at' => 'NOW()' // DBに自動で入るため、NOWではなくnullに変更
    'createrd_at' => null
];

// $paramsの連想配列をforeach文で変数$columnsと$valuesに入れていく
$count = 0;
$columns = '';
$values = '';

foreach(array_keys($params) as $key){   // 『array_keys(配列名)』で連想配列の左側を持って来れる。
    if($count++ > 0){
        $columns .= ',';
        $values .= ','; 
    }
    $columns .= $key;
    $values .= ':'.$key;
}

$sql = 'insert into contacts ('. $columns .')values('. $values .')';   // 『insert into データベース名』で新しいレコードを追加。$columnsと$valuesで、テーブルのカラムと値を入れていく。

// 配列をうまく取れているかチェック
// var_dump($sql);

$stmt = $pdo->prepare($sql);    // プリペアードステートメント
$stmt->execute($params); // 実行


