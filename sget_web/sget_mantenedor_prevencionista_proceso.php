<? include("../principal/conectar_sget_web.php");
	if(!isset($CmbClase))
		$CmbClase="-1";
	if($BuscaPer=='S')
	{
		$Consulta="SELECT * from sget_personal where rut = '".$Rut."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			//$TxtRutPrv=substr(str_pad($Fila["rut_prev"],10,'0',l_pad),0,10);				
			$TxtRutPrv=$Fila["rut"];				
			$TxtDv=substr(str_pad($Fila["rut"],12,'0',l_pad),11,1);
			$TxtNombres=$Fila["nombres"];
			$TxtApellidoPaterno=$Fila["ape_paterno"];
			$TxtApellidoMaterno=$Fila["ape_materno"];
			$TxtDireccion=$Fila["direccion"];
			$TxtFono=$Fila["telefono1"];
			$TxtCelular=$Fila["telefono2"];
			$CmbEstado=$Fila["estado"];
			$TxtTitulo=$Fila["titulo"];
			//$TxtTipoCont=$Fila["tipo_contrato"];
			$Consulta="SELECT t1.cod_contrato,t2.descripcion from sget_personal t1 inner join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato where rut='".$TxtRutPrv."'";
			$Resp1=mysql_query($Consulta);
			if($Fila1=mysql_fetch_array($Resp1))
			{
				$TxtTipoCont=$Fila1["cod_contrato"]." - ".$Fila1["descripcion"];
			}
		}
	}
	else
	{
			
		if ($Opc=='M')
		{
			if(!isset($Valores))
				$RutReq=$TxtRutPrv."-".$TxtDv;
			else
				$RutReq=$Valores;
			$Consulta="SELECT * from sget_prevencionistas where rut_prev = '".$RutReq."'";
			//echo $Consulta;
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				//$TxtRutPrv=substr(str_pad($Fila["rut_prev"],10,'0',l_pad),0,10);
				$TxtRutPrv=$Fila["rut_prev"];
				$TxtDv=substr(str_pad($Fila["rut_prev"],12,'0',l_pad),11,1);
				$TxtNombres=$Fila["nombres"];
				$TxtApellidoPaterno=$Fila["apellido_paterno"];
				$TxtApellidoMaterno=$Fila["apellido_materno"];
				$TxtNroRegistro=$Fila["nro_registro"];
				$TxtDireccion=$Fila["direccion"];
				$TxtFono=$Fila["telefono"];
				$CmbEstado=$Fila["estado"];
				$TxtCelular=$Fila["celular"];
				$TxtEmail1=$Fila["email_1"];
				$TxtEmail2=$Fila["email_2"];
				$TxtTitulo=$Fila["titulo"];
				//$TxtJornadaAse=$Fila["tipo_jornada"];
				$Observacion=$Fila["observacion"];
				$SeparoRegis=explode('~',$Fila[regis_sns_serg]);
				$TxtSerga=$SeparoRegis[0];
				$TxtSNS=$SeparoRegis[1];
				$DocSernageomin=$Fila[res_serna];
				$DocSNS=$Fila[res_sns];
				$DocCurri=$Fila[curriculum];
				$DocTitulo=$Fila[titulo_prof];
				
				$Consulta="SELECT t1.cod_contrato,t2.descripcion from sget_personal t1 inner join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato where rut='".$TxtRutPrv."'";
				$Resp1=mysql_query($Consulta);
				if($Fila1=mysql_fetch_array($Resp1))
				{
					$TxtTipoCont=$Fila1["cod_contrato"]." - ".$Fila1["descripcion"];
				}
			}
		}

	}
?>
<html>
<head>
<?
	if ($Opc=='N')
		$VarTitulo='Nuevo Prevencionista';
	else	
		$VarTitulo='Modifica Prevencionista';
	echo "<title>$VarTitulo</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">


function Proceso(Opcion,Cont)
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
				f.action = "sget_mantenedor_prevencionista01.php?Opcion="+Opcion; 
				f.submit();
			}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "sget_mantenedor_prevencionista01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "R":
			f.action = "sget_mantenedor_prevencionista_proceso.php?Opcion="+Opcion+"&CmbClase="+f.CmbClase.value+"&Rec=S";
			f.submit();
		break;
		case "GJor":
			var Jornada='';
			for(i=0;i<f.elements.length;i++)
			{
				if(f.elements[i].name=='Contrato'+Cont+'')
				{
					if(f.elements[i].value=='')
					{
						alert('Debe Ingresar Tipo Jornada para Contrato '+Cont+'')
						return;
					}
					else
						Jornada=f.elements[i].value;
				}	
			}
			f.action = "sget_mantenedor_prevencionista01.php?Opcion="+Opcion+"&Contrato="+Cont+"&Jorn="+Jornada;
			f.submit();
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
		
	
	if (f.TxtNombres.value=="")
	{
		alert("Debe Ingresar Nombres");
		f.TxtNombres.focus();
		Res=false;
		return;
	}
	if (f.TxtApellidoPaterno.value=="")
	{
		alert("Debe Ingresar Apellido Paterno");
		f.TxtApellidoPaterno.focus();
		Res=false;
		return;
	}
	if (f.TxtApellidoMaterno.value=="")
	{
		alert("Debe Ingresar Apellido Materno");
		f.TxtApellidoMaterno.focus();
		Res=false;
		return;
	}
/*	if(f.CmbClase.value=='-1')
	{
		alert("Debe Seleccionar Clase");
		return;
	}
*/
	if(f.CmbEstado.value=='-1')
	{
		alert("Debe Seleccionar Estado");
		return;
	}
	return(Res);
}
function EliminaDoc(Rut,Tipo,Doc)
{
	var f=document.FrmProceso;
	f.action = "sget_mantenedor_prevencionista01.php?Opcion=ELDOC&Rut="+Rut+"&Doc="+Doc+"&Tipo="+Tipo;
	f.submit();
}
function VerificaPer()
{
	var f=document.FrmProceso;
	f.action = "sget_mantenedor_prevencionista_proceso.php?Opc="+f.Opc.value+"&Rut="+f.TxtRutPrv.value+"&BuscaPer=S";
	f.submit();
}
</script>
</head>
<?
if ($Opc=='N')
{
	if($BuscaPer!='S')
		echo '<body onLoad="document.FrmProceso.TxtRutPrv.focus();">';
	else
		echo '<body onLoad="document.FrmProceso.TxtNombres.focus();">';	
}	
else
	echo '<body onLoad="document.FrmProceso.TxtNombres.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmProceso" method="post" enctype="multipart/form-data">
<input name="Opc" type="hidden" value="<? echo $Opc; ?>">
<input name="Volver" type="hidden" value="<? echo $Volver; ?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="848" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="archivos/sub_tit_prev_n.png"><? }else{?><img src="archivos/sub_tit_prev_m.png"><?	}?></td>
       <td align="right"><a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td class="formulario2">Rut</td>
           <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
           <td class="formulariosimple" ><?
			 if ($Opc=='N')
			 {
			  	echo '<input name="TxtRutPrv" type="text"  value="'.$TxtRutPrv.'" size="12" maxlength="10" onblur="javascript:VerificaPer();">';
			 }
			 else
			 {
			 	echo '<input name="TxtRutPrv" type="text"   readonly  value="'.$TxtRutPrv.'" size="12" maxlength="10">';
			 }
			 ?>
            	(Ej: 12345678-6, Sin Puntos '.')  </td>
         </tr>
         <tr>
           <td width="280" class="formulario2">Nombres </td>
           <td width="821" class="formulariosimple" ><input name="TxtNombres" type="text" id="TxtNombres" style="width:350" value="<? echo $TxtNombres; ?>" >
               <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Apellido Paterno </td>
           <td class="formulariosimple" ><input name="TxtApellidoPaterno" type="text" id="TxtApellidoPaterno" style="width:350" value="<? echo $TxtApellidoPaterno; ?>" >
             <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Apellido Materno </td>
           <td class="formulariosimple" ><input name="TxtApellidoMaterno" type="text" id="TxtApellidoMaterno" style="width:300" value="<? echo $TxtApellidoMaterno; ?>">
             <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Direcci&oacute;n</td>
           <td class="formulariosimple" ><input name="TxtDireccion" type="text" id="TxtDireccion" style="width:300" value="<? echo $TxtDireccion ; ?>"></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Telefono 1 </td>
           <td class="formulariosimple" ><input name="TxtFono" type="text" id="TxtFono" style="width:200" value="<? echo $TxtFono ; ?>"></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Telefono 2 </td>
           <td class="formulariosimple" ><input name="TxtCelular" type="text" id="TxtCelular" style="width:200" value="<? echo $TxtCelular; ?>"></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Correo 1 </td>
           <td class="formulariosimple" ><input name="TxtEmail1" type="text" id="TxtEmail1" style="width:200" value="<? echo $TxtEmail1 ; ?>"></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Correo 2</td>
           <td class="formulariosimple" ><input name="TxtEmail2" type="text" id="TxtEmail2" style="width:200" value="<? echo $TxtEmail2; ?>"></td>
         </tr>
<!--         <tr>
           <td height="25" class="formulario2">Jornada Asesoria </td>
           <td colspan="2" class="formulariosimple" ><input name="TxtJornadaAse" type="text" id="TxtJornadaAse" style="width:200" value="<? //echo $TxtJornadaAse; ?>"></td>
         </tr>-->
         <tr>
           <td height="25" class="formulario2">Titulo Profesional </td>
           <td class="formulariosimple" ><input name="TxtTitulo" type="text" id="TxtTitulo" style="width:400" value="<? echo $TxtTitulo ; ?>"><br>
		   <?
		   		if($DocTitulo=='')
				{
					echo "<input name='DocTitulo' size='60' type='file'>";
					echo "<input type='hidden' name='DocTitulo2' value='N'>";
				}	
				else	
				{
					echo "<input type='hidden' name='DocTitulo' value='".$DocTitulo."'>";
					echo "<input type='hidden' name='DocTitulo2' value='S'>";
			   		echo "<a href=doc/".$DocTitulo." target='_blank'>".$DocTitulo ."</a><a href=JavaScript:EliminaDoc('".$TxtRutPrv."','T','".$DocTitulo."')><img src='archivos/elim_hito2.png' width='15' height='17' class='SinBorde'></a>";
				}
		   ?>
		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Curriculum</td>
           <td class="formulariosimple" >
		   <?
		   		if($DocCurri=='')
				{
					echo "<input name='DocCurri' size='60' type='file'>";
					echo "<input type='hidden' name='DocCurri2' value='N'>";
				}	
				else	
				{
					echo "<input type='hidden' name='DocCurri' value='".$DocCurri."'>";
					echo "<input type='hidden' name='DocCurri2' value='S'>";
			   		echo "<a href=doc/".$DocCurri."  target='_blank'>".$DocCurri ."</a><a href=JavaScript:EliminaDoc('".$TxtRutPrv."','C','".$DocCurri."')><img src='archivos/elim_hito2.png' width='15' height='17' class='SinBorde'></a>";
				}
		   ?>
		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Contrato</td>
           <td class="formulariosimple" ><? echo $TxtTipoCont; ?></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Registro Sernageomin </td>
           <td class="formulariosimple" ><label>
             <input name="TxtSerga" type="text" id="TxtSerga" value="<? echo $TxtSerga;?>">
           </label>
		   <?
		   		if($DocSernageomin=='')
				{
					echo "<input name='DocSerna' size='60' type='file'>";
					echo "<input type='hidden' name='DocSerna2' value='N'>";
				}	
				else	
				{
					echo "<input type='hidden' name='DocSerna' value='".$DocSernageomin."'>";
					echo "<input type='hidden' name='DocSerna2' value='S'>";
			   		echo "<a href=doc/".$DocSernageomin."  target='_blank'>".$DocSernageomin ."</a><a href=JavaScript:EliminaDoc('".$TxtRutPrv."','Se','".$DocSernageomin."')><img src='archivos/elim_hito2.png' width='15' height='17' class='SinBorde'></a>";
		   		}	
		   ?>		   
		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Registro SNS </td>
           <td class="formulariosimple" ><label>
			<input name="TxtSNS" type="text" id="TxtSNS" value="<? echo $TxtSNS;?>">
           </label>
		   <?
		   		if($DocSNS=='')
				{
					echo "<input name='DocSNS' size='60' type='file'>";
					echo "<input type='hidden' name='DocSNS2' value='N'>";
				}	
				else	
				{
					echo "<input type='hidden' name='DocSNS' value='".$DocSNS."'>";
					echo "<input type='hidden' name='DocSNS2' value='S'>";
			   		echo "<a href=doc/".$DocSNS." class='LinkSinLinea'>".$DocSNS ."</a><a href=JavaScript:EliminaDoc('".$TxtRutPrv."','SN','".$DocSNS."')><img src='archivos/elim_hito2.png' width='15' height='17' class='SinBorde'></a>";
				}
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Estado</td>
           <td class="formulariosimple" ><SELECT name="CmbEstado" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEstado==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
           </SELECT>
             <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Observaci&oacute;n</td>
           <td height="25" class="formulario2"><label>
             <textarea name="Observacion" cols="70" rows="4"><? echo $Observacion;?></textarea>
           </label></td>
           </tr>
         <tr>
           <td height="25" colspan="2" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
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
    <td width="1" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="1" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table><br>
  <?
  if($Opc=='M')
  {
  ?>
  <table width="90%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="ColorTabla02">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
      <td width="1056" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
      <td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
          <tr>
            <td width="100%" align="center" class="TituloTablaVerde">Contratos Relacionados </td>
          </tr>

          <tr>
            <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
                  <tr>
                    <td width="2%" align="center" class="TituloCabecera">&nbsp;</td>
                    <td width="11%" align="center" class="TituloCabecera">N� Contrato</td>
                    <td width="44%" align="center" class="TituloCabecera">Descripci&oacute;n</td>
                    <td width="31%" align="center" class="TituloCabecera">Empresa </td>
                    <td width="12%" align="center" class="TituloCabecera">Fecha&nbsp;T�rmino</td>
                    <td width="12%" align="center" class="TituloCabecera">D&iacute;as y Horas de Asesor&iacute;a </td>
                  </tr>
				  <?
				  $Consulta="SELECT * from sget_contratos where rut_prev='".$TxtRutPrv."'  order by fecha_termino desc,descripcion";				  
				  $Resp=mysql_query($Consulta);$Cont=1;$ContNV=0;$ContV=0;
				  while($Filas=mysql_fetch_array($Resp))
				  {
				  		
					  $CEMP="SELECT * from sget_contratistas where rut_empresa='".$Filas[rut_empresa]."'";
					  $REMP=mysql_query($CEMP);
					  $FEMP=mysql_fetch_array($REMP);
					  $NomEmp=$FEMP[razon_social];
					  $Span='';
					  $Blokeo='';
					  $Guardar="<a href=JavaScript:Proceso('GJor','".$Filas["cod_contrato"]."')><img src='archivos/btn_guardar.png' alt='Guardar'  border='0' align='absmiddle' /></a>";
					  if($Filas[fecha_termino] < date('Y-m-d'))
					  {
					  	$Span='class=InputRojo';
						$ContNV++;
						$Blokeo='disabled=disabled';
						$Guardar='';
					  }	
					  if($Span=='')
					  	$ContV++;
					  ?>
					  <tr>
						<td align="left"><span <? echo $Span;?>><? echo $Cont;?></span></td>
						<td align="left"><span <? echo $Span;?>><? echo $Filas["cod_contrato"];?></span></td>
						<td align="left"><span <? echo $Span;?>><? echo $Filas["descripcion"];?>&nbsp;</span></td>
						<td align="left"><span <? echo $Span;?>><? echo $NomEmp;?>&nbsp;</span></td>
						<td align="left"><span <? echo $Span;?>><? echo $Filas[fecha_termino];?>&nbsp;</span></td>
						<td align="left"><input  type="text" name="Contrato<? echo $Filas["cod_contrato"];?>" <? echo $Blokeo;?> maxlength="45" size="40" value="<? echo $Filas[tipo_jornada];?>">&nbsp;<? echo $Guardar;?>
						</td>
					  </tr>
					  <?
					  $Cont++;
				  }
				  ?>
				  <tr >
				  	<td class="TituloTablaVerde" colspan="6">Contratos Vigentes: <? echo $ContV?></td>
				  </tr>
				  <tr>	
				  	<td class="TituloTablaVerde" colspan="6">Contratos no Vigentes: <? echo $ContNV?></td>
				  </tr>
              </table>
			  </td>
          </tr>
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
      <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <?
  }
  ?>
  <p>
    <input name="TxtRutO" type="hidden"   value="<? echo $Valores ; ?>">
    <!--<input name="TxtTieneReq" type="hidden"   value="<? echo $TieneReq ; ?>">
  <input name="TxtGrupoU" type="hidden"   value="<? echo $TxtGrupoU ; ?>">-->
    </p>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Prevencionista  ya Existe');";
	if($Msj=='Jor')	
		echo "alert('Jornada Ingresada con �xito');";
	if($Msj=='DocE')	
		echo "alert('Documento Eliminado con �xito');";
	echo "</script>";
?>