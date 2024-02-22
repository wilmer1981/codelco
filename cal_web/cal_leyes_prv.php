<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 79;
	include("../principal/conectar_principal.php");
	if(isset($SubProducto2)&&isset($Proveedor2))
	{
		$SubProducto=$SubProducto2;	
		$Proveedor=$Proveedor2;
		$Mostrar=$Mostrar2;
		$TipoBusq=$TipoBusq2;
	}
	if (!isset($ChkOrden))
		$ChkOrden="R";
?>
<html>
<head>
<title>CAL-Asignacion Leyes Producto - Proveedor</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=1&CodPantalla=10&Nivel=1";
}
function Consultar(f,TipoBusq)
{	
	var f = document.frmPrincipal;
	switch(TipoBusq)
	{
		case "1":
			f.Proveedor.value='-1';
			break;
		case "2":
			f.SubProducto.value='-1';
			break;
		case "3":
			f.Proveedor.value='-1';
			f.SubProducto.value='-1';		
			break;
	}
	f.action = "cal_leyes_prv.php?Orden=<?php echo $Orden; ?>&Mostrar=S&TipoBusq="+TipoBusq;
	f.submit(); 
}
function Excel()
{	
	var f = document.frmPrincipal;

	window.open("cal_leyes_prv_excel.php?SubProducto="+f.SubProducto.value+"&Proveedor="+f.Proveedor.value,"","top=50,left=10,width=800,height=600,scrollbars=yes,resizable = yes");					
	//f.action = "cal_leyes_prv_excel.php?Orden=<?php echo $Orden; ?>&Mostrar=S";
	//f.submit(); 
}
function Recarga(obj)
{
	var f = document.frmPrincipal;
	f.action = "cal_leyes_prv.php?Orden=<?php echo $Orden; ?>";
	f.submit();
}
function Recarga2()
{
	var frm = document.frmPrincipal;
	frm.action="cal_leyes_prv.php?Orden=<?php echo $Orden; ?>";
	frm.submit();	
}
function Recarga3()
{
	var Frm=document.frmPrincipal;
	Frm.action="cal_leyes_prv.php?Busq=S";
	Frm.submit();	
}
function Orden(opt)
{
	var frm = document.frmPrincipal;
	frm.action="cal_leyes_prv.php?Mostrar=S&TipoBusq=<?php echo $TipoBusqueda; ?>&Orden="+opt;
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
		window.open("cal_leyes_prv02.php?Proceso=M&Valores="+Valores,"","top=50,left=10,width=500,height=300,scrollbars=yes,resizable = yes");					
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
<?php include("../principal/encabezado.php") ?>
  <table width="770"  height="313"border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="top">
	    <table width="720" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr align="center">
            <td height="23" colspan="4"><strong>Asignaci&oacute;n Leyes Productos-Proveedor</strong></td>
          </tr>
          <tr>
            <td height="23">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
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
                <input name="BtnModificar" type="button" id="BtnNuevo" style="width:70px;" onClick="Modificar()" value="Modificar">
                <!--<input name="BtnModificar" type="button" style="width:70px;" onClick="Modificar()" value="Modificar">-->
                <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="JavaScript:Salir()">
                <br>
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
				$Consulta.= " and (recepcion='' or recepcion='RAM') ";
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
					$Consulta.= " and (t3.recepcion='' or t3.recepcion='RAM') ";
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
					$Consulta.= " and (t3.recepcion='' or t3.recepcion='RAM') ";
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
            <td height="23" align="center">&nbsp;</td>
            <td height="23" align="left">&nbsp;</td>
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
			echo "<td width='30' align='center'>Leyes</td>\n";
			echo "<td width='60' align='left'>Impurezas</td>\n";
			echo "</tr>\n";
			$Consulta = "select t1.rut_proveedor,t1.cod_subproducto,t3.nomprv_a as nombre,t2.abreviatura as subproducto,t1.leyes,t1.impurezas ";
			$Consulta.= " from age_web.relaciones t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.=" left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
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
				case "3"://POR PROVEEDOR -`PRODUCTO
					$Consulta.= " where t1.rut_proveedor='".$Proveedor."' and t1.cod_subproducto='".$SubProducto."'";
					break;

				default:
					$Consulta.= " where t1.rut_proveedor='-1'";
					break;	
			}
			switch($Orden)
			{
				case "R"://POR SUBPRODUCTO
					$Consulta.= " order by lpad(t1.rut_proveedor,310,'0'), t3.nomprv_a, lpad(t1.cod_subproducto,3,'0')";
					break;
				case "P"://POR SUBPRODUCTO
					$Consulta.= " order by t3.nomprv_a, lpad(t1.cod_subproducto,3,'0')";
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
				echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
				$LeyesMuestra='';$ImpurezasMuestra='';$LeyesImp='';
				if($Fila["leyes"]!=''||$Fila["impurezas"]!='')
					$LeyesImp=$Fila["leyes"].'~'.$Fila["impurezas"];
				$Datos=explode('~',$LeyesImp);
				while(list($c,$v)=each($Datos))
				{
					if($v!='')
					{
						$Consulta = "select abreviatura as ley from proyecto_modernizacion.leyes where cod_leyes='$v'";
						$RespLey=mysqli_query($link, $Consulta);
						$FilaLey=mysqli_fetch_array($RespLey);
						if($v=='01'||$v=='02'||$v=='03'||$v=='04'||$v=='05')
							$LeyesMuestra=$LeyesMuestra.$FilaLey[ley]."~";
						else
							$ImpurezasMuestra=$ImpurezasMuestra.$FilaLey[ley]."~";
					}		
				}
				echo "<td >".$Fila["nombre"]."&nbsp;</td>";
				echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
				echo "<td align='center'>".$LeyesMuestra."&nbsp;</td>\n";
				echo "<td align='center'>".$ImpurezasMuestra."&nbsp;</td>\n";
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
