<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 77;
	include("../principal/conectar_principal.php");
	if(!isset($CmbMes))
	{
		$CmbMes=date('m');
		$CmbAno=date('Y');
	}┐	
	//echo $CmbMes."<br>";
	//*echo $CmbAno; 		
?>
<html>
<head>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_con_resumen_recepcion_lotes.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action="age_con_resumen_recepcion_lotes_web.php";
			f.submit();
			break;
		case "C2":
			f.action="age_con_resumen_recepcion_lotes_web2.php";
			f.submit();
			break;
		case "E":
			f.action="age_con_resumen_recepcion_lotes_excel.php";
			f.submit();
			break;
		case "E2":
			f.action="age_con_resumen_recepcion_lotes_excel2.php";
			f.submit();
			break;

		case "R":
			f.action="age_con_resumen_recepcion_lotes.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=70&Nivel=1";
			f.submit();
			break;
	}
}
</script>
<title>Resumen Compra por Vendedor</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle">
	  <table width="654" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td class="Detalle02">&gt;&gt;Periodo:</td>
            <td align="left">
			<select name="CmbMes" id="Mes" onChange="Proceso('R')">
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
            <td align="left"><select name="CmbRecepcion" style="width:200" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbRecepcion');" onChange="Proceso('R')">
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
            <td align="left"><select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" onChange="Proceso('R')">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
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
            <td class="Detalle02">&gt;&gt;Proveedor:</td>
            <td align="left"><select name="CmbProveedor" style="width:300" onkeydown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select t1.rut_proveedor, t2.nombre_prv as nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' ";  		
				$Consulta.= "  order by t2.nombre_prv";  				
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
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">            </td>
          </tr>
          <tr> 
            <td width="116" class="Detalle02">&gt;&gt;Ver:</td>
            <td width="499" align="left"><input name="OptLeyes" type="checkbox" value="S" checked>
              Leyes
                <input name="OptFinos" type="checkbox" value="S" checked>
            Finos</td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
              <input type="hidden" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="hidden" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
			  <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C2');">			  
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E2');">
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