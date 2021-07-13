<?php
header("Content-Type: application/json; charset=UTF-8");
require "../config/config.php";
$data = json_decode(file_get_contents('php://input'), true);
//print_r($data['username']);
//echo $data["operacion"];
//echo var_dump($_POST);
if(!empty($data['useremail'])&&!empty($data['password']))
{
    $email=$data['useremail'];
    $password=$data['password'];
    
    $sql1 = "SELECT * FROM User_Table WHERE user_email='{$email}' and user_password='{$password}'";
    //echo $sql;
    $result = mysqli_query($conn, $sql1);
    //print_r($result);
    $user=array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item['id']=$row["user_id"];
            $item['name']=$row["user_name"];
            $item['email']=$row["user_email"];
            
            array_push($user,$item);
        }
        
        response(1,"Success login",$user);
        
    }
    else{
        response(1,"Invalid useremail or password",NULL);
    }
}
else
{
    response(400,"Invalid Information",NULL);
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

