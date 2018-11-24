<?php
session_start();
// セッションクリア
session_destroy(); 
$error = "ログアウトしました。";
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>logout</title>
    <link rel="stylesheet" href="mission_6.css" type="text/css">
</head>
<body>
   <nav class="header">
       <h1><a href="mission_6_top.php"><img src="header.png" alt=デジタル絵日記></a></h1>
   </nav>
   <main> 
    <div><?php echo $error; ?></div>
    <ul>
    <li><a href="mission_6_top.php">ログインページへ</a></li>
    </ul>
    </main>
</body>
</html>