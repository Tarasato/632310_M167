<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php";

// สร้าง Instance (Object/ตัวแทน)
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

// รับข้อมูล JSON จาก Client
$data = json_decode(file_get_contents("php://input"));


    // กำหนดค่าให้กับตัวแปรในคลาส Trip
    $trip->trip_id = $data->trip_id;
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
        if($data->$key != ''){
            $picture_temp = $data->$key;

        // ตั้งชื่อรูปใหม่เพื่อใช้กับรูปที่เป็น Base64 ที่ส่งมา
        $picture_filename = "{$key}_" . uniqid() . "_" . round(microtime(true) * 1000) . ".png";

        // เอารูปที่เป็น Base64 แปลงเป็นรูปแล้วเก็บไว้ใน picupload/trippics/
        file_put_contents("./../picupload/trippics/" . $picture_filename, base64_decode($picture_temp));

        // เอาชื่อไฟล์ไปกำหนดให้กับตัวแปรที่จะเก็บลงในฐานข้อมูล
        $trip->$key = $picture_filename;
        }
        
    }
}

    // เรียกใช้ฟังก์ชันเพื่ออัปเดตข้อมูลการเดินทาง
    if ($trip->updateTrip()) {
        echo json_encode(array("message" => "1"));
    } else {
        echo json_encode(array("message" => "0"));
    }
