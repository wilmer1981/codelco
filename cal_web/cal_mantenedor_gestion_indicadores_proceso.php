<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Opc"])) {
		$Opc = $_REQUEST["Opc"];
	}else{
		$Opc = "";
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
	if(isset($_REQUEST["TxtValor"])) {
		$TxtValor = $_REQUEST["TxtValor"];
	}else{
		$TxtValor = 0;
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
		$Consulta="select * from cal_web.gestion_indicadores where cod_producto='".$Dato[0]."' and cod_subproducto='".$Dato[1]."'";
		$Consulta.=" and cod_leyes='".$Dato[2]."'";	
		$Respuesta = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$CmbProductos=$Fila["cod_producto"];
			$CmbSubProducto=$Fila["cod_subproducto"];
			$CmbLeyes=$Fila["cod_leyes"];
			$TxtValor=$Fila["valor"];
			$CmbUnidad=$Fila["cod_unidad"];
		}
	}
?>
<html>
<head>
<?php
  if($Opc=='N')
	echo "<title>Nuevo Gestión de Indicadores</title>";
  else
  	echo "<title>Modificar Gestión de Indicadores</title>";	
?>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
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
					
			if(f.TxtValor.value=='')
			{
				alert("Debe Ingresar Valor")
				f.TxtValor.focus();
				return;
			}
			
			f.action = "cal_mantenedor_gestion_indicadores_proceso01.php?Proceso="+opt;
			f.submit();
			break;
		case "M":
			
			if(f.TxtValor.value=='')
			{
				alert("Debe Ingresar Valor ")
				f.TxtValor.focus();
				return;
			}
		
			f.action = "cal_mantenedor_gestion_indicadores_proceso01.php?Proceso="+opt;
			f.submit();
			break;
		case "R"://recarga pagina
			f.action ="cal_mantenedor_gestion_indicadores_proceso.php?Opc=N";  
			f.submit();
		break;
		case "S": //Cancelar	
			window.opener.document.FrmPrincipal.action="cal_mantenedor_gestion_indicadores.php?Buscar=S";
			window.opener.document.FrmPrincipal.submit();		
			window.close();	
		break
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
function str_replace (search, replace, subject, count) 
{
	f = [].concat(search),
	r = [].concat(replace),
	s = subject,
	ra = r instanceof Array, sa = s instanceof Array;    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }
     for (i=0, sl=s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j=0, fl=f.length; j < fl; j++) {            temp = s[i]+'';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length-s[i].length)/f[j].length;}        }
    }
    return sa ? s : s[0];
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
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><?php
	  if($Opc=='N')
	  	$Nom='Nuevo';
	  else
	  	$Nom='Modificar';		
	  echo  $Nom." Gestión de Indicadores";	
	?></td>
  </tr>
  <tr class="Colum01">
    <td width="92" class="Colum01">Producto</td>
	<td class="Colum01"><font size="1"><font size="1"><font size="2"><strong>
	<?php
	  if($Opc=='N')
	  {
	?>
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
	<?php
	  }
	  else
	  {
			$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos where cod_producto='".$CmbProductos."' order by cod_producto,descripcion"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
				echo $Fila["descripcion"];
			echo "<input type='hidden' name='CmbProductos' value='".$CmbProductos."'>";	
	  }	
	?>  
	</strong></font></font></font></td>	
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Subproducto</td>
    <td class="Colum01"><font size="1"><font size="2"><strong>
	<?php
	  if($Opc=='N')
	  {
	?>
      <select name="CmbSubProducto" style="width:280">
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
	 <?php
	   }
	   else
	   {
			$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'  and cod_subproducto = '".$CmbSubProducto."'"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
				echo $Fila["descripcion"];
			echo "<input type='hidden' name='CmbSubProducto' value='".$CmbSubProducto."'>";	
	   }
	 ?> 
    </strong></font></font></td>
    </tr>
	<?php
	 if($CmbProductos=='1')
	 {	
	?>
   <?php
    }
   ?>
   <tr class="Colum01">
     <td class="Colum01">Ley</td>
     <td class="Colum01"><font size="1"><font size="2"><strong>
       <?php
	 if($Opc=='N')
	 {
	?>
       <select name="CmbLeyes" style="width:200" onChange="Proceso('R')">
         <option value="-1" selected>Seleccionar</option>
         <?php
			$Consulta="SELECT cod_leyes,nombre_leyes,cod_unidad,abreviatura from proyecto_modernizacion.leyes order by nombre_leyes"; 
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbLeyes == $Fila["cod_leyes"])
				{
					$CmbUnidad=$Fila["cod_unidad"];
					echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))." - ".ucwords(strtolower($Fila["nombre_leyes"]))."</option>\n";				
				}
				else
					echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["abreviatura"]))." - ".ucwords(strtolower($Fila["nombre_leyes"]))."</option>\n";
			}
		?>
       </select>
       <?php
	 }
	 else
	 {
			$Consulta="SELECT cod_leyes,nombre_leyes,cod_unidad from proyecto_modernizacion.leyes where cod_leyes='".$CmbLeyes."'"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
	 			echo $Fila["nombre_leyes"];
			echo "<input type='hidden' name='CmbLeyes' value='".$CmbLeyes."'>";	
	 }
	?>
     </strong></font></font></td>
   </tr>
   <tr class="Colum01">
    <td class="Colum01">Unidad</td>
    <td class="Colum01"><font size="1"><font size="2"><strong>  <?php
	 if($Opc=='N')
	 {
	?><select name="CmbUnidad" style="width:200">
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
    </select>  <?php
	 }
	 else
	 {
			$Consulta="select cod_unidad,nombre_unidad,abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$CmbUnidad."'"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
	 			echo $Fila["abreviatura"];
			echo "<input type='hidden' name='CmbUnidad' value='".$CmbUnidad."'>";	
	 } ?>     </strong></font></font></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Uspec</td>
    <td class="Colum01"><input name="TxtValor" type="text" id="TxtValor" value="<?php echo number_format((float)$TxtValor,3,',','');?>" size="12" maxlength="7" onKeyDown="SoloNumerosyNegativo(true,this)"></td>					
    </tr>
  <?php
  	if($Opc=='N')
		$Boton='Grabar';
	else
		$Boton='Modificar';	
  ?>
  <tr class="Colum01">
    <td colspan="2" align="center" class="Colum01">
      <input name="BtnGuardar" type="button" id="BtnGuardar" value="<?php echo $Boton;?>" style="width:70px " onClick="Proceso('<?php echo $Opc;?>')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
</form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if ($Msj=='1')
		echo "alert('Indicador Ingresado Exitosamente');";
	if ($Msj=='2')
		echo "alert('Registro Existente');";
	if ($Msj=='3')
		echo "alert('Indicador Modificado Exitosamente');";
	echo "</script>";
?>