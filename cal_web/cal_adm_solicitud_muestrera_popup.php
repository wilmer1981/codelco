<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["CmbProveedores"])) {
		$CmbProveedores = $_REQUEST["CmbProveedores"];
	}else{
		$CmbProveedores='T';
	}
	if(isset($_REQUEST["Consulta"])) {
		$Consulta = $_REQUEST["Consulta"];
	}else{
		$Consulta = "";
	}
	if(isset($_REQUEST["Genera"])) {
		$Genera = $_REQUEST["Genera"];
	}else{
		$Genera = "";
	}
	if(isset($_REQUEST["R"])) {
		$R = $_REQUEST["R"];
	}else{
		$R = "";
	}
	if(isset($_REQUEST["S"])) {
		$S = $_REQUEST["S"];
	}else{
		$S = "";
	}
	if(isset($_REQUEST["CmbAnoSol"])) {
		$CmbAnoSol = $_REQUEST["CmbAnoSol"];
	}else{
		$CmbAnoSol = date("Y");
	}
	if(isset($_REQUEST["Opc"])) {
		$Opc = $_REQUEST["Opc"];
	}else{
		$Opc = "";
	}
	if(isset($_REQUEST["NSol"])) {
		$NSol = $_REQUEST["NSol"];
	}else{
		$NSol = "";
	}
	if(isset($_REQUEST["TxtRecargo"])) {
		$TxtRecargo = $_REQUEST["TxtRecargo"];
	}else{
		$TxtRecargo = "";
	}
	


?>
<html>
<head>
<?php
$Msj="";
$Boton="";

	if($Consulta=='S')
	{
		$Estado = " where t1.nro_solicitud='".$CmbAnoSol.str_pad($S,6,0,STR_PAD_LEFT)."' and t1.recargo='".$R."'";
		$Consulta = "select t1.nro_solicitud from cal_web.solicitud_analisis t1 
		left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
		$Consulta.=$Estado;
		$Respuesta= mysqli_query($link, $Consulta);
		$Msj='';$Boton='S';
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$Msj='Exis';	
			$Boton='N';
		}
	}
	if($Genera=='S')
	{
		$Cons="select * from cal_web.solicitud_analisis where nro_solicitud='".$CmbAnoSol.str_pad($S,6,0,STR_PAD_LEFT)."' and recargo<>0 order by recargo asc limit 1";
		$Res=mysqli_query($link, $Cons);
		if($F=mysqli_fetch_assoc($Res))
		{
			$Inserta="insert into cal_web.solicitud_analisis (rut_funcionario,fecha_hora,id_muestra,recargo,nro_solicitud,peso_muestra,cod_ccosto,cod_area,cod_periodo,cod_producto,cod_subproducto,
					  cod_analisis,cod_tipo_muestra,leyes,impurezas,enabal,tipo_solicitud,estado_actual,rut_proveedor,peso_retalla,observacion,agrupacion,fecha_muestra,nro_semana,a�o,mes,frx,tipo)";
			$Inserta.="values ('".$F["rut_funcionario"]."','".$F["fecha_hora"]."','".$F["id_muestra"]."','".$R."','".$F["nro_solicitud"]."'";
			if($F["peso_muestra"]=='')
				$Inserta.=",null";
			else	
				$Inserta.=",'".$F["peso_muestra"]."'";
			
			$Inserta.=",'".$F["cod_ccosto"]."','".$F["cod_area"]."','".$F["cod_periodo"]."','".$F["cod_producto"]."','".$F["cod_subproducto"]."',
					  '".$F["cod_analisis"]."','".$F["cod_tipo_muestra"]."','".$F["leyes"]."','".$F["impurezas"]."','".$F["enabal"]."','".$F["tipo_solicitud"]."','".$F["estado_actual"]."','".$F["rut_proveedor"]."'";
			if($F["peso_retalla"]=='')
				$Inserta.=",null";
			else	
				$Inserta.=",'".$F["peso_retalla"]."'";
			$Inserta.=",'".$F["observacion"]."','".$F["agrupacion"]."','".$F["fecha_muestra"]."','".$F["nro_semana"]."','".$F["año"]."','".$F["mes"]."','".$F["frx"]."','".$F["tipo"]."')";
			//echo $Inserta."<br>";
			mysqli_query($link, $Inserta);
		
			$Cons="select * from cal_web.leyes_por_solicitud where nro_solicitud='".$CmbAnoSol.str_pad($S,6,0,STR_PAD_LEFT)."' and recargo<>0 order by recargo asc limit 1";
			$Res=mysqli_query($link, $Cons);
			if($F=mysqli_fetch_assoc($Res))
			{
				$Inserta="INSERT INTO cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,
						  activa,candado,valor,cod_producto,cod_subproducto,id_muestra,peso_humedo,peso_seco,signo,proceso,rut_quimico,virtual,valor2,observacion)";
				$Inserta.="values('".$F["rut_funcionario"]."','".$F["fecha_hora"]."','".$F["nro_solicitud"]."','".$R."','".$F["cod_leyes"]."','".$F["cod_unidad"]."',
						  '".$F["activa"]."','".$F["candado"]."'";
				if($F["valor"]=='')
					$Inserta.=",null";
				else			  
					$Inserta.=",'".$F["valor"]."'";				
				$Inserta.=",'".$F["cod_producto"]."','".$F["cod_subproducto"]."','".$F["id_muestra"]."'";
				if($F["peso_humedo"]=='')
					$Inserta.=",null";
				else		
					$Inserta.=",'".$F["peso_humedo"]."'";
				if($F["peso_seco"]=='')
					$Inserta.=",null";
				else		
					$Inserta.=",'".$F["peso_seco"]."'";
				$Inserta.=",'".$F["signo"]."','".$F["proceso"]."','".$F["rut_quimico"]."','".$F["virtual"]."'";
				if($F["valor2"]=='')
					$Inserta.=",null";
				else		
					$Inserta.=",'".$F["valor2"]."'";
				$Inserta.=",'".$F["observacion"]."')";	
				//echo $Inserta."<br>";
				mysqli_query($link, $Inserta);
			}
			
			$Cons="select * from cal_web.estados_por_solicitud where nro_solicitud='".$CmbAnoSol.str_pad($S,6,0,STR_PAD_LEFT)."' and recargo<>0 order by recargo asc limit 1";
			$Res=mysqli_query($link, $Cons);
			if($F=mysqli_fetch_assoc($Res))
			{
				$Inserta="insert into cal_web.estados_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_estado,ult_atencion,rut_proceso)";
				$Inserta.="values('".$F["rut_funcionario"]."','".$F["fecha_hora"]."','".$F["nro_solicitud"]."','".$R."','".$F["cod_estado"]."','".$F["ult_atencion"]."','".$F["rut_proceso"]."')";	
				//echo $Inserta."<br>";
				mysqli_query($link, $Inserta);
			}
			$Msj='G';
		}
		else
			$Msj='Nr';
	}

	echo "<title>Agrega Recargo</title>";
?>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "B":
			if(f.NSol.value=='')
			{
				alert("Debe Ingresar N° Solicitud.");
				f.NSol.focus();
				return;
			}
			if(f.TxtRecargo.value=='-1')
			{
				alert("Debe Ingresar Recargo");
				f.TxtRecargo.focus();
				return;
			}
			f.action = "cal_adm_solicitud_muestrera_popup.php?Consulta=S&S="+f.NSol.value+"&R="+f.TxtRecargo.value;
			f.submit();
			break;
		case "G":
			if(f.NSol.value=='')
			{
				alert("Debe Ingresar N° Solicitud.");
				f.NSol.focus();
				return;
			}
			if(f.TxtRecargo.value=='-1')
			{
				alert("Debe Ingresar Recargo");
				f.TxtRecargo.focus();
				return;
			}
			f.action = "cal_adm_solicitud_muestrera_popup.php?Genera=S&S="+f.NSol.value+"&R="+f.TxtRecargo.value;
			f.submit();		
		break;	
		case "R"://recarga pagina
			f.action ="cal_clasificacion_metodos_plasma_proceso.php?Opc=N";  
			f.submit();
		break;
		case "S": //Cancelar	
			window.opener.document.FrmMuestras.action="cal_adm_solicitud_muestrera.php";
		window.opener.document.FrmMuestras.submit();		
		window.close();
		break
	}
}

function Mensaje(Msj)
{
	if(Msj=='Exis')
	{
		alert('Recargo Existente para Solicitud.');
		return;
	}
	if(Msj=='Nr')
	{
		alert('Solicitud no tiene Recargos distinto al 0');
		return;
	}
	if(Msj=='G')
	{
		alert('Recargo Generado para Solicitud');
		window.opener.document.FrmMuestras.action="cal_adm_solicitud_muestrera.php";
		window.opener.document.FrmMuestras.submit();		
		window.close();	
		return;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body onLoad="Mensaje('<?php echo $Msj;?>')">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post">

<table width="400"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><?php
	echo " Agregar Recargo:";		
	?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td width="92" class="Colum01">Solicitud</td>
	<td class="Colum01"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
	  <select name="CmbAnoSol" size="1" style="width:70px;">
	    <?php
    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
    {
    if (isset($CmbAnoSol))
    {
        if ($i==$CmbAnoSol)
            {
                echo "<option selected value ='$i'>$i</option>";
            }
        else	
            {
                echo "<option value='".$i."'>".$i."</option>";
            }
    }
    else
    {
        if ($i==date("Y"))
            {
				$CmbAnoSol=$i;
                echo "<option selected value ='$i'>$i</option>";
            }
        else	
            {
                echo "<option value='".$i."'>".$i."</option>";
            }
    }		
    }
    ?>
	    </select>
      <input name="NSol" type="text" value="<?php echo $NSol; ?>" maxlength="6" style="width:47">
    </font></font></strong></font></font></font></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>	
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Recargo</td>
    <td class="Colum01"><font size="1"><font size="2"><strong>
      <input type="text" name="TxtRecargo" id="TxtRecargo" size="3" maxlength="2" value="<?php echo $TxtRecargo; ?>">
    </strong></font><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
    <input name="BtnBuscar" type="submit" id="BtnBuscar4" value="Buscar" onClick="Proceso('B');">
    </font></font></font></font></strong></font></font></font></font></font></td>
    </tr>
  </table><br>
<table width="400"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
    <tr class="Colum01">
    <td colspan="2" align="center" class="Colum01">
    <?php if($Boton=='S'){?><input name="BtnBuscar" type="submit" id="BtnBuscar4" value="Generar Recargo" style="width:100px;" onClick="Proceso('G');"><?php }?>
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
</form>
</body>
</html>
