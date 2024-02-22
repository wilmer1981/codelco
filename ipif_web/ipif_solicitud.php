<?  session_start(); 

	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$FechaSist=date("d/m/Y");
	$Fecha_Sistema= date("Y-m-d");
	$Hora= date("G:i:s");
	
	if($Op=='EF')
	{
		$Eliminar="delete from  ipif_novedades_correos where nro_solicitud='".intval($NumNov)."' and cuenta='".$F."' and tipo='M'";
		mysql_query($Eliminar);	
	
	}
	require "KoolAjax/koolajax.php";
	$koolajax->scriptFolder = "KoolAjax";
	
	if($koolajax->isCallback)
	{
		sleep(1); //Slow down 1s to see loading effect
	}
	echo $koolajax->Render();
	if($Opt=='M')
	{
		$Consulta="select * from ipif_novedades where nro_solicitud='".$NumNov."'";
		$RespSolp=mysql_query($Consulta);
		if($FilaSolp=mysql_fetch_array($RespSolp))
		{
			//echo "fecha".$FilaSolp[fecha_ingreso]."<br>";
			if($FilaSolp[fecha_ingreso] =!" ")
				$TxtFecha=FechaAMD($FilaSolp[fecha_ingreso]);
			$CmbTurno=$FilaSolp[turno];
			$textnovedad=$FilaSolp["observacion"];
			$InfGer=$FilaSolp[informe_gerencia];
			$Estado=$FilaSolp[estado];
			$CkJF=$FilaSolp[envio_jefe];
			$InfGer=$FilaSolp[informe_diario];
		}
	}
	
	if($TxtFecha=='')
		$TxtFecha=date("d-m-Y");

?>
<title>
Ingreso de Novedades
</title>
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/ipif_funciones.js"></script>
<script language="javascript">
function CambiaFecha(Sig)
{		var f=document.FrmProceso;

	switch(Sig)
	{
		case '+':
			f.TxtFecha.value=f.TxtFecha.value+1;
		
		break;
		case'-':
			f.TxtFecha.value=f.TxtFecha.value-1;
		
		break;
	
	}
	

}
function Proceso(Opt)
{
	var f=document.FrmProceso;
	var InfGer='';
	switch (Opt)
	{
		case "AS":
				URL='ipif_asociar_solicitante.php?OPTS=AS';
			opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=400,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		
		case "G":
			if(IngresoValido())
			{
				if(SoloUnElemento(f.name,'checkCondicion','E'))
				{
					Datos=Recuperar(f.name,'checkCondicion');
					if(Datos!='')
					{	var EnF='';
						var InfGer='';
						if(f.checkinforme.checked == true)
							InfGer='S'; 
						if(f.checkjefe.checked == true)
							EnF='S'; 	
						f.action="ipif_solicitud01.php?Opt=G&Valores="+Datos+"&InfGer="+InfGer+"&EJF="+EnF;
						f.submit();
						
					}
				}
			}
		break;
		case "S":
			window.close();
		break;
		case "E":
			if (confirm("�Seguro que desea Eliminar esta Novedad?"))
			{
				f.action="ipif_solicitud01.php?Opt=E";
				f.submit();
			}	
		break;
		case "ECA":
			if (confirm("�Seguro que desea Enviar los Correos?"))
			{
				f.action="ipif_solicitud01.php?Opt=ECA";
				f.submit();
			}	
		break;
		case "ECB":
			if (confirm("�Seguro que desea Enviar los Correos?"))
			{
				f.action="ipif_solicitud01.php?Opt=ECB";
				f.submit();
			}	
		break;
	}	
}
function IngresoValido()
{
	var f=document.FrmProceso;
	var Result=true;
	if(f.TxtFecha.value=='')
	{
		alert('Debe Ingresar Fecha');
		Result=false;
		return;		
	}
	if(f.CmbTurno.value=='-1')
	{
		alert('Debe Seleccionar Turno');
		f.CmbTurno.focus();
		Result=false;
		return;		
	}
	if(f.textnovedad.value=='')
	{
		alert('Debe Ingresar Observaci�n');
		f.textnovedad.focus();
		Result=false;
		return;		
	}
	return(Result);
}
function ASD(F)
{
	order_UPDATEpanel8.attachData("Op","GP");
	order_UPDATEpanel8.attachData("F",F);
	order_UPDATEpanel8.UPDATE();

}
function GrabaPerfiles(N)
{
		var perfil = document.getElementById("CmbPerfil").value;	
		document.getElementById("CmbPerfil").value="-1";
		//document.Proceso.value='M';
		if(perfil!="-1")
		{
			order_UPDATEpanel6.attachData("_numnov",document.getElementById("NumNov").value);
			order_UPDATEpanel6.attachData("_turno",document.getElementById("CmbTurno").value);
			order_UPDATEpanel6.attachData("_fecha",document.getElementById("TxtFecha").value);
			order_UPDATEpanel6.attachData("_perfil",perfil);
			order_UPDATEpanel6.attachData("_Grabar","S");
			order_UPDATEpanel6.UPDATE();
			
			
/**/		}
}
function Eliminar(ID)
{
	order_UPDATEpanel6.attachData("_Elim","S");
	order_UPDATEpanel6.attachData("_cuenta",ID);
	order_UPDATEpanel6.UPDATE();
}
function Elim(C)
{
	var f=document.FrmProceso;
	f.action="ipif_solicitud.php?Op=EF&F="+C;
	f.submit();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=180 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" action="" method="post" ENCTYPE="multipart/form-data">
<!--<input type="text" name="Opt"  value="<? echo $Opt;?>" size="10" readonly="true" class="InputDer" />-->
<input type="hidden" name="NumNov"  value="<? echo $NumNov;?>" size="10" readonly="true" class="InputDer" />
<input type="hidden" name="Estado"  value="<? echo $Estado;?>"  />

<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'ingreso_novedades.png',$CookieRut);
 ?>
 <table width="100%" align="center" border="0" cellpadding="0"  cellspacing="0"  class="TablaPricipalColor" >
  <tr>
	<td ><img src="archivos/images/interior/esq01.png" width="15" height="15"></td>
	<td width="915" height="15"background="archivos/images/interior/form_arriba0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td ><img src="archivos/images/interior/esq02.png" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq0.png">&nbsp;</td>
   	<td>
   	  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
    
     <tr>
       <td width="78" align="center" >Fecha Ingreso 	  </td>
       <td width="170" align="left" ><span class="formulario">
         <label>
         <input name="TxtFecha" type="text" style="width:70" id="TxtFecha" value="<? echo $TxtFecha; ?>" />
         <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false" /></label><span class="InputRojo">(*)</span></td>
       <td width="28" align="left" >Turno</td>
       <td width="449" align="left" >
	   <select name="CmbTurno">
         <option value="-1" class="NoSelec">Seleccionar</option>
         <?
			$Consulta = "select * from  proyecto_modernizacion.sub_clase where cod_clase=1 order by valor_subclase1";
			$Resp=mysql_query($Consulta);
			while ($FilaT=mysql_fetch_array($Resp))
			{
				if ($CmbTurno==$FilaT["cod_subclase"])
				echo "<option selected value='".$FilaT["cod_subclase"]."'>".ucfirst($FilaT["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaT["cod_subclase"]."'>".ucfirst($FilaT["nombre_subclase"])."</option>\n";
			}
			
?>
       </select>
         <span class="InputRojo">
&nbsp;(*)</span></td>
       <td width="129" align="right" >
	 <?  if($Estado>=1)
			{?>
		  <a href="JavaScript:Proceso('AS')"><img src="archivos/gestor1.png" alt="Agrega Solicitante" border="0" align="absmiddle" /></a>
	<?	}?>	   </td>
       <td width="133" align="right" > <a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
	   <a href="JavaScript:Proceso('E')"><img src="archivos/eliminar.png" height="25" width="25" alt="Elimina Novedad" border="0" align="absmiddle" /></a>&nbsp;
	   <a href="JavaScript:Proceso('S')"><img src="archivos/close.png"  alt="Cerrar " border="0" align="absmiddle" /></a></td>
     </tr>
          <tr>
       <td height="16" colspan="7" class="TituloCabecera"><div align="center">
	    <?  if($Estado>=1)
			{?>
	   INGRESO DE NOVEDADES  Nro. <? echo $NumNov?>
	   <?	}?>
	    </div></td>
     </tr>
      </table>
	 <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
      
		  <tr class="TituloCabeceraChica">
         <td colspan="2" class="formulario" >Novedad <span class="InputRojo">
&nbsp;(*)</span></td>
         <td width="184" class="formulario" >&nbsp;&nbsp; Condici&oacute;n <span class="InputRojo">
&nbsp;(*)</span></td>
         <td width="473" class="formulario" >Envio Correo</td>
         </tr>
		  
		  <tr class="TituloCabeceraChica">
		    <td colspan="2" valign="top" class="formulario" ><textarea name="textnovedad" rows="15" cols="80"><? echo $textnovedad; ?></textarea></td>
		    <td class="formulario" valign="top" ><? 
			$Consulta = "select count(*) as Cantidad from  ipif_condicion ";
				$Resp=mysql_query($Consulta);
				echo '<input class="SinBorde" name="checkCondicion" type="hidden" value="">';
				if($FilaC=mysql_fetch_array($Resp))
				{
				$CantRe=$FilaC[Cantidad];
				}
			
			if($CantRe>8)
				{
				?>
				<div style="width:100%;height:200px;overflow-y:scroll;overflow:-moz-scrollbars-vertical; border:thin " align="right">
				<? 
				}?><table width="180" height="40" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
              <?
				$Consulta = "select * from  ipif_condicion ";
				$Resp=mysql_query($Consulta);
				echo '<input class="SinBorde" name="checkCondicion" type="hidden" value="">';
				while ($Fila=mysql_fetch_array($Resp))
				{
					?>
              		<tr>
                	<td width="28" height="25">
					
					<?
						$Consulta="select * from ipif_novedades_condicion where nro_solicitud='".$NumNov."' and cod_condicion='".$Fila[cod_condicion]."'";
						$RespCon=mysql_query($Consulta);
						//echo $Consulta;
						if($FilaCon=mysql_fetch_array($RespCon))
						{
							$Check='checked';
						?>
						<input class="SinBorde" name="checkCondicion" type="checkbox" value="<? echo $Fila[cod_condicion]?>" checked="checked" >
						<?
						}
						else
						{
							?>
							<input class="SinBorde" name="checkCondicion" type="checkbox" value="<? echo $Fila[cod_condicion]?>">
							<?
						}				
					?>					</td>
                	<td width="168"><? echo $Fila["descripcion"]; ?></td>
              		</tr>
              		<?
				}
				?>
            </table>
			<? 
			if($CantRe>8)
				{
				 ?></div><?
				}
			
			?>			</td>
		    <td  valign="top" class="formulario" >
			<?
			/*
			$Consulta="select count(*) as CANT from ipif_ceco_solicitante t1 inner join ipif_novedades_correos t2 on t1.cod_ceco=t2.cod_cc and t1.cuenta_solicitante=t2.cuenta";
			$Consulta.=" where  cod_tipo='2' and nro_solicitud='".$NumNov."' and t2.tipo='A' ";
					$Resp=mysql_query($Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
						$CANTR=$Fila[CANT];
					}
			*/
			?><div style="width:100%;height:205px;overflow-y:scroll;overflow:-moz-scrollbars-vertical;" align="right"><?
			
			 echo KoolScripting::Start();?>
          <UPDATEpanel id="order_UPDATEpanel6">
		  
		  
		  
		  
		  <content><![CDATA[<table width="400" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
				<tr><td width="1%">&nbsp;<? if($Estado>=1){?><a href="JavaScript:Proceso('ECA')"><img src="archivos/email.png"  alt="Envio de mail " border="0" align="absmiddle" /></a><? }
				?></td>
				<td class="formulario">Area de Servicio</td>
				<td colspan="2"> 
				<select name="CmbPerfil" style="width:180">
                <option value="-1" class="NoSelec">Seleccionar</option>
                <?
				$Consulta = "select * from  ipif_ceco_asociacion t1 inner join proyecto_modernizacion.centro_costo t2 ";
				$Consulta.= " on t1.cod_cc=t2.CENTRO_COSTO where t1.cod_tipo='2' ";
				$RespP=mysql_query($Consulta);
				while ($FilaP=mysql_fetch_array($RespP))
				{
					if ($CmbPerfil==$FilaP["cod_cc"])
						echo "<option selected value='".$FilaP["cod_cc"]."'>".ucfirst(CambiaAcento($FilaP["descripcion"]))."</option>\n";
					else
						echo "<option value='".$FilaP["cod_cc"]."'>".ucfirst(CambiaAcento($FilaP["descripcion"]))."</option>\n";
				}
				?>
                </select>
				  <a href="JavaScript:GrabaPerfiles('<? echo $Numero; ?>')"><img src="archivos/btn_agregar.png" alt="Agregar" border="0" align="absmiddle" /></a></td>
				</tr>
				</td>
<?					if($_Grabar=='S')
					{
						$Consulta="select * from ipif_ceco_solicitante where cod_ceco='".$_perfil."' ";
						$RespP=mysql_query($Consulta);
						while ($FilaP=mysql_fetch_array($RespP))
						{
							$Consulta="select * from ipif_novedades_correos where nro_solicitud='".$NumNov."' and cuenta='".$FilaP[cuenta_solicitante]."' ";
							$RespE=mysql_query($Consulta);
							if(!$FilaE=mysql_fetch_array($RespE))
							{
								$Insertar="insert into ipif_novedades_correos(nro_solicitud,cuenta,tipo,cod_cc) values";
								$Insertar.="('".intval($NumNov)."','".$FilaP[cuenta_solicitante]."','A','".$_perfil."')";
								mysql_query($Insertar);	
								$Actualizar = "UPDATE ipif_novedades set mantencion='S' where nro_solicitud='".$NumNov."' ";
								mysql_query($Actualizar);
								//echo $Actualizar;
							}
						}		
				  		
					}
					if($_Elim=='S')
					{
						$Eliminar="delete from ipif_novedades_correos where nro_solicitud='".$NumNov."' and cuenta='".$_cuenta."' ";
						mysql_query($Eliminar);
						$Consulta="select * from ipif_novedades_correos  where nro_solicitud='".$NumNov."' ";
						$RespNov=mysql_query($Consulta);
						if(!$FilaNov=mysql_fetch_array($RespNov))
						{
							$Actualizar = "UPDATE ipif_novedades set mantencion='' where nro_solicitud='".$NumNov."' ";
							mysql_query($Actualizar);
						}
						
					}
					
					$Consulta="select * from ipif_novedades_correos where nro_solicitud='".$NumNov."' and tipo='A' ";
					$Resp=mysql_query($Consulta);
					//echo $Consulta;
					while($Fila=mysql_fetch_array($Resp))
					{		
?>					 <tr>
				  	 <td>	
					 <a href="JavaScript:Eliminar('<? echo $Fila[cuenta]; ?>')"><img src="archivos/elim2.png" alt="Eliminar" border="0" align="absmiddle" /></a>	
					  </td>
					  <td>
					   <?
					   echo Perfil($Fila[cuenta],$Fila[cod_cc]);
					   ?>
					   </td>
					  <td width="200">
					  <?
					    $DatosF=Funcionario($Fila[cuenta]);
						$MDatosF=explode('~',$DatosF);
						echo $MDatosF[0];
					   ?>
					  </td>
					  </tr>
<?	}
?></table>]]></content><loading image="KoolAjax/loading/15.gif" /></UPDATEpanel><?php echo KoolScripting::End();?></div>			</td>
	      </tr>
		  <tr class="TituloCabeceraChica">
		    <td width="111" class="formulario" >Informe&nbsp;de&nbsp;Gerencia</td>
			<td width="223" class="formulario" ><?
			if($InfGer=='S')
			{
				?>
		     	<input type="checkbox" name="checkinforme" value="checkbox" class="SinBorde" checked="checked">
		    	<?
			}
			else
			{
				?>
				<input type="checkbox" name="checkinforme" value="checkbox" class="SinBorde">
			<?
			}
			?>			</td>
			<td rowspan="2" class="formulario" >&nbsp;</td>
		    <td rowspan="3"  valign="top"class="formulario" >
			<?
		 echo KoolScripting::Start();?>
          <UPDATEpanel id="order_UPDATEpanel8">
		   <content><![CDATA[
		<? $Existe='N';
		
		 if($Op=='GP')
			{
				$Valor = explode("//",$F);
				while (list($clave,$Codigo)=each($Valor))
				{
				$Insertar="insert into ipif_novedades_correos(nro_solicitud,cuenta,tipo,cod_cc) values";
				$Insertar.="('".intval($NumNov)."','".$Codigo."','M','')";
				mysql_query($Insertar);	
				InsertarFuncionario($Codigo,'');
				}
				$Opt='M';
			}
		
			$ConsultaExiste="select * from ipif_novedades_correos where nro_solicitud='".$NumNov."' and tipo='M'";
			//echo $ConsultaExiste;
			$RespE=mysql_query($ConsultaExiste);
			if($FilaE=mysql_fetch_array($RespE))
			{?>	<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
				<tr><td width="1%" >
				<? $Existe='S';
				if($Estado>=1)
				{?>
				<a href="JavaScript:Proceso('ECB')"><img src="archivos/email.png"  alt="Envio de mail " border="0" align="absmiddle" /></a>			<? 
				
				}
				?>
				</td>
			      <td width="84%" ><span class="titulo_azul">ENVIO CORREO MANUAL</span></td>
				</tr>
			<tr><td colspan="2"><? 
			if($Existe=='S')
			{
			
			
			
			?>
			  <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
			  <? 
			
			 $RespE=mysql_query($ConsultaExiste);
			while($FilaE=mysql_fetch_array($RespE))
			{
			$DatosF=Funcionario($FilaE[cuenta]);
						$MDatosF=explode('~',$DatosF);
						
			 ?> <tr>
			    <td width="1"><a href="JavaScript:Elim('<? echo $FilaE[cuenta];?>','M')"><img src="archivos/elim2.png" alt="Eliminar" border="0" align="absmiddle" /></a>  </td>
                  <td><? echo $MDatosF[0]; ?></td>
                  </tr><? 
			}
				?>
		    </table>		
			<? 
			}?>	</td></tr></table><? 
			
			}?>
			]]></content><loading image="KoolAjax/loading/15.gif" /></UPDATEpanel><?php echo KoolScripting::End();?>
			</td>
	      </tr>
		  <tr class="TituloCabeceraChica">
		    <td class="formulario" >Informe&nbsp;Jefe </td>
	        <td class="formulario" >	<?
			if($CkJF=='S')
			{
				?>
		     	<input type="checkbox" name="checkjefe" value="checkbox" class="SinBorde" checked="checked">
		    	<?
			}
			else
			{
				?>
				<input type="checkbox" name="checkjefe" value="checkbox" class="SinBorde">
				<?
			}
			?>		</td>
		  </tr>
		  <tr class="TituloCabeceraChica">
		    <td colspan="2" class="formulario" ><span class="InputRojo">Campos Obligatorios &nbsp;(*)</span>&nbsp;<br><span class="titulo_cafe">
			La Informaci&oacute;n entregada es exclusiva Responsabilidad del Solicitante 
			</span></td>
		    <td class="formulario" >&nbsp;</td>
	      </tr>
	   
       <!-- </table>-->
     </table></td>
   <td  width="15" background="archivos/images/interior/form_der0.png">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq03.png" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq04.png" width="15" height="15" /></td>
  </tr>
  </table>
 
  <?
  CierreEncabezado();
  
if($Msj=='S')
{
?>
<script language="javascript">
alert('Correos Enviados Correctamente');
</script>
<?
}
  ?>

  
</form>
<body>