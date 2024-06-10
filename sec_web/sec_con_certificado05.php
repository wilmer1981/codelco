<?php include("../principal/conectar_principal.php");
	if(isset($_REQUEST["Lote"])) {
		$Lote = $_REQUEST["Lote"];
	}else{
		$Lote = "";
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}

	if(strlen($Mes)==1){$Mes = "0".$Mes;}

?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Detalle(num,idioma)
{
	var f = document.frmPrincipal;	
	var URL = "sec_con_certificado_creado.php?NumCertificado=" + num + "&Idioma=" + idioma;
	window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
}
function Recarga()
{
	var f = document.frmPopUp;	
	f.action = "sec_con_certificado05.php";
	f.submit();
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPopUp" action="" method="post">
<table width="100%" border="0" class="TablaInterior">
  <tr> 
    <td width="11%">Mes/A&ntilde;o:&nbsp;</td>
    <td width="89%"><SELECT name="Mes" style="width:100px">
        <?php
				$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option value='".$i."' SELECTed>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option value='".$i."' SELECTed>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
      </SELECT> <SELECT name="Ano" style="width:100px">
        <?php				
				for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option value='".$i."' SELECTed>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option value='".$i."' SELECTed>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
      </SELECT> 
      <input name="BtnOK" type="button" id="BtnOK" value="Consultar" onClick="Recarga();">
        <input name="BtnImprimir" type="button" value="Imprimir" onClick="window.print();" style="width:70px"> 
        <input name="BtnSalir" type="button" value="Salir" onClick="window.close();" style="width:70px"> 
      </td>
  </tr>
</table>
<br>
<br>
  <table width="750" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr class="ColorTabla01"> 
      <td width="46">ESP</td>
      <td width="57">ING</td>
      <td width="52">CERTIF.</td>
      <td width="52">VERSION</td>
      <td width="71">VIA TRANS.</td>
      <td width="63">INST.</td>
      <td width="75">LOTE</td>
      <td width="125">FECHA</td>
      <td width="134">EMISOR</td>
      <?php
	$Consulta = "SELECT distinct t1.cod_leyes ";
	$Consulta.= " from sec_web.certificacion_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
	$Consulta.= " where t1.fecha between '".$Ano."-".$Mes."-01 00:00:00' and '".$Ano."-".$Mes."-31 23:59:59'";
	$Consulta.= " order by t2.valor_subclase2 ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{	
		$Consulta = "SELECT * from proyecto_modernizacion.leyes where cod_leyes = '".$Fila["cod_leyes"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<td>".$Fila2["abreviatura"]."</td>\n";	
		}
	}
?>
    </tr>
    <?php  
	$Consulta = "SELECT distinct corr_enm, num_certificado, version, fecha, rut ";
	$Consulta.= " from sec_web.certificacion_catodos ";
	$Consulta.= " where fecha between '".$Ano."-".$Mes."-01 00:00:00' and '".$Ano."-".$Mes."-31 23:59:59'";
	$Consulta.= " order by num_certificado, version";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Consulta = "SELECT * from sec_web.lote_catodo where corr_enm = '".$Fila["corr_enm"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$CodBulto = $Fila2["cod_bulto"];
			$NumBulto = $Fila2["num_bulto"];
		}
		else
		{
			$CodBulto = "";
			$NumBulto = "";
		}
		echo "<tr> \n";
		//CONSULTA SI YA FUE CREADO Y ANULADO
		$Anulado =  "";
		$Consulta = "SELECT * from sec_web.solicitud_certificado ";
		$Consulta.= " where cod_bulto = '".$CodBulto."' and num_bulto = '".$NumBulto."'";
		$Respuesta2 = mysqli_query($link, $Consulta);		
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			if ($Fila2["estado_certificado"] == "A")
				$Anulado = "S";
		}
		//--------------------------------------------
		if ($Anulado == "S")
			echo "<td bgcolor = 'RED'>";
		else
			echo "<td>";
		echo "<a href=\"JavaScript:Detalle('".$Fila["num_certificado"]."','E')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'></a></td>\n";
		if ($Anulado == "S")
			echo "<td bgcolor = 'RED'>";
		else
			echo "<td>";
		echo "<a href=\"JavaScript:Detalle('".$Fila["num_certificado"]."','I')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'></a></td>\n";
		echo "<td align='right'>";		
		echo $Fila["num_certificado"]."</td> \n";
		echo "<td align='right'>".$Fila["version"]."</td> \n";		
		$Consulta = "SELECT * from sec_web.solicitud_certificado where cod_bulto = '".$CodBulto."' and num_bulto = '".$NumBulto."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			if ($Fila2["estado"] == "T")
				echo "<td align='right'>Terrestre</td> \n";
			else
				echo "<td align='right'>Exportacion</td> \n";
		}
		else
		{
			echo "<td align='right'>&nbsp;</td> \n";
		}
		echo "<td align='right'>".$Fila["corr_enm"]."</td> \n";		
		if ($CodBulto != "")
		{
			echo "<td align='right'>".strtoupper($CodBulto)."-".str_pad($NumBulto, 6, "0", STR_PAD_LEFT)."</td> \n";
		}
		else
		{
			echo "<td align='right'>NO ENCONTRADO</td> \n";
		}
		echo "<td align='center'>".substr($Fila["fecha"],8,2).".".substr($Fila["fecha"],5,2).".".substr($Fila["fecha"],0,4)." ".substr($Fila["fecha"],11)."</td> \n";
		//EMISOR
		$Consulta = "SELECT * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$Nombre = substr(strtoupper($Fila2["nombres"]),0,1).". ".ucwords(strtolower($Fila2["apellido_paterno"]));
			echo "<td align='left'>".$Nombre."</td> \n";
		}
		else
		{
			echo "<td align='left'>NO ENCONTRADO</td> \n";
		}
		$Consulta = "SELECT t1.valor, t1.signo, t1.modificado ";
		$Consulta.= " from sec_web.certificacion_catodos t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
		$Consulta.= " where t1.num_certificado = '".$Fila["num_certificado"]."'";
		$Consulta.= " and t1.version = '".$Fila["version"]."'";
		$Consulta.= " order by t2.valor_subclase2 ";
		//echo $Consulta;
		$Respuesta2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			if ($Fila2["modificado"] == "S")
			{
				echo "<td bgcolor='WHITE'>".$Fila2["signo"]."".number_format($Fila2["valor"],1,",",".")."</td>\n";
			}
			else
			{
				echo "<td>".$Fila2["signo"]."".number_format($Fila2["valor"],1,",",".")."</td>\n";
			}
		}
		echo "</tr> \n";
	}
?>
  </table>
<div align="center"><br>
  </div>
</form>
</body>
</html>
