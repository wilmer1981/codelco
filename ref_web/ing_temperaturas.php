<?php
   include("../principal/conectar_ref_web.php");
   $turno     = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
   $fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"0000-00-00";
   if ($turno=="")
	 {
		$Consulta = "select case when CURTIME() between '00:00:00' and '07:59:59' then 'C' else ";
		$Consulta.= " case when CURTIME() between '08:00:00' and '15:59:59' then 'A' else ";
		$Consulta.= " case when CURTIME() between '16:00:00' and '23:59:59' then 'B' end end end as turno ";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
			$turno = $Fila["turno"];
	} 
  $consulta1="select * from ref_web.temperaturas where fecha='".$fecha."' and instante='1' and TURNO='".$turno."'";
  $respuesta1 = mysqli_query($link, $consulta1);
  if ($fila1=mysqli_fetch_array($respuesta1))
   {
	  $inicio1A=$fila1["TEMP1"];
	  $inicio1B=$fila1["TEMP2"];
	  $inicio2A=$fila1["TEMP3"];
	  $inicio2B=$fila1["TEMP4"]; 
	  $inicio3A=$fila1["TEMP5"]; 
	  $inicio3B=$fila1["TEMP6"]; 
	  $inicio4A=$fila1["TEMP7"]; 
	  $inicio4B=$fila1["TEMP8"]; 
	  $inicio5A=$fila1["TEMP9"]; 
	  $inicio5B=$fila1["TEMP10"]; 
	  $inicio6A=$fila1["TEMP11"]; 
	  $inicio6B=$fila1["TEMP12"];
	  $inicio7A=$fila1["TEMP17"]; 
	  $inicio7B=$fila1["TEMP18"];
	  $inicioHMA=$fila1["TEMP13"]; 
	  $inicioHMB=$fila1["TEMP14"]; 
	  $inicioparcialA=$fila1["TEMP15"]; 
	  $inicioparcialB=$fila1["TEMP16"]; 
	}
	else {
	      $inicio1A=0;
		  $inicio1B=0;
		  $inicio2A=0;
		  $inicio2B=0; 
		  $inicio3A=0; 
		  $inicio3B=0; 
		  $inicio4A=0; 
		  $inicio4B=0; 
		  $inicio5A=0; 
		  $inicio5B=0; 
		  $inicio6A=0; 
		  $inicio6B=0; 
		  $inicio7A=0; 
		  $inicio7B=0; 
		  $inicioHMA=0; 
		  $inicioHMB=0; 
		  $inicioparcialA=0; 
		  $inicioparcialB=0; 
		 }  
  $consulta1="select * from ref_web.temperaturas where fecha='".$fecha."' and instante='2' and TURNO='".$turno."'";
  $respuesta1 = mysqli_query($link, $consulta1);
  if ($fila1=mysqli_fetch_array($respuesta1))
   {
	  $medio1A=$fila1["TEMP1"];
	  $medio1B=$fila1["TEMP2"];
	  $medio2A=$fila1["TEMP3"];
	  $medio2B=$fila1["TEMP4"]; 
	  $medio3A=$fila1["TEMP5"]; 
	  $medio3B=$fila1["TEMP6"]; 
	  $medio4A=$fila1["TEMP7"]; 
	  $medio4B=$fila1["TEMP8"]; 
	  $medio5A=$fila1["TEMP9"]; 
	  $medio5B=$fila1["TEMP10"]; 
	  $medio6A=$fila1["TEMP11"]; 
	  $medio6B=$fila1["TEMP12"];
	  $medio7A=$fila1["TEMP17"]; 
	  $medio7B=$fila1["TEMP18"];
	  $medioHMA=$fila1["TEMP13"]; 
	  $medioHMB=$fila1["TEMP14"]; 
	  $medioparcialA=$fila1["TEMP15"]; 
	  $medioparcialB=$fila1["TEMP16"]; 
	}
   else {
          $medio1A=0;
		  $medio1B=0;
		  $medio2A=0;
		  $medio2B=0; 
		  $medio3A=0; 
		  $medio3B=0; 
		  $medio4A=0; 
		  $medio4B=0; 
		  $medio5A=0; 
		  $medio5B=0; 
		  $medio6A=0; 
		  $medio6B=0;
		  $medio7A=0; 
		  $medio7B=0;
		  $medioHMA=0; 
		  $medioHMB=0; 
		  $medioparcialA=0; 
		  $medioparcialB=0; 
		}	  
  $consulta1="select * from ref_web.temperaturas where fecha='".$fecha."' and instante='3' and TURNO='".$turno."'";
  $respuesta1 = mysqli_query($link, $consulta1);
  if ($fila1=mysqli_fetch_array($respuesta1))
   {
	  $fin1A=$fila1["TEMP1"];
	  $fin1B=$fila1["TEMP2"];
	  $fin2A=$fila1["TEMP3"];
	  $fin2B=$fila1["TEMP4"]; 
	  $fin3A=$fila1["TEMP5"]; 
	  $fin3B=$fila1["TEMP6"]; 
	  $fin4A=$fila1["TEMP7"]; 
	  $fin4B=$fila1["TEMP8"]; 
	  $fin5A=$fila1["TEMP9"]; 
	  $fin5B=$fila1["TEMP10"]; 
	  $fin6A=$fila1["TEMP11"]; 
	  $fin6B=$fila1["TEMP12"]; 
	  $fin7A=$fila1["TEMP17"]; 
	  $fin7B=$fila1["TEMP18"]; 
	  $finHMA=$fila1["TEMP13"]; 
	  $finHMB=$fila1["TEMP14"]; 
	  $finparcialA=$fila1["TEMP15"]; 
	  $finparcialB=$fila1["TEMP16"]; 
	}  
  else {
          $fin1A=0;
		  $fin1B=0;
		  $fin2A=0;
		  $fin2B=0; 
		  $fin3A=0; 
		  $fin3B=0; 
		  $fin4A=0; 
		  $fin4B=0; 
		  $fin5A=0; 
		  $fin5B=0; 
		  $fin6A=0; 
		  $fin6B=0;
		  $fin7A=0; 
		  $fin7B=0;
		  $finHMA=0; 
		  $finHMB=0; 
		  $finparcialA=0; 
		  $finparcialB=0; 
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
else { f.action ="Ing_temperaturas01.php?Proceso=G&fecha="+fecha;
       f.submit();}		
}
function Recarga(f,fecha)
{
 f.action="Ing_temperaturas.php?fecha="+fecha+"&turno="+f.turno.value;
 f.submit();
}
function salir() // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "temperaturas.php";
	frm.submit();
}
</script>
</head>
<LINK href="../archivos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="../archivos/petalos.css" rel=stylesheet type=text/css>

<body>
<form name="FrmPrincipal" method="post" action="">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TR> 
      <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
      <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><strong> 
        INGRESADOR DE TEMPERATURAS</strong></FONT></TD>
      <TD width=9 align=right><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
    </TR>
    <TR> 
      <TD  bgColor=#6b8ec6 width=9>&nbsp;</TD>
      <TD align="left" bgColor=#6b8ec6> <strong><font color="#FFFFFF"> Turno:</font></strong> 
        <?php  
		          
					echo "<select name='turno' onChange=Recarga(this.form,'$fecha')>";
					echo '<option value="R">SELECCIONAR</option>';
					$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
					$respuesta = mysqli_query($link, $consulta);
					while ($fila1=mysqli_fetch_array($respuesta))
 					   {
						if ($turno==$fila1["turno"])
						   echo "<option value='".$fila1["turno"]."' selected>".$fila1["turno"]."</option>";
						else
							echo "<option value='".$fila1["turno"]."'>".$fila1["turno"]."</option>";
						}
					echo '</select></td>';
                   ?>
      </TD>
      <TD width=9  bgColor=#6b8ec6 align=right>&nbsp;</TD>
    </TR>
  </TABLE>
<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR> 
 <TD style="BACKGROUND-REPEAT: repeat-x" background="archivos/bg_grad3.gif" bgColor=#d7dce8> <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%"                   border=0>
 <TR> 
 <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
 <TD> 
 <TABLE cellSpacing=0 cellPadding=0 width="95%" border=0>
  <TR> 
   <TD><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
  </TR>
  <TR> 
    <TD>&nbsp; </TD>
  </TR>
  <TR> 
    <TD align=middle> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TR> 
        <TD width=44>&nbsp; </TD>
        <TD width="722"> <TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TR> 
          <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
        </TR>
        <TR> 
          <TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
          <TR> 
          <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
          <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
          <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
        </TR>
        <TR> 
          <TD width="100%" colSpan=3> <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
          <TR> 
           <TD width="0%">&nbsp; </TD>
           <TD width="1%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
           <TD width="97%"><p>&nbsp;</p>
           <table width="76%" border="1" align="center">
           <tr> 
           <td height="25" colspan="19"> 
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
           <div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">TEMPERATURAS DE CIRCUITOS</FONT></div></td>
          </tr>
          <tr> 
            <td width="34%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">HORA</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">1</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">2</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">3</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">4</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">5</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">6</FONT></div></td>
			<td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">7</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">HM</FONT></div></td>
            <td colspan="2"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Parcial</FONT></div></td>
          </tr>
          <tr> 
            <td width="34%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">INI.TURNO</FONT></div></td>
            <td width="4%"><div align="center"><input name="inicio1A" type="text" value="<?php echo $inicio1A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio1B" type="text" value="<?php echo $inicio1B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio2A" type="text" value="<?php echo $inicio2A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio2B" type="text" value="<?php echo $inicio2B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio3A" type="text" value="<?php echo $inicio3A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio3B" type="text" value="<?php echo $inicio3B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio4A" type="text" value="<?php echo $inicio4A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio4B" type="text" value="<?php echo $inicio4B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio5A" type="text" value="<?php echo $inicio5A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio5B" type="text" value="<?php echo $inicio5B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio6A" type="text" value="<?php echo $inicio6A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio6B" type="text" value="<?php echo $inicio6B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio7A" type="text" value="<?php echo $inicio7A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicio7B" type="text" value="<?php echo $inicio7B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicioHMA" type="text" value="<?php echo $inicioHMA; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicioHMB" type="text" value="<?php echo $inicioHMB; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="inicioparcialA" type="text" value="<?php echo $inicioparcialA; ?>" size="3" maxlength="5" ></div></td>
            <td width="6%"><div align="center"><input name="inicioparcialB" type="text" value="<?php echo $inicioparcialB; ?>" size="3" maxlength="5" ></div></td>
          </tr>
          <tr> 
            <td width="34%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">1/2 TURNO</FONT></div></td>
            <td width="4%"><div align="center"><input name="medio1A" type="text" value="<?php echo $medio1A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio1B" type="text" value="<?php echo $medio1B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio2A" type="text" value="<?php echo $medio2A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio2B" type="text" value="<?php echo $medio2B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio3A" type="text" value="<?php echo $medio3A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio3B" type="text" value="<?php echo $medio3B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio4A" type="text" value="<?php echo $medio4A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio4B" type="text" value="<?php echo $medio4B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio5A" type="text" value="<?php echo $medio5A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio5B" type="text" value="<?php echo $medio5B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio6A" type="text" value="<?php echo $medio6A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio6B" type="text" value="<?php echo $medio6B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio7A" type="text" value="<?php echo $medio7A; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medio7B" type="text" value="<?php echo $medio7B; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medioHMA" type="text" value="<?php echo $medioHMA; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medioHMB" type="text" value="<?php echo $medioHMB; ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="medioparcialA" type="text" value="<?php echo $medioparcialA; ?>" size="3" maxlength="5" ></div></td>
            <td width="6%"><div align="center"><input name="medioparcialB" type="text" value="<?php echo $medioparcialB; ?>" size="3" maxlength="5" ></div></td>
         </tr>
         <tr> 
            <td width="34%"><div align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">FIN TURNO</FONT></div></td>
            <td width="4%"><div align="center"><input name="fin1A" type="text" value="<?php echo $fin1A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin1B" type="text" value="<?php echo $fin1B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin2A" type="text" value="<?php echo $fin2A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin2B" type="text" value="<?php echo $fin2B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin3A" type="text" value="<?php echo $fin3A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin3B" type="text" value="<?php echo $fin3B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin4A" type="text" value="<?php echo $fin4A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin4B" type="text" value="<?php echo $fin4B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin5A" type="text" value="<?php echo $fin5A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin5B" type="text" value="<?php echo $fin5B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin6A" type="text" value="<?php echo $fin6A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin6B" type="text" value="<?php echo $fin6B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin7A" type="text" value="<?php echo $fin7A ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="fin7B" type="text" value="<?php echo $fin7B ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="finHMA" type="text" value="<?php echo $finHMA ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="finHMB" type="text" value="<?php echo $finHMB ?>" size="3" maxlength="5" ></div></td>
            <td width="4%"><div align="center"><input name="finparcialA" type="text" value="<?php echo $finparcialA ?>" size="3" maxlength="5" ></div></td>
            <td width="6%"><div align="center"><input name="finparcialB" type="text" value="<?php echo $finparcialB ?>" size="3" maxlength="5" ></div></td>
         </tr>
 </table>
 <p align="center">&nbsp;</p></TD>
 <TD width="2%"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></TD>
</TR>
</TABLE></TD>
</TR>
<TR> 
  <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
  <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
  <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
<TR> 
   <TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
</TR>
<TR> 
  <TD><div align="center"><b><font face="Arial, Helvetica, sans-serif"></font></b> </div></TD>
</TR>
<TR> 
  <TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
</TR>
<TR> 
  <TD id=rasc> </TD>
</TR>
</TABLE></TD>
<TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
</TR>
<TR> 
  <TD colspan="5"><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
                </font></b> <b><font face="Arial, Helvetica, sans-serif"> 
                <input name="btnGuardar" type="button" value="Guardar" style="width:60" onClick="JavaScript:Grabar(this.form,' <?php echo $fecha; ?>')" >
                </font></b></div></TD>
</TR>
</TABLE></TD>
</TR>
<TR> 
   <TD id=ca></TD>
</TR>
<TR> 
   <TD bgcolor="#FFFFFF"> 
   <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
   <TR> 
     <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
     <TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
     <TR> 
        <TD> <FONT class=small><B>Sistema Jefe Turno de Refineria</B><BR><font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
        <TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
        <TR> 
          <TD width=20><A href="javascript:salir();"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
          <TD id=st vAlign=center><A href="javascript:SF();"><B><FONT color=#000000>Volver</FONT></B></A></TD>
        </TR>
     </TABLE></TD>
     </TR>
     <TR> 
        <TD align=middle colSpan=2> <DIV id=tele style="DISPLAY: none; PADDING-TOP: 5px"></DIV></TD>
     </TR>
   </TABLE></TD>
   <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
   </TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
<TR> 
   <TD> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
   <TR> 
     <TD vAlign=bottom width=8><IMG height=8 src="archivos/hbw_line_l.gif" width=8 border=0></TD>
     <TD vAlign=bottom width="100%"><IMG height=2 src="archivos/6b8ec6dot.gif" width="100%"></TD>
     <TD vAlign=bottom align=right width=8><IMG height=8 src="archivos/hbw_line_r.gif" width=8 border=0></TD>
   </TR>
   </TABLE></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</FORM>
</body>
</html>
