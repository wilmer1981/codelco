<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 33;	
	include("../principal/conectar_principal.php");
	if (!isset($SubProducto))
		$SubProducto="S";
	if (!isset($Proveedor))
		$Proveedor="S";
	//COLORES DE LIMITES
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15007'";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		switch ($Fila["cod_subclase"])
		{
			case 1:
				$BajoMin=$Fila["valor_subclase1"];
				break;
			case 2:
				$SobreMax=$Fila["valor_subclase1"];
				break;			
		}
	}
?>
<html>
<head>
<title>AGE-Consulta Limites</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_con_limites.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f = document.frmPrincipal;
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
		case "C": //CONSULTA	
			if (f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.SubProducto.focus();
				return;
			}
			f.action = "age_con_limites_web.php";
			f.submit();
			break;
		case "E": //EXCEL
			if (f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.SubProducto.focus();
				return;
			}
			f.action = "age_con_limites_excel.php";
			f.submit(); 
			break;
		case "R": //RECARGA
			f.action = "age_con_limites.php";
			f.submit();
			break;
		case "S": //SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=30";
			f.submit();
			break;		
	}	
}

</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="770" height="330" align="center" valign="top"><br>
        <table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
        <tr align="center" >
          <td colspan="5" class="Detalle01"><strong>Consulta de Limites </strong></td>
        </tr>
        <tr>
          <td colspan="3">Periodo:</td>
          <td colspan="2"><select name="CmbMes" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbAno');">
            <?php
	for ($i=1;$i<=12;$i++)
	{
		if (!isset($CmbMes))
		{
			if ($i == date("n"))
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}	
		else
		{
			if ($i == $CmbMes)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
?>
          </select>
            <select name="CmbAno" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbSubProducto');">
              <?php
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if (!isset($CmbAno))
		{
			if ($i == date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}	
		else
		{
			if ($i == $CmbAno)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>
            </select>
</td>
        </tr>
        <tr>
          <td colspan="3">SubProducto:</td>
          <td width="491" colspan="2"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">SELECCIONAR</option>
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
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
          </select></td>
        </tr>
        <tr>
          <td colspan="3">Proveedor:</td>
          <td colspan="2"><select name="Proveedor" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' ";  					
				$Consulta.= " order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
				}
			?>
          </select>
            ---> Filtro Prv&nbsp;
            <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
            </td>
        </tr>
        <tr>
          <td colspan="3">Plantilla: </td>
          <td colspan="2"><select name="Plantilla" style="width:300">              			  
              <?php
			  	//BUSCO PLANTILLA PARA SUBPRODUCTO PROVEEDOR
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where cod_producto='1'";
				$Consulta.= " and cod_subproducto='".$SubProducto."'";
				$Consulta.= " and rut_proveedor ='".$Proveedor."'";
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
				$Consulta.= " and cod_subproducto='".$SubProducto."'";
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
			  ?>
            </select>
            <input name="BtnVer" type="button" id="BtnConsultar" value="Ver Limites" style="width:70px " onClick="Proceso('VL')">                        </td>
        </tr>
        <tr align="center">
          <td height="18" colspan="5"><table width="200" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr align="center">
              <td width="100" bgcolor="<?php echo $BajoMin; ?>">Bajo Min. </td>
              <td width="100" bgcolor="<?php echo $SobreMax; ?>">Sobre Max</td>
              </tr>
          </table></td>
        </tr>
        <tr align="center">
          <td height="35" colspan="5">
            <input name="BtnConsultar" type="button" id="BtnOK3" value="Consultar" style="width:70px " onClick="Proceso('C')">
            <input name="BtnExcel" type="button" id="BtnExcel" value="Excel" style="width:70px " onClick="Proceso('E')">
            <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')">
          </td>
        </tr>
      </table>
      </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
