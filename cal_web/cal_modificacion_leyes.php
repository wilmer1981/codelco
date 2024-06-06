<?php
include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;

/************************************************************ */
if(isset($_REQUEST["SolA"])) {
	$SolA = $_REQUEST["SolA"];
}else{
	$SolA = "";
}
if(isset($_REQUEST["Recargo"])) {
	$Recargo = $_REQUEST["Recargo"];
}else{
	$Recargo = "";
}
if(isset($_REQUEST["Fecha"])) {
	$Fecha = $_REQUEST["Fecha"];
}else{
	$Fecha = "";
}
if(isset($_REQUEST["RutF"])) {
	$RutF = $_REQUEST["RutF"];
}else{
	$RutF = "";
}
if(isset($_REQUEST["TxtRecargo"])) {
	$TxtRecargo = $_REQUEST["TxtRecargo"];
}else{
	$TxtRecargo = "";
}

/*
if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}*/
if(isset($_REQUEST["Plantilla"])) {
	$Plantilla = $_REQUEST["Plantilla"];
}else{
	$Plantilla = "";
}
$CentroCosto = isset($_REQUEST["CentroCosto"])?$_REQUEST["CentroCosto"]:"";
$RutPlant    = isset($_REQUEST["RutPlant"])?$_REQUEST["RutPlant"]:"";
$CmbCCosto = isset($_REQUEST["CmbCCosto"])?$_REQUEST["CmbCCosto"]:"";

/************************************************************ */
$Consulta = "SELECT t1.nro_solicitud,t1.id_muestra,t4.abreviatura,t4.tipo_leyes, ";
$Consulta = $Consulta."t3.centro_costo,t3.descripcion,t5.cod_producto,t6.cod_subproducto,t1.recargo,t1.cod_analisis ";
$Consulta =	$Consulta ." from cal_web.solicitud_analisis t1  ";
$Consulta =	$Consulta."left join cal_web.leyes_por_solicitud  t2 on (t1.nro_solicitud = t2.nro_solicitud) and (t1.recargo = t2.recargo) ";
$Consulta = $Consulta ."left join proyecto_modernizacion.leyes t4 on t2.cod_leyes = t4.cod_leyes  ";
$Consulta = $Consulta."left join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto = t3.centro_costo  "; 
$Consulta = $Consulta."inner join proyecto_modernizacion.productos t5 on t1.cod_producto = t5.cod_producto "; 
$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t6 on t1.cod_subproducto = t6.cod_subproducto and t1.cod_producto = t6.cod_producto "; 
if ($Recargo=='N')
{
	$Consulta = $Consulta."where t1.nro_solicitud ='".$SolA."' "; 
}
else
{
	$Consulta = $Consulta."where t1.nro_solicitud ='".$SolA."' and t1.recargo ='".$Recargo."'"; 
}
//echo $Consulta."<br>";
$Respuesta = mysqli_query($link, $Consulta);
//Se ejecuta nueva mente la consulta asignadola a otra variable para ir llenando las leyes e impurezas dentro del ciclo
$Respuesta2 = mysqli_query($link, $Consulta);
if ($Fila = mysqli_fetch_array($Respuesta))
{
	//si recrago es nulo muestra el nro de solicitud sin recargo
	$TxtSA= $Fila ["nro_solicitud"];
	if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
	{
		$TxtSol= $Fila ["nro_solicitud"];
		$Sol= $Fila ["nro_solicitud"];
		$Rec='N';
	}		
	else 
	{
		//Si no se concatena el N� de Recargo
		$TxtSol= $Fila ["nro_solicitud"].'-'.$Fila["recargo"];
		$Sol= $Fila ["nro_solicitud"];
		$Rec=$Fila["recargo"];
	}
	$TxtLotes = $Fila ["id_muestra"]; 
	//el valor que encuentra en la consulta del centro de costo se le asigna a la variable $CCosto para mas adelante 
	//en la consulta seleccionar  el elemento seleccionado por defecto de la consulta
	$CCosto = $Fila["centro_costo"]; 
	$Producto = $Fila["cod_producto"];
	$SubProducto= $Fila["cod_subproducto"];
	//echo $Consulta."<br>";
	$Impurezas="";
	$Ley="";
	while( $Fila = mysqli_fetch_array($Respuesta2)) 
	{
		if (($Fila["tipo_leyes"] == '0')|| ($Fila["tipo_leyes"] == '3'))
		{
			$Ley = $Ley.$Fila ["abreviatura"].'-';
		}
		if ($Fila["tipo_leyes"] == '1')
		{
			$Impurezas = $Impurezas.$Fila["abreviatura"].'-'; 
		}
		$Mostrar=$Fila["cod_analisis"];
	}
	$TxtLeyes=$Ley;
	$TxtImpurezas=$Impurezas;
	/*echo "leyes1".$Leyes."<br>";
	echo "imp2".$Impurezas."<br>";
	$TxtLeyes = substr($Ley,0,strlen($Ley)-1);
	$TxtImpurezas = substr($Impurezas,0,strlen($Ley)-1);
	echo "leyes".$TxtLeyes."<br>";
	echo "imp".$TxtImpurezas."<br>";*/
	
	//asigno el tipo de anlisis , si es quimico o fisico  para ocultar los botones plantillas o personalizar 
}
if ($Plantilla!="")
{
	$CCosto=$CentroCosto;
	$Consulta ="select t3.abreviatura,t3.tipo_leyes ";
	$Consulta = $Consulta."from cal_web.plantillas t1 inner join cal_web.leyes_por_plantillas t2 on t1.rut_funcionario = t2.rut_funcionario and t1.cod_plantilla = t2.cod_plantilla ";
	$Consulta = $Consulta."inner join proyecto_modernizacion.leyes t3  on t2.cod_leyes = t3.cod_leyes "; 
	$Consulta = $Consulta."where t1.rut_funcionario = '".$RutPlant."' and t1.cod_plantilla ='".$Plantilla."'";
	$Respuesta =mysqli_query($link, $Consulta);
	$Ley="";
	$Impurezas="";	
	while ($Fila =mysqli_fetch_array($Respuesta))
	{
	if ($Fila["tipo_leyes"] == '0')
			{
				$Ley = $Ley.$Fila ["abreviatura"].'-';
			}
			if ($Fila["tipo_leyes"] == '1')
			{
				$Impurezas = $Impurezas.$Fila["abreviatura"].'-'; 
			}
	}	
	$TxtLeyes = $Ley;
	$TxtImpurezas = $Impurezas;
}
?>

<html>
<head>
<title>Modificacion de Leyes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(Opcion,Plantilla,RutPlant,Producto,SubProducto)
{

var frm=document.FrmModifica;
	switch (Opcion)
	{
		case "P":
			window.open("cal_plantillas.php?Lotes="+ frm.TxtLotes.value + "&CCosto=" + frm.CmbCCosto.value + "&SA=" + frm.TxtSA.value + "&CmbProductos="+Producto + "&CmbSubProducto="+SubProducto,"","top=200,left=35,width=620,height=230,scrollbars=no,resizable = yes");					
			break;
		
		case "G":
			frm.action="cal_modificacion_leyes01.php?SA=" + frm.TxtSA.value + "&Lotes="+frm.TxtLotes.value + "&Plantilla="+Plantilla + "&CCosto="+frm.CmbCCosto.value + "&Fecha="+frm.TxtFecha.value + "&RutF="+frm.TxtRutF.value+ "&RutPlant="+RutPlant;
			frm.submit();
			break;
	
	}	
}	
function MostrarPersonalizar(Producto,SubProducto)
{
 	var Frm = document.FrmSolicitudAut;
	window.open("cal_personalizar_plantilla.php?CmbProductos="+Producto + "&CmbSubProducto="+SubProducto + "&Salir=1","","top=150,left=20,width=780,height=450,scrollbars=no,resizable = no");
}
function MostrarLeyes(N,Sol,Recargo)
{
	
	var Frm=document.FrmSolicitud;
	window.open("cal_leyes_por_solicitud.php?Sol="+Sol+"&Rec="+Recargo +"&Opcion=3",""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
}	
 
</script> 





</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmModifica" method="post" action="">
  <?php
//Creacion de campo oculto para almacenar la fecha de creacion de la solicitus de analisis y no perder el valor  
if(!isset($TxtFecha))
{ 
 	echo "<input name='TxtFecha' type='hidden' value='".$Fecha."'>";
	$TxtFecha=$Fecha;
}
else
{
	echo "<input name='TxtFecha' type='hidden' value='".$TxtFecha."'>";
}
if(!isset($TxtRutF))
{ 
 	echo "<input name='TxtRutF' type='hidden' value='".$RutF."'>";
	$TxtRutF=$RutF;
}
else
{
	echo "<input name='TxtRutF' type='hidden' value='".$TxtRutF."'>";
}
if(!isset($TxtRecargo))
{ 
 	echo "<input name='TxtRecargo' type='hidden' value='".$Recargo."'>";
	$TxtRecargo=$Recargo;
}
else
{
	echo "<input name='TxtRecargo' type='hidden' value='".$TxtRecargo."'>";
}
?>
  <table width="542"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="524">
<table width="539"  border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr>
            <td width="521"><div align="center"><strong>Modificacion de Leyes</strong></div></td>
          </tr>
        </table>
        <br>
        <table width="540"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2"> <strong> 
              <?php
			$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  		$Resultado= mysqli_query($link, $Consulta);
			if ($Fila =mysqli_fetch_array($Resultado))
			{	
				echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
			}	  
	  		else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
			}
		
			}
		  ?>
              </strong> </td>
          </tr>
          <tr> 
            <td width="176"><div align="left">Solicitud de Analisis</div></td>
            <td width="348"><input type="text" name="TxtSol" style="width:200" value="<?php echo $TxtSol ?>"> 
              <input name="TxtSA" type="hidden" id="TxtSA2" value="<?php echo $TxtSA ?> "></td>
          </tr>
          <tr> 
            <td><div align="left">N&deg; Lotes</div></td>
            <td><input name="TxtLotes" type="text" id="TxtLotes2"style="width:200"  readonly value="<?php echo $TxtLotes  ?>"></td>
          </tr>
          <tr> 
            <td>Leyes Finos</td>
            <td><input name="TxtLeyes" type="text" readonly style="width:330" value="<?php echo $TxtLeyes; ?>"></td>
          </tr>
          <tr> 
            <td>Impurezas</td>
            <td><input name="TxtImpurezas" type="text" readonly style="width:330" value="<?php echo $TxtImpurezas; ?>"></td>
          </tr>
          <tr> 
            <td>Centro Costo</td>
            <td><strong> 
              <select name="CmbCCosto" style="width:330">
                <option value ='-1' selected>Seleccionar</option>
                <?php

				$Consulta1 = "select centro_costo,descripcion from centro_costo  where mostrar_calidad='S' order by centro_costo";
				$Respuesta1 = mysqli_query ($link, $Consulta1);
				while ($Fila1=mysqli_fetch_array($Respuesta1))
				{
					
					
					if ($Fila1["centro_costo"] == $CCosto)	
					{
						
						echo "<option value = '".$Fila1["centro_costo"]."' selected>".$Fila1["centro_costo"]." - ".ucwords(strtolower($Fila1["descripcion"]))."</option>\n"; 
					}
					else
					{		
						
						echo "<option value = '".$Fila1["centro_costo"]."'>".$Fila1["centro_costo"]." - ".ucwords(strtolower($Fila1["descripcion"]))."</option>\n"; 
					}
				}
				echo "<option value ='-1'>____________________________________________________</option>\n";
				$Consulta1 = "select centro_costo,descripcion from centro_costo  where mostrar_calidad<>'S' order by centro_costo";
				$Respuesta1 = mysqli_query ($link, $Consulta1);
				while ($Fila1=mysqli_fetch_array($Respuesta1))
				{
					
					
					if ($Fila1["centro_costo"] == $CCosto)	
					{
						
						echo "<option value = '".$Fila1["centro_costo"]."' selected>".$Fila1["centro_costo"]." - ".ucwords(strtolower($Fila1["descripcion"]))."</option>\n"; 
					}
					else
					{		
						
						echo "<option value = '".$Fila1["centro_costo"]."'>".$Fila1["centro_costo"]." - ".ucwords(strtolower($Fila1["descripcion"]))."</option>\n"; 
					}
				}
				
			?>
              </select>
              </strong></td>
          </tr>
        </table>
        <br>
        <table width="541"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="220"> <div align="right">
            <?php
			if ($Mostrar =='1')
			{	
				echo "<input name='BtnPlantillas' type='button'  value='Plantillas' onClick=\"Proceso('P','','','$Producto','$SubProducto');\">";
			}
			?>
			</div></td>
            <td width="91"><div align="center"><strong> 
                <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70" value="Grabar" onClick="Proceso('G','<?php echo $Plantilla;?>','<?php echo $RutPlant;?>');">
                </strong></div></td>
            <td width="184"><strong> 
              <?php
			  if ($Mostrar=='1')
			  {
			  	echo "<input name='BtnPersonalizar' type='Button'  style='width:80' value='Personalizar' onClick=\"MostrarPersonalizar('$Producto','$SubProducto');\">";
              	echo "&nbsp;&nbsp;&nbsp;";	
				echo "<input name='BtnLeyes' type='Button' value='Leyes' style='width:70' onClick=\"MostrarLeyes('N','$Sol','$Rec');\">";
			  }
			  ?>
              </strong></td>
          </tr>
        </table>
        <br>
        <table width="542"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="524"><div align="center">
                <input name="BtnSalir" type="button" id="BtnSalir3" value="Salir" style="width:70" onClick="JavaScript:window.close();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
