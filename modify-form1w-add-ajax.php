<?php


header("Content-Type: text/html; charset=utf-8");
$myhost     = "172.16.44.8";
$myuser     = "root";
$mypassword = "seat";
$mydatabase = "tra_y2019";

try{
    $pdo=new PDO(
      "mysql:host=".$myhost.";
      dbname=".$mydatabase,$myuser,$mypassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

}catch (PDOException $e){
    exit("DB CAN'T CONNECT!");
}





$get_type=substr($_GET['add'],1,-3);
$type="";
$sql_type="select EID,ESID from exam_subj where ESID='$get_type' ";
$sth_type=$pdo->prepare($sql_type);
$sth_type->execute();

foreach($sth_type as $key=>$row)
{
  foreach($row as $k1=>$v1)
  {
    if($k1=='EID')
    {

      $type=$v1;

    }
  }
}



$new_no="";//AID製作 $type+00自動流水編號 目前最多就到99 以後再填空
$sql_aid="select AID from exam_subj_area where type='$type' and esid='$get_type' order by AID desc limit 1 ";
// echo $sql_aid;
$sth_aid=$pdo->prepare($sql_aid);
$sth_aid->execute();
foreach($sth_aid as $key=>$value)
{
  foreach($value as $k1=>$v1)
  {
    $tmp_no=$v1;
  }
}
// echo $tmp_no."--<br>";

$num="";
$right_num="";//新的正確編碼

//處理正確編號
// echo $tmp_no."<br>";
$tmp_right=substr($tmp_no,3);//撈出最新一筆後的資料 後面流水後頂多到99
$tmp_right=$tmp_right+1;
$tmp_right=str_pad($tmp_right,'2','0',STR_PAD_LEFT); 
$right_num=$get_type.$tmp_right;//正確編碼


/////////////
// for($i=0;$i<=99;$i++)
// {

//     $tmp_num=str_pad($i,'2','0',STR_PAD_LEFT); 
//     $num=$get_type.$tmp_num;//編碼過後的AID
    
//     if($num==$tmp_no)
//     {
      
//       // $i=$i+1;
//       // $tmp_num1=str_pad($i,'2','0',STR_PAD_LEFT); 
//       // $right_num=$get_type.$tmp_num1;
//     }
    

// }



if($_POST)
{

  foreach($_POST as $key=>$value)
  {
    // echo $key."->".$value."<br>";
    if($key=="EID")
    {
      $key="type";      
    }
    if($key=="remark1")
    {
      $key="";
    }
    elseif($key=="remark2")
    {
      $key="";
    }
    elseif($key=="abor")
    {
      $key="";
    }
    else
    {
      $str.="`".$key."`,";

    }
  }
  $insert=substr($str,0,-1);

  foreach($_POST as $key=>$value)
  {
    // echo $key."->".$value."<br>";
    if($key=="remark1")
    {
      $value="";
    }
    elseif($key=="remark2")
    {
      $value="";
    }
    else
    {
      $str_value.="'".$value."',";
  
    }
  }
  $str_value=substr($str_value,0,-1);



}

$sql="insert into exam_subj_area($insert,`ESID`)values($str_value,'$right_num')";
$sth=$pdo->prepare($sql);
$sth->execute();
// echo $sql;
// echo mysql_num_rows($sth)."111";


// echo "<br>".$get_type;





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
    <input type="hidden" id="EID" name="EID" value="<?php echo $type;?>">
        <tr><td>編碼</td><td>錄取名額</td><td>分發單位</td></tr>
        <tr>
        <td><input type='hidden' name='AID' id='AID' value='<?php echo $right_num;?>'><?php echo $right_num;?></td>
        <td><input type='text' name='Amount' id='Amount' placeholder='錄取名額'></td>
        <td><input type='text' name='Aname' id='Aname' placeholder='格式(區域-分發單位)'></td>

        
        </tr>

    </table>
    <input type="submit" value="確認上傳"></button>
    </form>
  </center>
  </body>
</html>

