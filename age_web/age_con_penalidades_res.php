<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 59;
	include("../principal/conectar_principal.php");
	if (!isset($ChkDetalle))
		$ChkDetalle="L";
?>
<html>
<head>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function CargaParametros(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "LEY":
			URL="age_seleccion_leyes_penalidades.php?Plantilla="+f.Plantilla.value;
			break;
	}	
	window.open(URL,"","top=30,left=30,width=600,height=500,scrollbars=yes,resizable=yes");
}
function Recarga3()
{
	var Frm=document.frmPrincipal;
	Frm.action="age_con_penalidades_res.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			if(f.TxtCodLeyes.value=='')
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_penalidades_web.php";
			f.submit();
			break;
		case "C2":
			if(f.TxtCodLeyes.value=='')
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_penalidades_web2_res.php";
			f.submit();
			break;
		case "E":
			f.action="age_con_penalidades_excel.php";
			f.submit();
			break;
		case "E2":
			f.action="age_con_penalidades_excel2.php";
			f.submit();
			break;
		case "R":
			f.action="age_con_penalidades_res.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=80&Nivel=1";
			f.submit();
			break;
	}
}
</script>
<title>Age-Web Consulta Penalidades</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle">
	  <table width="603" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr align="center" class="Detalle01">
            <td colspan="2">FILTROS CONSULTA</td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Periodo:</td>
            <td align="left"><select name="CmbMes" id="Mes" onChange="Proceso('R')">
              <?php
				for ($i=1;$i<=12;$i++)
				{
					if (isset($CmbMes))
					{
						if ($i==$CmbMes)
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
					}
					else
					{
						if ($i==date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
					}
				}
			?>
            </select>
            <select name="CmbAno" id="Ano" onChange="Proceso('R')">
            <?php
				for ($i=date("Y")-1;$i<=date("Y");$i++)
				{
					if (isset($CmbAno))
					{
						if ($i==$CmbAno)
							echo "<option selected value='".$i."'>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
					else
					{
						if ($i==date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
				}
			 ?>
             </select></td>
          </tr>		  
          <tr>
            <td class="Detalle02">&gt;&gt;Asignacion:</td>
            <td align="left"><select name="CmbRecepcion" style="width:200" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" >
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
				$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
				$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
				$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
				$Consulta = "select distinct cod_recepcion from age_web.lotes where fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				$Consulta.= " and cod_recepcion <>'' order by cod_recepcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRecepcion == $Fila["cod_recepcion"])
						echo "<option selected value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
				}
			  ?>
            </select></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;SubProducto:</td>
            <td align="left">              <select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" onChange="Proceso('R')">
                <option class="NoSelec" value="S">TODOS</option>
                <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
    echo $Consulta;
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
            <td width="109" class="Detalle02">&gt;&gt;Proveedor:</td>
          <td width="475" align="left"><select name="CmbProveedor" style="width:300" onkeydown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select t1.rut_proveedor, t2.nombre_prv as nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' ";  
				$Consulta.= "order by t2.nombre_prv";   
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
				}
			?>
          </select>
            ---> Filtro Prv&nbsp;
            <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
            </tr>
          <tr align="center" valign="middle" class="Detalle01">
            <td colspan="2">
<?php
switch ($ChkDetalle)
{
	case "L":
		echo "<input checked name=\"ChkDetalle\" type=\"radio\" value=\"L\">Detalle Lotes&nbsp;&nbsp;\n";
		echo "<input name=\"ChkDetalle\" type=\"radio\" value=\"P\">Acumulado Proveedor\n"; 
		break;	
	case "P":
		echo "<input name=\"ChkDetalle\" type=\"radio\" value=\"L\">Detalle Lotes&nbsp;&nbsp;\n";
		echo "<input checked name=\"ChkDetalle\" type=\"radio\" value=\"P\">Acumulado Proveedor\n"; 
		break;	
}

?>
</td>
          </tr>
          <tr align="center" class="Detalle01">
            <td colspan="2">SELECCION DE PLANTILLA PENALIDADES </td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;SubProducto:</td>
            <td align="left"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">GENERICA</option>
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
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Proveedor:</td>
            <td align="left"><select name="Proveedor" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">GENERICA</option>
              <?php
				$Consulta = "select * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				if($Busq=='S'&&$TxtFiltroPrv2!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv2."%' ";  				
				$Consulta.= " order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
				}
			?>
            </select>
              ---> Filtro Prv&nbsp;
              <input type="text" name="TxtFiltroPrv2" size="10" value="<?php echo $TxtFiltroPrv2;?>">
              <input name="BtnOkA22" type="button" value="Ok" onClick="Recarga3()"></td>
          </tr>
          <tr> 
            <td width="109" class="Detalle02">&gt;&gt;Plantilla:</td>
            <td width="475" align="left"><select name="Plantilla" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">GENERICA</option>
              <?php
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where tipo='P' and cod_producto='1'";
				if ($SubProducto=="S")
					$Consulta.= " and cod_subproducto='0'";
				else
					$Consulta.= " and cod_subproducto='".$SubProducto."'";
				if ($Proveedor=="S")
					$Consulta.= " and rut_proveedor='99999999-9'";
				else
					$Consulta.= " and rut_proveedor ='".$Proveedor."'";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Plantilla == $Fila["cod_plantilla"])
						echo "<option selected value='".$Fila["cod_plantilla"]."'>".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_plantilla"]."'>".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
            </select><?php //echo $Consulta;?>
          </tr>
          <tr> 
            <td width="109" class="Detalle02">&gt;&gt;Definir:</td>
            <td width="475" align="left">
                <input name="BtnLeyes" type="button" id="BtnLeyes2" value="Definir" readonly="true" onClick="CargaParametros('LEY')">
                 <input name="TxtLeyesMuestra" type="text" class="InputColor" size="50" readonly="true" value='<?php echo $TxtLeyesMuestra;?>'><input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="button" name="BtnConsulta2" value="Cons. con Ponder." style="width:120" onClick="Proceso('C2');">
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
			  <input type="button" name="BtnExcel2" value="Excel con Ponder." style="width:120" onClick="Proceso('E2');">			    
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br> 
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>
