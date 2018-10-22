<?php
	
	session_start();
		
	if (isset($_POST['registre']) && !empty($_POST['usuario']) && !empty($_POST['contrasena'])) {
			
		$conexion = new mysqli('localhost', 'root', '', 'bdcine');
		$error = $conexion->connect_errno;
				
		if ($error != null) { // es decir, ha habido un error
			echo "<p>Error $error conectando a la base de datos: "; 
			echo "$conexion->connect_error</p>"; 				
			exit();
		}
			
		//Comprobamos si el usuario existe o no
		$searchUser = "SELECT * FROM usuarios WHERE usuario = '$_POST[usuario]'";
		$result = $conexion->query($searchUser);
		$count = mysqli_num_rows($result);
			
		if($count == 1) {
				
			msg_error();
				
		} else {
				
			$consulta = $conexion->stmt_init();
			$consulta->prepare('INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)');
			$usuario = $_POST['usuario'];
			$contrasena = $_POST['contrasena'];
			$consulta->bind_param('ss', $usuario, $contrasena);
			$consulta->execute();
			$consulta->close(); 
			$conexion->close();
				
			header("Location:cineLoginMA.php");
				
		}
			
	}

	function msg_error() {
				
		echo "<p style='color: red;'>El nombre de Usuario ya existe. Introduce otro nombre de usuario.</p>";
					
	}
	
?>
	
<!DOCTYPE>

<html>
	
	<head>
		<title>Super Cines - Registro de Usuarios</title>
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

				<div id="form-section">

					<h2>Registrarme</h2>
	
						<form id="formRegistro" action="cineRegistroMA.php" method="POST" autocomplete="off">

							<div id="fields">

								<label for="usuario">Usuario: </label>
								<input type="text" id="usuario" name="usuario" value="<?php if(!empty($_POST['usuario'])) {echo $_POST['usuario']; } ?>">
								<?php
									if(isset($_POST['registre']) && empty($_POST['usuario']))
										echo "<span style='color:red'> Debe introducir un usuario!!</span>"
								?>

								<label for="contrasena">Contraseña: </label>
								<input type="password" id="contrasena" name="contrasena" value="<?php if(!empty($_POST['contrasena'])) {echo $_POST['contrasena']; } ?>">
								<?php
									if(isset($_POST['registre']) && empty($_POST['contrasena']))
										echo "<span style='color:red'> Debe introducir una contraseña!!</span>"
								?>
								<br>
								<br>
								<p><input style="width: 16%;" type="submit" name="registre" value="Registrarme"><p>

							</div>

						</form>

				</div>

			</div>

		</div>

	</body>

</html>