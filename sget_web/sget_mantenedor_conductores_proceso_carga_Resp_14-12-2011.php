<? include("../principal/conectar_sget_web.php");?>
<html>
<head>
<?
	if($Borra=='S')
	{
		$Elimina="delete from sget_conductores_tmp where rut_operador='".$CookieRut."'";
		mysql_query($Elimina);
	}

		echo "<title>Carga Excel Conductores</title>";
		$VarTitulo='Carga Excel Conductores';
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function Proceso(Opcion)
{
	var f= document.FrmProceso;
	var Valida=true;
	var Veri="";
	switch(Opcion)
	{
		case "Carga":
			if(f.file.value=='')
			{
				alert('Debe seleccionar el archivo a cargar.')
				f.file.focus();
				return;
			}
			if(comprueba_extension(f.file.value)==true)
			{ 
				f.action = "sget_mantenedor_conductores_proceso_carga01.php?Opcion="+Opcion; 
				f.submit();
			}
			else
			{
				alert('Extensi�n de archivo incorrecto, debe ser .xls')
				return;
			}			
		break;
		case "Carga1":
			f.action = "sget_mantenedor_conductores_proceso_carga01.php?Opcion="+Opcion; 
			f.submit();
		break;


	}
}
function Salir()
{
	window.close();
}
</script>
</head>


<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">

<form action="" method="post" enctype="multipart/form-data" name="FrmProceso">

<table width="960" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1em.gif" width="15" height="15"></td>
	<td width="848" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2em.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="74%" align="left"><img src="archivos/sub_tit_conduc_carga.png" width="450" height="40"></td>
	  <td width="26%" align="right">
	  Formato Carga Conductores <img src="archivos/vineta.gif"> <a href="archivos/carga_conductores.xls" target="_blank"><img src="archivos/ico_excel4.jpg"  alt="Formato Carga Conductores " align="absmiddle" border="0"></a>  
	  <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>  </td>
  </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
            <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" >
                <tr> 
                  <td width="150" class="FilaAbeja2">Excel</td>
                  <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                  <td width="781" class="FilaAbeja2"><label>
                    <input type="file" size="60" name="file">
                  &nbsp;<a href="JavaScript:Proceso('Carga')"><img src="archivos/Cexec.png" border="0" alt="Subir Archivo Excel" align="absmiddle"></a></label></td>
                </tr>
                <tr>
                  <td height="28" colspan="2" class="FilaAbeja2"><span class="InputRojo">(*) Rut en Rojo, Se encuentran incorrectos, revisar</span>
				  <?
					$Consulta="SELECT * from sget_conductores_tmp where corr_conductor<>'' and rut_operador='".$CookieRut."'";
					$Consulta.=" order by apellido_paterno,apellido_materno,nombres";	
					$Resp = mysqli_query($link, $Consulta);
					//echo $Consulta;
					$Cont=1;
					if($Fila=mysql_fetch_array($Resp))
					{
						?>
				  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
                    <tr>
                      <td colspan="11" align="center" class="CorteAmarillo">Guardar Datos&nbsp;&nbsp;<a href="JavaScript:Proceso('Carga1')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" class="CorteAmarillo" /></a>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="7%" align="center" class="TituloTablaVerde">Rut</td>
                      <td width="11%" align="center" class="TituloTablaVerde">Nombre</td>
                      <td width="12%" align="center" class="TituloTablaVerde">Tipo&nbsp;Vehiculo</td>
                      <td width="12%" align="center" class="TituloTablaVerde">Tipo&nbsp;Licencias</td>
                      <td width="12%" align="center" class="TituloTablaVerde">Vig.Licencia</td>
                      <td width="15%" align="center" class="TituloTablaVerde">Restricci&oacute;n</td>
                      <td width="10%" align="center" class="TituloTablaVerde">Fecha Preocu. </td>
                      <td width="16%" align="center" class="TituloTablaVerde">Empresa </td>
                      <td width="10%" align="center" class="TituloTablaVerde">N&deg; Contrato </td>
                      <td width="10%" align="center" class="TituloTablaVerde">Fecha  Otorgada </td>
                      <td width="9%" align="center" class="TituloTablaVerde">Fecha DAS</td>
                    </tr>
					  <?
						$Consulta="SELECT * from sget_conductores_tmp where corr_conductor<>'' and rut_operador='".$CookieRut."'";
						$Consulta.=" order by apellido_paterno,apellido_materno,nombres";	
						$Resp = mysqli_query($link, $Consulta);
						//echo $Consulta;
						$Cont=1;
						while ($Fila=mysql_fetch_array($Resp))
						{
							$Lic="SELECT tipo_licencia from sget_conductores_licencias_tmp where corr_conductor='".$Fila[corr_conductor]."'";
							//echo $Lic."<br>"; 
							$RLic=mysql_query($Lic);$Licencias='';
							while($FLic=mysql_fetch_array($RLic))
							{
								if($FLic[tipo_licencia]!='')
									$Licencias=$Licencias.$FLic[tipo_licencia].", ";
							}		
							if($Licencias !='')
									$Licencias=substr($Licencias,0,strlen($Licencias)-2);							
							if(valida_rut($Fila["rut"])==false)				
								$ColorRut="<span class='InputRojo'>".$Fila["rut"]."</span>";
							else
								$ColorRut=$Fila["rut"];	
							?>
							<tr>	
							  <td ><? echo $ColorRut; ?></td>
							  <td ><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"])); ?></td>
							  <td align="center" ><? echo strtoupper($Fila["tipo_vehiculo"]); ?>&nbsp;</td>
							  <td align="center" ><? echo $Licencias; ?>&nbsp;</td>
							  <td align="center" ><? echo $Fila["fecha_vig_licencia"]; ?></td>
							  <td ><textarea name="Restriccion" cols="30"><? echo $Fila["restriccion_licencia"]?></textarea></td>
							  <td align="center" ><? echo $Fila["fecha_exa_preoc"]."&nbsp;"; ?></td>
							  <td ><? echo $Fila["rut_empresa"]." - ".$Fila["empresa"]."&nbsp;"; ?></td>
							  <td ><? echo $Fila["contrato"]."&nbsp;"; ?></td>
							  <td align="center" ><? echo $Fila["fecha_exa_pst"]."&nbsp;"; ?></td>
							  <td align="center" ><? echo $Fila["fecha_hoja_ruta"]."&nbsp;"; ?></td>
							</tr>
							<?		
							$Cont++;
						}
			?>
                  </table>
				  <?
				  }
				  ?>
				  </td>
                </tr>
              </table>
		    </td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="1" height="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="1" height="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
  </table>
   <br>

</form>
</body>
</html>
	<script languaje='JavaScript'>
	<?
	if ($Ing=='NC')
	{
	?>
		alert('No se a podido cargar excel, intente nuevamente');
	<?
	}
	if ($Ing=='S')
	{
	?>
		alert('Proceso realizado exitosamente \nPor favor revisar y validar los datos antes de guardar.');
	<?
	}
	if ($Ing=='R')
	{
	?>
		alert('Datos Guardados exitosamente');
	<? 
	}	
	?>
	</script>
<?
function valida_rut($r)
{
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	if ( $dv==$sub_dv )
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>	