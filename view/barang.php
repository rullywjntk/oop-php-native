<?php
include "models/m_barang.php";

// deklarasi object
// $connect berasal dari index.php
$brg = new Barang($connect);

// get parameter ke 2
if (@$_GET['act'] == '') {


?>

    <div class="row">
        <div class="col-lg-12">
            <h1>Barang <small>Data Barang</small></h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="icon-dashboard"></i> Barang</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="datatables">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Stok Barang</th>
                            <th>Gambar Barang</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>

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
                                    <a href="" id="edit_brg" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_brg; ?>" data-nama="<?php echo $data->nama_brg; ?>" data-harga="<?php echo $data->harga_brg; ?>" data-stok="<?php echo $data->stok_brg; ?>" data-gambar="<?php echo $data->gambar_brg; ?>">
                                        <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                                    </a>

                                    <a href="?page=barang&act=del&id=<?php echo $data->id_brg; ?>" onclick="return confirm('Anda yakin ingin menghapus item ini?')">
                                        <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> Tambah Data</button>
            <a href="./report/export_excel_barang.php" target="blank">
                <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Export Excel</button>
            </a>

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
            <!-- end modal tambah -->

            <!-- modal edit -->
            <div id="edit" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Data Barang</h4>
                        </div>

                        <!-- menggunakan jquery ajax -->
                        <form id="form" enctype="multipart/form-data">
                            <div class="modal-body" id="modal-edit">
                                <div class="form-group">
                                    <label for="nama_brg" class="control-label">Nama Barang*</label>
                                    <input type="hidden" name="id_brg" id="id_brg">
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
                                    <div style="padding-bottom: 5px;">
                                        <img src="" width="80px" id="pict" alt="">
                                    </div>
                                    <input type="file" name="gambar_brg" class="form-control" id="gambar_brg">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" name="edit" value="Simpan" id="">

                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
            <script type="text/javascript">
                $(document).on("click", "#edit_brg", function() {
                    var idBrg = $(this).data('id');
                    var namaBrg = $(this).data('nama');
                    var hargaBrg = $(this).data('harga');
                    var stokBrg = $(this).data('stok');
                    var gambarBrg = $(this).data('gambar');

                    $("#modal-edit #id_brg").val(idBrg);

                    $("#modal-edit #nama_brg").val(namaBrg);
                    $("#modal-edit #harga_brg").val(hargaBrg);
                    $("#modal-edit #stok_brg").val(stokBrg);
                    $("#modal-edit #pict").attr("src", "assets/img/barang/" + gambarBrg);
                })

                // proses edit data
                $(document).ready(function(e) {
                    $("#form").on("submit", (function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: 'models/m_edit_barang.php',
                            type: 'POST',
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(msg) {
                                $('.table').html(msg);
                            }
                        })
                    }))
                })
            </script>

        </div>
    </div>

<?php
} elseif (@$_GET['act'] == 'del') {

    // get id diambil dari parameter ke 2 => id di link hapus
    $gambar_awal = $brg->tampil($_GET['id'])->fetch_object()->gambar_brg;
    unlink("assets/img/barang/" . $gambar_awal);

    $brg->delete($_GET['id']);
    header("location: ?page=barang");
}

?>