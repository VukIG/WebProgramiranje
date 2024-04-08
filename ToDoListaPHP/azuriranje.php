<?php
	require_once "konfiguracija.php";
	$naziv=$datum=$brojUcesnika="";
	$naziv_err=$datum_err=$brojUcesnika_err="";
	
	if(isset($_POST["id"]) && !empty($_POST["id"])){
		$id = $_POST["id"];
		
		$input_naziv = trim($_POST["naziv"]);
		if(empty($input_naziv)){
			$naziv_err = "Molimo Vas, unesite naziv.";
		}
		else{
			$naziv = $input_naziv;
		}
		
		$input_datum = trim($_POST["datum"]);
		if(empty($input_datum)){
			$datum_err = "Molimo Vas, unesite datum.";
		}
		else{
			$datum = $input_datum;
		}
		
		$input_brojUcesnika = trim($_POST["brojUcesnika"]);
		if(empty($input_brojUcesnika)){
			$brojUcesnika_err = "Molimo Vas, unesite broj ucesnika.";
		}
		elseif(!ctype_digit($input_brojUcesnika)){
			$brojUcesnika_err = "Molimo Vas da unesete pozitivan ceo broj.";
		}
		else{
			$brojUcesnika = $input_brojUcesnika;
		}
		
		if(empty($naziv_err) && empty($datum_err) && empty($brojUcesnika_err)){
			
			$sql = "UPDATE dogadjaj SET naziv=?, datum=?, brojUcesnika=? WHERE id=?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				
				mysqli_stmt_bind_param($stmt, "sssi", $param_naziv, $param_datum, $param_brojUcesnika, $param_id);
				$param_naziv = $naziv;
				$param_datum = $datum;
				$param_brojUcesnika = $brojUcesnika;
				$param_id = $id;
				
				if(mysqli_stmt_execute($stmt)){
					header("location: index.php");
					exit();
				}
				else{
					echo "Upss! Nešto je bilo pogrešno. Pokušajte ponovo kasnije.";
				}
			}
			mysqli_stmt_close($stmt);
		}
		mysqli_close($link);
	}
	else{
		if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
			$id = trim($_GET["id"]);
			$sql = "SELECT * FROM dogadjaj WHERE id = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "i", $param_id);
				$param_id = $id;
				
				if(mysqli_stmt_execute($stmt)){
					$result = mysqli_stmt_get_result($stmt);
					
					if(mysqli_num_rows($result) == 1){
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						$naziv = $row["naziv"];
						$datum= $row["datum"];
						$brojUcesnika=$row["brojUcesnika"];
					}
					else{
						header("location: greska.php");
						exit();
					}
				}
				else{
					echo "Upss! Nešto je bilo pogrešno. Pokušajte ponovo kasnije.";
				}
			}
			mysqli_stmt_close($stmt);
			mysqli_close($link);
		}
		else{
			header("location: greska.php");
			exit();
		}
	}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<title>Ažuriranje dogadjaja</title>
	<meta name="author" content="Vuk Ignjatović vukignjatovic05@gmail.com">
	<meta name="description" content="Vežbe iz predmeta Veb programiranje, razvijanje veb aplikacije">
	<meta name="keywords" content="html, css, php, prnazivr">
	<link rel="stylesheet" href="stil.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis/com/css2?family=Golos+Text&display=swap" rel="stylesheet">
</head>
<body>
	<main class="wrapper col-md-12">
		<h2 class="mt-5">Ažuriranje dogadjaja</h2>
		<p>Molimo Vas, uredite ulazne podatke i sačuvajte izmene.</p>
		<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
			<div class="form-group">
				<label>naziv</label>
				<input type="text" name="naziv" class="form-control" <?php echo (!empty($naziv_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $naziv; ?>">
				<span class=invalid-feedback"><?php echo $naziv_err; ?></span>
			</div>
			
			<div class="form-group">
				<label>datum</label>
				<input type="date" name="datum" class="form-control" <?php echo (!empty($datum_err)) ? 'is-invalid' : ''; ?><?php echo $datum; ?></input>
				<span class=invalid-feedback"><?php echo $datum_err; ?></span>
			</div>
			
			<div class="form-group">
				<label>brojUcesnika</label>
				<input type="number" name="brojUcesnika" class="form-control" <?php echo (!empty($brojUcesnika_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $brojUcesnika; ?>">
				<span class=invalid-feedback"><?php echo $brojUcesnika_err; ?></span>
			</div>
			
			<input type="hidden" name="id" value="<?php echo $id; ?>"/>
			<input type="submit" class="btn btn-primary" value="Uradi">
			<a href="index.php" class="btn btn-secondary ml-2">Odustani</a> 
			
		</form>
	</main>
</body>
</html>