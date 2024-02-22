<?php
include("../principal/conectar_principal.php");
switch ($TipoPlantilla)
{
	case "G":
		$Rut =0;
		break;
	case "P":
		$Rut =$CookieRut;
		break;
}	
?>
<html>
<head>
<title>Seleccionar Plantillas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Recarga(TipoPlantilla,S)
{
 	var frm=document.FrmPlantillas;
	frm.action= "cal_buscar_plantilla.php?TipoPlantilla="+TipoPlantilla+"&Salir="+S;
	frm.submit();
}

function Recuperar(TipoPlantilla,S)
{
	var frm=document.FrmPlantillas;
	var LargoForm = frm.elements.length;
	var NomPlantilla="";
	var Plantilla="";
	var RutPlant ="";
	var CheckeoPlantillas="";
	var Prod ="";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "radioP") && (frm.elements[i].checked == true))
		{
			NomPlantilla=frm.elements[i+1].value;
			Plantilla =frm.elements[i+2].value; 
			RutPlant =frm.elements[i+3].value;
			SProd=frm.elements[i+4].value;
			 
			CheckeoPlantillas = true;
		}
	}
	if (CheckeoPlantillas == false)
	{
		alert ("No Hay Plantillas Seleccionadas");
	}
	else
	{
		switch (TipoPlantilla)
		{
			case "G":																																																																																		
				window.opener.document.FrmPersonalizar.action="cal_quimico_plantilla.php?Plantilla="+Plantilla+"&RutPlant="+RutPlant+"&NombrePlantilla="+NomPlantilla+"&Productos="+frm.CmbProductos.value+"&SubProductos="+SProd;
				window.opener.document.FrmPersonalizar.submit();
				window.close();
				break;
			case "P":
				window.opener.document.FrmPersonalizar.action="cal_personalizar_plantilla.php?Plantilla="+Plantilla+"&RutPlant="+RutPlant+"&NombrePlantilla="+NomPlantilla+"&Productos="+frm.CmbProductos.value+"&SubProductos="+frm.CmbSubProducto.value+"&Salir="+S;
				window.opener.document.FrmPersonalizar.submit();
				window.close();
				break;
		}		
	}
}
</script>



</head>

<body leftmargin="0" topmargin="0"  >
<form name="FrmPlantillas" method="post" action="">
  <table width="609" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="591"><table width="600"  border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td><div align="center"><strong>Seleccionar Plantillas</strong></div></td>
          </tr>
        </table>
        <br>
        <table width="600"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="3"><strong>Buscar</strong></td>
          </tr>
          <tr> 
            <td width="156">Tipo Producto</td>
            <td width="338"><strong> 
              <select name="CmbProductos" style="width:280" onChange="Recarga('<?php echo $TipoPlantilla;?>','<?php echo $Salir;?>');">
                <option value='-1' selected>Seleccionar</option>
                <?php
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
				?>
              </select>
              </strong></td>
            <td width="84" rowspan="2"><div align="center"> 
                <?php
					echo "<input name='BtnBuscar' type='button' value='Buscar' onClick=\"Recarga('$TipoPlantilla','$Salir');\">";
				?>	
              </div></td>
          </tr>
          <tr> 
            <td>Tipo SubProducto</td>
            <td><strong> 
				<?php
	    	        echo "<select name='CmbSubProducto' style='width:280'>";
					if ($CmbSubProducto == -1)
					{
						echo "<option value='-1' selected>Todos</option>";
					} 
					else
					{	
    	            	echo "<option value='-1' selected>Seleccionar</option>";
					}	
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
					echo "</select>"
				?>
              </strong></td>
          </tr>
          <tr> 
            <td>Nombre Funcionario</td>
            <td colspan="2"><strong> </strong> <strong> 
              <?php
			$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
	  		$Resultado= mysqli_query($link, $Consulta);
			if ($Fila =mysqli_fetch_array($Resultado))
			{	
				echo "<input name='TxtNombre' type='text' style='width:280' maxlength='200' readonly value= '".$TxtNombre = $Fila["nombres"]." ".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]."'>";
				//echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));   
	  		}
	  		else
			{
		  		/*$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					//echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
					echo "<input name='TxtNombre' type='text' style='width:280' maxlength='200' readonly value='".$TxtNombre = $Fila["nombres"]." ".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]."'>";				
				}*/
		
			}
		  ?>
              </strong> <strong> </strong></td>
          </tr>
        </table>
        <br>
        <table width="600"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="23" colspan="3"><strong>Plantillas Seleccionadas</strong></td>
          </tr>
          <?php
		//consulta que busca al funcionario si este ha creado a una plantilla 
		if ($CmbSubProducto == -1)
		{
			$Consulta ="select distinct t1.cod_subproducto,t1.rut_funcionario,t1.cod_plantilla,t1.nombre_plantilla ";
			$Consulta = $Consulta."from cal_web.plantillas t1 inner join cal_web.leyes_por_plantillas t2 on t1.rut_funcionario = t2.rut_funcionario and t1.cod_plantilla = t2.cod_plantilla ";
			$Consulta = $Consulta."where (t1.rut_funcionario = '".$Rut."' and t1.tipo_plantilla ='".$TipoPlantilla."') and  (cod_producto = '".$CmbProductos."')";  
			$Respuesta =mysqli_query($link, $Consulta);
			}
			else
			{	
				$Consulta ="select distinct t1.rut_funcionario,t1.cod_plantilla,t1.nombre_plantilla ";
				$Consulta = $Consulta."from cal_web.plantillas t1 inner join cal_web.leyes_por_plantillas t2 on t1.rut_funcionario = t2.rut_funcionario and t1.cod_plantilla = t2.cod_plantilla ";
				$Consulta = $Consulta."where (t1.rut_funcionario = '".$Rut."' and t1.tipo_plantilla ='".$TipoPlantilla."') and  (cod_producto = '".$CmbProductos."' and cod_subproducto = '".$CmbSubProducto."')"; 
		 		$Respuesta =mysqli_query($link, $Consulta);
		}
		while ($Fila = mysqli_fetch_array($Respuesta))
		{		
			echo "<tr>"; 
			echo "<td width='29'><input type='radio' name='radioP' value='radiobutton'></td>";
			echo "<td width='150'><input name='TxtNombreP' type='text'  style='width:150' maxlength='200' readonly value = '".$TxtNombreP = $Fila["nombre_plantilla"]."'><input type = 'hidden' value =".$Fila["cod_plantilla"]."><input type = 'hidden' value =".$Fila["rut_funcionario"]."><input type = 'hidden' value=".$Fila["cod_subproducto"]."></td>";
			//consulta que busca las leyes asociadas al funcionario que este ha generado en las plantillas 
			$Consulta ="select t2.abreviatura ";
			$Consulta = $Consulta."from cal_web.leyes_por_plantillas t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";
			$Consulta = $Consulta."where (t1.rut_funcionario = '".$Fila["rut_funcionario"]."' and t1.cod_plantilla ='".$Fila["cod_plantilla"]."')";  
			$Respuesta2=mysqli_query($link, $Consulta);
			$Plantillas="";
			while ($Fila2=mysqli_fetch_array($Respuesta2))
			{
				$Plantillas = $Plantillas.$Fila2["abreviatura"].'-';  		
			}		
			echo "<td width='399'><input name='TxtPlantillas' type='text'  style='width:399' readonly value = '".$TxtPlantillas = $Plantillas."'></td>";
			echo "</tr>";
		}	
	?>
        </table>
        <br>
        <table width="600"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center"><strong> 
            <?php
				
			  	echo "<input name='BtnOk' type='button' value='Ok' style='width:70' onClick=\"Recuperar('$TipoPlantilla','$Salir');\">";
			?>
                &nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70" onClick="JavaScript:window.close();">
                </strong> </div>
              <div align="center"> </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
