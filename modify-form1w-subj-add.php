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


$select_op=$_GET['add'];

if($select_op != ""){ 
   
    if($select_op == "營運專員類組"){ 
            // echo "A"; 
        $EID="A";
        $ENo='1';

            
     }else if($select_op == "營運員類組")
     { 
        $EID="B";
        $ENo='2';
            // echo "B"; 
     }else if($select_op == "服務員類組")
     { 
        $EID="C";
        $ENo='3';
            // echo "C"; 
     } 
     else if($select_op =="服務佐理類組")
     {
        $EID="D";
        $ENo='4';
            // echo "D";
     }
}else{ 

      echo "請選擇一個選項"; 
}

$sql="select ESID from exam_subj where eid='$EID' order by esid desc limit 1";
$sth=$pdo->prepare($sql);
$sth->execute();

foreach($sth as $key=>$value)
{
    foreach($value as $k1=>$v1)
    {
        
    }
    $tmp_esid=$v1;
}

$tmp_esid=substr($tmp_esid,1);
$tmp_esid=$tmp_esid+1;
if(strlen($tmp_esid)<2)
{
    $tmp_esid=str_pad($tmp_esid,2,0,STR_PAD_LEFT);
}
$esid=$EID.$tmp_esid;//ESID新的



// var_dump($_POST);
foreach($_POST as $key=>$value)
{
    // echo $key."->".$value."<br>";
    $tmp_key.="`".$key."`,";
    $tmp_value.="'".$value."',";
    if($key=="EID")
    {
        $e_eid=$value;
    }
}
$in_key=substr($tmp_key,0,-1);
$in_value=substr($tmp_value,0,-1);

$sql="insert into exam_subj($in_key) values($in_value)";
$sth=$pdo->prepare($sql);
$sth->execute();
// echo $sql;

// $sql="insert into exam_subj_area(`esid`,`type`)values('$esid','$e_eid');";
// $sth=$pdo->prepare($sql);
// $sth->execute();

if($sth->rowCount()!=0)
{
header('location:modify-from1w.php');

} 
// echo $sql;
?>


<!DOCTYPE html>
  <head>
    <title>ADD</title>
  </head>
  <script>

  </script>
  <body>
  <center>
    <form action="" method="POST">
    <table border='1'>
    <input type="hidden" id="EID" name="EID" value="<?php echo $EID;?>">
    <input type="hidden" id="ENo" name="ENo" value="<?php echo $ENo;?>">
    <input type="hidden" id="esid" name="esid" value="<?php echo $esid;?>">
        <tr><td>EID</td><td>ENO</td><td>ESID</td><td>測驗科目</td><td>工作內容簡述</td><td>科目</td><td>科目簡稱</td><td>身分</td></tr>
        <tr>
        <td><?php echo $EID;?></td>
        <td><?php echo $ENo;?></td>
        <td><?php echo $esid;?></td>
        <td><input type="text" name="Esname" id="Esname"></td>
        <td><input type="text" name="Esname2" id="Esname2"></td>
        <td><textarea cols="30" rows="20" name="remark1" id="remark1"></textarea></td>
        <td><textarea cols="30" rows="20"  name="remark2" id="remark2"></textarea></td>
        <td>
            <input type="radio" name="abor" id="abor" value='0'>一般身分<br/>
            <input type="radio" name="abor" id="abor" value='1'>原住民<br/>
            <input type="radio" name="abor" id="abor" value='2'>身心障礙<br/>
            <input type="radio" name="abor" id="abor" value='3'>員工協助<br/>
            <input type="radio" name="abor" id="abor" value='4'>產學合作<br/>
        </td>
        
        </tr>

    </table>
    <input type="submit" value="確認上傳"></button>
    </form>
  </center>
  </body>
</html>

