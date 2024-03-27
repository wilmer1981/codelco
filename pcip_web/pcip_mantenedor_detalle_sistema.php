
<? include("../principal/conectar_pcip_web.php");

if ($Cod!='')
{
	$Consulta="select * from pcip_eec_sistemas t1 ";
	$Consulta.=" where t1.cod_sistema='".$Cod."' ";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtSistema=$Fila["nom_sistema"];
	}
}
?>
<html>
<head>
<title>Equipos Por Sistemas</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Salir()
{
	window.close();
}
</script>
</head>

<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<table width="75%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="730" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_equipo_por_sistema.png"></td>
       <td align="right"><a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
		 <tr>
           <td width="15%" class="formulario2" align="justify">Sistema:</td>
           <td width="85%" class="formulario2" ><? echo $TxtSistema; ?></td>
         </tr>
          <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr align="center">
              
               <td width="8%" class="TituloTablaVerde">Codigo</td>
               <td width="78%" class="TituloTablaVerde">Equipos</td>
             </tr>
             <?
		
				$Consulta = "select t2.cod_equipo,t2.nom_equipo";
				$Consulta.= " from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo";
				$Consulta.=" where t1.cod_sistema='".$Cod."'";
				$Consulta.= " order by cod_equipo ";
				$Resp = mysqli_query($link, $Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {
					$Cod=$Fila["cod_equipo"];
					$Equipo=$Fila["nom_equipo"];
			 ?>
				 <tr class="FilaAbeja">   
				   <td align="center"><? echo $Cod; ?></td>
				   <td ><? echo $Equipo; ?></td>
				 </tr>
             <?
					}
			
         	 ?>
           </table></td>
          </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="1" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="133" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>