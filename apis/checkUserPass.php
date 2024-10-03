<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/profile.php";

//สร้าง Instance (Object/ตัวแทน)
$connDB = new ConnectDB();
$profile = new Profile($connDB->getConnectionDB());

//รับค่าจาก Client/User ซึ่งเป็น JSON มา Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

//เอาค่าในตัวแปรกำหนดให้กับ ตัวแปรของ Model ที่สร้างไว้
$profile->username = $data->username;
$profile->password = $data->password;

//เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $profile->checkUserPassword();

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result->rowCount() > 0) {
    //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    //สร้างตัวแปรอาร์เรย์เก็บข้อมูล
    $resultArray = array(
        "message" => "1",
        "user_id" => strval($user_id),
        "username" => strval($username),
        "password"=> strval($password),
        "email" => strval($email),
        "phone" => strval($phone)
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    //echo json_encode(array("message" => "เข้าสู่ระบบ!!"));
} else {
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode(array("message" => "ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง"));
}