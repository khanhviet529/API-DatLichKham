<?php

class bacSiModel extends connectDB
{
    protected $c;
    private  $hoTen;
    private  $chuyenKhoa;
    private $ngaySinh;
    private $gioiTinh;
    private $email;
    private $cccd;
    private $soDienThoai;
    private $diaChi;
    private $hocVan;
    private $ngayVaoLam;
  
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
    function getDoctorList()
    {
        $sql = "SELECT * FROM bacsi";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Danh sách bác sĩ',
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
               
            } else {
                return $this -> message(404 , 'Không có bác sĩ nào!' , "404 Không có bác sĩ nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }
    function getDoctor($id)
    {
        $sql = "SELECT * FROM bacsi WHERE  maBacSi = $id";
        $query_run =  mysqli_query($this->c->con, $sql);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                $data = [
                    'status' => 200,
                    'message' => 'Bác sĩ có mã ' . $id,
                    'data' => $res,
                ];
                header("HTTP/1.0 200 Thành công ");
                return json_encode($data);
            } else {
                return $this -> message(404 , 'Không có bác sĩ nào!' , "404 Không có bác sĩ nào!");
            }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        return json_encode($res);
    }


    function  checkData ( $DoctorrInput ){
       
        $this -> hoTen = $DoctorrInput["hoTen"] ;
        $this -> chuyenKhoa = $DoctorrInput["chuyenKhoa"] ;
        $this -> ngaySinh = $DoctorrInput["ngaySinh"];
        $this -> gioiTinh = $DoctorrInput["gioiTinh"];
        $this -> email = $DoctorrInput["email"];
        $this -> cccd = $DoctorrInput["cccd"];
        $this -> soDienThoai =  $DoctorrInput["soDienThoai"];
        $this -> diaChi = $DoctorrInput["diaChi"];
        $this -> hocVan = $DoctorrInput["hocVan"];
        $this -> ngayVaoLam = $DoctorrInput["ngayVaoLam"];
        // if( strcmp(trim($this -> hoTen) , "") == 0 ){
        //     return false;
        // }
        if( empty($this -> hoTen) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường họ tên"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> chuyenKhoa) ){
            return $this -> message( 422 ,"Bạn không được bỏ trống trường chuyên khoa"  , "422 Dữ liệu không hợp lệ");
        }
        if( empty($this -> ngaySinh) ){
            return  $this -> message( 422,"Bạn không được bỏ trống trường ngày sinh " , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> gioiTinh)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường giới tính" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> email)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường email" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> cccd)  ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường căn cước công dân" , "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> soDienThoai) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường số điện thoại", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> diaChi) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường địa chỉ", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> hocVan) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường học vấn", "422 Dữ liệu không hợp lệ");
        }
        if(  empty($this -> ngayVaoLam) ){
            return  $this -> message( 422 ,"Bạn không được bỏ trống trường ngày vào làm", "422 Dữ liệu không hợp lệ");
        }
        
        return 1;
    }
    function insertDoctor($DoctorrInput)
    {
        echo "fdf" . $DoctorrInput["hoTen"];
        $check = $this -> checkData($DoctorrInput);
        if($check != 1){
            return $check;
        }
       
        $sql = "INSERT INTO `bacsi`( `hoTen`, `chuyenKhoa`, `ngaySinh`, `gioiTinh`, `email`, `cccd`, `soDienThoai`, `diaChi`, `hocVan`, `ngayVaoLam`) VALUES (n'$this->hoTen', n'$this->chuyenKhoa', '$this->ngaySinh', n'$this->gioiTinh', '$this->email', '$this->cccd', '$this->soDienThoai', n'$this->diaChi', n'$this->hocVan', n'$this->ngayVaoLam')";

        $result = mysqli_query($this->c->con, $sql);

        if ($result) {
            return $this -> message(201 , 'Thêm bác sĩ thành công' , "201 đã khởi tạo");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function updateDoctor($DoctorrInput, $id)
    {
        $sqlSelect = "SELECT * FROM `bacsi` WHERE maBacSi = $id";
        $resultSelect = mysqli_query($this->c->con, $sqlSelect);;
      
        if($resultSelect){
            if(mysqli_num_rows($resultSelect) == 0 ){
                return $this -> message(404 , 'Không tìm thấy bác sĩ nào' , "404 not found");
            }
        }
        else{
            return $this -> message(500 , 'Intern111al Server Error' , "500 Internal Server Error");
        }

        $check = $this -> checkData($DoctorrInput);
        if($check != 1){
            return $check;
        }
        if(empty($id) ){
            return $this -> message(422 ,"Bạn chưa nhập mã bác sĩ" , "422 Dữ liệu không hợp lệ");
        }
        $sql = "UPDATE `bacsi` SET `hoTen`=n'$this->hoTen',`chuyenKhoa`= n'$this->chuyenKhoa',`ngaySinh`='$this->ngaySinh',`gioiTinh`= n'$this->gioiTinh',`email`='$this->email',`cccd`='$this->cccd',`soDienThoai`='$this->soDienThoai'
        ,`diaChi`=n'$this->diaChi',`hocVan`=n'$this->hocVan',`ngayVaoLam`='$this->ngayVaoLam' WHERE maBacSi = $id";
        $result = mysqli_query($this->c->con, $sql);
        
       
        
        if ($result) {
            return $this -> message(200 , 'Update successfully' , "200 Updated");
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
    function deleteDoctor($id)
    {

        if(empty($id) ){
            return $this -> message(422 , "Bạn chưa nhập mã bác sĩ"  , "422 Dữ liệu không hợp lệ");
        }
        $sql = "DELETE FROM bacsi WHERE `maBacSi` = $id LIMIT 1";
        $result = mysqli_query($this->c->con, $sql);
        
        $num = mysqli_affected_rows($this->c->con) ;
        
        if ($result) {
                if($num > 0 ){
                    return $this -> message(200 , 'delete successfully' , "200 deleted");
                }
                else{
                    return $this -> message(404 , 'Không tìm thấy bác sĩ nào' , "404 not found");
                }
        } else {
            return $this -> message(500 , 'Internal Server Error' , "500 Internal Server Error");
        }
    }
}
