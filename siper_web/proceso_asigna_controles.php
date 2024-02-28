<?
	if($Proceso=='EO')
	{
		$Elimina="delete from sgrs_sipercontroles_obs where CIDCONTROL='".$Corr."' and CCONTROL='".$CODCONTROL."' and CCONTACTO='".$CodCCONTACTO."' and CPELIGRO='".$CodPel."' and CAREA='".$AREA."'";
		//echo  $Elimina."<br>";
		mysql_query($Elimina);
	}	
	if($Proceso=='AOBC')
	{
		$Consulta="SELECT max(CIDCONTROL+1) as maximo from sgrs_sipercontroles_obs ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["maximo"]=='')
				$TxtVeriObs='1';
			else		
				$TxtVeriObs=$Fila["maximo"];
		}
		
		$Inserta="INSERT INTO sgrs_sipercontroles_obs  (CIDCONTROL,CCONTROL,CPELIGRO,CAREA,CCONTACTO)";
		$Inserta.=" values('".$TxtVeriObs."','".$CODCONTROL."','".$CodPel."','".$AREA."','".$CodCCONTACTO."')";		
		//echo $Inserta."<br>";
		mysql_query($Inserta);
	}
	if($Proceso=='AOBN')
	{
		$Consulta="SELECT max(CIDCONTROL+1) as maximo from sgrs_sipercontroles_obs ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["maximo"]=='')
				$TxtVeriObs='1';
			else		
				$TxtVeriObs=$Fila["maximo"];
		}
		
		$Inserta="INSERT INTO sgrs_sipercontroles_obs  (CIDCONTROL,CCONTROL,CPELIGRO,CAREA,CCONTACTO,TOBSERVACION)";
		$Inserta.=" values('".$TxtVeriObs."','".$CODCONTROL."','".$CodPel."','".$AREA."','".$CodCCONTACTO."','".$ObsMod."')";		
		//echo $Inserta."<br>";
		mysql_query($Inserta);
	}

	if($Proceso=='MOD')
	{
		$Actualiza="UPDATE sgrs_sipercontroles_obs set TOBSERVACION='".$ObsMod."'  where CIDCONTROL='".$CIDCONTROL."' and CCONTROL='".$CODCONTROL."' and CPELIGRO='".$CodPel."' and CAREA='".$AREA."' and CCONTACTO='".$CodCCONTACTO."'";		
		//echo $Actualiza."<br>";
		mysql_query($Actualiza);	
	}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<script language="javascript">
function BuscaControles()
{
	var Pestana=top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
	
	top.frames['Procesos'].location='procesos_organica.php?TipoPestana='+Pestana+'&CmbPeligros='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;

}
function GrabarControles()
{
	var f=document.Mantenedor;		
	if(top.frames['Procesos'].document.Mantenedor.CmbPeligros.value=='S')
	{
		alert('Debe Seleccionar Peligro');
		top.frames['Procesos'].document.Mantenedor.CmbPeligros.focus();
		return;
	}
	var DatosCtrl='';
	var DatosObsCtrl='';
	
	for (i=1;i<Mantenedor.elements.length;i++)
	{
		//alert(Mantenedor.elements[i].name);
		if (Mantenedor.elements[i].name=="CodControl")
		{	
			//alert(Mantenedor.elements[i].value);
			if(Mantenedor.elements[i+1].value!='NA')
			{
				DatosCtrl = DatosCtrl + Mantenedor.elements[i].value + "~@~" + Mantenedor.elements[i+1].value + "~@~" + Mantenedor.elements[i+2].value + "//";
				//alert(DatosCtrl);	
			}
		}
		if (Mantenedor.elements[i].name=="Obs"&&Mantenedor.elements[i+1].value!='')
		{	
			DatosObsCtrl = DatosObsCtrl + Mantenedor.elements[i].value + "~" + Mantenedor.elements[i+1].value + "//";
		}
	}
	
	DatosCtrl = DatosCtrl.substring(0,(DatosCtrl.length-2));			
	//alert(DatosCtrl);

	Cod='Proceso=GC&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&DatosCtrl='+DatosCtrl+'&DatosObsCtrl='+DatosObsCtrl;
	top.frames['Procesos'].location='procesos.php?'+Cod;	
}
function EliminarControles()
{

	if(top.frames['Procesos'].document.Mantenedor.CmbPeligros.value=='S')
	{
		alert('Debe Seleccionar Peligro');
		top.frames['Procesos'].document.Mantenedor.CmbPeligros.focus();
		return;
	}
	if(confirm('Esta Seguro de Eliminar los Controles del Peligro'))
	{
		//ObsElimina.style.visibility = 'visible';
		//Transparente.style.visibility = 'visible';
		Cod='Proceso=EC&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value;
		top.frames['Procesos'].location='procesos.php?'+Cod;	
	}
}
function ObsControl()
{
	URL='proceso_asigna_controles_obs_control.php';
	window.open(URL,"","top=300,left=500,width=630,height=500,status=no,menubar=no,resizable=yes,scrollbars=yes");
}
function ComboVeri()
{
	var Pestana=top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
	top.frames['Procesos'].location='procesos_organica.php?TipoPestana='+Pestana+'&CmbPeligros='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
}


function AgregaObs(CODCONTROL,Area,CodSelTarea,CodCCONTACTO,Opc)
{
	var f=document.Mantenedor;
	f.action='procesos_organica.php?Proceso=AOBC&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=3&CodCCONTACTO='+CodCCONTACTO;
	f.submit();
	
	//URL='div_obs_controles.php?Opc=GO&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&CodCCONTACTO='+CodCCONTACTO;
	//window.open(URL,"","top=300,left=500,width=400,height=300,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}
function AgregaObs2(CODCONTROL,Area,CodSelTarea,CodCCONTACTO,Opc,ContObs)
{
	var f=document.Mantenedor;
	//alert(f.Obs[ContObs].value);
	f.action='procesos_organica.php?Proceso=AOBN&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=3&CodCCONTACTO='+CodCCONTACTO+'&ObsMod='+f.Obs[ContObs].value;
	f.submit();
	
	//URL='div_obs_controles.php?Opc=GO&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&CodCCONTACTO='+CodCCONTACTO;
	//window.open(URL,"","top=300,left=500,width=400,height=300,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}

function EliminaObs(CIDVERIFICADOR,CODCONTROL,Area,CodSelTarea,CodCCONTACTO,Opc)
{
	var f=document.Mantenedor;
	f.action='procesos_organica.php?Proceso=EO&Corr='+CIDVERIFICADOR+'&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=3&CodCCONTACTO='+CodCCONTACTO;
	f.submit();
}
function ModObs(CIDCONTROL,CODCONTROL,Area,CodSelTarea,CodCCONTACTO,Opc,ContObs)
{			
	var f=document.Mantenedor;	
	//alert(f.Obs[ContObs].value);
	//alert(ContObs)
	f.action='procesos_organica.php?Proceso=MOD&CIDCONTROL='+CIDCONTROL+'&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=3&CodCCONTACTO='+CodCCONTACTO+'&ObsMod='+f.Obs[ContObs].value;
	f.submit();
	//URL='div_obs_controles.php?Opc=MO&CIDCONTROL='+CIDCONTROL+'&CODCONTROL='+CODCONTROL+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&CodCCONTACTO='+CodCCONTACTO;
	//window.open(URL,"","top=300,left=500,width=400,height=300,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}

/*function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	//Transparente.style.visibility = 'hidden';
}

function ConfirmaEliminar()
{
	if(top.frames['Procesos'].document.Mantenedor.ObsEli.value=='')
	{
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		//document.Mantenedor.ObsEli.value.focus();
		return;
	}
	Cod='Proceso=EC&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&ObsEli='+top.frames['Procesos'].document.Mantenedor.ObsEli.value;
	top.frames['Procesos'].location='procesos.php?'+Cod;	
}*/
</script>
<body>
<form name="MantenedorCont" method="post">
<?
//include('div_obs_elimina3.php');
?>   

<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
<td width="5" background="imagenes/tab_separator.gif"></td>
<td width="948" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="4">
<tr>
<td align="left"><?
$Cod=ObtenerCodParent($CodSelTarea);
 $Consulta="SELECT * from sgrs_siperpeligros where CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."'";
 //echo $Consulta;
 $Resp=mysql_query($Consulta);
 if($Fila=mysql_fetch_array($Resp))
{
	$QPROBHIST=$Fila[QPROBHIST];
	$QCONSECHIST=$Fila[QCONSECHIST];
	$MRI=$QPROBHIST*$QCONSECHIST;
?>		 
<a href="javascript:GrabarControles()"><img src="imagenes/btn_guardar.png" alt='Grabar Controles' border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:EliminarControles()"><img src="imagenes/btn_eliminar2.png" alt='Eliminar Controles' border="0" align="absmiddle"></a>
&nbsp;
<?
}
echo DescripOrganica2($CodSelTarea);?></td>
<td align="right">
<?
 
?>
</td>
</tr>
 <tr>
   <td colspan="2" width="13%" class="formulario" align="left">&nbsp;Contacto / Peligros&nbsp;&nbsp;
   <SELECT name="CmbPeligros" onchange="BuscaControles()" style="width:300">
   <option value="S" SELECTed>Seleccionar</option>
   <?
		//$Cod=ObtenerCodParent($CodSelTarea);		
		$TextVisible='hidden';
		$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.CCONTACTO as orden from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$Cod."' group by t1.CPELIGRO order by NCONTACTO asc";
		//echo $Consulta;
		$Resultado=mysql_query($Consulta);
		while ($Fila=mysql_fetch_array($Resultado))
		{
			if($CmbPeligros==$Fila[CPELIGRO])
			{
				echo "<option value='".$Fila[CPELIGRO]."' SELECTed>".$Fila[NCONTACTO]."</option>";
				$CodCCONTACTO=$Fila[CCONTACTO];
				$ObsPel=$Fila[TOBSERVACION];
				$TextVisible='visible';
			}	
			else
				echo "<option value='".$Fila[CPELIGRO]."'>".$Fila[NCONTACTO]."</option>";				
		}
  		
   ?>
   </SELECT>&nbsp;&nbsp;<textarea cols="90" rows="2" style="visibility:<? echo $TextVisible;?>"><? echo $ObsPel;?></textarea>
   </td>
 </tr>
 <?
 if($CmbPeligros!='S'&&$CmbPeligros!='')
 {
	CalculoMR($QPROBHIST,$QCONSECHIST,&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
	CalculoMRI($QPROBHIST,$QCONSECHIST,&$DESMRI,&$SEMAMRI);	
 ?>
 <tr>
   <td align="center" colspan="2">
		<table width="83%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="10%" align="center" class="TituloCabecera" >P</td>
			<td width="10%" align="center" class="TituloCabecera" >C</td>
			<td width="10%" align="center" class="TituloCabecera" >MRi</td>
			<td width="3%" rowspan="2" align="center" class="TituloCabecera" ><img src="imagenes/<? echo $SEMAMRI;?>" border=0 width="18" height="30"></td>
			<td width="10%" align="center" class="TituloCabecera" >P</td>
			<td width="14%" align="center" class="TituloCabecera" >C</td>
			<td width="23%" align="center" class="TituloCabecera" >MRR</td>
			<td width="3%" rowspan="2" align="center" class="TituloCabecera" ><img src="imagenes/<? echo $Semaforo;?>" border=0 width="18" height="30"></td>
		</tr>
		<tr>

			<td class="TituloCabecera" align="center" ><? echo $QPROBHIST;?></td><!--PROBABILIDAD HISTORICA DE SGRS_SIPERPELIGROS-->
			<td class="TituloCabecera" align="center"><? echo $QCONSECHIST;?></td><!--CONSECUENCIA HISTORICA DE SGRS_SIPERPELIGROS-->
			<td class="TituloCabecera" align="center"><? echo $MRI;?></td>
			<td class="TituloCabecera" align="center"><? echo $PC;?>&nbsp;</td>
			<td class="TituloCabecera" align="center"><? echo $CC;?>&nbsp;</td>
			<td class="TituloCabecera" align="center"><? echo $MR." - ".$Descrip;?></td>
			</tr>		
		</table>
		<br>
		 <div id='Peligros'  style='overflow:auto;WIDTH: 90%; height:260px;left: 0px; top: 65px;'>
		<table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" colspan="2" class="TituloCabecera" >Familia de Controles&nbsp;&nbsp;<a href=JavaScript:ObsControl()><img src='imagenes/obs.png' alt="Descripci�n de los Controles" border=0 width='17' height='17'></a></td>
			<td width="50%" align="center" class="TituloCabecera" >Especificaci�n Control</td>
		 </tr>		 
		 <?
		 $Consulta="SELECT * from sgrs_siperpeligros where CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' and MVALIDADO='1'";
		 //echo $Consulta."<br>";
		 $Resp=mysql_query($Consulta);
		 if(!$Fila=mysql_fetch_array($Resp))
		 {
		 ?>
		 <!--<table width="90%" border="0" cellpadding="0" cellspacing="0">	-->	
		 <?
		 	$ContObs=1;
	  		$Consulta="SELECT ceiling(t1.CCONTROL) as CCONTROL,t1.NCONTROL,t1.QPESOESP,t2.MCONTROL from sgrs_codcontroles t1";
			$Consulta.=" left join sgrs_sipercontroles t2 on t1.CCONTROL=t2.CCONTROL and t2.CPELIGRO='".$CmbPeligros."' ";			
			$Consulta.="where t1.MVIGENTE='1' and t1.CCONTROL<>'--' order by NCONTROL asc";//and t2.CCONTACTO='".$CodC."' 
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);//echo "<input type='hidden' name='CodControl'><input type='hidden' name='CmbControl'><input type='hidden' name='ObsControl'>";
			echo "<input type='hidden' name='Obs'><input type='hidden' name='ObsControl'>";
			while ($Fila=mysql_fetch_array($Resultado))
			{				
				echo "<tr>";
				echo "<td align='left'>".$Fila[NCONTROL]."</td>";
				echo "<td align='center'  style='border-left:none' ><input type='hidden' name='CodControl' value='".$Fila[CCONTROL]."'>";
				echo "<SELECT name='CmbControl'>";
				echo "<option value='NA' SELECTed>No Aplica</option>";
				$Consulta="SELECT * from sgrs_tipo_controles where VIGENTE ='1' order by ORDEN";
				$ResultadoC=mysql_query($Consulta);
				while($FilaC=mysql_fetch_array($ResultadoC))
				{
					if($Fila[MCONTROL]==$FilaC[CTCONTROLES])
						echo "<option value='".$FilaC[CTCONTROLES]."' SELECTed>".$FilaC[NTCONTROLES]."</option>";
					else
						echo "<option value='".$FilaC[CTCONTROLES]."'>".$FilaC[NTCONTROLES]."</option>";
				}
				echo "</SELECT>";
				echo "</td>";
				?>
				<td align='left'><a href="JavaScript:AgregaObs('<? echo $Fila[CCONTROL];?>','<? echo $Cod;?>','<? echo $CodSelTarea;?>','<? echo $CodCCONTACTO;?>','AG')"><img src="imagenes/add.png" alt="Agregar Nueva Especificaci�n" border=0 width="10" height="10"></a><br />
				<table width="100%">
				<?
				$EncontroObs='N';
				$Consulta="SELECT * from sgrs_sipercontroles_obs where CCONTROL ='".$Fila[CCONTROL]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by CIDCONTROL asc";
				//echo $Consulta."<br>";
				$ResultadoC=mysql_query($Consulta);
				while($FilaC=mysql_fetch_array($ResultadoC))
				{	
					$EncontroObs='S';
					?>
					<tr>
					<td width="90%"><? echo "<textarea name='Obs' cols='80'>".$FilaC[TOBSERVACION]."</textarea><input type='hidden' name='ObsControl' value='".$Fila[CCONTROL]."~".$FilaC[CIDCONTROL]."'>";?></td>
					<td width="10%" align="left"><a href="JavaScript:EliminaObs('<? echo $FilaC[CIDCONTROL];?>','<? echo $Fila[CCONTROL];?>','<? echo $Cod;?>','<? echo $CodSelTarea;?>','<? echo $CodCCONTACTO;?>','EO')"><img src="imagenes/btn_eliminar2.png" alt='Elimina especificaci�n' border=0 width="18" height="18"></a></td>
					</tr>
					<?
					$ContObs=$ContObs+1;
				}
				if($EncontroObs=='N')
				{
					?>
					<tr>
					<td width="90%"><? echo "<textarea name='Obs' cols='80'></textarea><input type='hidden' name='ObsControl' value='".$Fila[CCONTROL]."~'>";?></td>
					<td width="10%">&nbsp;</td>
					</tr>
					<?
					$ContObs=$ContObs+1;
				}	
				?>
				</table>
				<?

				/*$Consulta="SELECT * from sgrs_sipercontroles_obs where CCONTROL ='".$Fila[CCONTROL]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by CIDCONTROL asc";
				echo $Consulta."<br>";
				$ResultadoC=mysql_query($Consulta);
				if($FilaC=mysql_fetch_array($ResultadoC))
				{	
					if($FilaC[TOBSERVACION]!='')
					{
						?><td align='left'><a href="JavaScript:AgregaObs('<? echo $Fila[CCONTROL];?>','<? echo $Cod;?>','<? echo $CodSelTarea;?>','<? echo $CodCCONTACTO;?>','AG')"><img src="imagenes/add.png" alt="Agregar Nueva Especificaci�n" border=0 width="10" height="10"></a><br /><?
					}
					else
						echo "<td>&nbsp;<textarea name='Obs' cols='80'></textarea>"; 
				}
				else
				{
					echo "<td>&nbsp;<textarea name='Obs1' cols='80'></textarea>";   
				}	
					
				 $ConsultaE="SELECT * from sgrs_sipercontroles_obs where CCONTROL='".$Fila[CCONTROL]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by CIDCONTROL asc";
				 //echo $ConsultaE."<br>";
				 $RespE=mysql_query($ConsultaE);
				 if($FilaE=mysql_fetch_array($RespE))
				 {
					if($FilaE[TOBSERVACION]!='')
					{
			   		?>
					   <table width="100%">
					   <?
						 $ConsultaE2="SELECT * from sgrs_sipercontroles_obs where CCONTROL='".$FilaE[CCONTROL]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by CIDCONTROL desc";
						// echo $ConsultaE2."<br>";
						 $RespE2=mysql_query($ConsultaE2);
						 while($FilaE2=mysql_fetch_array($RespE2))
						 {
							//echo $ContObs;
							?>
						   <tr>
							<td width="90%"><? echo "<textarea name='Obs' cols='80'>".$FilaE2[TOBSERVACION]."</textarea>";?></td>
							<td width="5%"><a href="javascript:ModObs('<? echo $FilaE2[CIDCONTROL];?>','<? echo $Fila[CCONTROL];?>','<? echo $Cod;?>','<? echo $CodSelTarea;?>','<? echo $CodCCONTACTO;?>','MO','<? echo $ContObs;?>')"><img src='imagenes/btn_modificar.png' alt='Modificar especificaci�n' border='0' width='25' align='absmiddle'></a>&nbsp;<a href="JavaScript:EliminaObs('<? echo $FilaE2[CIDCONTROL];?>','<? echo $Fila[CCONTROL];?>','<? echo $Cod;?>','<? echo $CodSelTarea;?>','<? echo $CodCCONTACTO;?>','EO')"><img src="imagenes/btn_eliminar2.png" alt='Elimina especificaci�n' border=0 width="18" height="18"></a></td>
						   </tr>
							<?
							$ContObs=$ContObs+1;
						 }	
					   ?>	   
					   </table>
						<?
					 }
				  }
				  ?> 
				  </td><?*/			   
				//}
				echo "</tr>";
			}
		 ?>
		 </table></div>
		 <?
		 }
		 else
		 {
		 ?>
		 <br>
		 <table width="83%" border="1" height="260px" cellpadding="0" cellspacing="0">
		 <tr>
			<td colspan="3" class="TituloCabecera" ><h1>Operaci�n no permitida, Peligro se encuentra validado.  P�ngase en contacto con el Validador.</h1></td>
		 </tr>
		 </table>
		 
		 <?
		 }
		 ?>   
   </td>
 </tr>
 <?
 }
 else
 {
 ?>
 <tr>
   <td align="center" colspan="2">
		<table width="83%" height="340px" border="0" cellpadding="0" cellspacing="0">
		<tr><td>&nbsp;</td></tr>
		</table>
	</td>		
 </tr>		
  <?
  }
  ?>
<tr>
<td></td>
<td></td>
</tr></table>
</td>
<td width="9" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
</td>

</form>
</body>
</html>
