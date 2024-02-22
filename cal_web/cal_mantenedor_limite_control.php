<?php
$CodigoDeSistema=1;
$CodigoDePantalla = 67;

include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;

if(isset($_REQUEST["Buscar"])) {
	$Buscar = $_REQUEST["Buscar"];
}else{
	$Buscar = "";
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
	$CmbProveedores = "";
}
if(isset($_REQUEST["Msj"])) {
	$Msj = $_REQUEST["Msj"];
}else{
	$Msj = "";
}


?>
<html>
<head>
<title>Administración Limite de Control</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var popup=0;
	var frm=document.FrmPrincipal;
	switch (Opcion)
	{
		case "B": 
			frm.action ="cal_mantenedor_limite_control.php?Buscar=S";  
			frm.submit();
		break;	
		case "R"://recarga pagina
			frm.action ="cal_mantenedor_limite_control.php";  
			frm.submit();
		break;
		case "N"://nuevo
			URL="cal_mantenedor_limite_control_proceso.php?Opc=N";
			opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=300,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			//popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "M"://modificar
			if(SoloUnElemento(frm.name,'CheckTipo','M'))
			{
				Datos=Recuperar(frm.name,'CheckTipo');
				URL="cal_mantenedor_limite_control_proceso.php?Opc=M&Valores="+Datos;
				opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=300,scrollbars=1';
				popup=window.open(URL,"",opciones);
				popup.focus();
			}
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
		break;	
		case "D":
			ValidarDetalle();
			break;			
		case "E":
			if(SoloUnElemento(frm.name,'CheckTipo','E'))
			{
				mensaje=confirm("¿Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(frm.name,'CheckTipo');
					frm.action='cal_mantenedor_limite_control_proceso01.php?Proceso=E&Valor='+Datos;
					frm.submit();
				}
			}	
		break; 
		case "EXC":
			if(frm.CmbProductos.value=='1')
			{
				URL='cal_mantenedor_limite_control_excel.php?CmbProductos='+frm.CmbProductos.value+'&CmbSubProducto='+frm.CmbSubProducto.value+'&CmbProveedores='+frm.CmbProveedores.value+'&CmbLeyes='+frm.CmbLeyes.value;
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			}
			else
			{
				URL='cal_mantenedor_limite_control_excel.php?CmbProductos='+frm.CmbProductos.value+'&CmbSubProducto='+frm.CmbSubProducto.value+'&CmbLeyes='+frm.CmbLeyes.value;
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			}
		break;
	}	

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
						//Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) + "~"+ (eval("document."+f+"."+inputchk+"["+i+1+"].value")) + "//" ;
						Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))+ "~" + "A" + "//" ;
						Encontro=true;
					}
				}
				else
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
				}
			}
		}
		else
		{
			if(niv=='AN')
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))  + "~" + "R" + "//" ;
				Encontro=true;
			}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function CheckearTodo(f,nomchk,nomchkT)
{
	var Check=new Object();
	var CheckT=new Object();
	
	try
	{
		eval("document."+f.name+"."+nomchk+"[0]");
		Check=eval("document."+f.name+"."+nomchk);
		CheckT=eval("document."+f.name+"."+nomchkT);
		for (i=1;i<Check.length;i++)
		{
			if (CheckT.checked==true){
				if(Check[i].disabled==false)
					Check[i].checked=true;
			}
			else{
				if(Check[i].disabled==false)
					Check[i].checked=false;
			}
		}
	}
	catch (e)
	{
	}
}
</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmPrincipal" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="756" align="center" valign="top"><table width="761" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
          <tr bgcolor="#FFFFFF"> 
            <td width="87">Producto</td>
            <td><font size="1"><font size="1"><font size="2"><strong>
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
            </strong></font></font></font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>SubProducto  </td>
            <td><font size="1"><font size="2"><strong>
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
          </tr>
		  <?php
		  if($CmbProductos=='1')
		  {
		  ?>
			  <tr bgcolor="#FFFFFF"> 
				<td>Proveedores  </td>
				<td><font size="1"><font size="2"><strong>
				  <select name="CmbProveedores" style="width:280">
					<option value="T" selected>Todos</option>
					<?php
						$Consulta="select rut_prv,nombre_prv from sipa_web.proveedores order by nombre_prv"; 
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ($CmbProveedores == $Fila["rut_prv"])
								echo "<option value = '".$Fila["rut_prv"]."' selected>".str_pad($Fila["rut_prv"], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]))."</option>\n";				
							else
								echo "<option value = '".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]))."</option>\n";
						}
					?>
				  </select>
				</strong></font></font></td>
			  </tr>
		  <?php
		  }
		  ?>	
          <tr bgcolor="#FFFFFF"> 
            <td>Ley</td>
            <td>
               <select name="CmbLeyes" style="width:200">
                <option value="T" selected>Todos</option>
                <?php
					$Consulta="select cod_leyes,nombre_leyes from proyecto_modernizacion.leyes order by nombre_leyes"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbLeyes == $Fila["cod_leyes"])
							echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["nombre_leyes"]))."</option>\n";				
						else
							echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["nombre_leyes"]))."</option>\n";
					}
				?>
              </select>            </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
            <td colspan="2">
                <input name="BtnDetalle3" type="button" id="BtnDetalle3" style="width:80" value="Buscar" onClick="Proceso('B');">
                <input name="BtnDetalle2" type="button" id="BtnDetalle2" style="width:80" value="Nuevo" onClick="Proceso('N');">
                <input name="BtnActualizar2" type="button" id="BtnActualizar2"style="width:80" value="Modificar" onClick="Proceso('M');">
                <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:80"value="Eliminar" onClick="Proceso('E');">
                <input name="Excel" type="button" id="Excel" style="width:80" value="Excel" onClick="Proceso('EXC');">
			    <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:80" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br>        
		<table width="760" border="0" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaDetalle" >
          <tr align="center" class="ColorTabla01">
            <td width="45" height="34">Todos<br><input name="ChkTodos" type="checkbox" onClick="CheckearTodo(this.form,'CheckTipo','ChkTodos');"></td>
            <td width="140" height="34">Producto</td>
            <td width="140">Subproducto</td>
            <td width="200">Proveedor</td>
            <td width="30">Ley</td>
            <td width="30">Unidad</td>
            <td width="40">Lim.Ini</td>
            <td width="40">Lim.Fin</td>
          </tr>
              <?php		
				if($Buscar=='S')
				{
					$Consulta="select t1.limite_inicial,t1.limite_final,t1.cod_producto,t1.cod_subproducto,t1.cod_ley,t1.rut_proveedor,t2.descripcion as nom_producto,t3.descripcion as nom_subproducto,t4.nombre_prv,t5.nombre_leyes,t5.abreviatura,t6.nombre_unidad,t6.abreviatura as abre_uni from cal_web.limite t1 inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
					$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
					$Consulta.=" left join sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv";
					$Consulta.=" inner join proyecto_modernizacion.leyes t5 on t1.cod_ley=t5.cod_leyes";
					$Consulta.=" inner join proyecto_modernizacion.unidades t6 on t1.unidad=t6.cod_unidad";
					$Consulta.=" where t1.cod_producto<>''";
					if($CmbProductos!='T')
						$Consulta.=" and t1.cod_producto='".$CmbProductos."'";
					if($CmbSubProducto!='T')
						$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."'";
					if($CmbProductos=='1')
							$Consulta.=" and t1.rut_proveedor='".$CmbProveedores."'";
					if($CmbLeyes!='T')
						$Consulta.=" and t1.cod_ley='".$CmbLeyes."'";
					$Consulta.=" order by t2.cod_producto,t3.cod_subproducto";	
					echo "<input name='CheckTipo' type='hidden'  value=''>";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if($Fila["rut_proveedor"]==''||$Fila["rut_proveedor"]=='Null')
							$Proveedor='NO APLICA';
						if($Fila["rut_proveedor"]!='')
							$Proveedor=$Fila["rut_proveedor"]." - ".$Fila["nombre_prv"];
						if($Fila["rut_proveedor"]=='T')
							$Proveedor='TODOS';		
						$Clave=$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["rut_proveedor"]."~".$Fila["cod_ley"];
						?><tr bgcolor="#FFFFFF"><?php
							?><td align="center"><input name='CheckTipo'  type='checkbox'  value='<?php echo $Clave;?>'></td><?php
							?><td align='left'><?php echo $Fila["nom_producto"];?></td><?php
							?><td align='left'><?php echo $Fila["nom_subproducto"];?></td><?php
							?><td align='left'><?php echo $Proveedor;?></td><?php
							?><td align='left'><?php echo $Fila["abreviatura"];?></td><?php
							?><td align='left'><?php echo $Fila["abre_uni"];?></td><?php
							?><td align='right'><?php echo number_format($Fila["limite_inicial"],3,',','.');?></td><?php
							?><td align='right'><?php echo number_format($Fila["limite_final"],3,',','.');?></td><?php
						?></tr><?php
					}					
				}	
			?>
          </table>
        <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
          <tr> 
            <td align="center">
                <input name="BtnDetalle22" type="button" id="BtnDetalle22" style="width:80" value="Nuevo" onClick="Proceso('N');">
                <input name="BtnActualizar22" type="button" id="BtnActualizar22"style="width:80" value="Modificar" onClick="Proceso('M');">
                <input name="BtnEliminar2" type="button" id="BtnEliminar2" style="width:80"value="Eliminar" onClick="Proceso('E');">
                <input name="Excel2" type="button" id="Excel2" style="width:80" value="Excel" onClick="Proceso('EXC');">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:80" onClick="Proceso('S');">
            </td>
          </tr>
      </table></td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if ($Msj=='4')
		echo "alert('Registro(s) Eliminado(s) Exitosamente');";
	echo "</script>";
?>