<?php 
   include("../principal/conectar_principal.php");

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

	$CodigoDeSistema = 7;
	$CodigoDePantalla =15; 
	$Dia = '01';
	include("../principal/conectar_principal.php");
	//echo "Dia: ".$Dia.'<br>';

 
	// rango dia
    $cons_fech = "SELECT year(DATE_ADD(now(),INTERVAL -1 DAY) )AS aa, month(DATE_ADD(now(),INTERVAL -1 DAY) )AS mm, day(DATE_ADD(now(),INTERVAL -1 DAY) )AS dd from dual";
    $Respuesta = mysqli_query($link, $cons_fech);
	if ($Fila = mysqli_fetch_array($Respuesta))	
	   { 				
	  	  $Ano = $Fila["aa"];
		  $Mes = $Fila["mm"];
		  $Dia = $Fila["dd"];
	   }
	  
	 /*     $Ano = '2016';
	  $Mes = '01';
	  $Dia = '15';   */
	  

   //rango mes
	 $ult_dia = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));
	 $fecha_i  = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
     $fecha_t = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT);
     $fecha_finmes = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($ult_dia,2,"0",STR_PAD_LEFT);

     // $fecha_ini = '2016-01-01';
	//  $fecha_ter = '2016-02-01';
	//  $UltimoDia='31';
	 // $Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-".$UltimoDia;
    
   echo "Fecha Ini: ".$fecha_i.'<br>';
   echo " Fecha Ter :".$fecha_t.'<br>';
      echo " Fecha Ter :".$fecha_finmes.'<br>';
   
    $Fecha_Ini_Hora = $fecha_i." 08:00:00";
	$Fecha_Ter_Hora = $fecha_t." 07:59:59";
	
	     // bORRA LA tABLA 
	 
     $BorraMES = "DELETE FROM sea_web.flujos_anodos WHERE cod_flujo IN (123,146,153,191,406,408)";
	 $BorraMES.=  " and  fecha BETWEEN '".$fecha_i."' and '".$fecha_finmes."'";
	 //$BorraMES.= " and month(fecha)= 1 and year(fecha)= 2016 ";
//     $BorraMES.= " and month(fecha)=  '".$Mes."' and year(fecha)= '".$Ano."' ";
     mysqli_query($link, $BorraMES);
     echo $BorraMES."<br><br>";
	

	//echo "FFecha_Ini_Hora: ".$Fecha_Ini_Hora.'<br>';
   // echo " Fecha_Ter_Hora :".$Fecha_Ter_Hora.'<br>';

    //Obtiene los todos flujos
	$ConsultaFlujo = "SELECT distinct cod_flujo FROM proyecto_modernizacion.flujos WHERE sistema = 'SEA' and esflujo<>'N' and cod_flujo in (123,146,153,191,406,408)";
	$ConsultaFlujo.= " ORDER BY cod_flujo";
	
	// echo $Consulta."<br><br>";   

     $Resp = mysqli_query($link, $ConsultaFlujo);
     while ($FilaFlujo = mysqli_fetch_array($Resp)) // WHILE 1

 //  $fecha_aux = $fecha_i; 
 //   while (date($fecha_aux) <= date($fecha_t)) //Recorre los dias.
    {	
    	$marca = "1";	
	    $dif1 = 0;
/*
		$FechaFinAux = date("Y-m-d", mktime(1,0,0,substr($fecha_aux,5,2),substr($fecha_aux,8,2)+1,substr($fecha_aux,0,4)));

         $Fecha_Ini = $fecha_aux;
		 $Fecha_Ter = $FechaFinAux;
		 $Fecha_Ini_Hora = $fecha_aux." 08:00:00";
		 $Fecha_Ter_Hora = $FechaFinAux." 07:59:59";
 */   
         //echo "Fecha Ini : ".$Fecha_Ini.'<br>';
         //echo " Fecha Ter  :".$Fecha_Ter.'<br>';
		 
		 //echo "Fecha Ini_hora: ".$Fecha_Ini_Hora.'<br>';
         //echo " Fecha Ter_hora :".$Fecha_Ter_Hora.'<br>';

        //  echo "Fecha Ini: ".$Fecha_Ini.'<br>';
        // echo " Fecha Ter :".$Fecha_Ter.'<br>';
		
	//	   $Resp = mysqli_query($link, $ConsultaFlujo);
   //     while ($FilaFlujo = mysqli_fetch_array($Resp)) // WHILE 1
   	   $ley_as_Actual = 0;
	   $ley_as_Anterior = 0;
       $fecha_aux = $fecha_i; 
       while (date($fecha_aux) <= date($fecha_t)) //Recorre los dias.
		{
    		$FechaFinAux = date("Y-m-d", mktime(1,0,0,substr($fecha_aux,5,2),substr($fecha_aux,8,2)+1,substr($fecha_aux,0,4)));

            $Fecha_Ini = $fecha_aux;
		    $Fecha_Ter = $FechaFinAux;
		    $Fecha_Ini_Hora = $fecha_aux." 08:00:00";
		    $Fecha_Ter_Hora = $FechaFinAux." 07:59:59";
				  
		    $Flujo = $FilaFlujo["cod_flujo"];
		    $TotalPeso = 0;
			$TotalPesoDia = 0;
			$TonAnterior = 0;
			$TonActual = 0;
		    $ley_as = 0;
		    $ley_s = 0;
	        $PesoH  = 0;
		  
		 //$Registros[$Fila7["hornada"]][08] = 0;
		 //$Registros[$Fila7["hornada"]][26] = 0;
		 
		  // codigo de detalle
		    
		    //Consulta si el flujo representa el movimiento de beneficio
	        $Consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo";
	        $Consulta.= " WHERE flujo = '".$Flujo."'";
	        $Resp3 = mysqli_query($link, $Consulta);
	        if ($Fila3 = mysqli_fetch_array($Resp3))
	        {
		      if ($Fila3["cod_proceso"] == 2)			
			    $Beneficio = "S";
		      else					
			    $Beneficio = "N";
	        }
	        else
	        {		
		     $Beneficio = "N";
	        }					
		
	    //Calcula los finos
	  if ($Beneficio == "S")
	  {
		$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
		$Consulta.= " t1.fecha_movimiento, sum(t1.peso) AS peso_hornada";
		$Consulta.= " FROM sea_web.movimientos AS t1";
		$Consulta.= " WHERE t1.flujo = '".$Flujo."'";
		$Consulta.= " AND ((t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora'";
		$Consulta.= " AND t1.fecha_benef = '0000-00-00')";
		$Consulta.= " OR (t1.fecha_benef BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'))";
		$Consulta.= " GROUP BY t1.hornada";
		$Consulta.= " ORDER BY t1.hornada";
	  }
	  else
	  {
		$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
		$Consulta.= " t1.fecha_movimiento, sum(t1.peso) AS peso_hornada";
		$Consulta.= " FROM sea_web.movimientos AS t1";
		$Consulta.= " WHERE t1.flujo = '".$Flujo."'";
		$Consulta.= " AND t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora'";
		$Consulta.= " GROUP BY t1.hornada";		
		$Consulta.= " ORDER BY t1.hornada";		
	  }
	//if($Flujo=='402')
	//	echo $Consulta."<br>";
	//echo $Consulta."<br>";
	$Registros = array();
	$Resp7 = mysqli_query($link, $Consulta);
	while ($Fila7 = mysqli_fetch_array($Resp7))		
	{
	    //echo "Fecha Ini : ".$Fecha_Ini.'<br>';
		//STOCK PISO RAF MES
		$Consulta = "SELECT SUM(peso) AS peso_piso FROM sea_web.stock_piso_raf";
		$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
		$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
		$Consulta.= " and hornada='".$Fila7["hornada"]."'";
		$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ini."'";
		$Consulta.= " AND flujo='".$FilaFlujo["cod_flujo"]."'";
		$RespPiso = mysqli_query($link, $Consulta);

		if ($FilaPiso = mysqli_fetch_array($RespPiso))
		{
			$PesoPiso = $FilaPiso["peso_piso"];
			$PesoH = $Fila7["peso_hornada"]; //- $PesoPiso);
		}
		else
		{
			$PesoPiso = 0;
			//$PesoH = ($Fila7["peso_hornada"]);
		}
		$horna = $Fila7["peso_hornada"];
		/*echo "PesoHornada : " .$horna.'<br>';
		echo "PesoPiso : " .$PesoPiso.'<br>';
		echo "PesoH : " .$PesoH.'<br>';*/

		//echo $PesoH."<br>"	;
		 $Registros = array();
		 
		//LEYES DE HORNADA
		$Consulta = "SELECT * from sea_web.leyes_por_hornada ";
		$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
		$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
		$Consulta.= " and hornada='".$Fila7["hornada"]."'";
		$Consulta.= " and cod_leyes in('08','26')";
		$RespLeyes = mysqli_query($link, $Consulta);
		$Entro = false;
		while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
		{							
			$Registros[$Fila7["hornada"]][10] = $Fila7["hornada"];
			$Registros[$Fila7["hornada"]][11] = $PesoH;
			$Registros[$Fila7["hornada"]][12] = $Fila7["fecha_movimiento"];
			$Registros[$Fila7["hornada"]][$FilaLeyes["cod_leyes"]] = $FilaLeyes["valor"];
		}
		
	   reset($Registros);
	   while (list($k,$v)=each($Registros))
	   {
		  if ($v[11]>0)
		  {			
			$TotalPeso = $TotalPeso + $v[11];
			$ley_as = $ley_as + ($v["08"]*$v[11]) ;
			$ley_s = $ley_s + ($v["26"]*$v[11]) ;
		  }  
      } // fin while regsitros 
		   
	} // fin flia 7 hornadas
	 if ( $TotalPeso > 0)
	 {
	   $ley_as = $ley_as/$TotalPeso;
       $ley_s = $ley_s/$TotalPeso;
	 }
	 else
	 {
	   $ley_as = 0;
       $ley_s = 0;
	 }
	
	//INCLUYE EL STOCK PISO DEL MES ANTERIOR EN LOS TRASPASOS Y LUEGO RESTA EL STOCK PISO DEL MES ACTUAL
	
// SOLO SI ES EL DIA 1, AL CUAL SE LE CARGARA LOS STOCJK PISO DE MES ANTEIOR - ACTUAKL
//*****************************************************************************************
	
	if ($marca == '1')
	{
	     $RegAnt = array();
		 $RegAct = array();
		 
	    // stock mes actual dia 1
	    $Consulta = "SELECT * FROM sea_web.stock_piso_raf";
	    $Consulta.= " WHERE flujo = '".$Flujo."'";	
   	    $Consulta.= " AND fecha BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
		$RespStock = mysqli_query($link, $Consulta);
		while ($FilaStock = mysqli_fetch_array($RespStock))
	    {
	       $Consulta = "SELECT cod_leyes, valor FROM sea_web.leyes_por_hornada";
		   $Consulta.= " WHERE cod_producto = '".$FilaStock["cod_producto"]."'";
		   $Consulta.= " AND cod_subproducto = '".$FilaStock["cod_subproducto"]."'";
		   $Consulta.= " AND hornada = '".$FilaStock["hornada"]."'";
		   $Consulta.= " AND cod_leyes IN ('08','26')";
		   $RespLeyes = mysqli_query($link, $Consulta);
		   while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
		   {				
			   $RegAct[$FilaStock["hornada"]][11] = $FilaStock["peso"];
			   $RegAct[$FilaStock["hornada"]][$FilaLeyes["cod_leyes"]] = $FilaLeyes["valor"];
		   }
	    } // Fin Ciclo Fila Stock
	    
		reset($RegAct);
	    while (list($k,$v)=each($RegAct))
	    {
		   $TonActual = $TonActual + $v[11];
		   $ley_as_Actual = $ley_as_Actual + ($v["08"]*$v[11]);
		   $ley_s_Actual = $ley_s_Actual + ($v["26"]*$v[11]);		   
   	     }   		
		 if ( $TonActual > 0 )
		 {
            $ley_as_Actual = $ley_as_Actual/$TonActual;
		    $ley_s_Actual = $ley_s_Actual/$TonActual;		
		 }
		 else
		 {
            $ley_as_Actual = 0;
		    $ley_s_Actual = 0;		   		    									 
		 }		 					
			
		 // stock piso mes anterior dia 1
	     $Consulta = "SELECT * FROM sea_web.stock_piso_raf";
         $Consulta.= " WHERE flujo = '".$Flujo."'";	
 	     $Consulta.= " AND fecha BETWEEN SUBDATE('".$fecha_i."', INTERVAL 1 MONTH)";
 	     $Consulta.= " AND SUBDATE('".$fecha_t."', INTERVAL 1 MONTH)";
	     $RespPisoAnt = mysqli_query($link, $Consulta);
		 while ($FilaPisoAnt = mysqli_fetch_array($RespPisoAnt))
	    {
	       $Consulta = "SELECT cod_leyes, valor FROM sea_web.leyes_por_hornada";
		   $Consulta.= " WHERE cod_producto = '".$FilaPisoAnt["cod_producto"]."'";
		   $Consulta.= " AND cod_subproducto = '".$FilaPisoAnt["cod_subproducto"]."'";
		   $Consulta.= " AND hornada = '".$FilaPisoAnt["hornada"]."'";
		   $Consulta.= " AND cod_leyes IN ('08','26')";
		   $RespLeyes = mysqli_query($link, $Consulta);
		   while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
		   {				
			   $RegAnt[$FilaPisoAnt["hornada"]][11] = $FilaPisoAnt["peso"];
			   $RegAnt[$FilaPisoAnt["hornada"]][$FilaLeyes["cod_leyes"]] = $FilaLeyes["valor"];
		   }
	    } // Fin Ciclo Fila Piso Anterior
	    
		reset($RegAnt);
	    while (list($k,$v)=each($RegAnt))
	    {
		   $TonAnterior = $TonAnterior + $v[11];
		   $ley_as_Anterior = $ley_as_Anterior + ($v["08"]*$v[11]);
		   $ley_s_Anterior = $ley_s_Anterior + ($v["26"]*$v[11]);		   
   	     }
		 if ( $TonAnterior > 0 )
		 {
            $ley_as_Anterior = $ley_as_Anterior/$TonAnterior;
		    $ley_s_Anterior = $ley_s_Anterior/$TonAnterior;		   		    							
		 }
		 else
		 {
            $ley_as_Anterior = 0;
		    $ley_s_Anterior = 0;		   		    									 
		 }
		 $dif1 = $TonAnterior - $TonActual;
		 $marca = "0";
		
	} // Fin If Dia Uno

//*************************************************
		   		   		
		   
		   $dif2 = $TotalPeso;
		   $dif = $dif1 + $dif2;
		   
		  /* echo "Fecha Ini : ".$Fecha_Ini.'<br>';
		   echo " dif1: ".$dif1."<br>";
		    echo " dif2: ".$dif2."<br>";
		    echo " dif: ".$dif."<br>";*/

		   if ( $dif < 0 )
		   {
		      $difResta =  $dif;
		      $dif1 = $dif1 - $difResta;
			  $TotalPesoDia = $TotalPeso + $dif1;
			  /* echo " Ley AS: ".$ley_as."<br>";
			    echo " Ley AS Actual: ".$ley_as_Actual."<br>";*/
			  $ley_as = $ley_as*$TotalPeso + ($ley_as_Actual*$dif1);
    		  $ley_s = $ley_s*$TotalPeso + ($ley_s_Actual*$dif1);
			  $dif1 = $difResta;
			  /*echo " difResta: ".$difResta."<br>";
			  echo " Ley AS: ".$ley_as."<br>";*/
			}
			else
			{
			   $TotalPesoDia = $TotalPeso + $dif1;
               $ley_as = $ley_as*$TotalPeso + ($ley_as_Actual*$dif1) ;
	    	   $ley_s = $ley_s*$TotalPeso + ($ley_s_Actual*$dif1)  ;
			   $dif1 = 0;
			 }
		
		   
  		    /*echo " ley_As ".$ley_as."<br>";
            echo " ley_s ".$ley_s."<br>";*/
   
		   $ley_ass =  0; 
           $ley_ss =  0; 
		   
           if ( $TotalPesoDia > 0 )
           {
            $ley_ass =  $ley_as / $TotalPesoDia; 
            $ley_ss =  $ley_s / $TotalPesoDia; 
           } 	
			
		  // fin codigo de detalle
		
          // insertar los flujos
		      
              $insertar = "INSERT INTO sea_web.flujos_anodos (fecha,cod_flujo,peso_ton,ley_as,ley_s)";
		      $insertar.= " VALUES('".$Fecha_Ini."',".$Flujo.",".$TotalPesoDia.",".$ley_ass.",".$ley_ss.")";
		      mysqli_query($link, $insertar);
			 /* if ( $Flujo == '406')
		         echo $insertar."<br><br>";*/
			  	 //Incrementa la fecha en 1 Dia.
	           $ciclo = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	           $rs10 = mysqli_query($link, $ciclo);
	           $row10 = mysqli_fetch_array($rs10);
	           $fecha_aux = $row10["fecha"];


	   }  // FIN WHILE FECHA 
	
    } // FIN WHILE FLUJO

?>

</body>
<script language="javascript"> 
 cerrar_sin(); 
</script>

</html>
<?php include("../principal/cerrar_sea_web.php") ?>
