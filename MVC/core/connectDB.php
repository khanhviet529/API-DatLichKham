<?php 
    class connectDB{
        public $con;
        protected $servername="localhost:3367";
        protected $username="root";
        protected $password="";
        protected $dbname="datlichkham";
        function __construct(){
            $this->con=mysqli_connect($this->servername,$this->username,$this->password,$this->dbname);
            mysqli_query($this->con,"SET NAMES 'utf8'");
        }
    }

?>