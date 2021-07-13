<?php
header("Content-Type: application/json; charset=UTF-8");
require "../config/config.php";
$data = json_decode(file_get_contents('php://input'), true);
//print_r($data['username']);
//echo $data["operacion"];
//echo var_dump($_POST);
$m_s_name="";
$m_s_id="";

$maincategory=array();
$sql1 = "SELECT * FROM MainServiceCategory";
$result = mysqli_query($conn, $sql1);
while($row = $result->fetch_assoc()) {
    $mitem['id']=$row["m_s_cate_id"];
    $mitem['name']=$row["m_s_cate_name"];
    array_push($maincategory,$mitem);
}
$data['maincategory']=$maincategory;

$subcategory=array();
$sql1 = "SELECT * FROM SubServiceCategory";
$result = mysqli_query($conn, $sql1);
while($row = $result->fetch_assoc()) {
    $sitem['id']=$row["s_s_cate_id"];
    $sitem['name']=$row["s_s_cate_name"];
    $sitem['m_id']=$row["m_s_cate_id"];
    
    array_push($subcategory,$sitem);
}
$data['subcategory']=$subcategory;

$country=array();
$sql1 = "SELECT * FROM Country";
$result = mysqli_query($conn, $sql1);
while($row = $result->fetch_assoc()) {
    $coitem['id']=$row["co_id"];
    $coitem['name']=$row["co_name"];
    array_push($country,$coitem);
}
$data['country']=$country;

$city=array();
$sql1 = "SELECT * FROM City";
$result = mysqli_query($conn, $sql1);
while($row = $result->fetch_assoc()) {
    $ciitem['id']=$row["ci_id"];
    $ciitem['name']=$row["ci_name"];
    $ciitem['co_id']=$row["co_id"];
    array_push($city,$ciitem);
}
$data['city']=$city;

$business=array();
$sql1 = "SELECT * FROM Business";
$result = mysqli_query($conn, $sql1);
while($row = $result->fetch_assoc()) {
    $bitem['id']=$row["b_id"];
    $bitem['name']=$row["_name"];
    $bitem['co_id']=$row["co_id"];
    array_push($city,$ciitem);
}
$data['city']=$city;

response(0,"success",$data);

            //print_r($ci_id);

function response($status,$status_message,$data)
{
    //header("HTTP/1.1 ".$status);

    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;

    $json_response = json_encode($response);
    echo $json_response;
}

