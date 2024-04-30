<?php include("../principal/conectar_ref_web.php"); 

$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$filtro    = isset($_REQUEST["filtro"])?$_REQUEST["filtro"]:"";
$hora     = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto   = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";
$mostrar  = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";

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
	var f = document.FrmPrincipal;
    cod_filtro=f.cod_filtro.value;
    hora=f.hora.value;
    minuto=f.minuto.value;
    observacion=f.observacion.value;
    situ=f.situ.value;
	
     if (cod_filtro=='x')
      {
	   alert('Debe seleccionar filtro');
	  }
	else if ((f.situ[0].checked==false) && (f.situ[1].checked==false) && (f.situ[2].checked==false) && (f.situ[3].checked==false))
	        {
	         alert('Debe seleccionar situacion del filtro');
	        }
         else {  
			   if (confirm("Esta Seguro de la Operaci�n"))
			     {
				  f.action = "ing_filtros01.php?Proceso=G";
			      f.submit();
			     }
	          }		
}
function salir() // RECARGA PAGINA DE FROMULARIO
{
	var f = document.FrmPrincipal;
	f.action = "filtros.php";
	f.submit();
}

</script>

<BODY>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
 <TR> 
   <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
   <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><B>INGRESADOR DE FILTROS</B></FONT></TD>
   <TD align=right width=9><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
 </TR>
</TABLE>
<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
 <TR> 
  <TD style="BACKGROUND-REPEAT: repeat-x" background="archivos/bg_grad3.gif" bgColor=#d7dce8> <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%"                   border=0>
  <TR> 
    <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
    <TD> 
	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TR> 
  	  <TD><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
    </TR>
    <TR> 
      <TD> 
	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TR> 
        <TD class=size11 width=61><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">FILTRO:</FONT></TD>
        <TD><font size="1"><IMG height=1 src="archivos/spaceit.gif" width=16></font></TD>
        <TD width="36"><div align="left"><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">HORA:</FONT></div></td>
        <TD><font size="1"><IMG height=1 src="archivos/spaceit.gif" width=16></font></TD>
        <TD colspan="3"><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">MINUTO:</FONT></TD>
      </TR>
      <TR> 
        <TD>
        <select name="cod_filtro"  size="1">
        	<option value="x" selected>Seleccionar</option>
       		<?php
			 $Consulta = "SELECT * FROM ref_web.filtros ORDER BY FILTRO";
			 $Respuesta = mysqli_query($link, $Consulta);
			  while ($Row = mysqli_fetch_array($Respuesta))
				{
				  $cod_filtro=$Row["cod_filtro"];
          if ($filtro==$cod_filtro)
          {
                echo "<option value='".$cod_filtro."' selected>".$Row['filtro']."</option>\n";
                    }
                else {
                  echo "<option value='".$Row["cod_filtro"]."'>".$Row["filtro"]."</option>\n";
          }			  	 
				}
            ?>
         </select>
         </TD>
         <TD width=16>&nbsp;</TD>
         <TD><b><font face="Arial, Helvetica, sans-serif"> 
         <select name="hora" size=1 >
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
        </font></b>
		</TD>
        <TD width=16>&nbsp;</TD>
        <TD width="92"><b><font face="Arial, Helvetica, sans-serif"> 
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
       <TD width="751"><b><font face="Arial, Helvetica, sans-serif"> 
       </font></b></TD>
       <TD width="1">&nbsp;</TD>
     </TR>
     </TABLE></TD>                                            
   </TR>
   <TR> 
   <TD align=middle> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
   <TR> 
     <TD width=274> <table cellspacing=0 cellpadding=0 width="100%" border=0>
     <tr> 
       <td width="7%" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
       <td width="93%" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator1.gif" width=12 border=0>
	   <input type="radio" value="En Servicio" name="situ"><FONT  style="FONT-WEIGHT: bold; COLOR: #000000">En Servicio</font></font></td>
     </tr>
     <tr> 
       <td onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
       <td onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator3.gif"  width=12 border=0>
	   <input type="radio" value="En Observacion" name="situ"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Observaci�n</font></font></td>
     </tr>
     <tr> 
       <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
       <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator2.gif"  width=12 border=0>
	   <input type="radio" value="Fuera de Servicio" name="situ"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Fuera de Servicio</font></font></td>
     </tr>
     <tr> 
       <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
       <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator4.gif" width=12 border=0>
	   <input type="radio" value="En Mantencion" name="situ"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Mantenci�n</font></font></td>
     </tr>
  </table>
  <TD>
  <TD width=42>&nbsp;</TD>
  <TD width="657"> <TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TR> 
    <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
  </TR>
  <TR> 
    <TD> 
	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TR> 
      <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
      <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
      <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
    </TR>
    <TR> 
      <TD width="100%" colSpan=3> 
      <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
      <TR> 
      <TD width="0%">&nbsp; 
      </TD>
      <TD width="23%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
      <TD width="49%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Observaciones:</FONT></p>
      <p align="center"><textarea name="observacion" cols="40" rows="10" ></textarea></p>
      <p align="center">&nbsp;</p>
      </TD>
      <TD width="28%"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></TD>
    </TR>
    </TABLE></TD>
   </TR>
   <TR> 
     <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
     <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
     <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
   </TR>
 </TABLE>
   </TD>
  </TR>
  </TABLE>
  </TD>
  </TR>
  </TABLE>
  </TD>
  </TR>
  <TR> 
    <TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
  </TR>
  <TR> 
    <TD><div align="center"><b><font face="Arial, Helvetica, sans-serif"><input type=button  onClick="JavaScript:Validar();"   value="Guardar"  >                            </font></b> </div></TD>
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
   </TABLE>
   </TD>
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
         <TD id=st vAlign=center><A href="javascript:salir();"><B><FONT color=#000000>Volver</FONT></B></A></TD>
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
</BODY>
</HTML>
