<?php 	
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	$Rut =$CookieRut;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	//echo "enabal".$Enabal."<br>";
	switch($Proceso)
	{
		case "M":
			if ($Opc=="")
			{
				$Datos=$Valores;
				for ($i=0;$i<=strlen($Datos);$i++)
				{
					if (substr($Datos,$i,2)=="//")
					{
						$Sol=substr($Datos,0,$i);
					}
				}
			}
			$Consulta="select * from cal_web.solicitud_analisis ";
			$Consulta.=" where nro_solicitud = '".$Sol."' "; 
			$Resultado=mysqli_query($link, $Consulta);
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta);
			$NumSol=$Fila1["nro_solicitud"];
			$IdMuestra=$Fila1["id_muestra"];
			$CmbArea=$Fila1[cod_area];
			$CmbCosto=$Fila1[cod_ccosto];
			$CmbPeriodo=$Fila1[cod_periodo];
			$Observacion=$Fila1["observacion"];
			$CmbAgrupacion=$Fila1[agrupacion];
			$CmbTipo=$Fila1[tipo];
			if (!isset($CmbProductos))
			{
				$CmbProductos=$Fila1["cod_producto"];
			}
			if (!isset($CmbSubProducto))
			{
				$CmbSubProducto=$Fila1["cod_subproducto"];
			}
			$CmbDias = intval(substr($Fila1[fecha_muestra],8,2));
			$CmbMes = intval(substr($Fila1[fecha_muestra],5,2));
			$CmbAno = intval(substr($Fila1[fecha_muestra],0,4));
			$A�oHora=substr($Fila1[fecha_muestra],0,strlen($Fila1[fecha_muestra])-6);
			$Hora=substr($A�oHora,11,2);
			$CmbHora=$Hora;
			$A�oMin=substr($Fila1[fecha_muestra],0,strlen($Fila1[fecha_muestra])-3);
			$Min=substr($A�oMin,14,2);
			$CmbMinutos=$Min;
			if ($Enabal=='1')
			{
				//echo "nada"."<br>";
			}
			else
			{
				if ($Enabal=='2')
				{
					$Enabal='2';
				}
				else
				{
					if ($Fila1[enabal]=='S')
					{
						//echo "if"."<br>";
						$Enabal='1';
					}
				}
			}
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(NumSol)
{
	var Frm=document.FrmProceso;
	if (Frm.IdMuestra.value == "")
	{
		alert("Debe Ingreasar IdMuestra ");
		Frm.IdMuestra.focus();
		return;
	}
	if (Frm.CmbPeriodo.value == "-1")
	{
		alert("Debe Seleccionar Periodo");
		Frm.CmbPeriodo.focus();
		return;
	}
	if (Frm.CmbCosto.value == "-1")
	{
		alert("Debe Seleccionar Centro Costo");
		Frm.CmbCCosto.focus();
		return;
	}
	if (Frm.CmbArea.value == "-1")
	{
		alert("Debe Seleccionar Area");
		Frm.CmbArea.focus();
		return;
	}
	if (Frm.CmbTipo.value == "-1")
	{
		alert("Debe Seleccionar Tipo");
		Frm.CmbTipo.focus();
		return;
	}
	if (Frm.CmbAgrupacion.value == "-1")
	{
		alert("Debe Seleccionar Agrupacion");
		Frm.CmbAgrupacion.focus();
		return;
	}
	if(Frm.CheckEnabal.checked)
	{
		Frm.action="cal_modificador_solicitud_proceso01.php?Sol="+NumSol +"&Proceso=M&Enabal=1";
		Frm.submit();
	}
	else
	{
		Frm.action="cal_modificador_solicitud_proceso01.php?Sol="+NumSol +"&Proceso=M&Enabal=2";
		Frm.submit();
	}
}	
function Salir()
{
	window.close();
}
function Recarga(S,P)
{
	var Opc='N';
	var Frm=document.FrmProceso;
	if (Frm.CheckEnabal.checked)
	{
		Frm.action="cal_modificador_solicitud_proceso.php?Sol="+S +"&Opc="+Opc +"&Proceso=M&Enabal=1";
		Frm.submit();
	}
	else
	{
		Frm.action="cal_modificador_solicitud_proceso.php?Sol="+S +"&Opc="+Opc +"&Proceso=M&Enabal=2";
		Frm.submit();
	}
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" background="../principal/imagenes/fondo3.gif" marginwidth="0" marginheight="0" >
<form name="FrmProceso" method="post" action="">
  <table width="750" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="730"><table width="733" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td colspan="2"><strong> 
              <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
		{
			$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
	
		}
		?>
              </strong> </td>
            <td>&nbsp;</td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> 
              </strong>&nbsp; <strong> 
              <?php
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td width="100">N&deg; Solicitud</td>
            <td> 
              <?php
			if ($Proceso=='M')
			{
				echo "<input name='NumSol' type='hidden'  style='width:100' value=".$NumSol.">";
            	echo $NumSol;
			}
			?>
            <td>IdMuestra</td>
            <td><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
              <?php
			if ($Proceso=='M')
			{
				echo "<input name='IdMuestra' type='text'  style='width:100' value='".$IdMuestra."'>";
            }
			?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td>Area</td>
            <td width="163"><strong>
              <select name="CmbArea" style="width:200">
                <option value ='-1' selected>Seleccionar</option>
                <?php
					$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase = 3 order by valor_subclase1 ";
					$Respuesta = mysql_query ($Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbArea == $Fila["cod_subclase"])
						{
							echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
						}	
					}
				?>
              </select>
              </strong> </td>
            <td width="95">Periodo</td>
            <td width="322"> <strong> 
              <select name="CmbPeriodo" style="width:130">
                <option value ='-1' selected>Seleccionar</option>
                <?php  
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 2 order by valor_subclase1";
				$Respuesta= mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($CmbPeriodo == $Fila["cod_subclase"])
					{
						echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
				}
			  ?>
              </select>
              </strong> </td>
          </tr>
          <tr> 
            <td>Agrupacion</td>
            <td> <strong>
              <select name="CmbAgrupacion">
                <option value="-1" selected>Seleccionar</option>
                <?php
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004  ";  
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbAgrupacion == $Fila["cod_subclase"])
					{
						echo "<option value= '".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
					}		
					else 
					{
						echo "<option value= '".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
					}
				}
				?>
              </select>
              </strong> 
            <td>Centro Costo 
            <td> <strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <select name="CmbCosto" style="width:260">
                <option value ='-1' selected>Seleccionar</option>
                <?php
				$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo where mostrar_calidad='S' order by centro_costo";
				$Respuesta = mysql_query ($Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCosto == $Fila[centro_costo])
					{
						echo "<option value = '".$Fila[centro_costo]."' selected>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}
					else
					{
						echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 					
					}		
				}
			?>
              </select>
              </strong></font></font> </strong> </tr>
          <tr> 
            <td>Producto</td>
            <td><font size="1"><font size="1"><font size="2"><strong>
              <select name="CmbProductos" style="width:250" onChange="Recarga('<?php echo $Sol;  ?>','<?php echo $Proceso;?>');">
                <option value='-1' selected>Seleccionar</option>
                <?php 
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
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
              </strong></font></font></font> </td>
            <td>SubProducto</td>
            <td><font size="1"><font size="1"><font size="1"><font size="2"><strong>
              <select name="CmbSubProducto" style="width:250">
                <option value="-1" selected>Seleccionar</option>
                <?php
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
				?>
              </select>
              </strong></font></font></font></font> </td>
          </tr>
          <tr> 
            <td height="22">Tipo</td>
            <td><font size="1"><font size="1"><font size="2"><strong>
              <?php
			echo "<select name='CmbTipo' style='width:110'>";
			echo "<option value='-1'>Seleccionar</option>";
			$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase=1005 order by cod_subclase";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($Fila["cod_subclase"]== $CmbTipo)
				{
					echo "<option value =".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";				
				}
				else
				{
					echo "<option value =".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";
				}	
			}
			echo "</select>";
			?>
              </strong></font></font></font></td>
            <td><font size="1"><font size="2">Enabal </font></font> </td>
            <td><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
              <?php
			 	if ($Enabal=="1")
				{ 
			  		echo "<input name='CheckEnabal' type='checkbox' id='CheckEnabal' value='checkbox' checked>";
              	}
				else
				{
					echo "<input name='CheckEnabal' type='checkbox' id='CheckEnabal' value='checkbox'>";
				}
			  ?>
              </strong></font></font></font><font size="2"><strong> </strong></font></font></font></font></td>
          </tr>
          <tr> 
            <td height="22">Fecha M</td>
            <td colspan="2"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <select name="CmbDias" id="select7" size="1" style="width:40px;">
                <?php
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			?>
              </select>
              </font> <font size="1"><font size="2"> 
              <select name="CmbMes" size="1" style="width:90px;">
                <?php
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
				   }
		  		 ?>
              </select>
              </font></font> <font size="2"> 
              <select name="CmbAno" size="1" style="width:70px;">
                <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAno))
					{
						if ($i==$CmbAno)
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}
					else
					{
						if ($i==date("Y"))
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}		
				}
			?>
              </select>
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"> 
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"> 
              <select name="CmbHora" id="select33">
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($CmbHora))
					{	
						if ($CmbHora == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </select>
              <strong>:</strong> 
              <select name="CmbMinutos">
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($CmbMinutos))
					{	
						if ($CmbMinutos == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </select>
              </font></font></td>
            <td><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong></font></font></font></td>
          </tr>
          <tr> 
            <td height="66">Obs</td>
            <td colspan="3"><textarea name="Observacion" cols="74" rows="2" wrap="VIRTUAL"><?php echo $Observacion; ?></textarea></td>
          </tr>
        </table>
        <br>
        <table width="733" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="713"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" onClick="Grabar('<?php echo $NumSol; ?>');"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>

