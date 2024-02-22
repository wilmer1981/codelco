<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");

  $CookieRut = $_COOKIE["CookieRut"]; 
  //Tab1=true&TabOC=true&VerOro=S&IdDiaOro=05&IdMesOro=05&IdAnoOro=2021&IdFechaOro=2021-05-05
    if(isset($_REQUEST["Tab1"])){
    $Tab1 = $_REQUEST["Tab1"];
  }else{
    $Tab1 = false;
  }
  if(isset($_REQUEST["TabOC"])){
    $TabOC = $_REQUEST["TabOC"];
  }else{
    $TabOC = false;
  }
  if(isset($_REQUEST["VerOro"])){
    $VerOro = $_REQUEST["VerOro"];
  }else{
    $VerOro = "";
  }
  if(isset($_REQUEST["IdDiaOro"])){
    $IdDiaOro = $_REQUEST["IdDiaOro"];
  }else{
    $IdDiaOro = "";
  }
  if(isset($_REQUEST["IdMesOro"])){
    $IdMesOro = $_REQUEST["IdMesOro"];
  }else{
    $IdMesOro = "";
  }
  if(isset($_REQUEST["IdAnoOro"])){
    $IdAnoOro = $_REQUEST["IdAnoOro"];
  }else{
    $IdAnoOro = "";
  }
  if(isset($_REQUEST["IdFechaOro"])){
    $IdFechaOro = $_REQUEST["IdFechaOro"];
  }else{
    $IdFechaOro = "";
  }

  
  //Mostrar=C&CmbDias=12&CmbMes=12&CmbAno=2023&NumBarra=&Peso=200.0000&LeyOro=&PesoOro=&LeyPlata=&PesoPlata=&Observacion=&Correlativo=1772&cmbrut=&Tab1=true&TabOC=true
  if(isset($_REQUEST["Mostrar"])){
    $Mostrar = $_REQUEST["Mostrar"];
  }else{
    $Mostrar = "";
  }
  if(isset($_REQUEST["CmbDias"])){
    $CmbDias = $_REQUEST["CmbDias"];
  }else{
    $CmbDias = "";
  }
  if(isset($_REQUEST["CmbMes"])){
    $CmbMes = $_REQUEST["CmbMes"];
  }else{
    $CmbMes = "";
  }
  if(isset($_REQUEST["CmbAno"])){
    $CmbAno = $_REQUEST["CmbAno"];
  }else{
    $CmbAno = "";
  }
  if(isset($_REQUEST["NumBarra"])){
    $NumBarra = $_REQUEST["NumBarra"];
  }else{
    $NumBarra = "";
  }
  if(isset($_REQUEST["Peso"])){
    $Peso = $_REQUEST["Peso"];
  }else{
    $Peso = "";
  }

  if(isset($_REQUEST["LeyOro"])){
    $LeyOro = $_REQUEST["LeyOro"];
  }else{
    $LeyOro = "";
  }
  if(isset($_REQUEST["PesoOro"])){
    $PesoOro = $_REQUEST["PesoOro"];
  }else{
    $PesoOro = "";
  }
  if(isset($_REQUEST["LeyPlata"])){
    $LeyPlata = $_REQUEST["LeyPlata"];
  }else{
    $LeyPlata = "";
  }
  if(isset($_REQUEST["PesoPlata"])){
    $PesoPlata = $_REQUEST["PesoPlata"];
  }else{
    $PesoPlata = "";
  }
  if(isset($_REQUEST["Observacion"])){
    $Observacion = $_REQUEST["Observacion"];
  }else{
    $Observacion = "";
  }
  if(isset($_REQUEST["Correlativo"])){
    $Correlativo = $_REQUEST["Correlativo"];
  }else{
    $Correlativo = "";
  }
  if(isset($_REQUEST["cmbrut"])){
    $cmbrut = $_REQUEST["cmbrut"];
  }else{
    $cmbrut = "";
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
var f=document.FrmIngOro;
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
<form name="FrmIngOro" method="post" action="">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td ><img src="archivos/images/interior/esq3.png"/></td>
      <td colspan="3" background="archivos/images/interior/arriba.png"></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png"><img src="archivos/images/interior/esq2.png" /></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
      <td width="19%"><img src="archivos/logo_sup.jpeg"/></td>
      <td width="74%" align="left" valign="bottom"  bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><strong><h5>Ingreso Oro Compra</h5></strong></td>
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
				include('pmn_ing_oro_compra.php');
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