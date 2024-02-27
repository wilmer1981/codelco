<?php include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Lista de Clientes</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function CargaDatos(RB)
{
	var Vector=RB.value.split('~');//Vector[0]=cod_sub_cliente_vta,Vector[1]=cod_cliente,Vector[2]=ciudad,Vector[3]=direcccion,Vector[4]=rut_cliente
	var f = document.frmConsulta;
	var Encontro=false;
	var dir ="";
	if ((parseInt(f.ClienteSantiagoAux.value))!=(parseInt(Number(Vector[1]))))
	{
		var mensaje = confirm("El Cliente Seleccinado No corresponde al Cliente del Envio");
	}
	else
	{
		Encontro=true;
	}
	if ((mensaje==true)||(Encontro==true))
	{
		
		dir=Vector[3].replace("�"," "); 
		//alert(dir);
		f.action="sec_autorizacion_despacho01.php?Envio="+f.EnvioAux.value+"&FechaEnvio="+f.FechaEnvioAux.value+"&SubCliente="+Vector[0]+"&Dir="+dir+"&Ciu="+Vector[2]+"&RutCliente="+Vector[4]+"&Proceso=ModificarSubCliente";
		f.submit();
	}
	else
	{
		return;
	}
	
}
function Salir()
{
	window.close();
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<input name="EnvioAux" type="hidden" value="<?php echo $Envio ?>">
 <input name="IEAux" type="hidden" value="<?php echo $Valoresie ?>">
 <input name="FechaEnvioAux" type="hidden" value="<?php echo $FechaEnvio ?>">
  <input name="ClienteSantiagoAux" type="hidden" value="<?php echo $ClienteSantiago ?>">
  <br>
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>
      <td width="343"><div align="center"> &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Salir();" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="700" border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>
    <?php  
	$Consulta="select * from sec_web.sub_cliente_vta t1 ";
	$Consulta.=" inner join sec_web.nave t2 on ";
	$Consulta.="	CEILING(t1.cod_cliente)=t2.cod_nave ";
	echo "<tr>\n";
	$Respuesta = mysqli_query($link, $Consulta);
	$cont=1;	
	echo "<input type='hidden' name='IdCliente'><input type='hidden' name='Ciudad'><input type='hidden' name='Direccion'><input type='hidden' name='Rut'>";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		if($cont==6) 
		{
			echo '</tr>';
			echo '<tr>';
			$cont=1;
		}
		echo "<td width='140'><input type='radio' name='IdCliente' value='".$Row["cod_sub_cliente"]."~".$Row["cod_cliente"]."~".$Row["ciudad"]."~".$Row["direccion"]."~".str_replace("�"," ",$Row["rut_cliente"])."~".$Row["comuna"]."' onClick='CargaDatos(this);' ><input type='hidden' name='Cliente' value='".$R["cod_cliente"]e]."'>\n";
		echo "$Row["nombre_nave"]&nbsp;".str_replace("�"," ",$Row["direccion"])."&nbsp;$Row["comuna"]</td>";
		$cont =$cont+ 1;
	}
?>
  </table>
</form>
</body>
</html>
