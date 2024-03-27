<?
	require_once("EnDecryptText.php"); 
	$EnDecryptText = new EnDecryptText();
	$Usuario= $EnDecryptText->Decrypt_Text($U);
	session_start();
	setcookie("CookieRut", $Usuario);
	
	include('conectar.php');
	require "includes/class.phpmailer.php";	
	include('funciones/siper_funciones.php');

	if($MRCAL=='1'&&$Carga=='S'&&isset($Opc))
	{
		$ActualizaContacto="UPDATE sgrs_siperpeligros set MR1='".$Opc."' where CAREA='".$CODAREA2."' and CCONTACTO='".$CodCont."' and CPELIGRO='".$Peligro."'";
		mysql_query($ActualizaContacto);
	}	
	if($MRCAL=='2'&&$Carga=='S'&&isset($Opc))
	{
		$ActualizaContacto="UPDATE sgrs_siperpeligros set MR2='".$Opc."' where CAREA='".$CODAREA2."' and CCONTACTO='".$CodCont."' and CPELIGRO='".$Peligro."'";
		mysql_query($ActualizaContacto);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function MRr(CODAREA,CONTACTO,PELIGRO,MRr,CodSelTarea)
{
	var f= document.ConsultaPel;	
	var Dato="MRE-"+CONTACTO+"-"+PELIGRO;
	var Valores2='';
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name==Dato && f.elements[i].checked==true)
			Valores2 = f.elements[i].value;
	}
	if(Valores2=='')
	{
		alert('Debe Seleccionar una Magnitud para Peligro');
		return;
	}	
	f.action = "proceso_magnitud_riesgo.php?CODAREA2="+CODAREA+"&CodCont="+CONTACTO+"&MRCAL="+MRr+"&CodSelTarea="+CodSelTarea+"&Opc="+Valores2+"&Carga=S&U="+f.U.value+"&Peligro="+PELIGRO;
	f.submit();
}
function EnviaCorreo(CODAREA,CONTACTO,MRr,CodSelTarea)
{
var f= document.ConsultaPel;	
f.action = "proceso_magnitud_riesgo.php?CODAREA2="+CODAREA+"&CodCont="+CONTACTO+"&MRCAL="+MRr+"&CodSelTarea="+CodSelTarea+"&Envio=S&U="+f.U.value;
f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Validaci�n de Tarea</title>
<style type="text/css">
<!--
.Estilo7 {font-size: 12px}
-->
</style>
</head>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="ConsultaPel" method="post">
<input type="hidden" name="U" value="<? echo $U;?>" />
<? echo DescripOrganica2($CodSelTarea);?>
<table width="100%" border="0" cellpadding="0" cellspacing="4">
  <tr>
  <?
	$CODAREA=ObtenerCodParent($CodSelTarea);
  	$Consulta="SELECT * from proyecto_modernizacion.funcionarios t1 inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut";
	$Consulta.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema and t2.nivel=t3.nivel";
	$Consulta.= " where t1.rut= '".$Usuario."' ";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$Fila=mysql_fetch_array($Resp);
		$NombreJEFE=$Usuario." - ".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"];
		$Perfil=$Fila["descripcion"];
  	
  ?>
	<td height="36" align="left" class="TituloCabecera">Seleccione La Magnitud de Riesgo </td>
	<td width="39%" height="36" align="left"><font class="formulario">Usuario:&nbsp;<? echo strtoupper($NombreJEFE);?>&nbsp;&nbsp;&nbsp;Perfil:&nbsp;<? echo strtoupper($Perfil);?></font></td>
	<td width="23%" align="right">
	<?
	if($MRCAL=='1')
	{
		$Consulta="SELECT MVALIDADO from sgrs_siperpeligros where CAREA='".$CODAREA."' and MVALIDADO='0'";
		$Resultado=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resultado))
		{
		?>
		<!--<a href="javascript:EnviaCorreo('<? //echo $CODAREA;?>','<? //echo $CodCont?>','<? //echo $MRCAL;?>','<? //echo $CodSelTarea;?>');"><img src="imagenes/btn_mail.gif" width="30" height="30" border="0" alt="Envia Correo no Acuerdo"></a>-->
		<?
		}
	}
	?>
	<a href="javascript:window.print();"><img src="imagenes/btn_imprimir.png" width="30" height="30" border="0" alt="Imprimir"></a></td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
<tr>
	<td width="10%" class="TituloCabecera" align="center" >Peligro</td>
	<td width="9%" class="TituloCabecera" align="center">Descripci�n</td>
	<td align='center' width='2%' class='TituloCabecera' >MRi</td>
	<td align='left' width='45%' class='TituloCabecera' ><table width="100%" border="0" cellpadding="0" cellspacing="0"><td width="60%">Familia de Controles</td><td width="40%" align="left">Especificaci�n de Controles</td></table>	
	<td align='left' width='45%' class='TituloCabecera' ><table width="100%" border="0" cellpadding="0" cellspacing="0"><td width="50%">Familia de Verificadores</td><td width="50%" align="left">Especificaci�n de Verificador</td></table>	
	<td align='center' width='5%' class='TituloCabecera' >MR JEFE</td>
	<td align='center' width='5%' class='TituloCabecera' >MR EXPERTO</td>
	<td align='center' width='5%' class='TituloCabecera' >MRr FINAL</td>
 </tr>

<? 
$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.MVALIDADO,t1.MR1,t1.MR2,t1.QPROBHIST,t1.QCONSECHIST from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$CODAREA."' group by t1.CPELIGRO order by NCONTACTO";
//echo $Consulta;
$Resultado=mysqli_query($link, $Consulta);
while ($Fila=mysql_fetch_array($Resultado))
{
	$PH='';$CH='';$PC='';$CC='';$Validado='';
	if($Fila[MVALIDADO]=='1')
		$Validado='SI';
	CalculoMR($Fila[CCONTACTO],$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
	CalculoMRI($Fila[QPROBHIST],$Fila[QCONSECHIST],&$DESMRI,&$SEMAMRI);							
	echo "<tr>";
	echo "<td align='left'>".$Fila[NCONTACTO]."</td>";
	echo "<td align='center'><textarea rows='3' cols='30' readonly>".$Fila[TOBSERVACION]."</textarea></td>";
	if($Descrip!='NO CALCULADO')
		echo "<td align='center'><img src='imagenes/$SEMAMRI' border=0 width='18' height='30'></td>";
	else
		echo "<td align='left'>&nbsp;</td>";	
	echo "<td align='left'>&nbsp;";
	if($Descrip!="ACEPTABLE"&&$Descrip!="MODERADO"&&$Descrip!="INACEPTABLE")
		echo $Descrip;
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
					$Consulta="SELECT t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
					$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
					$Consulta.=" where t1.CPELIGRO ='".$Fila[CPELIGRO]."'";
					//echo $Consulta."<br>";
					$RespCtrl=mysqli_query($link, $Consulta);
					while($FilaCtrl=mysql_fetch_array($RespCtrl))
					{
						echo "<tr>";
						$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysql_query($ConsuOBS);$Rows=0;
						while($FilaOBS=mysql_fetch_array($RespOBS))
							$Rows=$Rows+1;
						echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaCtrl[CCONTROL]." - ".$FilaCtrl[NCONTROL]."&nbsp;&nbsp;&nbsp;</td>";
						$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysql_query($ConsuOBS);
						if($FilaOBS=mysql_fetch_array($RespOBS))
						{
							$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
							$RespOBS=mysql_query($ConsuOBS);
							while($FilaOBS=mysql_fetch_array($RespOBS))
							{
								echo "<td align='left' width='30%'>&nbsp;<textarea cols='40' readonly>&nbsp;".$FilaOBS[TOBSERVACION]."</textarea></td>";
								echo "</tr>";
							}	
						}
						else
							echo "<td align='left' width='30%'>&nbsp;</td>";
					}
				echo "</table>";
				echo "</td>";
				echo "<td><br>";
				$ConsuVeri="SELECT * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
				$RespVeri=mysql_query($ConsuVeri);
				if($FilaVeri=mysql_fetch_array($RespVeri))
				{
					echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";														
					$ConsuVeri="SELECT * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
					$RespVeri=mysql_query($ConsuVeri);
					while($FilaVeri=mysql_fetch_array($RespVeri))
					{
						echo "<tr>";
						$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
						$RespOBS=mysql_query($ConsuOBS);$Rows=0;
						while($FilaOBS=mysql_fetch_array($RespOBS))
							$Rows=$Rows+1;
						$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
						$RespOBS=mysql_query($ConsuOBS);
						if($FilaOBS=mysql_fetch_array($RespOBS))
						{
							echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaVeri[DESCRIP_VERIFICADOR]."&nbsp;&nbsp;&nbsp;</td>";
							$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysql_query($ConsuOBS);
							while($FilaOBS=mysql_fetch_array($RespOBS))
							{
								echo "<td align='left' width='30%'>&nbsp;<textarea cols='40' readonly>&nbsp;".$FilaOBS[TOBSERVACION]."</textarea></td>";
								echo "</tr>";
							}	
						}
					}
					echo "</table>";

				}
				else
				{
					echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";														
					echo "<tr>";
					echo "<td coslpan='2'>SIN VERIFICADORES</td>";
					echo "</tr>";
					echo "</table>";
				}				
	echo "</td>";
	if($MRCAL==1)//JEFE AREA
	{
		if($Fila[MR1]==1)
			$CheckJ1='checked';
		else
			$CheckJ1='';	
		if($Fila[MR1]==2)
			$CheckJ2='checked';
		else
			$CheckJ2='';	
		if($Fila[MR1]==3)
			$CheckJ3='checked';
		else
			$CheckJ3='';	
		echo "<td align='center'>";
		echo "<table border=0 cellspacing='0' cellpadding='0'>";
		echo "<tr>";
		echo "<td><input type='radio' name='MRE-$Fila[CCONTACTO]-$Fila[CPELIGRO]."' value='1' class='SinBorde' $CheckJ1></td><td><img src='imagenes/verde.gif' alt='Verde'  border='0' align='absmiddle'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><input type='radio' name='MRE-$Fila[CCONTACTO]-$Fila[CPELIGRO]."' value='2' class='SinBorde' $CheckJ2></td><td><img src='imagenes/amarillo.gif' alt='Amarillo'  border='0' align='absmiddle'></td><td><a href=JavaScript:MRr('".$CODAREA."','".$Fila[CCONTACTO]."','".$Fila[CPELIGRO]."','".$MRCAL."','".$CodSelTarea."')><img src='../scop_web/archivos/grabar.png' alt='Grabar'  border='0' align='absmiddle' /></a></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><input type='radio' name='MRE-$Fila[CCONTACTO]-$Fila[CPELIGRO]."' value='3' class='SinBorde' $CheckJ3></td><td><img src='imagenes/rojo.gif' alt='Rojo'  border='0' align='absmiddle'></td>";
		echo "</tr>";	
		echo "</table>";
		echo "</td>";
		//-------------------------------MUESTRA EL COLOR QUE COLOCO EL EXPERTO-----------------------------------------
		if($Fila[MR2]==0)
			$SEMEXPERTO="&nbsp;";
		if($Fila[MR2]==1)
			$SEMEXPERTO="<img src='imagenes/verde.gif' border=0 >";
		if($Fila[MR2]==2)// SI SON IGUALES AMARILLO
			$SEMEXPERTO="<img src='imagenes/amarillo.gif' border=0 >";
		if($Fila[MR2]==3)// SI SON IGUALES ORJO
			$SEMEXPERTO="<img src='imagenes/rojo.gif' border=0 >";				
		echo "<td align='center'>&nbsp;".$SEMEXPERTO."</td>";
		//-----EXPERTO COLOR INGRESADO-----------------
	}
	if($MRCAL==2)//EXPERTO
	{
		if($Fila[MR2]==1)
			$CheckE1='checked';
		else
			$CheckE1='';	
		if($Fila[MR2]==2)
			$CheckE2='checked';
		else
			$CheckE2='';	
		if($Fila[MR2]==3)
			$CheckE3='checked';
		else
			$CheckE3='';
				
		//-------------------------------MUESTRA EL COLOR QUE COLOCO EL JEFE-----------------------------------------
		if($Fila[MR1]==0)
			$SEMJEFE="&nbsp;";
		if($Fila[MR1]==1)
			$SEMJEFE="<img src='imagenes/verde.gif' border=0 >";
		if($Fila[MR1]==2)// SI SON IGUALES AMARILLO
			$SEMJEFE="<img src='imagenes/amarillo.gif' border=0 >";
		if($Fila[MR1]==3)// SI SON IGUALES ORJO
			$SEMJEFE="<img src='imagenes/rojo.gif' border=0 >";				
		echo "<td align='center'>&nbsp;".$SEMJEFE."</td>";
		//-----JEFE COLOR INGRESADO-----------------
		echo "<td align='center'>";
		echo "<table border=0 cellspacing='0' cellpadding='0'>";
		echo "<tr>";
		echo "<td><input type='radio' name='MRE-$Fila[CCONTACTO]-$Fila[CPELIGRO]."' value='1' class='SinBorde' $CheckE1></td><td><img src='imagenes/verde.gif' alt='Verde'  border='0' align='absmiddle'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><input type='radio' name='MRE-$Fila[CCONTACTO]-$Fila[CPELIGRO]."' value='2' class='SinBorde' $CheckE2></td><td><img src='imagenes/amarillo.gif' alt='Amarillo'  border='0' align='absmiddle'></td><td><a href=JavaScript:MRr('".$CODAREA."','".$Fila[CCONTACTO]."','".$Fila[CPELIGRO]."','".$MRCAL."','".$CodSelTarea."')><img src='../scop_web/archivos/grabar.png' alt='Grabar'  border='0' align='absmiddle' /></a></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><input type='radio' name='MRE-$Fila[CCONTACTO]-$Fila[CPELIGRO]."' value='3' class='SinBorde' $CheckE3></td><td><img src='imagenes/rojo.gif' alt='Rojo'  border='0' align='absmiddle'></td>";
		echo "</tr>";	
		echo "</table>";
		echo "</td>";
	}
	if($Fila[MR1]==$Fila[MR2]&&$Fila[MR1]!=0&&$Fila[MR2]!=0)// SI SON IGUALES
	{
		if($Fila[MR1]==1&&$Fila[MR2]==1)// SI SON IGUALES VERDE
		{
			$SEMAMRI="<img src='imagenes/semaforo_verde.jpg' border=0 width='18' height='30'>";
			
			$Consulta1="SELECT * from sgrs_siperpeligros where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
			$Resp1=mysql_query($Consulta1);
			$Fila1=mysql_fetch_array($Resp1);
			$OBSPRINCIPAL=$Fila1[TOBSERVACION];
			$Consulta2="SELECT * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp2=mysql_query($Consulta2);
			$Fila2=mysql_fetch_array($Resp2);
			$NOMAREA=$Fila[NAREA];
			
			$Obs="Se a Validado Peligro ".$OBSPRINCIPAL." en: ".$NOMAREA."";	
			InsertaHistorico($CookieRut,'25',$Obs,'','','');
			
			$Actualizar="UPDATE sgrs_siperpeligros set MVALIDADO='1' where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
			//echo  $Actualizar."<br>";
			mysql_query($Actualizar);
		}			
		if($Fila[MR1]==2&&$Fila[MR2]==2)// SI SON IGUALES AMARILLO
		{
			$SEMAMRI="<img src='imagenes/semaforo_amarillo.jpg' border=0 width='18' height='30'>";

			$Consulta1="SELECT * from sgrs_siperpeligros where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
			$Resp1=mysql_query($Consulta1);
			$Fila1=mysql_fetch_array($Resp1);
			$OBSPRINCIPAL=$Fila1[TOBSERVACION];
			$Consulta2="SELECT * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp2=mysql_query($Consulta2);
			$Fila2=mysql_fetch_array($Resp2);
			$NOMAREA=$Fila[NAREA];
			
			$Obs="Se a Validado Peligro ".$OBSPRINCIPAL." en: ".$NOMAREA."";	
			InsertaHistorico($CookieRut,'25',$Obs,'','','');

			$Actualizar="UPDATE sgrs_siperpeligros set MVALIDADO='1' where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
			//echo  $Actualizar."<br>";
			mysql_query($Actualizar);
		}	
		if($Fila[MR1]==3&&$Fila[MR2]==3)// SI SON IGUALES ORJO
		{
			$SEMAMRI="<img src='imagenes/semaforo_rojo.jpg' border=0 width='18' height='30'>";

			$Consulta1="SELECT * from sgrs_siperpeligros where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
			$Resp1=mysql_query($Consulta1);
			$Fila1=mysql_fetch_array($Resp1);
			$OBSPRINCIPAL=$Fila1[TOBSERVACION];
			$Consulta2="SELECT * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp2=mysql_query($Consulta2);
			$Fila2=mysql_fetch_array($Resp2);
			$NOMAREA=$Fila[NAREA];
			
			$Obs="Se a Validado Peligro ".$OBSPRINCIPAL." en: ".$NOMAREA."";	
			InsertaHistorico($CookieRut,'25',$Obs,'','','');

			$Actualizar="UPDATE sgrs_siperpeligros set MVALIDADO='1' where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
			//echo  $Actualizar."<br>";
			mysql_query($Actualizar);
		}	
	}
	else
	{
		$SEMAMRI='';
		$Actualizar="UPDATE sgrs_siperpeligros set MVALIDADO='0' where CAREA='".$CODAREA."' and CPELIGRO='".$Fila[CPELIGRO]."'";
		//echo  $Actualizar."<br>";
		mysql_query($Actualizar);
	}	
	echo "<td align='center'>&nbsp;".$SEMAMRI."</td>";
/*				echo "<td align='center' width='4%'><img src='imagenes/$Semaforo' border=0 width='18' height='30'></td>";
	echo "<td align='center' width='5%'>".$Validado."&nbsp;</td>";
*/	echo "</tr>";
}
if(!isset($NUE))
{
	$Consulta="SELECT * from sgrs_siperpeligros where CAREA='".$CODAREA."' and (MR1='0' or MR2='0')";
	//echo $Consulta."<br>";
	$Resultado=mysqli_query($link, $Consulta);
	if(!$Fila=mysql_fetch_array($Resultado))
	{
		$Enviar='';
		$Consulta="SELECT * from sgrs_siperpeligros where CAREA='".$CODAREA."' and MR1>'0' and MR2>'0'";
		//echo $Consulta."<br>";
		$Resultado=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resultado))
		{
			if($Fila[MR1]!=$Fila[MR2])
				$Enviar='S';
		}		
		//echo ": ".$Enviar."<br>";
		if($Enviar=='S')
		{
			//echo "envio";
			$Consulta="SELECT RUT,AVISO_CORREO,AVISO_CORREO2,RUT_JEFE,RUT_EXPERTO from sgrs_acceso_organica where RUT='".$CookieRut."'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				
				//if($MRCAL==1)//JEFE
				//{		
					//echo $Fila[AVISO_CORREO]."<br>";	
					if($Fila[AVISO_CORREO2]!='')
						EnvioCorreo2($Fila[AVISO_CORREO2],$CodSelTarea,$Fila[RUT],'2',$Usuario);
						//experto		
				//}
				//else
				//{
					//echo $Fila[AVISO_CORREO2]."<br>";	
					if($Fila[AVISO_CORREO]!='')
						EnvioCorreo2($Fila[AVISO_CORREO],$CodSelTarea,$Fila[RUT],'1',$Usuario);
						//jefe area		
				//}
			}	
		}
		else
		{
			$Actualizar="UPDATE sgrs_siperoperaciones set MVALIDADO='1',FECHA_HORA_VAL='".date('Y-m-d G:i:s')."' where CAREA='".$CODAREA."'";
			//echo  $Actualizar."<br>";
			mysql_query($Actualizar);
		}	
	}
}	
?>
</table>

</form>
</body>
</html>
<?
function EnvioCorreo2($Correo,$CodSelTarea,$Rut,$MRCAL,$RUT_JE_EX)	
{	
	$CODAREA=ObtenerCodParent($CodSelTarea);	
	$Consulta="SELECT * from sgrs_areaorg where CAREA='".$CODAREA."'";
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysql_fetch_array($Resp);
	$NOMAREA=$Fila[NAREA];

	$Asunto='No acuerdo en validaci�n de tarea '.$NOMAREA.'.';
	$Titulo='SASSO - Sistema de Aseguramiento de Seguridad y Salud Ocupacional';	
	$Consulta="SELECT * from proyecto_modernizacion.funcionarios where rut='".$Rut."'";
	$Resul=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resul))
		$Nombre="<strong>".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]."</strong>";
	$Mensaje="<font face='Arial, Helvetica, sans-serif' size='2'>Estimados:<br> Debido a la diferencia de magnitud de los peligros, es necesario llegar a un acuerdo de magnitud.<br></font>";	
         $Mensaje.="Para su validaci�n cont�ctese con Jefe y/o Experto, para reevaluar la aplicaci�n de los controles necesarios para asegurar que la tarea se pueda realizar.<br>";
		 $Mensaje.="<table width='100%' border='1' cellpadding='0' cellspacing='0' align='left'>";
			$Mensaje.="<tr>";
				$Mensaje.="<td width='10%' bgcolor='#CCCCCC' align='center' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Peligro</font></td>";
				$Mensaje.="<td width='10%' bgcolor='#CCCCCC' align='center'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Descripci�n</font></td>";
				$Mensaje.="<td align='center' width='2%' bgcolor='#CCCCCC' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>MRi</font></td>";
				$Mensaje.="<td align='left' width='30%' bgcolor='#CCCCCC' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'><table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Famila de Controles</font></td><td><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Especificaci�n</font></td></tr></font></table></td>";
				$Mensaje.="<td width='35%' bgcolor='#CCCCCC'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'><table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Famila de Verificadores</font></td><td><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Especificaci�n</font></td></tr></font></table></td>";
				$Mensaje.="<td width='4%' bgcolor='#CCCCCC' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>MRr Jefe</font></td>";
				$Mensaje.="<td width='4%' bgcolor='#CCCCCC' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>MRr Experto</font></td>";
				//$Mensaje.="<td width='3%' bgcolor='#CCCCCC' align='center'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Val</font></td>";
			 $Mensaje.="</tr>";

			$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.MVALIDADO,t1.MR1,t1.MR2 from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$CODAREA."' group by t1.CCONTACTO order by NCONTACTO";
			//echo $Consulta;
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resultado))
			{
				$PH='';$CH='';$PC='';$CC='';$Validado='';
				if($Fila[MVALIDADO]=='1')
					$Validado='SI';
				CalculoMR($Fila[CCONTACTO],$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
				CalculoMRI($PH,$CH,&$DESMRI,&$SEMAMRI);							
				$Mensaje.="<tr>";
				$Mensaje.="<td align='left' width='25%'><font face='Arial, Helvetica, sans-serif' size='1'>".$Fila[NCONTACTO]."</font></td>";
				$Mensaje.="<td align='center' width='15%'><font face='Arial, Helvetica, sans-serif' size='1'>&nbsp;".$Fila[TOBSERVACION]."</font></td>";
				if($Descrip!='NO CALCULADO')
					$Mensaje.="<td align='center'>".$DESMRI."</td>";
				else
					$Mensaje.="<td align='left'>&nbsp;</td>";	
				$Mensaje.="<td align='left' width='40%'>";
				if($Descrip!="ACEPTABLE"&&$Descrip!="MODERADO"&&$Descrip!="INACEPTABLE")
					$Descrip=$Descrip;
					
				$Mensaje.="<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
					$Consulta="SELECT t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
					$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
					$Consulta.=" where t1.CPELIGRO ='".$Fila[CPELIGRO]."'";
					//echo $Consulta."<br>";
					$RespCtrl=mysqli_query($link, $Consulta);
					while($FilaCtrl=mysql_fetch_array($RespCtrl))
					{
						$Mensaje.="<tr>";
						$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysql_query($ConsuOBS);$Rows=0;
						while($FilaOBS=mysql_fetch_array($RespOBS))
							$Rows=$Rows+1;
						$Mensaje.="<td rowspan='".$Rows."' align='left' width='70%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaCtrl[CCONTROL]." - ".$FilaCtrl[NCONTROL]."</font>&nbsp;&nbsp;&nbsp;</td>";
						$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysql_query($ConsuOBS);
						if($FilaOBS=mysql_fetch_array($RespOBS))
						{
							$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
							$RespOBS=mysql_query($ConsuOBS);
							while($FilaOBS=mysql_fetch_array($RespOBS))
							{
								$Mensaje.="<td align='left' width='30%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaOBS[TOBSERVACION]."</font>&nbsp;</td>";
								$Mensaje.="</tr>";
							}	
						}
						else
							$Mensaje.="<td align='left' width='30%'>&nbsp;</td>";
					}
					$Mensaje.="</table>";
					$Mensaje.="</td>";
					$Mensaje.="<td>";
					$ConsuVeri="SELECT * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
					$RespVeri=mysql_query($ConsuVeri);
					if($FilaVeri=mysql_fetch_array($RespVeri))
					{
						$Mensaje.="<table width='100%' border='1' cellspacing='0' cellpadding='0'>";														
						$ConsuVeri="SELECT * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
						$RespVeri=mysql_query($ConsuVeri);
						while($FilaVeri=mysql_fetch_array($RespVeri))
						{
							$Mensaje.="<tr>";
							$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysql_query($ConsuOBS);$Rows=0;
							while($FilaOBS=mysql_fetch_array($RespOBS))
								$Rows=$Rows+1;
							$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysql_query($ConsuOBS);
							if($FilaOBS=mysql_fetch_array($RespOBS))
							{
								$Mensaje.="<td rowspan='".$Rows."' align='left' width='70%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaVeri[DESCRIP_VERIFICADOR]."</font>&nbsp;&nbsp;&nbsp;</td>";
								$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
								$RespOBS=mysql_query($ConsuOBS);
								while($FilaOBS=mysql_fetch_array($RespOBS))
								{
									$Mensaje.="<td align='left' width='30%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaOBS[TOBSERVACION]."</font>&nbsp;</td>";
									$Mensaje.="</tr>";
								}	
							}
						}
						$Mensaje.="</table>";
	
					}
					else
					{
						$Mensaje.="<table width='100%' border='0' cellspacing='0' cellpadding='0'>";														
						$Mensaje.="<tr>";
						$Mensaje.="<td coslpan='2' align='left'><font face='Arial, Helvetica, sans-serif' size='1'>SIN VERIFICADORES</font></td>";
						$Mensaje.="</tr>";
						$Mensaje.="</table>";
					}					
					$Mensaje.="</td>";
				//$Mensaje.="</table>";
				if($Fila[MR1]=='1')
					$Jefe="Aceptable";
				if($Fila[MR1]=='2')
					$Jefe="Moderado";
				if($Fila[MR1]=='3')
					$Jefe="Inaceptable";
				if($Fila[MR2]=='1')
					$Experto="Aceptable";
				if($Fila[MR2]=='2')
					$Experto="Moderado";
				if($Fila[MR2]=='3')
					$Experto="Inaceptable";
				$Mensaje.="<td>".$Jefe."</td>";
				$Mensaje.="<td>".$Experto."</td>";
/*				echo "<td align='center' width='3%'>".$PH."</td>";
				echo "<td align='center' width='3%'>".$CH."</td>";
				echo "<td align='center' width='3%'>".$PC."&nbsp;</td>";
				echo "<td align='center' width='3%'>".$CC."&nbsp;</td>";
*/				//$Mensaje.="<td align='center' width='4%'><font face='Arial, Helvetica, sans-serif' size='1'>".$Descrip."</font></td>";
				//$Mensaje.="<td align='center' width='5%'><font face='Arial, Helvetica, sans-serif' size='1'>".$Validado."&nbsp;</font></td>";
				$Mensaje.="</tr>";
			}
          $Mensaje.="</table>";

	$EnDecryptText = new EnDecryptText(); 
	
	/*DATOS ENCRIPTADOS*/
	$User = $EnDecryptText->Encrypt_Text($RUT_JE_EX);

	$ConsulServ="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='29001' and cod_subclase='1'";
	$RespServ=mysql_query($ConsulServ);
	$FilaServ=mysql_fetch_array($RespServ);
	$NomServ=$FilaServ["nombre_subclase"];


	$cuerpoMsj = '<html>';
	$cuerpoMsj.= '<head>';
	$cuerpoMsj.= '<title>'.$Titulo.'&nbsp;'.$MesCorreo.'&nbsp;'.$Ano.'</title>';
	$cuerpoMsj.= '</head>';
	$cuerpoMsj.= '<body>';
	$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
	$cuerpoMsj.= '<tr><td>';
	$cuerpoMsj.= ''.$Mensaje.'';
	$cuerpoMsj.= "<br><br>";
	$cuerpoMsj.= '</td></tr>';
	$cuerpoMsj.= '</table>';
	$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
	$cuerpoMsj.= '<tr><td>';
	$cuerpoMsj.= "<font face='Arial, Helvetica, sans-serif' size='2'>Seguir el link para revisar diferencia en evaluaci�n de la Magnitud de Riesgo Residual. : <a href='http://".$NomServ."/proyecto/siper_web/proceso_magnitud_riesgo.php?CodSelTarea=".$CodSelTarea."&NUE=S&MRCAL=".$MRCAL."&U=".$User."'><font size='2'>MRr.</font></a>";
	$cuerpoMsj.= "<br><br>";
	$cuerpoMsj.="Por Su Atenci�n Muchas Gracias";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.="Servicio Automatico de Sistema de Aseguramiento de Seguridad y Salud Ocupacional Ventanas (SASSO)";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.= '</td></tr>';
	$cuerpoMsj.= '</table>';
	$cuerpoMsj.= '</body></html>';
	//echo $cuerpoMsj."<br>";
	$mail = new phpmailer();
	//$mail->AddEmbeddedImage("includes/logo_seti.jpg","logo","includes/logo_seti.jpg","base64","image/jpg");
	$mail->PluginDir = "includes/";
	//$mail->Mailer = "smtp";
	$mail->Host = "VEFVEX03.codelco.cl";
	//$mail->From = "SASSO";
	$mail->FromName = "SASSO - Sistema de Aseguramiento de Seguridad y Salud Ocupacional";
	$mail->Subject = $Asunto;
	$mail->Body=$cuerpoMsj;
	$mail->IsHTML(true);
	$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
	$mail->AddAddress($Correo);	
	$mail->Timeout=120;
	//$mail->AddAttachment($Doc,$Doc);
	$exito = $mail->Send();
	$intentos=1; 
	while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
	sleep(5);
	$exito = $mail->Send();
	$intentos=$intentos+1;				
	}
	$mail->ClearAddresses();
}
?>