<?php
	require_once "konfiguracija.php";
	
	$naziv = $datum = $brojUcesnika = "";
	$naziv_err = $datum_err = $brojUcesnika_err = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	
		$input_naziv = trim($_POST["naziv"]);
		if(empty($input_naziv)){
			$naziv_err = "Molimo Vas, unesite naziv.";
		}
		else{
			$naziv = $input_naziv;
		}
		
		$input_datum = trim($_POST["datum"]);
		if(empty($input_datum)){
			$datum_err = "Molimo Vas, unesite adresu.";
		}
		else{
			$datum = $input_datum;
		}
		
		$input_brojUcesnika = trim($_POST["brojUcesnika"]);
		if(empty($input_brojUcesnika)){
			$brojUcesnika_err = "Molimo Vas, unesite zaradu.";
		}
		elseif(!ctype_digit($input_brojUcesnika)){
			$brojUcesnika_err = "Molimo Vas da unesete pozitivan ceo broj.";
		}
		else{
			$brojUcesnika = $input_brojUcesnika;
		}
		
		if(empty($naziv_err) && empty($datum_err) && empty($brojUcesnika_err)){
			$sql = "INSERT INTO dogadjaj (naziv, datum, brojUcesnika) VALUES (?, ?, ?)";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "sss", $param_naziv, $param_datum, $param_brojUcesnika);
				$param_naziv = $naziv;
				$param_datum = $datum;
				$param_brojUcesnika = $brojUcesnika;
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
?>

<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<title>Dodavanje dogadjaja</title>
	<meta name="author" content="Vuk Ignjatović vukignjatovic05gmail.com">
	<meta name="description" content="Vežbe iz predmeta Veb programiranje, razvijanje veb aplikacije">
	<meta name="keywords" content="html, css, php, prnazivr">
	<link rel="stylesheet" href="stil.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis/com/css2?family=Golos+Text&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
	<section class="text-gray-400 bg-gray-900 body-font h-[100vh]">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container px-5 py-24 w-[70vw] mx-auto flex flex-wrap items-center">
		<div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
		<h1 class="title-font font-medium text-3xl text-white">
			Savršeno optimizovana To-do-lista. Bez naprezanje, polako s plaćanje</h1>
		<p class="leading-relaxed mt-4">
			Dodajte Vaše omiljene događaje ovde. 
			Unesite Naziv, Datum i broj učesnika
		</p>
		</div>
		<div class="lg:w-2/6 md:w-1/2 bg-gray-800 bg-opacity-50 rounded-lg p-8 flex 
		flex-col md:ml-auto w-full mt-10 md:mt-0">
		<h2 class="text-white text-lg font-medium title-font mb-5">Dodaj događaj:</h2>
		<div class="relative mb-4">
			<label for="naziv" class="leading-7 text-sm text-gray-400">Naziv</label>
			<input type="text" id="naziv" name="naziv" class="w-full <?php echo(!empty($naziv_err)) ? 'bg-red-500' : 'bg-gray-600'; ?> bg-opacity-20 focus:bg-transparent 
			focus:ring-2 focus:ring-yellow-900 rounded border border-gray-600 focus:border-yellow-500 
			text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
			value="<?php echo $naziv; ?>" >
			<span class="text-red-500"><?php echo $naziv_err; ?></span>
		</div>
		<div class="relative mb-4">
			<label for="datum" class="leading-7 text-sm text-gray-400">Datum</label>
			<input type="date" id="datum" name="datum" class="w-full <?php echo(!empty($datum_err)) ? 'bg-red-500' : 'bg-gray-600'; ?> bg-gray-600 bg-opacity-20 
			focus:bg-transparent focus:ring-2 focus:ring-yellow-900 rounded border border-gray-600 
			focus:border-yellow-500 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors 
			duration-200 ease-in-out" value="<?php echo $datum; ?>">
			<span class="text-red-500"><?php echo $datum_err; ?></span>
		</div>
		<div class="relative mb-4">
			<label for="brojUcesnika" class="leading-7 text-sm text-gray-400">Broj učesnika</label>
			<input type="number" id="brojUcesnika" name="brojUcesnika" class="w-full <?php echo(!empty($brojUcesnika_err)) ? 'bg-red-500' : 'bg-gray-600'; ?> bg-gray-600 bg-opacity-20 
			focus:bg-transparent focus:ring-2 focus:ring-yellow-900 rounded border border-gray-600 
			focus:border-yellow-500 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors 
			duration-200 ease-in-out" value="<?php echo $brojUcesnika; ?>">
			<span class="text-red-500"><?php echo $brojUcesnika_err; ?></span>
		</div>
		<input type="submit" class="text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg" value="Dodaj">
		<a href="index.php" class="text-white bg-yellow-500 text-center border-0 mt-3 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg" ml-2>Odustani</a>
		</div>
	</form>
	</section>
</body>
</html>