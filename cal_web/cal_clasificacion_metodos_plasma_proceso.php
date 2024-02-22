<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Opc"])) {
		$Opc = $_REQUEST["Opc"];
	}else{
		$Opc="";
	}
	if(isset($_REQUEST["Msj"])) {
		$Msj = $_REQUEST["Msj"];
	}else{
		$Msj = "";
	}

	if(isset($_REQUEST["Valores"])) {
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
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
	if(isset($_REQUEST["CmbProveedores"])) {
		$CmbProveedores = $_REQUEST["CmbProveedores"];
	}else{
		$CmbProveedores='T';
	}
	if(isset($_REQUEST["CmbUnidad"])) {
		$CmbUnidad = $_REQUEST["CmbUnidad"];
	}else{
		$CmbUnidad = "";
	}
	if(isset($_REQUEST["Signo"])) {
		$Signo = $_REQUEST["Signo"];
	}else{
		$Signo = "";
	}
	if(isset($_REQUEST["Valor"])) {
		$Valor = $_REQUEST["Valor"];
	}else{
		$Valor = "";
	}

	if(isset($_REQUEST["Proc"])) {
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = "";
	}
	if(isset($_REQUEST["NewRec"])) {
		$NewRec = $_REQUEST["NewRec"];
	}else{
		$NewRec = "";
	}
	if(isset($_REQUEST["TipoConsulta"])) {
		$TipoConsulta = $_REQUEST["TipoConsulta"];
	}else{
		$TipoConsulta = "";
	}
	

	if($Opc=='M')
	{
		$Dato=explode("~",$Valores);
		$Consulta="SELECT * from cal_web.limite where cod_producto='".$Dato[0]."' and cod_subproducto='".$Dato[1]."'";
		if($Dato[0]=='1')
			$Consulta.=" and rut_proveedor='".$Dato[2]."'";
		$Consulta.=" and cod_ley='".$Dato[3]."'";	
		$Respuesta = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$CmbProductos=$Fila["cod_producto"];
			$CmbSubProducto=$Fila["cod_subproducto"];
			$CmbProveedores=$Fila["rut_proveedor"];
			$CmbLeyes=$Fila["cod_ley"];
			$LimitIni=$Fila["limite_inicial"];
			$LimitFin=$Fila["limite_final"];
			$CmbUnidad=$Fila["unidad"];
		}
	}
?>
<html>
<head>
<?php
  if($Opc=='N')
	echo "<title>Nuevo Metodo PLasma</title>";
  else
  	echo "<title>Modificar Metodo PLasma</title>";	
?>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Elimina(Valor)
{
	var f = document.frmProceso;
	var mensaje=confirm('�Esta Seguro de Eliminar Registro?');
	if(mensaje==true)
	{
		f.action = "cal_clasificacion_metodos_plasma_proceso01.php?Opcion=E&Valor="+Valor;
		f.submit();
	}
}
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "N":
			if(f.CmbProductos.value=='-1')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProductos.focus();
				return;
			}
			if(f.CmbSubProducto.value=='-1')
			{
				alert("Debe Seleccionar Subproducto");
				f.CmbSubProducto.focus();
				return;
			}
			if(f.CmbLeyes.value=='-1')
			{
				alert("Debe Seleccionar Ley");
				f.CmbLeyes.focus();
				return;
			}
			if(f.CmbUnidad.value=='-1')
			{
				alert("Debe Seleccionar Unidad");
				f.CmbUnidad.focus();
				return;
			}
			if(f.Signo.value=='-1')
			{
				alert("Debe Seleccionar Signo")
				f.Signo.focus();
				return;
			}
			if(f.Valor.value=='')
			{
				alert("Debe Ingresar Valor")
				f.Valor.focus();
				return;
			}
			f.action = "cal_clasificacion_metodos_plasma_proceso01.php?Opcion="+opt;
			f.submit();
			break;
		case "M":
			if(SoloUnElemento(f.name,'Seleccion1','E'))			
			{
				Datos=Recuperar(f.name,'Seleccion1');
				var Valores='';
				for(i=0;i<f.elements.length;i++)
				{
					if(f.elements[i].checked==true && f.elements[i].name=='Seleccion1')
						Valores=Valores+f.elements[i].value+"~"+f.elements[i+2].value+"//";
				}
				Valores=Valores.substr(0,Valores.length-2);
				f.action = "cal_clasificacion_metodos_plasma_proceso01.php?Opcion="+opt+"&Valores2="+Valores;
				f.submit();
			}
			break;
		case "R"://recarga pagina
			f.action ="cal_clasificacion_metodos_plasma_proceso.php?Opc=N";  
			f.submit();
		break;
		case "S": //Cancelar	
			window.opener.document.MetodoPLasma.action="cal_clasificacion_metodos_plasma.php?Buscar=S";
			window.opener.document.MetodoPLasma.submit();		
			window.close();	
		break
	}
}
function Recuperar(f,inputchk,niv,rutc)
{
	var Valores="";
	var Encontro=false;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			if(niv=='4')
			{
				if(eval("document."+f+".elements["+i+2+"].value")==rutc)
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
//				alert(eval("document."+f+".elements["+i+2+"].value"));
				}
				else
				{
					alert("Ud No tiene Acceso a Modificar el Requerimiento");
					Valores="";
				}
			}
			else
			{
				if(niv=='AN')
				{
					if((eval("document."+f+"."+inputchk+"["+i+"].checked")) == true)
					{
						Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) + "~"+ (eval("document."+f+"."+inputchk+"["+i+"].value")) + "//" ;
						//Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))+ "~" + "A" + "//" ;
						Encontro=true;
					}
				}
				else
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))  + "~"+ (eval("document."+f+"."+inputchk+"["+i+"].value"))+ "//" ;
					Encontro=true;
				}
			}
		}
		else
		{
			if(niv=='AN')
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))  + "~"+ (eval("document."+f+"."+inputchk+"["+i+"].value"))+ "//" ;
				Encontro=true;
			}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function SoloUnElemento(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
	}
	if (Opc=='M')
	{
		if (CantCheck > 1 ||CantCheck==0)
		{
			if(CantCheck==0)
				alert("Debe Seleccionar un Elemento");
			else
				alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
			return(true);
	}
	else
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			return(true);			
	}
}
function SoloNumerosyNegativo(PermiteDecimales,f) 
{ 
	var teclaCodigo = event.keyCode; 
	
	//alert(event.keyCode);
	if (PermiteDecimales==true)
	{
		if(teclaCodigo==110)
		{
		   event.keyCode=46;
		   f.value=f.value+",";
		}
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 109 )&&(teclaCodigo != 189 ))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}
	else
	{
		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}	
}
function Mensaje(Msj)
{
	if(Msj=='Exis')
	{
		alert('Registro Existe, Revisar en Listado.');
		return;
	}
	if(Msj=='M')
	{
		alert('Registro Modificado con Exito.');
		return;
	}
	if(Msj=='E')
	{
		alert('Registro Eliminado con Exito.');
		return;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body onLoad="Mensaje('<?php echo $Msj;?>')">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
  <?php
  if($Opc=='N')
  {
  ?>
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><?php
	  if($Opc=='N')
	  	$Nom='Nuevo';
	  else
	  	$Nom='Modificar';
	echo 	$Nom." Dato(s)";		
	?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td width="92" class="Colum01">Producto</td>
	<td class="Colum01"><font size="1"><font size="1"><font size="2"><strong>
	  <select name="CmbProductos" style="width:280" onChange="Proceso('R')">
        <option value='-1' selected>Seleccionar</option>
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
	</strong></font></font></font></td>	
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Subproducto</td>
    <td class="Colum01"><font size="1"><font size="2"><strong>
      <select name="CmbSubProducto" style="width:280" onChange="Proceso('R')">
        <option value="-1" selected>Seleccionar</option>
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
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Ley</td>
    <td class="Colum01"><font size="1"><font size="2"><strong>
	<select name="CmbLeyes" style="width:100" >
      <option value="-1" selected>Seleccionar</option>
      <?php
			$Consulta="select cod_leyes,nombre_leyes,cod_unidad,abreviatura from proyecto_modernizacion.leyes order by nombre_leyes"; 
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbLeyes == $Fila["cod_leyes"])
				{
					$CmbUnidad=$Fila["cod_unidad"];
					echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
				}
				else
					echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";
			}
		?>
    </select>	  
	</strong></font></font></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Unidad</td>
    <td class="Colum01"><font size="1"><font size="2"><strong>
	<select name="CmbUnidad" style="width:100">
      <option value="-1" selected>Seleccionar</option>
      <?php
			$Consulta="select cod_unidad,nombre_unidad,abreviatura from proyecto_modernizacion.unidades order by nombre_unidad"; 
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbUnidad == $Fila["cod_unidad"])
					echo "<option value = '".$Fila["cod_unidad"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
				else
					echo "<option value = '".$Fila["cod_unidad"]."'>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";
			}
		?>
    </select>
	</strong></font></font></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Signo</td>
    <td class="Colum01"><label>
	<select name="Signo">
	<?php
	switch($Signo)
	{
		case "=":
			echo "<option value='-1'>Seleccionar</option>;";
			echo "<option value='=' selected>=</option>;";
			echo "<option value='<'><</option>;";
			echo "<option value='>'>></option>;";
		break;
		case "<":
			echo "<option value='-1'>Seleccionar</option>;";
			echo "<option value='='>=</option>;";
			echo "<option value='<' selected><</option>;";
			echo "<option value='>'>></option>;";
		break;
		case ">":
			echo "<option value='-1'>Seleccionar</option>;";
			echo "<option value='='>=</option>;";
			echo "<option value='<'><</option>;";
			echo "<option value='>' selected>></option>;";
		break;
		default:
			echo "<option value='-1' selected>Seleccionar</option>;";
			echo "<option value='='>=</option>;";
			echo "<option value='<'><</option>;";
			echo "<option value='>'>></option>;";
		break;
	}
	?>
	</select>
    </label></td>					
    </tr>
  <tr class="Colum01">
    <td align="left" class="Colum01">Valor</td>
    <td align="left" class="Colum01"><input name="Valor" type="text" onKeyDown="SoloNumerosyNegativo(true,this)" id="Valor" value="<?php echo $Valor?>"></td>
  </tr>
  </table>
	  <table width="550px" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
	  <tr class="ColorTabla01"> 
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
			$Consulta.=" and t1.cod_producto='".$CmbProductos."'";
			$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."'";
			$Consulta.=" group by t1.cod_producto,t1.cod_subproducto,t1.cod_unidad,t1.signo,t1.valor";
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
					<td><?php echo $Filas3[unidad];?></td>
					<?php
					$ConsultaB="select ley from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' group by ley order by abreviatura";
					$RespB=mysqli_query($link, $ConsultaB);
					while($FilasB=mysqli_fetch_assoc($RespB))
					{
						$Consulta4="select valor from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' and SA='".$Filas[SA]."' and unidad='".$Filas3[unidad]."' and ley='".$FilasB[ley]."' group by ley order by abreviatura";
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
  <?php
  }
  else
  {
  $Datos=explode('~',$Valores);
  $CmbProductos=$Datos[0];
  $CmbSubProductos=$Datos[1];
  $Unidad=$Datos[2];
  $Signo=$Datos[3];
  $Valor=$Datos[4];
  ?>
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <input type="hidden" name="ValoresMOD" value="<?php echo $Valores;?>">
  <tr class="ColorTabla01">
    <td colspan="6"><?php
	  if($Opc=='N')
	  	$Nom='Nuevo';
	  else
	  	$Nom='Modificar';
	echo 	$Nom." Dato(s)";		
	?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01" colspan="2">Producto</td>
	<td class="Colum01" colspan="4"><font size="1"><font size="1"><font size="2"><strong>
	<?php 					
		$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos where cod_producto = '".$CmbProductos."' order by descripcion"; 
		$Respuesta = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
				echo ucwords(strtolower($Fila["descripcion"]));
	?>
	</strong></font></font></font></td>	
    </tr>
  <tr class="Colum01">
    <td class="Colum01" colspan="2">Subproducto</td>
    <td class="Colum01" colspan="4"><font size="1"><font size="2"><strong>
	<?php
	$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and cod_subproducto='".$CmbSubProductos."' order by descripcion"; 
	$Respuesta = mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
		echo ucwords(strtolower($Fila["descripcion"]));				
	?>
    </strong></font></font></td>
    </tr>
		<tr class="ColorTabla01">
		<td width="35">Mod.</td>
		<td width="36">Elim.</td>
		<td width="162">Ley</td>
		<td >Unidad</td>
		<td >Signo</td>
		<td width="120">Valor</td>
		</tr>
	<?php
		$Consulta3="select *,t2.abreviatura as nomLey,t5.abreviatura as nomUNidad from cal_web.clasificacion_metodos_plasma t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes";
		$Consulta3.=" inner join proyecto_modernizacion.productos t3 on t1.cod_producto=t3.cod_producto";
		$Consulta3.=" inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto";
		$Consulta3.=" inner join proyecto_modernizacion.unidades t5 on t1.cod_unidad=t5.cod_unidad";
		$Consulta3.=" where t1.cod_producto='".$CmbProductos."' and t1.cod_subproducto='".$CmbSubProductos."' and t1.cod_unidad='".$Unidad."' and t1.signo='".$Signo."' and t1.valor='".$Valor."'";
		echo "<input name='Seleccion1' type='hidden'  value=''>";
		echo "<input name='Seleccion2' type='hidden'  value=''>";
		$Resp3=mysqli_query($link, $Consulta3);$Cantidad=0;$Leyes='';
		while($Filas3=mysqli_fetch_assoc($Resp3))
		{
			?>
				<tr>
				<td width="35"><input type="checkbox" name="Seleccion1" value="<?php echo $CmbProductos."~".$CmbSubProductos."~".$Filas3["cod_leyes"];?>"></td>
				<td width="36" align="center">
				<input name="BtnSalir" type="button" id="BtnSalir" value="X" style="width:20px " onClick="Elimina('<?php echo $CmbProductos."~".$CmbSubProductos."~".$Filas3["cod_leyes"]."~".$Filas3["cod_unidad"]."~".$Filas3["signo"]."~".$Filas3["valor"];?>')">
				</td>
				<td width="162"><?php echo $Filas3["nomLey"];?></td>
				<td ><?php echo $Filas3["nomUNidad"];?></td>
				<td ><?php echo $Filas3["signo"];?></td>
				<td width="120"><input type="text" name="Valores" onKeyDown="SoloNumerosyNegativo(true,this)" value="<?php echo $Filas3["valor"];?>"></td>
				</tr>
			<?php	
			$Cantidad++;	
		}
  }
  ?>
  <input type="hidden" name="CantidadLeyes" value="<?php echo $Cantidad;?>">
</table>
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="Colum01">
    <td colspan="2" align="center" class="Colum01">
	<?php
  	if($Opc=='N')
	{	
	?>
		<input name="BtnGuardar" type="button" id="BtnGuardar" value="Grabar" style="width:70px " onClick="Proceso('<?php echo $Opc;?>')">
	<?php
	}
	else
	{
	?>
		<input name="BtnGuardar" type="button" id="BtnGuardar" value="Modificar Dato" style="width:100px " onClick="Proceso('M')">
	<?php
	}
	?>
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
</form>
</body>
</html>
