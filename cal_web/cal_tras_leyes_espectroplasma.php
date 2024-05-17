<?php
$CodigoDeSistema = 1;
$CodigoDePantalla = 78;
include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$HoraActual = date("H");
$MinutoActual = date("i");
?>
<html>
<head>
<title>Traspaso Leyes EspectroPlasma</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.EspectroPlasma;
	switch (Opcion)
	{
		case "PE"://procesa excel
			if(frm.file.value=='')
			{
				alert('Debe Seleccionar Archivo a Cargar.')
				return;
			}
			var UltimoPunto=frm.file.value.lastIndexOf('.');
			var Extension=frm.file.value.substring(UltimoPunto+1);
			if(Extension=='txt')
			{	
				frm.action="cal_tras_leyes_espectroplasma01.php?Opcion=Procesa";
				frm.submit();
			}
			else
			{
				alert('Documento debe tener extension .xls')
				return;
			}
			break;
		case "Guarda": 
			var mensaje=confirm('¿Está Seguro de Traspasar las Leyes?')
			if(mensaje==true)
			{
				frm.action="cal_tras_leyes_espectroplasma01.php?Opcion=Guarda";
				frm.submit();
			}	
			break;	
		case "S":
			frm.action="../principal/sistemas_usuario.php?CodSistema=1";
			frm.submit(); 
		break;
	}	
}
function Mensaje(Msj,Formato)
{
	if(Msj=='NC')
	{
		alert('Seleccionar Nuevamente Archivo, no se Realizó Carga');
		return;
	}
	if(Msj=='G')
	{
		alert('Archivo Procesado con Exito, Revisar y Luego Traspasar.');
		return;
	}
	if(Msj=='NG')
	{
		if(Formato=='N')
		{
			alert('Excel no Cumple con Formato Definido \npara Carga EspectroPLasma');
			return;
		}
		else
		{
			alert('Traspaso no Realizado, Revisar Excel.');
			return;
		}
	}
	if(Msj=='C')
	{
		alert('Traspaso de Datos Realizado con Exito.');
		return;
	}
}
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Muestra(SA,Ley)
{
	window.open("cal_tras_leyes_espectroplasma_proceso.php?SA="+ SA+"&Ley="+Ley,"","top=120,left=150,width=500,height=350,scrollbars=yes,resizable = no");					
}
</script></head>
<?php
if($Msj=='P')
{
	$Consulta="select SA from cal_web.tmp_espectroplasma where rut='".$CookieRut."'";		
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_assoc($Resp))
	{
		$Msj="G";
	}
	else
		$Msj="NG";
}
?>
<body onLoad="Mensaje('<?php echo $Msj;?>','<?php echo $For;?>')" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<?php
if($Msj=='R')
	$Msj="G";

?><form action="" method="post" enctype="multipart/form-data" name="EspectroPlasma">
  <?php include("../principal/encabezado.php")?>
  <table width="56.7%"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td> <table width="758" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="97" height="26">Archivo(Txt) Carga </td>
            <td width="432" height="26"><input type="file" size="40" name="file"></td>
            <td height="26"><input name="BtnBuscar" type="Button" style="width:110" value="Procesar Archivo" onClick="Proceso('PE');">
            <input name="BtnBuscar2" type="Button" style="width:50" value="Salir" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br>
		  <?php
		  if($Msj=='G')
		  {	
		  ?>
			<table width="500"border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
                <tr>
                  <td height="26" align="center"><input name="BtnBuscar3" type="Button" style="width:70" value="Traspasar" onClick="Proceso('Guarda');">
                  <input name="BtnBuscar222" type="Button" style="width:50" value="Salir" onClick="Proceso('S');"></td>
                </tr>
                        </table>
		 <?php
		 }
		 ?>  
        <br>
		<?php
		$Consulta="select abreviatura from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' group by ley order by abreviatura";
		$Resp=mysqli_query($link, $Consulta);$Mas=200;
		while($Filas=mysqli_fetch_assoc($Resp))
			$Mas=$Mas+10;
		if($M=='S')
		{	
		?>
        <table width="500px" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr> 
            <td colspan="7"><strong>Nota:<br>
			- Valores de Leyes en Blanco no ser&aacute;n Traspasadas a Sistema Control de Calidad<br>
			- Las SA deben estar en estado recepcionada por Control de Calidad o Atendida por el Quimico<br>
			- Las SA Finalizadas no seran actualizadas con estos valores de leyes<br>
			- Los Valores de Origen que se encuentren con un link, representan más de un valor por Ley</strong></td>
		  </tr>	
          <tr class="ColorTabla01"> 
            <td align="center"><div align="center">S.A</div></td>
            <td align="center"><div align="center">Ley</div></td>
            <td align="center">Valor Origen</td>
			<td align="center">Valor</td>
            <td align="center">Unidad</td>
            <td align="center">Signo</td>
            <td align="center">Status</td>
          </tr>
          <?php
			$Signo='';$Valor='';
			$Consulta="select SA,ley,abreviatura,AVG(valor) as valor_ley, count(ley) as CantLey from cal_web.tmp_espectroplasma t1 ";
			$Consulta.="left join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where rut='".$CookieRut."' group by rut,SA,ley";
			$Resp=mysqli_query($link, $Consulta);
			while($Filas=mysqli_fetch_assoc($Resp))
			{
				$Ley=$Filas[ley];
				$LeyNom=$Filas["abreviatura"];
				$Valor=$Filas[valor_ley];
				$ValorOrigen=$Filas[valor_ley];
				//echo $ValorOrigen."<br>";
				$Signo="=";
				//$SA=date('Y').str_pad($Filas[SA],6,0,STR_PAD_LEFT);
				$SA=$Filas[SA];$Unidad='';
				if(ValidarExistenciaSA($SA))
				{
					$CodUnidad=RecuperarUnidadLey($SA,$Ley);
					$Unidad=RecuperarAbrevUnidad($CodUnidad);
					if($CodUnidad!="")
					{
						$CodSubProd=explode('-',RecuperarCodProdSubPro($SA));	
						$Prod=$CodSubProd[0];$SubProd=$CodSubProd[1];
						$Consulta2="select t1.cod_unidad,t1.valor,t1.signo,t3.abreviatura,t2.recargo from cal_web.clasificacion_metodos_plasma t1";
						$Consulta2.=" left join cal_web.solicitud_analisis t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
						$Consulta2.=" left join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad";
						$Consulta2.=" where t1.cod_producto = '".$Prod."' and t1.cod_subproducto='".$SubProd."' and nro_solicitud = '".$SA."' and t1.cod_leyes='".$Ley."'";
						$Resp2=mysqli_query($link, $Consulta2);$Encontro='N';
						if($Fila2=mysqli_fetch_assoc($Resp2))
						{
							$Unidad=$Fila2["abreviatura"];$CodUnidad=$Fila2["cod_unidad"];$Recargo=$Fila2["recargo"];
							//echo $Filas[valor_ley].$Fila2["signo"].$Fila2[valor]."<br>";
							switch($Fila2["signo"])
							{
								case "<":
									if(floatval($Filas[valor_ley]) < floatval($Fila2[valor]))
									{
										$Valor=$Fila2[valor];
										$Signo=$Fila2["signo"];
										$Encontro='S';
									}
								break;
								case ">":
									if(floatval($Fila2[valor]) > floatval($Filas[valor_ley]))	
									{
										$Valor=$Fila2[valor];
										$Signo=$Fila2["signo"];
										$Encontro='S';
									}	
								break;
							
							}
						}	
						if($Encontro=='N')
							$Mensaje='Valor desde equipo Espectrografo';
						else
							$Mensaje='Valor por Default del Metodo';
					}
					else
						$Mensaje='Ley no se encuentra ingresada para esta SA';
					$Actualizar="UPDATE cal_web.tmp_espectroplasma set cod_unidad='".$CodUnidad."',signo='".$Signo."',graba='S' ";
					$Actualizar.=" where rut='".$CookieRut."' and SA='".$SA."' and ley='".$Ley."'";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
							
				}
				else
					$Mensaje='SA no existe en Cal-Web';
				?>
				<tr>
				<td rowspan="<?php echo $Cantidad;?>">
				<?php 
				if(ValidarExistenciaSA($SA))
					echo "<a href=\"javascript:Historial(".$SA.",'".$Recargo."')\">".$SA."</a>";
				else
					echo $SA;
				?>
				</td>
				<td rowspan="<?php echo $Cantidad;?>"><?php echo $LeyNom;?>&nbsp;</td>
				<td align="right" rowspan="<?php echo $Cantidad;?>"><?php if($Filas[CantLey] == 1 ) {echo number_format($ValorOrigen,4,',',''); }else{ echo "<a href=JavaScript:Muestra('".$SA."','".$Ley."')>".number_format($ValorOrigen,4,',','')."</a>"; }?>&nbsp;</td>
				<td align="right" rowspan="<?php echo $Cantidad;?>"><?php echo number_format($Valor,4,',','');?>&nbsp;</td>
				<td rowspan="<?php echo $Cantidad;?>"><?php echo $Unidad;?>&nbsp;</td>
				<td align="center" rowspan="<?php echo $Cantidad;?>"><?php echo $Signo;?>&nbsp;</td>
				<td align="left" rowspan="<?php echo $Cantidad;?>"><?php echo $Mensaje;?>&nbsp;</td>
				</tr>
				<?php
				/*$Consulta3="select unidad from cal_web.tmp_espectroplasma  where rut='".$CookieRut."' and SA='".$Filas[SA]."' group by unidad";
				$Resp3=mysqli_query($link, $Consulta3);$Cantidad=0;
				while($Filas3=mysqli_fetch_assoc($Resp3))
				{
					?>
					<td><?php echo $Filas3[unidad];?></td>
					<?php
					$ConsultaB="select ley from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' group by ley order by abreviatura";
					$RespB=mysqli_query($link, $ConsultaB);
					while($FilasB=mysqli_fetch_assoc($RespB))
					{
						$Consulta4="select valor from cal_web.tmp_espectroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where t1.rut='".$CookieRut."' and SA='".$Filas[SA]."' and unidad='".$Filas3[unidad]."' and ley='".$FilasB[ley]."' group by ley order by abreviatura";
						$Resp4=mysqli_query($link, $Consulta4);
						if($Filas4=mysqli_fetch_assoc($Resp4))
						{
							?>
							<td align="right"><?php echo $Filas4[valor];?></td>
							<?php
						}
						else
						{
							?>
							<td>&nbsp;</td>
							<?php
						}
					}
					?></tr><?php
				}	*/
			}		  	
		  ?>
        </table>
		<br>
		<?php
		if($Msj=='G')
		{
		?>
		<table width="500"border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="26" align="center"><input name="BtnBuscar" type="Button" style="width:70" value="Traspasar" onClick="Proceso('Guarda');">
            <input name="BtnBuscar22" type="Button" style="width:50" value="Salir" onClick="Proceso('S');"></td>
          </tr>
        </table>		
		<?php
		}
		}
		?>
		<br>
	  <br></td>
    </tr>
  </table>
  
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
function ValidarExistenciaSA($SA)
{
	$Encontro=false;
	$Consulta2="select nro_solicitud from cal_web.solicitud_analisis where nro_solicitud='".$SA."'";
	//echo $Consulta2;
	$RespSA=mysqli_query($link, $Consulta2);
	if($FilaSA=mysqli_fetch_assoc($RespSA))
		$Encontro=true;	
	return($Encontro);
}
function RecuperarUnidadLey($SA,$Ley)
{
	$CodUnidad="";
	$Consulta2="select cod_unidad from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and cod_leyes='".$Ley."'";
	$RespSA=mysqli_query($link, $Consulta2);
	if($FilaSA=mysqli_fetch_assoc($RespSA))
		$CodUnidad=$FilaSA["cod_unidad"];
	return($CodUnidad);
}
function RecuperarAbrevUnidad($CodUnidad)
{
	$Abrev="";
	$Consulta="select abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$CodUnidad."'";
	//echo $Consulta."<br>";
	$RespUnidad=mysqli_query($link, $Consulta);
	if($FilaUnidad=mysqli_fetch_assoc($RespUnidad))
		$Abrev=$FilaUnidad["abreviatura"];
	return($Abrev);	
}
function RecuperarCodProdSubPro($SA) 
{
	$CodProdSubp="";
	$ConsultaVacio="select cod_producto,cod_subproducto from cal_web.solicitud_analisis where nro_solicitud = '".$SA."'";
	$RespVacio=mysqli_query($link, $ConsultaVacio);
	if($FilaVacio=mysqli_fetch_assoc($RespVacio))
	{
		$CodProdSubp=$FilaVacio["cod_producto"]."-".$FilaVacio["cod_subproducto"];
	}
	return($CodProdSubp);
}

?>
