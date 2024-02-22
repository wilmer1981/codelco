<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 123;
	include("../principal/conectar_pmn_web.php");

	$CookieRut = $_COOKIE["CookieRut"]; 

	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = "";
	}
	if(isset($_REQUEST["AnoF"])){
		$AnoF = $_REQUEST["AnoF"];
	}else{
		$AnoF = "";
	}
	if(isset($_REQUEST["MesF"])){
		$MesF = $_REQUEST["MesF"];
	}else{
		$MesF = "";
	}
	if(isset($_REQUEST["DiaF"])){
		$DiaF = $_REQUEST["DiaF"];
	}else{
		$DiaF = "";
	}
	if(isset($_REQUEST["Corr"])){
		$Corr = $_REQUEST["Corr"];
	}else{
		$Corr = "";
	}
/*
	if(isset($_REQUEST["Tipo"])){
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
	}
	if(isset($_REQUEST["Rec"])){
		$Rec = $_REQUEST["Rec"];
	}else{
		$Rec = "";
	}
	if(isset($_REQUEST["RecT"])){
		$RecT = $_REQUEST["RecT"];
	}else{
		$RecT = "";
	}*/

	if(isset($_REQUEST["ExisteCorrelativo"])){
		$ExisteCorrelativo = $_REQUEST["ExisteCorrelativo"];
	}else{
		$ExisteCorrelativo = "";
	}

	if(isset($_REQUEST["Check1"])){
		$Check1 = $_REQUEST["Check1"];
	}else{
		$Check1='';
	}
	if(isset($_REQUEST["Check2"])){
		$Check2 = $_REQUEST["Check2"];
	}else{
		$Check2='';
	}

	if(isset($_REQUEST["TxtCorrelativo"])){
		$TxtCorrelativo = $_REQUEST["TxtCorrelativo"];
	}else{
		$TxtCorrelativo='';
	}
	if(isset($_REQUEST["Corr"])){
		$Corr = $_REQUEST["Corr"];
	}else{
		$Corr='';
	}
	if(isset($_REQUEST["TxtPatente"])){
		$TxtPatente = $_REQUEST["TxtPatente"];
	}else{
		$TxtPatente='';
	}
	if(isset($_REQUEST["TxtFecha"])){
		$TxtFecha = $_REQUEST["TxtFecha"];
	}else{
		$TxtFecha='';
	}
	if(isset($_REQUEST["TxtPesoBruto"])){
		$TxtPesoBruto = $_REQUEST["TxtPesoBruto"];
	}else{
		$TxtPesoBruto ='';
	}
	if(isset($_REQUEST["TxtHoraE"])){
		$TxtHoraE = $_REQUEST["TxtHoraE"];
	}else{
		$TxtHoraE ='';
	}
	if(isset($_REQUEST["Msj"])){
		$Msj = $_REQUEST["Msj"];
	}else{
		$Msj ='';
	}

if($Tipo=='SIPA')
{
	$Check1='checked=checked';
	$Check2='';
}	
if($Tipo=='ESPE')
{
$Check1='';
$Check2='checked=checked';
}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "G": //GRABAR CABECERA				
			var Tipo='SIPA';
			if(f.Tipo[1].checked==true)
				Tipo='ESPE';
			if(Tipo=='SIPA')
			{	
				if(f.Corr.value=='')
				{
					alert('Debe ingresar Correlativo a consultar')
					f.Corr.focus();
					return;
				}
			}
			else
			{
				if(f.CorrEs.value=='')
				{
					alert('Debe ingresar Correlativo a consultar')
					f.CorrEs.focus();
					return;
				}
			}	
			if(SoloUnElemento(f.name,'SelectedEmb','E'))
			{
				Datos=Recuperar(f.name,'SelectedEmb');
				if(confirm('Est seguro de asignar correlativo a lote(s) seleccionado(s)?'))
				{
					if(confirm('Est seguro de la fecha de embarque seleccionada?'))
					{
						//alert(Datos)
						f.action= "pmn_ing_embarque01.php?Proceso=G&Valores="+Datos+"&Tipo="+Tipo;
						f.submit();
					}
				}
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_ing_embarque01.php?Proceso=C";
	 		f.submit();
			break;
		case "S": //SALIR
			f.action="../principal/sistemas_usuario.php?CodSistema=6";
			f.submit();
			break;
		case "Ver": //SALIR
			var URL = "pmn_ing_embarque02.php?Corr="+f.Corr.value;
			window.open(URL,"","top=120,left=100,width=740,height=450,menubar=no,resizable=no,scrollbars=yes,status=yes");
			break;
		case "R": //RECARGA
			var Tipo='SIPA';
			if(f.Tipo[1].checked==true)
				Tipo='ESPE';
			f.action= "pmn_embarque.php?Rec=S&RecT=S&Tipo="+Tipo;
			f.submit();
			break;
		case "RTipo": //RECARGA Tipo
			var Tipo='SIPA';
			if(f.Tipo[1].checked==true)
				Tipo='ESPE';
			f.action= "pmn_embarque.php?Rec=S&RecT=S&Tipo="+Tipo;
			f.submit();
			break;
		case "verL":	
			var Tipo='SIPA';
			if(f.Tipo[1].checked==true)
				Tipo='ESPE';
			var URL = "pmn_ing_embarque03.php?Tipo="+Tipo;
			window.open(URL,"","top=120,left=100,width=850,height=450,menubar=no,resizable=no,scrollbars=yes,status=yes");
		break;
	}

}
function Msj(Msj)
{
	if(Msj!='')
	{
		if(Msj=='E')
			alert('registros eliminados con xito')
	}
}
</script>
<style type="text/css">

.Estilo2 {color: #FF0000}

</style>
</head>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="Msj('<?php echo $Msj;?>')" >
<form name="frmPrincipal" method="post" action="">
<table width="100%" border="0" class="TituloCabeceraOz">
    <tr>
    <td><table width="800"  border="1" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
      <tr class="ColorTabla01">
        <td colspan="6"><strong>Embarque:&nbsp;&nbsp; Barro anodico descobrizado</strong></td>
      </tr>  <br>
      <tr class="ColorTabla02">
        <td width="124" align="right" >Tipo Embarque:</td>
        <td colspan="5">Correlativo Sipa&nbsp;<input type="radio" name="Tipo" value="SIPA" border="0" <?php echo $Check1;?> onClick="Proceso('RTipo')" />&nbsp;&nbsp;&nbsp;Embarque Especial&nbsp;<input type="radio" name="Tipo" value="ESPE" <?php echo $Check2;?> border="0" onClick="Proceso('RTipo')" /></td>
      </tr>  <br>
	  <?php
	  if($RecT=='S')
	  {
	  	  if($Tipo=='SIPA')
		  {	
		  	$CorrEs='';	  
		  ?>
		  <tr>
			<td width="124" align="right" class="ColorTabla02">Correlativo Sipa:</td>
			<td colspan="5" class="ColorTabla02" ><input name="Corr" type="text" class="InputCen" id="Corr" value="<?php echo strtoupper($Corr); ?>" size="10" maxlength="10" onBlur="Proceso('R')">		</td>
			</tr>
		  <?php
				$Datos=explode('~',$TxtCorrelativo);
				if(isset($Datos[2])){
					$OrigenDatosGuia=$Datos[2];
				}else{
					$OrigenDatosGuia='';
				}
				
				$Consulta ="select distinct t1.lote,t1.recargo,t1.patente,t1.correlativo,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.conjunto,";
				$Consulta.="t1.cod_despacho,t1.cod_mop,t1.peso_bruto,t1.peso_tara,t1.observacion,t1.cod_producto,t1.cod_subproducto from sipa_web.despachos t1 ";
				$Consulta.="where correlativo='".$Corr."'";
				$Resp2 = mysqli_query($link, $Consulta);
				$ExisteCorrelativo='N';
				if($Fila = mysqli_fetch_array($Resp2))
				{
					$TxtPatente=$Fila["patente"];
					$TxtFecha=$Fila["fecha"];
					$TxtHoraE=$Fila["hora_entrada"];
					$TxtPesoTara=$Fila["peso_tara"];
					$TxtPesoNeto=abs($TxtPesoBruto-$TxtPesoTara);
					$TxtPesoBruto=$Fila["peso_bruto"];
					$CmbGrupoProd=$Fila["cod_producto"];
					$CmbSubProducto=$Fila["cod_subproducto"];
					$ExisteCorrelativo='S';
				}
	  	  }
		  else
		  {
		  	$CorrEs=ObtengoMaximo('pmn_corr_especial','corr_especial','',$link);
			$ExisteCorrelativo='S';
			$TxtPatente='ESPECIAL';
			$TxtFecha='ESPECIAL';
			$TxtHoraE='ESPECIAL';
			$TxtPesoTara='ESPECIAL';
			$TxtPesoNeto='ESPECIAL';
			$TxtPesoBruto='ESPECIAL';
		  ?>
		  <tr>
			<td width="124" align="right" class="ColorTabla02">Embarque Especial:</td>
			<td colspan="5" class="ColorTabla02" ><input name="CorrEs" type="text" readonly="" class="InputCen" id="CorrEs" value="<?php echo strtoupper($CorrEs); ?>" size="5" maxlength="8" >		</td>
		  </tr>
		  <?php
		  }
			?>
		  <tr>
			<td width="124" align="right" class="ColorTabla02">Patente:</td>
			<td width="155" class="ColorTabla02" ><strong><?php echo strtoupper($TxtPatente); ?></strong></td>
			<td width="103" align="right" class="ColorTabla02">Fecha:</td>
			<td width="120" class="ColorTabla02" ><strong><?php echo $TxtFecha; ?></strong></td>
			<td width="125" align="right" class="ColorTabla02">Peso Bruto : </td>
			<td width="127" class="ColorTabla02"><strong><?php echo $TxtPesoBruto; ?></strong></td>
		  </tr>
		  <tr>
			<td align="right" class="ColorTabla02">Hora Entrada:</td>
			<td class="ColorTabla02" colspan="5"><strong><?php echo $TxtHoraE; ?></strong></td>
		  </tr>
		  <tr>
			<td align="right" class="ColorTabla02">Fecha Embarque : </td>
			<td colspan="5" class="ColorTabla02"><strong>
				<?php 
						echo "<select name='Dia' style='width:50px'>\n";				
						for ($i=1;$i<=31;$i++)
						{
							if (isset($Dia))
							{
								if ($i == $Dia)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == $DiaActual)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
					  echo "</select> <select name='Mes' style='width:100px'>\n";
						for ($i=1;$i<=12;$i++)
						{
							if (isset($Mes))
							{
								if ($i == $Mes)
									echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
								else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
							}
							else
							{
								if ($i == $MesActual)
									echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
								else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
							}
						}
					  echo "</select> <select name='Ano' style='width:60px'>\n";
						for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
						{
							if (isset($Ano))
							{
								if ($i == $Ano)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == $AnoActual)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
						echo "</select>\n";
				?>
			 &nbsp;&nbsp;&nbsp;<a href="Javascript:Proceso('verL')">Ver lotes con correlativos SIPA</a></strong></td>
		  </tr>
			<?php
			if($ExisteCorrelativo=='N')
			{
			?>
			  <tr>
				<td align="left" class="TituloTablaNaranja" colspan="6">No se podran asignar lotes a correlativo, este no existe en los registros SIPA.</td>
			  </tr>
			<?php
			}
		}
		?>
    </table><br><br>
	<?php
	if($ExisteCorrelativo=='S')
	{
	?>
	  <table width="600" border="0" align="center" class="TablaInterior">
        <tr align="center" valign="middle">
          <td width="726" colspan="7"><?php
		  	  $Boton='G';	
		  	  $BotonLabel='Grabar';	
			 // if($ExisteCorrelativo=='S')
			  //{
			  ?>
              <input name="BtnGrabar2" type="button" value="<?php echo $BotonLabel;?>" style="width:60px;" onClick="Proceso('<?php echo $Boton?>');">
              <?php
			  //}
			  ?>
              <input name="BtnCancelar2" type="button" value="Cancelar" style="width:60px;" onClick="Proceso('C');">
              <input name="BtnSalir2" type="button" value="Salir" style="width:60px;" onClick="Proceso('S');">
          </td>
        </tr>
      </table>
	  <?php
	/*$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera ";
	$Consulta.= " where correlativo_sipa='".$Corr."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if (!$Row = mysqli_fetch_array($Respuesta))
	{*/
	if($Corr!='' || $CorrEs!='')
	{
	?>
			<table width="100%" border="0" class="TituloCabeceraOz">
			<tr>
			<td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
			  <tr>
			    <td valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
			      <tr align="center" class="ColorTabla01">
                    <?php
   				   // if($ExisteCorrelativo=='S')
					//{
					?>
                    <?php
					//}
					?>
			        <td width="41" height="15" class="ColorTabla01">Lote</td>
			        <td width="70">SA</td>
			        <td width="95">Producto SA</td>
			        <td width="130">Subproducto SA</td>
			        <td width="130">Leyes</td>
			        <td width="75">Peso Palet</td>
			        <td width="65">Peso Lote</td>
			        <td width="50">Tambores</td>
			        </tr>
			      <?php	
				$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra and t2.recargo in('0','') and t2.nro_solicitud is not null";
				$Consulta.= " inner join pmn_web.pmn_pesa_bad_detalle t3 on t1.lote=t3.lote and palet_a_b is null";
				$Consulta.= " where t1.lote<>'' group by t1.lote order by t1.lote asc";
				$Respuesta = mysqli_query($link, $Consulta);$HayD='N';
				echo "<input type='hidden' name='SelectedEmb' />";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$HayD='S';
					$NomProductoSA=NomProducto($Row["cod_producto"]);
					$NomSubProductoSA=NomSubProducto($Row["cod_producto"],$Row["cod_subproducto"]);
					$Leyes=ObtenerLeyes($Row["nro_solicitud"]);
					$TotTambores=ObtenerTambores($Row["lote"]);
										
					$OK='';
					if($Row["CabeceraSA"]!='')
						$OK='OK';
						
					$TotNeto=TotalNetoLote($Row["lote"]);	
					echo "<tr valign='top'>\n";
				    //if($ExisteCorrelativo=='S')
					echo "</td>\n";
					echo "<td align='left'>".$Row["lote"]."</td>\n";
					echo "<td align='left'>".$Row["nro_solicitud"]."<input type='hidden' name='SA[".$Row["lote"]."]' value='".$Row["nro_solicitud"]."'></td>\n";
					echo "<td align='left'>".$NomProductoSA."</td>\n";
					echo "<td align='left'>".$NomSubProductoSA."</td>\n";
					echo "<td align='left'>".$Leyes."</td>\n";
					$PaletA=ObtengoDatosPaletAB($Row["lote"],'A','S');
					$PaletA=explode('-:-',$PaletA);
					$ValorA=$PaletA[0];
					$TmbA=$PaletA[1];
					$CorrSIPAa=$PaletB[2];//SI TIENE ESTE CAMPO, ESTA EMBARCADO
					$PaletB=ObtengoDatosPaletAB($Row["lote"],'B','S');
					$PaletB=explode('-:-',$PaletB);
					$ValorB=$PaletB[0];
					$TmbB=$PaletB[1];
					$CorrSIPAb=$PaletB[2];//SI TIENE ESTE CAMPO, ESTA EMBARCADO
					echo "<td colspan='3'>";
						echo "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
						if($ValorA!='0'){
							if($CorrSIPAa=='')
							{
							echo "<tr valign='bottom'>\n
								<td align='right' width='38%'>A: <input type='checkbox' style='border:none;' name='SelectedEmb' value='".$Row["lote"]."-/-A"."'>".number_format($Row["peso_palet_a"],2,',','')."</td>\n
								<td align='right' width='32%'>".number_format($ValorA,2,',','')."</td>\n
								<td align='center' width='23%'>".$TmbA."</td>\n
							</tr>\n"; 
							}
							else
							{
							echo "<tr valign='bottom'>\n
								<td align='right' width='38%'>A: Emb.".number_format($Row["peso_palet_a"],2,',','')."</td>\n
								<td align='right' width='32%'>".number_format($ValorA,2,',','')."</td>\n
								<td align='center' width='23%'>".$TmbA."</td>\n
							</tr>\n"; 
							}
						}
						if($ValorB!='0'){
							if($CorrSIPAb=='')
							{
							echo "<tr valign='bottom'>\n
								<td align='right' width='38%'>B: <input type='checkbox' style='border:none;' name='SelectedEmb' value='".$Row["lote"]."-/-B"."'>".number_format($Row["peso_palet_b"],2,',','')."</td>\n
								<td align='right' width='32%'>".number_format($ValorB,2,',','')."</td>\n
								<td align='center' width='23%'>".$TmbB."</td>\n
							</tr>\n";
							}
							else
							{
							echo "<tr valign='bottom'>\n
								<td align='right' width='38%'>B: Emb.".number_format($Row["peso_palet_b"],2,',','')."</td>\n
								<td align='right' width='32%'>".number_format($ValorB,2,',','')."</td>\n
								<td align='center' width='23%'>".$TmbB."</td>\n
							</tr>\n";
							}
						}
						echo "</table>";
					echo "</td>";					
					echo "</tr>\n";
				}
				if($HayD=='N')
				{
					?>
					<tr><td colspan="9" align="center" class="TituloTablaNaranja">No hay lotes asignados a S.A</td></tr>
					<?php
				}
				?>
			      </table></td>
			    </tr>
			  </table></td>
			</tr>
			</table>	
	    <?php
	}
		?>
	    <br>		
         <table width="600" border="0" align="center" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> 
			  <?php
		  	  $Boton='G';	
		  	  $BotonLabel='Grabar';	
			 // if($ExisteCorrelativo=='S')
			  //{
			  ?>
			  <input name="BtnGrabar" type="button" value="<?php echo $BotonLabel;?>" style="width:60px;" onClick="Proceso('<?php echo $Boton?>');">
              <?php
			  //}
			  ?>
			  <input name="BtnCancelar" type="button" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
	<?php
	}
	?>	
	</td>
  </tr>
</table>

</form>
</body>
</html>
<script language="javascript">
var Rec='<?php echo $Rec;?>';
if(Rec=='')
	window.document.frmPrincipalRpt.Corr.focus();
</script>