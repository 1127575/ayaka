<?php
session_start();//session開始

if(isset($_SESSION['USERID'])){
    header('Location: mission_6_main.php');
exit;
}

//login
$db['host'] = 'ホスト';
$db['user'] = 'ユーザー名';
$db['pass'] = 'パスワード';
$db['dbname'] = 'データベース名';
$error = '';

//新規作成ボタンが押されたら
if (isset($_POST['signUp'])) {
    if(empty($_POST['username'])) {
        $error = 'ユーザーIDが未入力です。'; 
    }elseif(empty($_POST['password'])) {
        $error = 'パスワードが未入力です。'; 
    }
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
$pdo = new PDO('mysql:dbname=tt_91_99sv_coco_com', $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        
        // idの重複とパスワードの桁数チェック
        function cheak($id,$count){
            if($count > 0){
                throw new Exception('そのユーザーIDは既に使用されています。');
            }
            if ($id < 4) {
                throw new Exception('パスワードは4桁以上で入力してください。'); 
            }
        }
        try{
            $sqlname = 'SELECT COUNT(*) FROM user WHERE `name` = "$username"';
            $ss = $pdo->query($sqlname);
            $count = $ss->fetchColumn();

            $id = strlen($_POST['password']);
            cheak($id,$count);

            $stmt = $pdo->prepare('INSERT INTO `user`(`name`, `password`) VALUES (:username, :password)');
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);//余裕あれば後でハッシュ化
            $stmt->execute();    
     
            $_SESSION['USERID'] = $username;
            echo 
                '<script>
                alert("登録が完了しました。");
                location.href="mission_6_main.php";
                </script>';
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    } 
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>sign up</title>
    <link rel="stylesheet" href="mission_6.css" type="text/css">

</head>
<body>
    <nav class="header">
       <h1><a href="mission_6_top.php"><img src="header.png" alt=デジタル絵日記></a></h1>
    </nav>
    
   <main>
   <p>ユーザー名とパスワードを設定してください。</p>
    <form id="loginForm" name="loginForm" action="mission_6_sign.php" method="post">    <!--チェック！！-->
    <p><input type="text" placeholder="ユーザー名" id="username" name="username"></p>
    <p><input type="password" placeholder="パスワード" id="password" name="password"></p>
    <p><input type="submit" id="sugnUp" name="signUp" value="新規作成"></p>
    </form><br>
   </main>
    
</body>
</html>