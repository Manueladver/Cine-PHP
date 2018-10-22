<?php

	session_start();
	
	//Redirigir si no esta logueado
	if(!isset($_SESSION['usuario'])) {
		
		header("Location:cineLoginMA.php");
		
	}

	//Conexión a la base de datos
	$conexion = new mysqli('localhost', 'root', '', 'bdcine');
	$error = $conexion->connect_errno;
				
	if ($error != null) { // es decir, ha habido un error
		echo "<p>Error $error conectando a la base de datos: "; 
		echo "$conexion->connect_error</p>"; 				
		exit();
	}

	$consulta = "SELECT DisponibilidadSillas FROM peliculas WHERE Titulo='$_GET[pelicula]'";

	if ($resultado = $conexion->query($consulta)) {

		$fila = $resultado->fetch_row();

		$fila[0][$_GET['Asiento']] = 0;

		$update = "UPDATE peliculas SET DisponibilidadSillas='$fila[0]' WHERE Titulo='$_GET[pelicula]'";

		mysqli_query($conexion, $update);

		/* liberar el conjunto de resultados */
   		$resultado->close();

	}

	$conexion->close();

?>

<!DOCTYPE>

<html>
	
	<head>
		<title>Super Cines - Comprar Entradas</title>
		<link rel="stylesheet" href="./css/style.css">
	</head>

	<body>

		<div id="wrapper">

			<div id="main-content">

				<header>
					<div id="logo">
						<a href="./cineLoginMA.php"><img src="./img/logo.png" class="centered" title="super cines" alt="super cines"/></a>
					</div>
				</header>

				<div id="checkout-section">

					<h2>¡Enhorabuena!</h2>

					<?php

						echo '<p>Has adquirido una entrada. Para descargarla, haz click <a href="cineGenerarEntradaMA.php?Fila='.$_GET["Fila"].'&Asiento='.$_GET["Asiento"].'&pelicula='.$_GET["pelicula"].'">AQUÍ</a></p>';

						echo '<a href="cinePaginaMA.php?pelicula='.$_GET["pelicula"].'"><img style="width: 100px;" src="./img/seguir_comprando.png" title="seguir_comprando" alt="seguir_comprando"/></a>';

					?>

				</div>

			</div>			

		</div>
		
	</body>

</html>