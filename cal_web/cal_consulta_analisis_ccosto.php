<?php 
	//$LimitIni=$Limite;
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 32;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar =  "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  "";
	}
	if(isset($_REQUEST["CmbCCosto"])) {
		$CmbCCosto = $_REQUEST["CmbCCosto"];
	}else{
		$CmbCCosto =  "";
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
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
		//$LimitIni=$Limite;
	}else{
		$LimitIni =  0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin =  99;
	}
?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opcion,LimitIni,LimitFin)
{
	var Frm=document.FrmConsultaAnalisisCCosto;

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
			Frm.action= "cal_consulta_analisis_ccosto.php?Buscar=S";
			Frm.submit();
			break;
		case "E"://EXCEL
			Frm.action= "cal_consulta_analisis_ccosto_excel.php?Buscar=S&LimitIni="+LimitIni+"&LimitFin="+LimitFin;
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
	var frm=document.FrmConsultaAnalisisCCosto;
	frm.action="cal_consulta_analisis_ccosto.php?Buscar=S&Limite="+LimitIni+"&CmbCCosto="+CmbCCosto+"&CmbAno="+CmbAno+"&CmbMes="+CmbMes+"&CmbDias="+CmbDias;
	frm.submit(); 
}

function Salir()
{
	var Frm=document.FrmConsultaAnalisisCCosto;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}

</script>
<title>Consulta General</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaAnalisisCCosto" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
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
						for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
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
				   for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
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
            <td align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left">Centro de Costo 
              <?php
				echo "<select name='CmbCCosto' style='width:280'>";
				echo "<option value ='-1' selected>Todos</option>";
				$Consulta = "SELECT centro_costo,descripcion from centro_costo  where mostrar_calidad='S' order by centro_costo";
				$Respuesta = mysqli_query ($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCCosto==$Fila["centro_costo"])
					{
						echo "<option value = '".$Fila["centro_costo"]."' selected >".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}
					else
					{
						echo "<option value = '".$Fila["centro_costo"]."'>".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}	
				}
				echo "<option value ='-1'>______________________________________________</option>";
				$Consulta = "SELECT centro_costo,descripcion from centro_costo  where mostrar_calidad<>'S' order by centro_costo";
				$Respuesta = mysqli_query ($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCCosto==$Fila["centro_costo"])
					{
						echo "<option value = '".$Fila["centro_costo"]."' selected >".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}
					else
					{
						echo "<option value = '".$Fila["centro_costo"]."' >".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}	
				}
			?>
              &nbsp;Limite&nbsp;<input type="text" name="LimitFin" style="width:30" maxlength="2" value="<?php echo $LimitFin;?>"></td>
          </tr >
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp; </td>
          </tr>
          <br>
        </table>
        <br>
		<?php
			//$ConsultaLimit=""; //WSO
			if ($Buscar=='S')
			{
				$ConsultaLimit=""; //WSO
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
				if (($CmbCCosto=="-1")||($CmbCCosto==""))
				{
					$CodCCosto=" and ";
				}
				else
				{
					$CodCCosto="and t1.cod_ccosto ='".$CmbCCosto."' and ";				
				}
				$AnoCon=substr($FechaI,0,4);
				$CentroCosto='(';
				$Consulta="SELECT distinct t1.cod_ccosto,t3.descripcion,count(t1.nro_solicitud) as total ";
				if($AnoCon<2009 && $AnoCon>0)
					$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoCon." t1 ";
				else
					$Consulta.=" from cal_web.solicitud_analisis t1 ";					
				$Consulta.=" inner join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto=t3.centro_costo ";
				$Consulta.=" where not isnull(t1.cod_ccosto) ".$CodCCosto." t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t1.cod_ccosto LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta=mysqli_query($link, $Consulta);
				$Encontro=false;
				//echo $Consulta."<br>";
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$Encontro=true;
					$CentroCosto=$CentroCosto." t1.cod_ccosto='".$Fila["cod_ccosto"]."' or ";	
				}
				if ($Encontro==true)
				{
					$CentroCosto=substr($CentroCosto,0,strlen($CentroCosto)-3).")";	
					$Consulta="SELECT distinct t2.cod_leyes,t3.abreviatura ";
					if($AnoCon<2009 && $AnoCon>0)
						$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoCon." t1 inner join cal_histo.leyes_por_solicitud_a_".$AnoCon." t2 on ";
						else
						$Consulta.=" from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on ";
					$Consulta.=" t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
					$Consulta.=" inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
					$Consulta.=" where ".$CentroCosto." and (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') group by t1.cod_ccosto,t2.cod_leyes order by t1.cod_ccosto,t2.cod_leyes";
					$Respuesta=mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					$Arreglo=array();
					$ArregloTot=array();	
					$AnchoTabla=0;//WSO	
					$Cont=0; //WSO
					while($Fila1=mysqli_fetch_array($Respuesta))
					{
						$Arreglo[$Fila1["cod_leyes"]][0]=$Fila1["abreviatura"];
						$Arreglo[$Fila1["cod_leyes"]][1]=$Fila1["abreviatura"];
						$Arreglo[$Fila1["cod_leyes"]][2]="";
						$Arreglo[$Fila1["cod_leyes"]][3]="";
						$AnchoTabla=$AnchoTabla	+ 50;
						$Cont=$Cont+1;	
					}
					$AnchoTabla=$AnchoTabla	+ 600;	
					if (count($Arreglo))
					{				
						echo "<table width='$AnchoTabla' border='0' cellpadding='3' cellspacing='0' class='ColorTabla01'>";
						echo "<tr align='center'>";
						echo "<td width='270'>C.Costo</td>";
						echo "<td width='50' align='center'>Total S.A</td>";
						reset($Arreglo);
						ksort($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach ($Arreglo as $Clave => $Valor) 
						{  $Valor1 = isset($Valor[1])?$Valor[1]:"";
							echo "<td width='50' align='center'>";
							if ($Valor1!='')
							{
								echo $Valor1;
							}
							else
							{
								echo "&nbsp;";
							}	
							echo "</td>";
						}
						reset($ArregloTot);
						//while(list($Clave,$Valor)=each($ArregloTot))
						foreach ($ArregloTot as $Clave => $Valor) 
						{
							$ArregloTot[$Clave][0]=0;
						}
					
						echo "<td width='50'>TOTAL</td>";
						echo "</tr>";
						echo "</table>";
						echo "<table width='$AnchoTabla' border='1'>";
						$ConsultaLimit="SELECT count(distinct t1.cod_ccosto) as total_registros ";
						if($AnoCon<2009 && $AnoCon>0)
							$ConsultaLimit.=" from cal_histo.solicitud_analisis_a_".$AnoCon." t1 ";
						else
							$ConsultaLimit.=" from cal_web.solicitud_analisis t1 ";

						$ConsultaLimit.=" inner join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto=t3.centro_costo ";
						$ConsultaLimit.=" where not isnull(t1.cod_ccosto) ".$CodCCosto." t1.fecha_hora between '".$FechaI."' and '".$FechaT."'";
						//echo "ConsultaLimit: ".$ConsultaLimit;

						$Consulta="SELECT distinct t1.cod_ccosto,t3.descripcion,count(t1.nro_solicitud) as total ";
						if($AnoCon<2009 && $AnoCon>0)
							$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoCon." t1 ";
							else
							$Consulta.=" from cal_web.solicitud_analisis t1 ";
						$Consulta.=" inner join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto=t3.centro_costo ";
						$Consulta.=" where not isnull(t1.cod_ccosto) ".$CodCCosto." t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t1.cod_ccosto LIMIT ".$LimitIni.", ".$LimitFin;
						$Respuesta2=mysqli_query($link, $Consulta);
						$TotSA=0;
						//echo "CONSULTA:".$Consulta."<br>";
						while ($Fila=mysqli_fetch_array($Respuesta2))
						{
							$CantLeyesCCosto=0;
							echo "<tr>";
							echo "<td width='250' align='left'>".$Fila["cod_ccosto"]."-".$Fila["descripcion"]."</td>";
							echo "<td width='50'align='right' class='detalle01'>".$Fila["total"]."</td>";
							$TotSA=$TotSA+$Fila["total"];
							$Consulta = "select t2.cod_leyes,count(t2.cod_leyes)as total ";
							if($AnoCon<2009 && $AnoCon>0)
								$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoCon." t1 inner join cal_histo.leyes_por_solicitud_a_".$AnoCon." t2 on ";
								else
								$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on ";
							$Consulta.= " t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
							//$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
							$Consulta.= " where t1.cod_ccosto='".$Fila["cod_ccosto"]."' ";
							$Consulta.= " and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' ";
							$Consulta.= " group by t2.cod_leyes";
							$Respuesta3=mysqli_query($link, $Consulta);							
							//echo $Consulta."<br>";
							reset($Arreglo);
							//while(list($Clave,$Valor)=each($Arreglo))
							foreach ($Arreglo as $Clave => $Valor) 
							{
								$Arreglo[$Clave][1]="&nbsp;";
								$Arreglo[$Clave][3]="&nbsp;";				
							}
							$TotGeneral=0;
							while($FilaLeyes=mysqli_fetch_array($Respuesta3))
							{   $total = isset($FilaLeyes["total"])?$FilaLeyes["total"]:0;
								$ArregloTot0 =isset($ArregloTot[$FilaLeyes["cod_leyes"]][0])?$ArregloTot[$FilaLeyes["cod_leyes"]][0]:0;
								$Arreglo[$FilaLeyes["cod_leyes"]][2]=$total;
								$Arreglo[$FilaLeyes["cod_leyes"]][3]=$total;
								$ArregloTot[$FilaLeyes["cod_leyes"]][0]=$ArregloTot0 + $total;
								$CantLeyesCCosto=$CantLeyesCCosto + $total;
								$TotGeneral= $TotGeneral + $total;
							}	
							reset($Arreglo);
							ksort($Arreglo);
							//while(list($Clave,$Valor)=each($Arreglo))
							foreach ($Arreglo as $Clave => $Valor) 
							{
								echo "<td width='50' align='center'>";
								echo $Valor[3];
								echo "</td>";
							}
							echo "<td width='50' align='right' class='detalle01'>$CantLeyesCCosto</td>";
							echo "</tr>";
						}
						echo "<tr class='detalle01'>";
						echo "<td width='250'>TOTAL</td>";
						echo "<td width='50' align='right'>$TotSA</td>";
						echo "<td width='50'>&nbsp;</td>";
						reset($ArregloTot);
						ksort($ArregloTot);
						//while(list($Clave,$Valor)=each($ArregloTot))
						foreach ($ArregloTot as $Clave => $Valor) 
						{
							echo "<td width='50' align='center'>";
							echo $Valor[0];
							echo "</td>";
						}
						echo "<td width='50' align='right'>".$TotGeneral."</td>";
						echo "</tr>";
						echo "</table>";
					}
				}		
			}	
		?>
		<br>
		<table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
			<?php	
				if (($Buscar=='S')&&($Encontro==true))
				{
					$Respuesta = mysqli_query($link, $ConsultaLimit);
					$Row = mysqli_fetch_array($Respuesta);
					$Coincidencias = $Row["total_registros"];
					$NumPaginas = ($Coincidencias / $LimitFin);
					$LimitFinAnt = $LimitIni;
					$StrPaginas = "";
					for ($i = 0; $i <= $NumPaginas; $i++)
					{
						$LimitIni = ($i * $LimitFin);
						if ($LimitIni == $LimitFinAnt)
						{
							$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
						}
						else
						{
							$LimiteInicial=$i * $LimitFin;
							$Param="$LimiteInicial,'$CmbCCosto','$CmbAno','$CmbMes','$CmbDias'";
							$Param=str_replace(" ","%20",$Param);
							$StrPaginas.=  "<a href=JavaScript:Recarga($Param);>";
							$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
						}
					}
					echo substr($StrPaginas,0,-15);
				}	
			?>
          </tr>
        </table><BR>
        <table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
   			  <input name="BtnConsulta" type="button" value="Consultar" style="width:90" onClick="Proceso('R');">&nbsp;
              <input name="BtnExcel" type="button" value="Excel" style="width:90" onClick="Proceso('E','<?php echo $LimitIni;?>','<?php echo $LimitFin;?>');">&nbsp;
              <input name="BtnImprimir" type="button" value="Imprimir" style="width:90" onClick="Imprimir();">&nbsp;
              <input name="BtnSalir" type="button" value="Salir" style="width:90" onClick="Salir();"></td>
          </tr>
        </table>
        <br></td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
