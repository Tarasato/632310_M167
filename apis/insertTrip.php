<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php";

//สร้าง Instance (Object/ตัวแทน)
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

//รับค่าจาก Client/User ซึ่งเป็น JSON มา Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

//เอาค่าในตัวแปรกำหนดให้กับ ตัวแปรของ Model ที่สร้างไว้
$trip->user_id = $data->user_id;
$trip->location_name = $data->location_name;
$trip->start_date = $data->start_date;
$trip->end_date = $data->end_date;
$trip->latitude = $data->latitude;
$trip->longitude = $data->longitude;
$trip->cost = $data->cost;
$trip->day_Travel = $data->day_Travel;


// กำหนดรายการรูปที่ต้องการอัปโหลด
$picture_keys = ['trippic', 'trippic2', 'trippic3'];

// วนลูปเพื่ออัปโหลดแต่ละรูปในรายการ
foreach ($picture_keys as $key) {
    if (!empty($data->$key)) { // ตรวจสอบว่ามีข้อมูลภาพในตัวแปรหรือไม่
        // เก็บรูป Base64 ไว้ในตัวแปร
        $picture_temp = $data->$key;

        // ตั้งชื่อรูปใหม่เพื่อใช้กับรูปที่เป็น Base64 ที่ส่งมา
        $picture_filename = "{$key}_" . uniqid() . "_" . round(microtime(true) * 1000) . ".png";

        // เอารูปที่เป็น Base64 แปลงเป็นรูปแล้วเก็บไว้ใน picupload/trippics/
        file_put_contents("./../picupload/trippics/" . $picture_filename, base64_decode($picture_temp));

        // เอาชื่อไฟล์ไปกำหนดให้กับตัวแปรที่จะเก็บลงในฐานข้อมูล
        $trip->$key = $picture_filename;
    }
}

$result = $trip->inserttrip();

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result == true) {
    //insert-update-delete สำเร็จ
    $resultArray = array(
        "message" => "1"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    //insert-update-delete ไม่สำเร็จ
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}







?>