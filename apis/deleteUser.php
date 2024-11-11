<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE"); // กำหนดให้สามารถใช้วิธี DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/profile.php";

// สร้าง Instance (Object/ตัวแทน)
$connDB = new ConnectDB();
$profile = new Profile($connDB->getConnectionDB());

// รับข้อมูล JSON ที่ส่งมาจาก Client
$data = json_decode(file_get_contents("php://input"));

// ตรวจสอบว่ามีการส่ง trip_id มาหรือไม่
if (isset($data->user_id)) {
    $profile->user_id = $data->user_id; // กำหนดค่า trip_id

    // เรียกใช้ฟังก์ชันสำหรับลบข้อมูลการเดินทาง
    if ($profile->deleteCust()) {
        // ส่งผลลัพธ์การลบข้อมูลสำเร็จ
        echo json_encode(array("message" => "1"));
    } else {
        // ส่งผลลัพธ์การลบข้อมูลไม่สำเร็จ
        echo json_encode(array("message" => "0"));
    }
} else {
    // ส่งผลลัพธ์เมื่อไม่มีการส่ง trip_id
    echo json_encode(array("message" => "ไม่พบ trip_id"));
}
