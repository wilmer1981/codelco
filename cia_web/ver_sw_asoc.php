<?php
//popup para mostrar los softwares asociados a cierto equipo

include("../principal/conectar_principal.php");
//se recuperan todos los softwares asociados al equipo
$query="select * from asoc_sw_equipo where cod_equipo='".$cod_equipo."';";
$result=mysql_db_query("cia_web",$query,$link);
$cant=mysql_num_rows($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color: #b26c4a;
	text-align:center;
	text-decoration:none;
}

a:link{
	color: #b26c4a;
}	

a:hover{
	color: #b26c4a;
	background-color: #FFFFFF;
}

a:visited{
	color: #b26c4a;
}

a:active{
	color: #b26c4a;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
var tmp=0;
function ver_detalle(codigo)
{
	var URL,opciones;
	URL="ver_sw.php?codigo=" + codigo + "&foo=1"; 
	opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=460';
	verificar_popup(tmp);
	tmp=window.open(URL,"",opciones);
	tmp.focus();
	tmp.moveTo(0,0);
}

function to_excel(cod_equipo)
{
	var URL,opciones;
	URL="ToExcel/ver_sw_asoc_excel.php?cod_equipo=" + cod_equipo;
	opciones="resizable=0,scrollbars=1,menubar=1,toolbar=1";
	verificar_popup(tmp);
	tmp=window.open(URL,"",opciones);
	tmp.focus();
	tmp.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	tmp.moveTo(0,0);
}

function eliminar(cant)
{
	var f=document.frmSWAsoc,i;
	
	if(cant==1)
	{
		if(!f.Cod_Sw.checked)
		{
			alert("Debe Marcar una de las casillas");
			return false;
		}
			
	}
	else
	{
		for(i=0;i< f.Cod_Sw.length;i++)
		{
			if(f.Cod_Sw[i].checked)
				break;
		}
		if(i==f.Cod_Sw.length)
		{
			alert("Debe Marcar una de las casillas");
			return false;
		}
	}
	
	if(confirm("¿Seguro que desea eliminar este Software?"))
	{
		f.action="actualizar_datos.php?op=14";
		f.submit();
	}
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(tmp)">
<form name="frmSWAsoc" method="post" action="">
<input type="hidden" name="cod_equipo" value="<?php echo $cod_equipo;?>">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="450" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="430" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>Softwares asociados</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		    <td align="center"> 
              <?php
		if(!mysql_num_rows($result))	//no tiene softwares asociados
		{
			echo '<strong>No hay softwares asociados</strong>';
		}
		else		//si hay sw asociados
		{
			echo '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
			<tr>
				<td width="20">&nbsp;</td>  
				<td align="center" width="20%" style="border:solid 1px #666666;" bgcolor="#CCCCCC"><strong>Codigo</strong></td>
				<td align="center" width="30%" style="border:solid 1px #666666;" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
				<td align="center" width="30%" style="border:solid 1px #666666;" bgcolor="#CCCCCC"><strong>Versi&oacute;n</strong></td>
				<td align="center" width="20%" style="border:solid 1px #666666;" bgcolor="#CCCCCC"><strong>Fecha Asoc.</strong></td>
			</tr>';
			while($resp=mysql_fetch_array($result))
			{
				echo '<tr>';
				echo '<td align="center" style="border:solid 1px #666666;">';
				echo '<input type="radio" name="Cod_Sw" value="'.$resp["cod_sw"].';'.$resp["cod_equipo"].';'.$resp["fecha"].'"></td>';
				echo '<td align="center" width="20%" style="border:solid 1px #666666;">';
				echo '<a href="javascript: ver_detalle(\''.$resp[cod_sw].'\')" class="LINK"><strong>'.$resp[cod_sw].'</strong></a>';
				echo '</td>';
				//se recupera la informacion del sw
				$query="select nombre,version_sw from software where codigo='".$resp["cod_sw"]."'";
				$result_tmp=mysql_db_query("cia_web",$query,$link);
				$r_tmp=mysql_fetch_array($result_tmp);
				mysql_free_result($result_tmp);
				echo '
				<td align="center" width="30%" style="border:solid 1px #666666;">&nbsp;'.$r_tmp["nombre"].'</td>
				<td align="center" width="30%" style="border:solid 1px #666666;">&nbsp;'.$r_tmp["version_sw"].'</td>';
				$fecha=explode("-",$resp["fecha"]);
				$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				echo '<td align="center" width="20%" style="border:solid 1px #666666;">&nbsp;'.$fecha.'</td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="5">&nbsp;</td></tr>';
			echo '<tr><td colspan="5" align="center">';
			echo '<input type="button" name="Eliminar" value="Eliminar" style="width: 80px;" onClick="eliminar('.$cant.')"></td></tr>';
			echo '</table> ';
		}
		?>
            </td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<?php
	if(mysql_num_rows($result))
		echo '<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel(\''.$cod_equipo.'\')">&nbsp;&nbsp;&nbsp;';
	?>
	<input type="button" name="Cerrar" style="width: 80px;" value="Cerrar" onClick="javascript: window.close();">
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</form>
</body>
</html>
