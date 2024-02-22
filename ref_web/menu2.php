<?php 
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
    if(!isset($pagina)) {$pagina=1;}
	if (!isset($dia1))
	   {
	     $dia1=date("j");
		 $mes1=date("n");
		 $ano1=date("Y");
	    }	 
?>


<html>
<head>
<script language="JavaScript">
function Buscar()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos.php?mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarant()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos.php?mostrar=S&Ant=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarsig()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos.php?mostrar=S&Sig=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
function Excel()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/ref_web_xls.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}
function Tabla1()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;


	document.location = "../ref_web/tabla1.php?fecha="+fecha;
}
function Tabla2()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;


	document.location = "../ref_web/tabla2.php?fecha="+fecha;
}
function Tabla3()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;


	document.location = "../ref_web/tabla3.php?fecha="+fecha;
}
function Tabla4()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/tabla4.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}
function Tabla5()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/tabla5.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}

function Tabla6()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/Tabla6.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}


function Grafico()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/ejemplo_grafico.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");
}
function Grafico2()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico2.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");
}
function Grafico3()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico3.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");

}
function Imprimir()
{
	window.print();
}
function detalle(fecha,grupo,turno)
{
	var Frm=document.form1;
	window.open("detalle_rechazos.php?fecha="+ fecha+"&grupo="+grupo+"&turno="+turno,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
}
function detalle_produccion(fecha,grupo)
{
	var Frm=document.form1;
	window.open("ref_detalle_produccion_cubas.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}


</script>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<title>Sistema Informacion Refineria Electrolitica Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
<?php include("../principal/encabezado.php");?>

<TABLE border=0  class="TablaPrincipal"  cellPadding=0 cellSpacing=0  width=600>
  <TBODY>
  <TR>
    <TD align=middle vAlign=center width=100%>
    

       <?phpphp  
        $cod_pagina=$pagina;
        if($pagina==1) {$ImgInicio="tabFrontOn.gif";}else{$ImgInicio="tabFrontOff.gif";}
        if($pagina==1) {$seleccionado1="tabsonline";$ImgInt1="tabMidOff.gif"; $ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";}else{$seleccionado1="tabsoffline";}
        if($pagina==2) {$seleccionado2="tabsonline";$ImgInt1="tabMidOn.gif"; $ImgInt2="tabMidOff.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";}else{$seleccionado2="tabsoffline";}
        if($pagina==3) {$seleccionado3="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOn.gif";$ImgInt3="tabMidOff.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";}else{$seleccionado3="tabsoffline";}
        if($pagina==4) {$seleccionado4="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOn.gif";$ImgInt4="tabMidOff.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";}else{$seleccionado4="tabsoffline";}
        if($pagina==5) {$seleccionado5="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOn.gif";$ImgInt5="tabMidOff.gif";$ImgInt6="tabMidOff2.gif";$ImgInt7="tabMidOff2.gif";}else{$seleccionado5="tabsoffline";}
        if($pagina==6) {$seleccionado6="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOn.gif";$ImgInt6="tabMidOff.gif";$ImgInt7="tabMidOff.gif";}else{$seleccionado6="tabsoffline";}
        if($pagina==7) {$seleccionado7="tabsonline";$ImgInt1="tabMidOff2.gif";$ImgInt2="tabMidOff2.gif";$ImgInt3="tabMidOff2.gif";$ImgInt4="tabMidOff2.gif";$ImgInt5="tabMidOff2.gif";$ImgInt6="tabMidOn.gif";$ImgInt7="tabMidOff.gif";}else{$seleccionado7="tabsoffline";}
        if($pagina==7) {$ImgFinal="tabEndOn.gif";}else{$ImgFinal="tabEndOff.gif";}
?>
          <TABLE border=0  class=hdrtbl  cellPadding=0 cellSpacing=0 width=100%>
            <TBODY>
              <TR> 
                <td width="52"  align=middle class=tabson ><IMG height=40 alt=""  src="archivos2/tabFrontOn.gif" width=52 border=0></td>
                <td width="175" align=middle class=<?php echo $seleccionado1; ?>><font color="#3366FF"><A class=tabstext href="menu2.php?pagina=1"><B >Novedades</B></A></font></td>
                <TD width="10"  align=middle  class=tabsoff> <font color="#3366FF"><IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgInt1; ?>" width=22></font></TD>
                <TD width="46"  align=middle class=<?php echo $seleccionado2; ?>> 
                  <font color="#3366FF"><A class=tabstext href="menu2.php?pagina=2"><B >Laminas 
                  Iniciales </B></A></font></TD>
                <TD width="10"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgInt2; ?>" width=22></TD>
                <TD width="113" align=middle class=<?php echo $seleccionado3; ?>> 
                  <font color="#3366FF"><A class=tabstext href="menu2.php?pagina=3"><B >Maquinas</B></A></font></TD>
                <TD width="10"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgInt3; ?>" width=22></TD>
                <TD width="36"  align=middle  class=<?php echo $seleccionado4; ?>><font color="#3366FF"><A class=tabstext href="menu2.php?pagina=4"><B >Cortocircuitos</B></A></font></TD>
                <TD width="10"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgInt4; ?>" width=22></TD>
                <TD width="89"  align=middle  class=<?php echo $seleccionado5; ?>><font color="#3366FF"><A class=tabstext href="menu2.php?pagina=5"><B >Calidad 
                  Catodos Comerciales</B></A></font></TD>
                <TD width="10"  align=middle  class=tabsoff> <IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgInt5; ?>" width=22></TD>
                <TD width="89"  align=middle  class=<?php echo $seleccionado6; ?>><font color="#3366FF"><A class=tabstext href="menu2.php?pagina=6"><B >Renovacion 
                  Electrodos </B></A></font></TD>
                <TD width="10"  align=middle  class=tabsline> <IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgInt6; ?>" width=22></TD>
                <TD width="89"  align=middle  class=<?php echo $seleccionado7; ?>><font color="#3366FF"><A class=tabstext href="menu2.php?pagina=7"><B >Electrolito</B></A></font></TD>
                <TD width="15"  align=middle  class=tabsline> <IMG alt="" border=0 height=40 src="archivos2/<?phpphp echo $ImgFinal; ?>" width=10></TD>
              </TR>
            </TBODY>
          </TABLE>
          
          <TABLE border=1 cellPadding=3  class=hdrtbl  width=100%>
            <TBODY>
              <TR> 
                <TD width=168><INPUT name=buscar23 onclick=Buscarant() type=button value="<< Anterior"></TD>
                <TD width=95><STRONG>Informe del: </STRONG></TD>
                <TD width=322> <select name="dia1" size="1" >
                   <?php
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($dia1))
							{
								if ($dia1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("j"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
					  ?>
                  </select>
                  <select name="mes1" size="1" id="mes1">
              
           <?php    
						for ($i = 1;$i <= 12; $i++)
						{$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
							if (isset($mes1))
							{
								if ($mes1 == $i)
									echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
							}
							else
							{
								if ($i == date("n"))
									echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
							}
						}
						?>
            </select>
                 
                  <select name="ano1" size="1" id="select4">
                     <?php
						for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
						{
							if (isset($ano1))
							{
								if ($ano1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("Y"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
				?>
                  </select> &nbsp;&nbsp; 
                  <INPUT name=buscar3 onclick=Buscar() type=button value=buscar> 
                </TD>
                <TD width=128><INPUT name=buscar222 onclick=Buscarsig() type=button value="Siguiente > >" ></TD>
              </TR>
            </TBODY>
          </TABLE>
          <TABLE  width=100% height=242 border=1 align="center" bgColor=#999999>
            <TBODY>
              <TR align=middle > 
                <TD width="654" height="236"> 
                  <?php  
				        $linea="&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
						if($pagina==1) 
						  {
						    if(isset($ingresador))
							    {
								  $pagina="ingresadores/ing_general.php?dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1; 
								}
							if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda))
							    {
								  $pagina="general.php?dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
								}
							if(isset($estadisticas))
							   {
							     $pagina="estadisticas/est_general.php?dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1; 
							    }   
							if(isset($informe))
							   {
							     $pagina="general.php?dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
							   }  
							if(isset($historia))
							   {
							     $pagina="historia/his_general.php?dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
							   } 
						    if(isset($ayuda))
							  {
							    $pagina="ayuda/ayu_general.php";
							  }  
						  } 
        				if($pagina==2) 
						   {
						     if(isset($ingresador))
							    {
								  $pagina="ingresadores/ing_laminas.php";
								}
						     if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda))
							    {
								  $pagina="laminas.php";
								}            
							 if(isset($estadisticas))
							    {
								  $pagina="estadisticas/est_laminas.php";
								}   
							 if(isset($informe))
							     {
								   $pagina="laminas.php";
								 }  
							 if(isset($historia))
							     {
								   $pagina="historia/his_laminas.php";
								 }   
							 if(isset($ayuda))
							     {
								   $pagina="ayuda/ayu_laminas.php";          
								 }  
						 } 
        				if($pagina==3) 
						   {
						     if(isset($ingresador))
							    {
								  $pagina="ingresadores/ing_maquinas.php";
								}
							 if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda))
							    {
								  $pagina="maquinas.php";
								}  
							 if(isset($estadisticas))
							   {
							     $pagina="estadisticas/est_maquinas.php";
							    }   
							 if(isset($informe))
							   {
							    $pagina="maquinas.php";
							    }  
							 if(isset($historia))
							    {
								  $pagina="historia/his_maquinas.php";
								}   
							 if(isset($ayuda))
							    {
								  $pagina="ayuda/ayu_maquinas.php";
								 }  
						}
        				if($pagina==4)
						  {
						   if(isset($ingresador))
						     {
							   $pagina="ingresadores/cortes2_aux.php";         
							  }
							if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda))
							   {
							     $pagina="cortes2_aux.php";
							   }           
							if(isset($estadisticas))
							  {
							    $pagina="estadisticas/est_maquinas.php";         
							   }   
							if(isset($informe))
							  {
							    $pagina="maquinas.php";         
							  }  
							if(isset($historia))
							  {
							   $pagina="historia/his_maquinas.php";         
							  }   
							if(isset($ayuda))
							  {
							   $pagina="ayuda/ayu_maquinas.php";         
							  }  
						} 
        				if($pagina==5) {if(isset($ingresador)){$pagina="ingresadores/ing_cal_cat_comerciales.php";  }if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)){$pagina="cortocircuitos.php";}    if(isset($estadisticas)){$pagina="estadisticas/est_cortocircuitos.php";  }   if(isset($informe)){$pagina="cortocircuitos.php";  }  if(isset($historia)){$pagina="historia/his_cortocircuitos.php";  }   if(isset($ayuda)){$pagina="ayuda/ayu_cortocircuitos.php";  }  }
        				if($pagina==6) {if(isset($ingresador)){$pagina="ingresadores/ing_renovacion_electrodos.php";      }if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)){$pagina="conexiones.php";}        if(isset($estadisticas)){$pagina="estadisticas/est_conexiones.php";      }   if(isset($informe)){$pagina="conexiones.php";      }  if(isset($historia)){$pagina="historia/his_conexiones.php";      }   if(isset($ayuda)){$pagina="ayuda/ayu_conexiones.php";      }  }      
	       				if($pagina==7) {if(isset($ingresador)){$pagina="ingresadores/ing_electrolito.php";      }if(!isset($ingresador) && !isset($estadisticas) && !isset($informe) && !isset($historia) && !isset($ayuda)){$pagina="traspasos.php";}          if(isset($estadisticas)){$pagina="estadisticas/est_traspasos.php";       }   if(isset($informe)){$pagina="traspasos.php";       }  if(isset($historia)){$pagina="historia/his_traspasos.php";       }   if(isset($ayuda)){$pagina="ayuda/ayu_traspasos.php";       }  }    
					?>
                  <div align="center"> 
                    <iframe marginwidth=0 marginheight=0 src="<?php echo ''.$pagina.''; ?>"   frameborder=0 width="770" scrolling=yes height=350 leftmargin="0"  topmargin="0"></iframe>
                  </div></TD>
              </TR>
            </TBODY>
          </TABLE>       
          <table width="63%" border="1" align="center" class="TablaInterior">
            <tr>
              <td width="50" class=tabstext><div align="center"><A href="menu2.php?pagina=<?php echo $cod_pagina; ?>&amp;estadisticas=1"><img border=0 src="archivos2/f_14.gif"  width="42" height="36"></A><br>
                  <strong><font color="#000000">Estadisticas</font></strong> </div></td>
              <td width="50" class=tabstext><div align="center"><A href="menu2.php?pagina=<?php echo $cod_pagina; ?>&amp;ingresador=1"><img border=0 src="archivos2/f_18.gif"  width="42" height="36"></A><br>
                  <font color="#000000"><strong>Ingresador</strong> </font> </div></td>
              <td width="50" class=tabstext><div align="center"><A href="menu2.php?pagina=<?php echo $cod_pagina; ?>&amp;informe=1"><img border=0 src="archivos2/f_10.gif"  width="42" height="36"></A><br>
                  <strong><font color="#000000">Informe </font></strong> </div></td>
              <td width="50" class=tabstext><div align="center"><A href="menu2.php?pagina=<?php echo $cod_pagina; ?>&amp;historia=1"><img border=0 src="archivos2/f_21.gif"  width="42" height="36"></A><br>
                  <strong><font color="#000000">Historia </font></strong> </div></td>
              <td width="50" class=tabstext><div align="center"><A href="menu2.php?pagina=<?php echo $cod_pagina; ?>&amp;ayuda=1"><img border=0 src="archivos2/ayuda.gif" width="42" height="36"></A><br>
                  <strong><font color="#000000">Ayuda</font></strong></div></td>
            </tr>
          </table>

      </TR>
 </TBODY>
</TABLE>
<?php include("../principal/pie_pagina.php");?>

</FORM>
</BODY>
</HTML>
