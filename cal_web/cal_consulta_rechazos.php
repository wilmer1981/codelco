<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 50;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  0;
	}

	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni =  0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin =  10;
	}

	//$LimitIni=$Limite;

	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias =  date("d");
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes =  date("m");
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno =  date("Y");
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT =  date("d");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT =  date("m");
	}
	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT =  date("Y");
	}
	if(isset($_REQUEST["CmbSubProducto"])) {
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}
	

?>
<html>
<head>
<script language="JavaScript">
function Historial(Hornada,CodSubProducto)
{
	var Frm=document.FrmConsultaRechazos;
	var Valores="";
	if ((CodSubProducto==4)||(CodSubProducto==8))
	{
		window.open("cal_consulta_rechazos_detalle.php?Hornada="+Hornada+"&CodSubProducto="+CodSubProducto,"","top=5,left=40,width=660,height=667,scrollbars=no,resizable = yes");
	}
	else
	{
		window.open("cal_consulta_rechazos_detalle2.php?Hornada="+Hornada+"&CodSubProducto="+CodSubProducto,"","top=5,left=40,width=660,height=555,scrollbars=no,resizable = yes");	
	}	
}
function Proceso(Opcion,LimitIni,LimitFin)
{
	var Frm=document.FrmConsultaRechazos;

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
			Frm.action= "cal_consulta_rechazos.php?Buscar=S";
			Frm.submit();
			break;
		case "E"://EXCEL
			Frm.action= "cal_consulta_rechazos_excel.php?Buscar=S&LimitIni="+LimitIni+"&LimitFin="+LimitFin;
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
	var frm=document.FrmConsultaRechazos;
	frm.action="cal_consulta_analisis_ccosto.php?Buscar=S&Limite="+LimitIni+"&CmbCCosto="+CmbCCosto+"&CmbAno="+CmbAno+"&CmbMes="+CmbMes+"&CmbDias="+CmbDias;
	frm.submit(); 
}

function Salir()
{
	var Frm=document.FrmConsultaRechazos;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}

</script>
<title>Consulta Rechazos</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaRechazos" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="770" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="761" align="center" valign="middle"> <br>
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
            <td align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left">SubProducto
              <?php
				echo "<select name='CmbSubProducto' style='width:280'>";
				echo "<option value ='-1' selected>Todos</option>\n;";
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='17' order by descripcion";
				$Respuesta = mysqli_query ($link,$Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto==$Fila["cod_subproducto"])
					{
						echo "<option value = '".$Fila["cod_subproducto"]."' selected >".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}
					else
					{
						echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
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
			if ($Buscar=='S')
			{
				if (($CmbAno=="") || ($CmbMes=="")|| ($CmbDias==""))
				{
					$FechaI=date("Y-m-d")." 00:00:01";
					$FechaT=date("Y-m-d")." 23:59:59";
				}
				else
				{
					$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
					$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
				}	
				if (($CmbSubProducto=="-1")||($CmbSubProducto==""))
				{
					$CodSubProducto="";
				}
				else
				{
					$CodSubProducto="and t1.cod_subproducto =".$CmbSubProducto;				
				}
				echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
				echo "<tr class='ColorTabla01'>";
				echo "<td>Hornada</td>";
				echo "<td>Fecha</td>";
				echo "<td>SubProducto</td>";
				echo "<td>Unid.Rechazadas</td>";
				echo "<td>Unid.Recuperables</td>";
				$Consulta="select t1.cod_subproducto,t1.fecha_ini,t1.hornada,t2.descripcion,sum(t1.recuperables) as recup,sum(t1.rechazados) as rech from sea_web.rechazos t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
				$Consulta=$Consulta." where t1.cod_producto=17 and t1.cod_tipo=6 and cod_defecto=0 and ";
				$Consulta=$Consulta." fecha_ini between '".$FechaI."' and '".$FechaT."'".$CodSubProducto." group by t1.hornada,t1.cod_subproducto";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					echo "<td><a href=\"JavaScript:Historial('".$Fila["hornada"]."','".$Fila["cod_subproducto"]."')\">".$Fila["hornada"]."</a></td>";
					echo "<td>".$Fila["fecha_ini"]."</td>";
					echo "<td>".$Fila["descripcion"]."</td>";
					echo "<td align='right'>".$Fila["rech"]."</td>";
					echo "<td align='right'>".$Fila["recup"]."</td>";
					echo "</tr>";				
				}
				echo "</tr>";
				echo "</table>";
			}	
		?>
		<br>
		<table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
			<?php	
				if ($Buscar=='S')
				{
					/*$Respuesta = mysqli_query($link, $ConsultaLimit);
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
					echo substr($StrPaginas,0,-15);*/
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
        <br>
	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
