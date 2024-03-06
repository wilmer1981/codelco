<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 11;
	include("../principal/conectar_sec_web.php");

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtMarca  = isset($_REQUEST["TxtMarca"])?$_REQUEST["TxtMarca"]:"";
	$BuscarMarca  = isset($_REQUEST["BuscarMarca"])?$_REQUEST["BuscarMarca"]:"";
	$TxtDes  = isset($_REQUEST["TxtDes"])?$_REQUEST["TxtDes"]:"";
	$TxtDes1  = isset($_REQUEST["TxtDes1"])?$_REQUEST["TxtDes1"]:"";

	switch($Proceso)
	{
		case "N":
			$Consulta = "SELECT *  from sec_web.marca_catodos where cod_marca='".$TxtMarca."'";
			$Resultado = mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			if ($BuscarMarca=='S')
			{
				$MarcaCatodo=$TxtMarca;
				$Consulta="SELECT * from sec_web.marca_catodos where cod_marca='".$MarcaCatodo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Mensaje='C�digo Marca ya Existe,Reingrese...';
					$TxtMarca="";
				}
			}
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
		
		if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 95))
		{
		
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
		   
				event.keyCode=46;
		   }		
		}  
		
	}
} 
function ValidarMarca(Proceso)
{
	var Frm=document.FrmProceso;

	//alert(RutValido(Frm.TxtRut.value,Frm.TxtDv.value));
	if (Frm.TxtMarca.value == "")
	{
		alert('C�digo Ingresado no es Valido');
		Frm.TxtMarca.focus;
		return;
	}	
	
	
	Frm.action="sec_ingreso_marca_proceso.php?Proceso="+Proceso+"&BuscarMarca=S";
	Frm.submit();
}

function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtMarca.value == "")
	{
		alert("Debe Ingresar C�digo de la Marca")
		Frm.TxtMarca.focus();
		return;
	}
	if (Frm.TxtDes.value == "")
	{
		alert("Debe Ingresar Descripci�n de la Marca")
		Frm.TxtDes.focus();
		return;
	}	
	if (Frm.TxtDes1.value == "")
	{
		alert("Debe Ingresar Descripci�n en Ingles")
		Frm.TxtDes1.focus();
		return;
	}
	Frm.action="sec_ingreso_marca_proceso01.php?Proceso="+Proceso+"&TxtMarca="+Frm.TxtMarca.value;
	Frm.submit();
}
function TeclaPulsada1(salto) 
{ 
	var f = document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	//alert(teclaCodigo);	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function Salir()
{
	window.close();
	
}
</script>
<title>Ingreso Marca C�todos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.TxtMarca.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtMarca.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>
<form name="FrmProceso" method="post" action="">
	<table width="426" height="180" border="0" cellpadding="3" cellspacing="0" class="TablaPrincipal">
    <tr> 
		<table width="413" border="0" cellpadding="5" class="TablaInterior">
			<tr class="ColorTabla01"> 
            	<td  align="center" width="396">
             		Ingreso Marca C�todos
        		&nbsp; </td>
			</tr>
		</table> 
		<br>
		<td width="427"><table width="415" border="0" cellpadding="3" class="TablaInterior">
			<tr> 
		  		<td>C&oacute;digo Marca</td>
				<td> <input  name="TxtMarca"  type="text"    id="TxtMarca" onKeyDown="TeclaPulsada()"   maxlength="5" style="width:80" value="<?php echo $TxtMarca;?>">
					<?php 
						echo "<input type='button' name='BtnOK' value='Ok' style='width:30' onclick=ValidarMarca('$Proceso')>";
					?>
				</td>
			</tr>
          	<tr> 
            	<td>Descripci&oacute;n</td>
            	<td><input name="TxtDes" type="text" id="TxtDes" onKeyDown="TeclaPulsada1('TxtDes1')" style="width:300" value="<?php echo $TxtDes;?>"></td>
          	</tr>
          	<tr> 
            	<td>Descripci�n Ingl�s</td>
            	<td><input name="TxtDes1" type="text" id="TxtDes1" style="width:300" value="<?php echo $TxtDes1;?>"></td>
          	</tr>
          	<tr>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
          	</tr>
		</table>
			<br>
			<br>
			<table width="413" border="0" cellpadding="5" class="TablaInterior">
				<tr> 
        			<td  align="center" width="396"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
             			 <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
            	 	&nbsp; </td>
				</tr>
			</table> 
		</td>
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
