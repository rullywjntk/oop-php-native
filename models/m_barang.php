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

    public function tambah($nama_brg, $harga_brg, $stok_brg, $gambar_brg)
    {
        $db = $this->mysqli->conn;
        $db->query("INSERT INTO tbl_barang VALUES ('','$nama_brg','$harga_brg','$stok_brg','$gambar_brg')") or die($db->error);
    }

    public function edit($sql)
    {
        $db = $this->mysqli->conn;
        $db->query($sql) or die($db->error);
    }

    public function delete($id)
    {
        $db = $this->mysqli->conn;
        $db->query("DELETE FROM tbl_barang WHERE id_brg = '$id'") or die($db->error);
    }

    // fungsi dipanggil untuk menutup koneksi

    function __destruct()
    {
        $db = $this->mysqli->conn;
        $db->close();
    }
}
