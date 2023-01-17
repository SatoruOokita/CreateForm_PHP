<?php
if (!empty($_POST)) {
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}

// 表示を切り替えるためのif文
$pageFlag = 0;

if(!empty($_POST['btn_confirm'])){
    $pageFlag = 1;
}
if(!empty($_POST['btn_submit'])){
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
        <h2>入力画面</h2>
        <form method="POST" action="input.php">
        氏名：
        <input type="text" name="your_name" value="<?php if(!empty($_POST['your_name'])){echo $_POST['your_name'] ;}?>">
        <br>
        メールアドレス：
        <input type="email" name="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'] ;}?>">
        <br>
        <p>※ボタンにname属性とvalue属性を入れることで、KeyとValueの関係になりbtn_confirmに値が入っていれば、ボタンが押されたということが分かり、表示を切り替える条件に使うことができる。</p>
        <input type="submit" name="btn_confirm" value="確認画面へ">
    </form>
    <?php endif; ?>
    <?php if ($pageFlag === 1) : ?>
        <h2>確認画面</h2>
        <form method="POST" action="input.php">
        氏名：
        <?php echo $_POST['your_name'] ; ?>
        <br>
        メールアドレス：
        <?php echo $_POST['email'] ; ?>
        <br>
        <p>※POST通信は、一度通信を行うとデータが消えてしまうためtype="hidden"のinputタグを用意し、value属性に値を表示しているPHP文を貼り付けておく。</p>
        <p>hiddenで設定しておくと、表には見えないけどデータとして保持している状態にできる。</p>
        <input type="submit" name="back" value="戻る">
        <input type="submit" name="btn_submit" value="送信する">
        <input type="hidden" name="your_name" value="<?php echo $_POST['your_name'] ; ?>">
        <input type="hidden" name="email" value="<?php echo $_POST['email'] ; ?>">

        <?php endif; ?>
    <?php if ($pageFlag === 2) : ?>
        <h2>完了画面</h2>
        <p>送信が完了しました。</p>
    <?php endif; ?>
    
</body>

</html>