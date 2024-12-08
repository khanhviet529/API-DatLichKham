<?php

class phieuKham extends controller
{
    protected $phieuKhamModel;
    public function __construct() {
        $this -> phieuKhamModel = $this->model("phieuKhamModel");
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
            if (isset($_GET['id'])) {
                $phieuKham = $this -> phieuKhamModel -> getphieuKham($_GET['id']);
                echo $phieuKham;
            } else {
                $phieuKhamList = $this -> phieuKhamModel -> getphieuKhamList();
                echo $phieuKhamList;
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

    function insertphieuKham()
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
                $insertphieuKham = $this -> phieuKhamModel -> insertphieuKham($_POST);
            }
             else {
                $insertphieuKham = $this -> phieuKhamModel -> insertphieuKham($inputdata);
            }
            echo $insertphieuKham;
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

    function updatephieuKham(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'PUT'){
           
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                $updatephieuKham = $this -> phieuKhamModel -> updatephieuKham($_POST , $_GET['id'] );
            } else {
                $updatephieuKham = $this -> phieuKhamModel -> updatephieuKham($inputdata , $_GET['id'] );
            }
            echo $updatephieuKham;
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

    function deletephieuKham(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'DELETE'){
            $deletephieuKham = $this -> phieuKhamModel -> deletephieuKham($_GET['id'] );
            echo $deletephieuKham;
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
