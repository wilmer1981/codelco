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
  $consulta1="select * from ref_web.vapor where fecha='".$fecha."' and instante='1' and TURNO='".$turno."'";
  $respuesta1 = mysqli_query($link, $consulta1);
  if ($fila1=mysqli_fetch_array($respuesta1))
   {
	  $presion1=$fila1[PRE1];
	  $presion2=$fila1[PRE2];
	  $presion3=$fila1[PRE3];
	  $presion4=$fila1[PRE4];
	  $presion13=$fila1[PRE5]; 
	  $temp1=$fila1[TEMP1];
	  $temp2=$fila1[TEMP2];
	  $temp3=$fila1[TEMP3];
	  $temp4=$fila1[TEMP4]; 
	  $temp13=$fila1[TEMP5]; 
	} 
  else {
        $presion1=0;
	    $presion2=0;
	    $presion3=0;
	    $presion4=0; 
		$presion13=0; 
	    $temp1=0;
	    $temp2=0;
	    $temp3=0;
	    $temp4=0; 
		$temp13=0; 
	   }	 
  $consulta1="select * from ref_web.vapor where fecha='".$fecha."' and instante='2' and TURNO='".$turno."'";
  $respuesta1 = mysqli_query($link, $consulta1);
  if ($fila1=mysqli_fetch_array($respuesta1))
   {
	  $presion5=$fila1[PRE1];
	  $presion6=$fila1[PRE2];
	  $presion7=$fila1[PRE3];
	  $presion8=$fila1[PRE4];
	  $presion14=$fila1[PRE5]; 
	  $temp5=$fila1[TEMP1];
	  $temp6=$fila1[TEMP2];
	  $temp7=$fila1[TEMP3];
	  $temp8=$fila1[TEMP4]; 
	  $temp14=$fila1[TEMP5]; 
	}
  else {
        $presion5=0;
	    $presion6=0;
	    $presion7=0;
	    $presion8=0; 
		$presion14=0; 
	    $temp5=0;
	    $temp6=0;
	    $temp7=0;
	    $temp8=0; 
		$temp14=0; 
       }	  
  $consulta1="select * from ref_web.vapor where fecha='".$fecha."' and instante='3' and TURNO='".$turno."'";
  $respuesta1 = mysqli_query($link, $consulta1);
  if ($fila1=mysqli_fetch_array($respuesta1))
   {
	  $presion9=$fila1[PRE1];
	  $presion10=$fila1[PRE2];
	  $presion11=$fila1[PRE3];
	  $presion12=$fila1[PRE4]; 
	  $presion15=$fila1[PRE5]; 
	  $temp9=$fila1[TEMP1];
	  $temp10=$fila1[TEMP2];
	  $temp11=$fila1[TEMP3];
	  $temp12=$fila1[TEMP4]; 
	  $temp15=$fila1[TEMP5]; 
 	}
  else {
        $presion9=0;
	    $presion10=0;
	    $presion11=0;
	    $presion12=0; 
		$presion15=0; 
	    $temp9=0;
	    $temp10=0;
	    $temp11=0;
	    $temp12=0;
		$temp15=0; 
       }	   
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Grabar(f,fecha)
{
 if (f.turno.value=='R')
 {alert ('Debe seleccionar Turno')}
else { f.action ="Ing_vapor01.php?Proceso=G&fecha="+fecha;
       f.submit();}		
}
function Recarga(f,fecha)
{
 f.action="Ing_vapor.php?fecha="+fecha;
 f.submit();
}
function salir() // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "vapor.php";
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
          INGRESADOR DECONDICIONES DEL VAPOR</strong></FONT></TD>
        <TD width=9 align=right><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
      </TR>
      <TR> 
        <TD  bgColor=#6b8ec6 width=9>&nbsp;</TD>
        <TD align="left" bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><strong> 
          Turno: 
          <?php
		      		echo "<select name='turno' onChange=Recarga(this.form,'$fecha')>";
					echo '<option value="R">SELECCIONAR</option>';
					$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
					$respuesta = mysqli_query($link, $consulta);
					while ($fila1=mysqli_fetch_array($respuesta))
 					   {
						if ($turno==$fila1[turno])
						   echo "<option value='".$fila1[turno]."' selected>".$fila1[turno]."</option>";
						else
							echo "<option value='".$fila1[turno]."'>".$fila1[turno]."</option>";
						}
					echo '</select></td>';
                   ?>
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
<td height="25" colspan="11"> 
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
<div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">CONDICIONES 
DE VAPOR</FONT></div></td>
</tr>
<tr> 
<td>&nbsp;</td>
<td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">MATRIZ 
ENTRADA </FONT> 
</div></td>
<td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">CIRCUITOS 
1 a 4</FONT></div></td>
<td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">CIRCUITO 
5</FONT></div></td>
<td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">CIRCUITOS 
6</FONT></div></td>
<td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">CIRCUITOS 
7</FONT></div></td>

</tr>
<tr> 
<td width="20%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">HORA</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">P(Bar)</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">T&ordm;C</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">P(Bar)</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">T&ordm;C</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">P(Bar)</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">T&ordm;C</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">P(Bar)</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">T&ordm;C</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">P(Bar)</FONT></div></td>
<td width="10%"> <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">T&ordm;C</FONT></div></td>
</tr>
<tr> 
<td><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">INICIO TURNO</FONT></div></td>
<td> <div align="center"> 
<input name="presion1" type="text" size="5" value="<?php echo $presion1; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp1" type="text" size="5" value="<?php echo $temp1; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion2" type="text" size="5" value="<?php echo $presion2; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp2" type="text" size="5" value="<?php echo $temp2; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion3" type="text" size="5" value="<?php echo $presion3; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp3" type="text" size="5" value="<?php echo $temp3; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion4" type="text" size="5" value="<?php echo $presion4; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp4" type="text" size="5" value="<?php echo $temp4; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion13" type="text" size="5" value="<?php echo $presion13; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp13" type="text" size="5" value="<?php echo $temp13; ?>" maxlength="5" >
</div></td>

</tr>
<tr> 
<td><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">1/2 TURNO</FONT></div></td>
<td> <div align="center"> 
<input name="presion5" type="text" size="5" value="<?php echo $presion5; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp5" type="text" size="5" value="<?php echo $temp5; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion6" type="text" size="5" value="<?php echo $presion6; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp6" type="text" size="5" value="<?php echo $temp6; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion7" type="text" size="5" value="<?php echo $presion7; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp7" type="text" size="5" value="<?php echo $temp7; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion8" type="text" size="5" value="<?php echo $presion8; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp8" type="text" size="5" value="<?php echo $temp8; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="presion14" type="text" size="5" value="<?php echo $presion14; ?>" maxlength="5" >
</div></td>
<td> <div align="center"> 
<input name="temp14" type="text" size="5" value="<?php echo $temp14; ?>" maxlength="5" >
</div></td>

</tr>
<tr> 
<td width="20%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">FINAL TURNO</FONT></div></td>
<td width="10%"> <div align="center"> 
<input name="presion9" type="text" id="presion9" size="5" value="<?php echo $presion9; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="temp9" type="text" id="temp9" size="5" value="<?php echo $temp9; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="presion10" type="text" id="presion10" size="5" value="<?php echo $presion10; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="temp10" type="text" id="temp10" size="5" value="<?php echo $temp10; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="presion11" type="text" id="presion11" size="5" value="<?php echo $presion11; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="temp11" type="text" id="temp11" size="5" value="<?php echo $temp11; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="presion12" type="text" id="presion12" size="5" value="<?php echo $presion12; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="temp12" type="text" id="temp12" size="5" value="<?php echo $temp12; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="presion15" type="text" id="presion12" size="5" value="<?php echo $presion15; ?>" maxlength="5" >
</div></td>
<td width="10%"> <div align="center"> 
<input name="temp15" type="text" id="temp12" size="5" value="<?php echo $temp15; ?>" maxlength="5" >
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
<TD> <FONT class=small><B>Sistema Jefe Turno de Refineria</B><BR>
<font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
<TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
<TR> 
<TD width=20><A href="javascript:salir();"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
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
