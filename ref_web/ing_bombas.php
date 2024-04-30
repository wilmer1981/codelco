<?php 
include("../principal/conectar_ref_web.php"); 

$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$iso   = isset($_REQUEST["iso"])?$_REQUEST["iso"]:"";
$circuito   = isset($_REQUEST["circuito"])?$_REQUEST["circuito"]:"";
$bomba   = isset($_REQUEST["bomba"])?$_REQUEST["bomba"]:"";
$hora   = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto   = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";

?>

<HTML>
<HEAD>
<TITLE>Corto Circuitos</TITLE>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="../archivos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="../archivos/petalos.css" rel=stylesheet type=text/css>

<script language="JavaScript">
function Validar()
{
	var frm = document.FrmPrincipal;
    bomba=frm.bomba.value;
    hora=frm.hora.value;
    minuto=frm.minuto.value;
    observacion=frm.observacion.value;
    situ=frm.situ.value;
	if (frm.checkbox.checked)
	   {
	     var iso='S';
	   }
	else {
           var iso='N';	
	     }   
   if (bomba=='x')
      {
	   alert('Debe seleccionar bomba');
	  }
   else if ((frm.situ[0].checked==false) && (frm.situ[1].checked==false) && (frm.situ[2].checked==false) && (frm.situ[3].checked==false))	  
           {alert('Debe seleccionar situacion de la bomba');}
        else {  
			  if (confirm("Esta Seguro de la Operación"))
			    {
			     frm.action = "ing_bombas01.php?Proceso=G&iso="+iso;
			     frm.submit();
			    }
	      }		
	
}
function Recarga(frm,Pagina) // RECARGA PAGINA DE FROMULARIO
{
	frm.action = Pagina;
	frm.submit();
}

function salir() // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "bombas.php";
	frm.submit();
}

</script>

<BODY>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
 <TR> 
  <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
  <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><B>INGRESADOR 
      DE BOMBAS</B></FONT><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">FECHA :&nbsp;&nbsp;&nbsp;<?php  echo $fecha; ?></FONT></b></b></TD>
  <TD align=right width=9><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
 </TR>
</TABLE>
<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
 <TR> 
  <TD height="263" background="archivos/bg_grad3.gif" bgColor=#d7dce8 style="BACKGROUND-REPEAT: repeat-x"> 
  <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TR> 
    <TD width=7><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
    <TD width="984"> 
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TR> 
	  <TD><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
    </TR>
    <TR> 
      <TD> 
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TR> 
      <TD width=183 class=size11><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">CIRCUITO:</FONT></TD>
      <TD width="16">&nbsp;</TD>
      <TD width="123"><font size="1" style="FONT-WEIGHT: bold; COLOR: #000000">BOMBA:</font></TD>
      <TD width="17">&nbsp;</TD>
      <TD width="45"><font size="1" style="FONT-WEIGHT: bold; COLOR: #000000">HORA:</font></TD>
      <TD width="16">&nbsp;</TD>
      <TD width="365"><font size="1" style="FONT-WEIGHT: bold; COLOR: #000000">MINUTO:</font></TD>
      <TD width="1">&nbsp;</TD>
   </TR>
  <TR> 
     <TD>
     <select name="circuito"  size="1" onChange="JavaScript:Recarga(document.FrmPrincipal,'ing_bombas.php');">
   	 <option value="x" selected>Seleccionar</option>
     <?php
		$Consulta = "SELECT * FROM circuitos_bombas ORDER BY circuito";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Row = mysqli_fetch_array($Respuesta))
		   {
			$cod_circuito=$Row['cod_circuito'];
            if($circuito==$cod_circuito)
              {
			   echo "<option value='".$cod_circuito."' selected>".$Row['circuito']."</option>\n";
              }
			else
			    {
				 echo "<option value='".$cod_circuito."' >".$Row['circuito']."</option>\n";
				}
		   }
  	?>
    </select>
    </TD>
    <TD>&nbsp;</TD>
    <TD>
    <select name="bomba"  size="1">
    <option value="x" selected>Seleccionar</option>
    <?php
	   $Consulta = "SELECT * FROM ref_web.bombas WHERE cod_circuito = '".$circuito."'  ORDER BY bomba";
	   $Respuesta = mysqli_query($link, $Consulta);
	   while ($Row = mysqli_fetch_array($Respuesta))
		   {
		     $cod_bomba=$Row["cod_bomba"];
			 if ($bomba==$cod_bomba)
			    {
			   echo "<option value='".$cod_bomba."' selected>".$Row['bomba']."</option>\n";
                }
             else {
			       echo "<option value='".$Row['cod_bomba']."'>".$Row['bomba']."</option>\n";
				  }
		   }
    ?>
    </select>
    </TD>
    <TD>&nbsp;</TD>
    <TD><b><font face="Arial, Helvetica, sans-serif"> 
    <select name="hora"  >
	<?php
       for($i=0; $i<=23; $i++)
		 {
			if (($mostrar == "S") && ($i == $hora))
				echo '<option selected value ="'.$i.'">'.$i.'</option>';
			else if (($i == date("H")) && ($mostrar != "S"))
				     echo '<option selected value="'.$i.'">'.$i.'</option>';
			else	
				echo '<option value="'.$i.'">'.$i.'</option>';
		 }
	?>
     </select>
     </font></b></TD>
     <TD>&nbsp;</TD>
     <TD><b><font face="Arial, Helvetica, sans-serif"> 
     <select name="minuto" size=1 >
             <?php
		 	   for($i=0; $i<=59; $i++)
			     {
				  if (($mostrar == "S") && ($i == $minuto))
					  echo '<option selected value ="'.$i.'">'.$i.'</option>';
				  else if (($i == date("i")) && ($mostrar != "S"))
					  echo '<option selected value ="'.$i.'">'.$i.'</option>';
				  else	
					  echo '<option value="'.$i.'">'.$i.'</option>';
			     }
		     ?>
      </select>
      </font></b></TD>
      <TD>&nbsp;</TD>
    </TR>
    </TABLE></TD>                                            
	</TR>
    <tr> 
      <td height="153" colspan="2" align="center"><table cellspacing=0 cellpadding=0 width="63%" border=0 class="TablaPrincipal">
                      <tbody>
                        <tr> 
                          <td width="9" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
                          <td width="317" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator1.gif" width=12 border=0> 
                            <input type="radio" value="En Servicio" name="situ">
                            <font  style="FONT-WEIGHT: bold; COLOR: #000000">En 
                            Servicio</font></font></td>
                          <td width="80" rowspan="4"  class="Detalle02" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';" title="hola"><div align="center"><strong><font size="H7">ISO</font></strong></div></td>
						  <?php if ($iso=='S')
				       { ?>
					     <td width="29" height="12" rowspan="4" class="Detalle02" align="center"> <input type="checkbox" name="checkbox" value="<?php echo $iso; ?>" checked>  
					<?php }
					 else { ?>
					       <td width="36" height="12" rowspan="4"  class="Detalle02" align="center"> <input type="checkbox" name="checkbox" value="N" >
					   <?php } ?>
                        </tr>
                        <tr> 
                          <td onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
                          <td onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator3.gif"  width=12 border=0> 
                            <input type="radio" value="En Observacion" name="situ">
                            <font style="FONT-WEIGHT: bold; COLOR: #000000">En 
                            Observación</font></font></td>
                        </tr>
                        <tr> 
                          <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
                          <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator2.gif"  width=12 border=0> 
                            <input  type="radio" value="Fuera de Servicio" name="situ">
                            <font style="FONT-WEIGHT: bold; COLOR: #000000">Fuera 
                            de Servicio</font></font></td>
                        </tr>
                        <tr> 
                          <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
                          <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator4.gif" width=12 border=0> 
                            <input  type="radio" value="En Mantencion" name="situ">
                            <font style="FONT-WEIGHT: bold; COLOR: #000000">En 
                            Mantención</font></font></td>
                        </tr>
                      </tbody>
                    </table>
                    <p><b><font face="Arial, Helvetica, sans-serif">
                      <input name="button" type="button"  onclick="Validar();"   value="Guardar"  >
                      </font></b></p>
                    </td>
      <td rowspan="2" align="center"><textarea name="observacion" cols="30" rows="10" ></textarea></td>
    </tr>
    </TABLE></TD>
    </TR>
    <TR> 
      <TD width=7 height="8"><IMG height=7 src="archivos/hbw_Corner3.gif"  width=7 border=0></TD>
      <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif"  width="100%"></TD>
      <TD width=32><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
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
      <TD><div align="center"><b><font face="Arial, Helvetica, sans-serif"> </font></b> 
      </div></TD>
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
              <TD width=20><a href="JavaScript:salir();"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
              <TD id=st vAlign=center><a href="JavaScript:salir();"><B><FONT color=#000000>Volver</FONT></B></A></TD>
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
</FORM>
</BODY>
</HTML>
