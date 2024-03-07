<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla =4;
	include("../principal/conectar_pac_web.php");

	
	$EncontroCoincidencia = isset($_REQUEST["EncontroCoincidencia"])?$_REQUEST["EncontroCoincidencia"]:"";
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbTransp  = isset($_REQUEST["CmbTransp"])?$_REQUEST["CmbTransp"]:"";
	$Nombre     = isset($_REQUEST["Nombre"])?$_REQUEST["Nombre"]:"";
	$Direccion    = isset($_REQUEST["Direccion"])?$_REQUEST["Direccion"]:"";
	$Rut    = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
	$DV    = isset($_REQUEST["DV"])?$_REQUEST["DV"]:"";
	$Registro    = isset($_REQUEST["Registro"])?$_REQUEST["Registro"]:"";
	$RutTransp    = isset($_REQUEST["RutTransp"])?$_REQUEST["RutTransp"]:"";
	
	

	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$RutDv=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($RutDv);$j++)
					{
						if (substr($RutDv,$j,1)=="-")
						{
							$Rut=substr($RutDv,0,$j);
							$DV=substr($RutDv,$j+1);
							$RutChofer=$Rut."-".$DV;
						}
					}						

				}
			}
			$Consulta = "select t2.rut_transportista,t2.nombre as nombre_transp,t1.rut_chofer,t1.nombre,t1.direccion,t1.registro,t1.tipo from pac_web.choferes t1 ";
			$Consulta = $Consulta." inner join pac_web.transportista t2 on t1.rut_transportista=t2.rut_transportista where rut_chofer='".$RutChofer."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Transportista=$Fila["nombre_transp"];
			$RutTransp=$Fila["rut_transportista"];
			$Nombre=$Fila["nombre"];
			$Direccion=$Fila["direccion"];
			$Registro=$Fila["registro"];
			$Tipo=$Fila["tipo"];
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
alert("C�digo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	var Tipo='';
	
	if (Proceso=='N')
	{
		if (Frm.CmbTransp.value == "-1")
		{
			alert("Debe Seleccionar Transportista")
			Frm.CmbTransp.focus();
			return;
		}
		if (Frm.TxtRut.value == "")
		{
			alert("Debe Ingresar Rut Chofer")
			Frm.TxtRut.focus();
			return;
		}
		if (Frm.TxtDv.value == "")
		{
			alert("Debe Ingresar Digito")
			Frm.TxtDv.focus();
			return;
		}
		if (Frm.TxtNombre.value == "")
		{
			alert("Debe Ingresar Nombre Chofer")
			Frm.TxtNombre.focus();
			return;
		}
	}
	if (Frm.OptTipo[0].checked)
	{
		Tipo=Frm.OptTipo[0].value;
	}
	else
	{
		Tipo=Frm.OptTipo[1].value;
	}
	Frm.action="pac_ingreso_choferes_proceso01.php?Proceso="+Proceso+"&TxtRut="+Frm.TxtRut.value+"&TxtDv="+Frm.TxtDv.value+"&Valores="+Valores+"&Tipo="+Tipo;
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
function validarNumero(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) return true;
    patron = /[0-9]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.CmbTransp.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtNombre.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="101">Transp.</td>
            <td width="268"> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='hidden' name ='TxtRutTransp' value =".$RutTransp.">";
						echo $RutTransp."  ".strtoupper($Transportista);
					}
					else
					{
						echo "<select name='CmbTransp'>";
						echo "<option value ='-1' selected>Seleccionar</option> ";
						$Consulta="select rut_transportista,nombre from transportista order by nombre";
						$Respuesta=mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<option value ='".$Fila["rut_transportista"]."'>".$Fila["rut_transportista"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						}
						echo "</select></td>";
					}	
				?>
          </tr>
          <tr> 
            <td>Rut</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='text' name='TxtRut' style='width:70' onkeypress='return validarNumero(event)' maxlength='8' value='$Rut' disabled>- ";
						echo "<input type='text' name='TxtDv' style='width:25' maxlength='1' value='$DV' disabled>";
					}
					else
					{
						echo "<input type='text' name='TxtRut' style='width:70' onkeypress='return validarNumero(event)'  maxlength='8' value='$Rut'>- ";
						echo "<input type='text' name='TxtDv' style='width:25' maxlength='1' value='$DV'>";
					}	
				?>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre" style="width:250" maxlength="30" value="<?php echo $Nombre;?>"></td>
          </tr>
          <tr> 
            <td>Direccion</td>
            <td><input type="text" name="TxtDireccion" style="width:250" maxlength="30" value="<?php echo $Direccion;?>"></td>
          </tr>
          <tr> 
            <td>Reg.Nac.Conduct</td>
            <td><input type="text" name="TxtRegistro" style="width:100" maxlength="15" value="<?php echo $Registro;?>"></td>
          </tr>
          <tr>
            <td>Tipo</td>
            <td>
			<?php
				if ($Proceso=='N')
				{
					echo "<input type='radio' name='OptTipo' value='P' checked>Particular";
					echo "<input type='radio' name='OptTipo' value='E' >Enami";
				}
				else
				{
					switch ($Tipo)
					{
						case "P":
							echo "<input type='radio' name='OptTipo' value='P' checked>Particular";
							echo "<input type='radio' name='OptTipo' value='E'>Enami";
							break;
						case "E":
							echo "<input type='radio' name='OptTipo' value='P'>Particular";
							echo "<input type='radio' name='OptTipo' value='E' checked>Enami";
							break;
						default:	
							echo "<input type='radio' name='OptTipo' value='P' checked>Particular";
							echo "<input type='radio' name='OptTipo' value='E'>Enami";
							break;
					}
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
	if ($EncontroCoincidencia)
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Rut ya fue Ingresado');";
			echo "Frm.TxtRut.focus();";
			echo "</script>";
		}
	}
?>
