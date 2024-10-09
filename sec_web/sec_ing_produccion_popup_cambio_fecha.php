<?php	include("../principal/conectar_sec_web.php"); 
$Opcion = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
$Npeso = isset($_REQUEST["Npeso"])?$_REQUEST["Npeso"]:"";
$NFecha = isset($_REQUEST["NFecha"])?$_REQUEST["NFecha"]:"";
$Nhora = isset($_REQUEST["Nhora"])?$_REQUEST["Nhora"]:"";
$Prod = isset($_REQUEST["Prod"])?$_REQUEST["Prod"]:"";
$Fech = isset($_REQUEST["Fech"])?$_REQUEST["Fech"]:"";
$Grup = isset($_REQUEST["Grup"])?$_REQUEST["Grup"]:"";
$SubP = isset($_REQUEST["SubP"])?$_REQUEST["SubP"]:"";
$Hr = isset($_REQUEST["Hr"])?$_REQUEST["Hr"]:"";
$cod_grupo    = isset($_REQUEST["cod_grupo"])?$_REQUEST["cod_grupo"]:"";
$cmbproducto    = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";
$cmbsubproducto = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$Fecha2 = isset($_REQUEST["Fecha2"])?$_REQUEST["Fecha2"]:"";
$lado   = isset($_REQUEST["lado"])?$_REQUEST["lado"]:"";

if($Opcion=='M')
{
$Actualizar=" UPDATE produccion_catodo set peso_produccion='".$Npeso."',fecha_produccion='".$NFecha."', hora='".$Nhora."' where (cod_producto='".$Prod."') AND (cod_subproducto='".$SubP."') ";
$Actualizar.="AND (fecha_produccion='".$Fech."') AND (cod_grupo='".$Grup."')  AND (hora='".$Hr."')";
mysqli_query($link, $Actualizar);
//$f=explode("-",$NFecha);
//$fecha=date("Y-m-d", mktime(1,0,0,$f[1],($f[2] ),$f[0]))." 08:00:00";
//$Fecha2 =date("Y-m-d", mktime(1,0,0,$f[1],($f[2] + 1),$f[0]))." 07:59:59";	
$cod_grupo=$Grup;	
	
}
if($Opcion=='E')
{
	$Eliminar="delete from produccion_catodo where (cod_producto='".$Prod."') AND (cod_subproducto='".$SubP."') ";
	$Eliminar.="AND (fecha_produccion='".$Fech."') AND (cod_grupo='".$Grup."')  AND (hora='".$Hr."')";
	mysqli_query($link, $Eliminar);
	//$f=explode("-",$Fech);
//	$fecha=date("Y-m-d", mktime(1,0,0,$f[1],($f[2] ),$f[0]))." 08:00:00";

	$cod_grupo=$Grup;
//	$Fecha2 =date("Y-m-d", mktime(1,0,0,$f[1],($f[2] + 1),$f[0]))." 07:59:59";	
		
}
?>
<html>
<head>
<title>SEC- Muestra</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">


function AccionMuestra(cor,Op,grupo,prod,subprod,fec,hrs)
{	
	var f = document.frmPopUp;	
	switch(Op)
	{
		case 'M':
			if(confirm("¿Esta seguro de Modificar los Datos Ingresados?"))
			{
				
		
				var variable='';
				variable='&Npeso='+f.TxtPesoS[cor].value+'&NFecha='+f.ano[cor].value+"-"+f.mes[cor].value+"-"+f.dia[cor].value+"&Nhora="+f.hh[cor].value+":"+f.mm[cor].value+":00";
				f.action = "sec_ing_produccion_popup_cambio_fecha.php?Opcion=M&Grup="+grupo+"&Prod="+prod+"&SubP="+subprod+"&Fech="+fec+"&Hr="+hrs+variable;
				f.submit();
			}
		break;
		case 'E':
			if(confirm("¿Esta seguro de Eliminar el registro?"))
			{
				f.action = "sec_ing_produccion_popup_cambio_fecha.php?Opcion=E&Grup="+grupo+"&Prod="+prod+"&SubP="+subprod+"&Fech="+fec+"&Hr="+hrs;
				f.submit();
			}
		break;
	}
	
}
function Atras()
{	var Frm = document.frmPopUp;
	Frm.action="sec_ing_produccion_popup22.php?&fecha=<?php echo $fecha; ?>&fecha2=<?php echo $Fecha2;?>&cmbproducto=<?php echo $cmbproducto;?>&cmbsubproducto=<?php echo $cmbsubproducto;?>&grupo=<?php echo $cod_grupo;?>";
	Frm.submit();
}
/***************/
function Salir()
{	
	window.close();
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="CheckElim" value=''>
<div style="position:absolute; left: 10px; top: 2px;" id="div0">
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
        <td align="center" >Datos de Produccion</td>
  </tr>
  <tr>
        <td   ><font color="#FF0000" style=" font-weight:100">NOTA:<br>
La jornada laboral  se inicia a partir de 08:00:00 hrs  hasta las 07:59:59 hrs del día siguiente. favor de verificar horario de turnos.</font></td>
  </tr>
</table>


<?php 
	//Campos Ocultos.
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	
	echo '<input name="dia" type="hidden">';
	echo '<input name="mes" type="hidden" >';
	echo '<input name="ano" type="hidden">';
	echo '<input name="hh" type="hidden" >';
	echo '<input name="mm" type="hidden" >';
	echo '<input name="fecha" type="hidden" value="'.$fecha.'">';
	echo '<input name="TxtPesoS" type="hidden">';
	echo '<input name="Fecha2" type="hidden" value="'.$Fecha2.'">';
	echo '<div style="position:absolute; left: 0px; top: 65px; width:518px; height:200px; id="div2">';
	echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
	echo '<tr>';
	echo '<td width="50px" align="center">Grupo</td>';
	echo '<td width="80px" align="center">Peso</td>';
	echo '<td width="220px" align="center">Fecha Producción</td>';
	echo '<td width="100px" align="center">Hora</td>';	
	echo '<td width="50px" align="center"></td>';	
	echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left:0px; top: 95px; width:518px; height:223px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';


	$consulta = "SELECT *, year(fecha_produccion) as anio,month(fecha_produccion) as mes, day(fecha_produccion) as dia FROM sec_web.produccion_catodo";
	$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
	$consulta.= " AND cod_grupo = '".$cod_grupo."' AND cod_muestra = 'S' ";
	$consulta.= " ORDER BY cod_cuba";
	$rs = mysqli_query($link, $consulta);$Corr=0;
	while ($row = mysqli_fetch_array($rs))
	{
		$Corr=$Corr+1;

		$anio=$row["anio"];
		$mes=$row["mes"];
		$dia=$row["dia"];
		$hrs=explode(":",$row["hora"]);
		?><tr>
		<td width="50px"><?php echo $row["cod_grupo"];?></td>
		<td width="80px" ><input name="TxtPesoS" id="TxtPesoS" class="InputDer" value="<?php echo $row["peso_produccion"];?>" type="text" size="10"></td>
		<td width="220px">
<select name="dia" size="1">
			<?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		for ($i=1;$i<=31;$i++)
		{	
			if ($dia == $i)			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}		
	?>
	  </select><select name="mes" size="1" >
			<?php
		for($i=1;$i<13;$i++)
		{
			if ($mes == $i )
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
		  </select><select name="ano"  >
			<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if ($anio == $i )
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
		  </select>
      &nbsp; 
  
</td>
		<td  width="100px" >

    <select name="hh"  id="hh">
        <?php
		 	for($i=0; $i<=23; $i++)
			{
				if ($hrs[0]==$i)
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
      </select>:<select name="mm" id="mm">
        <?php
		 	for($i=0; $i<=59; $i++)
			{
				if ($hrs[1]==$i)
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
      </select>

</td>
	<td>
<a href="javascript:AccionMuestra('<?php echo $Corr;?>','M','<?php echo $row["cod_grupo"] ?>','<?php echo $row["cod_producto"];?>','<?php echo $row["cod_subproducto"];?>','<?php echo $row["fecha_produccion"];?>','<?php echo $row["hora"];?>')"><img src="../principal/imagenes/modificar_sea.png" class="SinBorde" alt="Modificar"></a>
<a href="javascript:AccionMuestra('<?php echo $Corr;?>','E','<?php echo $row["cod_grupo"] ?>','<?php echo $row["cod_producto"];?>','<?php echo $row["cod_subproducto"];?>','<?php echo $row["fecha_produccion"];?>','<?php echo $row["hora"];?>')"><img src="../principal/imagenes/eliminar_sea.png"  class="SinBorde" alt="Eliminar"></a>

</td>	</tr><?php
	}
	
	echo '</table>';
	echo '</div>';	
?>

<div style="position:absolute; left: 15px; top: 310px;" id="div5">
<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td align="center"><input name="btnatras" type="button" style="width:70" value="Atras" onClick="Atras()">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>