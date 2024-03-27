<?  session_start();  
	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$FechaSist=date("d/m/Y");
	$Fecha_Sistema= date("Y-m-d");
	$Hora= date("G:i:s");
	
	require "KoolAjax/koolajax.php";
	$koolajax->scriptFolder = "KoolAjax";
	
	if($koolajax->isCallback)
	{
		sleep(1); //Slow down 1s to see loading effect
	}
	echo $koolajax->Render();
	if($Opt=='M')
	{
		$Consulta="select * from ipif_novedades where nro_solicitud='".$NumNov2."'";
		$RespSolp=mysqli_query($link, $Consulta);
		//echo $Consulta;
		if($FilaSolp=mysql_fetch_array($RespSolp))
		{
			$TxtFecha=$FilaSolp[fecha_ingreso];
			$CmbTurno=$FilaSolp[turno];
			$textnovedad=$FilaSolp["observacion"];
			$InfGer=$FilaSolp[informe_gerencia];
			$Estado=$FilaSolp[estado];
			$CkJF=$FilaSolp[envio_jefe];
		}
	}
	
	if($TxtFecha=='')
		$TxtFecha=$Fecha_Sistema;

?>
<title>
Visualizaci�n de Novedades
</title>
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/ipif_funciones.js"></script>
<script language="javascript">

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
		case "I":
			window.print();
			break;
		case "S":
			window.close();
		break;
		
	}	
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
<input type="hidden" name="NumNov2"  value="<? echo $NumNov2;?>" size="10" readonly="true" class="InputDer" />
<input type="hidden" name="Estado"  value="<? echo $Estado;?>"  />

<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'vizualiza.png',$CookieRut)
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
         <input name="TxtFecha" type="text" style="width:70" disabled="disabled" id="TxtFecha" value="<? echo $TxtFecha; ?>" />
         </label><span class="InputRojo">(*)</span></td>
       <td width="28" align="left" >Turno</td>
       <td width="449" align="left" >
	   <select name="CmbTurno" disabled="disabled">
         <option value="-1" class="NoSelec">Seleccionar</option>
         <?
			$Consulta = "select * from  proyecto_modernizacion.sub_clase where cod_clase=1 order by valor_subclase1";
			$Resp=mysqli_query($link, $Consulta);
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
		 <!-- <a href="JavaScript:Proceso('AS')"><img src="archivos/gestor1.png" alt="Agrega Solicitante" border="0" align="absmiddle" /></a>-->
	<?	}?>	   </td>
       <td width="133" align="right" > 
	  <!-- <a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
	   <a href="JavaScript:Proceso('E')"><img src="archivos/eliminar.png" height="25" width="25" alt="Elimina Novedad" border="0" align="absmiddle" /></a>-->&nbsp;
	  <a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png" border="0" alt="Imprimir" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('S')"><img src="archivos/close.png"  alt="Cerrar " border="0" align="absmiddle" /></a></td>
     </tr>
          <tr>
       <td height="16" colspan="7" class="TituloCabecera"><div align="center">INGRESO DE NOVEDADES  Nro. <? echo $NumNov?> </div></td>
     </tr>
      </table>
	 <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
      
		  <tr class="TituloCabeceraChica">
         <td colspan="2" class="formulario" >Novedad <span class="InputRojo">
&nbsp;(*)</span></td>
         <td width="184" class="formulario" >&nbsp;&nbsp; Condici&oacute;n <span class="InputRojo">
&nbsp;(*)</span></td>
         <td width="473" class="formulario" >Envio Correo <span class="InputRojo">
&nbsp;(*)</span></td>
         </tr>
		  
		  <tr class="TituloCabeceraChica">
		    <td colspan="2" valign="top" class="formulario" ><textarea name="textnovedad" rows="15" cols="80"><? echo $textnovedad; ?></textarea></td>
		    <td class="formulario" valign="top" ><? 
			$Consulta = "select count(*) as Cantidad from  ipif_condicion ";
				$Resp=mysqli_query($link, $Consulta);
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
				$Resp=mysqli_query($link, $Consulta);
				echo '<input class="SinBorde" name="checkCondicion" type="hidden" value="">';
				while ($Fila=mysql_fetch_array($Resp))
				{
					?>
              		<tr>
                	<td width="28" height="25">
					
					<?
						$Consulta="select * from ipif_novedades_condicion where nro_solicitud='".$NumNov2."' and cod_condicion='".$Fila[cod_condicion]."'";
						$RespCon=mysqli_query($link, $Consulta);
						if($FilaCon=mysql_fetch_array($RespCon))
						{
							$Check='checked';
						?>
						<input class="SinBorde" name="checkCondicion" type="checkbox" value="<? echo $Fila[cod_condicion]?>" checked="checked"  disabled="disabled">
						<?
						}
						else
						{
							?>
							<input class="SinBorde" name="checkCondicion" type="checkbox" value="<? echo $Fila[cod_condicion]?>" disabled="disabled">
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
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
						$CANTR=$Fila[CANT];
					}
			*/
			?><div style="width:100%;height:205px;overflow-y:scroll;overflow:-moz-scrollbars-vertical;" align="right"><?
			
			 echo KoolScripting::Start();?>
          <UPDATEpanel id="order_UPDATEpanel6">
		  
		  
		  
		  
		  <content><![CDATA[<table width="400" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
				<tr><td width="1%">&nbsp;<? if($Estado>=1){?><? }
				?></td>
				<td colspan="3" class="formulario">Envio Correos Mantenci&oacute;n</td>
				</tr>
				</td>
<?					if($_Grabar=='S')
					{
						$Consulta="select * from ipif_ceco_solicitante where cod_ceco='".$_perfil."' ";
						$RespP=mysqli_query($link, $Consulta);
						while ($FilaP=mysql_fetch_array($RespP))
						{
							$Consulta="select * from ipif_novedades_correos where nro_solicitud='".$NumNov2."' and cuenta='".$FilaP[cuenta_solicitante]."' ";
							$RespE=mysqli_query($link, $Consulta);
							if(!$FilaE=mysql_fetch_array($RespE))
							{
								$Insertar="insert into ipif_novedades_correos(nro_solicitud,cuenta,tipo,cod_cc) values";
								$Insertar.="('".intval($NumNov)."','".$FilaP[cuenta_solicitante]."','A','".$_perfil."')";
								mysql_query($Insertar);	
							}
						}		
				  	}
					if($_Elim=='S')
					{
						$Eliminar="delete from ipif_novedades_correos where nro_solicitud='".$NumNov2."' and cuenta='".$_cuenta."' ";
						mysql_query($Eliminar);
					}
					
					$Consulta="select * from ipif_novedades_correos where nro_solicitud='".$NumNov2."' and tipo='A' ";
					$Resp=mysqli_query($link, $Consulta);
					//echo $Consulta;
					while($Fila=mysql_fetch_array($Resp))
					{		
?>					 <tr>
				  	 <td>	
					 &nbsp;	
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
		     	<input type="checkbox" name="checkinforme" value="checkbox" class="SinBorde" checked="checked" disabled="disabled">
		    	<?
			}
			else
			{
				?>
				<input type="checkbox" name="checkinforme" value="checkbox" class="SinBorde" disabled="disabled">
			<?
			}
			?>			</td>
			<td rowspan="2" class="formulario" >&nbsp;</td>
		    <td rowspan="3"  valign="top"class="formulario" >
			
		
		<? $Existe='N';
			$ConsultaExiste="select * from ipif_novedades_correos where nro_solicitud='".$NumNov2."' and tipo='M'";
			//echo $ConsultaExiste;
			$RespE=mysql_query($ConsultaExiste);
			if($FilaE=mysql_fetch_array($RespE))
			{?>	<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
				<tr><td width="1%" >
				<? $Existe='S';
				if($Estado>=1)
				{?>
				&nbsp;&nbsp;		<? 
				
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
			    <td width="1">&nbsp;</td>
                  <td><? echo $MDatosF[0]; ?></td>
                  </tr><? 
			}
				?>
		    </table>		
			<? 
			}?>	</td></tr></table><? 
			
			}?>
						</td>
	      </tr>
		  <tr class="TituloCabeceraChica">
		    <td class="formulario" >Informe&nbsp;Jefe </td>
	        <td class="formulario" >	<?
			if($CkJF=='S')
			{
				?>
		     	<input type="checkbox" name="checkjefe" value="checkbox" class="SinBorde" checked="checked" disabled="disabled">
		    	<?
			}
			else
			{
				?>
				<input type="checkbox" name="checkjefe" value="checkbox" class="SinBorde" disabled="disabled">
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