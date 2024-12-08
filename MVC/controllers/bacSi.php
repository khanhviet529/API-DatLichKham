<?php

class bacSi extends controller
{
    protected $bacSiModel;
    public function __construct()
    {
        $this->bacSiModel = $this->model("bacSiModel");
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
                $customer = $this->bacSiModel->getDoctor($_GET['maBacSi']);
                echo $customer;
            } else {
                $customerList = $this->bacSiModel->getDoctorList();
                echo $customerList;
            }
        } else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }

    function insertBacSi()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");


        $requestmethod = $_SERVER['REQUEST_METHOD'];

        if ($requestmethod == 'POST') {
            $inputdata = json_decode(file_get_contents("php://input"), true);
            if (empty($inputdata)) {
                $insertCustomer = $this->bacSiModel->insertDoctor($_POST);
            } else {
                $insertCustomer = $this->bacSiModel->insertDoctor($inputdata);
            }
            echo $insertCustomer;
        } else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }

    function updateBacSi()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: PUT");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];

        if ($requestmethod == 'PUT') {

            $inputdata = json_decode(file_get_contents("php://input"), true);
            if (empty($inputdata)) {
                $updateCustomer = $this->bacSiModel->updateDoctor($_POST, $_GET['maBacSi']);
            } else {
                $updateCustomer = $this->bacSiModel->updateDoctor($inputdata, $_GET['maBacSi']);
            }
            echo $updateCustomer;
        } else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }

    function deleteBacSi()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

        $requestmethod = $_SERVER['REQUEST_METHOD'];

        if ($requestmethod == 'DELETE') {
            $deleteCustomer = $this->bacSiModel->deleteDoctor($_GET['maBacSi']);
            echo $deleteCustomer;
        } else {
            $data = [
                'status' => 405,
                'message' => $requestmethod . 'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }
}
