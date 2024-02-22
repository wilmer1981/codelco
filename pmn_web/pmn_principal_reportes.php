<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");					

	require "KoolTabs/kooltabs.php";	
	
	$kts = new KoolTabs("kts");
	$kts->scriptFolder = "KoolTabs";
	$kts->styleFolder = "KoolTabs\styles\inox";
	
	$Hora=date('H:i:s');
	$FechaTurno=date('Y-m-d');
	if(isset($Tab1))
		$Tab1='true';
	
	$Tab1='true';$Block1='block';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
	$Block10='none';$Block11='none';$Block12='none';$Block13='none';$Block14='none';$Block15='none';
	if($Tab2=='true')
	{
		$Tab1='';$Tab2='true';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='block';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab3=='true')
	{
		$Tab1='';$Tab2='';$Tab3='true';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='block';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab4=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='true';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='block';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab5=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='true';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='block';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab6=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='true';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='block';$Block7='none';$Block8='none';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab7=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='true';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='block';$Block8='none';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab8=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='true';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='block';$Block9='none';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab9=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='true';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='block';
		$Tab10='';$Block10='none';$Block11='none';$Tab11='';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	if($Tab10=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='true';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Block10='block';$Block11='none';$Block12='none';$Tab12='';$Block13='none';$Tab13='';$Block14='none';$Block15='none';
	}
	//echo "tab:   ".$Tab11."<br>"; 
	if($Tab11=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='true';$Tab12='';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Block10='none';$Block11='block';$Block12='none';$Tab12='';$Block13='none';$Block14='none';$Block15='none';
	}
	if($Tab12=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='true';$Tab13='';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Block10='none';$Block11='none';$Block12='block';$Tab12='true';$Block13='none';$Block14='none';$Block15='none';
	}
	if($Tab13=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='true';$Tab14='';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Block10='none';$Block11='none';$Block12='none';$Tab12='none';$Block13='block';$Block14='none';$Block15='none';
	}
	if($Tab14=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='true';$Tab15='';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Block10='none';$Block11='none';$Block12='none';$Tab12='none';$Block13='none';$Block14='block';$Block15='none';
	}
	if($Tab15=='true')
	{
		$Tab1='';$Tab2='';$Tab3='';$Tab4='';$Tab5='';$Tab6='';$Tab7='';$Tab8='';$Tab9='';$Tab10='';$Tab11='';$Tab12='';$Tab13='';$Tab14='';$Tab15='true';
		$Block1='none';$Block2='none';$Block3='none';$Block4='none';$Block5='none';$Block6='none';$Block7='none';$Block8='none';$Block9='none';
		$Block10='none';$Block11='none';$Block12='none';$Tab12='none';$Block13='none';$Block14='none';$Block15='block';
	}
	$kts->addTab("root","externo","Prod. Externo","javascript:showPage(\"Tab1\")",$Tab1);//Make node selection	
	$kts->addTab("root","lixi","Lixiviaci&oacute;n Barro Anodico","javascript:showPage(\"Tab6\")",$Tab6);//Make node selection	
	$kts->addTab("root","plans","Planta Selenio","javascript:showPage(\"Tab8\")",$Tab8);//Make node selection	
	$kts->addTab("root","horno","Horno Trof","javascript:showPage(\"Tab2\")",$Tab2);//Make node selection	
	$kts->addTab("root","electrop","Electrolisis de plata","javascript:showPage(\"Tab3\")",$Tab3);//Make node selection	
	$kts->addTab("root","electroo","Electrolisis de oro","javascript:showPage(\"Tab4\")",$Tab4);//Make node selection	
	$kts->addTab("root","Lixi2","Lixiviaci&oacute;n Barro Aurifero","javascript:showPage(\"Tab10\")",$Tab10);//Make node selection	
	//$kts->addTab("root","Componentes","Componentes","javascript:showPage(\"F\")",$TabUso);//Make node selection	
	$kts->addTab("root","proanodooro","Produ. Anodos De Oro","javascript:showPage(\"Tab5\")",$Tab5);//Make node selection
	//echo "<br>";	
	$kts->addTab("root","prooro","Prod. Oro","javascript:showPage(\"Tab7\")",$Tab7);//Make node selection	
	$kts->addTab("root","proplata","Prod. Plata","javascript:showPage(\"Tab11\")",$Tab11);//Make node selection	
	$kts->addTab("root","prosub","Prod. Sub-Productos","javascript:showPage(\"Tab12\")",$Tab12);//Make node selection	
	$kts->addTab("root","embarque","Embarque","javascript:showPage(\"Tab9\")",$Tab9);//Make node selection	
	$kts->addTab("root","CirOxi","Circulantes-Oxidos Ag-Cu","javascript:showPage(\"Tab13\")",$Tab13);//Make node selection	
	$kts->addTab("root","CobreT","Cobre Teluro","javascript:showPage(\"Tab14\")",$Tab14);//Make node selection	
	$kts->addTab("root","CAuri","Cloruro &Aacute;urico","javascript:showPage(\"Tab15\")",$Tab15);//Make node selection	
	
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
f.action='pmn_principal.php';
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
<body>
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
      <td width="74%" align="left"  bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;">
		<script type="text/javascript">
			function showPage(Pant)
			{
				var f=document.frmPrincipalRpt;
				//alert(Pant);				
			   f.action="pmn_principal_reportes.php?"+Pant+'=true'; 		   
			   f.submit();
			}				
		</script>		    
		<div class="container" style="width:660px;">
			<div class="tabs">
				<?phpphp echo $kts->Render();?>			
			</div>
	  </div>		  
	  </td>
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
		<div class="container">
					<div id="A1" style="display:<?php echo $Block1;?>; ">
						<?php 
						if($Block1=='block')
							include('pmn_principal_reportes_ProdExt.php');						
						?>				
					</div>
					<div id="B2" style="display:<?php echo $Block2;?>;">
						<?php 
						if($Block2=='block')
							include('pmn_principal_reportes_HTrof.php');
						?>									
					</div>			
					<div id="C3" style="display:<?php echo $Block3;?>;">
						<?php 
						if($Block3=='block')
							include('pmn_principal_reportes_CargaElect.php');
						?>									
					</div>			
					<div id="D4" style="display:<?php echo $Block4;?>;">
						<?php 
						if($Block4=='block')
							include('pmn_carga_elec_oro.php');
						?>									
					</div>	
					<div id="E5" style="display:<?php echo $Block5;?>;">
						<?php 
						if($Block5=='block')
							include('pmn_carga_fusion.php');
						?>									
					</div>		
					<div id="F6" style="display:<?php echo $Block6;?>;">
						<?php 
						if($Block6=='block')
							include('pmn_ing_lixiviacion.php');
						?>									
					</div>			
					<div id="G7" style="display:<?php echo $Block7;?>;">
						<?php 
						if($Block7=='block')
							include('pmn_carga_fusion_oro.php');
						?>									
					</div>			
					<div id="H8" style="display:<?php echo $Block8;?>;">
						<?php 
						if($Block8=='block')
							include('pmn_ing_deselenizacion.php');
						?>									
					</div>			
					<div id="I9" style="display:<?php echo $Block9;?>;">
						<?php 
						if($Block9=='block')
							include('pmn_principal_reportes_Embarque.php');
						?>
					</div>			
					<div id="J10" style="display:<?php echo $Block10;?>;">
						<?php 
						if($Block10=='block')
							include('pmn_principal_reportes_BAurifero.php');
						?>
					</div>			
					<div id="K11" style="display:<?php echo $Block11;?>;">
						<?php 
						if($Block11=='block')
							include('pmn_produccion_plata.php');
						?>									
					</div>			
					<div id="L12" style="display:<?php echo $Block12;?>;">
						<?php 
						if($Block12=='block')
							include('pmn_ing_produccion_subproductos.php');
						?>									
					</div>			
					<div id="M13" style="display:<?php echo $Block13;?>;">
						<?php 
						if($Block13=='block')
							include('pmn_ing_circulantes_oxidos.php');
						?>									
					</div>			
					<div id="N14" style="display:<?php echo $Block14;?>;">
						<?php 
						if($Block14=='block')
							include('pmn_ing_cobre_teluro.php');
						?>									
					</div>			
					<div id="CAuri" style="display:<?php echo $Block15;?>;">
						<?php 
						if($Block15=='block')
							include('pmn_ing_cloruro_aurico.php');
						?>									
					</div>			
			</div>
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
          <td height="1" colspan="5" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut)."&nbsp;</SPAN>";?></td>
          <td width="18"><img src="archivos/images/interior/esq4.png"  /></td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
