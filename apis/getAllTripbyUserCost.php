<?php
// get_all_trip_by_User_api.php ดึงข้อมูลเฉพาะข้อมูลการเดินทางของสมาชิกคนนั้นๆ โดยค่าใช้จ่ายอยู่ในช่วงที่กำหนด

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //POST, PUT, DELETE
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
if (isset($data->user_id) && isset($data->min_cost) && isset($data->max_cost)) {
    
    // กำหนดค่าให้กับตัวแปรในคลาส Trip
    $trip->user_id = $data->user_id;
    $trip->min_cost = $data->min_cost;
    $trip->max_cost = $data->max_cost;

    // เรียกใช้ฟังก์ชันดึงข้อมูลทั้งหมดจากตาราง trip_tb ตามช่วงค่าใช้จ่าย
    $result = $trip->getAllTripByUserCost($min_cost, $max_cost);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->rowCount() > 0) {
        // ถ้ามีข้อมูล
        $resultInfo = array();

        // วนลูปเพื่อดึงข้อมูลจากผลลัพธ์
        while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($resultData);
            // สร้างตัวแปรอาร์เรย์เก็บข้อมูลแต่ละเรคอร์ด
            $resultArray = array(
                "message" => "1",
                "trip_id" => strval($trip_id),
                "user_id" => strval($user_id),
                "location_name" => $location_name,
                "start_date" => strval($start_date),
                "end_date" => strval($end_date),
                "latitude" => strval($latitude),
                "longitude" => strval($longitude),
                "cost" => strval($cost),
            );
            array_push($resultInfo, $resultArray);
        }

        // ส่งข้อมูล JSON กลับไปยัง Client
        echo json_encode($resultInfo, JSON_UNESCAPED_UNICODE);

    } else {
        // ถ้าไม่มีข้อมูล
        echo json_encode(array("message" => "ไม่มีข้อมูลการเดินทางที่ตรงตามเงื่อนไข"));
    }

} else {
    // กรณีที่ข้อมูลที่จำเป็นไม่ถูกส่งมาจาก Client
    echo json_encode(array("message" => "ข้อมูลไม่ครบถ้วน"));
}
