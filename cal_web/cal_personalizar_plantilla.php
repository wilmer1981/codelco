<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 7;
	include("../principal/conectar_principal.php");
	$CookieRut  = $_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	
	$CmbProductos    = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbSubProducto  = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";	
	
	$Plantilla       = isset($_REQUEST["Plantilla"])?$_REQUEST["Plantilla"]:"";
	$RutPlant   = isset($_REQUEST["RutPlant"])?$_REQUEST["RutPlant"]:"";
	$NombrePlantilla = isset($_REQUEST["NombrePlantilla"])?$_REQUEST["NombrePlantilla"]:"";	
	$Productos    = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:"";
	$SubProductos = isset($_REQUEST["SubProductos"])?$_REQUEST["SubProductos"]:"";
	$Salir        = isset($_REQUEST["Salir"])?$_REQUEST["Salir"]:"";
	$OpcionOculto = isset($_REQUEST["OpcionOculto"])?$_REQUEST["OpcionOculto"]:"";
	$FechaBuscar = isset($_REQUEST["FechaBuscar"])?$_REQUEST["FechaBuscar"]:"";
	
	$TxtNombrePlantilla = $NombrePlantilla;
	if ($Productos!="") 
	{
		$CmbProductos=$Productos;
	}
	if ($SubProductos!="") 
	{
		$CmbSubProducto=$SubProductos;
	}
	$Consulta="select cod_centro_costo from proyecto_modernizacion.funcionarios where rut='".$Rut."'";
	$Respuesta= mysqli_query($link,$Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$CodCCosto=substr($Fila["cod_centro_costo"],0,4);
	
	
?>
<html>
<head>
<script language="JavaScript">

function CheckearTodo()
{
	var Frm=document.FrmPersonalizar;
	for (i=0;i<Frm.elements.length;i++)
	{
		if (Frm.elements[i].name == "CheckLey")
		{
			if (Frm.CheckTodos.checked == true)
			{
				Frm.elements[i].checked = true;
			}
			else
			{
				Frm.elements[i].checked = false;
			}
		}
	}
}	
function Recarga(S)
{
 var Frm=document.FrmPersonalizar;
     Frm.action= "cal_personalizar_plantilla.php?Salir="+S;
	 Frm.submit();
}
function ModificarPlantilla(S)
{
	var Frm=document.FrmPersonalizar;
	window.open("cal_buscar_plantilla.php?TipoPlantilla=P&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&Salir="+S,"","top=150,left=20,width=660,height=400,scrollbars=yes,resizable = yes");
}
function MostrarLeyes(CodPlantilla,CodCCosto,S)
{
	var Frm=document.FrmPersonalizar;
	
	if (Frm.CmbProductos.value == "-1")
	{
		alert ("Debe Ingresar Producto");
		Frm.CmbProductos.focus();
		return;
	}
    if (Frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Ingresar SubProducto");
		Frm.CmbSubProducto.focus();
		return;
	}
	if (Frm.TxtNombrePlantilla.value == "")
	{
		alert ("Debe Ingresar Nombre de la Plantilla");
		Frm.TxtNombrePlantilla.focus();
		return;
	}
	if (CodCCosto=='02-5')
	{
		window.open("cal_leyes_quimico2.php?Personalizar=S&Producto="+Frm.CmbProductos.value+"&SubProducto="+Frm.CmbSubProducto.value+"&NombrePlantilla="+Frm.TxtNombrePlantilla.value+"&CodPlantilla="+CodPlantilla,"","top=150,left=20,width=660,height=400,scrollbars=yes,resizable = yes");
	}
  	else
	{	
		window.open("cal_leyes_por_solicitud.php?Personalizar=S&Productos="+Frm.CmbProductos.value+"&SubProducto="+Frm.CmbSubProducto.value+"&NombrePlantilla="+Frm.TxtNombrePlantilla.value+"&CodPlantilla="+CodPlantilla+"&Salir="+S,"","top=150,left=20,width=660,height=400,scrollbars=yes,resizable = yes");
	}	
	//window.open("cal_leyes_por_solicitud.php?Personalizar=S","","top=150,left=20,width=640,height=400,scrollbars=yes,resizable = yes");
} 

function RecuperarElementosCheckeados()
{
	var Frm=document.FrmPersonalizar;
	var Leyes="";
	for (i=0;i<=Frm.elements.length-1;i++)
	{
		if ((Frm.elements[i].name == "CheckLey") && (Frm.elements[i].checked == true))
		{
			Leyes = Leyes + Frm.elements[i+1].value + "//";
		}
	}
	return(Leyes);
}
function Proceso(Opcion,Cod_Plantilla,S)
{
	var Frm=document.FrmPersonalizar;
	var Leyes="";
	switch (Opcion)
	{
		case "E":
			if (LeyesSeleccionadas())
			{
				Leyes=RecuperarElementosCheckeados();
				Frm.action="cal_personalizar_plantilla01.php?Opcion="+Opcion+"&Leyes="+Leyes+"&Cod_Plantilla="+Cod_Plantilla+"&Salir="+S;
				Frm.submit();
			}
			else
			{
				alert ("Debe Seleccionar una Ley");
				return;
			}	
			break;
	}	
}	
function LeyesSeleccionadas()
{
//ESTA FUNCION DEVUELVE VERDADERO SI ENCUENTRA A LO MENOS UNA LEY SELECCIONADA
	var Frm=document.FrmPersonalizar;
    for (i=0;i<=Frm.elements.length - 1;i++)
	{
		if ((Frm.elements[i].name == "CheckLey") && (Frm.elements[i].checked == true))
		{
            return(true);	
		 	break;
		}
	}
}
function Nuevo(S)
{
	var Frm=document.FrmPersonalizar;
	Frm.action = "cal_personalizar_plantilla01.php?Salir="+S +"&Opcion=L";
	Frm.submit();	
}
function Salir(Opcion)
{
	var Frm=document.FrmPersonalizar;
	switch (Opcion)
	{
		
		case "1":
			window.close();
			break;
		case "2":
			//Frm.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=12";	
			//Frm.submit();
			document.location = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=12";			
			break;	
	}
	//Frm.action = "cal_personalizar_plantilla01.php?Opcion=S";
	
}
function Salir2()
{

	document.location = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=12";			
	//Frm.action = "cal_personalizar_plantilla01.php?Opcion=S";
	
}

</script>
<title>Personalizar Plantilla</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmPersonalizar" method="post" action="">
    <?php 
		include("../principal/encabezado.php");
		if ($OpcionOculto=="")
		{	

			echo "<input type='hidden' name='OpcionOculto' value ='$Salir'>";
			$OpcionOculto=$Salir;
		}
		else
		{
			echo "<input type='hidden' name='OpcionOculto' value ='".$OpcionOculto."'>";
		}
	
	
	?>
  <table width="770" border="0" cellpadding="5" class="tablaprincipal">
  <tr>
    <td align="center">
	<table width="677" border="1" cellpadding="5">
          <tr> 
            <td width="54"><div align="center"></div>
            </td>
            <td width="454"></td>
            <td width="131"><input align="right"type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="ModificarPlantilla('<?php echo $Salir;  ?>');">
              <input align="right"type="button" name="Button" value="Nuevo" style="width:60" onClick="Nuevo('<?php echo $Salir;  ?>' );"></td>
          </tr>
        </table>
        <br>

	    <table width="677" border="0" class="TablaInterior">
          <tr> 
            <td width="80"><div align="right">Responsable: </div></td>
            <td colspan="2">&nbsp; 
              <?php
	   	$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
		$Respuesta =  mysqli_query($link,$Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
		}

	  ?>
            </td>
            <td width="125">&nbsp;</td>
            <td width="88"><div align="right"> </div></td>
          </tr>
          <tr> 
            <td><div align="right">Producto</div></td>
            <td width="228"><strong> 
              <?php          
				echo "<select name='CmbProductos' style='width:250 'id='select' value='".$CmbProductos."' onChange=Recarga('$Salir');>";
				echo "<option value='-1' selected>Seleccionar</option>";
				if ($FechaBuscar!="")
				{
					$CmbProductos = $Productos;
				}
				$Consulta="select cod_producto,descripcion from productos order by descripcion"; 
				$Respuesta =  mysqli_query($link,$Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos==$Fila["cod_producto"])
					{
						echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				}
				echo "</select>";
		?>
              </strong></td>
            <td width="122"><div align="right">Nombre Plantilla</div></td>
            <td colspan="2"><input name="TxtNombrePlantilla" type="text" id="TxtNombrePlantilla" style="width:210" value="<?php echo $TxtNombrePlantilla;?>" maxlength="35"></td>
          </tr>
          <tr> 
            <td><div align="right">SubProducto</div></td>
            <td><strong> 
              <?php
			echo "<select name='CmbSubProducto' style='width:250'>";
			echo "<option value='-1' selected>Seleccionar</option>";
			$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
			$Respuesta =  mysqli_query($link,$Consulta);
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
			echo "</select>";

	 	?>
              </strong></td>
            <td><div align="right">Leyes</div></td>
            <td><div align="center"> 
                <input type="button" name="Button2" value="Leyes" style="width:60" onClick="MostrarLeyes('<?php echo $Plantilla;?>','<?php echo $CodCCosto;?>','<?php echo $Salir;?>');">
              </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="676" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="65"><input type="checkbox" name="CheckTodos" value="checkbox" onClick="CheckearTodo();">
              Todos</td>
            <td width="585"><input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="Proceso('E','<?php echo $Plantilla;?>','<?php echo $Salir;?>');"></td>
          </tr>
        </table>
        <table width="678" border="0" cellpadding="3">
          <tr class="ColorTabla01"> 
            <td width="70">&nbsp; </td>
            <td width="140"><div align="center"><strong>Ley</strong></div></td>
            <td width="243"><div align="center"><strong>Nombre Ley</strong></div></td>
            <td width="206"><div align="center"><strong>Unidad</strong></div></td>
          </tr>
        </table>
        <div style='position:absolute; overflow:auto; left: 57px; top: 258px; width: 676px; height: 113px;'> 
          <?php
  		echo "<table width='660' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
		$Consulta = "select t2.cod_leyes,t3.nombre_leyes,t3.abreviatura as abrevley,t4.abreviatura as abrevimp from cal_web.plantillas t1 inner join cal_web.leyes_por_plantillas t2 on t1.cod_plantilla=t2.cod_plantilla and t1.rut_funcionario = t2.rut_funcionario";
		$Consulta = $Consulta." left join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
		$Consulta = $Consulta." left join proyecto_modernizacion.unidades t4 on t2.cod_unidad = t4.cod_unidad";
		$Consulta = $Consulta." where t1.rut_funcionario = '".$Rut."' and t1.cod_plantilla ='".$Plantilla."'";
		$Respuesta =  mysqli_query($link,$Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
      		echo "<td width='43px'><input name='CheckLey' type='checkbox' style='width:43px'></td><input type='hidden' value =".$Fila["cod_leyes"].">";
      		echo "<td width='90px'><input type='textbox' style='width:90px' readonly value =".$Fila["abrevley"]."></td>";
      		echo "<td width='157px'><input type='textbox' style='width:157px' readonly value =".$Fila["nombre_leyes"]."></td>";
      		echo "<td width='121'px><input type='textbox' style='width:121px' readonly value =".$Fila["abrevimp"]."></td>";
    		echo "</tr>";
		}	
		echo "</table>";
	?>
        </div>
        <br> <table width="676" border="0">
          <tr> 
            <td>&nbsp;</td>
            <td><div align="center">
				<?php 

					if ($Salir == "1")//valor viene de la pantalla cal_web.modificacion_leyes
					{
						echo "<input name='BtnSalir' type='button'  value='Salir' style='width:60' onClick=Salir('1');>";
					}
					else
					{
						//echo "<input name='BtnSalir' type='button'  value='Salir' style='width:60' onClick=Salir('2');>";
						echo "<input name='BtnSalir' type='button'  value='Salir' style='width:60' onClick=Salir2();>";
					}	
				?>	
              </div></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
