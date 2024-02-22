<?php 
  include("../principal/conectar_ref_web.php");
  if (!isset($turno))
     {
 	  $Consulta = "select case when CURTIME() between '00:00:00' and '07:59:59' then 'C' else ";
	  $Consulta.= " case when CURTIME() between '08:00:00' and '15:59:59' then 'A' else ";
	  $Consulta.= " case when CURTIME() between '16:00:00' and '23:59:59' then 'B' end end end as turno ";
	  $Respuesta = mysqli_query($link, $Consulta);
	  if ($Fila = mysqli_fetch_array($Respuesta))
   	  $turno = $Fila["turno"];
	 }    
 	$Ano = substr($fecha,0,4);
	$Mes = substr($fecha,5,2);
	$Dia = substr($fecha,8,2);

	$consulta = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '1' AND fecha = '".$fecha."'";
	$rs = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($rs))
 	{
	//$checkbox = '0';
	$Ano = substr($row["fecha"],0,4);
	$Mes = substr($row["fecha"],5,2);
	$Dia = substr($row["fecha"],8,2);
	}
	$consulta2 = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '2' AND fecha = '".$fecha."'";
	$rs2 = mysqli_query($link, $consulta2);
	$row2 = mysqli_fetch_array($rs2);
	$consulta7 = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '7' AND fecha = '".$fecha."'";
	$rs7 = mysqli_query($link, $consulta7);
	$row7 = mysqli_fetch_array($rs7);
	$consulta8 = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '8' AND fecha = '".$fecha."'";
	$rs8 = mysqli_query($link, $consulta8);
	$row8 = mysqli_fetch_array($rs8);

		

	

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Grabar(f,fecha)

{
       var f=document.FrmPrincipal;
	   

        linea = "opcion=N";
	    linea = linea + "&gruesas1=" + f.txtgruesas1.value + "&delgadas1=" + f.txtdelgadas1.value + "&granuladas1=" + f.txtgranuladas1.value;
        linea = linea + "&gruesas2=" + f.txtgruesas2.value + "&delgadas2=" + f.txtdelgadas2.value + "&granuladas2=" + f.txtgranuladas2.value;
		linea = linea + "&gruesas7=" + f.txtgruesas7.value + "&delgadas7=" + f.txtdelgadas7.value + "&granuladas7=" + f.txtgranuladas7.value;
		linea = linea + "&gruesas8=" + f.txtgruesas8.value + "&delgadas8=" + f.txtdelgadas8.value + "&granuladas8=" + f.txtgranuladas8.value;
		linea= linea+ "&recuperado=" +f.txtrecuperado.value+"&ajuste="+f.txtajuste.value+"&tipo="+f.txttipo.value;
		f.action = "proceso01.php?fecha="+fecha+"&proceso=G&" + linea;
		f.submit();
	
}
function Calcula(grupo,tipo_rechazos,dato_esta,tipo)
{
	var f=document.FrmPrincipal;
	if (tipo=='G1')
	   {
	        f.txtgruesas1.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas12.value.replace(',','.'));    
	   }
	 else if (tipo=='D1')
	          {
	            f.txtdelgadas1.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas12.value.replace(',','.'));    
	          }  
	        else if (tipo=='Gra1')
			       {
				    f.txtgranuladas1.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas12.value.replace(',','.'));    
				   }
                  else if (tipo=='G2')
	                    {
	                     f.txtgruesas2.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas22.value.replace(',','.'));    
	                    }
	                   else if (tipo=='D2')
	                         {
	                           f.txtdelgadas2.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas22.value.replace(',','.'));    
	                         }  
	                        else if (tipo=='Gra2')
			                      {
				                    f.txtgranuladas2.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas22.value.replace(',','.'));    
				                   }
								   else if (tipo=='G7')
	                                      {
	                                       f.txtgruesas7.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas72.value.replace(',','.'));    
	                                      }
	                                     else if (tipo=='D7')
	                                          {
	                                           f.txtdelgadas7.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas72.value.replace(',','.'));    
	                                          }  
	                                         else if (tipo=='Gra7')
			                                       {
				                                    f.txtgranuladas7.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas72.value.replace(',','.'));    
				                                    }
												    else if (tipo=='G8')
	                                                       {
	                                                        f.txtgruesas8.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas82.value.replace(',','.'));    
	                                                       }
	                                                      else if (tipo=='D8')
	                                                             {
	                                                              f.txtdelgadas8.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas82.value.replace(',','.'));    
	                                                             }  
	                                                           else if (tipo=='Gra8')
			                                                          {
				                                                       f.txtgranuladas8.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas82.value.replace(',','.'));    
				                                                       } 
 																	else if (tipo=='Rec')
																	         {f.txtrecuperado.value=Number(dato_esta.replace(',','.'))+Number(f.txtrecuperado2.value.replace(',','.'));     }																	   	 
return;	
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
}

function modifica(fecha,grupo,gruesas,delgadas,granuladas)
{
 
   window.open("modifica_rechazo.php?fecha="+fecha+"&grupo="+grupo,"","top=195,left=180,width=420,height=180,scrollbars=no,resizable = no");
  
}



function salir(fecha) // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "prueba_hm.php?fecha="+fecha;
	frm.submit();
}
</script>
</head>
<LINK href="/estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="/archivos/petalos.css" rel=stylesheet type=text/css>
<body>
<form name="FrmPrincipal" method="post" action="">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TBODY>
      <TR> 
        <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
        <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><strong> 
          INGRESADOR DE LAMINAS INICIALES</strong></FONT></TD>
        <TD width=9 align=right><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
      </TR>
      <TR> 
        <TD  bgColor=#6b8ec6 width=9>&nbsp;</TD>
        <TD align="left" bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><strong> 
          </strong></FONT></TD>
        <TD width=9  bgColor=#6b8ec6 align=right>&nbsp;</TD>
      </TR>
    </TBODY>
  </TABLE>

<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR> 
<TD style="BACKGROUND-REPEAT: repeat-x" background="archivos/bg_grad3.gif" bgColor=#d7dce8> <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%"                   border=0>
<TBODY>
<TR> 
<TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
<TD> 
<TABLE cellSpacing=0 cellPadding=0 width="95%" border=0>
<TBODY>
<TR> 
<TD><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
</TR>
<TR> 
<TD>&nbsp; </TD>
</TR>
<TR> 
<TD align=middle> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR> 
<TD width=44>&nbsp; </TD>
<TD width="722"> <TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR> 
<TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
</TR>
<TR> 
<TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR> 
<TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
<TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
<TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
</TR>
<TR> 
<TD width="100%" colSpan=3> <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
<TBODY>
<TR> 
<TD width="0%">&nbsp; </TD>
<TD width="1%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
<TD width="97%"><p>&nbsp;</p>
                                                          <table width="87%" border="1" align="center">
                                                            <tr> 
                                                              <td height="25" colspan="8"> 
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"></div>
                                                                <div align="center"><em><FONT style="FONT-WEIGHT: bold; COLOR: #000000">INGRESO 
                                                                  EDITOR LAMINAS 
                                                                  INICIALES </FONT></em></div></td>
                                                            </tr>
                                                            <tr> 
                                                              <td>&nbsp;</td>
                                                              <td colspan="3"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">RECHAZOS</FONT><FONT style="FONT-WEIGHT: bold; COLOR: #000000"></FONT></div></td>
                                                              <td colspan="3"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000"> 
                                                                  TOTALES</FONT></div></td>
                                                            </tr>
                                                            <tr> 
                                                              <td width="19%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">GRUPOS</FONT></div></td>
                                                              <td width="9%"> 
                                                                <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">GRUESAS</FONT></div></td>
                                                              <td width="11%"> 
                                                                <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">DELGADAS</FONT></div></td>
                                                              <td width="9%"> 
                                                                <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">GRANULADAS</FONT></div></td>
                                                              <td width="9%"> 
                                                                <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">GRUESAS</FONT></div></td>
                                                              <td width="11%"> 
                                                                <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">DELGADAS</FONT></div></td>
                                                              <td width="12%"> 
                                                                <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">GRANULADAS</FONT></div></td>
                                                            </tr>
                                                            <tr> 
                                                              <td><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">1</FONT></div></td>
                                                              <?php if ($opcion <>'M')
															       {?>
                                                              <td> <div align="center"><?php echo "<input name='txtgruesas12' type='text'  value='$txtgruesas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtgruesas12."', '".$row[rechazo_gruesas]."','G1');\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtdelgadas12' type='text'  value='$txtdesgadas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtdelgadas12."', '".$row[rechazo_delgadas]."','D1' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtgranuladas12' type='text'  value='$txtgranuladas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtgranuladas12."', '".$row[rechazo_granuladas]."','Gra1' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgruesas1" type="text" id="txtgruesas1"  style="text-align: center;background:grey;"   value="<?php echo $row[rechazo_gruesas] ?>" size="10" readonly >
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtdelgadas1" type="text" size="10" value="<?php echo $row[rechazo_delgadas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgranuladas1" type="text" size="10" value="<?php echo $row[rechazo_granuladas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php  } 
																else {?>
                                                              <td> <div align="center"><?php echo "<input name='txtgruesas12' type='text'  value='$txtgruesas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtgruesas12."', '".$row[rechazo_gruesas]."','G1');\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtdelgadas12' type='text'  value='$txtdesgadas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtdelgadas12."', '".$row[rechazo_delgadas]."','D1' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtgranuladas12' type='text'  value='$txtgranuladas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtgranuladas12."', '".$row[rechazo_granuladas]."','Gra1' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgruesas1" type="text" id="txtgruesas1"  value="<?php echo $row[rechazo_gruesas] ?>" size="10" >
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtdelgadas1" type="text" size="10" value="<?php echo $row[rechazo_delgadas] ?>"  >
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgranuladas1" type="text" size="10" value="<?php echo $row[rechazo_granuladas] ?>"  >
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } ?>
                                                              <td><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">2</FONT></div></td>
                                                              <?php if ($opcion <>'M')
															       {?>
                                                              <td> <div align="center"><?php echo "<input name='txtgruesas22' type='text'  value='$txtgruesas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtgruesas22."', '".$row2[rechazo_gruesas]."','G2' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtdelgadas22' type='text'  value='$txtdesgadas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtdelgadas22."', '".$row2[rechazo_delgadas]."','D2' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtgranuladas22' type='text'  value='$txtgranuladas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtgranuladas22."', '".$row2[rechazo_granuladas]."','Gra2' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgruesas2" type="text" size="10" value="<?php echo $row2[rechazo_gruesas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtdelgadas2" type="text" size="10" value="<?php echo $row2[rechazo_delgadas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgranuladas2" type="text" size="10" value="<?php echo $row2[rechazo_granuladas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } 
															   else {?>
                                                              <td> <div align="center"><?php echo "<input name='txtgruesas22' type='text'  value='$txtgruesas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtgruesas22."', '".$row2[rechazo_gruesas]."','G2' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtdelgadas22' type='text'  value='$txtdesgadas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtdelgadas22."', '".$row2[rechazo_delgadas]."','D2' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td> <div align="center"><?php echo "<input name='txtgranuladas22' type='text'  value='$txtgranuladas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtgranuladas22."', '".$row2[rechazo_granuladas]."','Gra2' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgruesas2" type="text" size="10" value="<?php echo $row2[rechazo_gruesas] ?>" >
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtdelgadas2" type="text" size="10" value="<?php echo $row2[rechazo_delgadas] ?>" >
                                                                </div></td>
                                                              <td> <div align="center"> 
                                                                  <input name="txtgranuladas2" type="text" size="10" value="<?php echo $row2[rechazo_granuladas] ?>" >
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } ?>
                                                              <td width="19%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">7</FONT></div></td>
                                                              <?php if ($opcion <>'M')
															       {?>
                                                              <td width="9%"> 
                                                                <div align="center"><?php echo "<input name='txtgruesas72' type='text'  value='$txtgruesas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtgruesas72."', '".$row7[rechazo_gruesas]."','G7' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td width="11%"> 
                                                                <div align="center"><?php echo "<input name='txtdelgadas72' type='text'  value='$txtdesgadas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtdelgadas72."', '".$row7[rechazo_delgadas]."','D7' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td width="9%"> 
                                                                <div align="center"><?php echo "<input name='txtgranuladas72' type='text'  value='$txtgranuladas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtgranuladas72."', '".$row7[rechazo_granuladas]."','Gra7' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
                                                                </div></td>
                                                              <td width="9%"> 
                                                                <div align="center"> 
                                                                  <input name="txtgruesas7" type="text" size="10" value="<?php echo $row7[rechazo_gruesas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td width="11%"> 
                                                                <div align="center"> 
                                                                  <input name="txtdelgadas7" type="text" size="10" value="<?php echo $row7[rechazo_delgadas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td width="12%"> 
                                                                <div align="center"> 
                                                                  <input name="txtgranuladas7" type="text" size="10" value="<?php echo $row7[rechazo_granuladas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } 
																 else { ?>
                                                              <td width="9%"> 
                                                                <div align="center"><?php echo "<input name='txtgruesas72' type='text'  value='$txtgruesas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtgruesas72."', '".$row7[rechazo_gruesas]."','G7' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td width="11%"> 
                                                                <div align="center"><?php echo "<input name='txtdelgadas72' type='text'  value='$txtdesgadas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtdelgadas72."', '".$row7[rechazo_delgadas]."','D7' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td width="9%"> 
                                                                <div align="center"><?php echo "<input name='txtgranuladas72' type='text'  value='$txtgranuladas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtgranuladas72."', '".$row7[rechazo_granuladas]."','Gra7' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?> 
                                                                </div></td>
                                                              <td width="9%"> 
                                                                <div align="center"> 
                                                                  <input name="txtgruesas7" type="text" size="10" value="<?php echo $row7[rechazo_gruesas] ?>" >
                                                                </div></td>
                                                              <td width="11%"> 
                                                                <div align="center"> 
                                                                  <input name="txtdelgadas7" type="text" size="10" value="<?php echo $row7[rechazo_delgadas] ?>" >
                                                                </div></td>
                                                              <td width="12%"> 
                                                                <div align="center"> 
                                                                  <input name="txtgranuladas7" type="text" size="10" value="<?php echo $row7[rechazo_granuladas] ?>" >
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } ?>
                                                              <td><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">8</FONT></div></td>
                                                              <?php if ($opcion <>'M')
															       {?>
                                                              <td width="9%"><div align="center"><?php echo "<input name='txtgruesas82' type='text'  value='$txtgruesas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtgruesas82."', '".$row8[rechazo_gruesas]."','G8' );\" onKeyDown='TeclaPulsada()' size='10' >";?></div></td>
                                                              <td width="11%"><div align="center"><?php echo "<input name='txtdelgadas82' type='text'  value='$txtdesgadas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtdelgadas82."', '".$row8[rechazo_delgadas]."','D8' );\" onKeyDown='TeclaPulsada()' size='10' >";?></div></td>
                                                              <td width="9%"><div align="center"><?php echo "<input name='txtgranuladas82' type='text'  value='$txtgranuladas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtgranuladas82."', '".$row8[rechazo_granuladas]."','Gra8' );\" onKeyDown='TeclaPulsada()' size='10' >";?></div></td>
                                                              <td width="9%"><div align="center"> 
                                                                  <input name="txtgruesas8" type="text" size="10" value="<?php echo $row8[rechazo_gruesas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td width="11%"><div align="center"> 
                                                                  <input name="txtdelgadas8" type="text" size="10" value="<?php echo $row8[rechazo_delgadas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                              <td width="12%"><div align="center"> 
                                                                  <input name="txtgranuladas8" type="text" size="10" value="<?php echo $row8[rechazo_granuladas] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } 
																  else {?>
                                                              <td width="9%"><div align="center"><?php echo "<input name='txtgruesas82' type='text'  value='$txtgruesas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtgruesas82."', '".$row8[rechazo_gruesas]."','G8' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?></div></td>
                                                              <td width="11%"><div align="center"><?php echo "<input name='txtdelgadas82' type='text'  value='$txtdesgadas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtdelgadas82."', '".$row8[rechazo_delgadas]."','D8' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?></div></td>
                                                              <td width="9%"><div align="center"><?php echo "<input name='txtgranuladas82' type='text'  value='$txtgranuladas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtgranuladas82."', '".$row8[rechazo_granuladas]."','Gra8' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?></div></td>
                                                              <td width="9%"><div align="center"> 
                                                                  <input name="txtgruesas8" type="text" size="10" value="<?php echo $row8[rechazo_gruesas] ?>" >
                                                                </div></td>
                                                              <td width="11%"><div align="center"> 
                                                                  <input name="txtdelgadas8" type="text" size="10" value="<?php echo $row8[rechazo_delgadas] ?>" >
                                                                </div></td>
                                                              <td width="12%"><div align="center"> 
                                                                  <input name="txtgranuladas8" type="text" size="10" value="<?php echo $row8[rechazo_granuladas] ?>" >
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php } ?>
                                                              <td><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Recuperado</FONT></div></td>
                                                              <?php if ($opcion <>'M')
															       {
																      $consulta_recuperado="select ifnull(recuperado,0) as recuperado from ref_web.recuperado where fecha='".$fecha."' " ;
																	  $rs_r = mysqli_query($link, $consulta_recuperado);
																	  $row_r = mysqli_fetch_array($rs_r);?>
                                                              <td colspan="3"><div align="center"><?php echo "<input name='txtrecuperado2' type='text'  value='$txtrecuperado2' onBlur=\"Calcula( '0','".$txtgranuladas2."', '".$row_r[recuperado]."','Rec' );\" onKeyDown='TeclaPulsada()' size='10' >";?></div></td>
                                                              <td colspan="3"><div align="center"> 
                                                                  <input name="txtrecuperado" type="text" size="10" value="<?php echo $row_r[recuperado] ?>" style="text-align: center;background:grey;" readonly>
                                                                </div></td>
                                                            </tr>
                                                            <?php }
																else {?>
                                                            <td colspan="3"><div align="center"><?php echo "<input name='txtrecuperado2' type='text'  value='$txtrecuperado2' onBlur=\"Calcula( '0','".$txtgranuladas2."', '".$row_r[recuperado]."','Rec' );\" onKeyDown='TeclaPulsada()' size='10' style='text-align: center;background:grey;' readonly>";?></div></td>
                                                            <?php   $consulta_recuperado="select ifnull(recuperado,0) as recuperado from ref_web.recuperado where fecha='".$fecha."' " ;
																		   $rs_r = mysqli_query($link, $consulta_recuperado);
																		   $row_r = mysqli_fetch_array($rs_r);?>
                                                            <td colspan="3"><div align="center"> 
                                                                <input name="txtrecuperado" type="text" size="10" value="<?php echo $row_r[recuperado] ?>" >
                                                              </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <?php }?>
                                                              <td colspan="3"><div align="center"> 
                                                                  <strong>Ajuste 
                                                                  Laminas Iniciales</strong></div></td>
                                                         <?php   $consulta_ajuste="select ifnull(ajuste,0) as ajuste, tipo from ref_web.ajustes where fecha='".$fecha."' " ;
															   $rs_a = mysqli_query($link, $consulta_ajuste);
															   $row_a = mysqli_fetch_array($rs_a);?>
                                                              <td colspan="1"><div align="center"> 
                                                                  <input name="txtajuste" type="text" id="txtajuste" value="<?php echo $row_a[ajuste] ?>" size="10" >
                                                                </div></td>
															  <td colspan="1"><div align="center"> 
                                                                  <strong>Tipo de Ajuste</strong></div></td>	
                                                              <td colspan="2"><div align="center"> 
                                                                  <input name="txttipo" type="text" id="txttipo" value="<?php echo $row_a[tipo] ?>" size="15" >
                                                                </div></td>
                                                            </tr>
                                                          </table>
<p align="center">&nbsp;</p></TD>
<TD width="2%"><IMG height=1 src="archivos/spaceit.gif"width=10 border=0></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
<TR> 
<TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
<TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD> 
<TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
<TR> 
<TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
</TR>
<TR> 
<TD><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
</font></b> </div></TD>
</TR>
<TR> 
<TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
</TR>
<TR> 
<TD id=rasc> </TD>
</TR>
</TBODY>
</TABLE></TD>
<TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
</TR>
<TR> 
<TD colspan="5"><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
<input name="btnGuardar" type="button" value="Guardar" style="width:60" onClick="JavaScript:Grabar(this.form,' <?php echo $fecha; ?>')" >
</font></b> </div></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
<TR> 
<TD id=ca></TD>
</TR>
<TR> 
<TD bgcolor="#FFFFFF"> 
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR> 
<TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
<TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR> 
                        <TD> <FONT class=small><B>Sistema Jefe Hojas Madres de 
                          Refineria</B><BR>
<font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
<TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
<TR> 
<TD width=20><A href="javascript:salir('<?php echo $fecha ?>');"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
<TD id=st vAlign=center><B><FONT color=#000000>Volver</FONT></B></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
<TR> 
<TD align=middle colSpan=2> <DIV id=tele 
style="DISPLAY: none; PADDING-TOP: 5px"></DIV></TD>
</TR>
</TBODY>
</TABLE></TD>
<TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
<TR> 
<TD> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
<TBODY>
<TR> 
<TD vAlign=bottom width=8><IMG height=8 src="archivos/hbw_line_l.gif" width=8 border=0></TD>
<TD vAlign=bottom width="100%"><IMG height=2 src="archivos/6b8ec6dot.gif" width="100%"></TD>
<TD vAlign=bottom align=right width=8><IMG height=8 src="archivos/hbw_line_r.gif" width=8 border=0></TD>
</TR>
</TBODY>
</TABLE></TD>
</TR>
</TBODY>
</TABLE>
</TD>
</TR>
</TBODY>
</TABLE>

</FORM>
</body>
</html>
