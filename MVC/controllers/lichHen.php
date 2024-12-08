<?php

class lichHen extends controller
{
    protected $lichHenModel;
    public function __construct() {
        $this -> lichHenModel = $this->model("lichHenModel");
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
            if (isset($_GET['maLichHen'])) {
                $lichHen = $this -> lichHenModel -> getLichHen($_GET['maLichHen']);
                echo $lichHen;
            } else {
                $lichHenList = $this -> lichHenModel -> getLichHenList();
                echo $lichHenList;
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

    function insertLichHen()
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
                $insertLichHen = $this -> lichHenModel -> insertLichHen($_POST);
            }
             else {
                $insertLichHen = $this -> lichHenModel -> insertLichHen($inputdata);
            }
            echo $insertLichHen;
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

    function updateLichHen(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'PUT'){
           
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                $updateLichHen = $this -> lichHenModel -> updateLichHen($_POST , $_GET['maLichHen'] );
            } else {
                $updateLichHen = $this -> lichHenModel -> updateLichHen($inputdata , $_GET['maLichHen'] );
            }
            echo $updateLichHen;
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

    function deleteLichHen(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'DELETE'){
            $deleteLichHen = $this -> lichHenModel -> deleteLichHen($_GET['maLichHen'] );
            echo $deleteLichHen;
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
