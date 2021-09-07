<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-02</title>
</head>
<body>
    <?php
        // DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
        //テーブルの作成
        $sql = "CREATE TABLE IF NOT EXISTS mission5"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT"
        . "date TEXT,"
        . "pass char(32)"
        .");";
        $stmt = $pdo->query($sql);
        
        //データ入力・データレコードの挿入
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["hide_num"])){
            if(empty($_POST["pass_nc"])){//パスワード空
                $errorpass = "パスワードを入力してください";
            }else{//パスワード有
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                $date = date("Y/m/d H:i:s");
                $pass = $_POST["pass_nc"];
                $sql = $pdo->prepare("INSERT INTO mission5 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
                $sql->bindParam(':name', $name, PDO::PARAM_STR);
                $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql->bindParam(':date', $date, PDO::PARAM_STR);
                $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
                $sql->execute();
            }
        }
        //データ入力・データレコードの挿入　終了
    
        //削除
        if(!empty($_POST["delete"])){
            if(empty($_POST["pass_del"])){//パスワード空
                $errorpass = "パスワードを入力してください";
            }else{//パスワード有
                $sql = 'SELECT * FROM mission5';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($_POST["delete"] == $row['id'] && $_POST["pass_del"] == $row['pass']){
                        $id = ($_POST["delete"]);
                        $sql = 'delete from mission5 where id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }elseif($_POST["delete"] == $row['id'] && $_POST["pass_del"] != $row['pass']){
                        $errorpass = "パスワードが違います";
                    }
                }
            }
        }
        //削除　終了
    
        //編集選択
        if(!empty($_POST["edit"])){
            if(empty($_POST["pass_edit"])){//パスワード空
                $name_edit = " ";
                $comment_edit = " ";
                $errorpass = "パスワードを入力してください";
            }else{//パスワード有
                $sql = 'SELECT * FROM mission5';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($_POST["edit"] == $row['id'] && $_POST["pass_edit"] == $row['pass']){
                        $hide_num_edit = $row['id'];
                        $name_edit = $row['name'];
                        $comment_edit = $row['comment'];
                    }elseif($_POST["edit"] == $row['id'] && $_POST["pass_edit"] != $row['pass']){
                        $errorpass = "パスワードが違います";
                        $name_edit = " ";
                        $comment_edit = " ";
                    }
                }
            }
        }
        //編集選択　終了
    
        //投稿編集
        if (!empty($_POST["name"]) && ($_POST["comment"]) && ($_POST["hide_num"])){
            if(empty($_POST["pass_nc"])){//パスワード空
                $errorpass = "パスワードを入力してください";
            }else{//パスワード有
                $sql = 'SELECT * FROM mission5';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($_POST["hide_num"]==$row['id'] && $_POST["pass_nc"]==$row['pass']){
                        $id = $_POST["hide_num"]; 
                        $name = $_POST["name"];
                        $comment = $_POST["comment"];
                        $date = date("Y/m/d H:i:s");
                        $pass = $_POST["pass_nc"];
                        $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=:date,pass=:pass WHERE id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }elseif($_POST["hide_num"] == $row['id'] && $_POST["pass_nc"]!=$row['pass']){
                        $errorpass = "パスワードが違います";
                    }
                }
            }
        }
        //投稿編集　終了
    ?>

    <form action="" method="post">
        <input type="text" name="name" placeholder="名前"
                value='<?php if(!empty($_POST["edit"])){echo $name_edit;}?>'><br>
        <input type="text" name="comment" placeholder="コメント"
                value='<?php if(!empty($_POST["edit"])){echo $comment_edit;}?>'><br>
        <input type="password" name="pass_nc" placeholder="パスワード">
        <input type="submit" name="submit"><br>
        <input type="hidden" name="hide_num"
                value='<?php if(!empty($_POST["edit"])){echo $hide_num_edit;}?>'>
    
        <br>
    
        <input type="number" name="delete" placeholder="削除対象番号"><br>
        <input type="password" name="pass_del" placeholder="パスワード">
        <input type="submit" name="submit" value="削除"><br>

        <br>
    
        <input type="number" name="edit" placeholder="編集対象番号"><br>
        <input type="password" name="pass_edit" placeholder="パスワード">
        <input type="submit" name="submit" value="編集"><br>
    </form>
    
    <hr width="40%" align="left">
    <?php
        if(!empty($errorpass)){
            echo $errorpass."<br>";
        }else{
            echo "<br>";
        }
    ?>
    <hr width="40%" align="left">

    <?php
        $sql = 'SELECT * FROM mission5';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].' ';
            echo $row['name'].' ';
            echo $row['comment'].' ';
            echo $row['date'].'<br>';
            echo "<hr>";
        }
    ?>
</body>
</html>