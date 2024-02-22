<?php 	
	include("../principal/conectar_principal.php");

	$Valores=explode('~',$Datos);
	$CodAsig=str_replace('*',' ',$Valores[0]);
	$CodSubProd=$Valores[1];
	$RutPrv=$Valores[2];
	$CodLey=$Valores[3];
	$Consulta="select t1.cod_recepcion,t1.cod_subproducto,t1.rut_proveedor,t1.cod_leyes,t2.descripcion, nombre_prv,valor1,valor2,valor3,valor4 from age_web.deduc_metalurgicas t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="left join sipa_web.proveedores t3 on t1.rut_proveedor=t3.rut_prv where t1.cod_recepcion<>'' ";
	$Consulta.="and t1.cod_recepcion='$CodAsig'";
	$Consulta.=" and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProd' and cod_leyes='$CodLey'";
	if($RutPrv!='T')	
		$Consulta.=" and t1.rut_proveedor='$RutPrv' ";
	$RespDeduc=mysqli_query($link, $Consulta);
	//echo $Consulta;	
	if($FilaDeduc=mysqli_fetch_array($RespDeduc))
	{
		$SubProd=$FilaDeduc["descripcion"];
		if($RutPrv=='T')
			$Prv='TODOS';
		else
			$Prv=$FilaDeduc["nombre_prv"];
		switch($CodLey)
		{
			case "02":
				$Ley='Cu';
				break;
			case "04":
				$Ley='Ag';
				break;
			case "05":
				$Ley='Au';
				break;
		}	
		$TxtValor1=$FilaDeduc[valor1];
		$TxtValor2=$FilaDeduc[valor2];
		$TxtValor3=$FilaDeduc[valor3];
		$TxtValor4=$FilaDeduc[valor4];
	
	}
	
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga3()
{
	var Frm = FrmProceso;
	Frm.action="age_parametros_deduccion_proceso2.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f=document.FrmProceso;
	switch (opt)
	{
		case "R":
			f.action="age_parametros_deduccion_proceso2.php?RecPag=S&TProceso="+f.TipoProc.value;
			f.submit();
			break;
		case "P":
			switch(f.CmbCantP.value)
			{
				case "1":
					f.TxtValor1.style.visibility='';
					f.TxtValor2.style.visibility='hidden';
					f.TxtValor3.style.visibility='hidden';
					f.TxtValor4.style.visibility='hidden';
					break;
				case "2":
					f.TxtValor1.style.visibility='';
					f.TxtValor2.style.visibility='';
					f.TxtValor3.style.visibility='hidden';
					f.TxtValor4.style.visibility='hidden';			
					break;
				case "3":
					f.TxtValor1.style.visibility='';
					f.TxtValor2.style.visibility='';
					f.TxtValor3.style.visibility='';
					f.TxtValor4.style.visibility='hidden';				
					break;
				case "4":
					f.TxtValor1.style.visibility='';
					f.TxtValor2.style.visibility='';
					f.TxtValor3.style.visibility='';
					f.TxtValor4.style.visibility='';				
					break;
			}
			f.action="age_parametros_deduccion_proceso2.php?RecPag=S&TProceso="+f.TipoProc.value;
			f.submit();			
			break;	
	}
}
function Grabar()
{
	var Frm=document.FrmProceso;
	if(Frm.CmbRecepcion.value=='S')
	{
		alert('Debe Seleccionar Asignacion');
		Frm.CmbRecepcion.focus;
		return;
	}
	if(Frm.CmbSubProducto.value=='S')
	{
		alert('Debe Seleccionar SubProducto');
		Frm.CmbSubProducto.focus;
		return;
	}
	//if(Frm.CmbProveedor.value=='T'&&Frm.CmbRecepcion.value!='MAQ ENM')
	if(Frm.CmbProveedor.value=='')
	{
		alert('Debe Seleccionar Proveedor');
		Frm.CmbProveedor.focus;
		return;
	}
	if(Frm.CmbCantP.value=='S')
	{
		alert('Debe Seleccionar Cantidad de Parametros');
		Frm.CmbCantP.focus;
		return;
	}	
	if(Frm.CmbTipoF.value=='S')
	{
		alert('Debe Seleccionar Tipo Formula');
		Frm.CmbTipoF.focus;
		return;
	}
	if(Frm.CmbLey.value=='S')
	{
		alert('Debe Seleccionar Ley');
		Frm.CmbLey.focus;
		return;
	}
	if (Frm.TipoProc.value=="M")
		Frm.action='age_parametros_deduccion01.php?Proceso=M&Formula='+Frm.CmbTipoF.options[Frm.CmbTipoF.selectedIndex].text;
		else
		Frm.action='age_parametros_deduccion01.php?Proceso=N&Formula='+Frm.CmbTipoF.options[Frm.CmbTipoF.selectedIndex].text;
	Frm.submit();
}
function Imprimir()
{
	var Frm=document.FrmProceso;
	
	Frm.BtnImprimir.style.visibility='hidden';
	Frm.BtnSalir.style.visibility='hidden';
	window.print();
	Frm.BtnImprimir.style.visibility='';
	Frm.BtnSalir.style.visibility='';
}

function Salir()
{
	window.close();
}
</script>
<title>Ingreso de Remuestreos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body onload='' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>
<form name="FrmProceso" method="post" action="">
<input type="hidden" name="Datos" value="<?php echo $Datos;?>">
<input type="hidden" name="TipoProc" value="<?php echo $TProceso;?>">
  <table width="650" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554" align="center" valign="top">
	<table width="650" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla02">
            <td align="center">Parametros Deduccion Metalurgica</td> 
          </tr>
    </table>
        <br>
        <table width="650" border="1" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="86"  align="center" class="ColorTabla02">Asignaci&oacute;n</td>
			<td colspan="3"  align="left"><select name="CmbRecepcion" style="width:200" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbRecepcion');" onChange="Proceso('R')">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$CmbMes = str_pad(date('m'),2,"0",STR_PAD_LEFT);
				$TxtFechaIni = date('Y')."-".$CmbMes."-01";
				$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,date('Y')));
				$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
				$TxtFechaIni = "2008-08-01 07:49:59";
				$TxtFechaIni = "2008-08-31 08:00:00";
				
				$Consulta = "select distinct cod_recepcion from age_web.lotes where fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				$Consulta.= " and cod_recepcion <>'' order by cod_recepcion ";
				$var1 = $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRecepcion == $Fila["cod_recepcion"])
						echo "<option selected value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
					if ($TProceso=="M" && $RecPag!="S")
					{
						if ($CodAsig == $Fila["cod_recepcion"])
							echo "<option selected value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
						else
							echo "<option value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
					}
				}
			  ?>
            </select></td>
			<?php $TipoProc = $TProceso; ?>
		  </tr>
          <tr> 
            <td width="86"  align="center" class="ColorTabla02">Producto</td>
			<td colspan="3"  align="left"><select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" onChange="Proceso('R')">
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
					if ($TProceso=="M" && $RecPag!="S")
					{
						if ($CodSubProd == $Fila["cod_subproducto"])
							echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
						else
							echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					}
				}
			  ?>
            </select></td>
		  </tr>
          <tr> 
            <td width="86"  align="center" class="ColorTabla02">Proveedor</td>
			<td colspan="3"  align="left"><select name="CmbProveedor" style="width:300" onkeydown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
              <option class="NoSelec" value="T">TODOS</option>
              <?php
				$Consulta = "select t1.rut_proveedor, t2.nombre_prv as nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' and ";
				if ($TProceso=="M" && $RecPag!="S")
					$Consulta.=" t1.cod_subproducto= '".$CodSubProd."' ";
					else
					$Consulta.=" t1.cod_subproducto= '".$CmbSubProducto."' ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' ";  		
				$Consulta.= "  order by t2.nombre_prv"; 
				$var1 = $Consulta; 				
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					if ($TProceso =="M" && $RecPag!="S")
					{
						if ($RutPrv == $Fila["rut_proveedor"])
							echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
						else
							echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					}
				}
				
			?>
            </select>
---> Filtro Prv&nbsp;
<input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
<input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
		  </tr>
          <tr> 
            <td width="86"  align="center" class="ColorTabla02">Cant.Param</td>
			<td colspan="3"  align="left"><select name="CmbCantP" onChange="Proceso('P')">
              <option class="NoSelec" value="S">Seleccionar</option>
			  <?php
			  	switch($CmbCantP)
				{
					case "1":
						echo "<option value='1' selected>1</option>";
						echo "<option value='2'>2</option>";
						echo "<option value='3'>3</option>";
						echo "<option value='4'>4</option>";						
						break;
					case "2":
						echo "<option value='1' >1</option>";
						echo "<option value='2'selected>2</option>";
						echo "<option value='3'>3</option>";
						echo "<option value='4'>4</option>";						
						break;
					case "3":
						echo "<option value='1' >1</option>";
						echo "<option value='2'>2</option>";
						echo "<option value='3' selected>3</option>";
						echo "<option value='4'>4</option>";						
						break;
					case "4":
						echo "<option value='1' >1</option>";
						echo "<option value='2' >2</option>";
						echo "<option value='3'>3</option>";
						echo "<option value='4' selected>4</option>";						
						break;
					default:
						echo "<option value='1'>1</option>";
						echo "<option value='2'>2</option>";
						echo "<option value='3'>3</option>";
						echo "<option value='4'>4</option>";						
						break;																								
				}
			  ?>

             <?php 
				
			 ?>
            </select></td>
		  </tr>		 
          <tr> 
            <td width="86"  align="center" class="ColorTabla02">Tipo Formula</td>
			<td colspan="3"  align="left"><select name="CmbTipoF">
              <option class="NoSelec" value="S">Seleccionar</option>

             <?php 
				$Consulta = "select formula,tipo_formula ";
				$Consulta.= " from age_web.deduc_metalurgicas ";
				$Consulta.= " where cant_param='".$CmbCantP."' group by cant_param,cod_leyes,tipo_formula order by tipo_formula";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbTipoF == $Fila["tipo_formula"])
						echo "<option selected value='".$Fila["tipo_formula"]."'>".$Fila["formula"]."</option>";
					else
						echo "<option value='".$Fila["tipo_formula"]."'>".$Fila["formula"]."</option>";
				}				
			 ?>
            </select><?php //echo $Consulta;?></td>
		  </tr>			   
          <tr> 
            <td width="86"  align="center" class="ColorTabla02">Ley</td>
			<td colspan="3"  align="left">
			<select name="CmbLey">
			<option class="NoSelec" value="S">Seleccionar</option>
			<?php 
			$Consulta="select * from proyecto_modernizacion.leyes where cod_leyes in('02','04','05')";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($CmbLey == $Fila["cod_leyes"])
					echo "<option selected value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>";
				else
					echo "<option value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>";
				if ($TProceso=="M")
				{
					if ($CodLey == $Fila["cod_leyes"])
						echo "<option selected value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>";
					else
						echo "<option value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>";
				}
			}			
			?>
			</select>
			</td>
		  </tr>

          <tr>
            <td  align="center" class="ColorTabla02">Valor 1 </td>
            <td colspan="3"  align="left"><input name="TxtValor1" type="text" id="TxtValor1" value="<?php echo $TxtValor1;?>" size="10"  onKeyPress="TeclaPulsada2('S',true,this.form,'TxtValor2')"></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">Valor 2 </td>
            <td width="338"  align="left"><label>
              <input name="TxtValor2" type="text" id="TxtValor2" value="<?php echo $TxtValor2;?>" size="10" maxlength="8" onKeyPress="TeclaPulsada2('S',true,this.form,'TxtValor3')">
            </label></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">Valor 3 </td>
            <td  align="left"><input name="TxtValor3" type="text" id="TxtValor3" value="<?php echo $TxtValor3;?>" size="10" maxlength="8" onKeyPress="TeclaPulsada2('S',true,this.form,'TxtValor4')"></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">Valor 4 </td>
            <td  align="left"><input name="TxtValor4" type="text" id="TxtValor4" value="<?php echo $TxtValor4;?>" size="10" maxlength="8" onKeyPress="TeclaPulsada2('S',true,this.form,'BtnGrabar')"></td>
          </tr>
        </table>
        <br>

	    <table width="650" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
			<input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar();">
			<input type="button" name="BtnImprimir" value="Imprimir" style="width:60" onClick="Imprimir();">
			<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">          </td> 
          </tr>
        </table>		
	  </td>
  </tr>
</table>
</form>
</body>
</html>