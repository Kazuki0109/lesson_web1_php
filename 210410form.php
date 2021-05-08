<!DOCTYPE html>
<html>
    <?php
        if(!empty($_POST)){
            var_dump($_POST);
        }

        //クリックジャッキング対策
        header('X-FRAME-OPTIONS:DENY');
        //XSS対策　p267 サニタイズ
        // function es($data, $charset = 'UTF-8'){
        //     //配列の値の操作
        //     if(is_array($data)){
        //         return array_map(__METHOD__, $data);
        //     }else{
        //         return htmlspecialchars($data, ENT_QUOTES, $charset);
        //     }
        // }
        function es($data){
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        function h($str){
            return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        }       
        //登録フォームのフラグは、0
        $pageFlag = 0;

        if(!empty($_POST['btn_confirm'])){
            $pageFlag = 1;
        }
        if(!empty($_POST['btn_submit'])){
            $pageFlag = 2;
        }
    ?>
    <head>
        <meta charset="UTF-8">
        <title>フォーム</title>
    </head>
    <body>
    <?php if($pageFlag === 0):?>
        <h1>登録画面</h1>
        <form method = "POST" action = "210410form.php">
            <p>名前</p>
            <input type = "text" name = "name" value = "<?php if(!empty($_POST['name'])){echo es($_POST['name']);}?>">
            <p>メールアドレス</p>
            <input type = "email" name = "email" value = "<?php if(!empty($_POST['email'])){echo $_POST['email'];}?>">
            <p>性別</p>
            <input type="radio" name="gender" value = "0" >男性
            
            <input type="radio" name="gender" value = "1" checked = "<?php echo 'checked';?>">女性
            <input type="submit" name="btn_confirm" value="確認する">

        </form>
     <?php endif;?>
     <!-- <style>h1{color: #1234FF;}</style> -->
     <?php if($pageFlag === 1):?>
        <h1>確認画面</h1>
        <form method = "POST" action = "210410form.php">
            <p>名前</p>
            <?php echo $_POST['name'] ?>
            <p>メールアドレス</p>
            <?php echo $_POST['email'] ?>
            <input type="submit" name="btn_back" value="戻る">
            <input type="submit" name="btn_submit" value="送信する">
            <!-- データ保持のため -->
            <input type = "hidden" name = "name" value = "<?php echo $_POST['name'] ?>">
            <input type = "hidden" name = "email" value = "<?php echo $_POST['email'] ?>">
        </form>
    <?php endif;?>
    <?php if($pageFlag === 2):?>
        <h1>登録完了しました。</h1>
    <?php endif;?>
    </body>
</html>