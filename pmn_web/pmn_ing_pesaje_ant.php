<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 123;
	include("../principal/conectar_pmn_web.php");

if(!isset($Anor))
	$Anor=date('Y');
if(!isset($Mesr))
	$Mesr=date('m');
	
	switch($Opcion)
	{
		case "M":
				$Recargo=$Lx;
				if(isset($LR))
					$Lote=$LR;
				$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
				$Consulta.= " where lote='".$Lote."' and recargo='".$Recargo."'";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				$Row = mysqli_fetch_array($Respuesta);
				$Recargo=$Row["recargo"];
				$Lx=$Row[num_lixiviacion];
				$Lixiviacion=$Row[num_lixiviacion];
				$PesoNeto=$Row[pneto];
				$PesoTara2=$Row[ptara];
				$PesoBruto2=$Row[pbruto];
				$Obs=$Row[obs];
				$SInt=$Row[sint];
				$SExt=$Row[sext];
				$PesoBruto=$Row[pbruto];
				$PesoTotal=number_format($Row[peso_total],2,',','');
			$Consulta="select * from proyecto_modernizacion.clase where cod_clase='6001'";
			$RESP=mysqli_query($link, $Consulta);$TotDeTambores=0;
			$Fila=mysqli_fetch_assoc($RESP);
			$TotDeTambores=$Fila[valor1];
				
		break;
		default;
			if($LR=='')
			{
				$AnoDefault=$Anor;
				$MEsDefault=$Mesr;
				$Lote=ObtengoMaximo('pmn_pesa_bad_cabecera','lote',"year(fecha_hora)=".$AnoDefault." and month(fecha_hora)=".$MEsDefault."");
				if(strlen($Lote)==1)
				{
					$Ano=$AnoDefault;
					$Mes=str_pad($MEsDefault,2,0,STR_PAD_LEFT);
					$Lote=substr($Ano,2,2).$Mes.str_pad($Lote,3,0,STR_PAD_LEFT);
				}
			}
			else
				$Lote=$LR;
			if($LRO!=$Lote && isset($LRO))	
				$Lote=$LRO;
				
			$Recargo=ObtengoMaximo('pmn_pesa_bad_detalle','recargo','lote='.$Lote);
			
			$Consulta="select * from proyecto_modernizacion.clase where cod_clase='6001'";
			$RESP=mysqli_query($link, $Consulta);$TotDeTambores=0;
			$Fila=mysqli_fetch_assoc($RESP);
			$TotDeTambores=$Fila[valor1];
		break;
	}
$Ano=$Anor;
$Mes=$Mesr;
$Dia=$Diar;	
if($Mostrar=='S')
{
	$Consulta="select year(fecha_hora) as Ano,month(fecha_hora) as Mes,day(fecha_hora) as Dia,peso_palet_a,peso_palet_b,BAC from pmn_pesa_bad_cabecera where lote='".$Lote."'";
	$RESP=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_assoc($RESP))
	{
		$Ano=$Fila[Ano];
		$Mes=$Fila[Mes];
		$Dia=$Fila[Dia];
		$Mostrar='S';
		$pesoPaletA=$Fila[peso_palet_a];
		$pesoPaletB=$Fila[peso_palet_b];
		$ChkBAC='';
		if($Fila[BAC]=='S')
			$ChkBAC='checked="checked"';
	}
	else
	{
		$Ano=$Anor;
		$Mes=$Mesr;
		$Dia=$Diar;
	}
}
$PesoTara='9,5';
if($PesoTara2!='')
	$PesoTara=$PesoTara2;
	
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
			var PesoStockBad=parseFloat(f.pesoStockBad.value.replace(',','.'));
			var Neto=parseFloat(f.PesoNeto.value.replace(',','.'));
			if(Neto > PesoStockBad)
			{
				alert('Valor neto de tambor, no puede ser mayor a stock BAD de la lixiviaci�n.')
				f.PesoBruto.focus();
				return;
			}	
			var PesoTotal=parseFloat(f.PesoTotal.value.replace(',','.'));
			var Neto=parseFloat(f.PesoNeto.value.replace(',','.'));
			if(Neto > PesoTotal)
			{
				alert('Valor neto de tambor, no puede ser mayor al total del tambor.')
				f.PesoBruto.focus();
				return;
			}		
			if(f.Lixiviacion.value=='S')
			{
				alert('Debe seleccionar lixiviaci�n');
				f.Lixiviacion.focus();
				return;
			}	
			if(f.SInt.value=='')
			{
				alert('Debe ingresar sello interno');
				f.SInt.focus();
				return;
			}	
			if(f.SExt.value=='')
			{
				alert('Debe ingresar sello externo');
				f.SExt.focus();
				return;
			}	
			if(f.PesoTotal.value=='')
			{
				alert('Debe ingresar Peso total del tambor');
				f.PesoTotal.focus();
				return;
			}	
			f.action= "pmn_ing_pesaje01.php?Proceso=G&PesoNeto="+f.PesoNeto.value;
	 		f.submit();
			break;
		case "BAC": //GRABAR BAC		
			f.action= "pmn_ing_pesaje01.php?Proceso=BAC&BACV="+f.BAC.checked;
	 		f.submit();
			break;
		case "PPl": //GRABAR PESO PALET		
			if(f.pesoPaletA.value=='')
			{
				alert('Debe ingresar peso palet A.')
				f.pesoPaletA.focus();
				return;
			}		
			if(f.pesoPaletB.value=='')
			{
				alert('Debe ingresar peso palet B.')
				f.pesoPaletB.focus();
				return;
			}		
			f.action= "pmn_ing_pesaje01.php?Proceso=PPl";
	 		f.submit();
			break;
		case "Anteriores": //Anteriores
			f.action= "pmn_ing_pesaje01.php?Proceso=LAnt";
	 		f.submit();
			break;
		case "Consulta": //CANCELAR
			f.action= "pmn_pesaje.php?&LR="+f.Lote.value+"&Mostrar=S&Anor="+f.Ano.value+"&Mesr="+f.Mes.value+"&Diar="+f.Dia.value;
	 		f.submit();
			break;
		case "R": //CANCELAR
			if(f.Anterior.value!='S')
				f.action= "pmn_pesaje.php?LR=<?php echo $LR;?>&LRO="+f.Lote.value+"&Anor="+f.Ano.value+"&Mesr="+f.Mes.value+"&Diar="+f.Dia.value;
			else
				f.action= "pmn_pesaje.php?LR=<?php echo $LR;?>&LRO="+f.Lote.value+"&Mostrar=S&Anor="+f.Ano.value+"&Mesr="+f.Mes.value+"&Diar="+f.Dia.value;	
	 		f.submit();
			break;
		case "R2": //CANCELAR
			f.action= "pmn_pesaje.php?LR=<?php echo $LR;?>&Anor="+f.Ano.value+"&Mesr="+f.Mes.value+"&Diar="+f.Dia.value;
	 		f.submit();
			break;
		case "C": //CANCELAR
			f.action= "pmn_ing_pesaje01.php?Proceso=C";
	 		f.submit();
			break;
		/*case "B": //CANCELAR
			var URL = "pmn_embarque02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;*/
		case "S": //SALIR
			f.action="../principal/sistemas_usuario.php?CodSistema=6";
			f.submit();
			break;
	}

}
function LoteAnterior()
{
	var f = document.frmPrincipalRpt;
	f.action= "pmn_pesaje.php?&LR="+f.Lote.value+"&Mostrar=S";
	f.submit();
}
function completP(Datos)
{
	var f = document.frmPrincipalRpt;
	Datos=Datos.split('~');
	var Lote=Datos[0];
	var Recargo=Datos[1];
	var URL= "pmn_ing_pesaje02.php?&Lote="+Lote+"&Recargo="+Recargo;
	window.open(URL,"","top=120,left=350,width=610,height=350,menubar=no,resizable=yes,scrollbars=yes,status=yes");
}
function MOdificar(Lote,Lixi)
{
	var f = document.frmPrincipalRpt;
	if(SoloUnElemento(f.name,'Selected','M'))
	{
		Datos=Recuperar(f.name,'Selected');
		Datos=Datos.split('~');
		f.action= "pmn_pesaje.php?Opcion=M&LR="+Datos[0]+"&Lx="+Datos[1]+"&Mostrar=S";
		f.submit();
	}
}
function Eliminar(Datos)
{
	var f = document.frmPrincipalRpt;
	if(confirm('Esta seguro de eliminar registro(s)?'))
	{
		f.action= "pmn_ing_pesaje01.php?Proceso=E&Valores="+Datos;
		f.submit();
	}
}
function CalculaBT()
{
	var f = document.frmPrincipalRpt;
	var Valor=parseFloat(f.PesoBruto.value.replace(',','.'))-parseFloat(f.PesoTara.value.replace(',','.'));
	f.PesoNeto.value=decimales(Valor,2);
	document.getElementById('ValorNeto').innerHTML=decimales(Valor,2);
}
function Msj(Msj)
{
	if(Msj!='')
	{
		if(Msj=='E')
			alert('Registros eliminados con �xito')
		if(Msj=='EN')
			alert('Registro no se puede eliminar ya que existe(n) Tambor(es) mayor(es)')
		if(Msj=='PplS')
			alert('Peso palet ingresado con �xito')
		if(Msj=='Bac1')
			alert('Lote modificado a tipo BAC.')
		if(Msj=='Bac2')
			alert('Lote modificado a tipo BAD.')
	}
}
</script>
</head>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="Msj('<?php echo $Msj;?>')">
<form name="frmPrincipal" method="post" action="">
<input type="hidden" name="Anterior" id="Anterior" value="<?php echo $Mostrar;?>">
<table width="100%" border="0" class="TituloCabeceraOz">
    <tr>
    <td>
	<table width="761" cellpadding="3" cellspacing="0" align="center" class="TablaInterior">
          <tr> 
            <td width="100" height="30" class="titulo_azul">Fecha:</td>
            <td colspan="4"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
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
				  echo "</select> <select name='Mes' style='width:100px' onChange=Proceso('R2')>\n";
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
				  echo "</select> <select name='Ano' style='width:60px' onChange=Proceso('R2')>\n";
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
				}
			?>            </td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">Lote</td>
            <td colspan="7">
			<?php
			
			if($Opcion=='LAnt')
			{
			?>
			<select name="Lote" style="width:130px" onChange="LoteAnterior('')">
			<option value="S">Seleccionar anterior</option>
			<?php		
			$Consulta = "SELECT * FROM pmn_web.pmn_pesa_bad_cabecera";
			$Consulta.= " WHERE lote<>''  and year(fecha_hora)='".$Anor."' and month(fecha_hora)='".$Mesr."'";
			//$Consulta.= " AND ((YEAR(fecha) = '2004' AND num_lixiviacion >= '800') OR (YEAR(fecha) >= 2005))";
			$Consulta.= " ORDER BY lote asc";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Lote==$Row["lote"])
					echo "<option selected value = '".$Row["lote"]."'>".$Row["lote"]."</option>\n";
				else	
					echo "<option  value = '".$Row["lote"]."'>".$Row["lote"]."</option>\n";
			}
			?>
			</select><?php //echo $Consulta;?>
			<?php
			}
			else
			{
				echo "<strong>".$Lote."</strong>";
			?>
            <input name="Lote" type="hidden" value="<?php echo $Lote;?>" size="6" maxlength="7" onKeyDown="SoloNumeros(false,this)">&nbsp;
				<?php if($Mostrar!='S')
				{?>
				<input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('Consulta');">
				<?php
				}
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="ver" type="button" style="width:105" value="Ver Lotes Ingresados" onClick="Proceso('Anteriores');">
				<?php
			}
			$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
			$Consulta.= " where lote='".$Lote."' and recargo='8'";
			$Consulta.= " order by recargo";
			$Respuesta = mysqli_query($link, $Consulta);$EnDetalleTamb=0;
			while ($Row = mysqli_fetch_array($Respuesta))
					$EnDetalleTamb=$Row["recargo"];
			?>
			&nbsp;&nbsp;<?php if($Mostrar=='S') { ?>Es BAC:&nbsp;<input type="checkbox" name="BAC" <?php echo $ChkBAC;?> onClick="Proceso('BAC')"><?php }?></td>
          </tr>
		  <?php
		  if($Mostrar=='S')
		  {
		  ?>
          <tr> 
            <td class="titulo_azul">Num. lixiviaci�n</td>
            <td colspan="7">
			<select name="Lixiviacion" style="width:100px" onChange="Proceso('R')">
			<option value="S">Seleccionar</option>
			<?php
			$Consulta = "SELECT * FROM pmn_web.lixiviacion_barro_anodico";
			$Consulta.= " WHERE stock_bad > 0 and bad>0 and year(fecha)>=2011";
			//$Consulta.= " AND ((YEAR(fecha) = '2004' AND num_lixiviacion >= '800') OR (YEAR(fecha) >= 2005))";
			$Consulta.= " ORDER BY num_lixiviacion asc";
			$Respuesta = mysqli_query($link, $Consulta);$PesoTotalBad='';
			while ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Lixiviacion==$Row[num_lixiviacion])
				{
					$PesoTotalBad=number_format($Row[stock_bad],2,',','');
						echo "<option selected value = '".$Row[num_lixiviacion]."'>".str_pad($Row[num_lixiviacion],6,0,STR_PAD_LEFT)." -- ".number_format($Row[stock_bad],2,',','')."</option>\n";
				}
				else
					echo "<option  value = '".$Row[num_lixiviacion]."'>".str_pad($Row[num_lixiviacion],6,0,STR_PAD_LEFT)." -- ".number_format($Row[stock_bad],2,',','')."</option>\n";
			}
			?>
            </select>&nbsp;&nbsp;<?php echo 'Stock BAD lixiviaci�n: '.$PesoTotalBad;//."   ".$TotalTambores;?>
			<input type="hidden" name="pesoStockBad" id="pesoStockBad" value="<?php echo $PesoTotalBad;?>">			</td>
          </tr>
		  <?php
		  }
		//echo $EnDetalleTamb." - ". $TotDeTambores;  
	    if($EnDetalleTamb < $TotDeTambores)
	    {
		  if($Mostrar=='S')
		  {
		  ?>
          <tr> 
            <td class="titulo_azul">Tambor</td>
            <td width="76"><?php echo $Recargo;?><input name="Recargo" type="hidden" value="<?php echo $Recargo;?>" size="3" maxlength="2"></td>
            <td width="113" class="titulo_azul">Peso Bruto</td>
            <td width="71"><input name="PesoBruto" type="text" id="PesoBruto" value="<?php echo number_format($PesoBruto,2,',','');?>" size="6" onKeyDown="SoloNumeros(true,this)" onBlur="CalculaBT()" maxlength="7"></td>
            <td width="106" class="titulo_azul">Peso Tara</td>
            <td width="75"><input name="PesoTara" type="text" id="PesoTara" value="<?php echo $PesoTara;?>" size="6" onKeyDown="SoloNumeros(true,this)" onBlur="CalculaBT()" maxlength="7"></td>
            <td width="89" class="titulo_azul">Peso Neto</td>
            <td width="67"><label id="ValorNeto"></label><input name="PesoNeto" type="hidden" id="PesoNeto" disabled="disabled" value="<?php echo $PesoNeto;?>" size="6" maxlength="7"></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Sello interno </td>
            <td><input name="SInt" type="text" id="SInt" value="<?php echo $SInt;?>" size="5" maxlength="7" onKeyDown="SoloNumeros(true,this)" onBlur="CalculaBT()"></td>
            <td class="titulo_azul">Sello externo </td>
            <td><input name="SExt" type="text" id="SExt" value="<?php echo $SExt;?>" size="4" maxlength="6" onKeyDown="SoloNumeros(true,this)" onBlur="CalculaBT()"></td>
            <td class="titulo_azul">Peso Total Tambor (neto)</td>
            <td><input name="PesoTotal" type="text" id="PesoTotal" value="<?php echo $PesoTotal;?>" size="6" onKeyDown="SoloNumeros(true,this)" maxlength="7"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">Observaci&oacute;n:</td>
            <td colspan="7"><input name="Obs" type="text" id="Obs" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>
		  <?php		  
		  }
		}
		else
		{
		?>
          <tr> 
            <td class="titulo_azul" colspan="8">Lote completado. (si desea cambiar totalidad de tambores, comunicarse con TICA ventanas).</td>
          </tr>
		  <tr>
			  <td class="titulo_azul">Ingresar Peso Palet A</td>
			  <td colspan="7" class="titulo_azul"><input type="text" name="pesoPaletA" size="3" maxlength="6" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($pesoPaletA,2,',','');?>">&nbsp;Kg&nbsp;&nbsp;</td>
		  </tr>
		  <tr>
			  <td class="titulo_azul">Ingresar Peso Palet B</td>
			  <td colspan="7" class="titulo_azul"><input type="text" name="pesoPaletB" size="3" maxlength="6" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($pesoPaletB,2,',','');?>">&nbsp;Kg&nbsp;&nbsp;<input name="BtnEliminar" type="button" value="Grabar Pesos" style="width:80px;" onClick="Proceso('PPl');"></td>
		  </tr>
        <?php	
		}
		 ?>
        </table>
        <br>
        <table width="761" border="0" align="center" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> 
			  <?php
		  	  $Boton='G';	
		  	  $BotonLabel='Grabar';	
			  if($ModRec=='S')
			  {	$Boton='M';	$BotonLabel='Grabar';	}
			  if($EnDetalleTamb < $TotDeTambores)
			  {
			  ?>
			  <input name="BtnGrabar" type="button" value="<?php echo $BotonLabel;?>" style="width:60px;" onClick="Proceso('<?php echo $Boton?>');">
              <input name="BtnEliminar" type="button" value="Modificar" style="width:60px;" onClick="MOdificar();"> 
              <?php
			  }
			  ?>               
              <input name="BtnCancelar" type="button" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
		<?php
		if($Lote!='')
		{
		?>
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td valign="top"> 
              <table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
                <tr align="center" class="ColorTabla01"> 
                  <td width="41" height="15" class="ColorTabla01">Elim.</td>
                  <td width="41" height="15" class="ColorTabla01">Mod.</td>
                  <td width="41" height="15" class="ColorTabla01">Lote</td>
                  <td width="87">Num. Lixiviaciones</td>
                  <td width="95">Tambor</td>
                  <td width="149">Peso Bruto</td>
                  <td width="149">Peso Tara</td>
                  <td width="149">Peso Neto</td>
                  <td width="149">Sello interno</td>
                  <td width="149">Sello externo</td>
				  <td>&nbsp;</td>
                </tr>
                <?php	
				$Consulta = "select count(recargo) as cantidad from pmn_web.pmn_pesa_bad_detalle ";
				$Consulta.= " where lote='".$Lote."'";
				$Consulta.= " order by recargo desc";
				$Respuesta = mysqli_query($link, $Consulta);
				if($Row = mysqli_fetch_array($Respuesta))
					$UltimoCant=$Row[cantidad];
				$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
				$Consulta.= " where lote='".$Lote."'";
				$Consulta.= " order by recargo";
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				$Total02=0;
				$Total03=0;
				$Total04=0;$RecAux='';
				echo "<input type='hidden' name='Selected' />";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					//$Row[pneto]=0;
					/*$Valores=CantidadLixPorTambor($Row["lote"],$Row["recargo"]);	
					$LixyValor=explode('-:-',$Valores);
					$Row[num_lixiviacion]=$LixyValor[0];
					$Row[pneto]=$LixyValor[1];*/
					if($Row["recargo"]!=$RecAux && $RecAux!='')
					{
						?>
						<tr class="TituloCabecera"><td colspan="5" align='right'>Sub-Total Tambor <?php echo $RecAux;?></td>
						<td align='right'><?php echo $SubTotRec1;?></td>
						<td align='right'><?php echo $SubTotRec2;?></td>
						<td align='right'><?php echo $SubTotRec3;?></td>
						<td colspan="3">&nbsp;</td>
						</tr>
						<?php
						$SubTotRec1=0;$SubTotRec2=0;$SubTotRec3=0;
					}
					
					
					$BlokeaChk="N";
					if($Row["fecha_embarque"]!='')
						$BlokeaChk="S";
					echo "<tr>\n";
					if($UltimoCant==$i)
					{
						if($BlokeaChk=='N')
						{?><td align="center"><input name="BtnEliminar" type="button" title="Eliminar" value="X" style="width:15px;" onClick="Eliminar('<?php echo $Row["lote"]."~".$Row["recargo"]."~".$Row["fecha_hora"];?>');"></td><?php 
						}else{
						?><td align="center">&nbsp;</td><?php 
						}
					}
					else
					{
					?><td align="right">&nbsp;</td><?php
					}
					if($BlokeaChk=='N')
						echo "<td align='center'><input type='checkbox' style='border:none;' name='Selected' value='".$Row["lote"]."~".$Row["recargo"]."~".$Row["fecha_hora"]."'>\n";
					else
						echo "<td align='center'>&nbsp;\n";	
					echo "</td>\n";
					echo "<td align='center'>".$Row["lote"]."</td>\n";
					echo "<td align='right'>".$Row[num_lixiviacion]."</td>\n";
					echo "<td align='center'>".$Row["recargo"]."</td>\n";
					echo "<td align='right'>".number_format($Row[pbruto],2,',','.')."</td>\n";					
					echo "<td align='right'>".number_format($Row[ptara],2,',','.')."</td>\n";
					echo "<td align='right'>".number_format($Row[pneto],2,',','.')."</td>\n";
					echo "<td align='right'>".$Row[sint]."</td>\n";
					echo "<td align='right'>".$Row[sext]."</td>\n";
					if($UltimoCant==$i)
					{
						$Consulta = "select peso_total,sum(pneto) as PNeto from pmn_web.pmn_pesa_bad_detalle ";
						$Consulta.= " where lote='".$Lote."' and recargo='".$Row["recargo"]."' group by recargo";
						$Respuesta2 = mysqli_query($link, $Consulta);
						$Row2 = mysqli_fetch_array($Respuesta2);
						if($Row2[peso_total] > $Row2[PNeto])
						{
							if($BlokeaChk=='N')
							{ ?><td align="right"><input type="button" value="Completar Peso" style="width:80px;" onClick="completP('<?php echo $Row["lote"]."~".$Row["recargo"];?>')"></td><?php 
							}else{
							?><td align="right">Embarcado</td><?php 	
							}
						}else{
							?><td align="right">&nbsp;</td><?php 	
							}
					}
					else
					{
						if($BlokeaChk=='N')
						{ ?><td align="right">&nbsp;</td><?php }else{?><td align="right">Embarcado</td><?php }
					}
					echo "</tr>\n";
					$i++;
					$Total02 = $Total02 + $Row[pbruto];
					$Total03 = $Total03 + $Row[ptara];
					$Total04 = $Total04 + $Row[pneto];
					$Total01++;
					
					if($Row["recargo"]!=$RecAux)
						$SubTotal2= $SubTotal2 + $Row[ptara];
						
					$SubTotal3= $SubTotal3 + $Row[pneto];

					if($Row["recargo"]!=$RecAux)
						$SubTotRec2= $SubTotRec2 + $Row[ptara];
						
					$SubTotRec3= $SubTotRec3 + $Row[pneto];

					$SubTotal1= $SubTotal2 + $SubTotal3;
					$SubTotRec1= $SubTotRec2 + $SubTotRec3;
					
					if($Row["recargo"] > 4)
					{
						?>
						<tr class="TituloCabecera"><td colspan="5" align='right'>Sub-Total Palet A</td>
						<td align='right'><?php echo $SubTotal1;?></td>
						<td align='right'><?php echo $SubTotal2;?></td>
						<td align='right'><?php echo $SubTotal3;?></td>
						<td colspan="3">&nbsp;</td>
						</tr>
						<?php
						$SubTotal1=0;$SubTotal2=0;$SubTotal3=0;
					}
					$RecAux=$Row["recargo"];
				}
				if($RecAux>=4)
				{
					?>
					<tr class="TituloCabecera"><td colspan="5" align='right'>Sub-Total Tambor <?php echo $RecAux;?></td>
					<td align='right'><?php echo $SubTotRec1;?></td>
					<td align='right'><?php echo $SubTotRec2;?></td>
					<td align='right'><?php echo $SubTotRec3;?></td>
					<td colspan="3">&nbsp;</td>
					</tr>
					<?php
				}
				?>
				<tr class="TituloCabecera"><td colspan="5" align='right'>Sub-Total Palet B</td>
					<td align='right'><?php echo $SubTotal1;?></td>
					<td align='right'><?php echo $SubTotal2;?></td>
					<td align='right'><?php echo $SubTotal3;?></td>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr align="center"> 
				  <td height="15" colspan="3" align="right"><strong>TOTAL</strong></td>
				  <td align="right">&nbsp;</td>
				  <td align="right">&nbsp;</td>
				  <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
				  <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
				  <td align="right"><?php echo number_format($Total04,2,',','.'); ?></td>
				  <td align="right">&nbsp;</td>
				  <td align="right">&nbsp;</td>
				  <td align="right">&nbsp;</td>
				</tr>
		  </table>            
		  </td>
          </tr>
        </table>
        <?php
		}
		?>
      </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
if($Opcion=='M')
{ ?><script language="javascript">CalculaBT();</script><?php }
?>