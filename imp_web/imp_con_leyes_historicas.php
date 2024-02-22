<?php 
	$CodigoDeSistema = 05;
	$CodigoDePantalla = 4;

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}
	if(isset($_REQUEST["CmbProveedor"])){
		$CmbProveedor = $_REQUEST["CmbProveedor"];
	}else {
		$CmbProveedor = "";
	}
	

	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else {
		$CmbSubProducto = "";
	}


	include("../principal/conectar_principal.php");
	//NIVEL DEL USUARIO
	$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema='15'";
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Resp))
		$Nivel=$Fila["nivel"];
	else
		$Nivel=0;
	//-----------------
	if (!isset($CmbAnoIni))
	{
		$CmbAnoIni=2000;
		$CmbAnoFin=date("Y");
	}
?>
<html>
<head >
<title>IMP-Consulta Leyes Historicas</title>
<meta charset="iso-8859-1">
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "VL": //VER LISTADO DE PLANTILLAS
			if (f.Plantilla.value=="S")
			{
				alert("Debe Seleccionar Plantilla");
				f.Plantilla.focus();
				return;
			}
			window.open("age_ing_limites03.php?SoloVer=S&CodPlantilla="+f.Plantilla.value,"","top=20,left=30,width=650,height=450,scrollbars=yes,resizable=yes");
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=5";
			f.submit();
			break;
		case "C":
			if (f.CmbSubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.CmbAnoIni.value>f.CmbAnoFin.value)
			{
				alert("El A�o de Inicio no puede ser Mayor al Final");
				f.CmbAnoIni.focus();
				return;
			}
			f.action = "imp_con_leyes_historicas_mensual.php";
			f.submit();
			break;		
		case "R":
			f.action = "imp_con_leyes_historicas.php";
			f.submit();
			break;
	}
}
//-->
</script>
</head>

<body bgcolor="FFFFFF" leftmargin="3" topmargin="2" marginwidth="0" marginheight="0" link="#FFFF33" vlink="#FFFF33" alink="#FFFF33">
<form name="frmPrincipal" action="" method="post">
<?php 
	include("../principal/encabezado.php");
	include("../principal/conectar_imp_web.php");
?>
  <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="300" align="center" valign="middle">
          <table width="579" height="169" border="13" cellpadding="3" cellspacing="0" class="TablaInterior">
            <tr align="center" class="ColorTabla01">
              <td height="15" colspan="3"><strong>LEYES HISTORICAS</strong></td>
            </tr>
            <tr> 
              <td width="13" height="22" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> 
              </td>
              <td width="79">SubProducto:</td>
              <td width="460"><select name="CmbSubProducto" style="width:300" onChange="Proceso('R')">
                <option class="NoSelec"  value="S">SELECCIONAR</option>
                <?php
				$Consulta = "SELECT cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " FROM proyecto_modernizacion.subproducto ";
				$Consulta.= " WHERE cod_producto='1' ";
				$Consulta.= " ORDER BY orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
              </select></td>
            </tr>
            <tr>
              <td height="22" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
              <td height="22">Proveedor:</td>
              <td><select name="CmbProveedor" style="width:300" onChange="Proceso('R')">
                <option class="NoSelec" value="S">TODOS</option>
                <?php
				if (isset($CmbSubProducto) && $CmbSubProducto != "S")
				{
					$Consulta = "SELECT t1.RUTPRV_A, t1.NOMPRV_A ";
					$Consulta.= " FROM rec_web.proved t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rutprv_a = t2.rut_proveedor  ";
					$Consulta.= " WHERE t2.cod_producto='1' and t2.cod_subproducto='".$CmbSubProducto."'";			
					$Consulta.= " ORDER BY trim(t1.nomprv_a)";
				}
				else
				{
					$Consulta = "SELECT t1.RUTPRV_A, t1.NOMPRV_A ";
					$Consulta.= " FROM rec_web.proved t1  ";
					$Consulta.= " ORDER BY trim(t1.nomprv_a)";
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
				}
			?>
              </select></td>
            </tr>
            <!--
			<tr>
              <td height="22" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
              <td height="22">Plantilla:</td>
              <td><select name="Plantilla" style="width:300">
                <?php
			  	/*
				//BUSCO PLANTILLA PARA SUBPRODUCTO PROVEEDOR
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where cod_producto='1'";
				$Consulta.= " and cod_subproducto='".$CmbSubProducto."'";
				$Consulta.= " and rut_proveedor ='".$CmbProveedor."'";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				$Encontro01=false;
				$i=1;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Encontro01=true;
					if ($i==1)
						echo "<option class='NoSelec' value='S'>.::PLANTILLA ESPECIFICA::.</option>\n";
					if ($Plantilla == $Fila["cod_plantilla"])
						echo "<option selected value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
					$i++;
				}	
				//BUSCO PLANTILLA PARA SUBPRODUCTO				
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where cod_producto='1'";
				$Consulta.= " and cod_subproducto='".$CmbSubProducto."'";
				$Consulta.= " and rut_proveedor='99999999-9'";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				$Encontro02=false;
				$i=1;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Encontro02=true;
					if ($i==1)
						echo "<option class='NoSelec' value='S'>.::PLANTILLA SUBPRODUCTO::.</option>";
					if ($Plantilla == $Fila["cod_plantilla"])
						echo "<option selected value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
					$i++;
				}
				//BUSCO PLANTILLAS EN GENERAL				
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where cod_producto='1'";
				$Consulta.= " and cod_subproducto='0'";
				$Consulta.= " and rut_proveedor='99999999-9'";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				$Encontro03=false;
				$i=1;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Encontro03=true;
					if ($i==1)
						echo "<option class='NoSelec' value='S'>.::PLANTILLA GENERICAS::.</option>";
					if ($Plantilla == $Fila["cod_plantilla"])
						echo "<option selected value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
					$i++;
				}
				if (!$Encontro01 && !$Encontro02 && !$Encontro03)
					echo "<option class='NoSelec' value='S'>NO HAY PLANTILLAS</option>";
			*/		
			  ?>
              </select>
              <input name="BtnVer" type="hidden" id="BtnVer" value="Ver Limites" style="width:70px " onClick="Proceso('VL')"></td>
            </tr>
			-->
			 <input name="Plantilla" type="hidden"  value="S"></td>
            <tr>
              <td height="22" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> </td>
              <td height="22">Rango:</td>
              <td><select name="CmbAnoIni" id="CmbAnoIni">
<?php
	for ($i=1996;$i<=date("Y");$i++)
	{
		if ($CmbAnoIni==$i)
			echo "<option selected value='".$i."'>".$i."</option>\n";
		else
			echo "<option value='".$i."'>".$i."</option>\n";
	}
?>			  
              </select>
                Al 
                <select name="CmbAnoFin" id="CmbAnoFin">
<?php
	for ($i=1996;$i<=date("Y");$i++)
	{
		if ($CmbAnoFin==$i)
			echo "<option selected value='".$i."'>".$i."</option>\n";
		else
			echo "<option value='".$i."'>".$i."</option>\n";
	}
?>							
                </select></td>
            </tr>
            <tr align="center">
              <td height="40" colspan="3"><input name="BtnConsultar" type="button" id="BtnConsultar" value="Consultar" onClick="Proceso('C')" style="width:70px ">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
            </tr>
        </table>
      </td>
    </tr>
  </table>
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
