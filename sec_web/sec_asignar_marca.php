<?php 
include("../principal/conectar_pmn_web.php");
//Ano=2023&Codigo=A&Numero=2171

$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
$Numero  = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";

?>
<html>
<head>
<title>Lista de Clientes</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt,C,A,N,IE)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
		break;
		case "E":
			var StrMarca="";
			for (i=1;i<f.IdMarca.length;i++)
			{
				if (f.IdMarca[i].checked == true)
				{
					StrMarca=f.IdMarca[i].value;
				}
			}
		
			f.action="sec_conf_inicial_lotes_proceso01.php?Proceso=CambiarMarca&Codigo="+C+"&Ano="+A+"&Numero="+N+"&Marca="+StrMarca+"&IE="+IE;
			f.submit();
			break;
	}
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
  <br>
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">Lote # 
        <?php 
	  echo $Codigo;
	  echo "&nbsp;";
	  echo "-";
	  echo $Numero;
	  ?>
      </td>
      <td width="343"><div align="center"> &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="666" border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>
    <?php  
	$Consulta="SELECT cod_marca,descripcion from sec_web.marca_catodos";
	echo "<tr>\n";
	$Respuesta = mysqli_query($link, $Consulta);
	$cont=1;	
	echo "<input type='hidden' name='IdMarca'> ";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$cod_marca   = isset($Row["cod_marca"])?$Row["cod_marca"]:"";
		if($cont==6) 
		{
			echo '</tr>';
			echo '<tr>';
			$cont=1;
		}
		$Consulta="SELECT *  from sec_web.lote_catodo ";
		$Consulta.=" where cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and substring(fecha_creacion_lote,1,4)='".$Ano."' and cod_marca='".$cod_marca."'	";
		$Respuesta1=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta1))
		{
			$corr_enm   = isset($Fila["corr_enm"])?$Fila["corr_enm"]:"";
			echo "<td><input type='radio' name='IdMarca' value=".$cod_marca." onClick=\"Proceso('E','$Codigo','$Ano','$Numero','$corr_enm');\" checked>\n";
		}
		else
		{
			$corr_enm   = isset($Fila["corr_enm"])?$Fila["corr_enm"]:"";
			echo "<td><input type='radio' name='IdMarca' value=".$cod_marca." onClick=\"Proceso('E','$Codigo','$Ano','$Numero','$corr_enm');\">\n";
		}
		//echo "$Row["descripcion"]</td>";
       echo "$cod_marca</td>";
		$cont =$cont+ 1;
	}
?>
  </table>
</form>
</body>
</html>
