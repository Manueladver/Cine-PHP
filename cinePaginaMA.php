<?php
	
	session_start();
	
	//Redirigir si no esta logueado
	if(!isset($_SESSION['usuario'])) {
		
		header("Location:cineLoginMA.php");
		
	}

?>

<!DOCTYPE>

<html>
	
	<head>
		<title>Super Cines - Página de Compra</title>
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

				<div id="screen-section">

					<?php
				
						echo '<p>¡Bienvenido, <strong>'.$_SESSION['usuario'].'</strong>! <a href="cineLogoutMA.php">(Logout)</a><br>';
				
					?>

					<h2>Comprar entradas</h2>

					<h3>Película: <?php if(empty($_GET)) { echo ""; } else { echo $_GET['pelicula'];} ?></h3>

					<img src="./img/pant.png" title="pantalla cine" alt="pantalla cine"/>

					<form id="pelis" action="cinePaginaMA.php" method="GET" autocomplete="off">

						<?php

							//Conexión a la base de datos
							$conexion = new mysqli('localhost', 'root', '', 'bdcine');
							$error = $conexion->connect_errno;
				
							if ($error != null) { // es decir, ha habido un error
								echo "<p>Error $error conectando a la base de datos: "; 
								echo "$conexion->connect_error</p>"; 				
								exit();
							}

							//Comprobamos si esta vacío el GET para mostrar las sillas por defecto
							if(empty($_GET)) {

								for ($i=0; $i<4; $i++) {

									for($s=0; $s<10; $s++) {
										echo '<img src="./img/sillaLibre.png" title="sillaLibre" alt="sillaLibre"/>';
									}

								echo "<br>";

								}

							} else {

								//Consulta sobre la disponibilidad de las película seleccionada
								$consulta = "SELECT DisponibilidadSillas FROM peliculas WHERE Titulo='$_GET[pelicula]'";

								//Si se da un resultado
								if ($resultado = $conexion->query($consulta)) {

    							//Obtenemos un array con las posiciones
    							while ($fila = $resultado->fetch_row()) {

    								//Creación de filas
    								for($f = 1; $f < 5; $f++) {

    									//Fila 1
    									if($f == 1) {

    										//Creación de asientos
    										for($a1 = 0; $a1 < 10; $a1++) {

    											//Comprobamos si esta ocupado o no
    											if($fila[0][$a1] == 0) {

    												echo '<img name="Fila"src="./img/sillaOcupada.png" title="sillaOcupada" alt="sillaOcupada"/></a>';
							
    											} else {

    												echo '<a style="cursor: pointer;" href="cineCompraMA.php?Fila='.$f.'&Asiento='.$a1.'&pelicula='.$_GET["pelicula"].'"><img src="./img/sillaLibre.png" title="sillaLibre" alt="sillaLibre"/></a>';

    											}

    										}

    										echo "<br>";

    									//Fila 2
    									} else if($f == 2) {

    										//Creación de asientos
    										for($a2 = 10; $a2 < 20; $a2++) {

    											//Comprobamos si esta ocupado o no
    											if($fila[0][$a2] == 0) {

    												echo '<img src="./img/sillaOcupada.png" title="sillaOcupada" alt="sillaOcupada"/>';
							
    											} else {

    												echo '<a style="cursor: pointer;" href="cineCompraMA.php?Fila='.$f.'&Asiento='.$a2.'&pelicula='.$_GET["pelicula"].'"><img src="./img/sillaLibre.png" title="sillaLibre" alt="sillaLibre"/></a>';

    											}

    										}

    										echo "<br>";

    									//Fila 3
    									} else if($f == 3) {

    										//Creación de asientos
    										for($a3 = 20; $a3 < 30; $a3++) {

    											//Comprobamos si esta ocupado o no
    											if($fila[0][$a3] == 0) {

    												echo '<img src="./img/sillaOcupada.png" title="sillaOcupada" alt="sillaOcupada"/>';
							
    											} else {

    												echo '<a style="cursor: pointer;" href="cineCompraMA.php?Fila='.$f.'&Asiento='.$a3.'&pelicula='.$_GET["pelicula"].'"><img src="./img/sillaLibre.png" title="sillaLibre" alt="sillaLibre"/></a>';

    											}

    										}

    										echo "<br>";

    									//Fila 4
    									} else {

    										//Creación de sientos
    										for($a4 = 30; $a4 < 40; $a4++) {

    											//Comprobamos si esta ocupado o no
    											if($fila[0][$a4] == 0) {

    												echo '<img src="./img/sillaOcupada.png" title="sillaOcupada" alt="sillaOcupada"/>';
							
    											} else {

    												echo '<a style="cursor: pointer;" href="cineCompraMA.php?Fila='.$f.'&Asiento='.$a4.'&pelicula='.$_GET["pelicula"].'"><img src="./img/sillaLibre.png" title="sillaLibre" alt="sillaLibre"/></a>';

    											}

    										}

    									}
		    								
    								}

    							}

    							//Cerramos la consulta
   					 			$resultado->close();
								}

							}

							//Cerramos las conexión
							$conexion->close();

						?>
						<br>
						<br>
						<select id="peliculas" name="pelicula">
  							<option value="Alien">Alien</option>
  							<option value="Intocable">Intocable</option>
  							<option value="Shrek">Shrek</option>
  							<option value="Titanic">Titanic</option>
						</select>
						<input style="width: 40%;" type="submit" value="Seleccionar Película">

					</form>

				</div>

			</div>

		</div>			

	</body>

</html>