<?php
include_once "../ukljuci/funkcije.php";
include_once "../ukljuci/konekcija.php";
session_start();

if(!isset($_GET['id'])) {
    header("Location: stranice.php?poruka=Молимо+вас+да+кликнете+на+дугме+за+Ажурирање");
    exit();
} else {
    if (!isset($_SESSION['autor_uloga'])) {
        header("Location: prijavljivanje.php?poruka=Please+Login");
        exit();
    } else {
        if ($_SESSION['autor_uloga'] != "admin") {
            echo "Немате могућност приступа овој страници.";
        } else {
            $stranica_id = $_GET['id'];
            $sql = "SELECT * FROM stranica WHERE stranica_id='$stranica_id'";
            $rezultat = mysqli_query($veza, $sql);

            if (mysqli_num_rows($rezultat) <= 0) {
                // Није пронађена страница са датим идентификатором
                header("Location: stranice.php?poruka=Страниша+ниjе+пронајена");
                exit();
            } else {
                while ($ObrazacRed=mysqli_fetch_assoc($ObrazacRezultat)){
                    $stranicaNaslov = $ObrazacRed['stranica_naslov'];
                    $stranicaSadrzaj = $ObrazacRed['stranica_sadrzaj'];
                }
                ?>
                <!DOCTYPE html>
                <html lang="sr">
                <head>
                <?php include_once "ukljuci/zaglavlje.php"; ?>
                </head>
                <body>
                <!--Горњи мени-->
                <?php include_once "ukljuci/gornji_meni.php"; ?>
                <!--Контејнер-->
                <div class="container-fluid">
                <div class="row">
                <!--Леви мени-->
                <?php include_once "ukljuci/levi_meni.php"; ?>
                <!--Главни садржај-->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> <h1 class="h2">уређивање стране</h1>
                <h6>Здраво <?php echo $_SESSION['autor_ime']; ?> | Ваша улога је <?php echo $_SESSION['autor_uloga']; ?></h6> </div>
                <div id="admin-index-form">
                <?php
                if (isset($_GET['poruka'])) {
                    $msg = $_GET['poruka'];
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"> '.$msg.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                }
                ?>
                <form method="post" enctype="multipart/form-data">
                Наслов странице
                <input type="text" name="stranica_naslov" class="form-control" placeholder="унесите наслов стране" value="<?php echo $stranicaNaslov; ?>"><br> Садржај странице <textarea name="stranica_sadrzaj" class="form-control" id="exampleFormControlTextareal" rows="9"><?php echo $stranicaSadrzaj ?></textarea><br> <button name="submit" type="submit" class="btn btn-primary">Ажурирајте</button>
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $stranica_naslov = mysqli_real_escape_string($veza, $_POST['stranica_naslov']);
                    $stranica_sadrzaj = mysqli_real_escape_string($veza, $_POST['stranica_sadrzaj']);
                    // Провера да ли су поља празна
                    if (empty($stranica_naslov) || empty($stranica_sadrzaj)){
                        echo '<script>window.location = "stranice.php?poruka=Empty+Fields"; </script>';
                        exit();
                    }
                    $sql = "UPDATE stranica SET stranica_naslov='$stranica_naslov', stranica_sadrzaj='$stranica_sadrzaj' WHERE stranica_id='$stranica_id'";
                    if (mysqli_query($veza, $sql)) {
                        echo '<script>window.location = "stranice.php?poruka=Странишa+je+Ажурирана"; </script>';
                    } else {
                        echo '<script>window.location = "stranice.php?poruka=гpeшкa"; </script>';
                    }
                }
                ?>
                </div>
                </div>
                </main>
                </div>
                </div>
                <script src="../js/jquery.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/scroll.js"></script>
                <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ey51n3e6qq2sq6u5ka28g3yxtbiyj11zs816qyfegao3c0su"></script>
                <script>tinymce.init({ selector: 'textarea' });</script>
                </body>
                </html>
                <?php
            }
        }
    }
}
?>
