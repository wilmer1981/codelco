<?php 
	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni =  0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin =  100;
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

	$CodigoDeSistema = 1;
	$CodigoDePantalla = 54;
	include("../principal/conectar_principal.php");
	$Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase=1006 and cod_subclase=2";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$DiasConsulta=$Fila["valor_subclase1"];
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opcion)
{
	var Frm=document.FrmConsultaRecPendientes;

	var TotalDiasT=0;
	var CantDiasI=0;
	var CantDiasT=0;
	var TotalDiasI=0;
	var DifDias=0;
	
	/*CantDiasI=365*parseInt(Frm.CmbAno.value);
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
	}*/
	switch (Opcion)
	{
		case "R"://RECARGA
			Frm.action= "cal_con_recep_pendientes.php?Buscar=S";
			Frm.submit();
			break;
		case "E"://EXCEL
			Frm.action= "cal_xls_recep_pendientes.php?Buscar=S&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT+"&CmbDiasT="+Frm.CmbDiasT;
			Frm.submit();
			break;
	}			
}
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Imprimir()
{
	window.print();
}
function Recarga(LimitIni,CmbAno,CmbMes,CmbDias)
{
	var frm=document.FrmConsultaRecPendientes;
	frm.action="cal_con_recep_pendientes.php?Buscar=S&LimitIni="+LimitIni+"&CmbAnoT="+CmbAno+"&CmbMesT="+CmbMes+"&CmbDiasT="+CmbDias;
	frm.submit(); 
}
function Salir()
{
	var Frm=document.FrmConsultaRecPendientes;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}

</script>
<title>Consulta General</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaRecPendientes" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="761" align="center" valign="top"> <br>
	  <table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center"> 
              <?php
					echo "<strong>Fecha Consulta</strong>&nbsp;";
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
				?>&nbsp;&nbsp;&nbsp;
				<input name="BtnConsulta" type="button" value="Consultar" style="width:90" onClick="Proceso('R');">
              <!--&nbsp; <input name="BtnExcel" type="button" value="Excel" style="width:90" onClick="Proceso('E');">-->
              <input name="BtnImprimir" type="button" value="Imprimir" style="width:90" onClick="Imprimir();">
              <input name="BtnSalir" type="button" value="Salir" style="width:90" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
		<?php
			if ($Buscar=='S')
			{
				if (($CmbAnoT=="") || ($CmbMesT=="")|| ($CmbDiasT==""))
				{
					$FechaI=date("Y-m-d")." 00:00:01";
					$FechaT=date("Y-m-d")." 23:59:59";
				}
				else
				{
					if (strlen($CmbMesT)==1)
					{
						$CmbMesT="0".$CmbMesT;
					}
					if (strlen($CmbDiasT)==1)
					{
						$CmbDiasT="0".$CmbDiasT;
					}
					//$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
					$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
				}
				echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
				echo "<tr class='ColorTabla01'>";
				echo "<td align='center' width='50'>Lote</td>";
				echo "<td align='center' width='30'>Rec.</td>";
				echo "<td align='center' width='80'>Fecha</td>";
				echo "<td align='center' width='200'>Leyes</td>";
				echo "<td align='center' width='200'>Proveedor</td>";
				echo "<td align='center' width='200'>Producto</td>";
				$FechaTope=date( "Y-m-d", mktime(0,0,0,substr($FechaT,5,2),substr($FechaT,8,2)-$DiasConsulta,substr($FechaT,0,4)));
				$FechaTope=$FechaTope." 23:59:59";
				$FechaInicio=date( "Y-m-d", mktime(0,0,0,substr($FechaT,5,2),substr($FechaT,8,2)-60,substr($FechaT,0,4)));
				$FechaInicio=$FechaInicio." 00:00:00";
				$Consulta = "select lote as lote_a,if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado,fecha as fecha_a,leyes as d_past_a, impurezas as d_impu_a";//d_prov_a,d_prod_a,d_past_a,d_impu_a ";
				$Consulta.= " from sipa_web.recepciones where fecha between '".$FechaInicio."' and '".$FechaTope."' and activo='S' order by lote,recargo_ordenado LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					echo "<td align='center'>$Fila[lote_a]</td>";
					echo "<td align='center'>$Fila[recargo_ordenado]</td>";
					echo "<td align='center'>$Fila[fecha_a]</td>";
					if ($Fila["d_past_a"] !="" && $Fila["d_impu_a"] !="")
					{
						echo "<td>".$Fila["d_past_a"]." ".$Fila["d_impu_a"]."</td>";
					}
					else
					{
						echo "<td>&nbsp;</td>";
					}
					echo "<td>$Fila[d_prov_a]</td>";
					echo "<td>$Fila[d_prod_a]</td>";
					echo "</tr>";
				}
				echo "</table>";
			}	
		?>
        <table width="755" border="0" cellpadding="3" cellspacing="0"><!-- class="TablaInterior">-->
          <tr>
            <td align="center">
			<?php
				if ($Buscar=='S')
				{
					$Consulta="select count(distinct lote,recargo) as total_registros from sipa_web.recepciones where fecha between '".$FechaInicio."' and '".$FechaTope."' and activo='S'"; 
					$Respuesta = mysqli_query($link, $Consulta);
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
							$Param="$LimiteInicial,'$CmbAnoT','$CmbMesT','$CmbDiasT'";
							$Param=str_replace(" ","%20",$Param);
							$StrPaginas.=  "<a href=JavaScript:Recarga($Param);>";
							$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
						}
					}
					echo substr($StrPaginas,0,-15);
				}	
			?>	
		   </td>
		  </tr>
        </table><br>
			
		<br>
        <br></td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
