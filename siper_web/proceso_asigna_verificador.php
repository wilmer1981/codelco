<?php
	if($Proceso=='EO')
	{
		$Elimina="delete from sgrs_siperverificadores_obs where CIDVERIFICADOR='".$Corr."' and COD_VERIFICADOR='".$CodVeri."' and CCONTACTO='".$CodCCONTACTO."' and CPELIGRO='".$CodPel."' and CAREA='".$AREA."'";
		//echo  $Elimina."<br>";
		mysqli_query($link,$Elimina);
	}	
	if($Proceso=='AOBC')
	{
		$Consulta="select max(CIDVERIFICADOR+1) as maximo from sgrs_siperverificadores_obs ";
		$Resp=mysqli_query($link,$Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			if($Fila[maximo]=='')
				$TxtVeriObs='1';
			else		
				$TxtVeriObs=$Fila[maximo];
		}
		
		$Inserta="INSERT INTO sgrs_siperverificadores_obs  (CIDVERIFICADOR,COD_VERIFICADOR,CPELIGRO,CAREA,CCONTACTO)";
		$Inserta.=" values('".$TxtVeriObs."','".$CodVeri."','".$CodPel."','".$AREA."','".$CodCCONTACTO."')";		
		//echo $Inserta."<br>";
		mysqli_query($link,$Inserta);
	}
	if($Proceso=='MOD')
	{
		$Actualiza="update sgrs_siperverificadores_obs set TOBSERVACION='".$ObsMod."'  where CIDVERIFICADOR='".$CIDVERI."' and COD_VERIFICADOR='".$CodVeri."' and CPELIGRO='".$CodPel."' and CAREA='".$AREA."' and CCONTACTO='".$CodCCONTACTO."'";		
		//echo $Actualiza."<br>";
		mysqli_query($link,$Actualiza);			
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
function GrabarVerificador()
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
		if (Mantenedor.elements[i].name=="CmbAplica")
		{	
			if(Mantenedor.elements[i+1].value!='NA')
				DatosCtrl = DatosCtrl + Mantenedor.elements[i+1].value+"~@~"+Mantenedor.elements[i].value + "~@~" + Mantenedor.elements[i+2].value +"//";
		}	
		if (Mantenedor.elements[i].name=="Obs"&&Mantenedor.elements[i+1].value!='')
		{	
			DatosObsCtrl = DatosObsCtrl + Mantenedor.elements[i].value + "~" + Mantenedor.elements[i+1].value + "//";
		}
	}
	//alert(DatosObsCtrl)
	DatosCtrl = DatosCtrl.substring(0,(DatosCtrl.length-2));			

	Cod='Proceso=GVP&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&DatosCtrl='+DatosCtrl+'&DatosObsCtrl='+DatosObsCtrl;
	top.frames['Procesos'].location='procesos.php?'+Cod;	
}
function EliminarVeri()
{

	if(top.frames['Procesos'].document.Mantenedor.CmbPeligros.value=='S')
	{
		alert('Debe Seleccionar Peligro');
		top.frames['Procesos'].document.Mantenedor.CmbPeligros.focus();
		return;
	}
	if(confirm('Esta Seguro de Eliminar los Verificadores del Peligro'))
	{
		//ObsElimina.style.visibility = 'visible';
		//Transparente.style.visibility = 'visible';
		Cod='Proceso=EV&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value;
		top.frames['Procesos'].location='procesos.php?'+Cod;	
	}
}
function ObsVeri()
{
	URL='proceso_asigna_controles_obs_verificador.php';
	window.open(URL,"","top=300,left=500,width=630,height=500,status=no,menubar=no,resizable=yes,scrollbars=yes");
}

function AgregaObs(CODVERI,Area,CodSelTarea,CodCCONTACTO,Opc)
{
	var f=document.Mantenedor;
	f.action='procesos_organica.php?Proceso=AOBC&CodVeri='+CODVERI+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=2&CodCCONTACTO='+CodCCONTACTO;
	f.submit();

	//URL='div_obs_verificador.php?Opc=GO&CodVeri='+CODVERI+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&CodCCONTACTO='+CodCCONTACTO;
	//window.open(URL,"","top=300,left=500,width=400,height=300,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}
function EliminaObs(CIDVERIFICADOR,CODVERI,Area,CodSelTarea,CodCCONTACTO,Opc)
{
	var f=document.Mantenedor;
	f.action='procesos_organica.php?Proceso=EO&Corr='+CIDVERIFICADOR+'&CodVeri='+CODVERI+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=2&CodCCONTACTO='+CodCCONTACTO;
	f.submit();
}
function ModObs(CIDVERIFICADOR,CODVERI,Area,CodSelTarea,CodCCONTACTO,Opc,ContObs)
{
	var f=document.Mantenedor;
	f.action='procesos_organica.php?Proceso=MOD&CIDVERI='+CIDVERIFICADOR+'&CodVeri='+CODVERI+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&TipoPestana=2&CodCCONTACTO='+CodCCONTACTO+'&ObsMod='+f.Obs[ContObs].value;
	f.submit();
	//URL='div_obs_verificador.php?Opc=MO&CIDVERI='+CIDVERIFICADOR+'&CodVeri='+CODVERI+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&AREA='+Area+'&CodSelTarea='+CodSelTarea+'&CodCCONTACTO='+CodCCONTACTO;
	//window.open(URL,"","top=300,left=500,width=400,height=300,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}
function AC(CodPeli,Area)
{
	var f=document.Mantenedor;
	URL='proceso_asignacion_controles_popup.php?CmbPeligros='+CodPeli+'&Cod='+Area;
	window.open(URL,"","top=300,left=500,width=630,height=500,status=no,menubar=no,resizable=yes,scrollbars=yes");

}
</script>
<body>
<form name="MantenedorCont" method="post">

<?php
//include('div_obs_verificador.php');
?>   

<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
<td width="5" background="imagenes/tab_separator.gif"></td>
<td width="948" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="4">
<tr>
<td align="left">
<?php
 $Cod=ObtenerCodParent($CodSelTarea);
 $Consulta="select * from sgrs_siperpeligros where CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."'";
 //echo $Consulta;
 $Resp=mysqli_query($link,$Consulta);
 if($Fila=mysqli_fetch_array($Resp))
{
	$QPROBHIST=$Fila[QPROBHIST];
	$QCONSECHIST=$Fila[QCONSECHIST];
	$MRI=$QPROBHIST*$QCONSECHIST;
?>		 
<a href="javascript:GrabarVerificador()"><img src="imagenes/btn_guardar.png" alt='Grabar Verificadores' border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;
<a href="javascript:EliminarVeri()"><img src="imagenes/btn_eliminar2.png" alt='Eliminar Verificadores' border="0" align="absmiddle"></a>
<?php
}
?>
<?php echo DescripOrganica2($CodSelTarea);?></td>
<td align="right">
</td>
</tr>
 <tr>
   <td colspan="2" width="13%" class="formulario" align="left">&nbsp;Contacto / Peligros&nbsp;&nbsp;
   <select name="CmbPeligros" onchange="BuscaControles()" style="width:300">
   <option value="S" selected>Seleccionar</option>
   <?php
		//$Cod=ObtenerCodParent($CodSelTarea);		
		$TextVisible='hidden';
		$Consulta="select t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.CCONTACTO as orden from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$Cod."' group by t1.CPELIGRO order by NCONTACTO asc";
		//echo $Consulta;
		$Resultado=mysqli_query($link,$Consulta);
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			if($CmbPeligros==$Fila[CPELIGRO])
			{
				echo "<option value='".$Fila[CPELIGRO]."' selected>".$Fila[NCONTACTO]."</option>";
				$CodCCONTACTO=$Fila[CCONTACTO];
				$ObsPel=$Fila[TOBSERVACION];
				$TextVisible='visible';
			}	
			else
				echo "<option value='".$Fila[CPELIGRO]."'>".$Fila[NCONTACTO]."</option>";				
		}
  		
   ?>
   </select>&nbsp;&nbsp;<textarea cols="90" rows="2" style="visibility:<?php echo $TextVisible;?>"><?php echo $ObsPel;?></textarea>
   </td>
 </tr>
 <?php
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
			<td width="3%" rowspan="2" align="center" class="TituloCabecera" ><img src="imagenes/<?php echo $SEMAMRI;?>" border=0 width="18" height="30"></td>
			<td width="10%" align="center" class="TituloCabecera" >P</td>
			<td width="14%" align="center" class="TituloCabecera" >C</td>
			<td width="23%" align="center" class="TituloCabecera" >MRR</td>
			<td width="3%" rowspan="2" align="center" class="TituloCabecera" ><img src="imagenes/<?php echo $Semaforo;?>" border=0 width="18" height="30"></td>
		</tr>
		<tr>

			<td class="TituloCabecera" align="center" ><?php echo $QPROBHIST;?></td><!--PROBABILIDAD HISTORICA DE SGRS_SIPERPELIGROS-->
			<td class="TituloCabecera" align="center"><?php echo $QCONSECHIST;?></td><!--CONSECUENCIA HISTORICA DE SGRS_SIPERPELIGROS-->
			<td class="TituloCabecera" align="center"><?php echo $MRI;?></td>
			<td class="TituloCabecera" align="center"><?php echo $PC;?>&nbsp;</td>
			<td class="TituloCabecera" align="center"><?php echo $CC;?>&nbsp;</td>
			<td class="TituloCabecera" align="center"><?php echo $MR." - ".$Descrip;?></td>
			</tr>		
		</table>
		<br>
		 <div id='Peligros'  style='overflow:auto;WIDTH: 95%; height:260px;left: 0px; top: 65px;'>
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" colspan="2" class="TituloCabecera" >Familia de Verificadores&nbsp;&nbsp;<a href=JavaScript:ObsVeri()><img src='imagenes/obs.png' alt="Descripción de los Verificadores" border=0 width='17' height='17'></a>
			&nbsp;&nbsp;&nbsp;
			<?php
			 $Consulta="select * from sgrs_sipercontroles where CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."'";
			 //echo $Consulta."<br>";
			 $Resp=mysqli_query($link,$Consulta);
			 if($Fila=mysqli_fetch_array($Resp))
			 {
			?>
				<a href=JavaScript:AC('<?php echo $CmbPeligros;?>','<?php echo $Cod;?>')><img src='imagenes/btn_consulta.png' alt="Ver Controles Especificados al Peligro" border=0 width='17' height='17'></a></td>
			<?php
			 }
			?>	
			<td width="40%" align="center" class="TituloCabecera" >Especificación del Verificador</td>
		 </tr>		 
		 <?php
		 /*$Consulta="select * from sgrs_siperpeligros where CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' and MVALIDADO='1'";
		 $Resp=mysqli_query($link,$Consulta);
		 if(!$Fila=mysqli_fetch_array($Resp))*/
		 $VALIDADO='S';
		 if($VALIDADO=='S')
		 {
		 ?>
		 <!--<table width="90%" border="0" cellpadding="0" cellspacing="0">	-->	
		 <?php
		 	$ContObs=1;
			$Consulta1="select * from sgrs_tipo_verificador where COD_VERIFICADOR<>'' order by DESCRIP_VERIFICADOR";
			$Resp1=mysqli_query($link,$Consulta1);
			echo "<input type='hidden' name='Obs'>";
			while($Fila1=mysqli_fetch_array($Resp1))
			{
				
			   $Consulta2="select * from sgrs_siperverificadores where COD_VERIFICADOR='".$Fila1[COD_VERIFICADOR]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."'";
			   //echo $Consulta2."<br>";
			   $Resp2=mysqli_query($link,$Consulta2);
			   if($Fila2=mysqli_fetch_array($Resp2))
			   		$Tipo='1';
			   else
			   		$Tipo='';		
					
			   //echo "aplica:dd   ".$Tipo."<br>";	  
			   echo "<tr>";
			   echo "<td align='left'>".$Fila1[DESCRIP_VERIFICADOR]."</td>";
			   echo "<td align='center'  style='border-left:none' >";
			   echo "<select name='CmbAplica'>";	
			   switch($Tipo)
			   {
			   		case "1":
						  echo "<option value='NA'>No Aplica</option>";
						  echo "<option value='1' selected>Si</option>";
					break;
			   		case "":
						  echo "<option value='NA' selected>No Aplica</option>";
						  echo "<option value='1'>Si</option>";
					break;
			   }
			   echo "</select>";
			   echo "</td>";			   
   			   echo "<input type='hidden' name='Control' value=".$Fila1[COD_VERIFICADOR].">";
				?>
				<td align='left'>
				<a href="JavaScript:AgregaObs('<?php echo $Fila1[COD_VERIFICADOR];?>','<?php echo $Cod;?>','<?php echo $CodSelTarea;?>','<?php echo $CodCCONTACTO;?>','AG')"><img src="imagenes/add.png" alt="Agregar Nueva Especificación" border=0 width="10" height="10"></a><br />
				<!--<a href="JavaScript:AgregaObs('<?php //echo $Fila[CCONTROL];?>','<?php //echo $Cod;?>','<?php //echo $CodSelTarea;?>','<?php //echo $CodCCONTACTO;?>','AG')"><img src="imagenes/add.png" alt="Agregar Nueva Especificación" border=0 width="10" height="10"></a><br />-->
				<table width="100%">
				<?php
				$EncontroObs='N';
				$Consulta="select * from sgrs_siperverificadores_obs where COD_VERIFICADOR ='".$Fila1[COD_VERIFICADOR]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by COD_VERIFICADOR asc";
				//echo $Consulta."<br>";
				$ResultadoC=mysqli_query($link,$Consulta);
				while($FilaC=mysqli_fetch_array($ResultadoC))
				{	
					$EncontroObs='S';
					?>
					<tr>
					<td width="90%"><?php echo "<textarea name='Obs' cols='80'>".$FilaC[TOBSERVACION]."</textarea><input type='hidden' name='ObsVeri' value='".$Fila1[COD_VERIFICADOR]."~".$FilaC[CIDVERIFICADOR]."'>";?></td>
					<td width="10%" align="left"><a href="JavaScript:EliminaObs('<?php echo $FilaC[CIDVERIFICADOR];?>','<?php echo $Fila1[COD_VERIFICADOR];?>','<?php echo $Cod;?>','<?php echo $CodSelTarea;?>','<?php echo $CodCCONTACTO;?>','EO')"><img src="imagenes/btn_eliminar2.png" alt='Elimina especificación' border=0 width="18" height="18"></a></td>
					</tr>
					<?php
					$ContObs=$ContObs+1;
				}
				if($EncontroObs=='N')
				{
					?>
					<tr>
					<td width="90%"><?php echo "<textarea name='Obs' cols='80'></textarea><input type='hidden' name='ObsVeri' value='".$Fila1[COD_VERIFICADOR]."~'>";?></td>
					<td width="10%">&nbsp;</td>
					</tr>
					<?php
					$ContObs=$ContObs+1;
				}	
				?>
				</table>
				<?php
			   
/*			   $Consulta="select * from sgrs_siperverificadores_obs where COD_VERIFICADOR ='".$Fila1[COD_VERIFICADOR]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by COD_VERIFICADOR asc";
			   //echo $Consulta."<br>";
			   $ResultadoC=mysqli_query($link,$Consulta);
			   if($FilaC=mysqli_fetch_array($ResultadoC))
			   {
					if($FilaC[TOBSERVACION]!='')
					{
						?>
						<td align='left'><a href="JavaScript:AgregaObs('<?php echo $Fila1[COD_VERIFICADOR];?>','<?php echo $Cod;?>','<?php echo $CodSelTarea;?>','<?php echo $CodCCONTACTO;?>','AG')"><img src="imagenes/add.png" alt="Agregar Nueva Especificación" border=0 width="10" height="10"></a>			   
						<?php
					}
			   }
			   else
			   {
			   		echo "<td>&nbsp;<textarea name='Obs1' cols='80'></textarea>"; 
			   }
				 
			   	 $ConsultaE="select * from sgrs_siperverificadores_obs where COD_VERIFICADOR='".$Fila1[COD_VERIFICADOR]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by COD_VERIFICADOR asc";
				 $RespE=mysqli_query($link,$ConsultaE);
				 if($FilaE=mysqli_fetch_array($RespE))
				 {
					if($FilaE[TOBSERVACION]!='')
					{
				   ?>
				   <table width="100%">
				   <?php
					 $ConsultaE2="select * from sgrs_siperverificadores_obs where COD_VERIFICADOR='".$Fila1[COD_VERIFICADOR]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by CIDVERIFICADOR desc";
					 //echo  $ConsultaE2."<br>";
					 $RespE2=mysqli_query($link,$ConsultaE2);
					 while($FilaE2=mysqli_fetch_array($RespE2))
					 {
				   ?>
					   <tr>
					   	<td width="90%"><?php echo "<textarea name='Obs' cols='80'>".$FilaE2[TOBSERVACION]."</textarea>";?></td>
					   	<td width="10%"><a href="javascript:ModObs('<?php echo $FilaE2[CIDVERIFICADOR];?>','<?php echo $Fila1[COD_VERIFICADOR];?>','<?php echo $Cod;?>','<?php echo $CodSelTarea;?>','<?php echo $CodCCONTACTO;?>','MO','<?php echo $ContObs;?>')"><img src='imagenes/btn_modificar.png' alt='Modificar Especificación' border='0' width='25' align='absmiddle'></a>&nbsp;<a href="JavaScript:EliminaObs('<?php echo $FilaE2[CIDVERIFICADOR];?>','<?php echo $Fila1[COD_VERIFICADOR];?>','<?php echo $Cod;?>','<?php echo $CodSelTarea;?>','<?php echo $CodCCONTACTO;?>','EO')"><img src="imagenes/btn_eliminar2.png" alt='Elimina Especificación' border=0 width="18" height="18"></a></td>
					   </tr>
				   <?php
				   		$ContObs=$ContObs+1;
				   	 }	
				   ?>	   
				   </table>
			   <?php
			   	    }
			     }
			   ?> 
			   </td><?php	*/		   
			   echo "</tr>";
			}
		 ?>
		 </table></div>
		 <?php
		 }
		 else
		 {
		 ?>
		 <br>
		 <table width="83%" border="1" height="260px" cellpadding="0" cellspacing="0">
		 <tr>
			<td colspan="3" class="TituloCabecera" ><h1>Operación no permitida, Peligro se encuentra validado.  Póngase en contacto con el Validador.</h1></td>
		 </tr>
		 </table>
		 
		 <?php
		 }
		 ?>   
   </td>
 </tr>
 <?php
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
  <?php
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
