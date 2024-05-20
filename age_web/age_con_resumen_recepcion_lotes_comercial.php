<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 84;
	include("../principal/conectar_principal.php");

	$CookieRut = $_COOKIE["CookieRut"];
	$Busq       = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$CmbMes     = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:str_pad(date('m'),2,"0",STR_PAD_LEFT);
	$CmbAno     = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
	$TxtFechaCon     = isset($_REQUEST["TxtFechaCon"])?$_REQUEST["TxtFechaCon"]:date("Y-m-d");
	$TxtLeyesMuestra = isset($_REQUEST["TxtLeyesMuestra"])?$_REQUEST["TxtLeyesMuestra"]:"";
	$CmbRecepcion      = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$CmbSubProducto   = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor     = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$EncontroRelacion  = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$TxtCodLeyes       = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:"";


	if($TxtLeyesMuestra=="")
	{	
		$TxtLeyesMuestra='Cu,Ag,Au';
		$TxtCodLeyes="02~Cu~1~100~%~2//04~Ag~4~1000~g/T~3//05~Au~4~1000~g/T~3";
	}
	$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Nivel=$Fila["nivel"];
	//echo $Nivel;		
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
			URL="age_seleccion_leyes.php";
			break;
	}	
	window.open(URL,"","top=30,left=30,width=600,height=500,scrollbars=yes,resizable=yes");
}
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_con_resumen_recepcion_lotes_comercial.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			if(f.TxtLeyesMuestra.value=="")
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_resumen_recepcion_lotes_comercial_web3.php";
			f.submit();
			break;
		case "CFP"://PARA RPUEBA DE FINOS PAGABLES
			if(f.TxtLeyesMuestra.value=="")
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_resumen_recepcion_lotes_comercial_web4.php";
			f.submit();
			break;
		case "XFP"://PARA RPUEBA DE FINOS PAGABLES EXCEL
			if(f.TxtLeyesMuestra.value=="")
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_resumen_recepcion_lotes_comercial_excel4.php";
			f.submit();
			break;
		case "CP":
			if(f.TxtLeyesMuestra.value=="")
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_resumen_recepcion_lotes_comercial_web3.php";
			f.submit();
			break;
		case "CE":
			if(f.TxtLeyesMuestra.value=="")
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_resumen_recepcion_lotes_comercial_excel3.php";
			f.submit();
			break;
		case "E":
			if(f.TxtLeyesMuestra.value=="")
			{
				alert('Debe Definir Leyes');
				f.BtnLeyes.focus();
				return;
			}
			f.action="age_con_resumen_recepcion_lotes_comercial_excel3.php";
			f.submit();
			break;
		case "R":
			f.action="age_con_resumen_recepcion_lotes_comercial.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=80&Nivel=1";
			f.submit();
			break;
	}
}
</script>
<title>Resumen Compra por Vendedor Comercial</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle">
	  <table width="635" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
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
				for ($i=date("Y")-3;$i<=date("Y");$i++)
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
             </select>            </td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;&nbsp;Fec Comercial:</td>
            <td align="left"><input name="TxtFechaCon" type="text" class="InputCen" value="<?php echo $TxtFechaCon; ?>" size="15" maxlength="10" >
            <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="17" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaCon,TxtFechaCon,popCal);return false">			</td>
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
            </select>
			<?php //echo $Consulta."<br>";?>
		    </td>
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
				$Consulta = "select STRAIGHT_JOIN t1.rut_proveedor, t2.nombre_prv as nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' "; 
				 $Consulta.= " order by t2.nombre_prv"; 					
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
            </td>
          </tr>
		  
          <tr> 
            <td width="126" class="Detalle02">&gt;&gt;Ver:</td>
            <td width="490" align="left"><input name="OptLeyes" type="checkbox" value="S" checked>
              Leyes
                           
                <input name="OptFinos" type="checkbox" value="S" checked>
            Finos</td>
          </tr>
          <tr> 
            <td width="126" class="Detalle02">&gt;&gt;Definir:</td>
            <td width="490" align="left">
                <input name="BtnLeyes" type="button" id="BtnLeyes2" value="Definir" readonly onClick="CargaParametros('LEY')">
                 <input name="TxtLeyesMuestra" type="text" class="InputColor" size="50" readonly value='<?php echo $TxtLeyesMuestra;?>'><input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="hidden" name="BtnConsulta2" value="Prueba Web" style="width:90" onClick="Proceso('CP');">
			  <input type="hidden" name="BtnConsulta22" value="Prueba Excel" style="width:90" onClick="Proceso('CE');">
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
		    <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
					
		    </td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
		    <input type="hidden" name="CheckAnt" value="checkbox">
			<?php
			//if($Nivel==1)
			//{
			?>
			<input type="button" name="BtnConsulta" value="Deduc y FP Web" style="width:120" onClick="Proceso('CFP');">
			<input type="button" name="BtnConsulta" value="Deduc y FP Excel" style="width:120" onClick="Proceso('XFP');">
			<?php
			//}
			?>			</td>
			
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