<?php

	session_start();
	
	//Redirigir si no esta logueado
	if(!isset($_SESSION['usuario'])) {
		
		header("Location:cineLoginMA.php");
		
	}

	$fila = $_GET['Fila'];
	$asiento = $_GET['Asiento'];
	$titulo = $_GET['pelicula'];

	//limpiar el bufer de salida
	ob_end_clean();

	$objPDF = new TCPDF();

	//margenes del pdf
	$objPDF->SetMargins(10,25,10);

	// poner el logo y el titulo principal y secundario
	// la imagen para reconocerla debera estar en la misma carpeta que este archivo 
	// por que si no no la reconocera!!!
	$objPDF->setHeaderData('./img/logo.png', 24, 'Super cines', 'Una experiencia de pelicula');

	//añadimos la pagina al objeto PDF
	$objPDF->AddPage();

	// creacion de la entrada
	// grosor de la linea de la entrada
	$objPDF->SetLineWidth(0.8);
	
	// generando la entrada 
	// recuadro entrada principal
	$objPDF->RoundedRect(10, 15, 90, 50, 8);

	//margenes para texto
	$objPDF->SetMargins(10,10,50);
	// textos
	$objPDF->Cell(0, 0, ' Pelicula: '.$titulo, 0, 1);
	$objPDF->Cell(0, 0, ' Fila: '.$fila, 0, 1);
	$objPDF->Cell(0, 0, ' Asiento: '.$asiento, 0, 1);
	$objPDF->Cell(0, 0, ' Presente esta entrada en taquilla', 0 ,1);

	// imagen en la entrada
	$objPDF->setImageScale(5);

	// colocar la imagen en la posion x&y
	$objPDF->Image('logo.png',55,20);

	// estilo para la linea de corte
	$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '8', 'phase' => 10, 'color' => array(0, 0, 0));

	// poner la linea discontinua en el objeto pdf
	$objPDF->Line(83, 14, 83, 65, $style);

	//stylo para el codigo de barras
	$style = array(
	    'position' => '',
	    'align' => 'C',
	    'stretch' => false,
	    'fitwidth' => true,
	    'cellfitalign' => '',
	    'border' => false,
	    'hpadding' => 'auto',
	    'vpadding' => 'auto',
	    'fgcolor' => array(0,0,0),
	    'bgcolor' => false, //array(255,255,255),
	    'text' => true,
	    'font' => 'helvetica',
	    'fontsize' => 5,
	    'stretchtext' => 4
	);

    $objPDF->write1DBarcode('1234567890123456778', 'UPCA', 20, 50, 50, 13, 2, $style, 'N');

    $objPDF->Rotate(90);

    $objPDF->write1DBarcode('1234567890123456778', 'UPCA', 8, 140, 50, 13, 32, $style, 'N');

    $objPDF->Rotate(0);

	$objPDF->Output('EntradaCine.pdf','D');

?>