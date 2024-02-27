<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_sec_web.php");
	$Regiones =array("I Regi�n","II Regi�n","III Regi�n","IV Regi�n","V Regi�n","VI Regi�n","VII Regi�n","VIII Regi�n","IX Regi�n","X Regi�n","XI Regi�n","XII Regi�n","Regi�n Metrop.");	
	
	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$BuscarRut = isset($_REQUEST["BuscarRut"])?$_REQUEST["BuscarRut"]:"";
	$TxtRut    = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv     = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";
	$Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$TxtNombre   = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtNombre2  = isset($_REQUEST["TxtNombre2"])?$_REQUEST["TxtNombre2"]:"";
	$TxtDireccion  = isset($_REQUEST["TxtDireccion"])?$_REQUEST["TxtDireccion"]:"";
	$TxtCiudad     = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtCiudad"]:"";
	$TxtComuna     = isset($_REQUEST["TxtComuna"])?$_REQUEST["TxtComuna"]:"";
	$TxtRepresentante  = isset($_REQUEST["TxtRepresentante"])?$_REQUEST["TxtRepresentante"]:"";
	$cmbregion        = isset($_REQUEST["cmbregion"])?$_REQUEST["cmbregion"]:"";
	$TxtTelefono      = isset($_REQUEST["TxtTelefono"])?$_REQUEST["TxtTelefono"]:"";
	$TxtTelefono2     = isset($_REQUEST["TxtTelefono2"])?$_REQUEST["TxtTelefono2"]:"";



	switch($Proceso)
	{
		case "N":
			$Consulta = "SELECT ceiling(ifnull(max(substring(cod_cliente,3,3)),0))+1 as mayor  from sec_web.cliente_venta where substring(cod_cliente,1,2)='VD'";
			$Resultado = mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			$Codigo="VD".str_pad($Fila["mayor"],3,'0',STR_PAD_LEFT);
			if ($BuscarRut=='S')
			{
				$RutCliente=$TxtRut."-".$TxtDv;
				$Consulta="SELECT * from sec_web.cliente_venta where rut='".$RutCliente."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Mensaje='Rut Ingresado ya Existe';
				}
			}
			$Tipo='V';
			break;
		case "M":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$CodCliente=$Datos[0];
				$Codigo=$Datos[0];
			}
			$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente='".$CodCliente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$RutDV=explode('-',$Fila["rut"]);
			$TxtRut=$RutDV[0];
			$TxtDv=$RutDV[1];
			$TxtNombre=$Fila["nombre_cliente"];
			$TxtNombre2=$Fila["sigla_cliente"];
			$TxtDireccion=$Fila["direccion2"];
			$TxtCiudad=$Fila["ciudad"];
			$TxtComuna=$Fila["comuna"];
			$cmbregion=$Fila["region"];
			$TxtRepresentante=$Fila["representante"];
			$TxtTelefono=$Fila["fono1"];
			$TxtTelefono2=$Fila["fono2"];
			$Tipo=$Fila["tipo"];
			break;	
	}	

?>
<html>
<head>
<script language="Javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	//alert(teclaCodigo);
	//return;
	if ((teclaCodigo != 37)&&(teclaCodigo != 39))
	{
		if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 

function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
    if (RutValido(Frm.TxtRut.value,Frm.TxtDv.value)==false)
	{
		alert('Rut Ingresado no es Valido');
		Frm.TxtRut.focus;
		return;
	}
	if (Frm.TxtRut.value == "")
	{
		alert("Debe Ingresar Rut del Cliente")
		Frm.TxtRut.focus();
		return;
	}
	if (Frm.TxtDv.value == "")
	{
		alert("Debe Ingresar Digito del Cliente")
		Frm.TxtDv.focus();
		return;
	}	
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre del Cliente")
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.TxtDireccion.value == "")
	{
		alert("Debe Ingresar Direccion del Cliente")
		Frm.TxtDireccion.focus();
		return;
	}
	if (Frm.cmbregion.value == "-1")
	{
		alert("Debe Seleccionar Regi�n")
		Frm.cmbregion.focus();
		return;
	}
	Frm.action="sec_ingreso_clientes_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value;
	Frm.submit();
	
}
function ValidarRut(Proceso)
{
	var Frm=document.FrmProceso;
	
	//alert(RutValido(Frm.TxtRut.value,Frm.TxtDv.value));
    if (RutValido(Frm.TxtRut.value,Frm.TxtDv.value)==false)
	{
		alert('Rut Ingresado no es Valido');
		Frm.TxtRut.focus;
		return;
	}

	Frm.action="sec_ingreso_clientes_proceso.php?Proceso="+Proceso+"&BuscarRut=S";
	Frm.submit();
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.TxtRut.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtRut.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td></td>
            <td> 
              <?php
				echo "<input type='hidden' name='TxtCodigo' style='width:80' value='$Codigo'>";
			?>
            </td>
          </tr>
          <tr> 
            <td>Rut</td>
            <td> 
              <?php
				 echo "<input type='text' name='TxtRut' style='width:80' maxlength='10' onKeyDown='TeclaPulsada()' value='$TxtRut'>&nbsp;-&nbsp;<input type='text' name ='TxtDv'style='width:20' maxlength='1' value='$TxtDv'>&nbsp;&nbsp;";
				 echo "<input type='button' name='BtnOK' value='Ok' style='width:30' onclick=ValidarRut('$Proceso')>";			  	
			  ?>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre2" style="width:300" maxlength="40" value="<?php echo $TxtNombre2; ?>"> 
            </td>
          </tr>
          <tr>
            <td>Nombre2(Sigla)</td>
            <td><input type="text" name="TxtNombre" style="width:300" maxlength="40" value="<?php echo $TxtNombre;?>"></td>
          </tr>
          <tr> 
            <td>Direccion</td>
            <td><input type="text" name="TxtDireccion" style="width:300" maxlength="50" value="<?php echo $TxtDireccion;?>"></td>
          </tr>
          <tr> 
            <td>Ciudad</td>
            <td><input type="text" name="TxtCiudad" style="width:200" maxlength="40" value="<?php echo $TxtCiudad;?>"></td>
          </tr>
          <tr> 
            <td>Comuna</td>
            <td><input type="text" name="TxtComuna" style="width:200" maxlength="40" value="<?php echo $TxtComuna;?>"></td>
          </tr>
          <tr> 
            <td>Region</td>
            <td> <SELECT name="cmbregion" style="width:120">
                <?php
				echo"<option value='-1'>Seleccionar</option>";
				for($i=1;$i<14;$i++)
				{
					if ($i==$cmbregion)
					{
						echo"<option value='$i' SELECTed>".$Regiones[$i-1]."</option>";	
					}
					else
					{
						echo"<option value='$i'>".$Regiones[$i-1]."</option>";
					}
				}
			?>
              </SELECT> </td>
          </tr>
          <tr> 
            <td>Representante</td>
            <td><input type="text" name="TxtRepresentante" style="width:300" maxlength="50" value="<?php echo $TxtRepresentante;?>"></td>
          </tr>
          <tr> 
            <td>Telefono1</td>
            <td><input type="text" name="TxtTelefono" maxlength="10" value="<?php echo $TxtTelefono;?>"></td>
          </tr>
          <tr> 
            <td>Telefono2</td>
            <td><input type="text" name="TxtTelefono2" maxlength="10" value="<?php echo $TxtTelefono2;?>">
              &nbsp;&nbsp;&nbsp; Cliente Venta Directa&nbsp;&nbsp; 
              <?php 
			  	if ($Tipo=='V')
				{
					echo "<input type='checkbox' name='CheckVD' checked>";
				}
				else
				{
					echo "<input type='checkbox' name='CheckVD'>";
				}	
			  ?>
            </td>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
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
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
?>