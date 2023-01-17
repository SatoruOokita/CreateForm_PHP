<?php
// CSRF対策として$_SESSIONを使ってトークンを発行する
session_start();

// バリデーション用のファイルを読み込む
require 'validation.php';

// $_POSTの中身を確認する
if (!empty($_POST)) {
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}

// クリックジャッキング対策
header('X-FRAME-OPTIONS:DENY');

// XSS対策のhtmlエスケープ用のコード（サニタイズ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 入力画面、確認画面、完了画面の表示を切り替える処理
 */
$pageFlag = 0;  // 表示を切り替えるフラッグとして変数$pageFlagを用意する
$errors = validation($_POST);   // 「validation.php」で用意した関数のリターンを$errorsに格納する。

// 表示を切り替えるためのif文
if (!empty($_POST['btn_confirm']) && empty($errors)) {
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
    <p>バリデーションをする。</p>
    <hr>
    <?php if ($pageFlag === 0) : ?>
        <?php
        if (!isset($_SESSION['csrfToken'])) {
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrfToken'] = $csrfToken;
        }
        $token = $_SESSION['csrfToken'];
        ?>
        <?php
        // !empty($errors) で、「$errorsが空でなかったら（エラーがあれば）」という条件
        // !empty($errors) だけだと、初回アクセスの時点でエラーが出るため、
        // && !empty($_POST['btn_confirm'])で、「確認のボタンが押されたら」という条件を追加
        if (!empty($errors) && !empty($_POST['btn_confirm'])) : ?>
            <?php echo '<ul>'; ?>
            <?php
            foreach ($errors as $error) {
                echo  '<li>' . $error . '</li>';
            }
            ?>
            <?php echo '</ul>'; ?>
        <?php endif; ?>
        <h2>入力画面</h2>
        <form method="POST" action="input_validation.php">
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
            ホームページ
            <input type="url" name="url" value="<?php if (!empty($_POST['url'])) {
                                                    echo h($_POST['url']);
                                                } ?>">
            <br>
            性別
            <input type="radio" name="gender" value="0" <?php if (isset($_POST['gender']) && $_POST['gender'] === '0') {
                                                            echo 'checked';
                                                        } ?>>男性
            <input type="radio" name="gender" value="1" <?php if (isset($_POST['gender']) && $_POST['gender'] === '1') {
                                                            echo 'checked';
                                                        } ?>>女性
            <br>
            年齢
            <select name="age" id="">
                <option value="">選択して下さい</option>
                <option value="1">～19歳</option>
                <option value="2">20～29歳</option>
                <option value="3">30～39歳</option>
                <option value="4">40～49歳</option>
                <option value="5">50～59歳</option>
                <option value="6">60歳～</option>
            </select>
            <br>
            お問い合わせ内容
            <textarea name="contact" placeholder="200字まで" maxlength="200"><?php if (!empty($_POST['contact'])) {echo h($_POST['contact']);} ?></textarea>
            <br>
            <input type="checkbox" name="caution" value="1">注意事項にチェックする。
            <br>
            <input type="submit" name="btn_confirm" value="確認画面へ">
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <br>
        </form>
    <?php endif; ?>
    <?php if ($pageFlag === 1) : ?>
        <?php
        // 入力画面で作成した合言葉が、正しいものかどうかを判定する処理
        if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
            <h2>確認画面</h2>
            <form method="POST" action="input_validation.php">
                氏名：
                <?php echo h($_POST['your_name']); ?>
                <br>
                メールアドレス：
                <?php echo h($_POST['email']); ?>
                <br>
                ホームページ：
                <?php echo h($_POST['url']); ?>
                <br>
                性別：
                <?php
                if ($_POST['gender'] === '0') {
                    echo '男性';
                }
                if ($_POST['gender'] === '1') {
                    echo '女性';
                }
                ?>
                <br>
                年齢：
                <?php
                if ($_POST['age'] === '1') {
                    echo '～19歳';
                }
                if ($_POST['age'] === '2') {
                    echo '20～29歳';
                }
                if ($_POST['age'] === '3') {
                    echo '30～39歳';
                }
                if ($_POST['age'] === '4') {
                    echo '40～49歳';
                }
                if ($_POST['age'] === '5') {
                    echo '50～59歳';
                }
                if ($_POST['age'] === '6') {
                    echo '60歳～';
                }
                ?>
                <br>
                お問い合わせ内容：
                <?php echo h($_POST['contact']); ?>
                <br>
                <input type="submit" name="back" value="戻る">
                <input type="submit" name="btn_submit" value="送信する">
                <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
                <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
                <input type="hidden" name="url" value="<?php echo h($_POST['url']); ?>">
                <input type="hidden" name="gender" value="<?php echo h($_POST['gender']); ?>">
                <input type="hidden" name="age" value="<?php echo h($_POST['age']); ?>">
                <input type="hidden" name="contact" value="<?php echo h($_POST['contact']); ?>">
                <input type="hidden" name="caution" value="<?php echo h($_POST['caution']); ?>">
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