<?php

session_start();

// require 'validation.php';

//クリックジャッキング対策
header('X-FRAME-OPTIONS:DENY');
// $_の変数をスーパーグローバル変数
if (!empty($_POST)) {
    var_dump($_POST);
}

if (!empty($_SESSION)) {
    var_dump($_SESSION);
}

//$_SESSIONはずっと残る。GETとPOSTは1買い切る
// サニタイズ用の関数
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$pageFlag = 0;
// $errors = validation($_POST);
// $errors =  validation($_POST);

if (!empty($_POST['btn_confirm'])) {
    $pageFlag = 1;
}

if (!empty($_POST['btn_submit'])) {
    $pageFlag = 2;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <?php if ($pageFlag === 0) : ?>
        <?php
        if (!isset($_SESSION['$csrfToken'])) {
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrfToken'] = $csrfToken;
        }
        // echo(bin2hex())
        ?>

        <?php if(!empty($errors) && !empty($_POST['btn_confirm'])): ?>
        <?php echo '<ul>';?>
        <?php
            foreach($errors as $error){
                echo '<li>' .$error.'<li>' ;
            }
            ?>
        <?php echo '</ul>' ;?>
        <?php endif;?>
        <form method="POST" action=test.php>
            <p>氏名</p>
            <input type="text" name='name' value="<?php if (!empty($_POST['name'])) {
                                                        echo h($_POST['name']);
                                                    } ?>">
            <p>email</p>
            <input type="text" name="email" value="<?php if (!empty($_POST['email'])) {
                                                        echo h($_POST["email"]);
                                                    } ?>">
            <p>Gender</p>
            <input type="radio" name="gender" value="0" <?php if (!empty($_POST['gender']) && $_POST['gender'] === '0') {
                                                            echo 'checked';

                                                        } ?>>男性
            <input type="radio" name="gender" value="1" <?php if (!empty($_POST['gender']) && $_POST['gender'] === '1') {
                                                            echo 'checked';
                                                        } ?>>女性


            <p>注意事項</p>
            <input type="checkbox" name="caution" value="1">注意事項にチェックする。
            <input type="submit" name="btn_confirm" value="確認する">
            <input type="hidden" name="csrf" value="<?php echo $csrfToken; ?>">

        </form>
        <!-- 入力画面 -->
    <?php endif; ?>
    <?php if ($pageFlag === 1) : ?>
        <!-- 確認画面 -->
        <?php if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
            <form method="POST" action=test.php>
                <p>氏名</p>
                <?php echo h($_POST['name']); ?>
                <p>email</p>
                <?php echo h($_POST['email']); ?>
                <p>性別</p>
                <?php
                if ($_POST['gender'] === '0') {
                    echo '男性';
                }
                if ($_POST['gender'] === '1') {
                    echo '女性';
                }
                ?>
                <input type="submit" name="back" value="戻る">
                <input type="submit" 　name="btn_submit" value="送信する">

                <!-- データを保持するため -->
                <input type="hidden" name="name" value="<?php echo h($_POST['name']); ?>">
                <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
                <input type="hidden" name="gender" value="<?php echo h($_POST['gender']); ?>">
                <input type="checkbox" name="caution" value="1">注意事項にチェックする。
                <input type="hidden" name="csrf" value="<?php echo $csrfToken; ?>">
            </form>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($pageFlag === 2) : ?>
        <?php if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
            <!-- 入力画面 -->
            <p>送信が完了しました</p>
            <?php unset($_SESSION['csrfToken']) ?>
        <?php endif; ?>
    <?php endif; ?>

</body>

</html>