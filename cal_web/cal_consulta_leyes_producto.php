<?php 
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
		$Leyes =  "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  "";
	}
	if(isset($_REQUEST["NomLeyes"])) {
		$NomLeyes = $_REQUEST["NomLeyes"];
	}else{
		$NomLeyes =  "";
	}
	$TxtLeyes=$Leyes;
	$LimitIni=$Limite;
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 41;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");



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
			Frm.action= "cal_consulta_leyes_producto.php?Buscar=S&Leyes="+Leyes;
			Frm.submit();
			break;
		case "E"://EXCEL
			Frm.action= "cal_consulta_leyes_producto_excel.php?Buscar=S&Leyes="+Leyes;
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
	frm.action="cal_consulta_leyes_producto.php?Buscar=S&CmbAno="+CmbAno+"&CmbMes="+CmbMes+"&CmbDias="+CmbDias;
	frm.submit(); 
}
function MostrarLeyes(Leyes)
{
	var Frm=document.FrmConsultaAnalisisProducto;
	window.open("cal_leyes_por_producto.php?Pantalla=41&TxtLeyes="+Leyes,""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
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
      <td width="761" align="center" valign="top"> <br>
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
						$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloDescrip[$i];
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$NomLeyes=$NomLeyes." ".$Fila["abreviatura"];
					}
				}
				echo "<input name='TxtLeyes' type='text' value ='$NomLeyes' style='width:400' readonly>";
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
					//$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias;
					//$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT;
				}	
				
				$ArregloAux=explode('-',$TxtLeyes);
				reset($ArregloAux);
				$Arreglo=array();
				$Largo=count($ArregloAux);
				$AnchoTabla=0;//WSO
				for ($i=0;$i<$Largo;$i++)
				{
					$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloAux[$i];
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Arreglo[$ArregloAux[$i]][0]=$Fila["abreviatura"];
					$Arreglo[$ArregloAux[$i]][1]=$ArregloAux[$i];
					$AnchoTabla=$AnchoTabla	+ 50;
				}
				$AnchoTabla=$AnchoTabla	+ 500;
				if (count($Arreglo))
				{				
					
					echo "<table width='$AnchoTabla' border='0' cellpadding='3' cellspacing='0' class='ColorTabla01'>";
					echo "<tr align='center'>";
					echo "<td width='250'>Producto</td>";
					echo "<td width='250'>SubProducto</td>";
					reset($Arreglo);
					ksort($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach($Arreglo as $Clave => $Valor)
					{
						echo "<td width='50' align='center'>";
						if ($Valor[0]!='')
						{
							echo $Valor[0];
							//$CodLeyes=$CodLeyes." t2.cod_leyes='".$Valor[1]."' or ";
							$CodLeyes=" t2.cod_leyes='".$Valor[1]."' or ";
						}
						else
						{
							echo "&nbsp;";
						}	
						echo "</td>";
					}
					$CodLeyes=substr($CodLeyes,0,strlen($CodLeyes)-3);
					// apura consulta
					$ConsTB = "SHOW TABLES FROM `cal_web`";
					$RespTB = mysqli_query($link, $ConsTB);
					while ($FilaTB = mysqli_fetch_array($RespTB))
					{
						if ($FilaTB["Tables_in_cal_web"] == "tmp_paso_leyes")
						{
							$Borra = "DROP TABLE cal_web.tmp_paso_leyes";
							mysqli_query($link, $Borra);							
						}
					}
					//$Consulta.= " and t1.fecha_muestra between '".$Fila["fecha_muestra"]." 00:00:00' and '".$Fila["fecha_muestra"]." 23:59:59' ";
					$Consulta="CREATE table cal_web.tmp_paso_leyes as SELECT * FROM cal_web.solicitud_analisis WHERE NOT isnull(nro_solicitud)  and estado_actual !='7' and estado_actual !='16' and  fecha_hora between '".$FechaI."' and '".$FechaT."' ";
					/*
					$Consulta="CREATE TABLE `cal_web`.`tmp_paso_leyes`";
					$Consulta.=" SELECT * FROM `cal_web`.`solicitud_analisis` t1 ";
					$Consulta.=" WHERE NOT isnull(t1.nro_solicitud) AND t1.estado_actual !=7 AND t1.estado_actual !=16 ";
					$Consulta.=" AND t1.fecha_hora BETWEEN '".$FechaI."' AND '".$FechaT."' ";
					*/
					//$Consulta.=" and  fecha_hora between '".$FechaI." 00:00:00' and '".$FechaT." 23:59:59' ";
					//echo "Consulta:".$Consulta;

					mysqli_query($link, $Consulta);
					// hasta aca
					echo "</tr>";
					echo "</table>";
					echo "<table width='$AnchoTabla' border='1'>";
					//------QUERY MODIFICADA EN EL GROUP ANTES group by t2.producto,t3.subproducto ahora group by producto,subproducto
					//------DVS / LRC 13-06-2014
					$Consulta="select STRAIGHT_JOIN distinct t1.cod_producto,t1.cod_subproducto,t2.descripcion as producto,t3.descripcion as subproducto from cal_web.tmp_paso_leyes t1 "; //cal_web.solicitud_analisis t1 ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
					$Consulta=$Consulta." where not isnull(t1.nro_solicitud) and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by producto,subproducto";
					$Respuesta2=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>";
						echo "<td width='250' align='left'>".$Fila["producto"]."</td>";
						echo "<td width='250' align='left'>".$Fila["subproducto"]."</td>";
						$Consulta="select STRAIGHT_JOIN  t2.cod_leyes,count(t2.cod_leyes)as total from cal_web.tmp_paso_leyes t1 inner join cal_web.leyes_por_solicitud t2 on ";
						$Consulta=$Consulta." t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
						$Consulta=$Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
						$Consulta=$Consulta." where t1.cod_producto=".$Fila["cod_producto"]." and t1.cod_subproducto=".$Fila["cod_subproducto"]." and  ";
						$Consulta.=" (".$CodLeyes.") and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t2.cod_leyes";
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
							$Arreglo[$FilaLeyes["cod_leyes"]][0]='*';
							$Arreglo[$FilaLeyes["cod_leyes"]][1]='*';
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
      <br>	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
