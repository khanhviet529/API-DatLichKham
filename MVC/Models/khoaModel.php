<?php

class khoaModel extends connectDB
{
    protected $c;
    private  $maKhoa;
    private $tenKhoa	;
    private $viTri	;
    private $soDienThoai;
   
  
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
    function getKhoaList()
    {
        $sql = "SELECT * FROM khoa";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách khoa',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có khoa nào!' , "404 Không có khoa nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getKhoa($id)
    {
        $sql = "SELECT * FROM khoa WHERE  maKhoa = $id";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Khoa có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có khoa nào!' , "404 Không có khoa nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }


    function  checkData ( $khoaInput ){
       
        $this -> tenKhoa = $khoaInput["tenKhoa"] ;
        $this -> viTri = $khoaInput["viTri"];
        $this -> soDienThoai = $khoaInput["soDienThoai"];
        
        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> tenKhoa) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường tên khoa"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> viTri) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường vị trí " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> soDienThoai)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường số điện thoại" , "422 Dữ liệu không hợp lệ");
        }
        
     
        return 1;
    }
    function insertKhoa($khoaInput)
    {
        $check = $this -> checkData($khoaInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `khoa`(`tenKhoa`, `viTri`, `soDienThoai`) VALUES (n'$this->tenKhoa', '$this->viTri', n'$this->soDienThoai')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm khoa thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updateKhoa($khoaInput, $id)
    {
        $check = $this -> checkData($khoaInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã khoa" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `khoa` SET `tenKhoa`= n'$this->tenKhoa',`viTri`=n'$this->viTri',`soDienThoai`='$this->soDienThoai'  WHERE `maKhoa` = '$id' ";
        $result = mysqli_query($this->c->con, $sql);
        
        $sqlSelect = "SELECT * FROM `khoa` WHERE maKhoa = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;

        $num = mysqli_affected_rows($this->c->con) ;
        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy khoa nào' , "404 not found");
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
    function deleteKhoa($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã khoa"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM khoa WHERE `maKhoa` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);

        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy khoa nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
