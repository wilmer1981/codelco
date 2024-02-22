<?php
	$CodigoDeSistema = 7;
	$CodigoDePantalla =15; 
	$Dia = '01';
	include("../principal/conectar_principal.php");
	//echo "Dia: ".$Dia.'<br>';

	// bORRA LA tABLA 

	 

 if($Mostrar == "S")

  {
     // bORRA LA tABLA 
     if (strlen($Mes) == 1)
	       	$Mesi = "0".$Mes;
	 
     $BorraMES = "delete from flujos_anodos where cod_flujo in (92,131,129,93)";
     $BorraMES.= " and month(fecha)=  '".$Mesi."' and year(fecha)= '".$Ano."' ";
   //  $Actualizar.="where ano = '".$Ano."' and mes = '".$Mes."' and  nodo ='".$Fila1["nodo"]."' ";
     mysqli_query($link, $BorraMES);
    // echo $BorraMES."<br><br>";

	 $ult_dia = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));
	 $fecha_ini  = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
	 $fecha_ter = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($ult_dia,2,"0",STR_PAD_LEFT);


   // echo "Fecha Ini: ".$fecha_ini.'<br>';
   // echo " Fecha Ter :".$fecha_ter.'<br>';
    $Fecha_Ini_Hora = $fecha_ini." 08:00:00";
	$Fecha_Ter_Hora = $fecha_ter." 07:59:59";

	//echo "FFecha_Ini_Hora: ".$Fecha_Ini_Hora.'<br>';
   // echo " Fecha_Ter_Hora :".$Fecha_Ter_Hora.'<br>';

    //Obtiene los todos flujos
	$ConsultaFlujo = "SELECT distinct cod_flujo FROM proyecto_modernizacion.flujos WHERE sistema = 'SEA' and esflujo<>'N' and cod_flujo in (92,93,129,131)";
	$ConsultaFlujo.= " ORDER BY cod_flujo";

    $fecha_aux = $fecha_ini; 
    while (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
    {	
		$FechaFinAux = date("Y-m-d", mktime(1,0,0,substr($fecha_aux,5,2),substr($fecha_aux,8,2)+1,substr($fecha_aux,0,4)));

		 $Fecha_Ini_Hora = $fecha_aux." 08:00:00";
		 $Fecha_Ter_Hora = $FechaFinAux." 07:59:59";

		// echo "Fecha Ini: ".$Fecha_Ini_Hora.'<br>';
        // echo " Fecha Ter :".$Fecha_Ter_Hora.'<br>';

		$Resp = mysqli_query($link, $ConsultaFlujo);
       // echo $Consulta."<br><br>";      
        while ($FilaFlujo = mysqli_fetch_array($Resp)) // WHILE 1
		{
			$cod_flujo = $FilaFlujo["cod_flujo"];
			$PesoFlujo = 0;
			$ley_as = 0;
            $ley_s = 0;
			$Codigos = array('08'=>0, '26'=>0);
            $Pesos = array('08'=>0, '26'=>0);

            //echo " CODIGO FLUJO ".$FilaFlujo["cod_flujo"].'<br>';
			
			$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
			$Consulta.= " sum(t1.peso) AS peso_hornada";
			$Consulta.= " FROM sea_web.movimientos AS t1";
			$Consulta.= " WHERE t1.flujo = '".$FilaFlujo["cod_flujo"]."'";
			$Consulta.= " AND t1.fecha_movimiento BETWEEN '".$fecha_aux."' AND '".$FechaFinAux."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' ";
			$Consulta.= " GROUP BY t1.hornada";
            $Resp7 = mysqli_query($link, $Consulta);//$PesoFlujoPisoTot=0;
			//echo $Consulta."<br><br>";    

			while ($FilaHornada = mysqli_fetch_array($Resp7))		
			{

			  // echo "produ: ".$FilaHornada["cod_producto"]."<br><br>";
		      // echo "subpro: ".$FilaHornada["cod_subproducto"]."<br><br>";
             //  echo "hornada: ".$FilaHornada["hornada"]."<br><br>"; 

                $PesoFlujo = $PesoFlujo + $FilaHornada["peso_hornada"]; 
              //  echo "PesoFlujo ".$PesoFlujo."<br>";

               // saca las leyes por hornada
				$Consulta = "select * from sea_web.leyes_por_hornada ";
				$Consulta.= " where cod_producto='".$FilaHornada["cod_producto"]."' ";
				$Consulta.= " and cod_subproducto='".$FilaHornada["cod_subproducto"]."' ";
				$Consulta.= " and hornada='".$FilaHornada["hornada"]."'";
				$Consulta.= " and cod_leyes in('08','26')";
				$RespLeyes = mysqli_query($link, $Consulta);
				//echo $Consulta."<br><br>";  

				while ($FilaLeyes = mysqli_fetch_array($RespLeyes))  //recorre las leyes de As y S por hornada
	            {
		          // guardo la ley
		        //  echo "hornada: ".$FilaHornada["hornada"]."<br>";
			     // echo "leyes: ". $FilaLeyes["cod_leyes"]."<br>"; 
	              $Codigos[$FilaLeyes["cod_leyes"]] = $Codigos[$FilaLeyes["cod_leyes"]] + ($FilaHornada["peso_hornada"] * $FilaLeyes["valor"] );					
	              $Pesos[$FilaLeyes["cod_leyes"]] = $Pesos[$FilaLeyes["cod_leyes"]] + ($FilaHornada["peso_hornada"]);
			
	            } //
               
			 
			 }  

			   If ($PesoFlujo == 0 )
			   {
			   	// echo "ENTRO AL IF ".$PseoFlujo."<br>";

			   	$ley_as = 0;
			   	$ley_s = 0;
			   	
			   }

			   else
			   {

		
				  If ($Pesos["08"] > 0 && $Codigos["08"]>0 )
                //   $ley_as = number_format(($Codigos["08"]/$Pesos["08"]) ,0,",","");
				     $ley_as = ($Codigos["08"]/$Pesos["08"]);
                  If ($Pesos["26"] > 0  && $Codigos["26"]>0)
                //  $ley_s = number_format(($Codigos["26"]/$Pesos["26"]) ,0,",","");
                    $ley_s = ($Codigos["26"]/$Pesos["26"]);
                
                 //echo " COD_FLUJO : ".$cod_flujo."<br>";
                }

                  // insertar los flujos
                $insertar = "INSERT INTO sea_web.flujos_anodos (fecha,cod_flujo,peso_ton,ley_as,ley_s)";
		        $insertar.= " VALUES('".$fecha_aux."',".$cod_flujo.",".$PesoFlujo.",".$ley_as.",".$ley_s.")";
		        mysqli_query($link, $insertar);
		       // echo $insertar."<br><br>";


		}  // FIN WHILE FLUJO 

		   //Incrementa la fecha en 1 Dia.
	$ciclo = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	$rs10 = mysqli_query($link, $ciclo);
	$row10 = mysqli_fetch_array($rs10);
	$fecha_aux = $row10["fecha"];	
	
    } // FIN WHILE DIA 

 $Mostrar = 'N';
}


?>
<html>
<head>
<title>SISTEMA CARGA ANEXO DEL SISTEMA DE ANODOS</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":
			
			f.action = "sea_con_anexo_CargaMasiva.php?Mostrar=S";				
			f.submit();		

			break;	
			
			case "S":
			
			 window.open('','_parent','');
             window.close(); 
		
	}
}
function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "sea_con_anexo_CargaMasiva.php";
	f.submit();
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

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
  <table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
  
      <tr> 
        <td width="27%"> INGRESE PERIODO CARGA:</td>
	  </tr>  
		<br> 
		<br> 
    <tr>
      <td valign="top">
     <table width="76%" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
       				
		<tr> 	
            <select name="Mes" id="select5" style="width:110px">
                <?php
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
              </select>
              <select name="Ano" style="width:70px">
                <?php
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
            </select></td>
          </tr>
         </table>
      <br>      
	  <br>      <table width="76%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr>
          <td width="100%" align="center"><input name="BtnConsultar2" type="button" value="Cargar flujo" style="width:80px" onClick="Proceso('C');">
              <input name="BtnSalir2" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"></td>

        </tr>
      </table></td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
