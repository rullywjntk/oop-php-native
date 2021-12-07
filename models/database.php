<?php

class Database
{
    // membuat deklarasi variable
    private $host;
    private $user;
    private $pass;
    private $database;
    public $conn;

    // function construct yang diload pertama kali
    public function __construct($host, $user, $pass, $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;

        // membuat koneksi ke database oop
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->database) or die(mysqli_error($database));

        if (!$this->conn) {
            return false;
        } else {
            return true;
        }
    }
}
