<?php

class Profile{
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $user_id;
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $phone;
    //public $userpicture;
     //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }

    //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis
    public function checkUserPassword(){
        $strSQL = "SELECT * FROM myprofile_tb WHERE username = :username AND password = :password";

    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":password", $this->password);

    //สั่งsqlให้ทำงาน
    $stmt->execute();
    //ส่งค่าการทำงานกลับไปยังจุดเรียกใช้งานฟังก์ชั่น 
    return $stmt;
    }

    //function newProfile
    public function newProfile()
    {
    //ตัวแปรคำสั่งsql
    $strSQL = "INSERT INTO myprofile_tb ( `fullname`,`phone`,`username`,`password`,`email`) VALUES ( :fullname, :phone, :username, :password, :email);";
        
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->fullname = htmlspecialchars(strip_tags($this->fullname));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    //$this->userpicture = htmlspecialchars(strip_tags($this->userpicture));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":fullname", $this->fullname);
    $stmt->bindParam(":phone", $this->phone);
    //$stmt->bindParam(":userpicture", $this->userpicture);

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

//function updateCustAPI
public function updateCust(){   
    $strSQL = "";

    $strSQL = "UPDATE customer_tb SET 
    username = :username, 
    email = :email, 
    custPhonenum = :custPhonenum, 
    password = :password 
    WHERE user_id = :user_id;";

    
    //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->email = intval(htmlspecialchars(strip_tags($this->email)));
    $this->password = htmlspecialchars(strip_tags($this->password));

    //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);

    //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}   

    //function deleteCust
    public function deleteCust()
    {
        $strSQL = "DELETE FROM myprofile_tb WHERE user_id = :user_id";
        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
}

}