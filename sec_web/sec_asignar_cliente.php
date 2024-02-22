<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Lista de Clientes</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt,C,A,N)//Opcion y la ornada
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
		break;
		case "E":
			var StrCliente="";
			for (i=1;i<f.IdCliente.length;i++)
			{
				if (f.IdCliente[i].checked == true)
				{
					StrCliente=f.IdCliente[i].value;
				}
			}
			f.action="sec_conf_inicial_lotes_proceso01.php?Proceso=AsignarCliente&Codigo="+C+"&Ano="+A+"&Numero="+N+"&Cliente="+StrCliente;
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
	$Consulta="select cod_cliente,sigla_cliente from sec_web.cliente_venta";
	echo "<tr>\n";
	$Respuesta = mysqli_query($link, $Consulta);
	$cont=1;	
	echo "<input type='hidden' name='IdCliente'> ";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		if($cont==6) 
		{
			echo '</tr>';
			echo '<tr>';
			$cont=1;
		}
		//echo "<input type='radio'  name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
		echo "<td><input type='radio' name='IdCliente' value='".$Row["cod_cliente"]."' onClick=\"Proceso('E','$Codigo','$Ano','$Numero');\">\n";
		echo "$Row["sigla_cliente"]</td>";
		$cont =$cont+ 1;
	}
?>
  </table>
</form>
</body>
</html>
