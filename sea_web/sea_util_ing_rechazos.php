<?php 
	include("../principal/conectar_sea_web.php");
	$CodigoDeSistema = 2;

	if(isset($_REQUEST["Dia"])) {
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia =  date("d");
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes =  date("m");
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano =  date("Y");
	}

	if(isset($_REQUEST["TxtHornada"])) {
		$TxtHornada = $_REQUEST["TxtHornada"];
	}else{
		$TxtHornada =  "";
	}
	if(isset($_REQUEST["Mostrar"])) {
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar =  "";
	}
	if(isset($_REQUEST["subprocor"])) {
		$subprocor = $_REQUEST["subprocor"];
	}else{
		$subprocor =  "";
	}
	if(isset($_REQUEST["subprohm"])) {
		$subprohm = $_REQUEST["subprohm"];
	}else{
		$subprohm =  "";
	}


?>

<html>
<head>
<title>Ingreso Rechazos MPA</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function Grabar()
{
		frm = document.frml;
		if (frm.rechacp.value ==0 && frm.rechahp.value == 0)
		{
			alert("Debe ingresar unidades rechazadas");
			return;
		}
		var rechacp = frm.rechacp.value * 1;
		var rechahp = frm.rechahp.value * 1;
		var hornada = frm.TxtHornada.value;
		var subproc = frm.subprocor.value;
		var subprohm = frm.subprohm.value;
		var saldoc = frm.SaldoC.value;
		var saldoh = frm.SaldoHM.value;
		var ano = frm.Ano.value;
		var mes = frm.Mes.value;
		var dia = frm.Dia.value;
		frm.fecha.value = frm.Ano.value + "-" + frm.Mes.value + "-" + frm.Dia.value;
		var fecha = frm.fecha.value;
		frm.action = "sea_util_ing_rechazos01.php?Procesa=9&ano=" + ano + "&mes=" + mes + "&dia=" + dia + "&subproc=" + subproc + "&subprohm=" + subprohm + "&TxtHornada=" + hornada + "&rechacp=" + rechacp + "&rechahp=" + rechahp + "&saldoc=" + saldoc + "&saldoh=" + saldoh;
		frm.submit();		
}
/***********************/
function Limpiar()
{
	document.location = "sea_util_ing_rechazos.php";
}
/******************/
function Verifica1()
{
	var frm = document.frml;
	var saldo = frm.SaldoC.value * 1;
	var rechazo = frm.rechac.value * 1;
	if (rechazo > saldo)
	{
			alert ("Anodos Corr. rechazados por MPA  mayor que saldo, revise");
			frm.rechac.value = 0;
			frm.rechac.focus();
	}
	frm.rechampa.value = (frm.rechampa.value * 1) + (frm.rechac.value * 1);
	frm.SaldoC.value = (frm.SaldoC.value * 1) - (frm.rechac.value * 1);
	frm.rechampa_tot.value = (frm.rechampa.value * 1) + (frm.rechampaHM.value * 1);
	frm.saldo_hor.value = (frm.SaldoC.value * 1) + (frm.SaldoHM.value * 1);
	if(frm.rechac.value > 0)
		frm.rechacp.value = frm.rechac.value * 1;
	frm.rechac.value = 0;

}
/******************/
function Verifica2()
{
	var frm = document.frml;
	var saldoH = frm.SaldoHM.value * 1;
	var rechazoH = frm.rechah.value * 1;
	if (rechazoH > saldoH)
	{
		alert("Anodos H.M. rechazadas por MPA mayor que saldo, revise");
		frm.rechah.value = 0;
		frm.rechah.focus();
	}
	frm.rechampaHM.value = (frm.rechampaHM.value * 1) + (frm.rechah.value * 1); 
	frm.SaldoHM.value = (frm.SaldoHM.value * 1) - (frm.rechah.value * 1);
	frm.rechampa_tot.value = (frm.rechampa.value * 1) + (frm.rechampaHM.value * 1);
	frm.saldo_hor.value = (frm.SaldoC.value * 1) + (frm.SaldoHM.value * 1);
	if(frm.rechah.value >0)
		frm.rechahp.value = frm.rechah.value * 1;
	frm.rechah.value = 0;
	
}

/****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=30";
}
function VerRechazos()
{
var frm = document.frml;

       	window.open("sea_con_rechazos_mpa.php", "","menubar=no resizable=no Top=10 Left=200 width=590 height=700 scrollbars=no");

}

function Buscar()
{

	var frm = document.frml;
	if (frm.TxtHornada.value =="" || frm.TxtHornada.value == 0)
	{
		alert ("numero de Hornada debe ingresarse");
		return
	}
	frm.action = "sea_util_ing_rechazos.php?Mostrar=S&TxtHornada=" + frm.TxtHornada.value;
	frm.submit();

}
/***************/
function BuscarRechazo()
{
	var  frm = document.frml;
	if (frm.TxtHornada.value =="" || frm.TxtHornada.value == 0)
	{
		alert ("numero de Hornada debe ingresarse");
		return
	}
	frm.action = "sea_util_ing_rechazos.php?Mostrar=S";
	frm.submit();

}
/***************/
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frml" action="" method="post">
  <input name="fecha" type="hidden" value="<?php echo $fecha; ?>" >

<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" background="../principal/imagenes/fondo3.gif" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

		<table width="750" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr> 
		  		<td colspan="3" width="100">Fecha </td>
            	<td><SELECT name="Dia" style="width:50px">
                <?php 
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
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
              		</SELECT> <SELECT name="Mes" style="width:100px">
                <?php
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
								else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == date("n"))
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
								else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
				?>
              		</SELECT> <SELECT name="Ano" style="width:60px">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
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
              		</SELECT> </td>

            <td>Buscar Hornada</td>
			<td width="50">
			<?php
			    echo '<input name="TxtHornada" id="TxtHornada" type="text" size="15" value="'.$TxtHornada.'">';
			 ?>
			</td>
            <td width="50"> 
              <input name="btnok" type="button" value="OK" onClick="JavaScript:Buscar()">
			  </td>
			     <td align="center">
				 	<input name="btnVer" type="button" value="Ver Rechazos" style="width:80" onClick="JavaScript:VerRechazos(this.form)"> 
				 </td>

          </tr>
        </table>
          <table width="500" border="0" cellspacing="0" cellpadding="3" class="ColorTabla01">
            <tr> 
              <td height="20" align="center">Producto</td>
              
            <td align="center">Unidades Producidas</td>
            </tr>
          </table>
        <table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="180">Anodos Corrientes</td>
			<?php
				$unid_cor = 0;
				$unid_hm = 0;
				if ($Mostrar == "S")
				{
					$subprocor = 0;
					$subprohm = 0;
					$consulta = "SELECT * FROM sea_web.hornadas WHERE cod_producto = 17  AND hornada_ventana = ".$TxtHornada;
					$consulta.=" order by cod_subproducto";
					$rs = mysqli_query($link, $consulta);
					while($row = mysqli_fetch_array($rs))
					{
						if ($row["cod_subproducto"] >='1' && $row["cod_subproducto"] < '5')
						{
							$unid_cor = $row["unidades"];
							$subprocor = $row["cod_subproducto"];
						}
						else
						{
							$unid_hm = $row["unidades"];
							$subprohm = $row["cod_subproducto"];
						}
					}
				}
				  echo '<input name="subprocor"  type="hidden" size="15" value="'.$subprocor.'">';
  				  echo '<input name="subprohm"   type="hidden" size="15" value="'.$subprohm.'">';

 			?>
			 
			<td align="center">
					<input name="unid_cor" type="text" size="10" align="right" value="<?php echo $unid_cor; ?>" disabled> </td>
			</tr>
			<tr>
            <td width="180">Anodos Hojas Madres</td>
            <td align="center">
					<input name="unid_hm" type="text" align="right" size="10" value="<?php echo $unid_hm; ?>" disabled></td>
          </tr>
        </table>
        <br>
        <table width="700" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">
          <tr> 
            <td width="150" height="20" align="center">&nbsp;</td>
			<td width="120" height="20" align="center">Saldo Buenos</td>
            <td width="120" align="center">Beneficio</td>
            <td width="120" align="center">Rech.Fisico</td>
            <td width="120" align="center">Traspaso RAF</td>
			<td width="120" align="center">Rech. MPA</td>
			<td width="120" align="center">Ing.Rech. MPA</td>
          </tr>
		</table>
		</div>

       <table width="700" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">	  
          <tr> 
            <td width="120">Anodos corrientes</td>
				<?php 
					$SaldoC = 0;
					$rechac = 0;
					$rechampa=0;
					$Beneficio = 0;
					$Rechazo = 0;
					$traspaso = 0;
					$recha_tot = 0;
					$rechampa_tot  = 0;
					$benef_tot = 0;
					$traspaso_tot = 0;
					if ($Mostrar == "S")
					{
						//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
						$valida_fecha_movimiento = substr($TxtHornada,0,4)."-".substr($TxtHornada,4,2)."-".$Dia;
						include("sea_valida_mes.php");
						//******************
						$unidad_cte = 0;
						$consulta="Select sum(unidades) as unidades_c from sea_web.movimientos where tipo_movimiento IN ('2','10') ";
						$consulta.=" and cod_producto = '17' and cod_subproducto in ('1','2','3','4') and hornada = '".$TxtHornada."'";
						$resp=mysqli_query($link, $consulta);
						if ($Fila=mysqli_fetch_array($resp))
						{
							$Beneficio = $Fila["unidades_c"];
						}
						$consulta="Select sum(unidades) as unidades_r from sea_web.movimientos where tipo_movimiento = '1' ";
						$consulta.=" and sub_tipo_movim = '2' and cod_producto = '17' and cod_subproducto = '4'  and hornada = '".$TxtHornada."'";
						$respR=mysqli_query($link, $consulta);
						if ($FilaR=mysqli_fetch_array($respR))
						{
							$Rechazo = $FilaR["unidades_r"];
						}
						$consulta="Select sum(unidades) as unidades_m from sea_web.movimientos where tipo_movimiento = '1' ";
						$consulta.=" and sub_tipo_movim = '4' and cod_producto = '17' and cod_subproducto in ('1','2','3','4')  and hornada = '".$TxtHornada."'";
						$respM=mysqli_query($link, $consulta);
						if ($FilaM=mysqli_fetch_array($respM))
						{
							$rechampa = $FilaM["unidades_m"];
						}
						$consulta="SELECT sum(unidades) as unidades_t from sea_web.movimientos where tipo_movimiento = '4' ";
						$consulta.="and cod_producto = '17' and cod_subproducto in ('1','2','3','4') and hornada = '".$TxtHornada."'";
						$respT=mysqli_query($link, $consulta);
						if ($FilaT=mysqli_fetch_array($respT))
						{
							$traspaso = $FilaT["unidades_t"];
						}
					
						if($Beneficio > ($unid_cor - $Rechazo))
							$SaldoC = ($unid_cor - $Rechazo) - (($Beneficio - $Rechazo) + $rechampa + $traspaso);
							else
							$SaldoC = $unid_cor - ($Beneficio + $Rechazo + $rechampa + $traspaso);
						$recha_tot = $recha_tot + $Rechazo;
						$benef_tot = $benef_tot + $Beneficio;
						$traspaso_tot = $traspaso_tot + $traspaso;
						$rechampa_tot = $rechampa_tot + $rechampa;
					}
				?>
				<td><input name="SaldoC" type="text" align="right" value="<?php echo $SaldoC; ?>" size="12" disabled></td>
				<td><input name="Beneficio" type="text" align="right" value="<?php echo $Beneficio; ?>" size="12" disabled></td>				
				<td><input name="Rechazo" type="text" align="right" value="<?php echo $Rechazo; ?>" size="12" disabled></td>
				<td><input name="traspaso" type="text" align="right" value="<?php echo $traspaso; ?>" size="12" disabled></td>
				<td><input name="rechampa" type="text" align="right" value="<?php echo $rechampa; ?>" size="12" disabled></td>
            <td align="center">
				<input name="rechacp" type="hidden" align="right" value="'.$rechacp.'">
				<?php 
					if($SaldoC==0)
						echo '<input name="rechac" type="text" align="right" value="'.$rechac.'"  size="12" disabled >';
						else
						echo '<input name="rechac" type="text" align="right" value="'.$rechac.'" onBlur="JavaScritp:Verifica1()" size="12">';
				?>
			</td>
          </tr>
          <tr>
            <td width="130">Anodos Hojas Madres</td>
			<?php 
				$SaldoHM = 0;
				$BeneficioHM =0;
				$RechazoHM = 0;
				$rechah = 0;
				$rechampaHM = 0;
				$traspasoHM = 0;
				$traspaso_tot = 0;
				if ($Mostrar == "S")
				{
					//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
					$valida_fecha_movimiento = substr($TxtHornada,0,4)."-".substr($TxtHornada,4,2)."-".$Dia;
					include("sea_valida_mes.php");
					//******************
					$consulta="Select sum(unidades) as unidades_h from sea_web.movimientos where tipo_movimiento IN ('2','10') ";
					$consulta.=" and cod_producto = '17' and cod_subproducto in ('5','6','7','8') and hornada = '".$TxtHornada."'";
					$resp1=mysqli_query($link, $consulta);
					if ($Fila1=mysqli_fetch_array($resp1))
					{
							$BeneficioHM = $Fila1["unidades_h"];
					}
					$consulta="Select sum(unidades) as unidades_h from sea_web.movimientos where tipo_movimiento = '1' ";
					$consulta.=" and sub_tipo_movim = '2' and cod_producto = '17' and cod_subproducto = '8' and hornada = '".$TxtHornada."'";
					$resp11=mysqli_query($link, $consulta);
					if ($Fila11=mysqli_fetch_array($resp11))
					{
							$RechazoHM = $Fila11["unidades_h"];
					}
					
					$consulta="Select sum(unidades) as unidades_m from sea_web.movimientos where tipo_movimiento = '1' ";
					$consulta.=" and sub_tipo_movim = '4' and cod_producto = '17' and cod_subproducto in ('5','6','7','8') and hornada = '".$TxtHornada."'";
					$resp15=mysqli_query($link, $consulta);
					if ($Fila15=mysqli_fetch_array($resp15))
					{
							$rechampaHM = $Fila15["unidades_m"];
					}
					$consulta="Select sum(unidades) as unidades_t from sea_web.movimientos where tipo_movimiento = '4' ";
					$consulta.=" and cod_producto = '17' and cod_subproducto in ('5','6','7','8') and hornada = '".$TxtHornada."'";
					$resp16=mysqli_query($link, $consulta);
					if ($Fila16=mysqli_fetch_array($resp16))
					{
							$traspasohm = $Fila16["unidades_t"];
					}

					if($BeneficioHM > ($unid_hm - $RechazoHM))
						$SaldoHM = ($unid_hm - $RechazoHM) - (($BeneficioHM - $RechazoHM) + $rechampaHM + $traspasohm);
						else
						$SaldoHM = $unid_hm - ($BeneficioHM + $RechazoHM + $rechampaHM + $traspasohm);
					$recha_tot = $recha_tot + $RechazoHM;
					$benef_tot = $benef_tot + $BeneficioHM;
					$traspaso_tot = $traspaso_tot + $traspasohm;
					$rechampa_tot = $rechampa_tot + $rechampaHM;
				}
				?>

				<td><input name="SaldoHM" type="text" align="right" value="<?php echo $SaldoHM; ?>" size="12" disabled></td>
				<td><input name="BeneficioHM" type="text" align="right" value="<?php echo $BeneficioHM; ?>" size="12" disabled></td>
				<td><input name="RechazoHM" type="text" align="right" value="<?php echo $RechazoHM; ?>" size="12" disabled></td>
				<td><input name="traspasoHM" type="text" align="right" value="<?php echo $traspasoHM; ?>" size="12" disabled></td>
				
            <td><input name="rechampaHM" type="text" align="right" value="<?php echo $rechampaHM; ?>" size="12" disabled></td>
			<input name="rechahp" type="hidden" align="right" value="'.$rechahp.'">
            <td align="center">
			<?php
				if($SaldoHM==0)  
					echo '<input name="rechah" type="txt" align="right" value="'.$rechah.'" size="12" disabled>';
					else 
					echo '<input name="rechah" type="txt" align="right" value="'.$rechah.'" onBlur="JavaScript:Verifica2()" size="12">'; 
			?>
			</td>
          </tr>
          <tr> 
            <td width="130">Total Produccion (Unidades)</td>
            <td> 
              	<?php 
						$saldo_hor = 0;
						if ($Mostrar =="S")
						{
							$saldo_hor = /*$saldo_hor +*/ $SaldoC + $SaldoHM;
							echo '<input name="saldo_hor" type="text" align="right" value="'.$saldo_hor.'"  disabled size="12">';		
						}
						else
						{				
							echo '<input name="saldo_hor" type="text" align="right" value="'.$saldo_hor.'" disabled size="12">';				
						}		
				?>
            </td>
            <td> 
              	<?php 
						echo '<input name="benef_tot" type="text" align="right" value="'.$benef_tot.'" disabled size="12">';
				?>
            </td>
            <td> 
              	<?php 
						echo '<input name="recha_tot" type="text" align="right" value="'.$recha_tot.'"  disabled size="12">';
				?>
            </td>
            <td> 
              	<?php 
						echo '<input name="traspaso_tot" type="text" align="right" value="'.$traspaso_tot.'"  disabled size="12">';
				?>
            </td>
            <td> 
              	<?php 
						echo '<input name="rechampa_tot" type="text" align="right" value="'.$rechampa_tot.'"  disabled size="12">';
				?>
            </td>
          </tr>
        </table>
        <br>

        <table width="750" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width:60" onClick="JavaScript:Grabar(this.form)"> 
            <input name="btnlimpiar" type="button"  value="Limpiar" style="width:60" onClick="JavaScript:Buscar()">
            <input name="btnsalir" type="button" style="width:60" value="Salir" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
    
</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>    
</form>
</body>
</html>
