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

// ตรวจสอบว่าข้อมูลที่จำเป็นถูกส่งมาจากฝั่ง Client หรือไม่
if (
    isset($data->trip_id) &&
    isset($data->user_id) &&
    isset($data->location_name) &&
    isset($data->start_date) &&
    isset($data->end_date) &&
    isset($data->latitude) &&
    isset($data->longitude) &&
    isset($data->cost)
) {
    // กำหนดค่าให้กับตัวแปรในคลาส Trip
    $trip->trip_id = $data->trip_id;
    $trip->user_id = $data->user_id;
    $trip->location_name = $data->location_name;
    $trip->start_date = $data->start_date;
    $trip->end_date = $data->end_date;
    $trip->latitude = $data->latitude;
    $trip->longitude = $data->longitude;
    $trip->cost = $data->cost;

    // เรียกใช้ฟังก์ชันเพื่ออัปเดตข้อมูลการเดินทาง
    if ($trip->updateTrip()) {
        echo json_encode(array("message" => "1"));
    } else {
        echo json_encode(array("message" => "0"));
    }
} else {
    // กรณีที่ข้อมูลที่จำเป็นไม่ครบถ้วน
    echo json_encode(array("message" => "ข้อมูลไม่ครบถ้วน"));
}
