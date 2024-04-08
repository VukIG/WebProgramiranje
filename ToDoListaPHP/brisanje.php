<?php
	if(isset($_POST["id"]) && !empty($_POST["id"])){
		
		require_once "konfiguracija.php";
		$sql = "DELETE FROM dogadjaj WHERE id = ?";
		
		if($stmt = mysqli_prepare($link, $sql)){
			
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = trim($_POST["id"]);
			
			if(mysqli_stmt_execute($stmt)){
				header("location: index.php");
				exit();
			}
			else{
				echo "Upss! Nešto je bilo pogrešno. Pokušajte ponovo kasnije.";
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
	}
	else{
		if(empty(trim($_GET["id"]))){
			header("location: greska.php");
			exit();
		}
	}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<title>Brisanje dogadjaja</title>
	<meta name="author" content="Vuk Ignjatović vukignjatovic05Ćgmail.com">
	<meta name="description" content="Vežbe iz predmeta Veb programiranje, razvijanje veb aplikacije">
	<meta name="keywords" content="html, css, php, primer">
	<link rel="stylesheet" href="stil.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis/com/css2?family=Golos+Text&display=swap" rel="stylesheet">
</head>
<body>
	<main class="wrapper col-md-12">
		<h2 class="mt-5 mb-3">Brisanje dogadjaja</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="alert alert-danger">
				<input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
				<p>Da li ste sigurni da želite da obrišete podatke o ovom dogadjaju?</p>
				<p>
					<input type="submit" value="Da" class="btn btn-danger">
					<a href="index.php" class="btn btn-secondary">Ne</a>
				</p>
			</div>
		</form>
	</main>
</body>
</html>