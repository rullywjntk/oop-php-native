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
                        // nama_brg sesuai dengan field di database
                        <td><?php echo $data->nama_brg; ?></td>
                        <td><?php echo $data->harga_brg; ?></td>
                        <td><?php echo $data->stok_brg; ?></td>
                        <td><?php echo $data->gambar_brg; ?></td>
                        <td align="center">
                            <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>
                        </td>
                    </tr>

                <?php } ?>

            </table>
        </div>

    </div>
</div>