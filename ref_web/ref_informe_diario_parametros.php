<?php
//include('../principal/conectar_principal.php');
include('../principal/conectar_ref_web.php');
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
echo "Conecion ".CONEXION_HOST_BD."<br>";
if(!isset($FDesde))
	$FDesde=date('Y-m-d');
//echo $Graba."<br>";
if($Graba=='S')
{
	$Dato=explode('//',$Datos);
	while(list($c,$v)=each($Dato))
	{
		//echo $v."<br>";
		$Clave=explode('~',$v);
		if($Clave[0]=='1')
		{
			$Valor=$Datos[1];
			$Actualiza="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$Clave[1]."' where cod_clase='10005' and cod_subclase='".$Clave[0]."'";
			//echo $Actualiza."<br>";
			mysqli_query($link, $Actualiza);
		}	
		if($Clave[0]=='2')
		{
			$Valor=$Datos[1];
			$Actualiza="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$Clave[1]."' where cod_clase='10005' and cod_subclase='".$Clave[0]."'";
			//echo $Actualiza."<br>";
			mysqli_query($link, $Actualiza);
		}	
		if($Clave[0]=='3')
		{
			$Valor=$Datos[1];
			$Actualiza="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$Clave[1]."' where cod_clase='10005' and cod_subclase='".$Clave[0]."'";
			//echo $Actualiza."<br>";
			mysqli_query($link, $Actualiza);
		}	
			
	}
	$Mod='Par�metros modificados exitosamente';
}
if($GrabaProg=='S')
{
	
	$Com0=str_replace(',','.',$Com0);
	$Des0=str_replace(',','.',$Des0);
	$Lam0=str_replace(',','.',$Lam0);
	$Com1=str_replace(',','.',$Com1);
	$Des1=str_replace(',','.',$Des1);
	$Lam1=str_replace(',','.',$Lam1);
	
	$Actualizar="UPDATE sec_web.det_programa_produccion set d_catodo_comercial='".$Com0."',a_catodo_comercial='".$Des0."',desp_lamina='".$Lam0."' ";
	$Actualizar.="where fecha_programa='".$FDesde."' and cod_revision='0'";
	//echo $Actualizar."<br>";
	mysqli_query($link, $Actualizar);
	$Actualizar="UPDATE sec_web.det_programa_produccion set d_catodo_comercial='".$Com1."',a_catodo_comercial='".$Des1."',desp_lamina='".$Lam1."' ";
	$Actualizar.="where fecha_programa='".$FDesde."' and cod_revision='1'";
	//echo $Actualizar."<br>";
	mysqli_query($link, $Actualizar);
	
}
if($Graba=="GCu")
{
	 $ValorCuElec=str_replace(',','.',$ValorCuElec);
	 $Consulta="select nombre_subclase,cod_subclase,valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase = '10007' and valor_subclase1 ='".$CmbAno."' and valor_subclase2='".$CmbMes."'";
	 //echo $Consulta;
	 $Resp=mysqli_query($link, $Consulta);
	 if(!$Fila=mysqli_fetch_array($Resp))
	 {
		$Consulta="select ifnull(max(cod_subclase)+1,1) codigo_subclase from proyecto_modernizacion.sub_clase where cod_clase = '10007'";
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);
		$Fila2=mysqli_fetch_array($Resp2);
		$Insertar="INSERT INTO proyecto_modernizacion.sub_clase (cod_clase,cod_subclase,nombre_subclase,valor_subclase1,valor_subclase2,valor_subclase3) VALUES ('10007', '".$Fila2[codigo_subclase]."', 'Cu Elec', '".$CmbAno."', '".$CmbMes."', '".$ValorCuElec."')";
		//echo $Insertar."<br>";
		mysqli_query($link, $Insertar);
	 }
	 else
	 {
		 $Actualizar="UPDATE proyecto_modernizacion.sub_clase set valor_subclase3='".$ValorCuElec."' where cod_clase = '10007' and valor_subclase1 ='".$CmbAno."' and valor_subclase2='".$CmbMes."'";
		 mysqli_query($link, $Actualizar);
		//echo $Actualizar."<br>";
	 }
}
?>
<head>
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function Graba(Opc)
{
	var f = document.FrmPopupProceso;
	switch(Opc)
	{
		case "G":
			Valores='';
			Corr=0;
			for (i=0;i<f.elements.length;i++)
			{		
				Corr=Corr+1;	
				var Nom= f.elements[i].name								
				if (f.elements[i].name=="Valor")
				{	
					Valores = Valores+Corr+"~"+f.elements[i].value+"//";
				}	
			}
			Valores=Valores.substr(0,Valores.length-2);
			//alert(Valores)
			f.action='ref_informe_diario_parametros.php?Datos='+Valores+'&Graba=S';
			f.submit();
		break;
		case "GCu":
			f.action='ref_informe_diario_parametros.php?ValorCuElec='+f.TxtGElec.value+'&Graba=GCu&CmbAno='+f.CmbAno.value+'&CmbMes='+f.CmbMes.value;
			f.submit();
		break;
	}
}
function Proceso(Opc)
{
	var f = document.FrmPopupProceso;
	switch(Opc)
	{
	
		case "B":
		//alert(Valores)
		f.action='ref_informe_diario_parametros.php';
		f.submit();
		break;
		case "G":
		//alert(Valores)
		f.action='ref_informe_diario_parametros.php?GrabaProg=S';
		f.submit();
		break;		
	}
}
function MuestraMsj(Msj)
{
	alert(Msj)
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Par&aacute;metros</title>
</head>

<?php
if($Mod!='')
{
?>
<body onLoad="MuestraMsj('<?php echo $Mod;?>')">
<?php
}
else
{
?>
<body>	
<?php
}
?>
<link href="estilos/ref_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15" /></td>
    <td width="98%" height="15" background="archivos/interior2/form_arriba.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15" /></td>
    <td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td colspan="9" align="right" class="TituloCabecera"><a href="JavaScript:Graba('G')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;</td>
      </tr>
      <tr>
        <td width="56%" align="center" class="TituloCabecera">Par&aacute;metros</td>
        <td width="44%" align="center" class="TituloCabecera">Valor</td>
        </tr>
      <?php
  		 $Consulta="select nombre_subclase,cod_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase = '10005'";
echo $Consulta."<br>";		 
$Resp=mysqli_query($link, $Consulta);
		 while($Fila=mysqli_fetch_array($Resp))
		 {
echo "aaaaa";		 	
switch ($Fila["cod_subclase"])
			{
				case "1":
					$Param1=$Fila["valor_subclase1"];
					break;
				case "2":
					$Param2=$Fila["valor_subclase1"];
					break;
				case "3":
					$Param3=$Fila["valor_subclase1"];
					break;
			}
			?>
			 <tr>
			 <td><?php echo $Fila["nombre_subclase"];?></td>
			 <td><input type="text" name="Valor" value="<?php echo $Fila["valor_subclase1"];?>"/></td>
			 </tr>
			<?php
		 }
	  ?>
    </table></td>
    <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15" /></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15" /></td>
  </tr>
</table><br/>
<?php
  		 $Consulta="select * from sec_web.det_programa_produccion where fecha_programa = '".$FDesde."' and cod_revision=0";
		 $Resp=mysqli_query($link, $Consulta);
		 if($Fila=mysqli_fetch_array($Resp))
		 {
		 	$Com0=$Fila[d_catodo_comercial];
			$Des0=$Fila[a_catodo_comercial];
			$Lam0=$Fila[desp_lamina];
		 }
  		 $Consulta="select * from sec_web.det_programa_produccion where fecha_programa = '".$FDesde."' and cod_revision=1";
		 $Resp=mysqli_query($link, $Consulta);
		 if($Fila=mysqli_fetch_array($Resp))
		 {
		 	$Com1=$Fila[d_catodo_comercial];
			$Des1=$Fila[a_catodo_comercial];
			$Lam1=$Fila[desp_lamina];
		 }		 
?>
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15" /></td>
    <td width="98%" height="15" background="archivos/interior2/form_arriba.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15" /></td>
    <td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td colspan="10" align="right" class="TituloCabecera">Seleccionar Fecha&nbsp;&nbsp;&nbsp;
              <input type="text" size="9" readonly maxlength="10" name="FDesde" id="FDesde"  class="InputDer" value='<?php echo $FDesde?>' />
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FDesde,FDesde,popCal);return false" />&nbsp;&nbsp;&nbsp;<a href="JavaScript:Proceso('B')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;</td>
      </tr>
      <tr>
        <td width="56%" align="center" class="TituloCabecera">Programado</td>
        <td width="44%" align="center" class="TituloCabecera">PGM. REV Operativo</td>
        <td width="44%" align="center" class="TituloCabecera">PGM. REV Operativo Acum.</td>
      </tr>
      <tr>
        <td>C&aacute;todos Comerciales</td>
        <td><div align="center">
          <input type="text" name="Com0" value="<?php echo $Com0;?>"/>
        </div></td>
        <td><div align="center">
          <input type="text" name="Com1" value="<?php echo $Com1;?>"/>
        </div></td>
      </tr>
      <tr>
        <td>Descobrizaci&oacute;n Normal</td>
        <td><div align="center">
          <input type="text" name="Des0" value="<?php echo $Des0;?>"/>
        </div></td>
        <td><div align="center">
          <input type="text" name="Des1" value="<?php echo $Des1;?>"/>
        </div></td>
      </tr>
      <tr>
        <td>L&aacute;minas y Despuntes</td>
        <td><div align="center">
          <input type="text" name="Lam0" value="<?php echo $Lam0;?>"/>
        </div></td>
        <td><div align="center">
          <input type="text" name="Lam1" value="<?php echo $Lam1;?>"/>
        </div></td>
      </tr>
      <tr>
        <td colspan="3"><div align="right"><a href="JavaScript:Proceso('G')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a></div></td>
        </tr>
    </table></td>
    <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15" /></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15" /></td>
  </tr>
</table><br>
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15" /></td>
    <td width="98%" height="15" background="archivos/interior2/form_arriba.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15" /></td>
    <td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td colspan="9" align="right" class="TituloCabecera">
          <?php
        	if(!isset($CmbMes)&&!isset($CmbAno))
			{
				$CmbMes=intval(date("m"));
				$CmbAno=date("Y");
					
			}
			echo"<select name='CmbMes' onChange=Proceso('B')>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
			echo "</select>";
			echo "<select name='CmbAno' onChange=Proceso('B')>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			echo "</select>";

		?>
         &nbsp;&nbsp;&nbsp;<a href="JavaScript:Graba('GCu')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;</td>
      </tr>
      <tr>
        <td width="56%" align="center" class="TituloCabecera">&nbsp;</td>
        <td width="44%" align="center" class="TituloCabecera">Valor</td>
      </tr>
      <?php
  		 $Param3=0;
		 $Consulta="select nombre_subclase,cod_subclase,valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase = '10007' and valor_subclase1 ='".$CmbAno."' and valor_subclase2='".$CmbMes."'";
		 //echo $Consulta;
		 $Resp=mysqli_query($link, $Consulta);
		 if($Fila=mysqli_fetch_array($Resp))
		 {
			$Param3=$Fila[valor_subclase3];
		 }
			?>
      <tr>
        <td> Cu Elec</td>
        <td><input type="text" name="TxtGElec" value="<?php echo $Param3;?>"/ maxlength="6"></td>
      </tr>
    </table></td>
    <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15" /></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
</body>
</html>
