<?php
//mysqli
class connection
{
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'nti_ecommerce';
    private $conn;
    public function __construct()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password,$this->database);
    }
    //insert && update && delete return (true or false)
    public function runDML($query)
    {
        $result=$this->conn->query($query);
        if ($result) {
            return true;
        }
        else {
            return false;
        }
    }
    //select return (data or no data)
    public function runDQL($query)
    {
        $result=$this->conn->query($query);
        if ($result->num_rows>0) {
            return $result;
        }
        else{
            return [];
        }
    }
}
