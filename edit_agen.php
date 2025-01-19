<?php
include_once 'layout/header.php';
require 'functions/function_agen.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
                <center>Edit Agen</center>
            </h6>
        </div>
        <div class="card-body">
            <form action="functions/function_agen.php" method="POST" enctype="multipart/form-data">
                <?php
                $id_agents   = $_GET['id_agents'];
                $get  = showData($id_agents);
                ?>
                <?php foreach ($get as $data) { ?>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="formGroupExampleInput" class="form-label">No KTP</label>
                            <input name="ktp" type="text" class="form-control form-control-sm" value="<?= $data['ktp'] ?>">
                            <input type="hidden" name="id_agents" value="<?= $data['id_agents'] ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="formGroupExampleInput" class="form-label">Nama Agen</label>
                            <input name="name" type="text" class="form-control form-control-sm" value="<?= $data['name'] ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="formGroupExampleInput" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="formGroupExampleInput" class="form-label">No Telephone</label>
                            <input name="phone" type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="formGroupExampleInput" class="form-label">Alamat</label>
                            <input name="address" type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <br>
                <?php } ?>
                <input type="hidden" name="edit">
                <button class="btn btn-primary btn-sm">Simpan</button>
                <a class="btn btn-secondary btn-sm" href="data_agen.php">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php
include_once 'layout/footer.php';
?>