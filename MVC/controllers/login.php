<?php
class login extends controller
{
    protected $admin;

    function __construct()
    {
        $this->admin = $this->model("admin");
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
            $customerList = $this->admin->get_data();
            echo $customerList;
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
