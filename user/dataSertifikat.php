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
    <title>Data Tugas | Universitas Teknologi Digital Indonesia</title>
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
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <?php
                if (isset($_SESSION['pesan'])) {
                ?>
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="../asset/image/logo.png" class="rounded me-2" alt="..." width="5%">
                            <strong class="me-auto">File Laporan</strong>
                            <small>Just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <?php echo $_SESSION['pesan']  ?>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['pesan']);
                }
                ?>
            </div>

            <div class="col-sm-3 mb-3 mb-sm-0">
                <div class="card border-light shadow-sm ms-5 me-2 my-4 ">
                    <?php include('../layouts/sidebarUser.php') ?>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="fs-3 fw-bold ps-2 pt-4">DATA LAPORAN</p>
                </div>

                <div class="card border-light me-5 ms-2">
                    <div class="card-body bs-bg-opacity-0 p-0">
                        <?php

                        if (isset($_SESSION['id_user'])) {
                            $nis = $_SESSION['id_user'];
                            $sql = "SELECT * FROM tb_sertifikat WHERE id_pkl = $nis";
                            $query = mysqli_query($db, $sql);
                            if ($query->num_rows > 0) {
                                $data = $query->fetch_assoc();
                        ?>
                                <embed src="../asset/sertifikat/<?php echo $data['file']?>" class="img-preview" type="application/pdf" width="100%" height="550px" frameborder="0">
                        <?php
                            }
                        }
                        ?>
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