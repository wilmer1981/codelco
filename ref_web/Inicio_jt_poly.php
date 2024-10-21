<?php
include("../principal/conectar_ref_web.php");   
include("funciones_administrador.php");
$CodigoDeSistema = 10;
$CodigoDePantalla = 23;

$CookieRut   = $_COOKIE["CookieRut"];
$pagina  = isset($_REQUEST["pagina"])?$_REQUEST["pagina"]:1;
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$DiaIni   = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
$MesIni   = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("n");
$AnoIni   = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");

$siguiente  = isset($_REQUEST["siguiente"])?$_REQUEST["siguiente"]:"";
$anterior   = isset($_REQUEST["anterior"])?$_REQUEST["anterior"]:"";
$fecha_adelante = isset($_REQUEST["fecha_adelante"])?$_REQUEST["fecha_adelante"]:"";
$fecha_atras    = isset($_REQUEST["fecha_atras"])?$_REQUEST["fecha_atras"]:"";

$ingresador   = isset($_REQUEST["ingresador"])?$_REQUEST["ingresador"]:"";
$estadisticas = isset($_REQUEST["estadisticas"])?$_REQUEST["estadisticas"]:"";
$informe      = isset($_REQUEST["informe"])?$_REQUEST["informe"]:"";
$historia     = isset($_REQUEST["historia"])?$_REQUEST["historia"]:"";
$ayuda        = isset($_REQUEST["ayuda"])?$_REQUEST["ayuda"]:"";
$temperatura  = isset($_REQUEST["temperatura"])?$_REQUEST["temperatura"]:"";
$vapor        = isset($_REQUEST["vapor"])?$_REQUEST["vapor"]:"";
$informacion  = isset($_REQUEST["informacion"])?$_REQUEST["informacion"]:"";
$gruas        = isset($_REQUEST["gruas"])?$_REQUEST["gruas"]:"";

if ($fecha=="")
{/*
	if ($DiaIni=="")
	   {$DiaIni = date("d");}
	if ($MesIni=="")
	   {$MesIni = date("n");}
	if ($AnoIni=="")
	   {$AnoIni = date("Y");}
	   */
	if (strlen($DiaIni)==1)
	   {$DiaIni ="0".$DiaIni;}
	if (strlen($MesIni)==1)
	   {$MesIni ="0".$MesIni;}     
	$fecha=$AnoIni.'-'.$MesIni.'-'.$DiaIni;
    if ($siguiente=='S')
      {
       $fecha=aumentar_dias($fecha,1,$link);
	   $MesIni=substr($fecha,5,2);
	   $AnoIni=substr($fecha,0,4);
	   $DiaIni=substr($fecha,8,2);
	  }
    if ($anterior=='S')
     {
      $fecha=restar_dias($fecha,1,$link);
	  $MesIni=substr($fecha,5,2);
	  $AnoIni=substr($fecha,0,4);
	  $DiaIni=substr($fecha,8,2);
	 }
	 
}
else
{
  $AnoIni=substr($fecha,0,4);
  $MesIni=substr($fecha,5,2);
  $DiaIni=substr($fecha,8,2);
}
  
//if($pagina=="") 
//{$pagina=1;}

?>
<HTML>
<HEAD>
<TITLE>Sistema Informacion Refineria Electrolitica Electrolitica</TITLE>
<SCRIPT language=JavaScript>
function Imprimir()
{
	window.print();
}

function Recarga(frm,Pagina) // RECARGA PAGINA DE FROMULARIO
{
	frm.action=Pagina;
	frm.submit();
}

function Recarga_fecha_siguiente(frm,Pagina,fecha) // RECARGA PAGINA DE FROMULARIO
{
   frm.action=Pagina+"&fecha="+fecha+"&siguiente=S";
   frm.submit();
}
function Recarga_fecha_anterior(frm,Pagina,fecha) // RECARGA PAGINA DE FROMULARIO
{
	
   frm.action=Pagina+"&fecha="+fecha+"&anterior=S";
   frm.submit();
}

function Llama_jefe_turno(frm,Pagina,fecha)
{
	
	//alert (Pagina);
	//alert (fecha);
	frm.action=Pagina+"?fecha="+fecha;
	frm.submit();	
}
function Llama_jefe_hm(frm,Pagina,fecha)
{

	frm.action=Pagina+"?fecha="+fecha;
	frm.submit();	
}

function Llama_jefe_pte(frm,Pagina,fecha)
{
	
	frm.action=Pagina+"?fecha="+fecha;;
	frm.submit();	
}

function Salir(f)
{
 	window.opener.document.frmPrincipal.action = "Inicio_jt01.php?opcion=R";
	window.opener.document.frmPrincipal.submit();
	window.close();
 
}
</SCRIPT>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<BODY>
<form name="FrmPrincipal" method="post" action="">
<?php //include("../principal/encabezado_refineria.php");?>
<TABLE border=0  class=hdrtbl  cellPadding=0 cellSpacing=0  width="100%" height="100%">
	<?php  
        $cod_pagina=$pagina;
        if($pagina==1) 
		  {$ImgInicio="tabFrontOn.gif";}
		else{$ImgInicio="tabFrontOff.gif";}
        if($pagina==1) 
		  {$seleccionado1="tabsonline";$ImgInt1="tabMidOff.gif"; $ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado1="tabsoffline";}
        if($pagina==2) 
		  {$seleccionado2="tabsonline";$ImgInt1="tabMidOn.gif"; $ImgInt2="tabMidOff.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif" ;}
		else{$seleccionado2="tabsoffline";}
        if($pagina==3) 
		  {$seleccionado3="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOn.gif";$ImgInt3="tabMidOff.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado3="tabsoffline";}
        if($pagina==4) 
		  {$seleccionado4="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOn.gif";$ImgInt4="tabMidOff.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado4="tabsoffline";}
        if($pagina==5)
		  {$seleccionado5="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOn.gif";$ImgInt5="tabMidOff.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado5="tabsoffline";}
        if($pagina==6)
		  {$seleccionado6="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOn.gif";$ImgInt6="tabMidOff.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado6="tabsoffline";}
        if($pagina==7)
		  {$seleccionado7="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOn.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado7="tabsoffline";}
        if($pagina==8)
		  {$seleccionado8="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOn.gif";$ImgInt8="tabMidOff.gif";$ImgInt9="tabMidOff2.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado8="tabsoffline";}
        if($pagina==9)
		  {$seleccionado9="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOn.gif";$ImgInt9="tabMidOff.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado9="tabsoffline";}
		
	if($pagina==10)
		  {$seleccionado10="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOn.gif";$ImgInt9="tabMidOff.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado10="tabsoffline";}



//poly 24-03-2009
		if($pagina==11)
		  {$seleccionado11="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOn.gif";$ImgInt9="tabMidOff.gif";$ImgInt10="tabMidOff2.gif";}
		else{$seleccionado11="tabsoffline";}
        if($pagina==11)
		  {$ImgFinal="tabEndOn.gif";}
		else{$ImgFinal="tabEndOff.gif";}
        if($pagina==12)
		   {$seleccionado5="tabsoffline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";}
        if($pagina==13)
		   {$seleccionado5="tabsoffline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";}
        if($pagina==14)
		   {$seleccionado5="tabsoffline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";}
        if($pagina==15)
		   {$seleccionado5="tabsoffline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";}
        if($pagina==16)
		   {$seleccionado5="tabsoffline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";$ImgInt8="tabMidOff2.gif";$ImgInt9="tabMidOff2.gif";}
?>
 <TABLE border=1 cellPadding=1  class=hdrtbl  width="100%">
         <TR> 
                
            <TD width="10%"><strong>Usuario Actual </strong></TD>
			<?php 
			
			$consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
			$rss = mysqli_query($link, $consulta);
			$rows = mysqli_fetch_array($rss);
			echo "<TD width='20%'><strong>Sr. ".strtoupper($rows["nombres"])."&nbsp;".strtoupper($rows["apellido_paterno"])."&nbsp;".strtoupper($rows["apellido_materno"])."</strong></TD>";
			?>
			
			<td width="40%"><strong>Ud. Se Encuentra En Sistema Jefe De Turno</strong></td>
          <TABLE border=0  class=hdrtbl  cellPadding=0 cellSpacing=0 width=100%>
              <TR> 
                <TD width="7"  align=middle  class=tabson >  <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInicio; ?>" width=7></TD>
                <TD width="64" align=middle  class=<?php echo $seleccionado1; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=1&fecha=<?php echo $fecha; ?>"><B >Novedades</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <font color="#3366FF"><IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt1; ?>" width=7></font></TD>
                <TD width="46" align=middle  class=<?php echo $seleccionado2; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=2&fecha=<?php echo $fecha; ?>"><B >Bombas</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt2; ?>" width=7></TD>
                <TD width="40" align=middle  class=<?php echo $seleccionado3; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=3&fecha=<?php echo $fecha; ?>"><B >I. Calor </B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt3; ?>" width=7></TD>
                <TD width="44" align=middle  class=<?php echo $seleccionado4; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=4&fecha=<?php echo $fecha; ?>"><B >Filtros</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt4; ?>" width=7></TD>
                <TD width="84" align=middle  class=<?php echo $seleccionado5; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=5&fecha=<?php echo $fecha; ?>"><B >Comunicados</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt5; ?>" width=7></TD>
                <TD width="74" align=middle  class=<?php echo $seleccionado6; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=6&fecha=<?php echo $fecha; ?>"><B >Conexiones</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsline> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt6; ?>" width=7></TD>
                <TD width="66" align=middle  class=<?php echo $seleccionado7; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=7&fecha=<?php echo $fecha; ?>"><B >Traspasos</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt7; ?>" width=7></TD>
                <TD width="89" align=middle  class=<?php echo $seleccionado8; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=8&fecha=<?php echo $fecha; ?>"><B >Temperaturas</B></A></font></TD>
                <TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt8; ?>" width=7></TD>
                <TD width="42" align=middle  class=<?php echo $seleccionado9; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=9&fecha=<?php echo $fecha; ?>"><B >Vapor</B></A></font></TD>
				<TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt9; ?>" width=7></TD>
                <TD width="42" align=middle  class=<?php echo $seleccionado10; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=10&fecha=<?php echo $fecha; ?>"><B >Informaci&oacute;n</B></A></font></TD>
				<TD width="7"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt9; ?>" width=7></TD>
                <TD width="42"  align=middle  class=<?php echo $seleccionado11; ?>><font color="#3366FF"><A class=tabstext href="Inicio_jt_poly.php?pagina=11&fecha=<?php echo $fecha; ?>"><B >Gruas</B></A></font></TD>
                <TD width="135"  align="left"  class=tabsline> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgFinal; ?>" width=5></TD>
              </TR>
          </TABLE>
		  
          <TABLE border=1 cellPadding=3  class=hdrtbl  width=100%>
              <TR> 
                <TD width=100><STRONG>Informe del: </STRONG></TD>
                <TD width=300> 
				<SELECT name="DiaIni" onFocus="foco='MesIni';"><?php LLenaComboDia($DiaIni,date("j"));?></SELECT> 
				<SELECT name="MesIni" onFocus="foco='AnoIni';"><?php LLenaComboMes($MesIni,date("n"));?></SELECT>
        		<SELECT name="AnoIni" onFocus="foco='DiaFin';"><?php LLenaComboAno($AnoIni,date("Y"));?></SELECT>&nbsp;&nbsp; 
				<INPUT name="buscar3" onclick="Recarga(document.FrmPrincipal,'Inicio_jt_poly.php?pagina=<?php echo $pagina; ?>');" type="button" value="Buscar">
				
				<td width=300 align="left"><strong><b>Ir a </b></strong>
					<input name="hm" onclick="Llama_jefe_hm(document.FrmPrincipal,'Inicio_jhm.php','<?php echo $fecha; ?>');" type="button" value="Sist.Jefe H.M.">
					<input name="pte" onclick="Llama_jefe_pte(document.FrmPrincipal,'Inicio_pte.php','<?php echo $fecha; ?>');" type="button" value="Sist.Jefe Pte.">
 
				</td>
				<TD width=300 align="left"><strong>Consulta :</strong>
					<INPUT name="buscar23" onclick="Recarga_fecha_anterior(document.FrmPrincipal,'Inicio_jt_poly.php?pagina=<?php echo $pagina; ?>','<?php echo $fecha_atras; ?>');" type="button" value="<< Anterior">
                	<INPUT name="buscar222" onclick="Recarga_fecha_siguiente(document.FrmPrincipal,'Inicio_jt_poly.php?pagina=<?php echo $pagina; ?>','<?php echo $fecha_adelante; ?>');" type="button" value="Siguiente>>" >
				</TD>
              </TR>
          </TABLE>
		   
          <TABLE  width=100% height="87%" border=0 align="center" bgColor=#999999>
              <TR align=middle > 
                <TD width="100%" height="100%"> 

                  <TABLE  width="100%" height="95%" border=1 align="center" bgColor=#999999>
                    <TR align=middle > 
                     <TD width="100%" height="100%"> 
                      <?php
					  
                        if($pagina==1)
						{
						    if($ingresador!="")
						    {
								//echo "entrooo";
								$pagina="ing_general.php?fecha=$fecha";
							}
							//if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
						    if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
						    {
								$pagina="general.php?fecha=$fecha";
							}
						   if($estadisticas!="")
						      {
							   $pagina="est_general.php";
							  }   
						   if($informe!="")
						     {
							  $pagina="general.php?fecha=$fecha";
							 }  
						   if($historia!="")
						     {
							  $pagina="his_general.php";
							 }   
						   if($ayuda!="")
						     {
							  $pagina="ayu_general.php";
							 }  
						 } 
        				if($pagina==2)
						  {
						  // if(isset($ingresador))
						    if($ingresador!="")
						    {							
							  $pagina="ing_bombas.php?fecha=$fecha";
							}
						   //if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
						    if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
						    {							
							  $pagina="bombas.php?fecha=$fecha";
							}
						    if($estadisticas!="")
						    {
							  $pagina="est_bombas.php";
							}   
						    if($informe!="")
						    {
							  $pagina="bombas.php?fecha=$fecha";
							}  
						    if($historia!="")
						    {
							  $pagina="his_bombas.php?fecha=$fecha";
							}   
						    if($ayuda!="")
						    {
							  $pagina="ayu_general.php";
							}  
						} 
        				if($pagina==3) 
						  {
						
						   if($ingresador!="")
						     {
							  $pagina="ing_intercambiadores.php?fecha=$fecha";
							 }
						   //if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
						   if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")   
						   {
							  $pagina="intercambiadores.php?fecha=$fecha";
							 }  
						   if($estadisticas!="")
						     {
							  $pagina="est_intercambiadores.php";
							 }   
						   if($informe!="")
						     {
							  $pagina="intercambiadores.php?fecha=$fecha";
							 }  
						   if($historia!="")
						     {
							  $pagina="his_intercambiadores.php";
							 }   
						   if($ayuda!="")
						     {
							  $pagina="ayu_general.php";
							 }  
						 }
        				if($pagina==4) 
						  {
						   if($ingresador!="")
						     {
							  $pagina="ing_filtros.php?fecha=$fecha";
							 }
						    //if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							  $pagina="filtros.php?fecha=$fecha";
							 }
						   if($estadisticas!="")
						     {
							  $pagina="est_filtros.php";
							 }
						   if($informe!="")
						     {
							  $pagina="filtros.php?fecha=$fecha";
							 }  
						   if($historia!="")
						     {
							  $pagina="his_filtros.php";
							 }   
						   if($ayuda!="")
						     {
							  $pagina="ayu_general.php";
							 }  
						 } 
        				if($pagina==5)
						  {
						   if($ingresador!="")
						     {
							  $pagina="ing_procedimientos.php?fecha=$fecha";
							 }
						    //if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
						    if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")   
						    {
							  $pagina="procedimientos.php?fecha=$fecha";
							 }
						   if($estadisticas!="")
						     {
							  $pagina="est_procedimientos.php";
							 }   
						   if($informe!="")
						     {
							  $pagina="procedimientos.php?fecha=$fecha"; 
							 }  
						   if($historia!="")
						     {
							  $pagina="his_procedimientos.php";
							 }
						   if($ayuda!="")
						     {
							  $pagina="ayu_general.php";  
							 }  
						 }
        				if($pagina==6) 
						  {
						   if($ingresador!="")
						     {
							
							  $pagina="sec_ing_estadistica_cortes_proceso_ref2.php?fecha=$fecha&opcion=N";      
							 }
													 
						    //if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							  $pagina="conexiones.php?fecha=$fecha";
							 }        
						   if($estadisticas!="")
						     {
							  $pagina="est_conexiones.php";      
							 }   
						   if($informe!="")
						     {
							  $pagina="conexiones.php?fecha=$fecha";  
							 }  
						   if($historia!="")
						     {
							  $pagina="his_conexiones.php";                     
							 }   
						   if($ayuda!="")
						     {
							  $pagina="ayu_conexiones.php";
							 }  
						}      
        				if($pagina==7) 
						  {
						   if($ingresador!="")
						     {
							  $pagina="Ingresadores_traspaso2.php?fecha=$fecha";       
							 }
						    //if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							  $pagina="traspasos.php?fecha=$fecha";
							 }         
						   if($estadisticas!="")
						     {
							  $pagina="est_traspasos.php";       
							 }   
						   if($informe!="")
						     {
							  $pagina="traspasos.php?fecha=$fecha";       
							 }  
						   if($historia!="")
						     {
							  $pagina="his_traspasos.php";     
							 }   
						   if($ayuda!="")
						     {
							  $pagina="ayu_general.php";      
							 }  
						 } 
						$turno='Todo';    
        				if($pagina==8)
						  {
						   if($ingresador!="")
						     {
							  $pagina="ing_temperaturas.php?fecha=$fecha";
							  }
							//if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							   $pagina="temperaturas.php?fecha=$fecha&turno=$turno";
							  }
							if($estadisticas!="")
							  {
							   $pagina="est_temperaturas.php?turno=$turno";    
							  }   
							if($informe!="")
							  {
							   $pagina="temperaturas.php?turno=$turno&fecha=$fecha";
							  }  
							if($historia!="")
							  {
							   $pagina="his_temperaturas.php";
							  }   
							if($ayuda!="")
							  {
							   $pagina="ayu_general.php";    
							  }  
						 }  
						$turno='Todo'; 
						if($pagina==9)
						  {
						 
						   if($ingresador!="")
						     {
							  $pagina="Ing_vapor.php?fecha=$fecha";
							  }
							//if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							   $pagina="vapor.php?fecha=$fecha&turno=$turno";
							  }             
							if($estadisticas!="")
							  {
							   $pagina="est_vapor.php?turno=$turno";
							  }   
							if($informe!="")
							  {
							   $pagina="vapor.php?turno=$turno";
							  }  
							if($historia!="")
							  {
							   $pagina="his_vapor.php";
							   }   
							if($ayuda!="")
							  {
							   $pagina="ayu_general.php";
							   } 
					   }    
					   //aqui ingreso pagina 10 con Informacion
					 
					    if($pagina==15) 
					   {
					   		if($ingresador!="")
						    {
								$pagina="ingresadores_informacion.php?fecha=$fecha";
							}
							//if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							   $pagina="informacion_recti.php?fecha=$fecha&turno=$turno";
							}             
					   		if($ayuda!="")
							{
							  	$pagina="ayu_general.php";
							} 
					   }     

			
	
	
	// 31-03-2009 gruas poly
						if($pagina==16) 
					    {
					   		if($ingresador!="")
						    {
								$pagina="ingreso_gruas.php?fecha=$fecha";
							}
							//if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor)&& !isset($informacion)&& !isset($gruas))
							if($ingresador=="" && $estadisticas=="" && $informe=="" && $historia=="" && $ayuda=="" && $temperatura=="" && $vapor=="" && $informacion=="" && $gruas=="")
							{
							   $pagina="principal_gruas.php?fecha=$fecha&turno=$turno";
							}             
					   		if($ayuda!="")
							{
							  	$pagina="ayu_general.php";
							} 
					    }     
		
	// 31-03-2009 gruas poly				   
					   

        			if($pagina==10)
					   {
					    $pagina="Informe_renovacion_comercial.php?fecha=$fecha";
					   }    
        			if($pagina==11)  
					  {
					   $pagina="Informe_Renovacion_HM.php?fecha=$fecha";}    
        			if($pagina==12) 
					  {
					   $pagina="leyes_jt.php?fecha=$fecha";
					  }    
        			if($pagina==13)
					  {
					   //$pagina="comerciales.php?fecha=$fecha";
					   //$pagina="ref_ing_circuitos2.php?fecha=$fecha";  se saca este programa por peticion de Jaime Rivillo 
					   //$pagina='turno_a.php?fecha='.$fecha.'&ano1='.$AnoIni.'&mes1='.$MesIni.'&dia1='.$DiaIni.'&mostrar=S';
					   $pagina="turno_a.php";

					  }    
				     if($pagina==14) 
					   {
					    $pagina="lista.php";
					   } 
					 if($pagina==99) 
					   {
					    $pagina="en_construccion.php";
					   }     
					  ?>
					  
                      <div align="center"> 
                        <iframe marginwidth=0 marginheight=0 src="<?php echo $pagina; ?>"   frameborder=0 width="100%"  height="100%" scrolling=yes  leftmargin="0"  topmargin="0"></iframe>
                      </div>
                      </TD>
                     </TR>
                 </TABLE>       
		<table width="100%" border="4"  cellspacing="0"  cellpadding="0" class="fondo">
        	<tr > 
            	<td class="tabstext"><div align="center"><A  href="Inicio_jt_poly.php?pagina=<?php echo $cod_pagina; ?>&ingresador=1&fecha=<?php echo $fecha; ?>"><img alt="FORMULARIO INGRESO" border="0" src="archivos/ingresador.gif"  width="82" height="20"></A></div></td>
                <td class="tabstext"><div align="center">
				<!--<A href="Inicio_jt.php?pagina=<?php //echo $cod_pagina; ?>&amp;informe=1&amp;fecha=<?php echo $fecha; ?>"><img alt="INFORME" border=0 src="archivos/informe.gif"  width="82" height="20"></A></div>-->
				</td>
					<?php 	if (($cod_pagina==6) or ($cod_pagina==7) or ($cod_pagina==8) or ($cod_pagina==9) or ($cod_pagina==15))
						{ 
					?> 		<td class="tabstext"><div align="center"><img alt="HISTORIA" border=0 src="archivos/vacio.gif"  width="90" height="20"></A></div></td>
					<?php
						}
						else
						{ 
					?>	
                        	<td class="tabstext"><div align="center"><A href="Inicio_jt_poly.php?pagina=<?php echo $cod_pagina; ?>&historia=1&fecha=<?php echo $fecha; ?>"><img alt="HISTORIA" border=0 src="archivos/historia.gif"  width="82" height="20"></A></div></td>
					<?php 	} 
					?>
                            <td class="tabstext"><div align="center"><A href="Inicio_jt_poly.php?pagina=10"><img alt="PROGRAMA DESC. TOTAL" border=0 src="archivos/desc_total.gif" width="82" height="20"></A></div></td>
                            <td class="tabstext"><div align="center"><A href="Inicio_jt_poly.php?pagina=10"><img alt="PROGRAMA RENOVACI&Oacute;N"border=0 src="archivos/renovacion.gif"    width="82" height="20"></A></div></td>
                            <td class="tabstext"><div align="center"><A href="Inicio_jt_poly.php?pagina=11"><img alt="PROGRAMA RENOVACION HOJAS MADRES"  border=0  src="archivos/hojas_madres.gif" width="82" height="20"></A></div></td>
                            <td class="tabstext"><div align="center"><A href="Inicio_jt_poly.php?pagina=12"><img alt="LEYES" border=0 src="archivos/leyes.gif" width="82" height="20"></A></div></td>
                            <!--<td class=tabstext><div align="center"><A href="Inicio_jt.php?pagina=13"><img alt="PRODUCCION CATODOS COMERCIALES" border=0 src="archivos/comerciales.gif" width="82" height="20"></A></div></td>-->
                            <td class="tabstext"><div align="center"><A href="Inicio_jt_poly.php?pagina=13"><img alt="INFORME DIARIO" border=0 src="archivos/informe.gif" width="82" height="20"></A></div></td>
							<td class="tabstext"><div align="center"><a href="Inicio_jt_poly.php?pagina=<?php echo $cod_pagina; ?>&ayuda=1"><img alt="AYUDA" border=1 src="archivos/ayuda.gif" width="20" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp; 
                    </div></td>
							<td class="tabstext"><div align="center">
							
                      <input type="button" name="btnsalir" value="Salir" style="width=50" onClick="Salir('this.form')">
                    </div></td>
                            <td class="tabstext"><div align="center"></div></td>
                  </tr>
                </table>
                </TR>
</TABLE>
</TABLE>
</table>
<?php //include("../principal/pie_pagina_refineria.php");?>
</FORM>
</BODY>
</HTML>
