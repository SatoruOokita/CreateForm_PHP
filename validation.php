<?php
// 今回は関数を作成してバリデーションをかけていく
// 引数の$requestには、$_POSTの連想配列が入ってくる
function validation($request)
{

    // エラーをまとめて保管しておくために。$errorsという配列を作っておく。
    $errors = [];

    // 氏名が空だったら、「氏名は必須」と表示させる
    if (empty($request['your_name']) || 20 < mb_strlen($request['your_name'])) {
        $errors[] = '「氏名」は必須です。また、20文字以内で入力してください。';   // []を付けることで配列に値をつけることができる。
    }

    // メールアドレスとURLの設定は細かく設定することができるがその分複雑になる。
    // 今回は簡単な方法のみ（filter_var関数を用いる方法）
    if(empty($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = '「メールアドレス」は必須です。正しい形式で入力してください。'; 
    }

    // ホームページを持っていない場合も考えられるため、URLの入力があった場合のみ判定を行う。
    if(!empty($request['url'])){
        if(!filter_var($request['url'], FILTER_VALIDATE_URL)){
        $errors[] = '「ホームページのURL」は、正しい形式で入力してください。'; 
        }
    }


    // 問い合わせ内容が空だったら、「問い合わせ内容は必須」と表示させる
    if (empty($request['contact']) || 200 < mb_strlen($request['contact'])) {
        $errors[] = '「問い合わせ内容」は必須です。また、200文字以内で入力してください。';   // []を付けることで配列に値をつけることができる。
    }
    return $errors;

    // 性別が空だったら、「性別は必須」と表示させる
    // emptyだと、値が「0」でもtrueを吐き出すためissetを用いる
    if (isset($request['$gender'])) {
        $errors[] = '「性別」は必須です。';
    }

    // 年齢が空だったら、「年齢は必須」と表示させる
    // 年齢のselectタグには、空（''）を用意しているためemptyを用いる
    if (empty($request['age'])) {
        $errors[] = '「年齢」は必須です。';
    }

    // 注意事項が空だったら（チェックが入っていなかったら）
    if (empty($request['caution'])) {
        $errors[] = '「注意事項」をご確認の上、チェックを入れてください。';
    }
}
