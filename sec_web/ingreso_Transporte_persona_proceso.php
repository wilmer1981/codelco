<?php 	
	include("../principal/conectar_principal.php");
	if(!isset($CheckRut))
		$CheckRut='N';
	switch($Proceso)
	{
		case "IT":
			$TxtPatente='';$TxtNombre='';$TxtMarca='';
			$TxtAno='';$TxtPeso='';$TxtCapacidad='';
			$TxtAcoplado='';$TxtSW='';
			break;
	 	case "MT":
			$Datos=explode('//',$Valores);
			$TxtRut=$Datos[0];
			$Consulta="select * from sec_web.transporte where rut_transportista='".$TxtRut."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtPatente=$Fila["patente_transporte"];
			$TxtNombre=$Fila["nombre_transportista"];
			$TxtMarca=$Fila["marca_modelo_transporte"];
			$TxtAno=$Fila["ano_transporte"];
			$TxtPeso=$Fila["peso_tara_transporte"];
			$TxtCapacidad=$Fila["capacidad_transporte"];
			$TxtAcoplado=$Fila["acoplado_camion"];
			$TxtSW=$Fila["sw"];
			$TxtGiro=$Fila["giro_transportista"];
			break;
	}
?>
<html>
<head>
<script language="javascript" src="validarut.js"></script>
<script language="javascript">






function Grabar(Proceso,Valores,Existe)
{
	var Frm=document.FrmProceso;
	if (Proceso=='IT')
	{
		if (Frm.TxtRut.value == "")
		{
			alert("Debe Ingresar Rut")
			Frm.TxtRut.focus();
			return;
		}
		
		if (Frm.CheckRut.checked==false)
		{
			if (document.FrmProceso.TxtRut.value != "")
			{
				valor= new Object(document.FrmProceso.TxtRut.value);
				foco = new Object(document.FrmProceso.TxtRut.focus());
				var bandera = Rut(document.FrmProceso.TxtRut.value,'Rut Transportista', foco, valor);
				if(bandera == false){
				return;
				}
			}
		}
		if (Frm.TxtNombre.value == "")
		{
			alert("Debe Ingresar Nombre")
			Frm.TxtNombre.focus();
			return;
		}
		if (Frm.TxtPatente.value == "")
		{
			alert("Debe Ingresar Patente")
			Frm.TxtPatente.focus();
			return;
		}
		if (Frm.TxtAcoplado.value == "")
		{
			alert("Debe Ingresar Acoplado")
			Frm.TxtAcoplado.focus();
			return;
		}
	}
	Frm.action="ingreso_transporte_persona_proceso01.php?Buscar=S&Proceso="+Proceso+"&TxtRut="+Frm.TxtRut.value+"&Valores="+Valores;
	Frm.submit(); 	

	
	
}

function Salir()
{
	window.close();
}

</script>
<title>ingresa</title>  
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Mrut==1)
	echo "<body onload='document.FrmProceso.TxtDescripcion.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	else
	echo "<body onload='document.FrmProceso.TxtRut.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr>
			<td width="86">Rut</td>
			<td width="420"> 
              <?php 
			 if ($Proceso=="IT")
			 	{
				echo "<input type='text' name='TxtRut' style='width:75' maxlength='10' value='$TxtRut'><span class=' InputRojo'>(*)</span>";
				
				}
			 else
			 {	
			  	echo "<input type='text' name='TxtRut' style='width:75' maxlength='10' value='$TxtRut'readonly >";
			  }
			   if($CheckRut=='S')
			  {
			  ?> 
			<input type='checkbox' name='CheckRut' value='N' onClick='' checked>Rut Internacional
			<?php
			}
			else
			{
			?>			
			<input type='checkbox' name='CheckRut' value='S' onClick=''>Rut Internacional
			<?php
			}
			?>
            </td>
          </tr>
          <tr> 
            <td>Patente</td>
			 <td>
			 <?php if ($Proceso=="IT") {	?>
              <input  type="text" name="TxtPatente" maxlength='10' value="<?php echo $TxtPatente;?>" style="width:100"><span class=" InputRojo">(*)</span>
			<?php }
			 else 
			 { ?>
			   <input  type="text" name="TxtPatente" maxlength='10' value="<?php echo $TxtPatente;?>" readonly style="width:100"><span class=" InputRojo">(*)</span>
			<?php }?>
			</tr>
		    <tr> 
            <td>Nombre</td>
            <td><input  type="text" name="TxtNombre" maxlength='30' value="<?php echo $TxtNombre;?>" style="width:300"><span class=" InputRojo">(*)</span></td>
          </tr>
          <tr> 
            <td>Marca o Modelo </td>
            <td><input  type="text" name="TxtMarca" maxlength='30' value="<?php echo $TxtMarca;?>" style="width:300"></td>
          </tr>
          <tr>
            <td>A&ntilde;o Transporte </td>
            <td><input  type="text" name="TxtAno" maxlength='4' value="<?php echo $TxtAno;?>" style="width:50"></td>
          </tr>
		  <tr>
            <td>Peso Tara </td>
            <td><input  type="text" name="TxtPeso" maxlength='11' value="<?php echo $TxtPeso;?>" style="width:100"></td>
          </tr>
		   <tr>
            <td>Capacidad </td>
            <td><input  type="text" name="TxtCapacidad" maxlength='11' value="<?php echo $TxtCapacidad;?>" style="width:100"></td>
          </tr>
		   <tr>
            <td>Acoplado </td>
            <td> 
			<?php if ($Proceso=="IT") {	?>
			<input  type="text" name="TxtAcoplado" maxlength='10' value="<?php echo $TxtAcoplado;?>" style="width:100"><span class=" InputRojo">(*)</span>
			<?php }
			 else 
			 { ?>
			<input  type="text" name="TxtAcoplado" maxlength='10' value="<?php echo $TxtAcoplado;?>" readonly style="width:100"><span class=" InputRojo">(*)</span>
			<?php }?>
			</td>
          </tr>
		   <tr>
            <td>SW </td>
            <td><input  type="text" name="TxtSW" maxlength='1' value="<?php echo $TxtSW;?>" style="width:20"></td>
          </tr>
           <tr>
            <td>Giro </td>
            <td><input  type="text" name="TxtGiro" maxlength='50' value="<?php echo $TxtGiro;?>" style="width:250"></td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
		    <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $Existe;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
<?php
	 
		if($Existe == "S")
		{
			echo "<script languaje='javascript'>";
			echo "alert('El transportista que trata de ingresar ya existe, debe cambiar Rut ó Patente ó Acoplado');";	//valído que no exista 
			echo "</script>";
		}
?>
    </form>
</head>
</html>