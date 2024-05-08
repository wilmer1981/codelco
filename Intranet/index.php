<?
	include("conectar.php");
	//if (!isset($Pagina))
		//$Pagina="menu_dinamico.php?CodMenu=2";
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Dia=date("j");
	$Mes=date("n");
	$Ano=date("Y");
	$DiaAnt=date("j", mktime(1,0,0,$Mes,$Dia-1,$Ano));
	$MesAnt=date("n", mktime(1,0,0,$Mes,$Dia-1,$Ano));
	$AnoAnt=date("Y", mktime(1,0,0,$Mes,$Dia-1,$Ano));
?>
<html>
<head>
<title>CODELCO - DIVISION VENTANAS</title>
<link href="js/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
<?
	//if (!isset($Pagina))
		//echo "window.open(\"popup_principal.html\",\"\",\"top=50,left=50,width=450,height=430,resizable=no, scrollbars=no\");";
?>
function Cargar(pag)
{
	var f=document.frmPrincipal;
	f.action = "index.php?Pagina="+pag;
	f.submit();
}
function AbrirPopUp(pag)
{
	var f=document.frmPrincipal;
	window.open(pag,"","top=50,left=30,width=600,height=450,resizable=yes, scrollbars=yes");	
}

function AbrirPopUp2(pag, top, left, width, height)
{
	var f=document.frmPrincipal;
	window.open(pag,"","top="+top+",left="+left+",width="+width+",height="+height+",resizable=yes, scrollbars=yes");	
}
function AbrirPopUp3(pag, top, left, width, height)
{
	var f=document.frmPrincipal;
	window.open(pag,"","top="+top+",left="+left+",width="+width+",height="+height+",resizable=yes, scrollbars=yes");	
}
function AbrirPopUp4(pag, top, left, width, height)
{
	var f=document.frmPrincipal;
	window.open(pag,"","top="+top+",left="+left+",width="+width+",height="+height+",resizable=yes, scrollbars=yes");	
}
function AbrirPopUp5(pag, top, left, width, height)
{
	var f=document.frmPrincipal;
	window.open(pag,"","top="+top+",left="+left+",width="+width+",height="+height+",resizable=yes, scrollbars=yes");	
}
function DetalleNoticias(pos,cod)
{
	var f=document.frmPrincipal;
	pag="detalle_noticias.php?PosMenu="+pos+"&Codigo="+cod;
	window.open(pag,"","top=50,left=30,width=600,height=450,resizable=yes, scrollbars=yes");	
}
function AbrirPopUpLogin(pag)
{
	var f=document.frmPrincipal;
	window.open(pag,"","top=200,left=350,width=200,height=150,resizable=no, scrollbars=no");	
}
function acceso()
{
	var f=document.frmPrincipal;
	var clave=f.pass.value;
	clave=clave.toUpperCase();
	if (clave=="MORFEO")
	{
		f.action='control_accesos_90.php';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}
function acceso_sef_1()
{
	var f=document.frmPrincipal;
	var clave=f.pass.value;
	clave=clave.toUpperCase();
	if (clave=="FUNDICION")
	{
		f.action='http://10.56.11.6/sef/index.php';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}

 function acceso_sef_2()
{
	var f=document.frmPrincipal;
	var clave=f.pass2.value;
	clave=clave.toUpperCase();
	if (clave=="RAMBD")
	{
		f.action='http://10.56.11.6/sef/traspasoparcial/trasp_parcial.php';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}
  function acceso_sef_3()
{
	var f=document.frmPrincipal;
	var clave=f.pass3.value;
	clave=clave.toUpperCase();
	if (clave=="BDIAZ")
	{
		f.action='index.php?Pagina=inf_diario_tendencia.html';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}
function acceso_sef_12()
{
	var f=document.frmPrincipal;
	var clave=f.pass.value;
	clave=clave.toUpperCase();
	if (clave=="FUNDICION")
	{
		f.action='http://<? echo HTTP_SERVER;?>/proyecto/sef/index.php';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}

 function acceso_sef_22()
{
	var f=document.frmPrincipal;
	var clave=f.pass2.value;
	clave=clave.toUpperCase();
	if (clave=="RAMBD")
	{
		f.action='http://<? echo HTTP_SERVER;?>/proyecto/sef/traspasoparcial/trasp_parcial.php';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}
function acceso_fotos()
{
	var f=document.frmPrincipal;
	var clave=f.pass.value;
	clave=clave.toUpperCase();
	if ((clave=="6863016-9")||(clave =="7731447-4"))
	{
		f.action='index.php?Pagina=menu_foto.html';
		f.submit();
	}
	else
	{
		alert("Clave no Aceptada");
		return;
	}
}

function ing_user_inf_diario()
{
	var f=document.frmPrincipal;
	if (f.Rut.value=='')
	{
			alert ("Ingrese su Rut");
			f.Rut.focus();
			return
	}
	if (f.Pass.value=='')
	{
			alert ("Debe ingresar su Contraseña");
			f.Pass.focus();
			return
	}
//f.action='http://10.56.11.6/inf_diario/index.php';
	//f.submit();
}
function ing_user_inf_diario2()
{
	var f=document.frmPrincipal;
	if (f.Rut.value=='')
	{
			alert ("Ingrese su Rut");
			f.Rut.focus();
			return
	}
	if (f.Pass.value=='')
	{
			alert ("Debe ingresar su Contraseña");
			f.Pass.focus();
			return
	}

	f.action='http://<? echo HTTP_SERVER;?>/proyecto/inf_diario/index.php';
	f.submit();
}

function ing_user_sam()
{
	var f=document.frmPrincipal;
	if (f.Rut.value=='')
	{
			alert ("Ingrese su Rut");
			f.Rut.focus();
			return
	}
	if (f.Pass.value=='')
	{
			alert ("Debe ingresar su Contraseña");
			f.Pass.focus();
			return
	}
	f.action='http://<? echo HTTP_SERVER;?>/proyecto/sam_web/acceso.php';
	f.submit();
}

function ing_user_contratos()
{
	var f=document.frmPrincipal;
	if (f.nombres.value=='')
	{
			alert ("Ingrese Usuario");
			f.nombres.focus();
			return
	}
	if (f.pass.value=='')
	{
			alert ("Debe ingresar su Contraseña");
			f.pass.focus();
			return;
	}
//	f.action="http://10.56.11.6/contratos_ingenieria/actualiza_consulta_contratos.html";
	//f.submit();
}
function List_Inf_Dia(opt,dia,mes,ano)
{
	var f=document.frmPrincipal;
	var Archivo="";
	if (dia=="")
		dia=f.DiaIni.value;		
	if (mes=="")
		mes=f.MesIni.value;
	if (ano=="")
		ano=f.AnoIni.value;
	if (dia<10)
		dia="0"+dia;
	if (mes<10)
		mes="0"+mes;
	switch (opt)
	{
		case "W":
			f.action="http://<? echo HTTP_SERVER;?>/inf_diario/listado/Listar_Fundicion_Web.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
		case "E":
			f.action="http://<? echo HTTP_SERVER;?>/inf_diario/listado/Listar_Fundicion_excel.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
		case "A_W":
			f.action="http://<? echo HTTP_SERVER;?>/inf_diario/listado/Listar_Fundicion_Web.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
		case "A_E":
			f.action="http://<? echo HTTP_SERVER;?>/inf_diario/listado/Listar_Fundicion_excel.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
	}
	
}
function List_Inf_Dia2(opt,dia,mes,ano)
{
	var f=document.frmPrincipal;
	var Archivo="";
	if (dia=="")
		dia=f.DiaIni.value;		
	if (mes=="")
		mes=f.MesIni.value;
	if (ano=="")
		ano=f.AnoIni.value;
	if (dia<10)
		dia="0"+dia;
	if (mes<10)
		mes="0"+mes;
	switch (opt)
	{
		case "W":
			f.action="http://<? echo HTTP_SERVER;?>/proyecto/inf_diario/listado/Listar_Fundicion_Web.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
		case "E":
			f.action="http://<? echo HTTP_SERVER;?>/proyecto/inf_diario/listado/Listar_Fundicion_excel.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
		case "A_W":
			f.action="http://<? echo HTTP_SERVER;?>/proyecto/inf_diario/listado/Listar_Fundicion_Web.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
		case "A_E":
			f.action="http://<? echo HTTP_SERVER;?>/proyecto/inf_diario/listado/Listar_Fundicion_excel.php?dia="+dia+"&mes="+mes+"&ano="+ano;
			f.submit();
			break;
	}
	
}

</script>
<style type="text/css">
<!--
body,td,th {
	color: #64666f;
}
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body >
<form name="frmPrincipal" action="" method="post">
<table width="770" height="300" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" bgcolor="#FFFFFF">
  <tr valign="top">
    <td height="18" colspan="3"><? include("cabecera.php"); ?></td>
  </tr>
  <tr>
    <td width="160" rowspan="2" valign="top" class="BordeDer"><? include("menu_principal.php"); ?><br></td>
    <td width="770" align="center" valign="top">&nbsp;&nbsp;<? 	
	if (!isset($Pagina))
	{
		$CodMenu = 0; 
		include("noticias.php");
	}
	else
	{	 
		$Encontro="";
		$Encontro_1="N";
		$Encontro_2="N";
		$PosIni=0;
		for ($i=0;$i<=strlen($Pagina);$i++)
		{
			if (substr($Pagina,$i,18)=="menu_dinamico2.php")
			{				
				$Encontro="1";
				$PosIni=$i;
				break;
			}
			if (substr($Pagina,$i,22)=="seleccion_archivos.php")
			{	
				$Encontro="2";
				$PosIni=$i;
				break;
			}
		}
		if ($Encontro!="N")
		{
			//ES DINAMICO
			switch ($Encontro)
			{
				case "1":
					$CodMenu = substr($Pagina,27);
					$Pagina = trim(substr($Pagina,$PosIni,18));
					break;
				case "2":
					$Tipo = substr($Pagina,28);
					$Pagina = trim(substr($Pagina,$PosIni,22));
					break;
			}
		}
		include($Pagina); 
	}
	
?><br></td>
    <td width="242" align="right" valign="top">
<?
	$Pagina="menu_dinamico.php?CodMenu=2";
	$Encontro="";
	$Encontro_1="N";
	$Encontro_2="N";
	$PosIni=0;
	for ($i=0;$i<=strlen($Pagina);$i++)
	{
		if (substr($Pagina,$i,17)=="menu_dinamico.php")
		{
			$Encontro="1";
			$PosIni=$i;
			break;
		}
		if (substr($Pagina,$i,22)=="seleccion_archivos.php")
		{	
			$Encontro="2";
			$PosIni=$i;
			break;
		}
	}
	if ($Encontro!="N")
	{
		//ES DINAMICO
		switch ($Encontro)
		{
			case "1":
				$CodMenu = substr($Pagina,26);
				$Pagina = trim(substr($Pagina,$PosIni,17));
				break;
			case "2":
				$Tipo = substr($Pagina,28);
				$Pagina = trim(substr($Pagina,$PosIni,22));
				break;
		}
	}
	include($Pagina); 
?><br>
<!--<table width="230" height="70" border="0" align="center" cellpadding="1" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td align="left" height="20"></td>
    <td align="right"></td>
  </tr>
  <tr>
    <td height="60" align="center" valign="top" bgcolor="#efefef" colspan="2">
      <? //include("destacados.php"); ?>
    </td>
  </tr>
</table>-->
    </td>
  </tr>
  <tr>
    <td colspan="2" align="right" valign="top" height="50"><!--<img src="images/lienzo_1.JPG" >--></td>
  </tr>
  <tr>
    <td height="15" colspan="3" align="center" valign="middle" >
<? 
	//include("pie_pagina.php"); 
?>  </td>
  </tr>
</table> 
</form>
</body>
</html>
