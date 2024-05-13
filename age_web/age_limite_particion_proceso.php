<?php 	
	include("../principal/conectar_principal.php");
	$NomBtnGrabar = 'Grabar';
	$TxtNumPlantilla    = isset($_REQUEST["TxtNumPlantilla"])?$_REQUEST["TxtNumPlantilla"]:"";
	$TxtNombrePlantilla = isset($_REQUEST["TxtNombrePlantilla"])?$_REQUEST["TxtNombrePlantilla"]:"";
	$TxtDescripcion     = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	$TxtRango1          = isset($_REQUEST["TxtRango1"])?$_REQUEST["TxtRango1"]:"";
	$TxtRango2          = isset($_REQUEST["TxtRango2"])?$_REQUEST["TxtRango2"]:"";
	$TxtLimPart         = isset($_REQUEST["TxtLimPart"])?$_REQUEST["TxtLimPart"]:"";
	$CmbUnidad          = isset($_REQUEST["CmbUnidad"])?$_REQUEST["CmbUnidad"]:'-1';

	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Recarga   = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";
	$CmbLeyes  = isset($_REQUEST["CmbLeyes"])?$_REQUEST["CmbLeyes"]:"";
	$CodLey    = isset($_REQUEST["CodLey"])?$_REQUEST["CodLey"]:"";
	$Corr      = isset($_REQUEST["Corr"])?$_REQUEST["Corr"]:"";	
	$CmbPlantilla = isset($_REQUEST["CmbPlantilla"])?$_REQUEST["CmbPlantilla"]:"";
	$TipoProceso  = isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:"";
	$TxtCorr      = isset($_REQUEST["TxtCorr"])?$_REQUEST["TxtCorr"]:"";		

	$Consulta ="select ifnull(max(cod_plantilla)+1,1) as corr from age_web.limites_particion";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$TxtNumPlantilla=$Fila["corr"];
	}
	if ($Recarga=='S')
	{
		$Proceso='N';
		$Consulta ="select * from age_web.limites_particion where cod_plantilla='$CmbPlantilla'";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$CmbPlantilla=$Fila["cod_plantilla"];
			$TxtNumPlantilla=$Fila["cod_plantilla"];
			$TxtNombrePlantilla=$Fila["nombre_plantilla"];
		}
		$Consulta ="select ifnull(max(correlativo)+1,1) as corr from age_web.limites_particion where cod_plantilla='$CmbPlantilla' and cod_ley='$CmbLeyes'";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtCorr=$Fila["corr"];
		}
	}
	if($Proceso=='M')
	{
		$Consulta ="select * from age_web.limites_particion where cod_plantilla='$CmbPlantilla' and cod_ley='$CodLey' and correlativo='$Corr'";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$NomBtnGrabar='Modificar';
			$TxtNumPlantilla=$Fila["cod_plantilla"];
			$TxtNombrePlantilla=$Fila["nombre_plantilla"];
			$CmbLeyes=$Fila["cod_ley"];
			$TxtCorr=$Fila["correlativo"];
			$TxtDescripcion=$Fila["descripcion"];
			$TxtRango1=$Fila["rango1"];
			$TxtRango2=$Fila["rango2"];
			$TxtLimPart=$Fila["limite_particion"];
			$CmbUnidad=$Fila["cod_unidad"];
		}
	}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Grabar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbLeyes.value == "-1")
	{
		alert("Debe Seleccionar Leyes")
		Frm.CmbLeyes.focus();
		return;
	}
	if (Frm.TxtDescripcion.value == "")
	{
		alert("Debe Ingresar Descripcion");
		Frm.TxtDescripcion.focus();
		return;
	}
	if (Frm.TxtLimPart.value == "")
	{
		alert("Debe Ingresar Limite Particion");
		Frm.TxtLimPart.focus();
		return;
	}
	Frm.action="age_limite_particion_proceso01.php?Proceso="+Proceso;
	Frm.submit();
}
function Modificar(CodLey,Corr)
{
	var Frm=document.FrmProceso;

	Frm.action="age_limite_particion_proceso.php?Proceso=M&Corr="+Corr+"&CodLey="+CodLey;
	Frm.submit();
}
function Eliminar(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="age_limite_particion_proceso01.php?Proceso="+Proceso;
	Frm.submit();
}

function Recarga(Tipo)
{
	var Frm=document.FrmProceso;
	
	switch(Tipo)
	{
		case '1':
			Frm.action="age_limite_particion_proceso.php?Recarga=S";	
			break;
		case '2':
			Frm.action="age_limite_particion_proceso01.php";	
			break;
	}
	Frm.submit();
}

function Salir()
{
	window.close();
	
}
</script>
<title>
<?php if($TipoProceso=='CANJE')
		echo "Mantenedor Limites de Particion";
	else
		echo "Comparacion de Leyes entre PQ1 Y Muestra Paralela";
?>

</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.CmbPlantilla.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<form name="FrmProceso" method="post" action="">
<input type="hidden" name="TipoProceso" value="<?php echo $TipoProceso; ?>">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td class="Colum01">N&deg; Plantilla</td>
            <td><select name="CmbPlantilla" class="Select01" onChange="Recarga('1')" style="width:250" >
                <option value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select distinct cod_plantilla,nombre_plantilla ";
				$Consulta.= " from age_web.limites_particion where proceso='$TipoProceso' order by cod_plantilla";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbPlantilla == $Fila["cod_plantilla"])
						echo  "<option selected value='".$Fila["cod_plantilla"]."'>".$Fila["nombre_plantilla"]."</option>\n";
					else
						echo  "<option value='".$Fila["cod_plantilla"]."'>".$Fila["nombre_plantilla"]."</option>\n";
				}
				?>
              </select>
			  <input type="text" name="TxtNumPlantilla" size="7" value='<?php echo $TxtNumPlantilla;?>' readonly="true" class="InputColor"></td>
          </tr>
          <tr>
            <td class="Colum01">Nombre Plantilla </td>
            <td><input name="TxtNombrePlantilla" type="text" size="80" value="<?php echo $TxtNombrePlantilla;?>" class="InputLeft" ></td>
          </tr>
          <tr>
            <td class="Colum01">Ley</td>
            <td>
              <select name="CmbLeyes" class="Select01" onChange="Recarga('1')" >
                <option value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select cod_leyes,abreviatura ";
				$Consulta.= " from proyecto_modernizacion.leyes order by cod_leyes";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbLeyes == $Fila["cod_leyes"])
						echo  "<option selected value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>\n";
					else
						echo  "<option value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>\n";
				}
				?>
              </select>&nbsp;&nbsp;&nbsp;Correlativo&nbsp;&nbsp;<input type="text" name="TxtCorr" size="7" value='<?php echo $TxtCorr;?>' readonly="true" class="InputColor">
            </td>
          </tr>
          <tr> 
            <td class="Colum01">Descripcion</td>
            <td><input name="TxtDescripcion" type="text" size="80" value="<?php echo $TxtDescripcion;?>" class="InputLeft" ></td>
          </tr>
          <tr> 
            <td width="91" height="22" class="Colum01">Rango1</td>
            <td width="415"><input name="TxtRango1" type="text" size="8" value="<?php echo $TxtRango1;?>" class="InputCen" onKeyDown="TeclaPulsada(true)" ></td>
			
          </tr>
          <tr> 
            <td height="22" class="Colum01">Rango2</td>
            <td><input name="TxtRango2" type="text" size="8" value="<?php echo $TxtRango2;?>" class="InputCen" onKeyDown="TeclaPulsada(true)"></td>
          </tr>
          <tr>
            <td height="22" class="Colum01">
			<?php if($TipoProceso=='CANJE')
					echo "Limite Particion";
				else
					echo "Tolerancia";
			?>
			</td>
            <td><input name="TxtLimPart" type="text" size="12" value="<?php echo $TxtLimPart;?>"  class="InputCen" onKeyDown="TeclaPulsada(true)"></td>
          </tr>
          <tr>
            <td height="22" class="Colum01">Unidad</td>
            <td><select name="CmbUnidad" class="Select01">
              <option value="-1">SELECCIONAR</option>
              <?php
				$Consulta = "select cod_unidad,abreviatura";
				$Consulta.= " from proyecto_modernizacion.unidades order by cod_unidad ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbUnidad == $Fila["cod_unidad"])
						echo  "<option selected value='".$Fila["cod_unidad"]."'>".$Fila["abreviatura"]."</option>\n";
					else
						echo  "<option value='".$Fila["cod_unidad"]."'>".$Fila["abreviatura"]."</option>\n";
				}
				?>
            </select>&nbsp;&nbsp;&nbsp;
			<input type="button" name="BtnGrabar" value="<?php echo $NomBtnGrabar;?>" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
			<input type="button" name="BtnCancelar" value="Cancelar" style="width:60" onClick="Recarga('2');">
			<input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="Eliminar('E');">
			<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			</td>
          </tr>
        </table>
        <br>
        <table width="535" border="1" cellpadding="2" cellspacing="0" >
          <tr class="ColorTabla01" align="center"> 
            <td width="45">&nbsp;</td>
			<td width="220">Descripcion</td>
			<td width="70">Rango1</td>
			<td width="70">Rango2</td>
			<td width="70">
			<?php if($TipoProceso=='CANJE')
					echo "Lim.Particion";
				else
					echo "Tolerancia";
			?>
			</td>
			<td width="60">Unidad</td>
          </tr>
		  <?php
		  	if($CmbPlantilla!='-1')
			{
				$Consulta="select t1.cod_ley,t1.correlativo,t1.descripcion,t1.rango1,t1.rango2,t1.limite_particion,t2.abreviatura nom_ley,t3.abreviatura nom_unidad ";
				$Consulta.="from age_web.limites_particion t1 left join proyecto_modernizacion.leyes t2 ";
				$Consulta.="on t1.cod_ley=t2.cod_leyes left join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad where cod_plantilla='$CmbPlantilla'";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					echo "<td align='center' class='Detalle02'><input type='radio' name='OptSelecionar' onclick=Modificar('".$Fila["cod_ley"]."','".$Fila["correlativo"]."')>".$Fila["nom_ley"]."</td>";
					echo "<td align='left'>".$Fila["descripcion"]."</td>";
					echo "<td align='center'>".number_format($Fila["rango1"],3,',','.')."</td>";
					echo "<td align='center'>".number_format($Fila["rango2"],3,',','.')."</td>";
					echo "<td align='center'>".number_format($Fila["limite_particion"],3,',','.')."</td>";
					echo "<td align='center'>".$Fila["nom_unidad"]."</td>";
					echo "</tr>";
				}
			}
		  ?>
        </table>
	</td>
  </tr>
</table>
  </form>
</body>
</html>

