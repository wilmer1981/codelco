<?php 	
	include("../principal/conectar_principal.php");

	$Valores=explode('~',$Datos);
	$CodAsig=str_replace('*',' ',$Valores[0]);
	$CodSubProd=$Valores[1];
	$RutPrv=$Valores[2];
	$CodLey=$Valores[3];
	$Consulta="select t1.cod_recepcion,t1.cod_subproducto,t1.rut_proveedor,t1.cod_leyes,t2.descripcion, nombre_prv,valor1,valor2,valor3,valor4,t1.cant_param,t1.formula ";
	$Consulta.="from age_web.deduc_metalurgicas t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="left join sipa_web.proveedores t3 on t1.rut_proveedor=t3.rut_prv where t1.cod_recepcion<>'' ";
	$Consulta.="and t1.cod_recepcion='$CodAsig'";
	$Consulta.=" and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProd' and cod_leyes='$CodLey'";
	if($RutPrv!='T')	
		$Consulta.=" and t1.rut_proveedor='$RutPrv' ";
		else
		$Consulta.=" and t1.rut_proveedor = 'T'";
	$RespDeduc=mysqli_query($link, $Consulta);
	//echo $Consulta."</br>";;	
	if($FilaDeduc=mysqli_fetch_array($RespDeduc))
	{
		$SubProd=$FilaDeduc["descripcion"];
		if($RutPrv=='T')
			$Prv='TODOS';
		else
			$Prv=$FilaDeduc["nombre_prv"];
		$CantP=$FilaDeduc[cant_param];
		$Formula=$FilaDeduc[formula];
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
function Grabar()
{
	var Frm=document.FrmProceso;

	Frm.action='age_parametros_deduccion01.php?Proceso=G&Valores='+Frm.Datos.value;
	Frm.submit();	
}
function Proceso(tipo)
{
	var Frm=document.FrmProceso;

	switch (tipo)
	{
		case "G":
			Frm.action='age_parametros_deduccion01.php?Proceso=G&Valores='+Frm.Datos.value;
			Frm.submit();	
			break;
		case "E":
			if (confirm("Esta seguro de Elimnar Registro"))
			{
				Frm.action='age_parametros_deduccion01.php?Proceso=E&Valores='+Frm.Datos.value;
				Frm.submit();	
				break;
			}
			else
			{
				return;
			}
		case "M":
			var Valores = "";
			Valores = Frm.Casig.value+"~"+Frm.Cprod.value+"~"+Frm.Cprov.value+"~"+Frm.Cley.value;
			Frm.action='age_parametros_deduccion_proceso2.php?TProceso=M&Datos='+Valores;
			Frm.submit();	
			break;
	}
	
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
<input type="hidden" name="Casig" value="<?php echo $CodAsig;?>">
<input type="hidden" name="Cprod" value="<?php echo $CodSubProd;?>">
<input type="hidden" name="Cprov" value="<?php echo $RutPrv;?>">
<input type="hidden" name="Cley" value="<?php echo $CodLey;?>">

  <table width="600" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554" align="center" valign="top">
	<table width="550" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla02">
            <td align="center">Parametros Deduccion Metalurgica</td> 
          </tr>
    </table>
        <br>
        <table width="550" border="1" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="111"  align="center" class="ColorTabla02">Asignaci&oacute;n</td>
			<td colspan="3"  align="left"><strong><?php echo $CodAsig;?></strong>&nbsp;</td>
		  </tr>
          <tr> 
            <td width="111"  align="center" class="ColorTabla02">Producto</td>
			<td colspan="3"  align="left"><strong><?php echo $SubProd;?></strong>&nbsp;</td>
		  </tr>
          <tr> 
            <td width="111"  align="center" class="ColorTabla02">Proveedor</td>
			<td colspan="3"  align="left"><strong><?php echo $Prv;?></strong>&nbsp;</td>
		  </tr>
          <tr> 
            <td width="111"  align="center" class="ColorTabla02">Cant.Param</td>
			<td colspan="3"  align="left"><strong><?php echo $CantP;?></strong>&nbsp;</td>
		  </tr>
          <tr> 
            <td width="111"  align="center" class="ColorTabla02">Tipo Formula</td>
			<td colspan="3"  align="left"><strong><?php echo $Formula;?></strong>&nbsp;</td>
		  </tr>		  		  
          <tr> 
            <td width="111"  align="center" class="ColorTabla02">Ley</td>
			<td colspan="3"  align="left"><strong><?php echo $Ley;?></strong>&nbsp;</td>
		  </tr>

          <tr>
            <td  align="center" class="ColorTabla02">Valor 1 </td>
            <td colspan="3"  align="left"><input name="TxtValor1" type="text" id="TxtValor1" value="<?php echo $TxtValor1;?>" size="10"  onKeyPress="TeclaPulsada2('S',true,this.form,'TxtValor2')"></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">Valor 2 </td>
            <td width="275"  align="left"><label>
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
	    <table width="550" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
			<input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Proceso('G');">
			<input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="Proceso('M');">
			<input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="Proceso('E');">
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