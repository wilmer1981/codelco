﻿<?php include("../principal/conectar_sec_web.php"); 

$carpeta="archivos/";
$ingreso  = isset($_REQUEST["ingreso"])?$_REQUEST["ingreso"]:"Todos";
$dia1     = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d"); 
$mes1     = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");  
$ano1     = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y"); 
$page     = isset($_REQUEST["page"])?$_REQUEST["page"]:"";
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";

$intercambiador = isset($_REQUEST["intercambiador"])?$_REQUEST["intercambiador"]:"";
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Proceso(opcion)
{
	 var frm = document.FrmPrincipal;
     fecha=frm.ano1.value+'-'+frm.mes1.value+'-'+frm.dia1.value;
	 frm.action = "his_intercambiadores.php?fecha="+fecha;
	 frm.submit();

}
function Imprimir()
{
	window.print();
}
</script>
<body>
<FORM action="" method="post" name="FrmPrincipal">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TR  vAlign=top  class=dt> 
  <TD vAlign=bottom> <H4><B>BUSCAR HISTORIA INTERCAMBIADORES</B></H4></TD>
 <?php 
   echo'<TD width="14%" ><div align="right">';
   echo "<a href=\"JavaScript:Imprimir()\">";
   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>'; 
 ?>
 </TR>
 <TR  vAlign=top  class=dt> 
  <TD width="45%" vAlign=bottom colspan=2> 
  <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
   <TR> 
     <TD align=middle width="100%"> 
	 <TABLE cellSpacing=0 cellPadding=0 width="100%"  border=0>
      <TR bgcolor="#FFFFFF"> 
       <TD width="1" align="center">&nbsp;</td>
       <TD width="722" align="center">
       <TABLE height="100%" cellSpacing=0 cellPadding=0    align="center" width="100%" border=0>
         <TR> 
          <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
         </TR>
         <TR> 
           <TD> 
	         <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0>
              <TR> 
               <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7  bord er=0></TD>
               <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
               <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
             </TR>
             <TR> 
              <TD width="100%" colSpan=3>
              <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
               <TR> 
                 <TD width="21%"> <input type=radio value="En Servicio" name=ingreso   <?php if($ingreso=="En Servicio"){echo'checked';} ?>  > 
                 <FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Servicio</font></TD>
                 <TD width="25%"><input type=radio value="Fuera de Servicio" name=ingreso   <?php if($ingreso=="Fuera de Servicio"){echo'checked';} ?>  > 
                 <font style="FONT-WEIGHT: bold; COLOR: #000000">Fuera de Servicio</font> 
                 <TD width="10%"><input type=radio value="Todos" name=ingreso <?php if($ingreso=="Todos"){echo'checked';} ?>  > 
                 <font style="FONT-WEIGHT: bold; COLOR: #000000">Todo</font> 
                 <TD width="44%"><select name="dia1" size="1" >
                <?php
				 for($i=1;$i<31;$i++)
				  {
				   if (isset($dia1))
					 {
					  if ($i == $dia1)
						echo '<option selected value="'.$i.'">'.$i.'</option>';
					 else
						echo '<option value="'.$i.'">'.$i.'</option>';
					 }
				  else
					  {
						if ($i == date("j"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					  }						
				}
			?>
          </select> <b><font face="Arial, Helvetica, sans-serif"> 
          <select name="mes1" size="1">
          <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for($i=1;$i<13;$i++)
				{
				 if (isset($mes1))
				  {
					if ($i == $mes1)
						echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
					else
						echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
				  }
				 else
					 {
					  if ($i == date("n"))
						  echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
					  else
						  echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
				 	}						
				}
		 ?>
         </select>
         <select name="ano1" size="1" id="select2">
         <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
				 if (isset($ano1))
					{
					 if ($i == $ano1)
						echo '<option selected value="'.$i.'">'.$i.'</option>';
					 else
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				 else
					 {
					  if ($i == date("Y"))
						echo '<option selected value="'.$i.'">'.$i.'</option>';
					  else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				}
		 ?>
         </select>
         <input name="submit" type=submit onClick="JavaScript:Proceso('G')" value=Buscar>
         </font></b> <div align="left"><b><font face="Arial, Helvetica, sans-serif"> 
         </font></b><IMG height=8 src="../archivos/spaceit.gif" width=10 border=0><b><font face="Arial, Helvetica, sans-serif"></font></b></div></TR>
         <TR> 
           <TD><input type=radio value="En Observacion" name=ingreso   <?php if($ingreso=="En Observacion"){echo'checked';} ?>  > 
           <font style="FONT-WEIGHT: bold; COLOR: #000000">En Observación</font> </TD>
           <TD width="25%"><input type=radio value="En Mantencion" name=ingreso   <?php if($ingreso=="En Mantencion"){echo'checked';} ?>  > 
           <font style="FONT-WEIGHT: bold; COLOR: #000000">En Mantención</font> 
           <TD width="10%">&nbsp;
           <TD><font style="FONT-WEIGHT: bold; COLOR: #000000">Intercambiador</font> 
           <select name="intercambiador"  size="1">
             <option value="x" selected>Seleccionar</option>
             <?php
				$Consulta = "SELECT * FROM ref_web.intercambiadores ORDER BY INTERCAMBIADOR";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
					{
					  $cod_intercambiador=$Row['cod_intercambiador'];
		              if ($intercambiador==$cod_intercambiador)
		               {
		                echo "<option value='".$cod_intercambiador."' selected>".$Row['intercambiador']."</option>\n";
                       }
                      else {
		                    echo "<option value='".$Row['cod_intercambiador']."'>".$Row['intercambiador']."</option>\n";
			               }
					}
       		?>
         </select></TR>
         </TABLE>
         </TD>
       </TR>
       <TR> 
        <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
        <TD vAlign=bottom> <IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
        <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
       </TR>
       </TABLE>
       </TD>
       </TR>
       <TR> 
          <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
       </TR>
     </TABLE>
     </TD>
   </TR>
   </TABLE></TD>
   </TR>
   </TABLE></TD>
   </TR>
   <TR class=lcol vAlign=top> 
     <TD colSpan=4 bgcolor="#ffffff"> 
     <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
       <TR class=lcol> 
         <TD width=5% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
         <TD width=5% ><div align="center"><font size="6"><strong>SITU</strong></font></div></TD>
         <TD width=15% ><div align="center"><font size="6"><strong>FECHA</strong></font></div></TD>
         <TD width=10% ><div align="center"><font size="6"><strong>HORA</strong></font></div></TD>
         <TD width=20% ><div align="center"><font size="6"><strong>INTERCAMBIADOR</strong></font></div></TD>
         <TD width=60% ><div align="left"><font size="6"><strong>OBSERVACION</strong></font></div></TD>
       </TR>
<?php
     $consulta_f_sist="select left(sysdate(),10) as f_actual";
     $resultado=mysqli_query($link, $consulta_f_sist);
     $row_f_sist = mysqli_fetch_array($resultado);
     $color_i=0;
     if($page=="")
	   {
	    $page =1;
	   }
	 else{}
     if($ingreso=="Todos")
	   {
	    $sql = "select * from ref_web.historia_intercambiadores where fecha between '".$fecha."' and '".$row_f_sist["f_actual"]."' and cod_intercambiador='".$intercambiador."' ORDER BY fecha DESC";
	   }
     else{
	      $sql = "select * from ref_web.historia_intercambiadores WHERE situacion = '$ingreso' and fecha between '".$fecha."' and '".$row_f_sist["f_actual"]."' and cod_intercambiador='".$intercambiador."' ORDER BY fecha DESC";
		 }
	//echo $sql;	 
    $result=mysqli_query($link, $sql);
    $encontrados=1 ;
    $cantidad =1   ;
    $contador=0;
    while($row = mysqli_fetch_array($result))
     {
      $contador=$contador+1   ;
      if($contador >= 10*($page-1))
      {
        if($contador <= 10*$page)
        {
          $situacion= $row["situacion"];
          $cod_equipo=$row["cod_intercambiador"];
		  if($situacion=="En Servicio")
		    {
			 $icono="Indicator1.gif";
			}
		  if($situacion=="Fuera de Servicio")
		    {
			 $icono="Indicator2.gif";
			}
		  if($situacion=="En Observacion")
		    {
			 $icono="Indicator3.gif";
			}
		  if($situacion=="En Mantencion")
		    {
			 $icono="Indicator4.gif";
			}
         $cantidad=$cantidad+1   ;
         $indice=$contador;
         if ( $j==1)
		    {
			 $color= "lcol";
			 $j=0;
			}
		 else{
		      $color= "lcolver";
			  $j=1;
			 } //color fila

		 $sql3 = "select * from ref_web.intercambiadores WHERE cod_intercambiador= '$cod_equipo'";
         $result3=mysqli_query($link, $sql3);
         $row3 = mysqli_fetch_array($result3);
         $equipo=$row3["intercambiador"];
         echo '<TR class='.$color.'>';
         echo '<TD align=center height=15>'.$indice.'</TD>';
         echo '<TD ><div align="center"><img src="archivos/'.$icono.'" width="12" height="12"></div></TD>';
         echo '<TD align=center>'.$row["fecha"].'</TD>';
         echo '<TD align=center>'.$row["hora"].'</TD>';
         echo '<TD align=center>'.$equipo.'</TD>';
         echo '<TD align=left>'.$row["observacion"].'</TD>';
        }
      }
    }
echo ' </TR> ';
echo ' </TABLE> ';
          
$sql="select * from ref_web.historia_intercambiadores where fecha between '".$fecha."' and '".$row_f_sist["f_actual"]."' and cod_intercambiador='".$intercambiador."'";
$result=mysqli_query($link, $sql);
if($row = mysqli_fetch_array($result))
  {
    $cuenta=0  ;
    while($row = mysqli_fetch_array($result))
  	  {
  	    $cuenta=$cuenta+1;
  	  }
  }
$paginas=ceil(($contador/10)) ;
echo '<TR>';
echo '<TD align=middle colSpan=3 >';
echo '<HR>'; 
echo '</TD>'; 
echo '</TR>';
echo '<TR>';
echo '<TD align=middle colSpan=3  bgcolor="#ffffff"> PAGINAS</TD>'; 
echo '</TR>';
echo '<TR>';
echo '<TD align=middle colSpan=3  bgcolor="#ffffff">'; 
if($page != 1) 
  { 
   echo'<A href="his_intercambiadores.php?page='.($page - 1).'&fecha='.$fecha.'"><strong>&lt;&lt;&lt;</strong></A>&nbsp; &nbsp; &nbsp;'; 
  }
$in = 1;
while($in <= $paginas)
  {
   if($in==$page)
     {
       echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT color=#0000FF><b>'.$in.'</b></FONT>&nbsp;&nbsp;&nbsp;';
     }
   else{
        echo '&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;<A href="his_intercambiadores.php?ingreso='.$ingreso.'&amp;page='.$in.'&fecha='.$fecha.'"><FONT class=tiny>'.$in.'</FONT></A>&nbsp;&nbsp;&nbsp;';
        if($in==$paginas)
          {
            echo '&nbsp; &nbsp; &nbsp; <A href="his_intercambiadores.php?page='.($page + 1).'&fecha='.$fecha.'">&gt;&gt;&gt;</A>';
          }
  }
  $in = $in + 1;
 }
 echo '</TD>';
 echo '</TR>';
?>
</TABLE>
</TD> 
</TR> 
<TR>        
 <TD>         
</table>
</FORM>
</BODY>
</HTML>
