<?php
include_once "../ukljuci/funkcije.php";
include_once "../ukljuci/konekcija.php";
session_start();

if(!isset($_GET['id'])) {
    header("Location: stranice.php?poruka=кликните+на+дугме+на+страниши");
    exit();
} else {
    if (!isset($_SESSION['autor_uloga'])) {
        header("Location: prijavljivanje.php?poruka=Mолимо+вас+да+се+приjавите");
        exit();
    } else {
        if ($_SESSION['autor_uloga'] != "admin") {
            echo "Немате приступ овој страници";
        } else {
            $stranica_id = $_GET['id'];
            $sql = "SELECT * FROM stranica WHERE stranica_id='$stranica_id'";
            $rezultat = mysqli_query($veza, $sql);

            if (mysqli_num_rows($rezultat) <= 0) {
                // Није пронађена страница
                header("Location: stranice.php?poruka=Cтраниша+ниjе+пронаħена");
                exit();
            } else {
                $stranica_id = $_GET['id'];
                $sql = "DELETE FROM stranica WHERE `stranica_id`='$stranica_id'";
                if (mysqli_query($veza, $sql)) {
                    header("Location: stranice.php?poruka=Страниша+jе+уклонена");
                    exit();
                } else {
                    header("Location: stranice.php?poruka=ниje+могуhе+избрисати+странишу");
                    exit();
                }
            }
        }
    }
}
?>
