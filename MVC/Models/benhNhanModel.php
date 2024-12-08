<?php

class benhNhanModel extends connectDB
{
    protected $c;
    private  $hoTen;
    private $ngaySinh;
    private $gioiTinh;
    private $diaChi;
    private $soDienThoai;
    private $email;
    private $ngheNghiep;
    private $danToc;
  
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
    function getCustomerList()
    {
        $sql = "SELECT * FROM benhnhan";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách bệnh nhân',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có bệnh nhân nào!' , "404 Không có bệnh nhân nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getCustomer($id)
    {
        $sql = "SELECT * FROM benhnhan WHERE  soDienThoai = $id";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Bệnh nhân có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có bệnh nhân nào!' , "404 Không có bệnh nhân nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }


    function  checkData ( $customerInput ){
        $this -> hoTen = $customerInput["hoTen"] ;
        $this -> ngaySinh = $customerInput["ngaySinh"];
        $this -> gioiTinh = $customerInput["gioiTinh"];
        $this -> diaChi = $customerInput["diaChi"];
        $this -> soDienThoai =  $customerInput["soDienThoai"];
        $this -> email = $customerInput["email"];
        $this -> ngheNghiep = $customerInput["ngheNghiep"];
        $this -> danToc = $customerInput["danToc"];
        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> hoTen) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> ngaySinh) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường ngày sinh " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> gioiTinh)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> diaChi) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> soDienThoai) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên", "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> email)  ){
            return  $this ->message( 422 ,"Bạn không được bỏ trống trường họ tên", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> ngheNghiep) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> danToc) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên", "422 Dữ liệu không hợp lệ");
        }
     
        return 1;
    }
    function insertCustomer($customerInput)
    {
        $check = $this -> checkData($customerInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `benhnhan`(`hoTen`, `ngaySinh`, `gioiTinh`, `diaChi`, `soDienThoai`, `email`, `ngheNghiep`, `danToc`) VALUES (n'$this->hoTen', '$this->ngaySinh', n'$this->gioiTinh', n'$this->diaChi', '$this->soDienThoai', '$this->email', n'$this->ngheNghiep', n'$this->danToc')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm bệnh nhân thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updateCustomer($customerInput, $id)
    {
        $check = $this -> checkData($customerInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã bệnh nhân" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `benhnhan` SET `hoTen`= n'$this->hoTen',`ngaySinh`='$this->ngaySinh',`diaChi`=n'$this->diaChi' ,`soDienThoai`='$this->soDienThoai',`email`='$this->email',`ngheNghiep`= n'$this->ngheNghiep',`danToc`= n'$this->danToc' WHERE `maBenhNhan` = '$id' ";
        $result = mysqli_query($this->c->con, $sql);
        
        $sqlSelect = "SELECT * FROM `benhnhan` WHERE maBenhNhan = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;

        $num = mysqli_affected_rows($this->c->con) ;
        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy bệnh nhân nào' , "404 not found");
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
    function deleteCustomer($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã bệnh nhân"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM benhnhan WHERE `maBenhNhan` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);

        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy bệnh nhân nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
