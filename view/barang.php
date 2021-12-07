<?php
include "models/m_barang.php";

// deklarasi object
// $connect berasal dari index.php
$brg = new Barang($connect);

?>

<div class="row">
    <div class="col-lg-12">
        <h1>Barang <small>Data Barang</small></h1>
        <ol class="breadcrumb">
            <li><a href="index.html"><i class="icon-dashboard"></i> Barang</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Stok Barang</th>
                    <th>Gambar Barang</th>
                    <th>Opsi</th>
                </tr>

                <?php
                $no = 1;

                // memanggil method tampil dari object $brg
                $tampil = $brg->tampil();

                // looping data
                while ($data = $tampil->fetch_object()) {


                ?>

                    <tr>
                        <td align="center"><?php echo $no++ . "."; ?></td>

                        <!--  nama_brg sesuai dengan field di database -->
                        <td><?php echo $data->nama_brg; ?></td>
                        <td><?php echo $data->harga_brg; ?></td>
                        <td><?php echo $data->stok_brg; ?></td>
                        <td align="center">
                            <img src="assets/img/barang/<?php echo $data->gambar_brg; ?>" alt="" width="70px">
                        </td>
                        <td align="center">
                            <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>
                        </td>
                    </tr>

                <?php } ?>

            </table>
        </div>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> Tambah Data</button>

        <!-- modal tambah -->
        <div id="tambah" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Tambah Data Barang</h4>
                    </div>
                    <form action="" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_brg" class="control-label">Nama Barang*</label>
                                <input type="text" name="nama_brg" class="form-control" id="nama_brg" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_brg" class="control-label">Harga Barang*</label>
                                <input type="number" name="harga_brg" class="form-control" id="harga_brg" required>
                            </div>
                            <div class="form-group">
                                <label for="stok_brg" class="control-label">Stok Barang*</label>
                                <input type="number" name="stok_brg" class="form-control" id="stok_brg" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar_brg" class="control-label">Gambar Barang*</label>
                                <input type="file" name="gambar_brg" class="form-control" id="gambar_brg" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <input type="submit" class="btn btn-success" name="tambah" value="Simpan" id="">

                        </div>
                    </form>

                    <?php
                    if (@$_POST['tambah']) {
                        $nama_brg = $connect->conn->real_escape_string($_POST['nama_brg']);
                        $harga_brg = $connect->conn->real_escape_string($_POST['harga_brg']);
                        $stok_brg = $connect->conn->real_escape_string($_POST['stok_brg']);

                        // fungsi rename gambar yang diupload
                        $ekstensi = explode(".", $_FILES['gambar_brg']['name']);
                        $gambar_brg = "brg-" . round(microtime(true)) . "." . end($ekstensi);
                        $sumber = $_FILES['gambar_brg']['tmp_name'];
                        $upload = move_uploaded_file($sumber, "assets/img/barang/" . $gambar_brg);

                        if ($upload) {
                            $brg->tambah($nama_brg, $harga_brg, $stok_brg, $gambar_brg);

                            // redirect
                            header("location: ?page=barang");
                        } else {
                            echo "<script>alert('Upload gambar gagal!')</script>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>