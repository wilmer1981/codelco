<?php

   // --- Creado por GMR (unaquenoestabacogida@hotmail.com)
   // Este script crea un gr�fico de barras con unos datos dados, que podr�as adquirir de cualquier otra forma.
   // En la p�gina que queramos mostrarlo s�lo debemos a�adir <img src="grafico.php">
   
   header("Contet-type: image/jpeg"); // Esto indica al navegador que se le va a enviar datos de imagen
   
   
   $ancho_graf = 520;   // ancho del gr�fico
   $alto_graf = 340;    // alto del gr�fico
   $txt = 'Creada por: GMR'; // Si queremos a�adir un texto en la gr�fica, lo introducimos aqu�
   $fuente = 3;   // Es el identificador de la fuente (0..5) que queremos usar
   $margen = 5;   // Marg�nes horizontales
   
   // A�adimos los porcentajes a mostrar
   $datos [] = 0.5;
   $datos [] = 0.33;
   $datos [] = 0.9;
   $datos [] = 0.1;
   $datos [] = 0.2;
   $datos [] = 0.85;
   $datos [] = 0.6;
   $datos [] = 0.4;
   $num_datos = count($datos);
   
  
   // Ajustamos las barras al tama�o del gr�fico
   // Al ancho total hay que restarle: 10 para m�rgenes, 2*numero de datos para separaci�n
   // entre barras, 15 para graduar la gr�fica
   $aux = $ancho_graf - 10 - ($num_datos -1)*2 - 25;
   $ancho_barra = $aux/$num_datos;
   $ancho_barra = intval($ancho_barra);
   
   $im = imagecreatetruecolor ( $ancho_graf , $alto_graf );   // Cramos la imagen sobre la que dibujaremos la gr�fica
   
   // Definimos colores b�sicos para dibujar la gr�fica.
   $negro = imagecolorallocate ( $im , 0 , 0 , 0 );
   $blanco = imagecolorallocate ( $im , 255 , 255 , 255 );
   $rojo = imagecolorallocate ( $im , 255 , 0 , 0 );
   $verde = imagecolorallocate ( $im , 0 , 255 , 0 );
   $gris = imagecolorallocate ( $im , 90 , 90 , 90 );
   
   // bool imagefill ( resource im, int x, int y, int col ) realiza un relleno empezando en la coordenada x,y
   // (arriba izquierda es 0,0) con el color col en la imagen im.
   // Dejamos 10 pixels para marcar las medidas de la gr�fica
   imagefill ($im, 0, 0, $negro);
   
   //imagefilledrectangle ($im, 0, 0, 25, $alto_graf, $gris );  // Dibujamos el �rea en el que ir�n las marcas de la gr�fica   
   $ancho_texto = imagefontwidth($fuente)*strlen($txt);;
   $alto_texto = imagefontheight($fuente);
   imagestring ( $im , $fuente , 2 , $alto_graf - $alto_texto, "0%" , $blanco );
   imagestring ( $im , $fuente , 2 , $alto_graf + $alto_texto - (($alto_graf - 10) * 0.25), "25%" , $blanco );
   imagestring ( $im , $fuente , 2 , $alto_graf + $alto_texto - (($alto_graf - 10) * 0.5), "50%" , $blanco );
   imagestring ( $im , $fuente , 2 , $alto_graf + $alto_texto - (($alto_graf - 10) * 0.75), "75%" , $blanco );
   imagestring ( $im , $fuente , 2 , $alto_graf + $alto_texto - (($alto_graf - 10) * 1), "100%" , $blanco );
  
   
   // Dibujamos las barras correspondientes a los datos
   // imagefilledrectangle ( resource im, int x1, int y1, int x2, int y2, int col ) crea un rect�ngulo relleno con el color col
   // en la imagen im comenzando con las coordenadas superiores izquierdas x1, y1 y finalizando en las coordenadas inferiores
   // derechas x2, y2.
   $pos = $margen + 25;   // Hay que sumarle 15 porque lo hemos dejado para marcar la gr�fica
   $color = $rojo;
   $cont = 0;
   
   while ( $cont < count($datos) ){
      $alto_barra = ($alto_graf - 10) * $datos[$cont];
	  $alto_barra = intval($alto_barra);
	  imagefilledrectangle ($im, $pos, $alto_graf - $alto_barra, $pos + $ancho_barra, $alto_graf, $color );
	  if ($color == $rojo) { $color = $verde; }
	  else { $color = $rojo; }
	  $pos += $ancho_barra + 2;
	  $cont++;
   }
      
   // Por �ltimo introducimos el texto y mostramos la imagen   

   imagestring ( $im , $fuente , $ancho_graf - $ancho_texto - 5 , $alto_texto, $txt , $gris );   
   imagejpeg($im,'',100); // Mostramos la imagen por pantalla con una calidad de 90
   imagedestroy($im);
?>
