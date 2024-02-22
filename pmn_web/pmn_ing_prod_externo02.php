<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_ing_prod_externo02.php?Mostrar=S";
			f.submit();
			break;
	}
}

function CargaDatos(RB)
{
	var f = document.frmConsulta;
	window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?Modif=S&Hornada01=" + RB.value + "&Dia01=" + f.DiaConsulta.value + "&Mes01=" + f.MesConsulta.value + "&Ano01=" + f.AnoConsulta.value;
	window.opener.document.frmPrincipalRpt.submit();
	window.close();
}
function Recarga()
{
	var f=document.frmConsulta;
	f.action="pmn_ing_prod_externo02.php";
	f.submit();  
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<table width="650" height="20" border="0">
  <tr>
    <td class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Detalle Planta de Selenio por D&iacute;a</strong></td>
  </tr>
</table>
<br>
  <table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
    <tr>
      <td class="titulo_azul">Productos</td>
      <td><select name='Producto' onChange='Recarga();' style='width:220px'>
          <?php 
					echo "<option value='S'>Seleccionar</option>\n";
					$Consulta = "select t2.cod_producto, t2.descripcion ";
					$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
					$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='2' ";
					$Consulta.= " order by t1.cod_subclase";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Producto == $Row["cod_producto"])
							echo "<option selected value='".$Row["cod_producto"]."'>";														
						else	echo "<option value='".$Row["cod_producto"]."'>";
						printf("%'03d",$Row["cod_producto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
					echo "<option value='S'>-----------------------------</option>\n";
					$Consulta = "select * from proyecto_modernizacion.productos order by cod_producto";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Producto == $Row["cod_producto"])
							echo "<option selected value='".$Row["cod_producto"]."'>";														
						else	echo "<option value='".$Row["cod_producto"]."'>";
						printf("%'03d",$Row["cod_producto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
				?>
        </select></td>
      <td><input type="button" name="btnVerDia" value="Consultar" onClick="Proceso('C');" style="width:70px"></td>
    </tr>
    <tr> 
      <td width="116" class="titulo_azul">SubProdutos</td>
      <td width="343">
<select name="Subproducto" onChange="Recarga();" style="width:220px">
          <option value="S">Seleccionar</option>
          <?php
					$Consulta = "select t2.cod_subproducto, t2.descripcion ";
					$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
					$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Producto."' and ";
					$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Producto."' and t1.nombre_subclase='2'";
					$Consulta.= " order by t1.cod_subclase";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Producto == $Row["cod_subproducto"])
							echo "<option selected value='".$Row["cod_subproducto"]."'>";														
						else	echo "<option value='".$Row["cod_subproducto"]."'>";
						printf("%'03d",$Row["cod_subproducto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
					echo "<option value='S'>-----------------------------</option>\n";
					$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by cod_subproducto";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Subproducto == $Row["cod_subproducto"])
							echo "<option selected value='".$Row["cod_subproducto"]."'>\n";
						else	echo "<option value='".$Row["cod_subproducto"]."'>\n";
						printf("%'03d",$Row["cod_subproducto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}			
				?>
        </select></td>
      <td width="166"> <div align="left"> 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
    </tr>
  </table>
<br>
  <table width="903" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="TituloCabeceraAzul"> 
      <td width="57">&nbsp;</td>
      <td width="161"><strong>Tambor</strong></td>
      <td width="128"><strong>Producto</strong></td>
      <td width="149"><strong>SubProducto</strong></td>
      <td width="122"><strong>Peso Bruto</strong></td>
      <td width="122"><strong>Peso Tambor</strong></td>
      <td width="122"><strong>Peso Neto</strong></td>
    </tr>
    <?php  
	if ($Mostrar=='S')
	{
		$Consulta ="select t1.id_producto,t1.referencia,t2.abreviatura as DesProducto,t3.abreviatura as DesSubproducto,t1.peso_bruto,t1.peso_resta,t1.peso_final from pmn_web.detalle_productos_externos t1  ";
		$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_subproducto = t3.cod_subproducto and t2.cod_producto = t3.cod_producto ";
		$Consulta.=" where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$Subproducto."'"; 
		echo $Consulta."<br>";	
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td><input type='radio' name='CheckModificar' value='".$Row[id_producto]."' onClick='CargaDatos(this);'></td>\n";
			echo "<td>".$Row[id_producto]." ".$Row[referencia]."</td>\n";
			echo "<td>".$Row[DesProducto]."&nbsp;</td>\n";
			echo "<td>".$Row[DesSubproducto]."&nbsp;</td>\n";
			echo "<td>".$Row[peso_bruto]."&nbsp;</td>\n";
			echo "<td>".$Row[peso_resta]."&nbsp;</td>\n";
			echo "<td>".$Row[peso_final]."&nbsp;</td>\n";
			echo "</tr>\n";
		}
	}
?>
  </table>
</form>
</body>
</html>
