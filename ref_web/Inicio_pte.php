<?php
include("../principal/conectar_ref_web.php");   
include("funciones_administrador.php");
$CodigoDeSistema = 10;
$CodigoDePantalla = 29;
if (!isset($fecha))
{
	if (!isset($DiaIni))
	   {$DiaIni = date("d");}
	if (!isset($MesIni))
	   {$MesIni = date("n");}
	if (!isset($AnoIni))
	   {$AnoIni = date("Y");}
	if (strlen($DiaIni)==1)
	   {$DiaIni ="0".$DiaIni;}
	if (strlen($MesIni)==1)
	   {$MesIni ="0".$MesIni;}     
	$fecha=$AnoIni.'-'.$MesIni.'-'.$DiaIni;
    if ($siguiente=='S')
      {
       $fecha=aumentar_dias($fecha,1);
	   $MesIni=substr($fecha,5,2);
	   $AnoIni=substr($fecha,0,4);
	   $DiaIni=substr($fecha,8,2);
	  }
    if ($anterior=='S')
     {
      $fecha=restar_dias($fecha,1);
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
  
if(!isset($pagina)) 
	   {$pagina=1;}
?>

<HTML><HEAD><TITLE>Sistema Informacion Refineria Electrolitica Electrolitica</TITLE>
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
   frm.action=Pagina+"&amp;fecha="+fecha+"&siguiente=S";
   frm.submit();
}
function Recarga_fecha_anterior(frm,Pagina,fecha) // RECARGA PAGINA DE FROMULARIO
{
   frm.action=Pagina+"&amp;fecha="+fecha+"&anterior=S";
   frm.submit();
}
function Llama_jefe_jhm(frm,Pagina,fecha)
{

	frm.action=Pagina+"&amp;fecha="+fecha;
	frm.submit();	
}
function Llama_jefe_turno(frm,Pagina,fecha)
{

	frm.action=Pagina+"&amp;fecha="+fecha;
	frm.submit();	
}


function Salir()
{
	var Frm=document.FrmPrincipal;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=10";
	Frm.submit();

/*document.location = "../principal/sistemas_usuario.php?CodSistema=10";*/
}
</SCRIPT>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">	
<BODY>
<form name="FrmPrincipal" method="post" action="">
<?php
// include("../principal/encabezado.php");?>
<TABLE border=0  class=hdrtbl  cellPadding=0 cellSpacing=0  width="100%" height="100%">
	<?php  
		$cod_pagina=$pagina;
        if($pagina==1) 
		  {
		   $ImgInicio="tabFrontOn.gif";
		  }
		else{
		     $ImgInicio="tabFrontOff.gif";
			}
        if($pagina==1) 
		   {
		    $seleccionado1="tabsonline";
			$ImgInt1="tabMidOff.gif"; 
			$ImgInt2="tabMidOff2.gif";
			$ImgInt3="tabMidOff2.gif";
			$ImgInt4="tabMidOff2.gif";
			$ImgInt5="tabMidOff2.gif";
			$ImgInt6="tabMidOff2.gif";
			$ImgInt7="tabMidOff2.gif";
			$ImgInt8="tabMidOff2.gif";
			$ImgInt9="tabMidOff2.gif";
		   }
		else{
		     $seleccionado1="tabsoffline";
			}
        if($pagina==2) 
		  {
		   $seleccionado2="tabsonline";
		   $ImgInt1="tabMidOn.gif"; 
		   $ImgInt2="tabMidOff.gif";
		   $ImgInt3="tabMidOff2.gif";
		   $ImgInt4="tabMidOff2.gif";
		   $ImgInt5="tabMidOff2.gif";
		   $ImgInt6="tabMidOff2.gif";
		   $ImgInt7="tabMidOff2.gif";
		   $ImgInt8="tabMidOff2.gif";
		   $ImgInt9="tabMidOff2.gif";
		  }
		else{
		     $seleccionado2="tabsoffline";
			}
        if($pagina==3) 
		  {
		   $seleccionado3="tabsonline";
		   $ImgInt1="tabMidOff2.gif";
		   $ImgInt2="tabMidOn.gif";
		   $ImgInt3="tabMidOff.gif";
		   $ImgInt4="tabMidOff2.gif";
		   $ImgInt5="tabMidOff2.gif";
		   $ImgInt6="tabMidOff2.gif";
		   $ImgInt7="tabMidOff2.gif";
		   $ImgInt8="tabMidOff2.gif";
		   $ImgInt9="tabMidOff2.gif";
		  }
		else{
		     $seleccionado3="tabsoffline";
			}
        if($pagina==4) 
		  {
		   $seleccionado4="tabsonline";
		   $ImgInt1="tabMidOff2.gif";
		   $ImgInt2="tabMidOff2.gif";
		   $ImgInt3="tabMidOn.gif";
		   $ImgInt4="tabMidOff.gif";
		   $ImgInt5="tabMidOff2.gif";
		   $ImgInt6="tabMidOff2.gif";
		   $ImgInt7="tabMidOff2.gif";
		   $ImgInt8="tabMidOff2.gif";
		   $ImgInt9="tabMidOff2.gif";
		  }
		else{
		     $seleccionado4="tabsoffline";
		    }
        if($pagina==5) 
		  {
		   $seleccionado5="tabsonline";
		   $ImgInt1="tabMidOff2.gif";
		   $ImgInt2="tabMidOff2.gif";
		   $ImgInt3="tabMidOff2.gif";
		   $ImgInt4="tabMidOn.gif";
		   $ImgInt5="tabMidOff.gif";
		   $ImgInt6="tabMidOff2.gif";
		   $ImgInt7="tabMidOff2.gif";
		   $ImgInt8="tabMidOff2.gif";
		   $ImgInt9="tabMidOff2.gif";
		  }
		else{
		     $seleccionado5="tabsoffline";
			}
        if($pagina==5) 
		  {
		   $ImgFinal="tabEndOn.gif";
		  }
		else{
		     $ImgFinal="tabEndOff.gif";
		}
?>
        
<TABLE border=1 cellPadding=1  class=hdrtbl  width="100%">
	<TR> 
		<TD width="10%"><strong>Usuario Actual :</strong></TD>
			<?php 
			
				$consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
				$rss = mysqli_query($link, $consulta);
				$rows = mysqli_fetch_array($rss);
				echo "<TD width='20%'><strong>Sr. ".strtoupper($rows["nombres"])."&nbsp;".strtoupper($rows["apellido_paterno"])."&nbsp;".strtoupper($rows["apellido_materno"])."</strong></TD>";
				?>
				<td width="40%"><strong>Ud. Se Encuentra En Sistema Jefe Pte.</strong></td>

     <TABLE border=0  class=hdrtbl  cellPadding=0 cellSpacing=0 width=100%>
		<tr>	
  
     <TD width="7"   align=middle class=tabson > <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInicio; ?>" width=7></TD>
     <TD width="64"  align=middle class=<?php echo $seleccionado1; ?>><font color="#3366FF"><A class=tabstext href="Inicio_pte.php?pagina=1&amp;  fecha=<?phpphp echo $fecha; ?>"><B >Novedades</B></A></font></TD>
     <TD width="7"   align=middle  class=tabsoff> <font color="#3366FF"><IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt1; ?>" width=7></font></TD>
     <TD width="46"  align=middle class=<?php echo $seleccionado2; ?>><font color="#3366FF"><A class=tabstext href="Inicio_pte.php?pagina=2&amp;  fecha=<?phpphp echo $fecha; ?>"><B >Produccion</B></A></font></TD>
     <TD width="7"   align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt2; ?>" width=7></TD>
     <TD width="40"  align=middle class=<?php echo $seleccionado3; ?>><font color="#3366FF"><A class=tabstext href="Inicio_pte.php?pagina=3&amp;  fecha=<?phpphp echo $fecha; ?>"><B >Comunicados</B></A></font></TD>
     <TD width="7"   align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt3; ?>" width=7></TD>
     <TD width="44"   align=middle  class=<?php echo $seleccionado4; ?>><font color="#3366FF"><A class=tabstext href="Inicio_pte.php?pagina=4&amp;  fecha=<?phpphp echo $fecha; ?>"><B >Riles</B></A></font></TD>
     <TD width="7"    align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgInt4; ?>" width=7></TD>
     <TD width="84"   align=middle  class=<?php echo $seleccionado5; ?>><font color="#3366FF"><A class=tabstext href="Inicio_pte.php?pagina=5&amp;  fecha=<?phpphp echo $fecha; ?>"><B >Traspasos</B></A></font></TD>
     <TD width="255"  align="left"  class=tabsline> <IMG alt="" border=0 height=40 src="archivos/<?php echo $ImgFinal; ?>" width=5></TD>
  </TR>
</TABLE>
	<TABLE border=1 cellPadding=3  class=hdrtbl  width=100%>
  	<TR> 
    	 <TD width=95><STRONG>Informe del: </STRONG></TD>
    	 <TD width=300> 
			 <SELECT name="DiaIni" onFocus="foco='MesIni';"><?php LLenaComboDia($DiaIni,date("j"));?></SELECT> 
			 <SELECT name="MesIni" onFocus="foco='AnoIni';"><?php LLenaComboMes($MesIni,date("n"));?></SELECT>
        	 <SELECT name="AnoIni" onFocus="foco='DiaFin';"><?php LLenaComboAno($AnoIni,date("Y"));?></SELECT>&nbsp;&nbsp; 
			 <INPUT name=buscar3 onclick=JavaScript:Recarga(document.FrmPrincipal,'Inicio_pte.php?pagina=<?php echo $pagina; ?>') type=button value=Buscar>
		<td width=300 align="left"><strong><b>Ir a </b></strong>
			<input name=hm onClick=JavaScript:Llama_jefe_turno(document.FrmPrincipal,'inicio_jt.php?fecha=<?php echo $fecha; ?>') type=button value="Sist.Jefe Turno">
			<input name=pte onClick=JavaScript:Llama_jefe_jhm(document.FrmPrincipal,'Inicio_jhm.php?fecha=<?php echo $fecha; ?>') type=button value="Sist.Jefe H.M.">
 		</td>

		 
    	<td width="300" align="left"><strong>Consulta</strong>
			<INPUT name=buscar23 onclick=JavaScript:Recarga_fecha_anterior(document.FrmPrincipal,'Inicio_pte.php?pagina=<?phpphp echo $pagina; ?>','<?phpphp echo $fecha_atras; ?>') type=button value="<< Anterior">
			<INPUT name=buscar222 onclick=JavaScript:Recarga_fecha_siguiente(document.FrmPrincipal,'Inicio_pte.php?pagina=<?php echo $pagina; ?>','<?php echo $fecha_adelante; ?>') type=button value="Siguiente>>" >
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
				  if(isset($ingresador))
				     {
					   $pagina="ing_general_jefe_pte.php?fecha=$fecha";           
					 }
				  if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
				     {
					  $pagina="general_jefe_pte.php?fecha=$fecha"; 
					 }      
				  if(isset($estadisticas))
				     {
					  $pagina="est_general.php";            
					 }   
				  if(isset($informe))
				    {
					 $pagina="general_jefe_pte.php?fecha=$fecha";
					}  
				  if(isset($historia))
				    {
					 $pagina="his_general_jefe_pte.php";
					}   
				  if(isset($ayuda))
				    {
					 $pagina="ayu_general.php";
				    }  
				} 
        	  if($pagina==2) 
			    {
				 if(isset($ingresador))
				   {
				    $pagina="Ingreso_pte.php?fecha=$fecha&entrar=S";
				   }
				 if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
				   {
				    $pagina="informe_pte.php?fecha=$fecha";   
				   }      
				 if(isset($estadisticas))
				   {
				    $pagina="est_Maquinas.php";
				   }   
				 if(isset($informe))
				   {
				    $pagina="informe_pte.php?fecha=$fecha"; 
				   }  
				 if(isset($historia))
				   {
				    $pagina="his_produccion_maquinas.php?fecha=$fecha"; 
				   }   
				 if(isset($ayuda))
				   {
				    $pagina="ayu_Maquinas.php";
				   }  
			 } 
        	if($pagina==3) 
			  {
			   if(isset($ingresador))
				  {
				   $pagina="ing_procedimientos.php?fecha=$fecha";    
				  }
				if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
				  {
				   $pagina="procedimientos.php?fecha=$fecha";     
				  }      
				if(isset($estadisticas))
				  {
				   $pagina="est_procedimientos.php";     
				  }   
				if(isset($informe))
				  {
				   $pagina="procedimientos.php?fecha=$fecha";          
				  }  
				if(isset($historia))
				  {
				   $pagina="his_procedimientos.php";  
				  }   
				if(isset($ayuda))
				  {
				   $pagina="ayu_procedimientos.php";     
				  }  
			}
			//echo $pagina;
        	if($pagina==4) 
			  {
			   if(isset($ingresador))
			     {
				  $pagina="Informe_riles.php?fecha=$fecha";        
				 }
			   if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
			     {
				  $pagina="Informe_riles.php?fecha=$fecha";
				 }
			   if(isset($estadisticas))
			     {
				  $pagina="est_Inspeccion.php";  
				 }   
			   if(isset($informe))
			     {
				  $pagina="Informe_riles.php?fecha=$fecha";  
				 }  
			   if(isset($historia))
			     {
				  $pagina="Informe_riles.php";
				 }   
			   if(isset($ayuda))
			     {
				  $pagina="ayu_Inspeccion.php";         
				 }  
		      } 
          	 if($pagina==5) 
			   {
			     if(isset($ingresador))
					 {
					  $pagina="Ingresadores_traspaso.php?fecha=$fecha";       
					 }
				   if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
					 {
					  $pagina="traspasos.php?fecha=$fecha";
					 }         
				   if(isset($estadisticas))
					 {
					  $pagina="est_traspasos.php";       
					 }   
				   if(isset($informe))
					 {
					  $pagina="traspasos.php?fecha=$fecha";       
					 }  
				   if(isset($historia))
					 {
					  $pagina="his_traspasos.php";     
					 }   
				   if(isset($ayuda))
					 {
					  $pagina="ayu_general.php";      
					 }  
			  }
    		 if($pagina==6) 
			   {
			    if(isset($ingresador))
				  {
				   $pagina="Ing_pulido_placas.php?fecha=$fecha";     
				  }
				if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
				  {
				   $pagina="pulido_placas.php?fecha=$fecha";      
				  }      
				if(isset($estadisticas))
				  {
				   $pagina="est_Pulido_Placas.php";      
				  }   
				if(isset($informe))
				  {
				   $pagina="pulido_placas.php";           
				  }  
				if(isset($historia))
				  {
				   $pagina="his_Pulido_Placas.php";               
				  }   
				if(isset($ayuda))
				  {
				   $pagina="ayu_Pulido_Placas.php";      
				  }  
			  }      
         	 if($pagina==7) 
			   {
			    if(isset($ingresador))
				  {
				   $pagina="lectura_rectificador_proceso.php?fecha=$fecha";         
				  }
				if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
				  {
				   $pagina="Lectura_rectificador.php?fecha=$fecha";          
				  }      
				if(isset($estadisticas))
				  {
				   $pagina="est_rectificador1.php";         
				  }   
				if(isset($informe))
				  {
				   $pagina="Lectura_rectificador.php?fecha=$fecha";   
				  }  
				if(isset($historia))
				  {
				   $pagina="his_rectificador1.php";
				  }   
				if(isset($ayuda))
				  {
				   $pagina="ayu_rectificador1.php";  
				  }  
			  }    
         	 if($pagina==8) 
			   {
			    if(isset($ingresador))
				  {
				   $pagina="ayu_general.php";        
				  }
				if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)&& !isset($temperatura)&& !isset($vapor))
				  {
				   $pagina="ayu_general.php";          
				  }      
				if(isset($estadisticas))
				  {
				   $pagina="ayu_general.php";          
				  }   
				if(isset($informe))
				  {
				   $pagina="ayu_general.php";
				  }  
				if(isset($historia))
				  {
				   $pagina="ayu_general.php";    
				  }   
				if(isset($ayuda))
				  {
				   $pagina="ayu_general.php";
				  }  
			  }    
			  if($pagina==10)  
			    {
				 $pagina="Informe_renovacion_comercial.php?fecha=$fecha";
				}    
        	  if($pagina==11)  
			    {
				 $pagina="Informe_Renovacion_HM.php?fecha=$fecha";
				}    
          	 if($pagina==12) 
			   {
			    $pagina="leyes_jt.php?fecha=$fecha";
			   }    
             if($pagina==13) 
			   {
			  	$pagina='ref_ing_circuitos2.php?fecha='.$fecha.'&ano1='.$AnoIni.'&mes1='.$MesIni.'&dia1='.$DiaIni.'&mostrar=S';
 
			  //  $pagina="comerciales.php?fecha=$fecha";
			   } 
			 if($pagina==99)  
			   {
			    $pagina="ayu_general.php";
			   }            
		     ?>
             <div align="center"> 
			 <iframe marginwidth=0 marginheight=0 src="<?php echo''.$pagina.''; ?>" frameborder=0 width="100%" scrolling=yes height="100%" leftmargin="0"  topmargin="0"></iframe>
             </div>
            </TD>
          </TR>
        </TABLE>       
 

	<table width="100%" border="4"  cellspacing="0"  cellpadding="0" class="fondo">
      <tr > 
	     <?php if (($cod_pagina==5) or ($cod_pagina==4) ) 
		        {?>
		         <td class=tabstext><div align="center"><img alt="HISTORIA" border=0 src="archivos/vacio.gif"  width="90" height="20"></A></div></td>
			  <?php } 
			else {?>
                   <td class=tabstext><div align="center"><A  href="Inicio_pte.php?pagina=<?php echo $cod_pagina; ?>&amp;ingresador=1&amp;fecha=<?php echo $fecha; ?>"><img alt="FORMULARIO INGRESO" border="0" src="archivos/ingresador.gif"  width="82" height="20"></A></div></td>
			 <?php  } ?> 
 
        <!-- <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=<?php //echo $cod_pagina; ?>&amp;informe=1&amp;fecha=<?php echo $fecha; ?>"><img alt="INFORME" border=0 src="archivos/informe.gif"  width="82" height="20"></A></div></td>-->
	  	 <?php if (($cod_pagina==4) or ($cod_pagina==2) or ($cod_pagina==5))
		      { 
			?> <td class=tabstext><div align="center"><img alt="HISTORIA" border=0 src="archivos/vacio.gif"  width="90" height="20"></A></div></td>
		   <?php }
		    else { ?>	
                  <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=<?php echo $cod_pagina; ?>&amp;historia=1&amp;fecha=<?php echo $fecha; ?>"><img alt="HISTORIA" border=0 src="archivos/historia.gif"  width="82" height="20"></A></div></td>
			  <?php } ?>
            <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=99"><img alt="PROGRAMA DESC. TOTAL" border=0 src="archivos/desc_total.gif" width="82" height="20"></A></div></td>
            <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=10"><img alt="PROGRAMA RENOVACI�N"border=0 src="archivos/renovacion.gif"    width="82" height="20"></A></div></td>
            <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=11"><img alt="PROGRAMA RENOVACION HOJAS MADRES"  border=0  src="archivos/hojas_madres.gif" width="82" height="20"></A></div></td>
            <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=12"><img alt="LEYES" border=0 src="archivos/leyes.gif" width="82" height="20"></A></div></td>
			<td class=tabstext><div align="center"><A href="Inicio_jt.php?pagina=13"><img alt="INFORME DIARIO" border=0 src="archivos/informe.gif" width="82" height="20"></A></div></td>

        <!-- <td class=tabstext><div align="center"><A href="Inicio_pte.php?pagina=13"><img alt="PRODUCCION CATODOS COMERCIALES" border=0 src="archivos/comerciales.gif" width="82" height="20"></A></div></td>-->
            <td class=tabstext><div align="center"><a href="Inicio_pte.php?pagina=<?php echo $cod_pagina; ?>&amp;ayuda=1"><img alt="AYUDA" border=1 src="archivos/ayuda.gif" width="20" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp; 
            </div></td>
			<td class=tabstext><div align="center">
			
              <input type="button" name="btnsalir" value="Salir" style="width=50" onClick="Salir()">
			</div></td>
            <td class=tabstext><div align="center"></div></td>
       </tr>
    </table></td>
   </tr>
 </table>
 </TR>
</TABLE>
</TABLE>
<?php 
//include("../principal/pie_pagina.php");?>
</FORM>
</BODY>
</HTML>
