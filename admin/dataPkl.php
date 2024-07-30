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
    <title>Data PKL | Universitas Teknologi Digital Indonesia</title>
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
            <div class="col-sm-3 mb-3 mb-sm-0">
                <div class="card border-light shadow-sm ms-5 me-2 my-4 ">
                    <?php include('../layouts/sidebar.php') ?>
                </div>
            </div>
            <div class="col-sm-9">
                <p class="fs-3 fw-bold ps-2 pt-4">DATA SISWA PKL</p>
                <div class="card border-light me-5 ms-2">
                    <div class="card-body bs-bg-opacity-0 p-0">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="ps-5 pt-3 pb-3">
                            <div class="row text-center">
                                <div class="col-10">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Siswa PKL" name="cari" id="cari">
                                </div>
                                <div class="col-auto">
                                    <input type="submit" value="Cari Siswa PKL" class="btn btn-primary btn-sm">
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr class="table-info m-2">
                                    <td class="fw-medium align-middle">
                                        <p class="pt-3  ps-3">No</p>
                                    </td>
                                    <td class="fw-medium align-middle">
                                        <p class="pt-3 ">NIS</p>
                                    </td>
                                    <td class="fw-medium align-middle">
                                        <p class="pt-3 ">Nama</p>
                                    </td>
                                    <td class="fw-medium align-middle">
                                        <p class="pt-3 ">Jurusan</p>
                                    </td>
                                    <td class="fw-medium align-middle">
                                        <p class="pt-3 ">Asal Sekolah</p>
                                    </td>
                                    <td class="fw-medium align-middle text-center">
                                        <p class="pt-3 ">Action</p>
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider" id="data-table">
                                <?php
                                $batas = 5;
                                $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                                $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                                $previous = $halaman - 1;
                                $next = $halaman + 1;
                                if (isset($_GET['cari'])) {
                                    $cari = $_GET['cari'];
                                    $data = mysqli_query($db, "SELECT * FROM tb_siswa WHERE nama LIKE '%$cari%'");
                                    $jumlah_data = mysqli_num_rows($data);
                                    $total_halaman = ceil($jumlah_data / $batas);
                                    $data_pegawai = mysqli_query($db, "SELECT * FROM tb_siswa WHERE nama LIKE '%$cari%' ORDER BY nis DESC limit $halaman_awal, $batas ");
                                    $nomor = $halaman_awal + 1;
                                } else {
                                    $data = mysqli_query($db, "select * from tb_siswa");
                                    $jumlah_data = mysqli_num_rows($data);
                                    $total_halaman = ceil($jumlah_data / $batas);
                                    $data_pegawai = mysqli_query($db, "select * from tb_siswa ORDER BY nis DESC limit $halaman_awal, $batas ");
                                    $nomor = $halaman_awal + 1;
                                }
                                while ($d = mysqli_fetch_array($data_pegawai)) {
                                ?>
                                    <tr class="m-5">
                                        <th class="align-middle" scope="row">
                                            <p class="pt-3 ps-3"><?php echo $nomor++ ?></p>
                                        </th>
                                        <td class="align-middle">
                                            <p class="pt-3" id="nis"><?php echo $d['NIS'] ?></p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="pt-3" id="nama"><?php echo $d['nama'] ?>
                                        </td>
                                        <td class="align-middle">
                                            <p class="pt-3" id="jurusan"><?php echo $d['jurusan'] ?>
                                        </td>
                                        <td class="align-middle">
                                            <p class="pt-3" id="sekolah"><?php echo $d['asal_sekolah'] ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus-<?php echo $d['NIS'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="hapus-<?php echo $d['NIS'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <img src="../asset/image/hapus.png" alt="" width="100%">
                                                    <p class="fw-medium lh-1">Oh no! You're Deleting...</p>
                                                    <p class="fw-medium lh-1 pb-3">Are You sure</p>
                                                    <form action="action/cariPkl.php" method="post">
                                                        <input type="hidden" value="<?php echo $d['NIS'] ?>" name="hapus">
                                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Keluar</button>
                                                        <button class="btn btn-danger" type="submit" name="delete">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php
                        if ($total_halaman > 1) {
                        ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end pe-3">
                                    <li class="page-item">
                                        <a class="page-link" <?php if ($halaman >= 1) {
                                                                    echo "href='?halaman=$previous'";
                                                                } ?>>Previous</a>
                                    </li>
                                    <?php
                                    for ($x = 1; $x <= $total_halaman; $x++) {
                                    ?>
                                        <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" <?php if ($halaman <= $total_halaman) {
                                                                    echo "href='?halaman=$next'";
                                                                } ?>>Next</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

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