<? include("../principal/conectar_sget_web.php");

if($Form!='')
{
	if($RutReq=='S')
		$Opc='N';
	else
	{	
		$Opc='M';
		$Valores=$RutReq;
	}
}
if($Mutuales!='')
	$CmbMutuales=$Mutuales;

if ($Opc=='M')
{
	if(!isset($Valores))
		$RutReq=$TxtRutPrv."-".$TxtDv;
	else
		$RutReq=$Valores;
	$Consulta="SELECT * from sget_contratistas where rut_empresa = '".$RutReq."'";
	 $Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		//$TxtRutPrv=str_pad($Fila["rut_empresa"],10,'0',l_pad);
		$TxtRutPrv=$Fila["rut_empresa"];
		$TxtRazonSocial=$Fila["razon_social"];
		$TxtNombreFantasia=$Fila["nombre_fantasia"];
		$TxtCalle=$Fila["calle"];
		$TxtCorreo=$Fila["mail_empresa"];
		$TxtFono=$Fila["telefono_comercial"];
		$TxtRep1=$Fila["repres_legal1"];
		$TxtFonoRep1=$Fila["telefono_repres1"];
		$TxtMailRep1=$Fila["mail_repres_legal1"];
		$TxtCelRep1=$Fila["celular_repres_legal1"];
		$TxtRep2=$Fila["repres_legal2"];
		$TxtFonoRep2=$Fila["telefono_repres2"];
		$TxtMailRep2=$Fila["mail_repres_legal2"];
		$TxtCelRep2=$Fila["celular_repres_legal2"];
		$TxtNroRegic=$Fila["nro_regic"]; //estaba con comentario
		$TxtFechaCert=$Fila["fecha_ven_cert"];
		$TxtNroRegistro=$Fila["nro_registro"];
		if($Rec != 'S')
		{
			$CmbRegion=$Fila["cod_region"];
			$CmbCiudad=$Fila["cod_ciudad"];
			$CmbComuna=$Fila["cod_comuna"];
			$CmbMutuales=$Fila["cod_mutual_seguridad"];
			$CmbPrevencionista=$Fila["rut_prev"];
		}
	//	$CmbEstado=	$Fila["estado"];
	}	
}
?>
<html>
<head>
<?
	if ($Opc=='N')
	{
		echo "<title>Nueva Empresa</title>";
		$VarTitulo='Nueva Empresa';
	}
	else	
	{
		echo "<title>Modifica Empresa</title>";
		$VarTitulo='Modifica Empresa';
	}	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function ModificaRut()
{
	var f = document.FrmProceso;
	if (confirm("Esta opci�n reemplazar� rut empresa por nuevo ingresado"))
	{
		f.RutAnt.value = f.TxtRutPrv.value;
		f.NewOpc.value = 'S';
		f.action = "sget_mantenedor_empresas_proceso.php";
		f.submit();
	}
	else
	{
		f.NewOpc.value = "N";
		return;
	}

}
function Proceso(Opcion)
{
	var f= document.FrmProceso;
	var Valida=true;
	var Veri="";
	switch(Opcion)
	{
		case "N":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "sget_mantenedor_empresas01.php?Opcion="+Opcion; 
				f.submit();
			}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "sget_mantenedor_empresas01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "R":
			f.action = "sget_mantenedor_empresas_proceso.php?Opcion="+Opcion+"&Rec=S";
			f.submit();
		break;
		case "Mut":
		var	URL = "sget_mantenedor_mutuales_proceso.php?Volver=S&CmbMutuales="+f.CmbMutuales.value;		//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=500,height=250,menubar=no,status=1,resizable=yes,scrollbars=yes");

		break;

	}
}
function Salir()
{
	window.close();
}

function ValidaCampos(Res,Opcion)
{
	var f= document.FrmProceso;

		if(f.TxtRutPrv.value == '')
		{
			alert("Debe Ingresar Rut Empresa");
			f.TxtRutPrv.focus();
			Res=false;
			return;
		}
		valor= new Object(document.FrmProceso.TxtRutPrv.value);
		foco = new Object(document.FrmProceso.TxtRutPrv.focus());
		var bandera = Rut(document.FrmProceso.TxtRutPrv.value,'Rut Empresa', foco, valor);
		if(bandera == false)
		{
			Res=false;
			return;
			
		}
	
	if (f.TxtRazonSocial.value=="")
	{
		alert("Debe Ingresar Razon Social");
		f.TxtRazonSocial.focus();
		Res=false;
		return;
	}
	/*if (f.TxtNombreFantasia.value=="")
	{
		alert("Debe Ingresar Nombre de Fantasia");
		f.TxtNombreFantasia.focus();
		Res=false;
		return;
	}*/
	if (f.TxtCalle.value=="")
	{
		alert("Debe Ingresar Direccion");
		f.TxtCalle.focus();
		Res=false;
		return;
	}
	if(f.CmbRegion.value=='S')
	{
		alert("Debe Seleccionar Region");
		f.CmbRegion.focus();
		Validado=false;
		return;
	}

	if (f.CmbCiudad.value=="S")
	{
		alert("Debe Seleccionar Ciudad");
		f.CmbCiudad.focus();
		Res=false;
		return;
	}
	/*if (f.CmbComuna.value=="-1")
	{
		alert("Debe Seleccionar Comuna");
		f.CmbComuna.focus();
		Res=false;
		return;
	}*/
	if (f.CmbMutuales.value=="-1")
	{
		alert("Debe Seleccionar Mutual de Seguridad");
		f.CmbMutuales.focus();
		Res=false;
		return;
	}
	/*if (f.CmbEstado.value=="-1")
	{
		alert("Debe Seleccionar Estado");
		f.CmbEstado.focus();
		Res=false;
		return;
	}*/

	return(Res);
}

</script>
</head>
<?
if ($Opc=='N')
{
	echo '<body onLoad="document.FrmProceso.TxtRutPrv.focus();">';
}
else if ($Opc=="M")
{ 
	if ($NewOpc=="S")
		echo '<body onLoad="document.FrmProceso.TxtRutPrv.focus();">';
		else
		echo '<body onLoad="document.FrmProceso.TxtRazonSocial.focus();">';
}
?>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	/*background-image: url(archivos/f1.gif);*/
}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<img src="archivos/sub_tit_emp_n.png">
<form name="FrmProceso" method="post" action="">
<input name="Opc" type="hidden" value="<? echo $Opc; ?>">
<input name="NewOpc" type="hidden" value="<? echo $NewOpc; ?>">
<input name="Form" type="hidden" value="<? echo $Form; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="RutAnt" type="hidden" value="<? echo $RutAnt; ?>">

<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
              
            <td width="74%" align="left">
              <? if($Opc=='N'){?>
              <? }else{?>
              <img src="archivos/sub_tit_emp_m.png">
              <? }?>
            </td>
              <td width="26%" align="right">
			  <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
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
                  <td class="FilaAbeja2">Rut Empresa </td>
                  <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                  <td class="FilaAbeja2"> 
                    <?	   
		   	if($Opc=='M' && $NewOpc!='S')
			{
			?>
                    <input name="TxtRutPrv" type="text" value="<? echo $TxtRutPrv;?>" size="13" maxlength="10" readonly="true"> 
                    <?
			}
			else
			{
			?>
                    <input name="TxtRutPrv" type="text" value="<? echo $TxtRutPrv;?>" size="13" maxlength="10"> 
                    <?
			}
			?>
                    <span class="InputRojo">(*)</span></td>
                  <td colspan="2" class="FilaAbeja2"> <input name="ModRut" type="button"  value="Mod.Rut" onClick="ModificaRut()" ></td>
                </tr>
                <tr> 
                  <td width="231" class="FilaAbeja2">Raz&oacute;n Social </td>
                  <td colspan="3" class="FilaAbeja2"><input name="TxtRazonSocial" type="text" id="TxtRazonSocial3" style="width:350" value="<? echo $TxtRazonSocial; ?>" maxlength="100" > 
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Nombre Fantasia </td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtNombreFantasia" type="text" id="TxtNombreFantasia3" style="width:350" value="<? echo $TxtNombreFantasia; ?>" maxlength="50"></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Direcci&oacute;n</td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtCalle" type="text" id="TxtCalle3" style="width:300" value="<? echo $TxtCalle; ?>" maxlength="50"> 
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Regi&oacute;n</td>
                  <td colspan="3" class="FilaAbeja2"><SELECT name="CmbRegion" onChange="Proceso('R')">
                      <option value="S" SELECTed="SELECTed">Seleccionar</option>
                      <?
		$Consulta="SELECT * from sget_regiones ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbRegion==$Fila[cod_region])
				echo "<option value='".$Fila[cod_region]."' SELECTed>".$Fila[nom_region]."</option>";
			else	
				echo "<option value='".$Fila[cod_region]."'>".$Fila[nom_region]."</option>";
		}
		?>
                    </SELECT> <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Ciudad</td>
                  <td colspan="3" class="FilaAbeja2"><SELECT name="CmbCiudad" onChange="Proceso('R')">
                      <option value="S" SELECTed="SELECTed">Seleccionar</option>
                      <?
		$Consulta="SELECT t2.cod_ciudad,t2.nom_ciudad from sget_ciudades_por_region t1 inner join sget_ciudades t2 on t1.cod_ciudad=t2.cod_ciudad where cod_region='".$CmbRegion."' order by nom_ciudad ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbCiudad==$Fila["cod_ciudad"])
				echo "<option value='".$Fila["cod_ciudad"]."' SELECTed>".$Fila[nom_ciudad]."</option>";
			else	
				echo "<option value='".$Fila["cod_ciudad"]."'>".$Fila[nom_ciudad]."</option>";
		}
		?>
                    </SELECT> <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Comuna</td>
                  <td colspan="3" class="FilaAbeja2"><SELECT name="CmbComuna" id="SELECT12" >
                      <option value="-1" class="NoSelec">Seleccionar</option>
                      <?
			  $Consulta = "SELECT t2.cod_comuna,t2.nom_comuna from sget_comunas_por_ciudad  t1 inner join sget_comunas t2 on t1.cod_comuna=t2.cod_comuna ";
			  $Consulta.= " where t1.cod_ciudad='".$CmbCiudad."' ";			
			  $Consulta.= " order by nom_comuna ";			
			  $Resp2=mysqli_query($link, $Consulta);
			  while ($Fila2=mysql_fetch_array($Resp2))
			  {
				if ($CmbComuna==$Fila2["cod_comuna"])
					echo "<option SELECTed value='".$Fila2["cod_comuna"]."'>".ucfirst($Fila2["nom_comuna"])."</option>\n";
				else
					echo "<option value='".$Fila2["cod_comuna"]."'>".ucfirst($Fila2["nom_comuna"])."</option>\n";
			   }
			   ?>
                    </SELECT> </td>
                <tr> 
                  <td height="25" class="FilaAbeja2">E-Mail</td>
                  <td class="FilaAbeja2"><input name="TxtCorreo" type="text" id="TxtCorreo9" style="width:200" value="<? echo $TxtCorreo ; ?>" maxlength="50"></td>
                  <td class="FilaAbeja2">Telefono</td>
                  <td class="FilaAbeja2"><input name="TxtFono" type="text" id="TxtFono3" style="width:150" value="<? echo $TxtFono ; ?>" maxlength="50"></td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Mutual Seguridad </td>
                  <td class="FilaAbeja2"><SELECT name="CmbMutuales" >
                      <option value="-1" class="NoSelec">Seleccionar / Agregar</option>
                      <?
			  $Consulta = "SELECT * from sget_mutuales_seg where estado='1' order by descripcion ";			
			  $Resp3=mysqli_query($link, $Consulta);
			  while ($Fila3=mysql_fetch_array($Resp3))
			  {
				if ($CmbMutuales==$Fila3["cod_mutual"])
					echo "<option SELECTed value='".$Fila3["cod_mutual"]."'>".ucfirst($Fila3["abreviatura"])."</option>\n";
				else
					echo "<option value='".$Fila3["cod_mutual"]."'>".ucfirst($Fila3["abreviatura"])."</option>\n";
			  }
			 ?>
                    </SELECT> &nbsp;<a href="JavaScript:Proceso('Mut')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a><span class="InputRojo">(*)</span></td>
                  <td class="FilaAbeja2">Nro.Regic.</td>
                  <td class="FilaAbeja2"><input name="TxtNroRegic" type="text" id="TxtNroRegic" style="width:150" value="<? echo $TxtNroRegic ; ?> " maxlength="50"></td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Fecha Ven. Cert.</td>
                  <td width="148" class="FilaAbeja2" ><input name="TxtFechaCert" type="text" readonly   size="10" value="<? echo $TxtFechaCert; ?>" > 
                    &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaCert,TxtFechaCert,popCal);return false"></td>
                  <td width="138" class="FilaAbeja2" >Nro.Registro </td>
                  <td width="291" class="FilaAbeja2"><input name="TxtNroRegistro" type="text" id="TxtNroRegistro" style="width:150" value="<? echo $TxtNroRegistro ; ?> " maxlength="50"></td> 
                    
		  
                </tr>
                <?
              /*  <tr> 
              
			     <td height="28" class="FilaAbeja2">Estado</td>
                  <td colspan="3" class="FilaAbeja2"><SELECT name="CmbEstado" >
                  <option value="-1" class="NoSelec">Seleccionar</option>
                      
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEstado==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			*/?>
                <?
                 //   </SELECT> <span class="InputRojo">(*)</span></td>
                //</tr>
				?>
                <tr> 
                  <td  colspan="4" class="TituloTablaVerde">Datos Representante 
                    Principal </td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Representante Legal Principal 
                  </td>
                  <td class="FilaAbeja2"><input name="TxtRep1" type="text" id="TxtRep13" style="width:200" value="<? echo $TxtRep1 ; ?>" maxlength="50"></td>
                  <td class="FilaAbeja2">E-Mail</td>
                  <td class="FilaAbeja2"><input name="TxtMailRep1" type="text" id="TxtMailRep13" style="width:150" value="<? echo $TxtMailRep1 ; ?>" maxlength="50"></td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Telefono </td>
                  <td class="FilaAbeja2"><input name="TxtFonoRep1" type="text" id="TxtFonoRep13" style="width:100" value="<? echo $TxtFonoRep1 ; ?>" maxlength="10"></td>
                  <td class="FilaAbeja2">Celular</td>
                  <td class="FilaAbeja2"><input name="TxtCelRep1" type="text" id="TxtCelRep13" style="width:100" value="<? echo $TxtCelRep1 ; ?>" maxlength="20"></td>
                </tr>
                <tr> 
                  <td colspan="4" class="TituloTablaVerde">Datos Personas de Contacto 
                  </td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Nombre</td>
                  <td class="FilaAbeja2"><input name="TxtRep2" type="text"  style="width:200" value="<? echo $TxtRep2 ; ?>" maxlength="50"></td>
                  <td class="FilaAbeja2">Cargo</td>
                  <td class="FilaAbeja2"><input name="TxtCelRep2" type="text" id="TxtCelRep23" style="width:150" value="<? echo $TxtCelRep2 ; ?>" maxlength="50"></td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">E-Mail</td>
                  <td class="FilaAbeja2"><input name="TxtMailRep2" type="text"  style="width:150" value="<? echo $TxtMailRep2 ; ?>" maxlength="50"></td>
                  <td class="FilaAbeja2">Telefono</td>
                  <td class="FilaAbeja2"><input name="TxtFonoRep2" type="text"  style="width:100" value="<? echo $TxtFonoRep2 ; ?>" maxlength="10"></td>
                </tr>
                <tr> 
				
				 <table width="100%" align="center" cellpadding="2" border="1" cellspacing="0">
                  <tr>
                  <td width="147" align="left" class="TituloTablaVerde">Contratos Vigentes
				<?
			
						
						$Consulta= "SELECT * from sget_contratos t1 left join  proyecto_modernizacion.sub_clase t2"; 
						$Consulta.= " on t1.estado=t2.cod_subclase and t2.cod_clase='30007'";
					 	$Consulta.= " where t1.rut_empresa='".$TxtRutPrv."' and t1.estado = 1";
				  		$RespC=mysqli_query($link, $Consulta);
			  			while  ($FilaC=mysql_fetch_array($RespC))
			  			{
							echo "<tr align='center'>";
							echo "<td align='left'>".$FilaC["cod_contrato"]."-".$FilaC["descripcion"]."</td>";
							echo "</tr>";
						}
					?>
					</td>
             </tr>    
			 </table>
				
				




                </tr>
                <tr> 
                  <td height="28" colspan="4" class="FilaAbeja2"><span class="InputRojo">(*) 
                    Datos Obligatorios</span></td>
                </tr>
              </table></td>
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
<? if($Opc=='M')
{
?>
<? 
}
?>
<input name="TxtRutO" type="hidden"   value="<? echo $Valores ; ?>">
  <input name="TxtTieneReq" type="hidden"   value="<? echo $TieneReq ; ?>">
  <input name="TxtGrupoU" type="hidden"   value="<? echo $TxtGrupoU ; ?>">
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Empresa  ya Existe');";
	echo "</script>";
?>