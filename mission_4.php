<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title> 簡易掲示板 </title>
</head>
<body>

<?php
$dsn ='データベース名'; //login*
$user ='ユーザー名';
$password ='パスワード';
$pdo = new PDO($dsn,$user,$password);

 $name =$_POST['name'];
 $comment =$_POST['comment'];
 $date =date("y/m/d h:i:s");
 $pass =$_POST['pass'];



$sql ="CREATE TABLE tb3"//create tb2*
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."pass TEXT"
.");";
$stmt = $pdo -> query($sql);


//edit*
if(!empty($_POST['edit']) && !empty($_POST['Epass'])){
	$edit = $_POST['edit'];
	$sql = 'SELECT * FROM tb3';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
	 if($row['pass'] == $_POST['Epass']){
		$novalue=$row['id'];
		$namevalue=$row['name'];
		$comvalue=$row['comment'];
	 }
	}
}

//delete*
if(!empty($_POST['delete']) && !empty($_POST['Dpass'])){
	$delete = $_POST['delete'];
	$sql = 'SELECT * FROM tb3';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
	 if($row['pass'] == $_POST['Dpass']){
		$sql = "delete from tb3 where id = $delete";
		$result = $pdo->query($sql);
	 }
	}
}

//send*
if(isset($name) && ($name!=="") && isset($comment) && isset($pass) && empty($_POST['id'])){//new
	$sql = $pdo -> prepare("INSERT INTO tb3 (id, name, comment, date, pass) VALUES (null, :name, :comment, :date, :pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR); 
	$sql -> bindParam(':date', $date, PDO::PARAM_STR); 
	$sql -> bindParam(':pass',$pass, PDO::PARAM_STR);
	$sql -> execute();
}

if(isset($name) && ($name!=="") && isset($comment) && isset($pass) && !empty($_POST['id'])){//renew
	$id = $_POST['id'];
	$sql = 'SELECT * FROM tb3';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
	 if($row['id'] == $id){
		$sql = "update tb3 set name = '$name', comment = '$comment', pass = '$pass' where id =$id";
		$result = $pdo -> query($sql);
	 }
	}
}

$sql = 'SELECT * FROM tb3 order by id';
$results = $pdo -> query($sql);
foreach ($results as $row){
 echo $row['id'].' ';
 echo $row['name'].' ';
 echo $row['comment'].' ';
 echo $row['date'].'<br>';
}

?>

<form action="mission_4.php" method="post">
<p>〇投稿〇</p>
 <p><input type="text" value="<?=$namevalue?>" placeholder="名前" name="name"></p>
 <p><input type="text" value="<?=$comvalue?>" placeholder="コメント" name="comment"></p>
 <p><input type="text" placeholder="パスワード" name="pass">
  <input type="hidden" value="<?=$novalue?>" name="id">
 <input type="submit" value="送信" name="send"></p>
<p>〇削除〇<p/>
 <p><input type="text" placeholder="削除対象番号" name="delete"></p>
 <p><input type="text" placeholder="パスワード" name="Dpass">
 <input type="submit" value="削除"></p>
<p>〇編集〇</p>
 <p><input type="text" placeholder="編集対象番号" name="edit"></p>
 <p><input type="text" placeholder="パスワード" name="Epass">
 <input type="submit" value="編集"></p>
</form>

</body>
</html>