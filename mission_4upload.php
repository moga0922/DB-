<html>
<head>
  <title>mission_4.php</title>
  <meta charset="utf-8">
</head>
<body>
<?php

$dsn='mysql:dbname=データベース名;host=localhost';
$user='ユーザー名';
$password_db='パスワード名';

$pdo=new PDO($dsn,$user,$password_db);


$sql="CREATE TABLE file3"
."("
."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
."name TEXT,"
."comment TEXT,"
."date TEXT,"
."password TEXT"
.");";
$stmt=$pdo->query($sql);

$sql='SHOW TABLES';
$result=$pdo->query($sql);
foreach($result as $row){
  echo $row[0];
  echo '<br>';
}
echo "<hr>";

$sql='SHOW CREATE TABLE file3';
$result=$pdo->query($sql);
foreach($result as $row){
  print_r($row);
}
echo "<hr>";

$name=$_POST["name"];
$comment=$_POST["comment"];
$send=$_POST["send"];
$editnumber=$_POST["editnumber"];
$date=date('Y年m月d日G時i分s秒');
$password=$_POST["password"];


if(!empty($send)){
  if(!empty($name)&&!empty($comment)&&!empty($password)){
    if(empty($editnumber)){
      $sql=$pdo->prepare("INSERT INTO file3 (name,comment,date,password)VALUES(:name,:comment,:date,:password)");
      $sql->bindParam(':name',$name,PDO::PARAM_STR);
      $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
      $sql->bindParam(':date',$date,PDO::PARAM_STR);
      $sql->bindParam(':password',$password,PDO::PARAM_STR);
      $sql->execute();
    }
  }
}
$delete=$_POST["delete"];
$delbutton=$_POST["delbutton"];
$password_delete=$_POST["password_delete"];
if(!empty($delbutton)){
  if(!empty($delete)){//削除番号が送信された
    $sql='SELECT*FROM file3';
    $results=$pdo->query($sql);
    foreach($results as $row){
      if($delete==$row['id']){
        if($password_delete==$row['password']){
        $id=$row['id'];
        $sql="delete from file3 where id=$id";
        $result=$pdo->query($sql);
        }
      }
    }
  }
}

$edit=$_POST["edit"];
$editbutton=$_POST["editbutton"];
$password_edit=$_POST["password_edit"];
if(!empty($editbutton)){
  if(!empty($edit)){
    $sql='SELECT*FROM file3';
    $results=$pdo->query($sql);
    foreach($results as $row){
      if($edit==$row['id']){
        if($password_edit==$row['password']){
          $editname=$row['name'];
          $editcomment=$row['comment'];
        }
      }
    }
  }
}
$editnumber=$_POST["editnumber"];
if(!empty($editnumber)){
  $sql='SELECT*FROM file3';
  $results=$pdo->query($sql);
  foreach($results as $row){
    if($editnumber==$row['id']){
      if($password==$row['password']){
        $id=$row['id'];
        $nm=$name;
        $kome=$comment;
        $date=date('Y年m月d日G時i分s秒');
        $sql="update file3 set name='$nm',comment='$kome',date='$date'where id=$id";
        $result=$pdo->query($sql);
      }
    }
  }
}
?>

<form action="mission_4.php" method="post">
名前:<input type="text"name="name"value="<?php echo $editname;?>"><br>
コメント:<input type="text"name="comment"value="<?php echo $editcomment;?>"><br>
パスワード:<input type="password" name="password" ><br>
<input type="submit"name="send"value="送信"><br><br>

<form action="mission_4.php"method="post">
<input type="text" name="editnumber" value="<?php echo $edit;?>"><br>


<form action="mission_4.php"method="post">
削除対象番号:<input type="text" name="delete"><br>
パスワード:<input type="password" name="password_delete" ><br>
<input type="submit"name="delbutton"value="削除"><br><br>

<form action="mission_4.php"method="post">
編集対象番号:<input type="text" name="edit"><br>
パスワード:<input type="password" name="password_edit" ><br>
<input type="submit" name="editbutton" value="編集"><br>

<?php

$sql='SELECT*FROM file3';
$results=$pdo->query($sql);
foreach($results as $row){
  echo $row['id'].',';
  echo $row['name'].',';
  echo $row['comment'].',';
  echo $row['date'].'<br>';
}
?>
</body>
</html>