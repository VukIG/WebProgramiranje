<?php
session_start();
include_once "../ukljuci/konekcija.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
} else {
    // Провера да ли је сесија активна
    if (!isset($_SESSION['autor_uloga'])) {
        header("Location: prijavljivanje.php?poruka=Молимо+вас+да+се+пријавите");
        exit();
    } else {
        // Провера да ли корисник има улогу администратора
        if ($_SESSION['autor_uloga'] != "admin") {
            echo "ГРЕШКА: Ви немате приступ овој страници";
            exit();
        } else if ($_SESSION['autor_uloga'] == "admin") {
            $id = $_GET['id'];
            // Провера да ли чланак постоји
            $sqlProvera = "SELECT * FROM clanak WHERE clanak_id='$id'";
            $result = mysqli_query($veza, $sqlProvera);
            if (mysqli_num_rows($result) <= 0) {
                header("Location: clanci.php?poruka=чланак+не+постоjи");
                exit();
            }
            // Уклањање чланка
            $sql = "DELETE FROM clanak WHERE clanak_id='$id'";
            if (mysqli_query($veza, $sql)) {
                header("Location: clanci.php?poruka=чланак+је+успешно+уклоњен");
                exit();
            } else {
                header("Location: clanci.php?poruka=Није+могуће+уклонити+изабрани+чланак");
                exit();
            }
        }
    }
}
?>
