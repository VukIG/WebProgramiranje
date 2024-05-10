<?php
include_once "../ukljuci/funkcije.php";
include_once "../ukljuci/konekcija.php"; 
session_start();

if (isset($_SESSION['autor_uloga']) && $_SESSION['autor_uloga'] == "admin") {
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1>Подешавања</h1>
                <h6>Здраво <?php echo $_SESSION['autor_ime']; ?> | Ваша улога је <?php echo $_SESSION['autor_uloga']; ?></h6>
            </div>
            <div id="admin-index-form">
                <?php
                if (isset($_GET['poruka'])){
                    $msg = $_GET['poruka'];
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            '.$msg.'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
                ?>
                <form method="post">
                    Наслов на почетној страници
                    <input type="text" name="pocetna_veliki_naslov" class="form-control" placeholder="Унесите текст наслова" value="<?php echo uzmiPodesavanjeVrednost("pocetna_veliki_naslov"); ?>"><br>
                    Поднаслов (и опис) на почетној страници
                    <textarea name="pocetna_veliki_podnaslov" class="form-control" rows="3" placeholder="Унесите текст поднаслова"><?php echo uzmiPodesavanjeVrednost("pocetna_veliki_podnaslov"); ?></textarea><br>
                    <button name="submit" class="btn btn-success">Ажурирајте подешавања</button><br><br>
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $velikiNaslov = mysqli_real_escape_string($veza, $_POST['pocetna_veliki_naslov']);
                    $velikiPodnaslov = mysqli_real_escape_string($veza, $_POST['pocetna_veliki_podnaslov']);
                    postaviPodesavanjeVrednost("pocetna_veliki_naslov", $velikiNaslov);
                    postaviPodesavanjeVrednost("pocetna_veliki_podnaslov", $velikiPodnaslov);
                    header("Location: podesavanja.php?poruka=Подешавања+су+ажурирана");
                    exit(); // Exit after header to prevent further execution
                }
                ?>
            </div>
        </main>
    </div>
</div>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scroll.js"></script>
</body>
</html>
<?php
} else {
    header("Location: prijavljivanje.php?poruka=Молимо+вас+да+се+пријавите");
    exit(); // Exit after header to prevent further execution
}
?>
