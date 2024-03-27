<?
 	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	if(!isset($CertAnt))
	{
		$CertAnt='checked';
		$CertAnt2='';	
	}
	if(!isset($Estado1))
	{
		$Estado1='checked';
		$Estado2='';	
	}
	if(!isset($TxtTarj))
		$TxtTarj=0;
	switch ($Proceso)
	{
		case "M":
			$Datos=explode('~',$Valores);
			$Consulta="SELECT * from sget_personal where rut='".$Valores."'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysql_fetch_array($Resp))
			{
				$TxtRut=$Fila["rut"];					
				$TxtNom=$Fila["nombres"];
				$TxtPat=$Fila[ape_paterno];
				$TxtMat=$Fila[ape_materno];
				$Empresa=$Fila[rut_empresa];
				$Contrato=$Fila["cod_contrato"];
				
			}
			$Consulta="SELECT * from sget_comparacion_sueldo where rut_funcionario ='".$TxtRut."' and cod_contrato='".$Contrato."' and rut_empresa='".$Empresa."'";
			$RespMontos=mysqli_query($link, $Consulta);
			if($FilaMontos=mysql_fetch_array($RespMontos))
			{
				$EcoSI=number_format($FilaMontos[eco_si],0,'','');
				$CttoSI=number_format($FilaMontos[ctto_si],0,'','');
				$DifSI=abs($FilaMontos[eco_si]-$FilaMontos[ctto_si]);
				$EcoSB=number_format($FilaMontos[eco_sb],0,'','');
				$CttoSB=number_format($FilaMontos[ctto_sb],0,'','');
				$DifSB=abs($FilaMontos[eco_sb]-$FilaMontos[ctto_sb]);
				$EcoSL=number_format($FilaMontos[eco_sl],0,'','');
				$CttoSL=number_format($FilaMontos[ctto_sl],0,'','');
				$DifSL=abs($FilaMontos[eco_sl]-$FilaMontos[ctto_sl]);
			}
				
			
			
			break;
	
	}
	//$Proceso='';
?>
<html>
<head>
<title>
Comparacion Sueldo 
</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function TeclaPulsada1(tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 


		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		
} 
function CalcDif(Input1,Input2,Input3)
{
	var f = document.frmPrincipal;
	var Valor1=Input1.value.replace(/\./g,'');
	var Valor2=Input2.value.replace(/\./g,'');
	
	//alert(Math.abs(Valor1-Valor2));
	Input3.value=(Math.abs(Valor1-Valor2));
	PoneMiles(Input3,Input3.value);
	//alert(Valor1);
	//alert(Valor2);
}
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	var Est='';
	var Cert='';
	//alert(TipoProceso);
	switch(TipoProceso)
	{
	
		case "G": 
			f.action='sget_comparacion_sueldo_proceso01.php?Proc=G';
			f.submit();
		break;	
					
		case 'S'://SALIR
			window.close();
			break;
	
	}
}
function BuscarEmp()
{
	var f = document.frmPrincipal;
	
	var Est1='';
	var Est2='';
	var CertAnt1='';
	var CertAnt2='';
	//alert(f.OptEst[0].checked);
	if(f.OptCert[0].checked==true)
		CertAnt1='checked';//CON CERT.ANT
	else
		CertAnt2='checked';//SIN CERT.ANT
	if(f.OptEst[0].checked==true)
		Est1='checked';
	else	
		Est2='checked';
	f.action='sget_mantenedor_personal_proceso.php?BuscarEmp=S&Estado1='+Est1+'&Estado2='+Est2+'&CertAnt='+CertAnt1+'&CertAnt2='+CertAnt2;
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post" enctype="multipart/form-data" >
<input type="hidden" name="Proceso" value="<? echo $Proceso;?>">
<input type="hidden" name="Valores" value="<? echo $Valores;?>">
<table width="90%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">

  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15" /></td>
    <td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="74%" align="left"><img src="archivos/sub_tit_sueldo_n.png"></td>
          <td align="right">
			<a href="JavaScript:Procesos('G')"><img src="archivos/btn_guardar.png"  border="0"  alt=" Grabar " align="absmiddle"></a>
           <a href="JavaScript:Procesos('S')"><img src="archivos/close.png"  border="0"  alt=" Volver " align="absmiddle"></a>
		    </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td colspan="3"align="center" class="TituloTablaVerde"></td>
        </tr>
        <tr>
          <td width="1%" align="center" class="TituloTablaVerde"></td>
          <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td colspan="6"align="center" class="TituloTablaNaranja">Datos Persona</td>
            </tr>
            <tr >
              <td width="121" rowspan="4" class="formulario"><img src='fotos/<? echo $TxtRut;?>.jpg' width='112' height='98' border='0' align='absmiddle'></td>
              <td width="55" colspan="1" align="left"  class="formulario">Rut:</td>
              <td width="476" align="left"><input type="hidden" name="TxtRut" value="<? echo $TxtRut;?>">
                  <? echo $TxtRut;?></td>
            </tr>
            <tr >
              <td align="left"  class="formulario" colspan="1">Nombre:</td>
              <td align="left"><? echo $TxtNom."&nbsp;".$TxtPat."&nbsp;".$TxtMat;?></td>
            </tr>
            <tr >
              <td colspan="1"  class="formulario" align="left">Empresa:&nbsp; </td>
              <td align="left"><input type="hidden" name="Empresa" value="<? echo $Empresa;?>">
                  <?
				$Consulta="SELECT * from sget_contratistas where rut_empresa='".$Empresa."' ";
				$RespEmp=mysqli_query($link, $Consulta);
				if($FilaEmp=mysql_fetch_array($RespEmp))
				{
					echo $FilaEmp[razon_social];
					
				}
			
			?></td>
            </tr>
            <tr >
              <td colspan="1"  class="formulario" align="left">Contrato:</td>
              <td align="left"><input type="hidden" name="Contrato" value="<? echo $Contrato;?>">
                  <? echo $Contrato;?></td>
            </tr>
            <tr >
              <td colspan="3" align="center" ><table width="100%" cellpadding="0" cellspacing="1" border="1">
                  <tr>
                    <td colspan="4" align="center" class="TituloTablaNaranja">Comparaci&oacute;n de Sueldo </td>
                  </tr>
                  <tr>
                    <td width="33%" align="center" class="TituloCabecera">ITEM</td>
                    <td width="30%" align="center" class="TituloCabecera">ECO04</td>
                    <td width="37%" align="center" class="TituloCabecera">CONTRATO</td>
                    <td width="37%" align="center" class="TituloCabecera">DIFERENCIA</td>
                  </tr>
                  <tr>
                    <td  >Sueldo Imponible</td>
                    <td align="center"><input type="text" name="EcoSI" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($EcoSI,0,'','.');?>" onKeyDown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" onBlur="CalcDif(EcoSI,CttoSI,DifSI);"></td>
                    <td  align="center"><input type="text" name="CttoSI" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($CttoSI,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" onBlur="CalcDif(EcoSI,CttoSI,DifSI);"></td>
                    <td  align="center"><input type="text" name="DifSI" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($DifSI,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" readonly></td>
                  </tr>
                  <tr>
                    <td >Sueldo Bruto</td>
                    <td align="center"><input type="text" name="EcoSB" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($EcoSB,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" onBlur="CalcDif(EcoSB,CttoSB,DifSB);"></td>
                    <td align="center"><input type="text" name="CttoSB" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($CttoSB,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" onBlur="CalcDif(EcoSB,CttoSB,DifSB);"></td>
                    <td align="center"><input type="text" name="DifSB" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($DifSB,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" readonly></td>
                  </tr>
                  <tr>
                    <td >Sueldo Liquido</td>
                    <td align="center"><input type="text" name="EcoSL" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($EcoSL,0,'','.');;?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" onBlur="CalcDif(EcoSL,CttoSL,DifSL);"></td>
                    <td align="center"><input type="text" name="CttoSL" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($CttoSL,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" onBlur="CalcDif(EcoSL,CttoSL,DifSL);"></td>
                    <td align="center"><input type="text" name="DifSL" maxlength="20" size="20"  class="InputIzq"  value="<? echo number_format($DifSL,0,'','.');?>"  onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))" readonly></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
          <td width="0%" align="center" class="TituloTablaVerde"></td>
        </tr>
        <tr>
          <td colspan="3"align="center" class="TituloTablaVerde"></td>
        </tr>
      </table>
      <br></td>
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