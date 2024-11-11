<?php //get_all_trip_by_User_api.php ดึงข้อมูลเฉพาะข้อมูลการกินของสมาชิกคนนั้นๆเท่านั้น
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/trip.php";

//สร้าง Instance (Object/ตัวแทน)
$connDB = new ConnectDB();
$trip = new Trip($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$trip->user_id = $data->user_id;
//เรียกใช้ฟังก์ชันดึงข้อมูลทั้งหมดจากตาราง trip_tb
$result = $trip->getAllTripByUserID();

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result->rowCount() > 0) {
    //มี
    $resultInfo = array();

    //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);
        //สร้างตัวแปรอาร์เรย์เก็บข้อมูล
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
            "trippic" => strval($trippic),
            "trippic2" => strval($trippic2),
            "trippic3" => strval($trippic3),
            "day_Travel" => strval($day_Travel)
        );
        array_push($resultInfo, $resultArray);
    }


    echo json_encode($resultInfo, JSON_UNESCAPED_UNICODE);
} else {
    $resultInfo = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultInfo, $resultArray);
    echo json_encode(array("message" => "0"));
}