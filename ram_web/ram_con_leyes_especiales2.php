<?php
	include("../principal/conectar_principal.php");

if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso= "";
}
if(isset($_REQUEST["SubProceso"])){
	$SubProceso = $_REQUEST["SubProceso"];
}else{
	$SubProceso= "";
}
if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = date("Y");
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = date("m");
}

if(isset($_REQUEST["Producto"])){
	$Producto = $_REQUEST["Producto"];
}else{
	$Producto= "";
}
if(isset($_REQUEST["SubProducto"])){
	$SubProducto = $_REQUEST["SubProducto"];
}else{
	$SubProducto= "";
}



	set_time_limit(3000);
?>
<html>

<head>
    <title>Sistema de RAM</title>
    <link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
    <script language="JavaScript">
    function Proceso(Valores) {
        var f = document.BuscaLeyes;
        //alert(Valores);
        window.opener.document.frmPrincipal.action = "ram_ing_leyes_esp.php?BuscaLeyesAnt=S&Valores=" + Valores;
        window.opener.document.frmPrincipal.submit();
        window.close();

    }
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body background="../Principal/imagenes/fondo3.gif">
    <form name="BuscaLeyes" action="" method="post">
        <?php
		$Consulta = "select * from proyecto_modernizacion.productos where cod_producto = '".$Producto."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
			$NomProducto = $Fila2["descripcion"];
		else
			$NomProducto = "";
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto = '".$Producto."' and cod_subproducto = '".$SubProducto."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
			$NomSubProducto = $Fila2["descripcion"];
		else
			$NomSubProducto = "";

?>
        <table width="400" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
                <td>PRODUCTO</td>
                <td class="Detalle01"><?php echo $NomProducto;?></td>
            </tr>
            <tr class="ColorTabla01">
                <td>SUB-PRODUCTO</td>
                <td class="Detalle01"><?php echo $NomSubProducto;?></td>
            </tr>
        </table><br>
        <table width="900" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
                <td>SEL.</td>
                <td>COD CNJTO</td>
                <td>CONJUNTO</td>
                <td>FECHA</td>
                <td>TIPO LEY</td>
                <td>H2O</td>
                <td>Cu</td>
                <td>Ag</td>
                <td>Au</td>
                <td>As</td>
                <td>S</td>
                <td>Pb</td>
                <td>Fe</td>
                <td>Si</td>
                <td>CaO</td>
                <td>Al2O3</td>
                <td>MgO</td>
                <td>Sb</td>
                <td>Cd</td>
                <td>Hg</td>
                <td>Te</td>
                <td>Zn</td>
                <td>Fe3O4</td>
            </tr>
            <?php
    $FechaTope=date("Y-m-d", mktime(1,0,0,intval($Mes)-6,1,intval($Ano)));	
	
	$Consulta = "select * from ram_web.leyes_especiales where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."' and fecha >='".$FechaTope."'";// and num_conjunto='".$Conjunto."'";
	$Consulta.= " order by cod_producto, cod_subproducto, cod_conjunto, num_conjunto, tipo_ley,fecha desc";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		$H2O = $Fila["v_h2o"];
		$Cu = $Fila["v_cu"];
		$Ag = $Fila["v_ag"];
		$Au = $Fila["v_au"];
		$As = $Fila["v_as"];
		$S = $Fila["v_s"];
		$Pb = $Fila["v_pb"];
		$Fe = $Fila["v_fe"];
		$Si = $Fila["v_si"];
		$CaO = $Fila["v_cao"];
		$AL2O3 = $Fila["v_al2o3"];
		$MgO = $Fila["v_mgo"];
		$Sb = $Fila["v_sb"];
		$Cd = $Fila["v_cd"];
		$Hg = $Fila["v_hg"];
		$Te = $Fila["v_te"];
		$Zn = $Fila["v_zn"];
		$Fe3O4 = $Fila["v_fe3o4"];
		
		$Var=$Fila["tipo_ley"]."~".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Conjunto."~".$Ano."~".$Mes."//";
		$Var.=$H2O."~".$Cu."~".$Ag."~".$Au."~".$As."~".$S."~".$Pb."~".$Fe."~".$Si."~".$CaO."~".$AL2O3."~".$MgO."~".$Sb."~".$Cd."~".$Hg."~".$Te."~".$Zn."~".$Fe3O4;
		//echo $Var."<br>"; 
		echo "<td><input type='radio' name='Opt' onClick=Proceso('".$Var."')></td>\n";
		echo "<td>".$Fila["cod_conjunto"]."</td>\n";
		echo "<td class='Detalle01'>".$Fila["num_conjunto"]."</td>\n";
		echo "<td class='Detalle01'>".substr($Fila["fecha"],5,2)."/".substr($Fila["fecha"],0,4)."</td>\n";
		if ($Fila["tipo_ley"] == "S")
			$TipoLey = "STOCK INICIAL";
		else
			$TipoLey = "OPERACIONAL";
		echo "<td>".$TipoLey."</td>\n";
		echo "<td>".$Fila["v_h2o"]."</td>\n";
		echo "<td>".$Fila["v_cu"]."</td>\n";
		echo "<td>".$Fila["v_ag"]."</td>\n";
		echo "<td>".$Fila["v_au"]."</td>\n";
		echo "<td>".$Fila["v_as"]."</td>\n";
		echo "<td>".$Fila["v_s"]."</td>\n";
		echo "<td>".$Fila["v_pb"]."</td>\n";
		echo "<td>".$Fila["v_fe"]."</td>\n";
		echo "<td>".$Fila["v_si"]."</td>\n";
		echo "<td>".$Fila["v_cao"]."</td>\n";
		echo "<td>".$Fila["v_al2o3"]."</td>\n";
		echo "<td>".$Fila["v_mgo"]."</td>\n";
		echo "<td>".$Fila["v_sb"]."</td>\n";
		echo "<td>".$Fila["v_cd"]."</td>\n";
		echo "<td>".$Fila["v_hg"]."</td>\n";
		echo "<td>".$Fila["v_te"]."</td>\n";
		echo "<td>".$Fila["v_zn"]."</td>\n";
		echo "<td>".$Fila["v_fe3o4"]."</td>\n";
		echo "</tr>\n";
	}
?>
        </table>
        <div align="center"><br>
            <br>
            <input name="btnCerrar" type="button" id="btnCerrar" value="Cerrar" onClick="window.close()">
        </div>
    </form>
</body>

</html>