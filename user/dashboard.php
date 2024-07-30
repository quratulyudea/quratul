<?php
session_start();
include('../config.php');

if (empty($_SESSION['csrf_token'])) {
    header("Location: ../login.php");
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Universitas Teknologi Digital Indonesia</title>
    <link rel="icon" href="../asset/image/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="min-vh-100 bg-light">
        <nav class="navbar sticky-top shadow-sm" style="background-color: #fff;">
            <div class="px-5">
                <a class="navbar-brand fw-bold" href="#"><img src="../asset/image/utdi.png" alt="" width="10%"></a>
            </div>
        </nav>
        <div class="row gx-0">
            <?php
            $nis = $_SESSION['id_user'];
            $sql = "SELECT * FROM tb_siswa WHERE NIS = $nis";
            $query = mysqli_query($db, $sql);
            if ($query) {
                $data = $query->fetch_assoc();
            ?>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <div class="card border-light shadow-sm ms-5 me-2 my-4 ">
                        <?php include('../layouts/sidebarUser.php') ?>
                    </div>
                </div>

                <div class="col-sm-9">
                    <p class="fs-3 fw-bold ps-2 pt-4 text-capitalize">Silahkan Presensi, <?php echo $data['nama'] ?></p>
                    <div class="card border-light me-5 ms-2 my-4 ">
                        <div class="card-body bs-bg-opacity-0 p-4">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">NIS</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" placeholder=": <?php echo $data['NIS'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext text-capitalize" placeholder=": <?php echo $data['nama'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Asal Sekolah</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext text-capitalize" placeholder=": <?php echo $data['asal_sekolah'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Jurusan</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext text-capitalize" placeholder=": <?php echo $data['jurusan'] ?>">
                                </div>
                            </div>
                            <form action="action/presensi.php" method="post">
                                <div class="mb-3 row">
                                    <?php
                                    $id = $_SESSION['id_user'];
                                    $tanggal = date('Y-m-d');
                                    $masuk = "SELECT * FROM tb_presensi WHERE nis = $id AND masuk LIKE '%$tanggal%'";
                                    if (mysqli_query($db, $masuk)->num_rows == 0) {
                                        $data = mysqli_query($db, $masuk)->fetch_assoc();
                                        $now = isset($data['masuk']);
                                        $for = new DateTime($now)
                                    ?>
                                        <div class="col-sm-2">
                                            <button type="submit" name="masuk" class="btn btn-success">Presensi Masuk</button>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="col-sm-2">
                                            <button type="submit" name="masuk" class="btn btn-success disabled">Presensi Masuk</button>
                                        </div>
                                    <?php
                                    }
                                    $keluar = "SELECT * FROM tb_presensi WHERE nis = $id AND keluar LIKE '%$tanggal%'";
                                    if (mysqli_query($db, $keluar)->num_rows == 0) {
                                        $data = mysqli_query($db, $keluar)->fetch_assoc();
                                        $now = isset($data['masuk']);
                                        $for = new DateTime($now)
                                    ?>
                                        <div class="col-sm-7">
                                            <button type="submit" name="keluar" class="btn btn-danger">Presensi Kembali</button>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="col-sm-7">
                                            <button type="submit" name="keluar" class="btn btn-danger disabled">Presensi Kembali</button>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var toastTrigger = $('#liveToast');
        var toast = new bootstrap.Toast(toastTrigger);

        // Show the toast if it exists
        if (toastTrigger.length) {
            toast.show();
        }
    });
</script>
</body>

</html>