<?
 	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	if($Buscar =='S')
	{
		if(isset($Empresa))
		{
			$RutPer=$Empresa;
			$TxtRutPer=substr($Empresa,0,8);
			$TxtDv=substr($Empresa,9,1);
		}
		else
			$RutPer=$TxtRutPer.'-'.$TxtDv;
		$Consulta="SELECT * from sget_personal where rut='$RutPer'";
		$RespPer=mysqli_query($link, $Consulta);
		if($FilaPer=mysql_fetch_array($RespPer))
		{
			$TxtPat=$FilaPer[ape_paterno];
			$TxtMat=$FilaPer[ape_materno];
			$TxtNom=$FilaPer["nombres"];
			$TxtFechaNac=$FilaPer[fec_nac];
			$CmbCargo=$FilaPer[cargo];
			$TxtDireccion=$FilaPer["direccion"];
			$CmbCiudad=$FilaPer["cod_ciudad"];
			$TxtTarj=$FilaPer[nro_tarjeta];
			$CmbAfp=$FilaPer[cod_afp];
			$CmbSindicato=$FilaPer[cod_sindicato];
			$Cert=$FilaPer[certificado_ant];
			$TxtFechaTermino=$FilaPer[fecha_certif];
		}
		else
		{
			$TxtPat='';
			$TxtMat='';
			$TxtNom='';
			$TxtFechaNac='';
			$CmbCargo='';
			$TxtDireccion='';
			$CmbCiudad='';
			$TxtTarj='';
			$CmbAfp='';
			$CmbSindicato='';
			$Cert='';
			$TxtFechaTermino='';
			//LimpiarVar();
		}
	}
	else
	{
		$TxtPat='';
		$TxtMat='';
		$TxtNom='';
		$TxtFechaNac='';
		$CmbCargo='';
		$TxtDireccion='';
		$CmbCiudad='';
		$TxtTarj='';
		$CmbAfp='';
		$CmbSindicato='';
		$Cert='';
		$TxtFechaTermino='';
	}	
?>
<html>
<head>
<title>
	Personal de Nomina 
</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	var Est='';
	var Cert='';
	//alert(TipoProceso);
	switch(TipoProceso)
	{
		case 'AG'://GRABAR PERSONA
			if(f.TxtRutPer.value == '')
			{
				alert("Debe Ingresar Rut");
				f.TxtRutPer.focus();
				return;
			}
			
			if(f.TxtNom.value == '')
			{
				alert("Debe Ingresar Nombre");
				f.TxtNom.focus();
				return;
			}
			if(f.TxtPat.value == '')
			{
				alert("Debe Ingresar Apellido Paterno");
				f.TxtPat.focus();
				return;
			}
			if(f.TxtMat.value == '')
			{
				alert("Debe Ingresar Apellido Materno");
				f.TxtMat.focus();
				return;
			}
			if(f.TxtFechaNac.value=='')
			{
				alert("Debe Fecha Ingresar de Nacimiento");
				f.TxtFechaNac.focus();
				return;			
			}
						
			if(f.TxtTarj.value == '')
			{
				alert("Debe Ingresar Tarjeta");
				f.TxtTarj.focus();
				return;
			}
			if(f.CmbCargo.value=='S')
			{
				alert("Debe Seleccionar Cargo");
				f.CmbCargo.focus();
				return;
			}
			if(f.TxtDireccion.value == '')
			{
				alert("Debe Ingresar Direcci�n");
				f.TxtDireccion.focus();
				return;
			}
			if(f.radioCert[0].checked==true)
				Cert='S';
			else
				Cert='N';
			f.action='sget_hoja_ruta01.php?Proceso=AN&Cert='+Cert;
			f.submit();
			break;
		case "M": //Modificar registros
			if(f.radioCert[0].checked==true)
				Cert='S';
			else
				Cert='N';
			f.action='sget_hoja_ruta01.php?Proceso=AN&Cert='+Cert;
			f.submit();
			break;	
					
		case 'S'://SALIR
			window.opener.document.FrmProceso.action="sget_hoja_ruta.php?TxtHoja="+f.TxtHoja.value+"&Opt=M&CmbEmpresa="+f.CmbEmpresa.value+"&CmbContrato="+f.CmbContrato.value;
			window.opener.document.FrmProceso.submit();		
			window.close();
			break;
	}
}
function BuscaRut() 
{
	var f=document.frmPrincipal;
	f.action='sget_hoja_ruta_manual.php?Buscar=S';
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo7 {color: #FF0000}
.Estilo11 {
	color: #FF0000;
	font-size: 12px;
	font-weight: bold;
}
.Estilo13 {color: #FF0000; font-size: 11px; }
-->
</style>
</head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post" enctype="multipart/form-data" >
<input type="hidden" name="Proceso" value="<? echo $Proceso;?>">
<input type="hidden" name="Valores" value="<? echo $Valores;?>">
<input type="hidden" name="CmbEmpresa" value="<? echo $CmbEmpresa;?>">
<input type="hidden" name="CmbContrato" value="<? echo $CmbContrato;?>">
<input type="hidden" name="TxtHoja" value="<? echo $TxtHoja;?>">

<table width="70%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">

  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15" /></td>
    <td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td align="center"><table width="491" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
      <tr align="center" bgcolor="#FFFFFF">
        <td width="573" colspan="2" align="right"><? if($Proceso=='M')
			{
			?>
			<a href="JavaScript:Procesos('M')"><img src="archivos/btn_guardar.png"  border="0"  alt=" Modificar " align="absmiddle"></a>
			<!--<a href="JavaScript:Procesos('T')"><img src="archivos/trasp_codelco.png"  border="0"  alt=" Traspasar a Codelco " align="absmiddle"></a>-->
            <?
			 }
			 else
			 {
			 ?>
			<a href="JavaScript:Procesos('AG')"><img src="archivos/btn_guardar.png"  border="0"  alt=" Grabar " align="absmiddle"></a>
            <?
			  }
			  ?>
             <a href="JavaScript:Procesos('S')"><img src="archivos/close.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
      </tr>
    </table>
    <br><table width="490" border="0" cellpadding="3" cellspacing="0">
    <tr>
    <td colspan="3"align="center" class="TituloTablaNaranja">Personal de Nomina
	<td>    </tr>
	<tr align="center" bgcolor="#FFFFFF">
	<td width="165" align="right" class="formulario">Rut:</td>
	<td width="313" colspan="2" align="left"><span class="formulario">
	  <?
		echo "<input name='TxtRutPer' type='text'   value='".$TxtRutPer."' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPer','TxtDv') onKeyDown=\"ValidaIngreso('S',false,this.form,'TxtDv')\">";//Numerico,Decimales,formulario,Salto
			 	echo "-";
                echo "<input name='TxtDv' type='text'   value='".$TxtDv."'  size='3' maxlength='1' onBlur=BuscaRut()  >";
		?>
	  <span class="Estilo7">*</span></span></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Nombre:</td>
        <td align="left"><input name="TxtNom" type="text" value="<? echo $TxtNom;?>" size="40" maxlength="40">
          <span class="Estilo7">*</span></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Apelli. Paterno:</td>
        <td align="left"><input name="TxtPat" type="text" value="<? echo $TxtPat;?>" size="30" maxlength="30">
          <span class="Estilo7">*</span> </td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario"> Apelli. Materno:</td>
        <td align="left"><input name="TxtMat" type="text" value="<? echo $TxtMat;?>" size="30" maxlength="30">
          <span class="Estilo13">*</span></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Fec.Nacimiento:</td>
        <td colspan="2" align="left"><input name="TxtFechaNac" type="text" readonly="readonly"   size="10" value="<? echo $TxtFechaNac; ?>" />
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaNac,TxtFechaNac,popCal);return false" />&nbsp;&nbsp;&nbsp;<span class="Estilo7">*</span></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Cargo:</td>
        <td colspan="2" align="left">
		<SELECT name="CmbCargo">
		<option value="S" SELECTed="SELECTed">Seleccionar</option>
		<?
		$Consulta="SELECT * from sget_cargos order by descrip_cargo";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbCargo==$Fila[cod_cargo])
				echo "<option value='".$Fila[cod_cargo]."' SELECTed>".$Fila[descrip_cargo]."</option>";
			else	
				echo "<option value='".$Fila[cod_cargo]."'>".$Fila[descrip_cargo]."</option>";
		}
		?>
        </SELECT>
		<span class="Estilo11">*</span>	 </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Direcci&oacute;n:</td>
        <td colspan="2" align="left"><span class="formulario">
          <input name="TxtDireccion" type="text" class="InputIzq" id="TxtDireccion" value="<? echo $TxtDireccion; ?>" size="45" maxlength="70" />
          <span class="Estilo7">*</span></span></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Ciudad:</td>
        <td colspan="2" align="left"><SELECT name="CmbCiudad" onChange="Procesos('R')">
          <option value="S" SELECTed="SELECTed">Seleccionar</option>
          <?
		$Consulta="SELECT * from sget_ciudades order by nom_ciudad";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbCiudad==$Fila["cod_ciudad"])
				echo "<option value='".$Fila["cod_ciudad"]."' SELECTed>".$Fila[nom_ciudad]."</option>";
			else	
				echo "<option value='".$Fila["cod_ciudad"]."'>".$Fila[nom_ciudad]."</option>";
		}
		?>
        </SELECT></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Credencial:</td>
        <td colspan="2" align="left"><span class="formulario">
          <input name="TxtTarj" type="text" id="TxtTarj" value="<? echo $TxtTarj;?>" size="18" maxlength="8" />
        </span></td>
      </tr>	  	  
      	
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario">Afp :</td>
        <td colspan="2" align="left"><span class="formulario">
          <SELECT name="CmbAfp" id="CmbAfp">
            <option value="S" SELECTed="SELECTed">Seleccionar</option>
            <?
		$Consulta="SELECT * from sget_afp order by descripcion_afp";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbAfp==$Fila[cod_afp])
				echo "<option value='".$Fila[cod_afp]."' SELECTed>".$Fila[descripcion_afp]."</option>";
			else	
				echo "<option value='".$Fila[cod_afp]."'>".$Fila[descripcion_afp]."</option>";
		}
		?>
          </SELECT>
        </span></td>
      </tr>		        
	  <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario"> Isapre:</td>
        <td colspan="2" align="left"><span class="formulario">
          <SELECT name="CmbIsapre">
            <option value="S" SELECTed="SELECTed">Seleccionar</option>
            <?
			$Consulta="SELECT * from sget_isapre order by descripcion";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if($CmbIsapre==$Fila[cod_isapre])
					echo "<option value='".$Fila[cod_isapre]."' SELECTed>".$Fila["descripcion"]."</option>";
				else	
					echo "<option value='".$Fila[cod_isapre]."'>".$Fila["descripcion"]."</option>";
			}
		  ?>
          </SELECT>
        </span></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right" class="formulario"> Sindicato:</td>
        <td colspan="2" align="left"><span class="formulario">
          <SELECT name="CmbSindicato" id="CmbSindicato">
            <option value="S" SELECTed="SELECTed">Seleccionar</option>
            <?
			$Consulta="SELECT * from sget_sindicato order by descripcion ";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if($CmbSindicato==$Fila[cod_sindicato])
					echo "<option value='".$Fila[cod_sindicato]."' SELECTed>".$Fila["descripcion"]."</option>";
				else	
					echo "<option value='".$Fila[cod_sindicato]."'>".$Fila["descripcion"]."</option>";
			}
		  ?>
          </SELECT>
        </span></td>
      </tr>
      
      
      
      	  
      <tr align="center" >
        <td align="right" class="formulario">Certificado de Antecedentes:</a></td>
        <td colspan="2"  class="formulario" align="left"><?
		  if($Cert == "S")
			{
				?>
SI
  <input name="radioCert" type="radio" class="SinBorde" value="radiobutton" checked="checked" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              NO
              <input name="radioCert" type="radio" class="SinBorde" value="radiobutton" />
              <?
			}
			else
			{
				?>
SI
<input name="radioCert" type="radio" class="SinBorde" value="radiobutton" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              NO
              <input name="radioCert" type="radio" class="SinBorde" value="radiobutton" checked="checked" />
              <?
			}
			?>
&nbsp;<span class="Estilo7">*</span></td>
      </tr>
      <tr align="center" >
        <td align="right" class="formulario">F.Termino Estadia Trabajador: </td>
        <td colspan="2"  class="formulario" align="left"><input name="TxtFechaTermino" type="text" id="TxtFechaTermino" value="<? echo $TxtFechaTermino; ?>"   size="10" readonly="readonly" />
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaTermino,TxtFechaTermino,popCal);return false" /></td>
     <!-- </tr>
      <tr align="center" >
        <td align="right" class="formulario">Observaci&oacute;n:</td>
        <td colspan="2"  class="formulario" align="left"><label>
          <input name="TxtFechaTermino" type="hidden" ></textarea>
        </label></td>
      </tr>-->
      
      
      
      
      
    </table></td>
    <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
</body>
</html>
<?
	//echo "EXISTE RUT:".$Existe."<br>";
	//echo "EXISTE INICIALES:".$Existe2."<br>"; 
	echo "<script languaje='JavaScript'>";
	if ($Existe==true)
	{
		echo "alert('Rut Ingresado ya Existe');";
		echo "document.frmPrincipal.TxtRut.focus();";
	}	
	if ($Existe2==true)
	{
		echo "alert('Iniciales Ingresada ya Existe');";
		echo "document.frmPrincipal.TxtRut.focus();";
	}	
	echo "</script>";
	$Existe=false;$Existe2=false;
	
?>	