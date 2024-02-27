<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Lista de Clientes</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt,NumEnvio)//
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
		break;
		case "C":
			var StrCliente="";
			var StrDireccion="";
			var StrCiudad="";
			var StrRut="";
			for (i=1;i<f.IdCliente.length;i++)
			{
				if (f.IdCliente[i].checked == true)
				{
					StrCliente=f.IdCliente[i].value;
					StrDireccion=f.Direccion[i].value;
					StrCiudad=f.Ciudad[i].value;
					StrRut=f.Rut[i].value;
				}
			}
			
			window.opener.document.FrmProceso.action="sec_autorizacion_despacho.php?Envio="+NumEnvio+"&Valoresie="+f.IEAux.value+"&SubCliente="+StrCliente+"&Direccion="+StrDireccion+"&Ciudad="+StrCiudad+"&RutCliente="+StrRut+"&Mostrar=S";
			window.opener.document.FrmProceso.submit();
			window.close();
			break;
	}
}
function AgregarCliente()//N� Envio
{
	var Frm=document.FrmProceso;
	window.open("sec_ing_subcliente.php",""," fullscreen=no,width=750,height=400,scrollbars=yes,resizable = yes");
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
 <input name="IEAux" type="hidden" value="<?php echo $Valoresie ?>">
  <br>
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>
      <td width="343"><div align="center"> 
	    <!-- <input name="BtnNuevo" type="button" id="BtnNuevo" style="width:60px;" onClick="AgregarCliente('');"  value="Nuevo">-->
          &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
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
		//echo "<input type='radio'  name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
		echo "<td width='120'><input type='radio' name='IdCliente' value='".$Row[cod_sub_cliente]."' onClick=\"Proceso('C','$Envio');\">\n";
		echo "<input type='hidden' name='Ciudad' value='".$Row["ciudad"]."'>\n";
		$Ciudad=$Row["ciudad"];
		echo "<input type='hidden' name='Direccion' value='".$Row[direccion]."'>\n";
		$Direccion=$Row[direccion];
		echo "<input type='hidden' name='Rut' value='".$Row[rut_cliente]."'>\n";
		$Rut=$Row[rut_cliente];
		echo "$Row[nombre_nave]&nbsp;$Row[direccion]</td>";
		$cont =$cont+ 1;
	}
?>
  </table>
</form>
</body>
</html>
