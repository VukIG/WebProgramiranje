<?php
include_once "../ukljuci/funkcije.php";
include_once "../ukljuci/konekcija.php"; 
session_start();

if (isset($_SESSION['autor_uloga'])) {
?>
<!DOCTYPE html>
<html lang="sr">
<head>
<?php include_once "../ukljuci/zaglavlje.php"; ?> 
</head>
<body>
<!--Горњи мени-->
<?php include_once "../ukljuci/gornji_meni.php"; ?>
<!--Контејнер-->
<div class="container-fluid">
<div class="row">
<!--Леви мени-->
<?php include_once "../ukljuci/levi_meni.php"; ?>
<!--Главни садржај-->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> 
<a href="clanak_dodavanje.php"><button class="btn btn-info">Додавање новог чланка</button></a>
<h6>Здраво <?php echo $_SESSION['autor_ime']; ?> | Ваша улога је <?php echo $_SESSION['autor_uloga']; ?></h6> </div>
<div id="admin-index-form">
<?php
if (isset($_GET['poruka'])){
$msg = $_GET['poruka'];
echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
'.$msg.'
<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
</button>
</div>';
}
?>
<h1>Чланци:</h1>
<table class="table">
<thead>
<tr>
<th scope="col">ID чланка</th>
<th scope="сol">Слика</th>
<th scope="col">Наслов чланка</th>
<th scope="col">Аутор чланка</th>
<?php if ($_SESSION['autor_uloga']=="admin") { ?>
<th scope="col">Акције</th>
<?php } ?>
</tr>
</thead>
<tbody>
<?php
$sql = "SELECT * FROM clanak ORDER BY clanak_id DESC";
$rezultat = mysqli_query($veza, $sql);
while ($red = mysqli_fetch_assoc($rezultat)) {
    $clanak_id = $red['clanak_id'];
    $clanak_naslov = $red['clanak_naslov'];
    $clanak_slika = $red['clanak_slika'];
    $clanak_autor = $red['clanak_autor'];
    $clanak_sadrzaj = $red['clanak_sadrzaj'];

    $sql_autentifikacija = "SELECT * FROM autor WHERE autor_id='$clanak_autor'";
    $rezultat_autentifikacija = mysqli_query($veza, $sql_autentifikacija);
    while ($autor_red = mysqli_fetch_assoc($rezultat_autentifikacija)) {
        $clanak_autor_ime = $autor_red['autor_ime'];
?>
<tr>
<td><?php echo $clanak_id; ?></td>
<td><img src="../<?php echo $clanak_slika; ?>" width="50px" height="50px"></td>
<td><?php echo $clanak_naslov; ?></td>
<td><?php echo $clanak_autor_ime; ?></td>
<?php if ($_SESSION['autor_uloga'] == "admin") { ?>
<td>
    <a href="clanak_uredjivanje.php?id=<?php echo $clanak_id; ?>"><button class="btn btn-info">Уређивање</button></a>
    <a onclick="return confirm('Да ли сте сигурни?');" href="clanak_uklanjanje.php?id=<?php echo $clanak_id; ?>"><button class="btn btn-danger">Уклањање</button></a>
</td>
<?php } ?>
</tr>
<?php 
    }
}
?>
</tbody>
</table>
</div>
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
    exit();
}
?>
