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
    public $upic;
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
        $strSQL = "SELECT * FROM myprofile_tb WHERE BINARY username = :username AND password = :password";

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
        // ตรวจสอบว่า ชื่อ ซ้ำหรือไม่ (case-insensitive)
    $strSQL = "SELECT * FROM myprofile_tb WHERE LOWER(fullname) = LOWER(:fullname)";
    $stmt = $this->connDB->prepare($strSQL);
    $stmt->bindParam(":fullname", $this->fullname);
    $stmt->execute();

    // ถ้าพบข้อมูลแสดงว่า ชื่อ ซ้ำ
    if ($stmt->rowCount() > 0) {
        return '3'; // บอกว่ามี ชื่อ ซ้ำ
    }

    // ตรวจสอบว่า username ซ้ำหรือไม่ (case-insensitive)
    $strSQL = "SELECT * FROM myprofile_tb WHERE LOWER(username) = LOWER(:username)";
    $stmt = $this->connDB->prepare($strSQL);
    $stmt->bindParam(":username", $this->username);
    $stmt->execute();

    // ถ้าพบข้อมูลแสดงว่า username ซ้ำ
    if ($stmt->rowCount() > 0) {
        return '2'; // บอกว่ามี username ซ้ำ
    }
    //ตัวแปรคำสั่งsql
    $strSQL = "INSERT INTO myprofile_tb ( `fullname`,`phone`,`username`,`password`,`email`,`upic`) VALUES ( :fullname, :phone, :username, :password, :email, :upic);";
        
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->fullname = htmlspecialchars(strip_tags($this->fullname));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->upic = htmlspecialchars(strip_tags($this->upic));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":fullname", $this->fullname);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":upic", $this->upic);

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return '1';
    } else {
        return '0';
    }

    }

//function updateCustAPI
public function updateProfile(){
    if(isset($data->fullname)){
        // ตรวจสอบว่า ชื่อ ซ้ำหรือไม่ (case-insensitive)
    $strSQL = "SELECT * FROM myprofile_tb WHERE LOWER(fullname) = LOWER(:fullname)";
    $stmt = $this->connDB->prepare($strSQL);
    $stmt->bindParam(":fullname", $this->fullname);
    $stmt->execute();

    // ถ้าพบข้อมูลแสดงว่า ชื่อ ซ้ำ
    if ($stmt->rowCount() > 0) {
        return 2; // บอกว่ามี ชื่อ ซ้ำ
    }
    }

    $strSQL = "";
    if($this->fullname == "" && $this->upic == "") { // ใช้ได้
        $strSQL = "UPDATE myprofile_tb SET `email` = :email, `phone` = :phone, `password` = :password WHERE `user_id` = :user_id";
    } elseif($this->fullname == "" && $this->upic != "") {// ใช้ได้
        $strSQL = "UPDATE myprofile_tb SET `email` = :email, `phone` = :phone, `password` = :password, `upic` = :upic WHERE `user_id` = :user_id";
    } elseif($this->fullname != "" && $this->upic != "") { // ใช้ได้
        $strSQL = "UPDATE myprofile_tb SET `fullname` = :fullname, `email` = :email, `phone` = :phone, `password` = :password, `upic` = :upic WHERE `user_id` = :user_id";
    } elseif($this->fullname != '') {
        $strSQL = "UPDATE myprofile_tb SET `fullname` = :fullname, `email` = :email, `phone` = :phone, `password` = :password WHERE `user_id` = :user_id";
    }
    
    
    //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    if($this->upic != ""){$this->upic = htmlspecialchars(strip_tags($this->upic));}
    if($this->fullname != ""){$this->fullname = htmlspecialchars(strip_tags($this->fullname));}

    //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":phone", $this->phone);
    if($this->upic != ""){$stmt->bindParam(":upic", $this->upic);}
    if($this->fullname != ""){$stmt->bindParam(":fullname", $this->fullname);}

    //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
    if ($stmt->execute()) {
        return 1;
    } else {
        return 0;
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