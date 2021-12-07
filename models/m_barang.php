<?php

class Barang
{
    private $mysqli;

    function __construct($conn)
    {
        $this->mysqli = $conn;
    }

    public function tampil($id = null)
    {
        // deklarasi koneksi
        $db = $this->mysqli->conn;

        // memilih data dari table
        $sql = "SELECT * FROM tbl_barang";

        // kondisi data diambil berdasarkan id
        if ($id != null) {
            $sql .= " WHERE id_brg = $id";
        }

        $query = $db->query($sql) or die($db->error);

        // mengembalikan data
        return $query;
    }
}
