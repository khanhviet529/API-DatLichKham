<?php

class dichVuModel extends connectDB
{
    protected $c;
    private  $tenDichVu;
    private $moTa;
    private $gia;
    private $maKhoa;
    
  
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
    function getDichVuList()
    {
        $sql = "SELECT * FROM dichvu";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách dịch vụ',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có dịch vụ nào!' , "404 Không có dịch vụ nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getDichVu($id)
    {
        $sql = "SELECT * FROM dichvu WHERE  maDichVu = $id";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Dịch vụ có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có dịch vụ nào!' , "404 Không có dịch vụ nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }


    function  checkData ( $dichVuInput ){
       
        $this -> tenDichVu = $dichVuInput["tenDichVu"] ;
        $this -> moTa = $dichVuInput["moTa"];
        $this -> gia = $dichVuInput["gia"];
        $this -> maKhoa = $dichVuInput["maKhoa"];


        
        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> tenDichVu) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường tên dịch vụ"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> moTa) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường mô tả " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> gia)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường giá" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> maKhoa)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường mã khoa" , "422 Dữ liệu không hợp lệ");
        }
   
     
        return 1;
    }
    function insertDichVu($dichVuInput)
    {
        $check = $this -> checkData($dichVuInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `dichvu`(`tenDichVu`, `moTa`, `gia`, `maKhoa`) VALUES (n'$this->tenDichVu', n'$this->moTa', '$this->gia', '$this->maKhoa')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm dịch vụ thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updateDichVu($dichVuInput, $id)
    {
        $sqlSelect = "SELECT * FROM `dichvu` WHERE maDichVu = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;

        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy dịch vụ nào' , "404 not found");
            }
        }
        else{
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        
        $check = $this -> checkData($dichVuInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã dịch vụ" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `dichvu` SET `tenDichVu`= n'$this->tenDichVu',`moTa`=n'$this->moTa',`gia`='$this->gia', `maKhoa`='$this->maKhoa'  WHERE `maDichVu` = '$id' ";
        $result = mysqli_query($this->c->con, $sql);
        
       
        
        if ($result) {
            return $this -> message(200 , 'Update successfully' , "200 Updated");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function deleteDichVu($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã dịch vụ"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM dichvu WHERE `maDichVu` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);

        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy dịch vụ nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
