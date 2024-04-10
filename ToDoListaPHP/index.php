<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<title>Podaci o dogadjajima</title>
	<meta name="author" content="Vuk Ignjatović vukignjatovic05@gmail.com">
	<meta name="description" content="Mučenje">
	<meta name="keywords" content="html, css, php, primer">
	<link rel="stylesheet" href="stil.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis/com/css2?family=Golos+Text&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-gray-400 bg-gray-900">
	<main class="m-20">
		<a href="dodavanje.php" class="pull-right text-white bg-yellow-500 text-center border-0 mt-3 py-2 px-8 focus:outline-none hover:bg-yellow-600 flex gap-3 flex-row
		items-center rounded text-lg"><i class="fa fa-plus"></i>Dodavanje novog dogadjaja</a>
		<h2 class="text-4xl bold">To do lista:</h2>

		<?php
			require_once "konfiguracija.php";
			$sql = "SELECT * FROM dogadjaj";
			if($result = mysqli_query($link, $sql)){
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
					$encodedId = urlencode($row['id']);
					echo <<<HTML
						<div class="divide-y-2 divide-gray-100">
						<div class="py-8 flex flex-wrap md:flex-nowrap">
							<div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
							<span class="font-semibold title-font text-white-700">ID Događaja: {$row['id']}</span>
							<span class="mt-1 text-gray-500 text-sm">{$row['datum']}</span>
							</div>
							<div class="md:flex-grow">
							<h2 class="text-2xl font-medium text-gray-500 title-font mb-2">Naziv događaja: {$row['naziv']} </h2>
							<p class="leading-relaxed">Broj učesnika {$row['brojUcesnika']}</p>
							<div class="flex gap-5">
								<a href="citanje.php?id={$encodedId}" title="Pregled podataka"
								class="text-indigo-500 inline-flex items-center mt-4">Saznaj više
								<svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path d="M5 12h14"></path>
									<path d="M12 5l7 7-7 7"></path>
									</svg>
								</a>
								<a href="brisanje.php?id={$encodedId}" title="Brisanje podataka"
								class="text-indigo-500 inline-flex items-center mt-4">Obriši događaj
								<svg class="ml-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
									<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
									<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
								</svg>
								</a>
								<a href="azuriranje.php?id={$encodedId}" title="Pregled podataka"
								class="text-indigo-500 inline-flex items-center mt-4">Izmeni događaj
								<svg class="ml-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
									<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
									<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
								</svg>
								</a>
							</div>
							</div>
						</div>
					HTML;
					}
					mysqli_free_result($result);

				}
				else{
					echo '<div class="alert alert-danger"><em>Nije pronađen nijedan zapis.</em></div>';
				}
			}
			else{
					echo "Upss! Nešto je bilo pogrešno. Pokušajte ponovo kasnije.";
				}
				
			mysqli_close($link);
		?>
	</main>
	<footer class="absolute bottom-0 right-0 left-0 text-gray-400 bg-gray-800 body-font">
	<div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
		<a class="flex title-font font-medium items-center md:justify-start justify-center text-white">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-yellow-500 rounded-full" viewBox="0 0 24 24">
			<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
		</svg>
		<span class="ml-3 text-xl">Vuk Ignjatović</span>
		</a>
		<p class="text-sm text-gray-400 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-800
		 sm:py-2 sm:mt-0 mt-4">© 2024 Web programiranje —
		<a href="#" class="text-gray-500 ml-1" 
		target="_blank" rel="noopener noreferrer">@ssk_milutin</a>
		</p>
		<span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
		<a class="text-gray-400">
			<svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
			<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
			</svg>
		</a>
		<a class="ml-3 text-gray-400">
			<svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
			<path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
			</svg>
		</a>
		<a class="ml-3 text-gray-400">
			<svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
			<rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
			<path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
			</svg>
		</a>
		<a class="ml-3 text-gray-400">
			<svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
			<path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
			<circle cx="4" cy="4" r="2" stroke="none"></circle>
			</svg>
		</a>
		</span>
	</div>
	</footer>

</body>
</html>