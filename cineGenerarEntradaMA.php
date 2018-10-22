<?php

	session_start();
	
	//Redirigir si no esta logueado
	if(!isset($_SESSION['usuario'])) {
		
		header("Location:cineLoginMA.php");
		
	}

	$fila = $_GET['Fila'];
	$asiento = $_GET['Asiento'];
	$titulo = $_GET['pelicula'];

	//Añadimos los archivos necesarios
	require_once("TCPDF/config/tcpdf_config.php");
	require_once("TCPDF/tcpdf.php");

	//Creamos un nuevo obj para genera pfdf
	$pdf = new TCPDF();

	//Márgenes
	$pdf->SetMargins(10,25,10);

	$img = "./img/logo.png";

	//Añadimos la cabecera
	$pdf->setHeaderData('logo.png', 24, 'Super cines', 'Una experiencia de pelicula');

	//Añadimos la pagina al objeto PDF
	$pdf->AddPage();

	//Grosor de la linea de la entrada
	$pdf->SetLineWidth(0.8);
	
	//Parte principal
	$pdf->RoundedRect(10, 15, 90, 50, 8);

	//Margen texto
	$pdf->SetMargins(10,10,50);

	//Añadimos los textos
	$pdf->Cell(0, 0, ' Pelicula: '.$titulo, 0, 1);
	$pdf->Cell(0, 0, ' Fila: '.$fila, 0, 1);
	$pdf->Cell(0, 0, ' Asiento: '.$asiento, 0, 1);
	$pdf->Cell(0, 0, ' Presente esta entrada en taquilla', 0 ,1);

	//Escala de la imagen
	$pdf->setImageScale(5);
	
	//Colocamos imagen en la entrada
	$pdf->Image('logo.png',55,20);

	//Estilos
	$css = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '8', 'phase' => 10, 'color' => array(0, 0, 0));

	//Añadimos la línea discontinua
	$pdf->Line(83, 14, 83, 65, $css);

	//Código de barras CSS
	$css = array(
	    'position' => '',
	    'align' => 'C',
	    'stretch' => false,
	    'fitwidth' => true,
	    'cellfitalign' => '',
	    'border' => false,
	    'hpadding' => 'auto',
	    'vpadding' => 'auto',
	    'fgcolor' => array(0,0,0),
	    'bgcolor' => false,
	    'text' => true,
	    'font' => 'helvetica',
	    'fontsize' => 5,
	    'stretchtext' => 4
	);

    $pdf->write1DBarcode('1234567890123456778', 'UPCA', 20, 50, 50, 13, 2, $css, 'N');

    $pdf->Rotate(90);

    $pdf->write1DBarcode('1234567890123456778', 'UPCA', 8, 140, 50, 13, 32, $css, 'N');

    $pdf->Rotate(0);

	$pdf->Output('Entrada_Pelicula.pdf','D');

?>