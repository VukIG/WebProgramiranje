<?php
	if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
	
		require_once "konfiguracija.php";
		$sql = "SELECT * FROM dogadjaj WHERE id = ?";
		
		if($stmt = mysqli_prepare($link, $sql)){
		
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = trim($_GET["id"]);
			
			if(mysqli_stmt_execute($stmt)){

				$result = mysqli_stmt_get_result($stmt);
				
				if(mysqli_num_rows($result) == 1){
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					$naziv = $row["naziv"];
					$datum = $row["datum"];
					$brojUcesnika = $row["brojUcesnika"];
				}
				else{
					header("location: greska.php");
					exit();
				}
			}
			else{
				echo "Upss! Nešto je bilo pogrešno. Pokušajte kasnije.";
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
	}
	else{
		header("location: greska.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<title>Prikaz dogadjaja</title>
	<meta name="author" content="Vuk Ignjatović vukignjatovic05@gmail.com">
	<meta name="description" content="Vežbe iz predmeta Veb programiranje, razvijanje veb aplikacije">
	<meta name="keywords" content="html, css, php, prnazivr">
	<link rel="stylesheet" href="stil.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis/com/css2?family=Golos+Text&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="flex items-center justify-center mt-20 text-gray-400 bg-gray-900">
	<div class="p-4 lg:w-1/3">
        <div class="h-full bg-gray-800 bg-opacity-40 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative">
          <h2 class="tracking-widest text-xs title-font font-medium text-gray-500 mb-1">PREGLED PODATAKA</h2>
          <h1 class="title-font sm:text-2xl text-xl font-medium text-white mb-3"><?php echo $row["naziv"]; ?></h1>
		  <h2 class="tracking-widest title-font font-medium text-gray-500 mb-1">ID:<?php echo $row["id"]; ?> </h2>
          <p class="leading-relaxed mb-3">Photo booth fam kinfolk cold-pressed sriracha leggings jianbing microdosing tousled waistcoat.</p>
		  <p class="leading-relaxed mb-3">Broj učesnika: <?php echo $row["brojUcesnika"]; ?></p>
		  <p class="leading-relaxed mb-3">Datum <?php echo $row["datum"]; ?></p> 
		<p><a href="index.php" class="btn btn-primary">Nazad</a></p>
		</div>
	</div>
</body>
</html>