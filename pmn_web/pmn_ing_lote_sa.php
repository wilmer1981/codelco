<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 123;
	include("../principal/conectar_pmn_web.php");
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
			if(SoloUnElemento(f.name,'Selected','E'))
			{
				Datos=Recuperar(f.name,'Selected');
				if(confirm('�Esta seguro de asignar lotes con SA?'))
				{
					f.action= "pmn_ing_lote_sa01.php?Proceso=G&Valores="+Datos;
					f.submit();
				}
			}
			break;
		case "Consulta": //CANCELAR
			f.action= "pmn_lote_sa.php?Consulta=S";
	 		f.submit();
			break;
		case "R": //CANCELAR
			if(f.Anterior.value!='S')
				f.action= "pmn_pesaje.php?LR=<?php echo $LR;?>&LRO="+f.Lote.value;
			else
				f.action= "pmn_pesaje.php?LR=<?php echo $LR;?>&LRO="+f.Lote.value+"&Mostrar=S";	
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
function MOdificar(Lote,Lixi)
{
	var f = document.frmPrincipalRpt;
	if(SoloUnElemento(f.name,'Selected','M'))
	{
		Datos=Recuperar(f.name,'Selected');
		Datos=Datos.split('~');
		f.action= "pmn_pesaje.php?Opcion=M&LR="+Datos[0]+"&Lx="+Datos[1];
		f.submit();
	}
}
function Eliminar()
{
	var f = document.frmPrincipalRpt;
	if(SoloUnElemento(f.name,'Selected','E'))
	{
		Datos=Recuperar(f.name,'Selected');
		if(confirm('�Esta seguro de eliminar registro(s)?'))
		{
			f.action= "pmn_ing_pesaje01.php?Proceso=E&Valores="+Datos;
			f.submit();
		}
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
		if(Msj=='A')
			alert('Lotes seleccionados asignados a SA con �xito')
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
	<table width="700" cellpadding="3" cellspacing="0" align="center" class="TablaInterior">
          <tr> 
            <td width="100" height="30" class="titulo_azul">Fecha Lote:</td>
            <td width="366"> 
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
				}
			?>            </td>
            <td width="231"><input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('Consulta');"></td>
          </tr>
		  <?php
	    if($EnDetalleTamb < $TotDeTambores)
	    {
		  if($Lixiviacion!='S' && $Lixiviacion!='')
		  {
		  ?>
		  <?php		  
		  }
		}
		else
		{
		?>
        <?php	
		}
		  ?>
        </table>
        <br>
        <table width="750" border="0" align="center" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> 
			  <input name="BtnGrabar" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G');">
              <input name="BtnSalir" type="button" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
		<?php
		if($Consulta=='S')
		{
		?>
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td valign="top"> 
              <table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
                <tr align="center" class="ColorTabla01"> 
                  <td width="41" height="15" class="ColorTabla01">&nbsp;</td>
                  <td width="41" height="15" class="ColorTabla01">Lote</td>
                  <td width="70">SA</td>
                  <td width="140">Producto SA</td>
                  <td width="80">Subproducto SA</td>
                  <td width="160">Leyes</td>
                  <td width="70">Peso Lote</td>
                  <td width="70">Peso Pale</td>
                  <td width="80">S.A Asignada</td>
                </tr>
                <?php	
				$Consulta = "select *,t1.nro_solicitud as CabeceraSA from pmn_web.pmn_pesa_bad_cabecera t1 inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra";
				$Consulta.= " where year(t1.fecha_hora)='".$Ano."' and month(t1.fecha_hora)='".$Mes."' and day(t1.fecha_hora)='".$Dia."' ";
				$Consulta.= " group by t1.lote order by t1.lote asc";
				$Respuesta = mysqli_query($link, $Consulta);
				//echo $Consulta;
				echo "<input type='hidden' name='Selected' />";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$NomProductoSA=NomProducto($Row["cod_producto"]);
					$NomSubProductoSA=NomSubProducto($Row["cod_producto"],$Row["cod_subproducto"]);
					$Leyes=ObtenerLeyes($Row["nro_solicitud"]);
					
					$OK='';
					if($Row[CabeceraSA]!='')
						$OK='OK';
					$TotNeto=TotalNetoLote($Row[lote]);	
					echo "<tr valign='top'>\n";
					if($OK=='')
						echo "<td align='center'><input type='checkbox' style='border:none;' name='Selected' value='".$Row[lote]."'>\n";
					else
						echo "<td align='center'>&nbsp;\n";	
					echo "</td>\n";
					echo "<td align='center'>".$Row[lote]."</td>\n";
					echo "<td align='right'>".$Row["nro_solicitud"]."<input type='hidden' name='SA[".$Row[lote]."]' value='".$Row["nro_solicitud"]."'></td>\n";
					echo "<td align='left'>".$NomProductoSA."</td>\n";
					echo "<td align='left'>".$NomSubProductoSA."</td>\n";
					echo "<td align='left'>".$Leyes."</td>\n";
					echo "<td align='center'>".$TotNeto."</td>\n";
					echo "<td align='center'><input type='text' name='PesoPale[".$Row[lote]."]' value='".number_format($Row[peso_palet],3,',','')."' onKeyDown='SoloNumeros(true,this)' size='5' maxlength='7' id='PesoPale'></td>\n";
					echo "<td align='center' class='TituloCabecera'>".$OK."</td>\n";
					echo "</tr>\n";
					echo "<tr>\n";
					echo "<td align='center' colspan='7'>";
							/*echo "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
								echo "<tr class='ColorTabla01'>\n";
								echo "<td align='center'>Recargos</td>\n";
								echo "<td align='right'>Peso Bruto</td>\n";
								echo "<td align='right'>Peso Tara</td>\n";
								echo "<td align='right'>Peso Neto</td>\n";
								echo "</tr>\n";
							$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
							$Consulta.= " where lote='".$Row[lote]."'";
							$Consulta.= " order by recargo";
							$RespuestaDet = mysqli_query($link, $Consulta);$TotNeto=0;$TotTara=0;$TotBruto=0;
							while ($RowDet = mysqli_fetch_array($RespuestaDet))
							{
								echo "<tr>\n";
								echo "<td align='center'>".$RowDet["recargo"]."</td>\n";
								echo "<td align='right'>".$RowDet[pbruto]."</td>\n";
								echo "<td align='right'>".$RowDet[ptara]."</td>\n";
								echo "<td align='right'>".$RowDet[pneto]."</td>\n";
								echo "</tr>\n";
								$TotBruto=$TotBruto+$RowDet[pbruto];
								$TotTara=$TotTara+$RowDet[ptara];
								$TotNeto=$TotNeto+$RowDet[pneto];
							}
							echo "<tr  class='TituloCabecera'>\n";
							echo "<td align='center'>Total</td>\n";
							echo "<td align='right'>".$TotBruto."</td>\n";
							echo "<td align='right'>".$TotTara."</td>\n";
							echo "<td align='right'>".$TotNeto."</td>\n";
							echo "</tr>\n";
							echo "</table>";*/
					echo "</td>\n";
					echo "</tr>\n";
				}
				?>
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
