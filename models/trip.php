<?php

class Trip{
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $trip_id;
    public $user_id;
    public $start_date;
    public $end_date;
    public $location_name;
    public $latitude;
    public $longitude;
    public $cost;
    public $min_cost;
    public $max_cost;
    public $created_at;
     //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }

    //----------------------------------------------------------
public function getAllTrip()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM trip_tb";

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูล trip
    public function insertTrip()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "  INSERT INTO trip_tb ( `user_id`, `location_name`,`start_date`, `end_date`, `latitude`, `longitude`, `cost`) VALUES (:user_id, :location_name, :start_date, :end_date, :latitude, :longitude, :cost);";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $this->location_name = htmlspecialchars(strip_tags($this->location_name));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->latitude = htmlspecialchars(strip_tags($this->latitude));
        $this->longitude = htmlspecialchars(strip_tags($this->longitude));
        $this->cost = intval(htmlspecialchars(strip_tags($this->cost)));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":location_name", $this->location_name);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":cost", $this->cost);


        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชันดึงข้อมูลเฉพาะข้อมูลการกินของสมาชิกคนนั้นๆเท่านั้นจากตาราง trip_tb
    public function getAllTripByUserID()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM trip_tb" . " WHERE user_id = :user_id";

        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันดึงข้อมูลเฉพาะข้อมูลของสมาชิกคนนั้นๆเท่านั้นตามวันที่จากตาราง trip_tb
    public function getAllTripByUserIDDate()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND start_date >= :start_date AND end_date <= :end_date";

        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันดึงข้อมูลเฉพาะข้อมูลของสมาชิกคนนั้นๆตามสถานที่ที่ระบุจากตาราง trip
    public function getAllTripByUserLocation()
{
    // ตัวแปรเก็บคำสั่ง SQL
    $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND location_name LIKE :location_name";

    // ตรวจสอบและกำหนดค่าตัวแปร
    $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
    $location_name = "%" . htmlspecialchars(strip_tags($this->location_name)) . "%"; 

    // สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    // กำหนดค่าให้กับ parameters
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":location_name", $location_name);

    // สั่งให้ SQL ทำงาน
    $stmt->execute();

    // ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
    return $stmt;
}

//แก้ไขข้อมูล
public function updateTrip()
{
    // ตัวแปรเก็บคำสั่ง SQL สำหรับการอัปเดตข้อมูล
    $strSQL = "UPDATE trip_tb 
               SET user_id = :user_id, 
                   location_name = :location_name, 
                   start_date = :start_date, 
                   end_date = :end_date, 
                   latitude = :latitude, 
                   longitude = :longitude, 
                   cost = :cost 
               WHERE trip_id = :trip_id";

    // ตรวจสอบและทำความสะอาดค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
    $this->location_name = htmlspecialchars(strip_tags($this->location_name));
    $this->start_date = htmlspecialchars(strip_tags($this->start_date));
    $this->end_date = htmlspecialchars(strip_tags($this->end_date));
    $this->latitude = htmlspecialchars(strip_tags($this->latitude));
    $this->longitude = htmlspecialchars(strip_tags($this->longitude));
    $this->cost = floatval(htmlspecialchars(strip_tags($this->cost)));
    $this->trip_id = intval(htmlspecialchars(strip_tags($this->trip_id)));

    // สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    // กำหนดค่าให้กับ parameters
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":location_name", $this->location_name);
    $stmt->bindParam(":start_date", $this->start_date);
    $stmt->bindParam(":end_date", $this->end_date);
    $stmt->bindParam(":latitude", $this->latitude);
    $stmt->bindParam(":longitude", $this->longitude);
    $stmt->bindParam(":cost", $this->cost);
    $stmt->bindParam(":trip_id", $this->trip_id);

    // สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าอัปเดตข้อมูลสำเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// ฟังก์ชันสำหรับลบข้อมูลการเดินทางตาม trip_id
public function deleteTrip()
{
    // ตัวแปรเก็บคำสั่ง SQL
    $strSQL = "DELETE FROM trip_tb WHERE trip_id = :trip_id";

    // ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters
    $this->trip_id = intval(htmlspecialchars(strip_tags($this->trip_id)));

    // สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    // กำหนดค่าให้กับ parameters
    $stmt->bindParam(":trip_id", $this->trip_id);

    // สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสำเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

public function getAllTripByUserCost($min_cost, $max_cost)
    {
        // คำสั่ง SQL สำหรับค้นหาทริปตามช่วงค่าใช้จ่าย
        $strSQL = "SELECT * FROM trip_tb WHERE user_id = :user_id AND cost BETWEEN :min_cost AND :max_cost";

        // สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        // Bind parameters
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":min_cost", $min_cost);
        $stmt->bindParam(":max_cost", $max_cost);

        // สั่งให้ SQL ทำงาน
        $stmt->execute();

        // ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }


}