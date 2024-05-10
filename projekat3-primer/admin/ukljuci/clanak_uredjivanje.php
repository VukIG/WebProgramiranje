<?php
include_once "../ukljuci/funkcije.php"; 
include_once "../ukljuci/konekcija.php"; 
session_start();

if (isset($_SESSION['autor_uloga'])) {
    if ($_SESSION['autor_uloga'] == "admin") {
        if (isset($_GET['id'])) {
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
<h1 class="h2">Уређивање чланка</h1>
<h6>Здраво <?php echo $_SESSION['autor_ime']; ?> | Ваша улога је <?php echo $_SESSION['autor_uloga']; ?></h6>
</div>
<div id="admin-index-form">
<?php
if (isset($_GET['poruka'])) {
    $msg = $_GET['poruka'];
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$msg.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
?>
<?php
$clanak_id = $_GET['id'];
$ObrazacSql = "SELECT * FROM clanak WHERE clanak_id='$clanak_id'"; 
$ObrazacRezultat = mysqli_query($veza, $ObrazacSql);
while ($ObrazacRed = mysqli_fetch_assoc($ObrazacRezultat)) {
    $clanakNaslov = $ObrazacRed['clanak_naslov'];
    $clanakSadrzaj = $ObrazacRed['clanak_sadrzaj']; 
    $clanakSlika = $ObrazacRed['clanak_slika']; 
    $clanakReci = $ObrazacRed['clanak_reci'];
?>
<form method="post" enctype="multipart/form-data">
Наслов чланка
<input type="text" name="clanak_naslov" class="form-control" placeholder="унесите наслов чланка" value="<?php echo $clanakNaslov; ?>"><br> 
Садржај чланка 
<textarea name="clanak_sadrzaj" class="form-control" id="exampleFormControlTextareal" rows="9"><?php echo $clanakSadrzaj; ?></textarea><br> 
<img src="../<?php echo $clanakSlika; ?>" width="150px" height="150px"><br>
Слика
<input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>
Кључне речи
<input type="text" name="clanak_reci" class="form-control" placeholder="унесите клучне речи" value="<?php echo $clanakReci; ?>"><br> 
<button name="prihvati" type="submit" class="btn btn-primary">Ажурирање</button>
</form>
<?php } ?>
<?php
if (isset($_POST['prihvati'])) {
    $clanak_naslov = mysqli_real_escape_string($veza, $_POST['clanak_naslov']); 
    $clanak_sadrzaj = mysqli_real_escape_string($veza, $_POST['clanak_sadrzaj']); 
    $clanak_reci = mysqli_real_escape_string($veza, $_POST['clanak_reci']);
    // Провера да ли су поља изнад празна
    if (empty($clanak_naslov) || empty($clanak_sadrzaj)) {
        echo '<script>window.location = "clanci.php?poruka=Пола+су+празна"; </script>';
        exit();
    }

    if (is_uploaded_file ($_FILES['file']['tmp_name'])) {
        // Корисник жели да ажурира и датотеку
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTmp = $file['tmp_name'];
        $fileErr= $file['error'];
        $fileSize = $file['size'];
        $fileEXT = explode('.', $fileName);
        $fileExtension = strtolower (end ($fileEXT));
        $allowedExt = array ("jpg", "jpeg", "png", "gif");

        if (in_array($fileExtension, $allowedExt)) {
            if ($fileErr === 0) {
                if ($fileSize< 3000000) {
                    //Чување слике у локалном фолдеру
                    $newFileName = uniqid('', true).'.'.$fileExtension;
                    $destination = "../slike/$newFileName";
                    $dbdestination = "slike/$newFileName";
                    move_uploaded_file ($fileTmp, $destination);
                    //Ажурирање података у бази
                    $sql = "UPDATE clanak SET clanak_naslov='$clanak_naslov', clanak_reci='$clanak_reci', clanak_sadrzaj='$clanak_sadrzaj', clanak_slika='$dbdestination' WHERE clanak_id='$clanak_id'"; 
                    if (mysqli_query($veza, $sql)) { 
                        echo '<script>window.location = "clanci.php?poruka=чланак+је+ажуриран"; </script>';
                    } else {
                        echo '<script>window.location = "clanci.php?poruka=грешка"; </script>';
                    }
                } else {
                    echo '<script>window.location = "clanak_dodavanje.php?porukа=Датотека је сувише велика!"; </script>'; 
                    exit();
                }
            } else {
                echo '<script>window.location = "clanak_dodavanje.php?poruka=Грешка при учитавању датотеке"; </script>'; 
                exit();
            }
        } else {
            echo '<script>window.location = "clanak_dodavanje.php?poruka=Датотека нема дозвољени формат!";</script>'; 
            exit();
        }
    } else {
        // Корисник не жели да ажурира и датотеку
        $sql = "UPDATE clanak SET clanak_naslov='$clanak_naslov', clanak_reci='$clanak_reci', clanak_sadrzaj='$clanak_sadrzaj' WHERE clanak_id='$clanak_id'"; 
        if (mysqli_query($veza, $sql)) {
            echo '<script>window.location = "clanci.php?poruka=чланак+је+ажуриран"; </script>';
        } else {
            echo '<script>window.location = "clanci.php?poruka=грешка"; </script>';
        }
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
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apikey=ey51n3e6qq2sq6u5ka28g3yxtbiyj1lzs816qyfegao3c0su"></script>
<script>tinymce.init({ selector: 'textarea' });</script>
</body>
</html>
<?php
        }
    }
} else {
    header("Location: prijavljivanje.php?poruka=молимо+вас+дa+се+приjавите");
}
?>
