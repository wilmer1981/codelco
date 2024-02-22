<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 8;
	include("../principal/conectar_principal.php");
	$CookieRut= $_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	

	if(isset($_REQUEST["Productos"])) {
		$Productos = $_REQUEST["Productos"];
	}else{
		$Productos =  "";
	}
	if(isset($_REQUEST["SubProductos"])) {
		$SubProductos = $_REQUEST["SubProductos"];
	}else{
		$SubProductos =  "";
	}
	if(isset($_REQUEST["Plantilla"])) {
		$Plantilla = $_REQUEST["Plantilla"];
	}else{
		$Plantilla =  "";
	}
	if(isset($_REQUEST["NombrePlantilla"])) {
		$NombrePlantilla = $_REQUEST["NombrePlantilla"];
	}else{
		$NombrePlantilla =  "";
	}
	
	$TxtNombrePlantilla = $NombrePlantilla;

	
	if (isset($Productos)) 
	{
		$CmbProductos=$Productos;
	}
	if (isset($SubProductos)) 
	{
		$CmbSubProducto=$SubProductos;
	}


	header ("location:cal_quimico_plantilla.php?Productos=".$CmbProductos."&SubProductos=".$CmbSubProducto."&Plantilla=".$Cod_Plantilla."&NombrePlantilla=".$TxtNombrePlantilla);		
		
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
function Recarga()
{
 var Frm=document.FrmPersonalizar;
     Frm.action= "cal_quimico_plantilla.php";
	 Frm.submit();
}
function ModificarPlantilla()
{
	var Frm=document.FrmPersonalizar;
	
	window.open("cal_buscar_plantilla.php?TipoPlantilla=G&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value,"","top=150,left=20,width=660,height=400,scrollbars=yes,resizable = yes");

}
function MostrarLeyes(CodPlantilla)
{
	var Frm=document.FrmPersonalizar;
	var TipoPlantilla="";
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
	window.open("cal_leyes_quimico.php?Personalizar=S&Producto="+Frm.CmbProductos.value+"&SubProducto="+Frm.CmbSubProducto.value+"&NombrePlantilla="+Frm.TxtNombrePlantilla.value+"&CodPlantilla="+CodPlantilla,"","top=150,left=20,width=660,height=400,scrollbars=yes,resizable = yes");
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
function Proceso(Opcion,Cod_Plantilla)
{
	var Frm=document.FrmPersonalizar;
	var Leyes="";
	switch (Opcion)
	{
		case "E":
			if (LeyesSeleccionadas())
			{
				Leyes=RecuperarElementosCheckeados();
				Frm.action="cal_quimico_plantilla01.php?Opcion="+Opcion+"&Leyes="+Leyes+"&Cod_Plantilla="+Cod_Plantilla;
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
function Nuevo()
{
	var Frm=document.FrmPersonalizar;
	Frm.action = "cal_quimico_plantilla01.php?Opcion=L";
	Frm.submit();	
}
function Salir()
{
	var Frm=document.FrmPersonalizar;
	Frm.action = "cal_quimico_plantilla01.php?Opcion=S";
	Frm.submit();	
}

</script>
<title>Plantilla Genericas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmPersonalizar" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" cellpadding="5" class="tablaprincipal">
  <tr>
    <td align="center">
	<table width="677" border="1" cellpadding="5">
          <tr> 
            <td width="54"><div align="center"></div>
            </td>
            <td width="454"></td>
            <td width="131"><input align="right"type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="ModificarPlantilla();">
              <input align="right"type="button" name="Button3" value="Nuevo" style="width:60" onClick="Nuevo();"></td>
          </tr>
        </table>
        <br>

	    <table width="677" border="0" class="TablaInterior">
          <tr> 
            <td><div align="right">Responsable:</div></td>
            <td colspan="3"> 
              <?php
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			  ?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="80">
<!--<div align="right">Tipo Plantilla</div>--></td>
            <td width="113"><!--<input type="radio" name="OptTipoPlantilla" value="P" checked>
              Personalizada--> </td>
            <td width="120"><!--<input type="radio" name="OptTipoPlantilla" value="G">Generica--></td>
            <td>&nbsp;</td>
            <td width="125">&nbsp;</td>
            <td width="88"><div align="right"> </div></td>
          </tr>
          <tr> 
            <td><div align="right">Producto</div></td>
            <td colspan="2"><strong> 
            <?php          
				echo "<select name='CmbProductos' style='width:250 'id='select' value='".$CmbProductos."' onChange=Recarga();>";
				echo "<option value='-1' selected>Seleccionar</option>";
				if (isset($FechaBuscar))
				{
					$CmbProductos = $Productos;
				}
				$Consulta="select cod_producto,descripcion from productos order by descripcion"; 
				$Respuesta = mysqli_query($link, $Consulta);
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
            <td colspan="2"><strong> 
              <?php
				echo "<select name='CmbSubProducto' style='width:250'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
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
				echo "</select>";
		 	  ?>
              </strong></td>
            <td><div align="right">Leyes</div></td>
            <td><div align="center"> 
                <input type="button" name="Button2" value="Leyes" style="width:60" onClick="MostrarLeyes('<?php echo $Plantilla;?>');">
              </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="676" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="65"><input type="checkbox" name="CheckTodos" value="checkbox" onClick="CheckearTodo();">
              Todos</td>
            <td width="585"><input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="Proceso('E','<?php echo $Plantilla;?>');"></td>
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
        <div style='position:absolute; overflow:auto; left: 57px; top: 275px; width: 676px; height: 113px;'> 
          <?php
				echo "<table width='660' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
				$Consulta = "select t2.cod_leyes,t3.nombre_leyes,t3.abreviatura as abrevley,t4.abreviatura as abrevimp from cal_web.plantillas t1 inner join cal_web.leyes_por_plantillas t2 on t1.cod_plantilla=t2.cod_plantilla and t1.rut_funcionario = t2.rut_funcionario";
				$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
				$Consulta = $Consulta." inner join proyecto_modernizacion.unidades t4 on t2.cod_unidad = t4.cod_unidad";
				$Consulta = $Consulta." where t1.rut_funcionario = '0' and t1.cod_plantilla ='".$Plantilla."'";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					echo "<td width='43px'><input name='CheckLey' type='checkbox' style='width:43px'></td><input type='hidden' value =".$Fila["cod_leyes"].">";
					echo "<td width='90px'><input type='textbox' style='width:90px' readonly value ='".$Fila["abrevley"]."'></td>";
					echo "<td width='157px'><input type='textbox' style='width:157px' readonly value ='".$Fila["nombre_leyes"]."'></td>";
					echo "<td width='121'px><input type='textbox' style='width:121px' readonly value ='".$Fila["abrevimp"]."'></td>";
					echo "</tr>";
				}	
				echo "</table>";
		  ?>
        </div>
        <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <table width="676" border="0">
          <tr> 
            <td>&nbsp;</td>
            <td><div align="center"> 
                <input name="BtnSalir" type="button"  value="Salir" style="width:60" onClick="Salir();">
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
