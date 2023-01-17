<?php
// CSRF対策として$_SESSIONを使ってトークンを発行する
session_start();

// $_SESSIONの中身を確認する
if (!empty($_SESSION)) {
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
}

// クリックジャッキング対策のコード
// サーバーに書く方法とPHPに書く方法とがある。
header('X-FRAME-OPTIONS:DENY');

// XSS対策のhtmlエスケープ用のコード（サニタイズ）
// htmlspecialchars関数は、記述が冗長なためユーザー定義関数を作成して使いまわす。
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 表示を切り替えるためのif文
$pageFlag = 0;

if (!empty($_POST['btn_confirm'])) {
    $pageFlag = 1;
}
if (!empty($_POST['btn_submit'])) {
    $pageFlag = 2;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>input.php</title>
</head>

<body>

    <h1>入力、確認、確認を1ページで切り替える</h1>
    <p>if文の処理で表示を切り替えて実現する</p>
    <hr>
    <?php if ($pageFlag === 0) : ?>
        <?php
        // $_SESSIONにcsrfTokenがセットされていなかったら、csrfTokenを作成する。
        if (!isset($_SESSION['csrfToken'])) {
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrfToken'] = $csrfToken;
        }
        $token = $_SESSION['csrfToken'];   // $tokenの中に作成したcsrfTokenを格納（$_SESSION['csrfToken'] は長い）
        ?>
        <h2>入力画面</h2>
        <form method="POST" action="input.php">
            氏名：
            <input type="text" name="your_name" value="<?php if (!empty($_POST['your_name'])) {
                                                            echo h($_POST['your_name']);
                                                        } ?>">
            <br>
            メールアドレス：
            <input type="email" name="email" value="<?php if (!empty($_POST['email'])) {
                                                        echo h($_POST['email']);
                                                    } ?>">
            <br>
            <p>※ボタンにname属性とvalue属性を入れることで、KeyとValueの関係になりbtn_confirmに値が入っていれば、ボタンが押されたということが分かり、表示を切り替える条件に使うことができる。</p>
            <input type="submit" name="btn_confirm" value="確認画面へ">
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <br>
            <p>※hiddenで見えないが、CSRF対策用のinputタグを用意している。</p>
            <p>inputタグのvalue属性にPHPで暗号用に作成したcsrfToken（合言葉）をechoで表示させている</p>
        </form>
    <?php endif; ?>
    <?php if ($pageFlag === 1) : ?>
        <?php
        // 入力画面で作成した合言葉が、正しいものかどうかを判定する処理
        if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
            <h2>確認画面</h2>
            <form method="POST" action="input.php">
                氏名：
                <?php echo h($_POST['your_name']); ?>
                <br>
                メールアドレス：
                <?php echo h($_POST['email']); ?>
                <br>
                <p>※POST通信は、一度通信を行うとデータが消えてしまうためtype="hidden"のinputタグを用意し、value属性に値を表示しているPHP文を貼り付けておく。</p>
                <p>hiddenで設定しておくと、表には見えないけどデータとして保持している状態にできる。</p>
                <input type="submit" name="back" value="戻る">
                <input type="submit" name="btn_submit" value="送信する">
                <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
                <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
                <input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']); ?>">
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($pageFlag === 2) : ?>
            <?php
            // 入力画面で作成した合言葉が、正しいものかどうかを判定する処理
            if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
                <h2>完了画面</h2>
                <p>送信が完了しました。</p>
                <?php
                // 合言葉がずっと残るのは望ましくないため、unset関数でcsrfTokenを削除する。
                unset($_SESSION['csrfToken']);
                ?>
            <?php endif; ?>
        <?php endif; ?>

</body>

</html>