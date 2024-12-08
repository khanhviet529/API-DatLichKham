<?php

class dichVu extends controller
{
    protected $dichVuModel;
    public function __construct() {
        $this -> dichVuModel = $this->model("dichVuModel");
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
                $dichVu = $this -> dichVuModel -> getDichVu($_GET['id']);
                echo $dichVu;
            } else {
                $dichVuList = $this -> dichVuModel -> getDichVuList();
                echo $dichVuList;
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

    function insertDichVu()
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
                $insertDichVu = $this -> dichVuModel -> insertDichVu($_POST);
            }
             else {
                $insertDichVu = $this -> dichVuModel -> insertDichVu($inputdata);
            }
            echo $insertDichVu;
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

    function updateDichVu(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'PUT'){
           
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                $updateDichVu = $this -> dichVuModel -> updateDichVu($_POST , $_GET['maDichVu'] );
            } else {
                $updateDichVu = $this -> dichVuModel -> updateDichVu($inputdata , $_GET['maDichVu'] );
            }
            echo $updateDichVu;
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

    function deleteDichVu(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'DELETE'){
            $deleteDichVu = $this -> dichVuModel -> deleteDichVu($_GET['maDichVu'] );
            echo $deleteDichVu;
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
