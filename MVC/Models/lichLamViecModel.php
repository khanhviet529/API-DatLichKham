<?php

class lichLamViecModel extends connectDB
{
    protected $c;
    private  $maBacSi;
    private $ngayLamViec;
    private $thoiGianBatDau;
    private $thoiGianKetThuc;
    private $maKhoa;
   
  
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
    function getlichLamViecList()
    {
        $sql = "SELECT llv.* , bs.maBacSi , bs.hoTen , k.maKhoa , k.tenKhoa 
        FROM lichlamvien llv
        INNER JOIN bacsi bs
        ON llv.maBacSi = bs.maBacSi
        INNER JOIN khoa k
        ON llv.maKhoa = k.maKhoa";

        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách lịch làm việc',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có lịch làm việc nào!' , "404 Không có lịch làm việc nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getlichLamViec($id , $tenBacSi)
    {
        // $sql = "SELECT * FROM lichlamvien WHERE  maLichLamViec = $id";
        $sql = "SELECT * FROM `lichlamvien` llv
        INNER JOIN bacsi bs
        ON bs.maBacSi = llv.maBacSi
        INNER JOIN khoa k
        ON k.maKhoa = llv.maKhoa
        WHERE llv.maLichLamViec LIKE '%$id%' OR  bs.hoTen LIKE '%$tenBacSi%' ";

        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Lịch làm việc có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có lịch làm việc nào!' , "404 Không có lịch làm việc nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
       
    }


    function  checkData ( $lichLamViecInput ){
       
        $this -> maBacSi = $lichLamViecInput["maBacSi"] ;
        $this -> ngayLamViec = $lichLamViecInput["ngayLamViec"];
        $this -> thoiGianBatDau = $lichLamViecInput["thoiGianBatDau"];
        $this -> thoiGianKetThuc = $lichLamViecInput["thoiGianKetThuc"];
        $this -> maKhoa =  $lichLamViecInput["maKhoa"];

        $nlv = new DateTime($this->ngayLamViec);
        $ngayHienTai = new DateTime(); // Ngày hiện tại
        
        if ($nlv <= $ngayHienTai) {
            return $this->message(422, "Ngày làm việc phải lớn hơn ngày hiện tại", "422 Dữ liệu không hợp lệ");
        }
        
        // Kiểm tra thời gian bắt đầu và kết thúc
        $thoiGianBatDau = new DateTime($this->thoiGianBatDau);
        $thoiGianKetThuc = new DateTime($this->thoiGianKetThuc);
        
        if ($thoiGianBatDau >= $thoiGianKetThuc) {
            return $this->message(422, "Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc", "422 Dữ liệu không hợp lệ");
        } 

        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> maBacSi) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường mã bác sĩ"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> ngayLamViec) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường ngày làm việc " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> thoiGianBatDau)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường thời gian bắt đầu" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> thoiGianKetThuc) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường thời gian kết thúc", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> maKhoa) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường mã khoa", "422 Dữ liệu không hợp lệ");
        }
       
     
        return 1;
    }
    function insertLichLamViec($lichLamViecInput)
    {
        $check = $this -> checkData($lichLamViecInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `lichlamvien`(`maBacSi`, `ngayLamViec`, `thoiGianBatDau`, `thoiGianKetThuc`, `maKhoa`) VALUES ('$this->maBacSi', '$this->ngayLamViec', '$this->thoiGianBatDau', '$this->thoiGianKetThuc', '$this->maKhoa')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm lịch làm việc thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updateLichLamViec($lichLamViecInput, $id)
    {
        $check = $this -> checkData($lichLamViecInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã lịch làm việc" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `lichlamvien` SET `maBacSi`= '$this->maBacSi',`ngayLamViec`='$this->ngayLamViec',`thoiGianBatDau`='$this->thoiGianBatDau' ,`thoiGianKetThuc`='$this->thoiGianKetThuc',`maKhoa`='$this->maKhoa' WHERE `maLichLamViec` = '$id' ";
        $result = mysqli_query($this->c->con, $sql);
        
        $sqlSelect = "SELECT * FROM `lichlamvien` WHERE maLichLamViec = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;

        $num = mysqli_affected_rows($this->c->con) ;
        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy lịch làm việc nào' , "404 not found");
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
    function deleteLichLamViec($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã lịch làm việc"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM lichlamvien WHERE `maLichLamViec` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);

        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy lịch làm việc nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
