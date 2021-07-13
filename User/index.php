

<?php
header("Content-Type: application/json; charset=UTF-8");
require "../config/config.php";
$data = json_decode(file_get_contents('php://input'), true);
//print_r($data['username']);
//echo $data["operacion"];
//echo var_dump($_POST);
if(!empty($data['username'])&&!empty($data['useremail'])&&!empty($data['password']))
{
    $name=$data['username'];
    $email=$data['useremail'];
    $password=$data['password'];
    
    $sql1 = "SELECT * FROM User_Table WHERE user_email='{$email}'";
    //echo $sql;
    $result = mysqli_query($conn, $sql1);
    //print_r($result);
    if ($result->num_rows > 0) {
        response(3,"already exist",NULL);
        exit();
    }
    
    $sql = "INSERT INTO User_Table (user_name,user_email,user_password)VALUES ('{$name}','{$email}','{$password}')";
    if (mysqli_query($conn, $sql)) {
        response(1,"success register",NULL);
    } else {
        response(1,"error connect db",NULL);
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

