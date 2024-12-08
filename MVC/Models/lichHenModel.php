<?php

class lichHenModel extends connectDB
{
    protected $c;
    private  $maBacSi;
    private $ngayHen;
    private $maDichVu;
    private $soThuTu;
    private $maBenhNhan	;
    private $maKhoa	;
    
  
    function __construct()
    {
        $this->c = new connectDB();
    }
    function message(  $status ,$mess , $textH){
        $data = [
            'status' => $status,
            'message' => $mess,
            'data' => null
        ];
        header("HTTP/1.0 " . $textH);
        return json_encode($data);
    }
    function getLichHenList()
    {
        $sql = "SELECT * FROM lichhen";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách lịch hẹn',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có lịch hẹn nào!' , "404 Không có lịch hẹn nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getLichHen($id)
    {
        $sql = "SELECT * FROM lichhen WHERE  maLichHen = $id";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Lịch hẹn có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có lịch hẹn nào!' , "404 Không có lịch hẹn nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }


    function  checkData ( $lichHenInput ){
       
        $this -> maBacSi = $lichHenInput["maBacSi"] ;
        $this -> ngayHen = $lichHenInput["ngayHen"];
        $this -> maDichVu = $lichHenInput["maDichVu"];
        $this -> soThuTu = $lichHenInput["soThuTu"];
        $this -> maBenhNhan =  $lichHenInput["maBenhNhan"];
        $this -> maKhoa =  $lichHenInput["maKhoa"];
        
        $nH = new DateTime($this->ngayHen);
        $ngayHienTai = new DateTime(); // Ngày hiện tại
        
        if ($nH <= $ngayHienTai) {
            return $this -> message( 422 ,"Ngày hẹn phải lớn hơn ngày hiện tại"  , "422 Dữ liệu không hợp lệ");
        }
        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> maBacSi) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường mã bác sĩ"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> ngayHen) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường ngày hẹn " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> maDichVu)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường mã dịch vụ" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> soThuTu) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường số thứ tự", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> maBenhNhan) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường mã bệnh nhân", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> maKhoa) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường mã khoa", "422 Dữ liệu không hợp lệ");
        }
     
        return 1;
    }
    function insertLichHen($lichHenInput)
    {
        $check = $this -> checkData($lichHenInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `lichhen`(`maBacSi`, `ngayHen`, `maDichVu`, `soThuTu`, `maBenhNhan`, `maKhoa` ) VALUES ('$this->maBacSi', '$this->ngayHen', '$this->maDichVu', '$this->soThuTu', '$this->maBenhNhan', '$this->maKhoa')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm lịch hẹn thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updateLichHen($lichHenInput, $id)
    {
        $check = $this -> checkData($lichHenInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã lịch hẹn" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `lichhen` SET `maBacSi`= '$this->maBacSi',`ngayHen`='$this->ngayHen',`maDichVu`='$this->maDichVu' ,`soThuTu`='$this->soThuTu',`maBenhNhan`='$this->maBenhNhan' ,`maKhoa`='$this->maKhoa' WHERE `maLichHen` = '$id' ";
        $result = mysqli_query($this->c->con, $sql);
        
        $sqlSelect = "SELECT * FROM `lichhen` WHERE maLichHen = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;

        $num = mysqli_affected_rows($this->c->con) ;
        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy lịch hẹn nào' , "404 not found");
            }
        }
        else{
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        
        if ($result) {
            return $this -> message(200 , 'Update successfully' , "200 Updated");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function deleteLichHen($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã lịch hẹn"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM lichhen WHERE `maLichHen` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);

        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy lịch hẹn nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
