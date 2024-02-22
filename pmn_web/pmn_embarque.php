<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");		

	if(isset($_REQUEST["Rec"])){
		$Rec = $_REQUEST["Rec"];
	}else{
		$Rec = "";
	}
	if(isset($_REQUEST["RecT"])){
		$RecT = $_REQUEST["RecT"];
	}else{
		$RecT = "";
	}
  if(isset($_REQUEST["Tipo"])){
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
	}

  if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = "";
	}
	
	if(isset($_REQUEST["Corr"])){
		$Corr = $_REQUEST["Corr"];
	}else{
		$Corr = "";
	}
  if(isset($_REQUEST["CorrEs"])){
		$CorrEs = $_REQUEST["CorrEs"];
	}else{
		$CorrEs = "";
	}


	//echo "hora: minuto   ".date('H:i')."<br>";
	if(date('H:i')>="00:00" and date('H:i')<="07:59")
	{
		$Fecha=date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));	
		$DiaMesAno=explode('-',$Fecha);
		$Dia=$DiaMesAno[2];
		$Mes=$DiaMesAno[1];
		$Ano=$DiaMesAno[0];
		$dia1=$DiaMesAno[2];
		$mes1=$DiaMesAno[1];
		$ano1=$DiaMesAno[0];
	//echo "fecha salida de server:    ".$Fecha."<br>";
	}
	else
	{
		$Dia=date('d');
		$Mes=date('m');
		$Ano=date('Y');
		$dia1=date('d');
		$mes1=date('m');
		$ano1=date('Y');
	}
?>
<html>
<head>
<title>Acceso Principal PMN</title>
<script language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function SalirRpt()
{
var f=document.frmPrincipalRpt;
f.action="../principal/sistemas_usuario.php?CodSistema=6";
f.submit();
}
function Pantalla(Pant)
{
var f=document.frmPrincipalConsulta;
f.action=Pant;
f.submit();
}
</script>
</head>
<body topmargin="5">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<form name="frmPrincipalRpt" method="post" action="">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td ><img src="archivos/images/interior/esq3.png"/></td>
      <td colspan="3" background="archivos/images/interior/arriba.png"></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png"><img src="archivos/images/interior/esq2.png" /></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
      <td width="19%"><img src="archivos/logo_sup.jpeg"/></td>
      <td width="74%" align="left" valign="bottom"  bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><strong><h5>Embarque BAD</h5></strong></td>
      <td width="4%" align="right" bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><a href="JavaScript:SalirRpt('')" class="LinkPestana" ><img src="archivos/btn_volver2.png" class="SinBorde"/></a></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">
		  <table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" bgcolor="#F7F2EB">
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td colspan="5" ><img src="archivos/images/interior/transparent.gif" width="4" /></td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td colspan="5" rowspan="4" align="center" valign="top">
			<?php 
				include('pmn_ing_embarque.php');
			?>									
			</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
	
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td width="12"><img src="archivos/images/interior/esq1.png"/></td>
          <td height="1" colspan="5" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut,$link)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut,$link)."&nbsp;</SPAN>";?></td>
          <td width="18"><img src="archivos/images/interior/esq4.png"  /></td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
