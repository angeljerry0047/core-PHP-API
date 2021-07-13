<?php
header("Content-Type: application/json; charset=UTF-8");
require "../config/config.php";
$data = json_decode(file_get_contents('php://input'), true);
//print_r($data['username']);
//echo $data["operacion"];
//echo var_dump($_POST);
if(!empty($data['m_service'])&&!empty($data['s_service'])&&!empty($data['useremail'])&&!empty($data['b_name'])&&!empty($data['co_name'])&&!empty($data['ci_name'])&&!empty($data['b_adress'])&&!empty($data['b_phonenumber'])&&!empty($data['b_siteurl']))
{
    $co_name=$data['co_name'];
    $sql1 = "SELECT * FROM Country WHERE co_name='{$co_name}'";
    $result = mysqli_query($conn, $sql1);
    //print_r($result);
    $co_id="";
    $ci_id="";
    $user_id="";
    $m_s_id="";
    $s_s_id="";
    $b_name=$data['b_name'];
    $b_address=$data['b_adress'];
    $b_phonenumber=$data['b_phonenumber'];
    $b_siteurl=$data['b_siteurl'];
    
    
    if ($result->num_rows < 1) {
       $sql2="INSERT INTO Country (co_name) VALUES ('{$co_name}')";
       mysqli_query($conn, $sql2);
       $co_id = $conn->insert_id;
       
        $ci_name=$data['ci_name'];
        $sql2="INSERT INTO City (ci_name,co_id) VALUES ('{$ci_name}','{$co_id}')";
        mysqli_query($conn, $sql2);
        $ci_id = $conn->insert_id;
        //print_r($ci_id);
        //response($ci_id,"REGISTE",NULL);
    }
    else{
       $sql1 = "SELECT * FROM Country WHERE co_name='{$co_name}'";
       $result = mysqli_query($conn, $sql1);
       
       while($row = $result->fetch_assoc()) {
         $co_id=$row["co_id"];
        }
       //print_r($co_id);
       $ci_name=$data['ci_name'];
       $sql1 = "SELECT * FROM City WHERE ci_name='{$ci_name}' and co_id='{$co_id}'";
       $result = mysqli_query($conn, $sql1);
       if($result->num_rows<1){
           $sql2="INSERT INTO City (ci_name,co_id) VALUES ('{$ci_name}','{$co_id}')";
            mysqli_query($conn, $sql2);
            $ci_id = $conn->insert_id;
       }
       else{
          $sql2 = "SELECT * FROM City WHERE ci_name='{$ci_name}' and co_id='{$co_id}'";
          $result = mysqli_query($conn, $sql2);
       
           while($row = $result->fetch_assoc()) {
             $ci_id=$row["ci_id"];
            } 
            //print_r($ci_id);
       }
       
       
       //response(400,"asd",NULL);
    }
    //get userid
       
       $user_email=$data['useremail'];
       $sql1 = "SELECT * FROM User_Table WHERE user_email='{$user_email}'";
       $result = mysqli_query($conn, $sql1);
       while($row = $result->fetch_assoc()) {
             $user_id=$row["user_id"];
            }
            
        //get mainservice category id
        $m_s_name=$data['m_service'];
       $sql1 = "SELECT * FROM MainServiceCategory WHERE m_s_cate_name='{$m_s_name}'";
       $result = mysqli_query($conn, $sql1);
       while($row = $result->fetch_assoc()) {
             $m_s_id=$row["m_s_cate_id"];
            }
            
        //get subservice category id
        $s_s_name=$data['s_service'];
         
       $sql1 = "SELECT * FROM SubServiceCategory WHERE s_s_cate_name='{$s_s_name}' and m_s_cate_id='{$m_s_id}'";
       $result = mysqli_query($conn, $sql1);
       
       while($row = $result->fetch_assoc()) {
             $s_s_id=$row["s_s_cate_id"];
            }
       
       $sql1 = "SELECT * FROM Business WHERE user_id='{$user_id}'";
       $result = mysqli_query($conn, $sql1);
       
       if($result->num_rows<1){
           $sql2="INSERT INTO Business (b_name,m_s_id,s_s_id,co_id,ci_id,b_adress,b_phonenumber,b_siteurl,user_id) VALUES ('{$b_name}','{$m_s_id}','{$s_s_id}','{$co_id}','{$ci_id}','{$b_address}','{$b_phonenumber}','{$b_siteurl}','{$user_id}')";
            mysqli_query($conn, $sql2);
            response(1,"success register",NULL);
       }
       else{
           $b_id="";
           while($row = $result->fetch_assoc()) {
             $b_id=$row["b_id"];
            }
            print_r($b_id);
           $sql2="UPDATE Business SET b_name='{$b_name}',m_s_id='{$m_s_id}',s_s_id='{$s_s_id}',co_id='{$co_id}',ci_id='{$ci_id}',b_adress='{$b_address}',b_phonenumber='{$b_phonenumber}',b_siteurl='{$b_siteurl}' WHERE b_id='{$b_id}'";
            mysqli_query($conn, $sql2);
           
           
           response(2,"success updated.",NULL);
       }
   
}
else
{
    response(400,"Invalid Information(exit empty field)",NULL);
}

function response($status,$status_message,$data)
{
    //header("HTTP/1.1 ".$status);

    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;

    $json_response = json_encode($response);
    echo $json_response;
}

