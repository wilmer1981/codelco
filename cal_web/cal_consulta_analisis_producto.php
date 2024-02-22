<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 40;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	set_time_limit(5000);
	$CookieRut=$_COOKIE["CookieRut"];

	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar =  "";
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno =  date("Y");
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes = date("m");
	}
	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias =  date("d");
	}

	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT =  date("Y");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT = date("m");
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT =  date("d");
	}

	if(isset($_REQUEST["Leyes"])) {
		$Leyes = $_REQUEST["Leyes"];
	}else{
		$Leyes = "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  "";
	}
	if(isset($_REQUEST["NomLeyes"])) {
		$NomLeyes = $_REQUEST["NomLeyes"];
	}else{
		$NomLeyes = "";
	}

	$TxtLeyes=$Leyes;
	$LimitIni=$Limite;

?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opcion,Leyes)
{
	var Frm=document.FrmConsultaAnalisisProducto;
	var TotalDiasT=0;
	var CantDiasI=0;
	var CantDiasT=0;
	var TotalDiasI=0;
	var DifDias=0;
	CantDiasI=365*parseInt(Frm.CmbAno.value);
	TotalDiasI=parseInt(CantDiasI)+(31*parseInt(Frm.CmbMes.value))+parseInt(Frm.CmbDias.value);
	CantDiasT=365*parseInt(Frm.CmbAnoT.value);
	TotalDiasT=CantDiasT+(31*parseInt(Frm.CmbMesT.value))+parseInt(Frm.CmbDiasT.value);
	DifDias=TotalDiasT-TotalDiasI;
	if (TotalDiasI>TotalDiasT)
	{
		alert("Fecha Inicio Debe ser menor o igual a Fecha Termino")
		return;	
	}
	if (DifDias > 31)
	{
		alert("Rango de busqueda debe entre 1 y 31 dias")
		return;
	}
	if (Frm.CmbAnoT.value==Frm.CmbAno.value)
	{
		if ((Frm.CmbMesT.value-Frm.CmbMes.value)>1)
		{
			alert("El rango de fecha debe ser menor o igual a 2 meses");
		}
	}
	switch (Opcion)
	{
		case "R"://RECARGA
			Frm.action= "cal_consulta_analisis_producto.php?Buscar=S&Leyes="+Leyes;
			Frm.submit();
			break;
		case "E"://EXCEL
			Frm.action= "cal_consulta_analisis_producto_excel.php?Buscar=S&Leyes="+Leyes;
			Frm.submit();
			break;
	}			
}
function Imprimir()
{
	window.print();
}
function Recarga(LimitIni,CmbCCosto,CmbAno,CmbMes,CmbDias)
{
	var frm=document.FrmConsultaAnalisisProducto;
	frm.action="cal_consulta_analisis_producto.php?Buscar=S&CmbAno="+CmbAno+"&CmbMes="+CmbMes+"&CmbDias="+CmbDias;
	frm.submit(); 
}
function MostrarLeyes(Leyes)
{
	var Frm=document.FrmConsultaAnalisisProducto;
	window.open("cal_leyes_por_producto.php?Pantalla=40&TxtLeyes="+Leyes,""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
}
function Salir()
{
	var Frm=document.FrmConsultaAnalisisProducto;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}

</script>
<title>Consulta General</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaAnalisisProducto" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="776" align="center" valign="top"> <br>
	  <table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td>&nbsp;</td>
            <td width="84%" align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td width="16%">&nbsp;</td>
            <td align="left"> 
              <?php
					echo"Fecha Inicio&nbsp;";
					echo "<select name='CmbDias'>";
						for ($i=1;$i<=31;$i++)
						{
							if (isset($CmbDias))
							{
								if ($i==$CmbDias)
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}
							else
							{
								if ($i==date("j"))
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}	
						  }
					echo"</select>";
					echo"<select name='CmbMes'>";
					  for($i=1;$i<13;$i++)
					  {
							if (isset($CmbMes))
							{
								if ($i==$CmbMes)
								{
									echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
								}
								else
								{
									echo "<option value='$i'>".$meses[$i-1]."</option>\n";
								}
							
							}	
							else
							{
								if ($i==date("n"))
								{
									echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
								}
								else
								{
									echo "<option value='$i'>".$meses[$i-1]."</option>\n";
								}
							}	
						}
					echo "</select>";
					echo "<select name='CmbAno'>";
						for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
						{
							if (isset($CmbAno))
							{
								if ($i==$CmbAno)
									{
										echo "<option selected value ='$i'>$i</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}
							else
							{
								if ($i==date("Y"))
									{
										echo "<option selected value ='$i'>$i</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}		
						}
	    			echo "</select>&nbsp;";
					echo "Fecha Termino&nbsp;";
					echo "<select name='CmbDiasT'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDiasT))
						{
							if ($i==$CmbDiasT)
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}
						else
						{
							if ($i==date("j"))
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}	
					}
				  echo "</select>";
				  echo "<select name='CmbMesT'>";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
				   }
				   echo "</select>";
				   echo "<select name='CmbAnoT'>";
				   for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAnoT))
						{
							if ($i==$CmbAnoT)
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}		
					}
				  echo "</select>";
				?>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left">Leyes&nbsp;
              <input name="BtnLeyes" type="button" value="Leyes" style="width:50" onClick="MostrarLeyes('<?php echo $TxtLeyes;?>');">&nbsp;
			  <input name="TxtLeyes" type="hidden" value ='<?php echo $TxtLeyes;?>'>&nbsp;
			  <?php
				if ($TxtLeyes!='')
				{
					$ArregloDescrip=explode('-',$TxtLeyes);
					reset($ArregloDescrip);
					$Largo=count($ArregloDescrip);
					for ($i=0;$i<$Largo;$i++)
					{
						//$Consulta="select t2.cod_leyes from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud=t2.nro_soliditud  ";
					//	$Consulta.=" where not isnull(t1.nro_solicitud)  and t1.estado_actual !='7' and t1.estado_actual !='16' and  t1.fecha_hora between '".$FechaI."' and '".$FechaT."' and  t2.cod_leyes=".$ArregloDescrip[$i];
						$Consulta="SELECT abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloDescrip[$i];
						//echo $Consulta;
						$Respuesta=mysqli_query($link, $Consulta);
						if($Fila=mysqli_fetch_array($Respuesta))
						{
							$NomLeyes=$NomLeyes." ".$Fila["abreviatura"];
						}
					}
				}
				
					
				echo "<input name='TxtLeyes' type='text' value ='".$NomLeyes."' style='width:400' readonly>";
			  ?>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left">
          </tr >
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp; </td>
          </tr>
          <br>
        </table><br>
        <table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center"> <input name="BtnConsulta" type="button" value="Consultar" style="width:90" onClick="Proceso('R','<?php echo $TxtLeyes;?>');">
              &nbsp; <input name="BtnExcel" type="button" value="Excel" style="width:90" onClick="Proceso('E','<?php echo $TxtLeyes;?>');">
              &nbsp; <input name="BtnImprimir" type="button" value="Imprimir" style="width:90" onClick="Imprimir();">
              &nbsp; <input name="BtnSalir" type="button" value="Salir" style="width:90" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
		<?php
			$RutTB="";
			if (($Buscar=='S') and ($TxtLeyes!=''))
			{
				if (($CmbAno=="") || ($CmbMes=="")|| ($CmbDias==""))
				{
					$FechaI=date("Y-m-d")." 00:00:01";
					$FechaT=date("Y-m-d")." 23:59:59";
				}
				else
				{
					if(strlen($CmbDias)==1){
						$CmbDias= "0".$CmbDias;
					}
					if(strlen($CmbMes)==1){
						$CmbMes= "0".$CmbMes;
					}
					if(strlen($CmbDiasT)==1){
						$CmbDiasT= "0".$CmbDiasT;
					}
					if(strlen($CmbMesT)==1){
						$CmbMesT= "0".$CmbMesT;
					}
					$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
					$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
				}	
				
				$ArregloAux=explode('-',$TxtLeyes);
				//$ArregloAux=explode('-',$LeyesExistentes);
				reset($ArregloAux);
				$Arreglo=array();
				$Largo=count($ArregloAux);
				$AnchoTabla=0;//WSO
				for ($i=0;$i<$Largo;$i++)
				{
						$Consulta="SELECT t2.cod_leyes,t3.abreviatura from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud=t2.nro_solicitud inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes  ";
						$Consulta.=" where not isnull(t1.nro_solicitud)  and t1.estado_actual !='7' and t1.estado_actual !='16' and  t1.fecha_hora between '".$FechaI."' and '".$FechaT."' and  t2.cod_leyes='".$ArregloDescrip[$i]."' limit 1";
					//	$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloDescrip[$i];
					echo $Consulta."<br>";	
				//	$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloAux[$i];
					$Respuesta=mysqli_query($link, $Consulta);
					if($Fila=mysqli_fetch_array($Respuesta))
					{
						$Arreglo[$ArregloAux[$i]][0]=$Fila["abreviatura"];
						$Arreglo[$ArregloAux[$i]][1]=$ArregloAux[$i];
						$AnchoTabla=$AnchoTabla	+ 50;
						$LeyesExistentes=$LeyesExistentes.$Fila['cod_leyes']."-";
					}
				
				
				}
				$AnchoTabla=$AnchoTabla	+ 500;
				if (count($Arreglo))
				{				
					
					echo "<table width='$AnchoTabla' border='1' cellpadding='3' cellspacing='0' >";
					echo "<tr align='center' class='ColorTabla01'>";
					echo "<td width='250'>Producto</td>";
					echo "<td width='250'>SubProducto</td>";
					echo "<td width='100'>Cant. Solicitudes</td>";
					echo "<td width='100'>Cant. Solicitudes Directas</td>";
					echo "<td width='100'>Cant. Solicitudes Finalizadas</td>";
					echo "<td width='100'>% Solicitudes Finalizadas</td>";
					reset($Arreglo);
					ksort($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach($Arreglo as $Clave => $Valor)
					{
						echo "<td width='50' align='center'>";
						if ($Valor[0]!='')
						{
							echo $Valor[0];
							$CodLeyes=$CodLeyes." t2.cod_leyes='".$Valor[1]."' or ";
						}
						else
						{
							echo "&nbsp;";
						}	
						echo "</td>";
					}
					$CodLeyes=substr($CodLeyes,0,strlen($CodLeyes)-3);
					// apura consulta
					$RutTB = substr($CookieRut,0,8);
					//echo $RutTB;
					$ConsTB = "SHOW TABLES FROM `cal_web`";
					$RespTB = mysqli_query($link, $ConsTB);
					while ($FilaTB = mysqli_fetch_array($RespTB))
					{
						if ($FilaTB["Tables_in_cal_web"] == "tmp_paso_".$RutTB)
						{
							$Borra = "DROP TABLE cal_web.tmp_paso_".$RutTB;
							mysqli_query($link, $Borra);
                            //echo $Borra;
							
						}
					}
					$Consulta="create table cal_web.tmp_paso_".$RutTB." as select * from cal_web.solicitud_analisis ";
					$Consulta.=" where not isnull(nro_solicitud)  and estado_actual !='7' and estado_actual !='16' and  fecha_hora between '".$FechaI."' and '".$FechaT."' ";
                    //echo $Consulta."<br>";
                    mysqli_query($link, $Consulta);
					// hasta aca

					echo "</tr>";
					//echo "</table>";
					//echo "<table width='$AnchoTabla' border='1'>";
					
					//------QUERY MODIFICADA EN EL GROUP ANTES group by t2.producto,t3.subproducto ahora group by producto,subproducto
					//------DVS / LRC 13-06-2014
					
					
					function ObtenerTotal($Producto,$Subproducto,$Estado,$Directa,$link)
					{
						global $RutTB;
							$valor=0;
					$Consulta="select STRAIGHT_JOIN count(distinct(t1.nro_solicitud)) as Cantidad from cal_web.tmp_paso_".$RutTB." t1 "; //cal_web.solicitud_analisis t1 ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
					$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and  t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$Subproducto."'  and t1.recargo in (' ','','0')";
					if($Estado!='')
						$Consulta=$Consulta." and t1.estado_actual in ('6','32')"; // SOLICITUDES EN ESTADO TERMINADO
						$RespuestaFunction=mysqli_query($link, $Consulta);
						if ($FilaFunction=mysqli_fetch_array($RespuestaFunction))
						{
							$valor=$FilaFunction['Cantidad'];
						}
						return $valor;
					}
					function ObtenerTotalDirecta($Producto,$Subproducto,$Estado,$Directa,$link)
					{
						global $RutTB;
							$valor=0;
					$Consulta="select STRAIGHT_JOIN count(distinct(t1.nro_solicitud)) as Cantidad from cal_web.tmp_paso_".$RutTB." t1 "; //cal_web.solicitud_analisis t1 ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
					$Consulta=$Consulta." inner join cal_web.estados_por_solicitud t4 on t1.nro_solicitud=t4.nro_solicitud and t4.cod_estado='12' ";
					$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and  t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$Subproducto."' and t1.recargo in (' ','','0')";
					$RespuestaFunction=mysqli_query($link, $Consulta);
						if ($FilaFunction=mysqli_fetch_array($RespuestaFunction))
						{
							$valor=$FilaFunction['Cantidad'];
						}
						return $valor;
					}
					
					
					
					$Consulta="select STRAIGHT_JOIN distinct t1.cod_producto,t1.cod_subproducto,t2.descripcion as producto,t3.descripcion as subproducto from cal_web.tmp_paso_".$RutTB." t1 "; //cal_web.solicitud_analisis t1 ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
					$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and  t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by producto,subproducto";
					$Respuesta2=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						$TotalSolicitud=ObtenerTotal($Fila["cod_producto"],$Fila["cod_subproducto"],'','',$link);
						$TotalSolicitudDirecta=ObtenerTotalDirecta($Fila["cod_producto"],$Fila["cod_subproducto"],'','S',$link);
						$TotalSolicitudTerminada=ObtenerTotal($Fila["cod_producto"],$Fila["cod_subproducto"],'6','',$link);
						$PorcentajeFinalizado=($TotalSolicitudTerminada*100)/$TotalSolicitud;
						echo "<tr align='center'>";
						echo "<td width='250' align='left'>".$Fila["producto"]."</td>";
						echo "<td width='250' align='left'>".$Fila["subproducto"]."</td>";
						echo "<td width='100'>".$TotalSolicitud."</td>";
						echo "<td width='100'>".$TotalSolicitudDirecta."</td>";
						echo "<td width='100'>".$TotalSolicitudTerminada."</td>";
						echo "<td width='100'>".number_format($PorcentajeFinalizado,2,',','.')." % </td>";
				
						$Consulta="select STRAIGHT_JOIN t2.cod_leyes,count(t2.cod_leyes)as total from cal_web.tmp_paso_".$RutTB." t1 inner join cal_web.leyes_por_solicitud t2 on ";
						$Consulta=$Consulta." t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
						$Consulta=$Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
						$Consulta=$Consulta." where  t1.cod_producto=".$Fila["cod_producto"]." and t1.cod_subproducto=".$Fila["cod_subproducto"]." and (".$CodLeyes.") and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t2.cod_leyes";
				//	echo $Consulta."</br>";
						$Respuesta3=mysqli_query($link, $Consulta);
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor)
						{
							$Arreglo[$Clave][0]="&nbsp;";
							$Arreglo[$Clave][1]="&nbsp;";				
						}
						while($FilaLeyes=mysqli_fetch_array($Respuesta3))
						{
							$Arreglo[$FilaLeyes["cod_leyes"]][0]=$FilaLeyes["total"];
							$Arreglo[$FilaLeyes["cod_leyes"]][1]=$FilaLeyes["total"];
						}
						reset($Arreglo);
						ksort($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor)
						{
							echo "<td width='50' align='center'>";
							echo $Valor[1];
							echo "</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				}	
			}	
		?>
		<br>
        <br></td>
	</tr>
  </table>
<?php 
          $ConsTB = "SHOW TABLES FROM cal_web";
          $RespTB = mysqli_query($link, $ConsTB);
          while ($FilaTB = mysqli_fetch_array($RespTB))
          {
               if ($FilaTB["Tables_in_cal_web"] == "tmp_paso_".$RutTB)
               {
                    $Borra = "DROP TABLE cal_web.tmp_paso_".$RutTB;
                    mysqli_query($link, $Borra);
                            //echo $Borra;
                }
           }
?>
 
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
