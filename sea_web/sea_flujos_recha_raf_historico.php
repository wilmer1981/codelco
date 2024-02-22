<?php include("../principal/conectar_sea_web.php") 

?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">

function Salir()
{
	window.history.back();
}

function Imprimir()
{
	window.print();
}

</script>

</head>

<SCRIPT LANGUAGE="JavaScript">
function cerrar_sin()
{  
 window.open('','_parent','');
 window.close(); 
} 
</script> 

<SCRIPT LANGUAGE="JavaScript">
function cerrar_con()
{  
 window.close(); 
} 
</script> 

<body class="TablaPrincipal">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
    <td align="center">RECHAZADOS A RAF</td>
  </tr>
 
</table>
<br>

<table width="330" border="0" cellpadding="0" cellspacing="0" align="center" class="ColorTabla01">
  <tr>
<?php

           $cmborigen =  "T"; // filtrado por todos los productos
		   $radio = "F";  //filtrado por flujos
	       $radio2 = "L";  //filtrado por leyes

        	echo '<td align="center">LEYES</td>';
		 //  $cons_fech = "select  year(now()) aa, month(now()) mm, day(now()) dd   from dual  ";
	   /*  $cons_fech = "SELECT year(DATE_ADD(now(),INTERVAL -1 DAY) )AS aa, month(DATE_ADD(now(),INTERVAL -1 DAY) )AS mm, day(DATE_ADD(now(),INTERVAL -1 DAY) )AS dd from dual";
	     $Respuesta = mysqli_query($link, $cons_fech);
		 if ($Fila = mysqli_fetch_array($Respuesta))	
		   { 				
	  		  $ano_i = $Fila["aa"];
			  $mes_i = $Fila["mm"];
			  $dia_i = $Fila["dd"];
		   } */

?>
  </tr>
</table>
<br>


<br>

<?php
 set_time_limit(300);
 
	
  //  nueva forma de c�lculo LFF 05-10-2016 por flujo en forma diaria
	
	// $Ano = '2016';
	// $Mes = '07';
	// $Dia = '01';
	
	 // rango de 1 dia  		      
	// $FechaIni = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT);
	// $FechaFin = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT); 
	 
	 // rango de mes
	 $ult_dia = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));
	 $FechaIni = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
	 $FechaFin = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($ult_dia,2,"0",STR_PAD_LEFT);
	 
	 /* echo "fecha ini : ".$FechaIni." ";
	  echo "fecha fin : ".$FechaFin." "; */

   // borrar en tabla los datos del mes a insertar del blister
			
	$borrar = " DELETE FROM sea_web.flujos_anodos ";
	//$borrar.= " WHERE fecha BETWEEN '2016-11-01' and '2016-11-30' ";
	$borrar.=  " WHERE fecha BETWEEN '".$FechaIni."' and '".$FechaFin."'";
	//$borrar.=  " AND   cod_flujo in (145,170,180,281,402,404) ";
	$borrar.=  " AND cod_flujo in ( SELECT distinct flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo " ;
    $borrar.=  " WHERE cod_producto = 17 and cod_proceso = 4 and flujo > 0 )";
	mysqli_query($link, $borrar);
	//echo $borrar."<br>";
	 
	//Obtiene los todos flujos
   $ConsultaFlujo = " SELECT distinct flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo " ;
   $ConsultaFlujo.= " WHERE cod_producto = 17 and cod_proceso = 4 and flujo > 0 ";
   $ConsultaFlujo.= " ORDER BY  flujo ";

   $fecha_aux = $FechaIni; 
   
   while (date($fecha_aux) <= date($FechaFin)) //Recorre los dias.
   {	
     $FechaFinAux = date("Y-m-d", mktime(1,0,0,substr($fecha_aux,5,2),substr($fecha_aux,8,2)+1,substr($fecha_aux,0,4)));
	 //echo "fecha aux : ".$FechaFinAux." ";
	 $Resp = mysqli_query($link, $ConsultaFlujo);
     while ($Fila_flujo = mysqli_fetch_array($Resp))   // recorrre los flujos 
     {
      $cod_flujo = $Fila_flujo["flujo"];
      $PesoFlujo = 0;
      $peso_ton = 0;
      $ley_as = 0;
      $ley_s = 0;
	  //echo "flujo: ".$cod_flujo." ";
	  
      $Codigos = array('08'=>0, '26'=>0);
      $Pesos = array('08'=>0, '26'=>0);
	  
     // busca las hornadas para el flujo
      $Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
      $Consulta.= " sum(t1.peso) AS peso_hornada";
      $Consulta.= " FROM sea_web.movimientos AS t1"; 
      $Consulta.= " WHERE t1.flujo = '".$Fila_flujo["flujo"]."'";
      $Consulta.= " AND tipo_movimiento = 4 "; // traspaso
	//  $Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_aux."' AND '".$FechaFinAux."'";
      $Consulta.= " and hora between '".$fecha_aux." 08:00:00' and '".$FechaFinAux." 07:59:59'";
      $Consulta.= " GROUP BY t1.hornada";

      $Resp7 = mysqli_query($link, $Consulta);
    //if ($Fila_flujo["cod_flujo"]=='145')
    //	echo $Consulta."<br>";

      while ($Fila_horna = mysqli_fetch_array($Resp7))		//recorre las hornadas
      {
	     /*  echo "produ: ".$Fila_horna["cod_producto"]." ";
		   echo "subpro: ".$Fila_horna["cod_subproducto"]." ";
           echo "hornada: ".$Fila_horna["hornada"]." "; */
		   
         $PesoFlujo = $PesoFlujo + $Fila_horna["peso_hornada"]; 

        // saca las leyes por hornada

         $Consulta = "select * from sea_web.leyes_por_hornada ";
         $Consulta.= " where cod_producto='".$Fila_horna["cod_producto"]."' ";
         $Consulta.= " and cod_subproducto='".$Fila_horna["cod_subproducto"]."' ";
         $Consulta.= " and hornada='".$Fila_horna["hornada"]."'";
         $Consulta.= " and cod_leyes in('08','26')";  // As y S
         $RespLeyes = mysqli_query($link, $Consulta);
	   
         while ($FilaLeyes = mysqli_fetch_array($RespLeyes))  //recorre las leyes de As y S por hornada
	     {
		   // guardo la ley
		    /* echo "hornada: ".$Fila_horna["hornada"]." ";
			 echo "leyes: ". $FilaLeyes["cod_leyes"]." "; */
	        $Codigos[$FilaLeyes["cod_leyes"]] = $Codigos[$FilaLeyes["cod_leyes"]] + ($Fila_horna["peso_hornada"] * $FilaLeyes["valor"] );					
	        $Pesos[$FilaLeyes["cod_leyes"]] = $Pesos[$FilaLeyes["cod_leyes"]] + ($Fila_horna["peso_hornada"]);
			
	     } //fin ciclo recorre las leyes de As y S por hornada

       }      // fin ciclo recorre las hornadas
  
        $peso_ton =  $PesoFlujo ;
        If ($Pesos["08"] > 0 && $Codigos["08"]>0 )
            $ley_as =  ($Codigos["08"]/$Pesos["08"])  ;
        If ($Pesos["26"] > 0  && $Codigos["26"]>0)
             $ley_s =  ($Codigos["26"]/$Pesos["26"]) ;

         if ($PesoFlujo = 0  )
		 { 
           //Consulto el peso total por el flujo
           $Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
           $Consulta.= " WHERE flujo = '".$Fila_flujo["flujo"]."'";
           $Consulta.= " AND tipo_movimiento = 4 AND cod_producto = 17 " ;
           // $Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_aux."' AND '".$FechaFinAux."'";
           $Consulta.= " and hora between '".$fecha_aux." 08:00:00' and '".$FechaFinAux." 07:59:59'";
			
           $Resp4 = mysqli_query($link, $Consulta);
           $Fila_tot = mysqli_fetch_array($Resp4);
           $peso_total =  $Fila_tot["peso"] ;
		   $peso_ton =  $Fila_tot["peso"] ; 
		  }  
		// echo "flujo: ".$cod_flujo." ";
		 //echo "peso total: ".$peso_total." "; 
 
      // insertar los flujos
         $insertar = "INSERT INTO sea_web.flujos_anodos (fecha,cod_flujo,peso_ton,ley_as,ley_s)";
		 $insertar.= " VALUES('".$fecha_aux."',".$cod_flujo.",".$peso_ton.",".$ley_as.",".$ley_s.")";
		 mysqli_query($link, $insertar);
		//   echo $insertar."<br>";	
   
     } // fin recorrre los flujos	
	 
	     //Incrementa la fecha en 1 Dia.
	    $ciclo = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	    $rs10 = mysqli_query($link, $ciclo);
	    $row10 = mysqli_fetch_array($rs10);
	    $fecha_aux = $row10["fecha"];	
			
   } // fin Recorre los dias.	
		
		   echo "termino el proceso";	
	//
   
?>


</body>

<script language="javascript"> 
cerrar_sin(); 
</script>

</html>
<?php include("../principal/cerrar_sea_web.php") ?>