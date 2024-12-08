<?php
    class admin extends connectDB{
        protected $connect;
        function __construct()
        {
            $this -> connect = new connectDB();
        }

        function get_data(){
            $sql = "SELECT * FROM admin";
            $result = mysqli_query($this -> connect -> con , $sql);
            if($result){
                if(mysqli_num_rows($result) > 0 ){
                    $res = mysqli_fetch_all($result , MYSQLI_ASSOC);
                    $data = [
                        "status" => 200,
                        "message" => "Thành công",
                        "data" => $res
                    ];
                    header("http 1.0 200 thành công");
                    return json_encode($data);
                }
                else{
                    $data = [
                        "status" => 404,
                        "message" => "Not found",
                        "data" => null
                    ];
                    header("http 1.0 404 not found");
                    return json_encode($data);
                }
            }
            else{
                $data = [
                    "status" => 500,
                    "message" => "Internal Server Error"
                ];
                header("http 1.0 500 Internal Server Error");
                return json_encode($data);
            }
        }
    }

?>