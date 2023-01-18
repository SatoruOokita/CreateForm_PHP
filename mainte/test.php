<?php
// パスワードを記録した場所
echo __FILE__;
// C:\xampp\htdocs\CreateForm_PHP\mainte\test.php
echo '<br>';

// パスワード（暗号化）
echo(password_hash('password123', PASSWORD_BCRYPT));
echo '<br>';

/**
 * テキストファイルを操作する方法
 */
// 読み込みたいファイルを変数に入れておく
$contactFile = '.contact.dat';

// file_get_contents()関数を使ってファイル丸ごと読み込み
$fileContents = file_get_contents($contactFile);
echo $fileContents;

// ファイルに書き込み1
// 今まであった文字をすべて消して上書きする
// file_put_contents($contactFile, '第３引数FILE_APPENDをつけないと、全て上書き');

// ファイルに書き込み2
// 追記する（改行せずに、最後の文字列の後ろに追加）
// file_put_contents($contactFile, '追加したい文字列（改行なし）', FILE_APPEND);


// ファイルに書き込み3
// 改行して追記する（改行コード\nをコンマで付け足す）
// $addText = '追加したい文字列' . "\n";
// file_put_contents($contactFile, $addText, FILE_APPEND);


/**
 * CSVファイルを操作する方法（コンマで区切られたデータ）
 * 
 */
// 配列として扱う関数： file()
// 区切る関数： explode
// 配列の表示： foreach

// 読み込みたいファイルを変数に入れておく
$csvFile = '.practice_csv.dat';

$allData = file($csvFile);

foreach($allData as $lineData){
    $lines = explode(',', $lineData);
    echo $lines[0].'<br>';
    echo $lines[1].'<br>';
    echo $lines[2].'<br>';
    echo $lines[3].'<br>';
    echo '<br>';
}