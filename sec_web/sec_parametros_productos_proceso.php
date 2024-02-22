<?php 	
	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");
	switch($Proceso)
	{
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$ProductoCorr=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($ProductoCorr);$j++)
					{
						if (substr($ProductoCorr,$j,2)=="~~")
						{
							$Producto=substr($ProductoCorr,0,$j);
							$Corr=substr($ProductoCorr,$j+2);
							$Consulta ="select * from sec_web.parametros_productos where cod_subproducto='".$Producto."'";
							$Resultado =mysqli_query($link, $Consulta);
							$Fila=mysqli_fetch_array($Resultado);
							$CmbSubProducto=$Fila["cod_subproducto"];
							$Procedencia=$Fila["procedencia"];
							$PesoPromedio=$Fila["peso_promedio"];
							$PesoValido=$Fila["peso_valido"];
							$DescripcionIngles=$Fila["descripcion_ingles"];
						}	
					}
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">
/*document.onkeydown = TeclaPulsada; 

function TeclaPulsada (tecla) 
{ 
var teclaCodigo = event.keyCode; 
var teclaReal = String.fromCharCode(teclaCodigo); 
alert("Cdigo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbSubProducto.value == "-1")
	{
		alert("Debe Ingresar Producto")
		Frm.CmbSubProducto.focus();
		return;
	}
	if (Frm.TxtProcedencia.value == "")
	{
		alert("Debe Ingresar Procedencia")
		Frm.TxtProcedencia.focus();
		return;
	}
	if (Frm.TxtPesoPromedio.value == "")
	{
		alert("Debe Ingresar Peso Promedio")
		Frm.TxtPesoPromedio.focus();
		return;
	}
	if (Number(Frm.TxtPesoPromedio.value.replace(",",".")))
	{
		Frm.TxtPesoPromedio.value=Frm.TxtPesoPromedio.value.replace(",",".");
	}
	else
	{
		alert("Numero Ingresado Invalido");
		Frm.TxtPesoPromedio.focus();
		return;
	}
	Frm.action="sec_parametros_productos_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&CmbSubProducto="+Frm.CmbSubProducto.value;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body  background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="500" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="500" border="0" >
          <tr> 
            <td width="128">&nbsp;</td>
            <td width="362">&nbsp;</td>
          </tr>
          <tr> 
            <td>Tipo Producto</td>
            <td> 
              <?php
					if ($Proceso=="M")
					{
						echo "<select name='CmbSubProducto' disabled style='width:280'>";
					}
					else
					{
						echo "<select name='CmbSubProducto' style='width:280'>";					
					}
                	echo "<option value='-1' selected>Seleccionar</option>";
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '18'"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
		    		echo"</select>";
				?>
            </td>
          </tr>
          <tr> 
            <td>Procedencia</td>
            <td><input type="text" name="TxtProcedencia" maxlength="40" style="width:280" value="<?php echo $Procedencia;?>"></td>
          </tr>
          <tr> 
            <td>Peso Promedio</td>
            <td><input type="text" name="TxtPesoPromedio" maxlength="10" style="width:80" value="<?php echo $PesoPromedio;?>" ></td>
          </tr>
          <tr> 
            <td>Peso Valido</td>
            <td> 
              <?php
				  if (isset($PesoValido))
				  {
					  if ($PesoValido=="0")
					  {
						  echo "<input type='radio' name='OptPesoValido' value='0' checked>Ventana"; 
						  echo "<input type='radio' name='OptPesoValido' value='1'>Origen";
					  }
					  else
					  {
						  echo "<input type='radio' name='OptPesoValido' value='0'>Ventana"; 
						  echo "<input type='radio' name='OptPesoValido' value='1' checked>Origen";
					  }
				  }
				  else
				  {
					  echo "<input type='radio' name='OptPesoValido' value='0' checked>Ventana"; 
					  echo "<input type='radio' name='OptPesoValido' value='1'>Origen";
				  }
			  ?>
            </td>
          </tr>
          <tr> 
            <td>Descripcion Ingles</td>
            <td><input type="text" name="TxtDescripcionIngles" maxlength="40" style="width:280" value="<?php echo $DescripcionIngles;?>"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="500" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
