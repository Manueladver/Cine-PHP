<?php
	session_start();
	if (isset($_POST['entrar']) && !empty($_POST['usuario']) && !empty($_POST['contrasena'])) {
				
		//Intento de conexion
		$usuario = $_POST['usuario'];
		$pass = $_POST['contrasena'];

		echo $usuario;
		echo $pass;				
		$conexion = new PDO('mysql:host=localhost;dbname=bdcine', 'root', '');
		$sql = 'SELECT * FROM usuarios WHERE usuario = :user and contrasena = :pass';
				
		$consulta = $conexion->prepare($sql);
		$consulta->bindParam(":user", $usuario);
		$consulta->bindParam(":pass", $pass);
		$consulta->execute();
				
		$resultado = $consulta->fetch(PDO::FETCH_OBJ);
		
		if($resultado != null) {
					
			$_SESSION['usuario'] = $resultado->usuario;
			header("Location:cinePaginaMA.php");
					
		}
			
	}
	
?>

<!DOCTYPE>

<html>
	
	<head>
		<title>Super Cines - Login</title>
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

				<?php
		
					if(isset($_SESSION['usuario'])) {
				
						echo '<div id="log"><p>Ya estás logueado como: '.$_SESSION['usuario'].'</p>';
						echo '<a href="cineLogoutMA.php">Logout</a></div>';
				
					} else {
				
						if(isset($usuario)) {
					
							echo '<br><p style="color: red;">Los datos introducidos no son correctos. Usuario o contraseña no válido.</p>';
					
					}
				
				?>

				<div id="form-section">

					<h2>Introduce tus datos para iniciar sesión</h2>

					<form id="formLogin" action="cineLoginMA.php" method="POST" autocomplete="off">

						<div id="fields">

							<label for="usuario">Usuario: </label>
							<input type="text" id="usuario" name="usuario" value="<?php if(!empty($_POST['usuario'])) {echo $_POST['usuario']; } ?>">
							<?php
								if(isset($_POST['entrar']) && empty($_POST['usuario']))
									echo "<span style='color:red'> Debe introducir un usuario!!</span>"
							?>
							<label for="contrasena">Contraseña: </label>
							<input type="password" id="contrasena" name="contrasena" value="<?php if(!empty($_POST['contrasena'])) {echo $_POST['contrasena']; } ?>">
							<?php
								if(isset($_POST['entrar']) && empty($_POST['contrasena']))
									echo "<span style='color:red'> Debe introducir una contraseña!!</span>"
							?>

							<br>
							<br>
							<p><input type="submit" name="entrar" value="Entrar"></p>

						</div>

					</form>

					<p>¿Aún no tienes cuenta en Super Cines? ¡<a href="cineRegistroMA.php">Regístrate</a>!</p>

					<?php
		
						}
		
					?>

				</div>

			</div>

		</div>			

	</body>

</html>