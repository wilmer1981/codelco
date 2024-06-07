<?php
$CodigoDeSistema = 1;
$CodigoDePantalla = 79;
$CookieRut= $_COOKIE["CookieRut"];
include("../principal/conectar_principal.php");

$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$HoraActual = date("H");
$MinutoActual = date("i");

if(isset($_REQUEST["M"])) {
	$M = $_REQUEST["M"];
}else{
	$M = "";
}
if(isset($_REQUEST["Msj"])) {
	$Msj = $_REQUEST["Msj"];
}else{
	$Msj = "";
}
if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos = "";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto = "";
}
if(isset($_REQUEST["CmbLeyes"])) {
	$CmbLeyes = $_REQUEST["CmbLeyes"];
}else{
	$CmbLeyes = "";
}
if(isset($_REQUEST["Buscar"])) {
	$Buscar = $_REQUEST["Buscar"];
}else{
	$Buscar = "";
}


?>
<html>
<head>
<title>Clasificacion Metodos Plasma</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.MetodoPLasma;
	switch (Opcion)
	{
		case "N"://procesa excel
			URL="cal_clasificacion_metodos_plasma_proceso.php?Opc=N";
			opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=300,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			break;
		case "M"://procesa excel
			var	Valores='';
			for(i=0;i<frm.elements.length;i++)
			{
				if(frm.elements[i].checked==true && frm.elements[i].name=='Seleccion')
					Valores=frm.elements[i].value;
			}
			if(Valores=='')
			{
				alert('Debe Seleccionar un Elemento');
				return;
			}
			URL="cal_clasificacion_metodos_plasma_proceso.php?Opc=M&Valores="+Valores;
			opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=300,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			break;
		case "S":
			frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
			frm.submit(); 
		break;
		case "R"://recarga pagina
			frm.action ="cal_clasificacion_metodos_plasma.php";  
			frm.submit();
		break;
	}	
}
function Mensaje(Msj,Can)
{
	if(Msj=='E')
	{
		alert('Registro Eliminado con Exito.');
		return;
	}
	if(Msj=='G')
	{
		alert('Registro(s) Ingresado(s) con Exito');
		return;
	}
}
</script></head>
<body onLoad="Mensaje('<?php echo $Msj;?>')" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" enctype="multipart/form-data" name="MetodoPLasma">
  <?php include("../principal/encabezado.php")?>
  <table width="56.7%"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td> <table width="758" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="97" height="26">Producto</td>
            <td width="344" height="26"><font size="1"><font size="1"><font size="2"><strong>
              <select name="CmbProductos" style="width:280" onChange="Proceso('R')">
                <option value='T' selected>Todos</option>
                <?php 					
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						else
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				?>
              </select>
            </strong></font></font></font>&nbsp;</td>
            <td width="296" height="26">&nbsp;</td>
          </tr>
          <tr>
            <td height="26">Subproducto</td>
            <td height="26"><font size="1"><font size="2"><strong>
              <select name="CmbSubProducto" style="width:280" onChange="Proceso('R')">
                <option value="T" selected>Todos</option>
                <?php
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						else
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				?>
              </select>
            </strong></font></font></td>
            <td height="26">&nbsp;</td>
          </tr>
          <tr>
            <td height="26">Ley</td>
            <td height="26"><select name="CmbLeyes" style="width:200" >
              <option value="T" selected>Todos</option>
              <?php
					$Consulta="select t1.cod_leyes,abreviatura from proyecto_modernizacion.leyes t1";
					$Consulta.=" inner join cal_web.clasificacion_metodos_plasma t2 on t1.cod_leyes=t2.cod_leyes";
					$Consulta.=" and t2.cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."' group by t2.cod_leyes order by t1.nombre_leyes"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbLeyes == $Fila["cod_leyes"])
							echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
						else
							echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";
					}
				?>
            </select><?php //echo $Consulta;?><input name="BtnBuscar" type="Button" style="width:70" value="Buscar" onClick="Proceso('R');"></td>
            <td height="26" align="right">
			  
			  <input name="BtnBuscar" type="Button" style="width:70" value="Nuevo" onClick="Proceso('N');">
              <input name="BtnBuscar" type="Button" style="width:80" value="Modif/Elim" onClick="Proceso('M');">
              <input name="BtnBuscar2" type="Button" style="width:50" value="Salir" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br>
		  <?php
		  if($M=='S')
		  {	
		  ?>
		  <?php
		 }
		 ?>
          <br>
		<?php
		?>
        <table width="600px" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td align="center"> - </td>
            <td width="120px"><div align="center">Producto</div></td>
            <td width="120px"><div align="center">SubProducto</div></td>
            <td width="200px">Leyes</td>
            <td width="20px">Unidad</td>
            <td width="20px">Signo</td>
            <td width="10px">Valor</td>
          </tr>
          <?php
			$Consulta="select *,t2.descripcion as nom_producto,t3.descripcion as nom_subproducto,t4.abreviatura as NomUnidad from cal_web.clasificacion_metodos_plasma t1 ";
			$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
			$Consulta.=" inner join proyecto_modernizacion.unidades t4 on t1.cod_unidad=t4.cod_unidad";
			$Consulta.=" where t1.cod_producto<>''";
			if($CmbProductos!='T')
				$Consulta.=" and t1.cod_producto='".$CmbProductos."'";
			if($CmbSubProducto!='T')
				$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."'";
			if($CmbLeyes!='T')
				$Consulta.=" and t1.cod_leyes='".$CmbLeyes."'";
			$Consulta.=" group by t1.cod_producto,t1.cod_subproducto,t1.cod_unidad,t1.signo,t1.valor";
			//echo $Consulta;
			$Resp=mysqli_query($link, $Consulta);
			while($Filas=mysqli_fetch_assoc($Resp))
			{
				$Consulta3="select t2.abreviatura from cal_web.clasificacion_metodos_plasma t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes";
				$Consulta3.=" where t1.cod_producto='".$Filas["cod_producto"]."' and t1.cod_subproducto='".$Filas["cod_subproducto"]."' and t1.cod_unidad='".$Filas["cod_unidad"]."' and t1.signo='".$Filas["signo"]."' and t1.valor='".$Filas["valor"]."'";
				$Resp3=mysqli_query($link, $Consulta3);$Cantidad=0;$Leyes='';
				while($Filas3=mysqli_fetch_assoc($Resp3))
					$Leyes=$Leyes.$Filas3["abreviatura"].",";				
				if($Leyes !='')
					$Leyes=substr($Leyes,0,strlen($Leyes)-1);		
				?>
				<tr>
				<td ><input type="radio" name="Seleccion" value="<?php echo $Filas["cod_producto"]."~".$Filas["cod_subproducto"]."~".$Filas["cod_unidad"]."~".$Filas["signo"]."~".$Filas["valor"];?>"></td>
				<td ><?php echo $Filas["nom_producto"];?></td>
				<td ><?php echo $Filas["nom_subproducto"];?>&nbsp;</td>
				<td ><?php echo $Leyes;?>&nbsp;</td>
				<td  align="center"><?php echo $Filas["NomUnidad"];?>&nbsp;</td>
				<td  align="center"><?php echo $Filas["signo"];?>&nbsp;</td>
				<td align="left"><?php echo $Filas["valor"];?>&nbsp;</td>
				</tr>
				<?php
				/*$Consulta3="select unidad from cal_web.tmp_espectroplasma  where rut='".$CookieRut."' and SA='".$Filas[SA]."' group by unidad";
				$Resp3=mysqli_query($link, $Consulta3);$Cantidad=0;
				while($Filas3=mysqli_fetch_assoc($Resp3))
				{
					?>
					<td><?php echo $Filas3["unidad"];?></td>
					<?php
					$ConsultaB="select ley from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' group by ley order by abreviatura";
					$RespB=mysqli_query($link, $ConsultaB);
					while($FilasB=mysqli_fetch_assoc($RespB))
					{
						$Consulta4="select valor from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' and SA='".$Filas[SA]."' and unidad='".$Filas3["unidad"]."' and ley='".$FilasB[ley]."' group by ley order by abreviatura";
						$Resp4=mysqli_query($link, $Consulta4);
						if($Filas4=mysqli_fetch_assoc($Resp4))
						{
							?>
							<td align="right"><?php echo $Filas4["valor"];?></td>
							<?php
						}
						else
						{
							?>
							<td>&nbsp;</td>
							<?php
						}
					}
					?></tr><?php
				}	*/
			}		  	
		  ?>
        </table>
		<br>
	  <br></td>
    </tr>
  </table>
  
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
