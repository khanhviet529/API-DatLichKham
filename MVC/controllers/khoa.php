<?php

class khoa extends controller
{
    protected $khoaModel;
    public function __construct() {
        $this -> khoaModel = $this->model("khoaModel");
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
                $khoa = $this -> khoaModel -> getKhoa($_GET['maKhoa']);
                echo $khoa;
            } else {
                $khoaList = $this -> khoaModel -> getKhoaList();
                echo $khoaList;
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

    function insertKhoa()
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
                $insertKhoa = $this -> khoaModel -> insertKhoa($_POST);
            }
             else {
                $insertKhoa = $this -> khoaModel -> insertKhoa($inputdata);
            }
            echo $insertKhoa;
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

    function updateKhoa(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'PUT'){
           
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if(empty($inputdata)) {
                $updateKhoa = $this -> khoaModel -> updateKhoa($_POST , $_GET['maKhoa'] );
            } else {
                $updateKhoa = $this -> khoaModel -> updateKhoa($inputdata , $_GET['maKhoa'] );
            }
            echo $updateKhoa;
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

    function deleteKhoa(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];
    
        if($requestmethod == 'DELETE'){
            $deleteKhoa = $this -> khoaModel -> deleteKhoa($_GET['maKhoa'] );
            echo $deleteKhoa;
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
