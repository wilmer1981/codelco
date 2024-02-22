<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");

	$Lote = isset($_REQUEST["Lote"])?$_REQUEST["Lote"]:"";
	$Idioma = isset($_REQUEST["Idioma"])?$_REQUEST["Idioma"]:"";
	$MesCon = isset($_REQUEST["MesCon"])?$_REQUEST["MesCon"]:date('m');
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');

?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":
			if (f.Lote.value == "")
			{
				alert("Debe ingresar Numero de Lote");
				f.Lote.focus;
				return;
			}
			var URL = "sec_con_certificado.php?Mes=" + f.Mes.value + "&Lote=" + f.Lote.value + "&Idioma=" + f.Idioma.value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
			break;
		case "P":
			if (f.Lote.value == "")
			{
				alert("Debe ingresar Numero de Lote");
				f.Lote.focus;
				return;
			}
			var URL = "sec_con_certificado.php?Proceso=P&Mes=" + f.Mes.value + "&Lote=" + f.Lote.value + "&Idioma=" + f.Idioma.value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
			break;
		case "I":
			if (f.Lote.value == "")
			{
				alert("Debe ingresar Numero de Lote");
				f.Lote.focus;
				return;
			}
			var URL = "sec_con_certificado04.php?Mes=" + f.Mes.value + "&Lote=" + f.Lote.value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
			break;
		case "V":			
			var URL = "sec_con_certificado05.php";
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
			break;	
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
	}
}
function Detalle(num,idioma)
{
	var f = document.frmPrincipal;	
	var URL = "sec_con_certificado_creado.php?NumCertificado=" + num + "&Idioma=" + idioma;
	window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
}
function Recarga()
{
	var f = document.frmPrincipal;	
	f.action = "sec_con_certificado_comun.php";
	f.submit();
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
        
  <table width="770" border="0" class="TablaInterior">
    <tr> 
      <td colspan="2"><strong>GENERAR VISTA PREVIA DE CERTIFICADOS</strong></td>
      <td width="424" rowspan="3"><input name="BtnVistaPrevia" type="button" id="BtnVistaPrevia2" style="width:80px" onClick="Proceso('P');" value="Vista Previa"> 
        <input name="BtnInformacion" type="button" id="BtnInformacion2" style="width:80px" onClick="Proceso('I');" value="Informacion"> 
        <input type="button" name="BtnSalir" value="Salir" style="width:80px" onClick="Proceso('S');"> 
      </td>
    </tr>
    <tr> 
      <td width="110">Lote</td>
      <td width="219"><SELECT name="Mes">
          <?php
				$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3004' order by nombre_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Mes == $Fila["nombre_subclase"])
						echo "<option SELECTed value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
					else
						echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
				}
			?>
        </SELECT> <input type="text" name="Lote" value="<?php echo $Lote?>"> </td>
    </tr>
    <tr> 
      <td>Idioma</td>
      <td><SELECT name="Idioma" style="width:100px">
          <?php
				if (($Idioma == "E") || (!isset($Idioma)))
				{
                	echo "<option value='E' SELECTed>Espa&ntilde;ol</option>\n";
	                echo "<option value='I'>Ingles</option>\n";
				}
				else
				{
					echo "<option value='E'>Espa&ntilde;ol</option>\n";
	                echo "<option value='I' SELECTed>Ingles</option>\n";
				}
			?>
        </SELECT></td>
    </tr>
  </table>
        <br>
        
  <table width="770" border="0" class="TablaInterior">
    <tr> 
      <td colspan="2"><strong>CERTIFICADOS CREADOS</strong></td>
    </tr>
    <tr> 
      <td width="11%">Mes/A&ntilde;o:&nbsp;</td>
      <td width="89%"><SELECT name="MesCon" style="width:100px">
          <?php
				$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i=1;$i<=12;$i++)
				{
					if (isset($MesCon))
					{
						if ($i == $MesCon)
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
        </SELECT> <input name="BtnOK" type="button" id="BtnOK" value="Consultar" onClick="Recarga();">
        <input name="BtnImprimir" type="button" value="Imprimir" onClick="window.print();" style="width:70px"> 
      </td>
    </tr>
  </table>
        <br> 
  <table width="750" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr class="ColorTabla01"> 
            <td width="30">ESP</td>
            <td width="30">ING</td>
            <td width="30">CERTIF.</td>
			<td width="30">VERSION.</td>
            <td width="47">INST.</td>
            <td width="66">LOTE</td>
            <td width="82">FECHA</td>
            <td width="97">EMISOR</td>
            <?php
	$Consulta = "SELECT distinct t1.cod_leyes ";
	$Consulta.= " from sec_web.certificacion_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
	$Consulta.= " where t1.fecha between '".$Ano."-".$MesCon."-01 00:00:00' and '".$Ano."-".$MesCon."-31 23:59:59'";
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
	$Consulta.= " where fecha between '".$Ano."-".$MesCon."-01 00:00:00' and '".$Ano."-".$MesCon."-31 23:59:59'";
	$Consulta.= " group by corr_enm order by num_certificado, version";
	
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
		echo "<td align='right'>".$Fila["corr_enm"]."</td> \n";
		$Consulta = "SELECT * from sec_web.lote_catodo where corr_enm = '".$Fila["corr_enm"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<td align='right'>".strtoupper($Fila2["cod_bulto"])."-".str_pad($Fila2["num_bulto"], 6, "0", STR_PAD_LEFT)."</td> \n";
		}
		else
		{
			echo "<td align='right'>NO ENCONTRADO</td> \n";
		}
		echo "<td align='center'>".substr($Fila["fecha"],8,2).".".substr($Fila["fecha"],5,2).".".substr($Fila["fecha"],0,4)."</td> \n";
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
				echo "<td bgcolor='WHITE'>".$Fila2["signo"]."".number_format($Fila2["valor"],1,",",".")."</td>\n";
			else
				echo "<td>".$Fila2["signo"]."".number_format($Fila2["valor"],1,",",".")."</td>\n";
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
