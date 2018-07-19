<?php
//データベース情報
$dsn = 'mysql:dbname=loope_cs; host=mysql626.db.sakura.ne.jp; charset=utf8;';
$user = 'loope';
$pass = '3638Kengo';
        
//データベース接続
try{
    $dbh = new PDO($dsn,$user,$pass);
}
catch(PDOExeption $error){
    echo "接続不良" .$error->getMessage();
    die();
}
?>