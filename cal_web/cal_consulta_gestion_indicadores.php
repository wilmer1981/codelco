<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 73;

	$CookieRut=$_COOKIE["CookieRut"];

	if(isset($_REQUEST["LimitFinAux"])) {
		$LimitFinAux = $_REQUEST["LimitFinAux"];
	}else{
		$LimitFinAux = 50;
	}
	if(isset($_REQUEST["Opc"])) {
		$Opc = $_REQUEST["Opc"];
	}else{
		$Opc = 1;
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes=date("n");
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno=date("Y");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT=date("n");
	}
	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT = date("Y");
	}
	if(isset($_REQUEST["CmbProductos"])) {
		$CmbProductos = $_REQUEST["CmbProductos"];
	}else{
		$CmbProductos ="";
	}
	if(isset($_REQUEST["CmbSubProducto"])) {
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto ="";
	}
	if(isset($_REQUEST["CmbTipo"])) {
		$CmbTipo = $_REQUEST["CmbTipo"];
	}else{
		$CmbTipo ="";
	}
	if(isset($_REQUEST["CmbTipoAnalisis"])) {
		$CmbTipoAnalisis = $_REQUEST["CmbTipoAnalisis"];
	}else{
		$CmbTipoAnalisis ="";
	}
	if(isset($_REQUEST["CmbLeyes"])) {
		$CmbLeyes = $_REQUEST["CmbLeyes"];
	}else{
		$CmbLeyes = "";
	}
	if(isset($_REQUEST["CmbUnidad"])) {
		$CmbUnidad = $_REQUEST["CmbUnidad"];
	}else{
		$CmbUnidad = "";
	}
	if(isset($_REQUEST["Tipo"])) {
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
	}
	if(isset($_REQUEST["Msj"])) {
		$Msj = $_REQUEST["Msj"];
	}else{
		$Msj = "";
	}
	if(isset($_REQUEST["Busq"])) {
		$Busq = $_REQUEST["Busq"];
	}else{
		$Busq = "";
	}
	 


include("../principal/conectar_principal.php");

$meses = array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila  = mysqli_fetch_array($Respuesta);
$Nivel = $Fila["nivel"];




?>
<html>
<head>
<script language="JavaScript">
function Recarga3()
{
	var Frm = document.FrmConsultaGestionInd;

	Frm.action="cal_consulta_gestion_indicadores.php?Busq=S";
	Frm.submit();	
}
function Recarga(Opcion)
{
	var Frm=document.FrmConsultaGestionInd;
	Frm.action="cal_consulta_gestion_indicadores.php?Opc=1";
	Frm.submit();

}
function Proceso(Opcion,Tipo)
{
	var Frm=document.FrmConsultaGestionInd;
	var Producto="";
	var SubProducto="";
 	if (Frm.CmbProductos.value == "-1")
	{
		alert ("Debe Seleccionar Producto");
		Frm.CmbProductos.focus();
		return;
	}
	if (Frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Seleccionar SubProducto");
		Frm.CmbSubProducto.focus();
		return;
	}
	if (Frm.CmbLeyes.value=="-1")
	{
		alert ("Debe Seleccionar Ley");
		Frm.CmbLeyes.focus();
		return;
	} 
	if (Frm.CmbUnidad.value=="-1")
	{
		alert ("Debe Seleccionar Unidad");
		Frm.CmbUnidad.focus();
		return;
	} 

	Frm.Tipo.value=Tipo;
	Frm.action= "cal_consulta_gestion_indicadores_respuesta_grafico.php";
	Frm.submit();
	
}
function Salir()
{
	var Frm=document.FrmConsultaGestionInd;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}


</script>
<title>Consulta Gesti&oacute;n Indicadores </title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0"> 
<form name="FrmConsultaGestionInd" method="get" action="">
<input type="hidden" name="Tipo" value="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="761" align="center" valign="middle"><table width="755" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
        <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
          <td colspan="4">CONSULTA GESTI&Oacute;N INDICADORES </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="11%"> Producto:</td>
          <td colspan="3" align="left" bgcolor="#efefef"><select name="CmbProductos" style="width:250" onChange="Recarga();" <?php if ($Opc!=1) echo "Disabled";?>>
              <option value="-1" selected>Seleccionar</option>
            <?php
				if ($Opc=="1")
				{
					
					$Consulta="select STRAIGHT_JOIN t1.cod_producto,t1.descripcion from proyecto_modernizacion.productos t1 inner join cal_web.gestion_indicadores t2 on t1.cod_producto=t2.cod_producto group by t2.cod_producto order by descripcion"; 
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
				}
		
		    ?>
            </select>          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>SubProducto:</td>
          <td colspan="3" bgcolor="#efefef"><select name="CmbSubProducto"  onChange="Recarga();"  style="width:250" <?php if ($Opc!=1) echo "disabled"; ?>>
            <?php
				if ($Opc=="1")
				{
					
					echo "<option value='-1' selected>Seleccionar</option>";
					$Consulta="select STRAIGHT_JOIN t1.cod_subproducto,t1.descripcion from proyecto_modernizacion.subproducto t1 inner join cal_web.gestion_indicadores t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto "; 
					$Consulta.=" where t2.cod_producto = '".$CmbProductos."' group by t2.cod_producto,t2.cod_subproducto order by descripcion ";
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
				}
				else
				{
					echo "<option value='-1' selected>Seleccionar</option>";					
				}			
		    ?>
          </select></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>Ley</td>
          <td colspan="3" bgcolor="#efefef"><select name="CmbLeyes" onChange="Recarga();"  style="width:250" <?php if ($Opc!=1) echo "Disabled";?>>
              <option value="-1" selected>Seleccionar</option>
            <?php
				if ($Opc=="1")
				{
					
					$Consulta="select STRAIGHT_JOIN t1.cod_leyes,t1.nombre_leyes from proyecto_modernizacion.leyes t1 inner join cal_web.gestion_indicadores t2 on  t1.cod_leyes=t2.cod_leyes  "; 
					$Consulta.=" where t2.cod_producto = '".$CmbProductos."' and t2.cod_subproducto='".$CmbSubProducto."' group by t2.cod_leyes order by t1.nombre_leyes ";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbLeyes==$Fila["cod_leyes"])
						{
							echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["nombre_leyes"]))."</option>\n";
						}
						else
						{
							echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["nombre_leyes"]))."</option>\n";
						}
					}
				}
		
		    ?>
            </select>			  </td>
        </tr>
		 <tr bgcolor="#FFFFFF">
    <td >Unidad</td>
    <td colspan="3" >
	<select name="CmbUnidad" >
      <option value="-1" selected>Seleccionar</option>
      <?php
			$Consulta="select STRAIGHT_JOIN t1.cod_unidad,t1.nombre_unidad,t1.abreviatura from proyecto_modernizacion.unidades t1 "; 
			$Consulta.=" inner join cal_web.gestion_indicadores t2 on  t1.cod_unidad=t2.cod_unidad  "; 
			$Consulta.=" where t2.cod_producto = '".$CmbProductos."' and t2.cod_subproducto='".$CmbSubProducto."' and t2.cod_leyes='".$CmbLeyes."' group by t2.cod_leyes order by t1.nombre_unidad ";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbUnidad == $Fila["cod_unidad"])
					echo "<option value = '".$Fila["cod_unidad"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
				else
					echo "<option value = '".$Fila["cod_unidad"]."'>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";
			}
		?>
    </select>	</td>
    </tr>
		
        <tr bgcolor="#FFFFFF">
          <td>Tipo Muestra:</td>
          <td width="6%" colspan="1" bgcolor="#efefef"><?php					
					echo "<select name='CmbTipo' style='width:110'>";
					echo "<option value='-1' selected>Todos</option>";
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
          <td width="13%">Tipo&nbsp;Analisis:</td>
          <td width="39%" bgcolor="#efefef"><?php 
					echo "<select name='CmbTipoAnalisis' style='width:120'>";
					echo "<option value = '-1' selected>Todos</option>\n";
					$Consulta= "select * from sub_clase where cod_clase = 1000";
					$Respuesta= mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbTipoAnalisis == $Fila["cod_subclase"])
						{
							echo "<option value ='".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 			
						}
						else			
						{	
							if ($Fila["cod_subclase"]=='1')
							{
								echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}
							else
							{
								echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}
						}
					}
			?>          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="26" align="left">Fecha Inicio:</td>
          <td colspan="1" bgcolor="#efefef"><?php
				//if (($CmbPeriodo=='1')||($CmbPeriodo=='2')||($CmbPeriodo=='3'))
				//{

					echo"<select name='CmbMes'>";
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
					echo "</select>";
					echo "<select name='CmbAno'>";
						for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
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
	    			echo "</select>&nbsp;&nbsp;";
					?>          </td>
          <td>Fecha&nbsp;Termino:</td>
          <td bgcolor="#efefef"><?php
					
				  echo "<select name='CmbMesT'>";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
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
				   echo "</select>";
				   echo "<select name='CmbAnoT'>";
				   for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAnoT))
						{
							if ($i==$CmbAnoT)
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
				  echo "</select>";
				?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="30" colspan="4" align="center"><span class="InputRojo">El rango de fechas no Puede Exceder a 6 meses, por tiempo de respuesta.</span> </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="Detalle02">
          <td height="30" colspan="4" align="center">
		  <input name="BtnImprimir" type="button" value="Graficar CPK" style="width:80" onClick="Proceso('L','CPK');">&nbsp;&nbsp;<input name="BtnImprimir" type="button" value="Graficar CV" style="width:70" onClick="Proceso('L','CV');">
            &nbsp;&nbsp;
            <input name="BtnSalir" type="button" value="Salir" style="width:80" onClick="Salir();">          </td>
        </tr>
        <br>
      </table>
      <table>
	  <TR>
	  <TD>
	  <?php 
	if($Msj=='S')
	{
	?>
	<script>
		alert("Verifique el Rango de Fechas, NO puede exceder a 6 Meses ")
	</script>
	<?php
	}
	

  ?>
	  
	  </TD>
	  
	  </TR>
	  
	  </table>
	  
	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
