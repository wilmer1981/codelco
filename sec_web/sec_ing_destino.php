<?php
	include("../principal/conectar_principal.php");


	$Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$BuscarCliente   = isset($_REQUEST["BuscarCliente"])?$_REQUEST["BuscarCliente"]:"";
	$TipoBusqueda   = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";

	$CmbRutCliente   = isset($_REQUEST["CmbRutCliente"])?$_REQUEST["CmbRutCliente"]:"";
	$TxtRutDestino   = isset($_REQUEST["TxtRutDestino"])?$_REQUEST["TxtRutDestino"]:"";
	$TxtDvDestino    = isset($_REQUEST["TxtDvDestino"])?$_REQUEST["TxtDvDestino"]:"";

	$TxtCiudad     = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtCiudad"]:"";
	$TxtComuna     = isset($_REQUEST["TxtComuna"])?$_REQUEST["TxtComuna"]:"";
	$TxtDireccion  = isset($_REQUEST["TxtDireccion"])?$_REQUEST["TxtDireccion"]:"";
	$cmbregion     = isset($_REQUEST["cmbregion"])?$_REQUEST["cmbregion"]:"";
	$TxtRepresentante = isset($_REQUEST["TxtRepresentante"])?$_REQUEST["TxtRepresentante"]:"";
	$TxtFono    = isset($_REQUEST["TxtFono"])?$_REQUEST["TxtFono"]:"";
	$TxtCelular = isset($_REQUEST["TxtCelular"])?$_REQUEST["TxtCelular"]:"";
	$Mensaje    = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";


	$tope = strlen($Valores);
    $TxtCliente = substr($Valores,0,($tope - 2));

	$Consulta = "SELECT rut,nombre_cliente FROM sec_web.cliente_venta WHERE cod_cliente = '".$TxtCliente."'";
	$rs = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($rs);
	$TxtRut = $Fila["rut"];
	$NombreCliente=$Fila["nombre_cliente"];

	$Consulta = "SELECT ceiling(ifnull(max(Id),0))+1 as Id FROM sec_web.sub_cliente_vta";
	$rs = mysqli_query($link, $Consulta);	
	$Fila = mysqli_fetch_array($rs);
	$TxtId = $Fila["Id"];

	$Consulta = "SELECT ifnull(max(ceiling(cod_sub_cliente)),0)+1 as subcliente FROM sec_web.sub_cliente_vta WHERE cod_cliente = '".$TxtCliente."'";
	$rs2 = mysqli_query($link, $Consulta);
	$Fila2 = mysqli_fetch_array($rs2);
	$TxtSubCliente = $Fila2["subcliente"];
	$TxtSubCliente=str_pad($TxtSubCliente,3,"0",STR_PAD_LEFT);
	
	if ($BuscarCliente=='S')
	{
		if ($TipoBusqueda=='1')
		{
			$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente='".$CmbRutCliente."'";
		}
		else
		{
			$Rut=$TxtRutDestino."-".$TxtDvDestino;
			$Consulta="SELECT * from sec_web.cliente_venta where rut='".$Rut."'";
		}
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$CmbRutCliente=$Fila["cod_cliente"];
		$Rut=explode('-',$Fila["rut"]);
		$TxtRutDestino=$Rut[0];
		$TxtDvDestino=$Rut[1];
		$TxtCiudad=$Fila["ciudad"];
		$TxtComuna=$Fila["comuna"];
		//$cmbregion=$Fila[region];
		$TxtDireccion=$Fila["direccion"];
		$TxtRepresentante=$Fila["representante"];
		$TxtFono=$Fila["fono1"];
		$TxtCelular=$Fila["fono2"];
	}

?>
<html>
<head>
<title>Ingreso SubCliente</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="Javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Grabar()
{
	var f = FrmIngreso

    if (!RutValido(f.TxtRutDestino.value,f.TxtDvDestino.value))
	{
		alert('Rut Ingresado no es Valido');
		f.TxtRutDestino.focus;
		return;
	}
	if(f.TxtCiudad.value == '')
	{
	    alert("Debe Ingresar la Ciudad");
        f.TxtCiudad.focus();  
		return
    }   

    if(f.TxtComuna.value == '')
	{
	    alert("Debe Ingresar la Comuna");
        f.TxtComuna.focus();  
		return
    }   

    if(f.cmbregion.value == -1)
	{
	    alert("Debe Seleccionar Región");
        f.cmbregion.focus();  
		return
    }   

    if(f.TxtDireccion.value == '')
	{
	    alert("Debe Ingresar la Dirección");
        f.TxtDireccion.focus();  
		return
    }   

    if(f.TxtRepresentante.value == '')
	{
	    alert("Debe Ingresar el Representante");
        f.TxtRepresentante.focus();  
		return
    }   

    if(f.TxtFono.value == '')
	{
	    alert("Debe Ingresar el Fono");
        f.TxtFono.focus();  
		return
    }   

    if(f.TxtCelular.value == '')
	{
	    alert("Debe Ingresar el Celular");
        f.TxtCelular.focus();  
		return
    }   

	f.action = 'sec_ing_destino01.php?Proceso=G';
	f.submit();

}
function Salir()
{
	var frm =document.FrmIngreso;	 
	window.close();
}

function  Recarga(TipoBusqueda,Valores)
{
	var frm =document.FrmIngreso;
	if (frm.CmbRutCliente!='-' || frm.CmbRutCliente!='-1')
	{
		frm.action="sec_ing_destino.php?BuscarCliente=S&TipoBusqueda="+TipoBusqueda+"&Valores="+Valores;
		frm.submit(); 
	}
}
function Cancelar()
{
	var frm =document.FrmIngreso;	 
	frm.action="sec_ing_destino.php";
	frm.submit(); 
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmIngreso" method="post" action="">
  <table width="479" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="467">
	  <table width="464" height="47" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="18" colspan="2"><div align="center"><strong>Ingreso Destinos</strong></div></td>
          </tr>
			<input type="hidden" name="TxtId" style="width:80px" readOnly value="<?php echo $TxtId?>">
			<input type="hidden" name="TxtCliente" style="width:80px"  readonly value="<?php echo $TxtCliente?>">
			<input type="hidden" name="TxtSubCliente" style="width:80px"  ReadOnly value="<?php echo $TxtSubCliente?>">
          <tr> 
            <td width="133" height="26"><strong>Rut Cliente</strong></td>
			<td width="316">
			<input type="text" name="TxtRut"  maxlength="10" style="width:80px" readonly value="<?php echo $TxtRut?>">&nbsp;&nbsp;<strong><?php echo $NombreCliente;?></strong>
			</td>
          </tr>
          <tr> 
            <td width="133" height="26"><strong>Rut Destino</strong></td>
			<td width="316">
				<SELECT name="CmbRutCliente" style="width:300" onChange="Recarga('1','<?php echo $Valores;?>')">
				<option value="-1">Seleccionar</option>
				<?php
					echo "<option value='-'>&nbsp;</option>";
					echo "<option value='-'>------CLIENTES VENTAS DIRECTAS--------------------------</option>";
					$Consulta="SELECT * from sec_web.cliente_venta where (cod_cliente like '%VD%') and (rut <>'".$TxtRut."') and nombre_cliente <> ''  order by nombre_cliente";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbRutCliente==$Fila["cod_cliente"])
						{
							echo "<option value='".$Fila["cod_cliente"]."' SELECTed>".$Fila["nombre_cliente"]."</option>";
						}
						else
						{
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["nombre_cliente"]."</option>";
						}
					}
					echo "<option value='-'>&nbsp;</option>";
					echo "<option value='-'>------CLIENTES CHILE--BRASIL--ARGENTINA-----------------------------</option>";
					echo "<option value='-'>&nbsp;</option>";
					$Consulta="SELECT * from sec_web.cliente_venta where (cod_cliente like '%LX%' or cod_cliente like '%AR%' or ";
					$Consulta.="cod_cliente like '%BR%' or cod_cliente like '%VD%') and (rut <>'".$TxtRut."') and nombre_cliente <> '' order by nombre_cliente";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbRutCliente==$Fila["cod_cliente"])
						{
							echo "<option value='".$Fila["cod_cliente"]."' SELECTed>".$Fila["nombre_cliente"]."</option>";
						}
						else
						{
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["nombre_cliente"]."</option>";
						}
					}
					
				?>
				</SELECT>
			</td>
          </tr>
		  <tr>
		  <td>&nbsp;</td>
		  <td>
		  <input type="text" name="TxtRutDestino"  maxlength="10" style="width:80px" maxlength="9" value="<?php echo $TxtRutDestino;?>">&nbsp;-&nbsp;
		  <input type="text" name='TxtDvDestino' style="width:20" maxlength="1" value="<?php echo $TxtDvDestino;?>">&nbsp;<input type="button" name="BtnOk" value="Ok" onClick="Recarga('2','<?php echo $Valores;?>')">
		  </td>
		  </tr>
          <tr> 
            <td width="133" height="26">Ciudad</td>
			<td width="316">
			<input type="text" name="TxtCiudad" style="width:150px" value="<?php echo $TxtCiudad?>">
			</td>
          </tr>		  
          <tr> 
            <td width="133" height="26">Comuna</td>
			<td width="316">
			<input type="text" name="TxtComuna" style="width:150px" value="<?php echo $TxtComuna?>">
			</td>
          </tr>		  
          <tr> 
            <td width="133" height="26">Region</td>
			<td width="316">
			<SELECT name="cmbregion" style="width:120">
			<?php
				echo'<option value="-1">SELECCIONAR</option>';

				if($cmbregion=="1")
					echo'<option value="1" SELECTed>I Región</option>';
				if($cmbregion=="1")
					echo'<option value="1" SELECTed>I Región</option>';
				else	
					echo'<option value="1">I Región</option>';
				if($cmbregion=="2")
					echo'<option value="2" SELECTed>II Región</option>';
				else	
					echo'<option value="2">II Región</option>';
				if($cmbregion=="3")
					echo'<option value="3" SELECTed>III Región</option>';
				else	
					echo'<option value="3">III Región</option>';
				if($cmbregion=="4")
					echo'<option value="4" SELECTed>IV Región</option>';
				else	
					echo'<option value="4">IV Región</option>';
				if($cmbregion=="5")
					echo'<option value="5" SELECTed>V Región</option>';
				else	
					echo'<option value="5">V Región</option>';
				if($cmbregion=="6")
					echo'<option value="6" SELECTed>VI Región</option>';
				else	
					echo'<option value="6">VI Región</option>';
				if($cmbregion=="7")
					echo'<option value="7" SELECTed>VII Región</option>';
				else	
					echo'<option value="7">VII Región</option>';
				if($cmbregion=="8")
					echo'<option value="8" SELECTed>VIII Región</option>';
				else	
					echo'<option value="8">VIII Región</option>';
				if($cmbregion=="9")
					echo'<option value="9" SELECTed>IX Región</option>';
				else	
					echo'<option value="9">IX Región</option>';
				if($cmbregion=="10")
					echo'<option value="10" SELECTed>X Región</option>';
				else	
					echo'<option value="10">X Región</option>';
				if($cmbregion=="11")
					echo'<option value="11" SELECTed>XI Región</option>';
				else	
					echo'<option value="11">XI Región</option>';
				if($cmbregion=="12")
					echo'<option value="12" SELECTed>XII Región</option>';
				else	
					echo'<option value="12">XII Región</option>';
				if($cmbregion=="13")
					echo'<option value="13" SELECTed>Región Metrop.</option>';
				else	
					echo'<option value="13">Región Metrop.</option>';
								 
			?>
			</SELECT>
			</td>
          </tr>		  
          <tr> 
            <td width="133" height="26">Direcci&oacute;n</td>
			<td width="316">
			<input type="text" name="TxtDireccion" style="width:300px" value="<?php echo $TxtDireccion?>">
			</td>
          </tr>		  
          <tr> 
            <td width="133" height="26">Representante</td>
			<td width="316">
			<input type="text" name="TxtRepresentante" style="width:150px" value="<?php echo $TxtRepresentante?>">
			</td>
          </tr>		  
          <tr> 
            <td width="133" height="26">Fono</td>
			<td width="316">
			<input type="text" name="TxtFono" style="width:100px" value="<?php echo $TxtFono?>">
			</td>
          </tr>		  
          <tr> 
            <td width="133" height="26">Celular</td>
			<td width="316">
			<input type="text" name="TxtCelular" style="width:100px" value="<?php echo $TxtCelular?>">
			</td>
          </tr>		  

        </table>
        <br>
        <table width="464" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="455"> <div align="center"> 
                <input name="BtnGrabar" type="button" style="width:50"  id="BtnGrabar" value="Grabar" onClick="Grabar('')" >
                <input name="BtnSalir" style="width:50" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
<?php
	echo "<script languaje='JavaScript'>";
	echo "var frm=document.FrmIngreso;";
	if ($Mensaje!='')
	{
		echo "alert('".$Mensaje."');";
	}
	echo "</script>"
?>

</form>
</body>
</html>
