<?php
include_once 'layout/header.php';
require 'functions/function_mitra.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
                <center>Data Mitra</center>
            </h6>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn c-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1">Tambah Data</button>
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Mitra</h5>
                            </div>
                            <div class="modal-body">
                                <form action="functions/function_mitra.php" method="POST">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">No Registrasi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="registration_number" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">ID Mitra</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="id_mitra" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">ID Generasi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="gen_id" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">No KTP</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="ktp" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">No Sim</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="sim" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Nama Mitra</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">No Telephone</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="phone" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Alamat Mitra</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="address" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">ID Leader</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="leader_id" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">ID Upper</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="upper_i" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">ID Upper II</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="upper_ii" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">ID Upper III</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="upper_iii" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Bonus</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bonus_i" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Bonus II</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bonus_ii" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Bonus III</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bonus_iii" class="form-control form-control-sm" id="inputEmail3" require>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="add">
                                        <button class="btn btn-primary btn-sm">Simpan</button>
                                        <a class="btn btn-outline-secondary btn-sm" href="data_mitra.php">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">No Registrasi</th>
                            <th style="text-align: center;">ID Mitra</th>
                            <th style="text-align: center;">ID Generasi</th>
                            <th style="text-align: center;">No KTP</th>
                            <th style="text-align: center;">No SIM</th>
                            <th style="text-align: center;">Nama Mitra</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">No Telephone</th>
                            <th style="text-align: center;">Alamat</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $all = getData();
                        $no = 1; ?>
                        <?php foreach ($all as $data) { ?>
                            <tr>
                                <!-- <td style="text-align: center;"><?= $no++; ?></td> -->
                                <td style="text-align: center;"><?= $data['registration_number'] ?></td>
                                <td style="text-align: center;"><?= $data['id_mitra'] ?></td>
                                <td style="text-align: center;"><?= $data['gen_id'] ?></td>
                                <td style="text-align: center;"><?= $data['ktp'] ?></td>
                                <td style="text-align: center;"><?= $data['sim'] ?></td>
                                <td style="text-align: center;"><?= $data['name'] ?></td>
                                <td style="text-align: center;"><?= $data['email'] ?></td>
                                <td style="text-align: center;"><?= $data['phone'] ?></td>
                                <td style="text-align: center;"><?= $data['address'] ?></td>
                                <td style="text-align: center;"><a href="<?= 'edit_mitra.php?id_mitra=' . $data['id_mitra']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                                    &nbsp;<a href="<?= 'functions/function_mitra.php?hapus=' . $data['id_mitra']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php
include_once 'layout/footer.php';
?>