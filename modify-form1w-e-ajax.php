<?php
header("Content-Type: text/html; charset=utf-8");
$myhost     = $myhost;
$myuser     = $myuser;
$mypassword = $mypass;
$mydatabase = $mydb;

try{
    $pdo=new PDO(
      "mysql:host=".$myhost.";
      dbname=".$mydatabase,$myuser,$mypassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // echo "sucess";
}catch (PDOException $e){
    exit("DB CAN'T CONNECT!");
}


// var_dump($_POST);exit;

$str="";
$str.=" update exam_subj_area as c 
inner join exam_subj as a on a.ESID=c.ESID 
inner join exam_type as b on a.EID=b.EID        
        ";
foreach($_POST as $k=>$v)
{
    if($k=="Amount")
    {
        
        $k='set c.Amount';
        $str.=$k."='".$v."'";
    }
    if($k=="AID")
    {
        $value=$v;
    }

}
$str.=" where c.AID='$value'";
echo $str;
$sth=$pdo->prepare($str);
$sth->execute();


$str1.=" update exam_subj_area as c 
inner join exam_subj as a on a.ESID=c.ESID 
inner join exam_type as b on a.EID=b.EID        
        ";
foreach($_POST as $k=>$v)
{
    if($k=="remark1")
    {
        
        $k='set a.remark1';
        $str1.=$k."='".$v."'";
    }
    if($k=="AID")
    {
        $value=$v;
    }

}
$str1.=" where c.AID='$value'";
echo $str1;
$sth=$pdo->prepare($str1);
$sth->execute();

$str2.=" update exam_subj_area as c 
inner join exam_subj as a on a.ESID=c.ESID 
inner join exam_type as b on a.EID=b.EID        
        ";
foreach($_POST as $k=>$v)
{
    if($k=="remark2")
    {
        
        $k='set a.remark2';
        $str2.=$k."='".$v."'";
    }
    if($k=="AID")
    {
        $value=$v;
    }
}

$str2.=" where c.AID='$value'";
echo $str2;
$sth=$pdo->prepare($str2);
$sth->execute();

$str3.=" update exam_subj_area as c 
inner join exam_subj as a on a.ESID=c.ESID 
inner join exam_type as b on a.EID=b.EID        
        ";

foreach($_POST as $k=>$v)
{
    if($k=="Aname")
    {
        
        $k='set c.Aname';
        $str3.=$k."='".$v."'";
    }
    if($k=="AID")
    {
        $value=$v;
    }
}

$str3.=" where c.AID='$value'";
echo $str3;
$sth=$pdo->prepare($str3);
$sth->execute();



// echo $in_col."<br>";
// echo $in_key;
// echo "<script>alert('$_POST');</script>";
// $sql="update sign_up_data set name='2145' where Student_No='499999'";
// $sth=$pdo->prepare($sql);
// $sth->execute();

?>

<script>history.go(-1)</script>
