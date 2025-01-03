<?php
include("../principal/conectar_sea_web.php");
$CodigoDeSistema=2;

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
$hora     = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto   = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";

$Fis_Vent   = isset($_REQUEST["Fis_Vent"])?$_REQUEST["Fis_Vent"]:"";
$Quim_Vent  = isset($_REQUEST["Quim_Vent"])?$_REQUEST["Quim_Vent"]:"";
$Calaf_Vent = isset($_REQUEST["Calaf_Vent"])?$_REQUEST["Calaf_Vent"]:"";
$Ana_Vent   = isset($_REQUEST["Ana_Vent"])?$_REQUEST["Ana_Vent"]:"";

$Fis_HMadres   = isset($_REQUEST["Fis_HMadres"])?$_REQUEST["Fis_HMadres"]:"";
$Quim_HMadres  = isset($_REQUEST["Quim_HMadres"])?$_REQUEST["Quim_HMadres"]:"";
$Calaf_HMadres = isset($_REQUEST["Calaf_HMadres"])?$_REQUEST["Calaf_HMadres"]:"";
$Ana_HMadres   = isset($_REQUEST["Ana_HMadres"])?$_REQUEST["Ana_HMadres"]:"";

$Fis_Teniente   = isset($_REQUEST["Fis_Teniente"])?$_REQUEST["Fis_Teniente"]:"";
$Quim_Teniente  = isset($_REQUEST["Quim_Teniente"])?$_REQUEST["Quim_Teniente"]:"";
$Calaf_Teniente = isset($_REQUEST["Calaf_Teniente"])?$_REQUEST["Calaf_Teniente"]:"";
$Ana_Teniente   = isset($_REQUEST["Ana_Teniente"])?$_REQUEST["Ana_Teniente"]:"";

$Fis_FHVL   = isset($_REQUEST["Fis_FHVL"])?$_REQUEST["Fis_FHVL"]:"";
$Quim_FHVL  = isset($_REQUEST["Quim_FHVL"])?$_REQUEST["Quim_FHVL"]:"";
$Calaf_FHVL = isset($_REQUEST["Calaf_FHVL"])?$_REQUEST["Calaf_FHVL"]:"";
$Ana_FHVL   = isset($_REQUEST["Ana_FHVL"])?$_REQUEST["Ana_FHVL"]:"";

$Fis_Disputada   = isset($_REQUEST["Fis_Disputada"])?$_REQUEST["Fis_Disputada"]:"";
$Quim_Disputada  = isset($_REQUEST["Quim_Disputada"])?$_REQUEST["Quim_Disputada"]:"";
$Calaf_Disputada = isset($_REQUEST["Calaf_Disputada"])?$_REQUEST["Calaf_Disputada"]:"";
$Ana_Disputada   = isset($_REQUEST["Ana_Disputada"])?$_REQUEST["Ana_Disputada"]:"";

$Fis_Restos   = isset($_REQUEST["Fis_Restos"])?$_REQUEST["Fis_Restos"]:"";
$Quim_Restos  = isset($_REQUEST["Quim_Restos"])?$_REQUEST["Quim_Restos"]:"";
$Calaf_Restos = isset($_REQUEST["Calaf_Restos"])?$_REQUEST["Calaf_Restos"]:"";
$Ana_Restos   = isset($_REQUEST["Ana_Restos"])?$_REQUEST["Ana_Restos"]:"";

$Fis_Expo   = isset($_REQUEST["Fis_Expo"])?$_REQUEST["Fis_Expo"]:"";
$Quim_Expo  = isset($_REQUEST["Quim_Expo"])?$_REQUEST["Quim_Expo"]:"";
$Calaf_Expo = isset($_REQUEST["Calaf_Expo"])?$_REQUEST["Calaf_Expo"]:"";
$Ana_Expo   = isset($_REQUEST["Ana_Expo"])?$_REQUEST["Ana_Expo"]:"";

if(strlen($Dia)==1)
	$Dia="0".$Dia;
if(strlen($Mes)==1)
	$Mes="0".$Mes;

if($Proceso == 'E')
{
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	$Eliminar = "DELETE FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha."'";	
	mysqli_query($link, $Eliminar);
	
	$Proceso = "B";
}
if($Proceso == 'B')
{
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	$fecha2 = $Fecha.':'.$hora.':'.$minuto;
	//$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '$Fecha' and hora = '$fecha2' ";
	$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha."'";
	//echo $Consulta;
	$rs   = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($rs);
	$hora1 = isset($Fila["hora"])?$Fila["hora"]:"0000-00-00 00:00:00";
	$hora   = substr($hora1,11,2);
	$minuto = substr($hora1,14,2);
	$Fis_Vent = isset($Fila["Fis_Vent"])?$Fila["Fis_Vent"]:0;
	$Quim_Vent = isset($Fila["Quim_Vent"])?$Fila["Quim_Vent"]:0;
	$Calaf_Vent = isset($Fila["Calaf_Vent"])?$Fila["Calaf_Vent"]:0;
	$Ana_Vent = isset($Fila["Ana_Vent"])?$Fila["Ana_Vent"]:0;
	$Fis_HMadres = isset($Fila["Fis_HMadres"])?$Fila["Fis_HMadres"]:0;
	$Quim_HMadres = isset($Fila["Quim_HMadres"])?$Fila["Quim_HMadres"]:0;
	$Calaf_HMadres = isset($Fila["Calaf_HMadres"])?$Fila["Calaf_HMadres"]:0;
	$Ana_HMadres = isset($Fila["Ana_HMadres"])?$Fila["Ana_HMadres"]:0;
	$Fis_Teniente = isset($Fila["Fis_Teniente"])?$Fila["Fis_Teniente"]:0;
	$Quim_Teniente = isset($Fila["Quim_Teniente"])?$Fila["Quim_Teniente"]:0;
	$Calaf_Teniente = isset($Fila["Calaf_Teniente"])?$Fila["Calaf_Teniente"]:0;
	$Ana_Teniente = isset($Fila["Ana_Teniente"])?$Fila["Ana_Teniente"]:0;
	$Fis_FHVL = isset($Fila["Fis_FHVL"])?$Fila["Fis_FHVL"]:0;
	$Quim_FHVL = isset($Fila["Quim_FHVL"])?$Fila["Quim_FHVL"]:0;
	$Calaf_FHVL = isset($Fila["Calaf_FHVL"])?$Fila["Calaf_FHVL"]:0;
	$Ana_FHVL = isset($Fila["Ana_FHVL"])?$Fila["Ana_FHVL"]:0;
	$Fis_Disputada = isset($Fila["Fis_Disputada"])?$Fila["Fis_Disputada"]:0;
	$Quim_Disputada = isset($Fila["Quim_Disputada"])?$Fila["Quim_Disputada"]:0;
	$Calaf_Disputada = isset($Fila["Calaf_Disputada"])?$Fila["Calaf_Disputada"]:0;
	$Ana_Disputada = isset($Fila["Ana_Disputada"])?$Fila["Ana_Disputada"]:0;
	$Fis_Restos = isset($Fila["Fis_Restos"])?$Fila["Fis_Restos"]:0;
	$Quim_Restos = isset($Fila["Quim_Restos"])?$Fila["Quim_Restos"]:0;
	$Calaf_Restos = isset($Fila["Calaf_Restos"])?$Fila["Calaf_Restos"]:0;
	$Ana_Restos = isset($Fila["Ana_Restos"])?$Fila["Ana_Restos"]:0;
	$Fis_Expo = isset($Fila["Fis_Expo"])?$Fila["Fis_Expo"]:0;
	$Quim_Expo = isset($Fila["Quim_Expo"])?$Fila["Quim_Expo"]:0;
	$Calaf_Expo = isset($Fila["Calaf_Expo"])?$Fila["Calaf_Expo"]:0;
	$Ana_Expo = isset($Fila["Ana_Expo"])?$Fila["Ana_Expo"]:0;
	
	if($Fis_Vent == 0)
		$Fis_Vent = '';	
	else	
		$Fis_Vent = $Fila["Fis_Vent"];	

	if($Quim_Vent == 0)
		$Quim_Vent = '';	
	else
		$Quim_Vent = $Fila["Quim_Vent"];	

	if($Calaf_Vent == 0)
		$Calaf_Vent = '';	
	else
		$Calaf_Vent = $Fila["Calaf_Vent"];	

	if($Ana_Vent == 0)
		$Ana_Vent = '';	
	else
		$Ana_Vent = $Fila["Ana_Vent"];	

	if($Fis_HMadres == 0)
		$Fis_HMadres = '';	
	else	
		$Fis_HMadres = $Fila["Fis_HMadres"];	

	if($Quim_HMadres == 0)
		$Quim_HMadres = '';	
	else
		$Quim_HMadres = $Fila["Quim_HMadres"];	

	if($Calaf_HMadres == 0)
		$Calaf_HMadres = '';	
	else
		$Calaf_HMadres = $Fila["Calaf_HMadres"];	

	if($Ana_HMadres == 0)
		$Ana_HMadres = '';	
	else
		$Ana_HMadres = $Fila["Ana_HMadres"];	

	if($Fis_Teniente == 0)
		$Fis_Teniente = '';	
	else
		$Fis_Teniente = $Fila["Fis_Teniente"];	

	if($Quim_Teniente == 0)
		$Quim_Teniente = '';	
	else
		$Quim_Teniente = $Fila["Quim_Teniente"];	

	if($Calaf_Teniente == 0)
		$Calaf_Teniente = '';	
	else
		$Calaf_Teniente = $Fila["Calaf_Teniente"];	

	if($Ana_Teniente == 0)
		$Ana_Teniente = '';	
	else
		$Ana_Teniente = $Fila["Ana_Teniente"];	

	if($Fis_FHVL == 0)
		$Fis_FHVL = '';	
	else
		$Fis_FHVL = $Fila["Fis_FHVL"];	

	if($Quim_FHVL == 0)
		$Quim_FHVL = '';	
	else
		$Quim_FHVL = $Fila["Quim_FHVL"];	

	if($Calaf_FHVL == 0)
		$Calaf_FHVL = '';	
	else
		$Calaf_FHVL = $Fila["Calaf_FHVL"];	

	if($Ana_FHVL == 0)
		$Ana_FHVL = '';	
	else
		$Ana_FHVL = $Fila["Ana_FHVL"];	

	if($Fis_Disputada == 0)
		$Fis_Disputada = '';	
	else
		$Fis_Disputada = $Fila["Fis_Disputada"];	

	if($Quim_Disputada == 0)
		$Quim_Disputada = '';	
	else
		$Quim_Disputada = $Fila["Quim_Disputada"];	

	if($Calaf_Disputada == 0)
		$Calaf_Disputada = '';	
	else
		$Calaf_Disputada = $Fila["Calaf_Disputada"];	

	if($Ana_Disputada == 0)
		$Ana_Disputada = '';	
	else
		$Ana_Disputada = $Fila["Ana_Disputada"];	

	if($Fis_Restos == 0)
		$Fis_Restos = '';	
	else
		$Fis_Restos = $Fila["Fis_Restos"];	

	if($Quim_Restos == 0)
		$Quim_Restos = '';	
	else
		$Quim_Restos = $Fila["Quim_Restos"];	

	if($Calaf_Restos == 0)
		$Calaf_Restos = '';	
	else
		$Calaf_Restos = $Fila["Calaf_Restos"];	

	if($Ana_Restos == 0)
		$Ana_Restos = '';	
	else
		$Ana_Restos = $Fila["Ana_Restos"];	
	
   	if($Fis_Expo == 0)
		$Fis_Expo = '';
	else
		$Fis_Expo = $Fila["Fis_Expo"];

	if($Quim_Expo == 0)
		$Quim_Expo = '';
	else
		$Quim_Expo = $Fila["Quim_Expo"];

	if($Calaf_Expo == 0)
		$Calaf_Expo = '';
	else
		$Calaf_Expo = $Fila["Calaf_Expo"];

	if($Ana_Expo == 0)
		$Ana_Expo = '';
	else
		$Ana_Expo = $Fila["Ana_Expo"];

}
?>
<html>
<head>
<title>Ingreso de Rechazos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opc)
{
var f = document.FrmPrincipal;

	switch(opc)
	{
		case "G": 
			var dia  = f.Dia.value;
			var mes  = f.Mes.value;
			var semaforo = 0;	
			if (f.hora.value =='' || f.hora.value == 0)
        	{
                alert ("Debe ingresar Hora ");
         		return
        	}
	   	    if (f.minuto.value =='')
        	{
                alert ("Debe ingresar Minutos ");
            	return
        	}
			if(mes==2){
				if(dia>28){
					alert("Debe Ingresar fecha correcta(<29) ");
					f.Dia.focus();
					return;
				}else{
					semaforo=1;
				}
			}
			if(mes==4 || mes==6 || mes==9 || mes==11){
				if(dia>30){
					alert("Debe Ingresar fecha correcta(<31) ");
					f.Dia.focus();
					return;
				}else{
					semaforo=1;  
				}
			}else{
				semaforo=1; 
			}
			if(semaforo==1){
				f.action="sea_ing_rechazo_fisico01.php?Proceso=G";
				f.submit();
			}
			break;		
		case "B": 
			f.action="sea_ing_rechazo_fisico.php?Proceso=B";
			f.submit();
			break;		
		case "E": 
			f.action="sea_ing_rechazo_fisico.php?Proceso=E";
			f.submit();
			break;		
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=45";										 	
			break;
	}

}
function valida_hora()
{
	var f = FrmPrincipal;
		
	var largo = f.hora.value.length;
		if (largo == 1)
			f.hora.value = "0"+f.hora.value;
}

function valida_minuto()
{
		var f = FrmPrincipal;
		
		var largo1 = f.minuto.value.length;
		if (largo1 == 1)
			f.minuto.value = "0"+f.minuto.value;

	
}
function TeclaPulsada1(salto) 
{ 
	var f = FrmPrincipal;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

</script>
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<form name="FrmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
<table width="770" height="330" border="0" class="TablaPrincipal"> 
<tr> 
	<td align="center" valign="top">
	  <p><b><b>R E C H A Z O S<b></b></p>
        <table width="494" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td width="74" align="center">Fecha</td>
            <td colspan="5"><SELECT name="Dia" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			  ?>
              </SELECT> <SELECT name="Mes" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </SELECT> <SELECT name="Ano" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>

						
              </SELECT>
              Hora :
              <input type="text" name="hora" size="2" onKeyDown="TeclaPulsada1('minuto')" value="<?php echo $hora;?>" onBlur="valida_hora(this.form)"> 
              Min.
              <input type="text" name="minuto" size="2" onKeyDown="TeclaPulsada1('Fis_Teniente')" value="<?php echo $minuto;?>" onBlur="valida_minuto(this.form)">
              <input type="button" name="BtnBuscar" value="Buscar" style="width:70px" onClick="Proceso('B');"></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="74" height="14" align="center">ANODOS</td>
            <td width="101" align="center">Fisi
              
            co</td>
            <td width="102" align="center">Quimico</td>
            <td width="106" align="center">Calafateo</td>
            <td width="98" align="center">Mold. Sin Analis.</td>
          </tr>
           <tr> 
            <td>VENT. CTE</td>
            <td align="center"><input type="text" name="Fis_Vent" style="width:70px" value="<?php echo $Fis_Vent; ?>"></td>
            <td align="center"><input type="text" name="Quim_Vent" style="width:70px" value="<?php echo $Quim_Vent; ?>"></td>
            <td align="center"><input type="text" name="Calaf_Vent" style="width:70px" value="<?php echo $Calaf_Vent; ?>"></td>
            <td align="center"><input type="text" name="Ana_Vent" style="width:70px" value="<?php echo $Ana_Vent; ?>"></td>
          </tr>
          <tr> 
            <td>H. MADRES</td>
            <td align="center"><input type="text" name="Fis_HMadres" style="width:70px" value="<?php echo $Fis_HMadres; ?>"></td>
            <td align="center"><input type="text" name="Quim_HMadres" style="width:70px" value="<?php echo $Quim_HMadres; ?>"></td>
            <td align="center"><input type="text" name="Calaf_HMadres" style="width:70px" value="<?php echo $Calaf_HMadres; ?>"></td>
            <td align="center"><input type="text" name="Ana_HMadres" style="width:70px" value="<?php echo $Ana_HMadres; ?>"></td>
          </tr>
          <tr> 
            <td>TENIENTE</td>
            <td align="center"><input type="text" name="Fis_Teniente" style="width:70px" onKeyDown="TeclaPulsada1('Quim_Teniente')"  value="<?php echo $Fis_Teniente; ?>"></td>
            <td align="center"><input type="text" name="Quim_Teniente" style="width:70px" onKeyDown="TeclaPulsada1('Calaf_Teniente')"  value="<?php echo $Quim_Teniente; ?>"></td>
            <td align="center"><input type="text" name="Calaf_Teniente" style="width:70px" onKeyDown="TeclaPulsada1('Ana_Teniente')" value="<?php echo $Calaf_Teniente; ?>"></td>
            <td align="center"><input type="text" name="Ana_Teniente" style="width:70px" onKeyDown="TeclaPulsada1('Fis_FHVL')"value="<?php echo $Ana_Teniente; ?>"></td>
          </tr>
          <tr> 
            <td>FHVL CTE.</td>
            <td align="center"><input type="text" name="Fis_FHVL" style="width:70px"onKeyDown="TeclaPulsada1('Quim_FHVL')" value="<?php echo $Fis_FHVL; ?>"></td>
            <td align="center"><input type="text" name="Quim_FHVL" style="width:70px"onKeyDown="TeclaPulsada1('Calaf_FHVL')" value="<?php echo $Quim_FHVL; ?>"></td>
            <td align="center"><input type="text" name="Calaf_FHVL" style="width:70px"onKeyDown="TeclaPulsada1('Ana_FHVL')" value="<?php echo $Calaf_FHVL; ?>"></td>
            <td align="center"><input type="text" name="Ana_FHVL" style="width:70px"onKeyDown="TeclaPulsada1('Fis_Disputada')" value="<?php echo $Ana_FHVL; ?>"></td>
          </tr>
          <tr> 
            <td>ANGLO AMERICAN</td>
            <td align="center"><input type="text" name="Fis_Disputada" style="width:70px"onKeyDown="TeclaPulsada1('Quim_Disputada')" value="<?php echo $Fis_Disputada; ?>"></td>
            <td align="center"><input type="text" name="Quim_Disputada" style="width:70px"onKeyDown="TeclaPulsada1('Calaf_Disputada')" value="<?php echo $Quim_Disputada; ?>"></td>
            <td align="center"><input type="text" name="Calaf_Disputada" style="width:70px"onKeyDown="TeclaPulsada1('Ana_Disputada')" value="<?php echo $Calaf_Disputada; ?>"></td>
            <td align="center"><input type="text" name="Ana_Disputada" style="width:70px"onKeyDown="TeclaPulsada1('Fis_Restos')" value="<?php echo $Ana_Disputada; ?>"></td>
          </tr>
          <tr> 
            <td>RESTOS</td>
            <td align="center"><input type="text" name="Fis_Restos" style="width:70px"onKeyDown="TeclaPulsada1('Quim_Restos')" value="<?php echo $Fis_Restos; ?>"></td>
            <td align="center"><input type="text" name="Quim_Restos" style="width:70px"onKeyDown="TeclaPulsada1('Calaf_Restos')" value="<?php echo $Quim_Restos; ?>"></td>
            <td align="center"><input type="text" name="Calaf_Restos" style="width:70px"onKeyDown="TeclaPulsada1('Ana_Restos')" value="<?php echo $Calaf_Restos; ?>"></td>
            <td align="center"><input type="text" name="Ana_Restos" style="width:70px"onKeyDown="TeclaPulsada1('Fis_Expo')" value="<?php echo $Ana_Restos; ?>"></td>
          </tr>
          <tr>
            <td>EXPO/EMB</td>
            <td align="center"><input type="text" name="Fis_Expo" style="width:70px"onKeyDown="TeclaPulsada1('Quim_Expo')" value="<?php echo $Fis_Expo; ?>"></td>
            <td align="center"><input type="text" name="Quim_Expo" style="width:70px"onKeyDown="TeclaPulsada1('Calaf_Expo')" value="<?php echo $Quim_Expo; ?>"></td>
            <td align="center"><input type="text" name="Calaf_Expo" style="width:70px"onKeyDown="TeclaPulsada1('Ana_Expo')" value="<?php echo $Calaf_Expo; ?>"></td>
            <td align="center"><input type="text" name="Ana_Expo" style="width:70px"onKeyDown="TeclaPulsada1('BtnGuardar')" value="<?php echo $Ana_Expo; ?>"></td>
          </tr>

        </table>
	  <br>
        <table width="420" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td width="415" align="center"> <input type="button" name="BtnGuardar" value="Grabar" style="width:70px" onClick="Proceso('G');"> 
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:70px" onClick="Proceso('E');"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
            </td>
          </tr>
      </table> </td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>

</body>
</html>
