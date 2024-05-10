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
<h1 class="h2">контролна табла</h1>
<h6>Здраво <?php echo $_SESSION['autor_ime']; ?> | Ваша улога је <?php echo $_SESSION['autor_uloga']; ?></h6>
</div>
<div id="admin-index-form">
<!--Порука-->
<?php
if (isset($_GET['poruka'])) {
    $poruka = $_GET['poruka'];
    // Приказивање поруке
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$poruka.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
?>
<h1>Ваш профил</h1>
<form method="post">
    Име:
    <input name="autor_ime" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Унесите име" value="<?php echo $_SESSION['autor_ime']; ?>"><br>
    Е-адреса:
    <input name="autor_eadresa" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Унесите е-адресу" value="<?php echo $_SESSION['autor_eadresa']; ?>"><br>
    Лозинка:
    <input name="autor_lozinka" type="password" class="form-control" id="exampleInputPassword1" placeholder="Лозинка"><br>
    Основне информације:
    <textarea name="autor_info" class="form-control" id="exampleFormControlTextareal" rows="3"><?php echo $_SESSION['autor_info']; ?></textarea><br>
    <button type="submit" name="update" class="btn btn-primary">Ажурирање података</button>
</form>
<?php
if (isset($_POST['update'])) {
    $autor_ime = mysqli_real_escape_string($veza, $_POST['autor_ime']);
    $autor_eadresa = mysqli_real_escape_string($veza, $_POST['autor_eadresa']);
    $autor_lozinka = mysqli_real_escape_string($veza, $_POST['autor_lozinka']);
    $autor_info = mysqli_real_escape_string($veza, $_POST['autor_info']);
    // Провера да ли има празних поља
    if (empty($autor_ime) || empty($autor_eadresa) || empty($autor_info)) {
        echo "Поља су празна";
    } else {
        // Провера да ли је е-адреса валидна
        if (!filter_var($autor_eadresa, FILTER_VALIDATE_EMAIL)) {
            echo "Молимо вас, унесите валидну е-адресу!";
        } else {
            //Провера да ли је унета нова лозинка
            if (empty($autor_lozinka)) {
                // Корисник не жели да промени своју лозинку
                $autor_id = $_SESSION['autor_id'];
                $sql = "UPDATE autor SET autor_ime='$autor_ime', autor_eadresa='$autor_eadresa', autor_info='$autor_info' WHERE autor_id='$autor_id';";
                if (mysqli_query($veza, $sql)) {
                    $_SESSION['autor_ime'] = $autor_ime;
                    $_SESSION['autor_eadresa'] = $autor_eadresa;
                    $_SESSION['autor_info'] = $autor_info;
                    header("Location: index.php?poruka=Ваш профил је ажуриран");
                } else {
                    echo "Грешка";
                }
            } else {
                // Корисник жели да промени своју лозинку
                $hash = password_hash($autor_lozinka, PASSWORD_DEFAULT);
                $autor_id = $_SESSION['autor_id'];
                $sql = "UPDATE autor SET autor_ime='$autor_ime', autor_eadresa='$autor_eadresa', autor_info='$autor_info', autor_lozinka='$hash' WHERE autor_id='$autor_id';";
                if (mysqli_query($veza, $sql)) {
                    session_unset();
                    session_destroy();
                    header("Location: prijavljivanje.php?poruka=Ваш профил је ажуриран, можете поново да се пријавите");
                } else {
                    echo "Грешка";
                }
            }
        }
    }
}
?>
</div>
</div>
</main>
</div>
</div>
<footer>
<?php include_once "../ukljuci/podnozje.php"; ?>
</footer>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scroll.js"></script>
</body>
</html>
<?php
} else {
    header("Location: prijavljivanje.php?poruka=Молимо вас да се пријавите");
    exit();
}
?>
