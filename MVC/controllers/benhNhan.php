<?php

class benhNhan extends controller
{
    protected $benhNhanModel;
    public function __construct() {
        $this -> benhNhanModel = $this->model("benhNhanModel");
    }
    
    function get_data()
    {
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: GET");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
        
        if ($requestmethod == 'GET') {
            if (isset($_GET['soDienThoai'])) {
                $customer = $this -> benhNhanModel -> getCustomer($_GET['soDienThoai']);
                echo $customer;
            } else {
                $customerList = $this -> benhNhanModel -> getCustomerList();
                echo $customerList;
            }
        }  
        
        else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }

    function insertBenhNhan()
    {      
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");
        

        $requestmethod = $_SERVER['REQUEST_METHOD'];
        
        if($requestmethod == 'POST'){
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                $insertCustomer = $this -> benhNhanModel -> insertCustomer($_POST);
            }
             else {
                $insertCustomer = $this -> benhNhanModel -> insertCustomer($inputdata);
            }
            echo $insertCustomer;
        }
        
        else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
   
    }

    function updateBenhNhan(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'PUT'){
           
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                var_dump($_POST);
                $updateCustomer = $this -> benhNhanModel -> updateCustomer($_POST , $_GET['maBenhNhan'] );
            } else {
                $updateCustomer = $this -> benhNhanModel -> updateCustomer($inputdata , $_GET['maBenhNhan'] );
            }
            echo $updateCustomer;
        }
        
        else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }

    function deleteBenhNhan(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'DELETE'){
            $deleteCustomer = $this -> benhNhanModel -> deleteCustomer($_GET['maBenhNhan'] );
            echo $deleteCustomer;
        }
        
        else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }
}
