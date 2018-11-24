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

//ログインボタンが押されたら
if(isset($_POST['login'])){
    if(empty($_POST['username'])){
        $error = 'ユーザーIDが未入力です。';
    }elseif(empty($_POST['password'])){
        $error = 'パスワードが未入力です。';
    }
}
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
    try{
        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $stmt = $pdo->prepare('SELECT * FROM user WHERE name = ?');
        $stmt->execute(array($username));
        $password = $_POST['password'];
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $result['password'])) {
            $_SESSION['USERID'] = $username;
            header('Location: mission_6_main.php');
            exit();
        }else{
            $error = 'ユーザーIDあるいはパスワードに誤りがあります。';
        }
    }catch(PDOException $e){
        echo $e -> getMessage();
    }
}   
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TOP</title>
    <link rel="stylesheet" href="mission_6.css" type="text/css">
</head>

<body>
   <nav class="header">
       <h1><a href="mission_6_top.php"><img src="header.png" alt=デジタル絵日記></a></h1>
   </nav>
   
   <main>
    <form id="loginForm" name="loginForm" action="mission_6_top.php" method="post">    <!--チェック！！-->
    <p style="coler:red;"><?php echo $error ?></p>
    <br>
    <p><input type="text" placeholder="ユーザーID" id="username" name="username"></p>
    <p><input type="password" placeholder="パスワード" id="password" name="password"></p>
    <p><input type="submit" id="login" name="login" value="ログイン"></p>
    </form>
    <br>
       <p><a href="mission_6_sign.php">新規作成する</a></p>
  </main>
</body>
</html>