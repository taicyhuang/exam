<?php
header("Content-Type: text/html; charset=utf-8");
$myhost     = $myhost;
$myuser     = "root";
$mypassword = "$mypass";
$mydatabase = "$mypass";

try{
    $pdo=new PDO(
      "mysql:host=".$myhost.";
      dbname=".$mydatabase,$myuser,$mypassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // echo "sucess";
}catch (PDOException $e){
    exit("DB CAN'T CONNECT!");
}

session_start();

    if(empty($_SESSION['type']))
    {
        $select_op=$_POST['ename'];
        $_SESSION['type']=$select_op;   
    }
    if(empty($_POST['type']))
    {
        // echo $_SESSION['type']."--2--";
        $select_op= $_SESSION['type'];
    }

    //TODO下拉是選單流程要調整
    // echo $select_op;
    $type="";
    $action_editor=$_POST['editor'];
    $action_del=$_POST['del'];
    $aid=$_POST['aid'];

    if(!empty($action_editor))
    {





        $_sql="select c.AID ,c.Amount  ,Aname , a.remark1  ,a.remark2     from exam_subj as a
        left  join exam_type as b on a.EID=b.EID
        left join exam_subj_area as c  on a.ESID=c.ESID 
        where c.AID='$aid'"; 
        // where c.type='$select_op'";
        echo $_sql;
        $statement = $pdo->prepare($_sql);
        $statement->execute();
        $results=$statement->fetchAll(PDO::FETCH_ASSOC);
        $str.="<form action='modify-form1w-e-ajax.php' name='form_editor' id='form_editor' method='post'>";
        $str.="<table border='1'>";
        $str.= "<tr><td>專屬代碼</td><td>錄取名額</td><td>分發單位</td><td>測驗科目</td><td>工作內容簡述</td></tr>";
        foreach($results as $k=>$v)
        {
            $str.= "<tr>";
            foreach($v as $k1=>$v1)
            {
                if($k1=="AID")
                {

                    $id='"'.$v1.'"';
                    $str.="<input type='hidden' name='$k1' id='$k1' value='$v1'>";
                    $str.="<td>$v1</td>";
                }
                elseif($k1=="remark1")
                {
                    $str.="<td><textarea cols='50' rows='10' id='$k1' name='$k1' >$v1</textarea></td>";
                }
                elseif($k1=="remark2")
                {
                    $str.="<td><textarea cols='50' rows='10' id='$k1' name='$k1' >$v1</textarea></td>";
                }
                else
                {
                    $str.= "<td><input type='text' name='$k1' id='$k1' value='$v1'></td>";
                }

                 
            }
            $str.= "</tr>";
        }

            $str.= "</table>";
            $str.="<td><button onclick='chkedit($id)';>確定</button></td>";
            $str.="</form>";     
    }
    if(!empty($_POST['ename']) || !empty($_SESSION['type'])){
    if($select_op != ""){ 
   
            if($select_op == "營運專員類組"){ 
                    // echo "A"; 
                $type="A";

                    
             }else if($select_op == "營運員類組")
             { 
                $type="B";
                    // echo "B"; 
             }else if($select_op == "服務員類組")
             { 
                $type="C";
                    // echo "C"; 
             } 
             else if($select_op =="服務佐理類組")
             {
                $type="D";
                    // echo "D";
             }
        }else{ 
 
              echo "請選擇一個選項"; 
        }
}
        $_SESSION['type']=$_POST['name'];//因為POST只會吃一次,所以用session帶type的值
                // echo "是否要新增".$_SESSION['type']."<br>";
                // echo "這邊是POST".$_POST['ename']."<br>".$type;
   
        $_sql="select c.AID ,c.Amount  ,Aname , a.remark1  ,a.remark2     from exam_subj as a
        left  join exam_type as b on a.EID=b.EID
        left join exam_subj_area as c  on a.ESID=c.ESID 
        where c.type='$type'";

        $statement = $pdo->prepare($_sql);
        $statement->execute();
        $results=$statement->fetchAll(PDO::FETCH_ASSOC);

        $type_4='"'.$type.'"'; //function 要傳值過去前都要先處理
        
        $str.="<table border='1'>";
      
        foreach($results as $k =>$value)
        {
            $str.="<tr><td>專屬代碼</td><td>錄取名額</td><td>分發單位</td><td>測驗科目</td><td>工作內容簡述</td><td>新增</td><td>編輯</td><td>刪除</td></tr>";
            $str.="<tr>";
            foreach($value as $k1=>$v1)
            {
                if($k1=='ESID')
                {
                    $esid=$v1;
                }       
                if($k1=="AID")
                {
                    $id='"'.$v1.'"';
                    $str.="<td>$v1</td>";
                }
                elseif($k1=="remark2")
                {
                    $str.="<td>$v1</td>";
                }
                else
                {
                    $str.= "<td>$v1</td>";
                }

           
            }
            $str.="<td><button><a href='modify-form1w-add-ajax.php?add=$id'>新增項目</a></button></td>";
            $str.="<td><button onclick='edit($id)';>編輯</button></td>";
            $str.="<td><button onclick='del($id)';>刪除</button></td>";
            $str.="</tr>";
      
        }
        $str.="</table>";
        echo $str;
        
       


    

?>
