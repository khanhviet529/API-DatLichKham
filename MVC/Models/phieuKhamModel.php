<?php

class phieuKhamModel extends connectDB
{
    protected $c;
    private  $maLichHen;
    private $maBenhNhan;
    private $maBacSi;
    private $chuanDoan;
    private $ngayThamKham;
    private $ghiChu;
    
  
    function __construct()
    {
        $this->c = new connectDB();
    }
    function message(  $status ,$mess , $textH){
        $data = [
            'status' => $status,
            'message' => $mess,
        ];
        header("HTTP/1.0 " . $textH);
        return json_encode($data);
    }
    function getphieuKhamList()
    {
        $sql = "SELECT * FROM phieukham";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách phiếu khám',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có phiếu khám nào!' , "404 Không có phiếu khám nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getphieuKham($id)
    {
        $sql = "SELECT * FROM phieukham WHERE  maPhieuKham = $id";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Phiếu khám có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có phiếu khám nào!' , "404 Không có phiếu khám nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }


    function  checkData ( $phieuKhamInput ){
       
        $this -> maLichHen = $phieuKhamInput["maLichHen"] ;
        $this -> maBenhNhan = $phieuKhamInput["maBenhNhan"];
        $this -> maBacSi = $phieuKhamInput["maBacSi"];
        $this -> chuanDoan = $phieuKhamInput["chuanDoan"];
        $this -> ngayThamKham =  $phieuKhamInput["ngayThamKham"];
        $this -> ghiChu = $phieuKhamInput["ghiChu"];
       
        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> maLichHen) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường lịch hẹn"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> maBenhNhan) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường bệnh nhân " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> maBacSi)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường bác sĩ" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> chuanDoan) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường chuẩn đoán", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> ngayThamKham) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường ngày thăm khám", "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> ghiChu)  ){
            return  $this ->message( 422 ,"Bạn không được bỏ trống trường ghi chú", "422 Dữ liệu không hợp lệ");
        }
       
     
        return 1;
    }
    function insertphieuKham($phieuKhamInput)
    {
        $check = $this -> checkData($phieuKhamInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `phieukham`(`maLichHen`, `maBenhNhan`, `maBacSi`, `chuanDoan`, `ngayThamKham`, `ghiChu`) VALUES (n'$this->maLichHen', '$this->maBenhNhan', n'$this->maBacSi', n'$this->chuanDoan', '$this->ngayThamKham', '$this->ghiChu')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm phiếu khám thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updatephieuKham($phieuKhamInput, $id)
    {
        $check = $this -> checkData($phieuKhamInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã phiếu khám" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `phieukham` SET `maLichHen`= n'$this->maLichHen',`maBenhNhan`='$this->maBenhNhan',`maBacSi`=n'$this->maBacSi' ,`chuanDoan`='$this->chuanDoan',`ngayThamKham`='$this->ngayThamKham',`ghiChu`= n'$this->ghiChu' WHERE `maPhieuKham` = '$id' ";
        $result = mysqli_query($this->c->con, $sql);
        
        $sqlSelect = "SELECT * FROM `phieukham` WHERE maPhieuKham = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;

        $num = mysqli_affected_rows($this->c->con) ;
        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy phiếu khám nào' , "404 not found");
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
    function deletephieuKham($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã phiếu khám"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM phieukham WHERE `maPhieuKham` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);

        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy phiếu khám nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
