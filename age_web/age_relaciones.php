<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 22;
	include("../principal/conectar_principal.php");	
	if (!isset($ChkTipoFlujo))
	{
		$ChkTipoFlujo="RAM";
		$TipoFlujo="RAM";
	}
	if (!isset($ChkOrden))
		$ChkOrden="R";
?>
<html>
<head>
<title>AGE-Relaciones</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=20&Nivel=1";
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
	f.action = "age_relaciones.php?Orden=<?php echo $Orden; ?>&Mostrar=S&TipoBusq="+TipoBusq;
	f.submit(); 
}
function Excel()
{	
	var f = document.frmPrincipal;
	f.action = "age_relaciones_excel.php?Orden=<?php echo $Orden; ?>&Mostrar=S&TipoBusq=<?php echo $TipoBusq; ?>";
	f.submit(); 
}
function Nuevo()
{
	var f = document.frmPrincipal;		
	window.open("age_relaciones02.php?Orden=<?php echo $Orden; ?>&TipoBusq="+ f.TipoBusqueda.value + "&Proceso=N&ChkTipoFlujo="+f.TipoFlujo.value+"&SubProducto="+f.SubProducto.value+"&Rut="+f.Proveedor+"&Flujos="+f.Flujos.value,"","top=50,left=10,width=650,height=300,scrollbars=yes,resizable = yes");					
}

function Recarga(obj)
{
	var f = document.frmPrincipal;
	f.TipoFlujo.value = obj.value;
	f.action = "age_relaciones.php?Orden=<?php echo $Orden; ?>";
	f.submit();
}
function Recarga2()
{
	var frm = document.frmPrincipal;
	frm.action="age_relaciones.php?Orden=<?php echo $Orden; ?>";
	frm.submit();	
}
function Recarga3()
{
	var Frm=document.frmPrincipal;
	Frm.action="age_relaciones.php?Busq=S";
	Frm.submit();	
}
function Orden(opt)
{
	var frm = document.frmPrincipal;
	frm.action="age_relaciones.php?Mostrar=S&TipoBusq=<?php echo $TipoBusqueda; ?>&Orden="+opt;
	frm.submit();	
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
		window.open("age_relaciones02.php?TipoBusq="+ f.TipoBusqueda.value + "&Proceso=M&ChkTipoFlujo="+f.TipoFlujo.value+"&Valores="+Valores,"","top=50,left=10,width=650,height=300,scrollbars=yes,resizable = yes");					
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
			f.action="age_relaciones01.php?Orden=<?php echo $Orden; ?>&Proceso=E&Valores="+Valores;					
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
function PrvRelacion()
{
	window.open("age_prv_relaciones.php?Orden=<?php echo $Orden; ?>","","top=50,left=10,width=650,height=450,scrollbars=yes,resizable = yes");					
	
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
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoBusq; ?>">
<input type="hidden" name="TipoFlujo" value="<?php echo $TipoFlujo; ?>">
<?php include("../principal/encabezado.php") ?>
  <table width="770"  height="313"border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="top">
	    <table width="720" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr align="center">
            <td height="23" colspan="4"><strong>Relacion Productos-Proveedor-Flujo</strong></td>
          </tr>
          <tr>
            <td height="23">Sistema Asociado: </td>
            <td colspan="2">
              <?php
	switch ($ChkTipoFlujo)
	{
		case "RAM":
			echo "<input checked name='ChkTipoFlujo' type='radio' value='RAM' onClick=\"Recarga(this)\">Flujos RAM&nbsp;&nbsp;";
			echo "<input name='ChkTipoFlujo' type='radio' value='PMN' onClick=\"Recarga(this)\">Flujos PLAMEN";		
			break;
		case "PMN":
			echo "<input name='ChkTipoFlujo' type='radio' value='RAM' onClick=\"Recarga(this)\">Flujos RAM&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoFlujo' type='radio' value='PMN' onClick=\"Recarga(this)\">Flujos PLAMEN";		
			break;			
	}

?>
            </td>
            <td width="209" rowspan="5">
              <div align="center">
                <input name="BtnConsultar" type="button" onClick="Consultar(this.form,'1')" style="width:70px;"  value="Consultar">
				<?php 
				if ($Mostrar=="S")
				{
				?>
                <input name="BtnExcel" type="button" id="BtnConsultar" style="width:70px;"  onClick="Excel()" value="Excel">				
                <?php } ?>
                <br>
                <input name="BtnNuevo" type="button" id="BtnNuevo4" style="width:70px;" onClick="Nuevo()" value="Nuevo">
                <input name="BtnModificar" type="button" id="BtnNuevo" style="width:70px;" onClick="Modificar()" value="Modificar">
                <!--<input name="BtnModificar" type="button" style="width:70px;" onClick="Modificar()" value="Modificar">-->
                <br>
                <input name="BtnEliminar" type="button" id="BtnEliminar2" style="width:70px;" onClick="Eliminar()" value="Eliminar">
                <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="JavaScript:Salir()">
				<input name="BtnPrvSinRelacion" type="button" id="BtnSalir2" value="Proveedores sin Flujo" style="width:130px;" onClick="PrvRelacion()">
            </div></td>
          </tr>
          <tr>
            <td width="136" height="23">Buscar Por SubProducto:</td>
            <td width="348" align="left">
              <select name="SubProducto" onChange="Consultar(this.form,'1')" style="width:300">
                <option class="NoSelec" value="S">SELECCIONAR</option>
                <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				switch ($ChkTipoFlujo)
				{
					case "RAM":
						$Consulta.= " and (recepcion='' or recepcion='RAM') ";
						break;
					case "PMN":
						$Consulta.= " and (recepcion='PMN') ";
						break;
				}		
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
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">Orden Por: </td>
            <td align="left" bgcolor="#FFFFFF"><?php
switch ($ChkOrden)
{
	case "R":
		echo '<input checked name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
		echo '<input name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
		break;
	case "N":
		echo '<input name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
		echo '<input checked name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
		break;

}

?>
              &nbsp;&nbsp;---> Filtro Prv&nbsp;
              <input type="text" name="TxtFiltroPrv" size="10">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
          </tr>
          <tr>
            <td height="23" align="center"><div align="left">Buscar Por Proveedor:</div></td>
            <td height="23" align="left">
              <select name="Proveedor" onChange="Consultar(this.form,'2')" style="width:300">
                <option class="NoSelec" value="S">SELECCIONAR</option>
                <?php
				if (isset($SubProducto) && $SubProducto != "S")
				{
					$Consulta = "select DISTINCT t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A ";
					$Consulta.= " from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv = t2.rut_proveedor inner join proyecto_modernizacion.subproducto t3 ";
					$Consulta.= " on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
					$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";			
					if($Busq=='S'&&$TxtFiltroPrv!='')
					   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%'";  					
					switch ($ChkTipoFlujo)
					{
						case "RAM":
							$Consulta.= " and (t3.recepcion='' or t3.recepcion='RAM') ";
							break;
						case "PMN":
							$Consulta.= " and (t3.recepcion='PMN') ";
							break;
					}			
					switch ($ChkOrden)
					{
						case "R":
							$Consulta.= "order by lpad(t1.rut_prv,10,'0')";
							break;
						case "N":
							$Consulta.= "order by trim(t1.nombre_prv)";
							break;
					
					}
				}
				else
				{
					$Consulta = "select DISTINCT t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A ";
					$Consulta.= " from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv = t2.rut_proveedor inner join proyecto_modernizacion.subproducto t3 ";
					$Consulta.= " on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
					$Consulta.= " where t2.cod_producto='1' ";			
					if($Busq=='S'&&$TxtFiltroPrv!='')
					   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%'"; 					
					switch ($ChkTipoFlujo)
					{
						case "RAM":
							$Consulta.= " and (t3.recepcion='' or t3.recepcion='RAM') ";
							break;
						case "PMN":
							$Consulta.= " and (t3.recepcion='PMN') ";
							break;
					}			
					switch ($ChkOrden)
					{
						case "R":
							$Consulta.= "order by lpad(t1.rut_prv,10,'0')";
							break;
						case "N":
							$Consulta.= "order by trim(t1.nombre_prv)";
							break;
					
					}
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
				}
			?>
              </select>
            </td>
          </tr>
          <tr>
            <td height="23" align="center"><div align="left">Buscar Por Flujos:</div></td>
            <td height="23" align="left">
              <select name="Flujos" style="width:300" onChange="Consultar(this.form,'3')">
                <option class="NoSelec" value="S">SELECCIONAR</option>
                <?php
				$Consulta = "select distinct t1.cod_flujo,t1.descripcion,lpad(t1.cod_flujo,3,'0') as orden ";
				$Consulta.= " from age_web.relaciones t0 inner join proyecto_modernizacion.flujos t1 on t0.flujo=t1.cod_flujo";
				$Consulta.= " where t1.esflujo<>'N' ";
				$Consulta.= " and t1.sistema='".$ChkTipoFlujo."' and t1.sub_tipo='R'";				
				$Consulta.= " order by orden";
				
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Flujos == $Fila["cod_flujo"])
						echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],0,3,STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
					else
						echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,'0',STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
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
			echo "<td width='90' align='center'><a href=\"JavaScript:Orden('R')\">Rut</a></td>\n";
			echo "<td width='220' align='center'><a href=\"JavaScript:Orden('P')\">Proveedor</a></td>\n";
			echo "<td width='180' align='left'>SubProducto</td>\n";
			echo "<td width='30' align='center'><a href=\"JavaScript:Orden('F')\">Flujo</a></td>\n";
			echo "<td width='220' align='left'>Descrip. Flujo</td>\n";
			echo "<td width='60' align='left'><a href=\"JavaScript:Orden('G')\">Grupo</a></td>\n";
			echo "</tr>\n";
			$Consulta = "select t1.rut_proveedor,t1.cod_subproducto,t1.flujo,t3.nomprv_a as nombre,t2.abreviatura as subproducto,t4.descripcion as nomflujo, t1.grupo,t1.leyes,t1.impurezas ";
			$Consulta.= " from age_web.relaciones t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.=" left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
			$Consulta.= " left join proyecto_modernizacion.flujos t4 on case when t2.recepcion='PMN' then t4.sistema='PMN' else t4.sistema='RAM' end ";
			$Consulta.= " and t1.flujo=t4.cod_flujo and esflujo<>'N' and sub_tipo='R'" ;
			switch($TipoBusq)
			{
				case "1"://POR SUBPRODUCTO
					$Consulta.= " where t1.cod_producto='1' ";
					if ($SubProducto!="S")
						$Consulta.= " and t1.cod_subproducto='".$SubProducto."'";	
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
			switch($Orden)
			{
				case "R"://POR SUBPRODUCTO
					$Consulta.= " order by lpad(t1.rut_proveedor,310,'0'), t3.nomprv_a, lpad(t1.cod_subproducto,3,'0'),   t1.flujo";
					break;
				case "P"://POR SUBPRODUCTO
					$Consulta.= " order by t3.nomprv_a, lpad(t1.cod_subproducto,3,'0'), t1.flujo";
					break;
				case "F"://POR SUBPRODUCTO
					$Consulta.= " order by t1.flujo, lpad(t1.cod_subproducto,3,'0'), t3.nomprv_a ";
					break;
				case "G"://POR SUBPRODUCTO
					$Consulta.= " order by t1.grupo, lpad(t1.cod_subproducto,3,'0'), t3.nomprv_a,  t1.flujo ";
					break;
			}
			//echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='ChkRut'>";
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Cont++;
				echo "<tr>\n";
				echo "<td align='center'><input type='radio' name='ChkRut' value='".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~".$Fila["flujo"]."~~".$Fila["grupo"]."~~".$Fila["leyes"]."~~".$Fila["impurezas"]."'></td>";
				//echo "<td align='center'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)."</td>";
				echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
				$LeyesMuestra='';$ImpurezasMuestra='';$LeyesImp='';
				if($Fila["leyes"]!=''||$Fila["impurezas"]!='')
					$LeyesImp=$Fila["leyes"].'~'.$Fila["impurezas"];
				$Datos=explode('~',$LeyesImp);
				foreach($Datos as $c => $v)
				{
					if($v!='')
					{
						$Consulta = "select abreviatura as ley from proyecto_modernizacion.leyes where cod_leyes='$v'";
						$RespLey=mysqli_query($link, $Consulta);
						$FilaLey=mysqli_fetch_array($RespLey);
						if($v=='01'||$v=='02'||$v=='03'||$v=='04'||$v=='05')
							$LeyesMuestra=$LeyesMuestra.$FilaLey["ley"]."~";
						else
							$ImpurezasMuestra=$ImpurezasMuestra.$FilaLey["ley"]."~";
					}		
				}
				echo "<td onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' class='Detalle02'>";
				echo "<div id='Txt".$Cont."' ";
				echo " style=\"FILTER: alpha(opacity=85);  background-color:#fff4cf; VISIBILITY: hidden; WIDTH: 500px; POSITION: absolute; moz-opacity: .75; opacity: .75; border:solid 1px Black\">";
				echo "<font face='courier' color='#000000' size=1><b>Leyes:&nbsp;".$LeyesMuestra."<br></b>";
				echo "<font face='courier' color='#000000' size=1><b>Impurezas:&nbsp;".$ImpurezasMuestra."<br></b>";
				echo "</div>&nbsp;&nbsp;".$Fila["nombre"]."</td>";
				echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
				if ($Fila["flujo"]=="0" || $Fila["flujo"]=="")
				{
					echo "<td align='center'>-</td>\n";
					echo "<td align='left'>SIN FLUJO</td>\n";
				}
				else
				{
					echo "<td align='center'>".$Fila["flujo"]."</td>\n";
					echo "<td align='left'>".$Fila["nomflujo"]."</td>\n";
				}
				switch ($Fila["grupo"])
				{
					case "P":
						echo "<td align='left'>Principal</td>\n";
						break;
					case "V":
						echo "<td align='left'>Varios</td>\n";
						break;
					case "":
						echo "<td align='left'>&nbsp;</td>\n";
						break;
				}				
				echo "</tr>\n";
			}
		}
		?>  </td>
 </tr>
</table>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
