<?php 
// echo $_POST['aid'];
// var_dump($_POST);

// echo "1";
header("Content-Type: text/html; charset=utf-8");
$myhost     = $myhost;
$myuser     = $myuser;
$mypassword = $mypas;
$mydatabase = $mydb;

try{
    $pdo=new PDO(
      "mysql:host=".$myhost.";
      dbname=".$mydatabase,$myuser,$mypassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // echo "sucess";
}catch (PDOException $e){
    exit("DB CAN'T CONNECT!");
}
// select c.AID ,c.Amount  ,Aname , a.remark1  ,a.remark2     from exam_subj as a
//         left  join exam_type as b on a.EID=b.EID
//         left join exam_subj_area as c  on a.ESID=c.ESID 
// echo $_POST['aid'];
$sql="DELETE from  exam_subj_area  where AID='".$_POST['aid']."'";
// echo $sql;
$sth=$pdo->prepare($sql);
$sth->execute();
?>
