<?php
if(!empty($_POST)){
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="index.php">
        氏名：
        <input type="text" name="your_name">
        <br>
        野球<input type="checkbox" name="sports[]" value="野球">
        サッカー<input type="checkbox" name="sports[]" value="サッカー">
        バスケ<input type="checkbox" name="sports[]" value="バスケ">
        <input type="submit"  value="送信">
    </form>
</body>
</html>