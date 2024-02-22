<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 3;
	include("../principal/conectar_principal.php");	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=15";
}
function Consultar(f,TipoBusq)
{	
	var f = document.frmPrincipal;
	switch(TipoBusq)
	{
		case "1":
			f.Proveedor.value='-1';
			f.Flujos.value='-1';		
			break;
		case "2":
			f.SubProducto.value='-1';
			f.Flujos.value='-1';		
			break;
		case "3":
			f.Proveedor.value='-1';
			f.SubProducto.value='-1';		
			break;
	}
	f.action = "age_recpromin.php?Mostrar=S&TipoBusq="+TipoBusq;
	f.submit(); 
}

function Nuevo()
{
	var f = document.frmPrincipal;		
	window.open("age_recpromin02.php?Proceso=N&SubProducto="+f.SubProducto.value+"&Rut="+f.Proveedor+"&Flujos="+f.Flujos.value,"","top=50,left=10,width=500,height=300,scrollbars=yes,resizable = yes");					
}

function Modificar()
{
	var f = document.frmPrincipal;
	var Rut="";
	var Valores="";

	for (i=1;i<f.ChkRut.length;i++)
	{
		if (f.ChkRut[i].checked==true)
		{
			Valores=Valores + f.ChkRut[i].value+"//";
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	if (Valores=="")
	{
		alert("Debe Seleccionar un elemento para Modificar");
		return;
	}
	else
	{
		window.open("age_recpromin02.php?Proceso=M&Valores="+Valores,"","top=50,left=10,width=500,height=300,scrollbars=yes,resizable = yes");					
	}
}
function Eliminar()
{
	var f = document.frmPrincipal;
	var Valores="";

	for (i=1;i<f.ChkRut.length;i++)
	{
		if (f.ChkRut[i].checked==true)
		{
			Valores=Valores + f.ChkRut[i].value+"//";
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	if (Valores=="")
	{
		alert("Debe Seleccionar un elemento para Eliminar");
		return;
	}
	else
	{
		var msg = confirm("�Esta Seguro de Eliminar este registro?");
		if (msg==true)
		{
			f.action="age_recpromin01.php?Proceso=E&Valores="+Valores;					
			f.submit();
		}
		else
		{
			return;
		}
	}
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770"  height="313"border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="top">
	  <table width="720" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr align="center"> 
            <td height="23" colspan="3"><strong>ASOCIACION DE PRODUCTOS MINEROS</strong></td>
          </tr>
          <tr> 
            <td width="136" height="23">Buscar Por SubProducto</td>
            <td width="305" align="left">
			<select name="SubProducto" onChange="Consultar(this.form,'1')" style="width:300">
            <option value="S">SELECCIONAR</option>
			<?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			?>
            </select></td>
            <td width="252" rowspan="3"> <div align="center">
			<input name="BtnNuevo" type="button" id="BtnNuevo2" style="width:70px;" onClick="Nuevo()" value="Nuevo">
			<!--<input name="BtnModificar" type="button" style="width:70px;" onClick="Modificar()" value="Modificar">-->
			<input name="BtnEliminar" type="button" id="BtnEliminar2" style="width:70px;" onClick="Eliminar()" value="Eliminar">
			<input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="JavaScript:Salir()">
            </div></td>
            </tr>
            <tr> 
            <td height="23" align="center"><div align="left">Buscar Por Proveedor</div></td>
            <td height="23" align="left">
			<select name="Proveedor" onChange="Consultar(this.form,'2')" style="width:300">
            <option value="S">SELECCIONAR</option>
			<?php
				$Consulta = "select * from ram_web.proveedor order by nombre";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre"]."</option>";
				}
			?>
            </select>			
			</td>
          </tr>
          <tr> 
            <td height="23" align="center"><div align="left">Buscar Por Flujos</div></td>
            <td height="23" align="left">
			<select name="Flujos" onChange="Consultar(this.form,'3')" style="width:300">
            <option value="S">SELECCIONAR</option>
			<?php
				$Consulta = "select cod_flujo,descripcion,lpad(cod_flujo,3,'0') as orden from proyecto_modernizacion.flujos where esflujo<>'N' and sistema='RAM' and tipo='E' order by orden";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Flujos == $Fila["cod_flujo"])
						echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],0,3,STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
					else
						echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila[cod_flujo],3,'0',STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
				}
			?>
            </select>			
			</td>
          </tr>
        </table>
        <br>        
		<?php	
		if ($Mostrar == "S")
		{	
			echo "<table width='720' border='1' cellpadding='1' cellspacing='0' class='TablaDetalle'>\n";		
			echo "<tr class='ColorTabla01'>\n";
			echo "<td width='5'>&nbsp;</td>\n";
			echo "<td width='90' align='center'>Rut</td>\n";
			echo "<td width='220' align='center'>Proveedor</td>\n";
			echo "<td width='180' align='center'>SubProducto</td>\n";
			echo "<td width='220' align='center'>Flujo</td>\n";
			echo "</tr>\n";
			$Consulta = "select t1.rut_proveedor,t1.cod_subproducto,t1.flujo,t3.nombre,t2.abreviatura as subproducto,t4.descripcion as nomflujo from age_web.recpromin t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.=" inner join ram_web.proveedor t3 on t1.rut_proveedor=t3.rut_proveedor inner join proyecto_modernizacion.flujos t4 on t4.sistema='RAM' and t1.flujo=t4.cod_flujo";
			switch($TipoBusq)
			{
				case "1"://POR SUBPRODUCTO
					$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";	
					break;
				case "2"://POR PROVEEDOR
					$Consulta.= " where t1.rut_proveedor='".$Proveedor."'";
					break;
				case "3"://POR FLUJO
					$Consulta.= " where t1.flujo='".$Flujos."'";
					break;
				default:
					$Consulta.= " where t1.rut_proveedor='-1'";
					break;	
			}
			$Resp = mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='ChkRut'>";
			while ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
				echo "<td align='center'><input type='radio' name='ChkRut' value='".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~".$Fila["flujo"]."'>";
				echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
				echo "<td align='left'>".$Fila["nombre"]."</td>\n";
				echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
				echo "<td align='left'>".$Fila["flujo"]."-".$Fila[nomflujo]."</td>\n";
				echo "</tr>\n";
			}
		}
		?>		  
  </td>
 </tr>
</table>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
