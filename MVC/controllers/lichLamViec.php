<?php

class lichLamViec extends controller
{
    protected $lichLamViecModel;
    public function __construct() {
        $this -> lichLamViecModel = $this->model("lichLamViecModel");
    }
    function get_data()
    {
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: GET");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
        $maLich = "";
        $tenBacSi = "";
        $check = 0;
        if ($requestmethod == 'GET') {
            if (isset($_GET['maLichLamViec'])) {
                $maLich = $_GET['maLichLamViec'];
                $check = 1;
            } 
            if (isset($_GET['tenBacSi'])) {
                $tenBacSi = $_GET['tenBacSi'];
                $check = 1;
            } 
            if($check == 1){
                $lichLamViec = $this -> lichLamViecModel -> getLichLamViec($maLich , $tenBacSi);
                echo $lichLamViec;
            }
            
            else {
                $lichLamViecList = $this -> lichLamViecModel -> getlichLamViecList();
                echo $lichLamViecList;
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

    function insertLichLamViec()
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
                $insertLichLamViec = $this -> lichLamViecModel -> insertLichLamViec($_POST);
            }
             else {
                $insertLichLamViec = $this -> lichLamViecModel -> insertLichLamViec($inputdata);
            }
            echo $insertLichLamViec;
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

    function updateLichLamViec(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'PUT'){
           
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                $updateLichLamViec = $this -> lichLamViecModel -> updateLichLamViec($_POST , $_GET['maLichLamViec'] );
            } else {
                $updateLichLamViec = $this -> lichLamViecModel -> updateLichLamViec($inputdata , $_GET['maLichLamViec'] );
            }
            echo $updateLichLamViec;
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

    function deleteLichLamViec(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'DELETE'){
            $deleteLichLamViec = $this -> lichLamViecModel -> deleteLichLamViec($_GET['maLichLamViec'] );
            echo $deleteLichLamViec;
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
