<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if ($Elim=="S")
	{
		$Dir = 'doc';
		$Archivo = $Dir."/".$ArchivoElim;
		if (file_exists($Archivo))
			unlink($Archivo);
		$Eliminar="UPDATE pcip_fac_compra_finos_relacion  set adjunto='' where adjunto='".$ArchivoElim."'";
		//echo $Eliminar;
		mysql_query($Eliminar);	
	}	
?>
<title>Informaci�n Archivos Facturas</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="javascript">
function Recarga(Opt)
{
	var f=document.frmPrincipal;

	f.action="pcip_info_relacion_sistema.php?";
	f.submit();
}
function DelFile(arch)
{
	var f=document.frmPrincipal;
	var msg=confirm("�Desea Eliminar este Archivo?");
	if (msg==true)
	{
		f.action="pcip_info_archivos_facturas.php?Elim=S&ArchivoElim="+arch;
		f.submit();
	}
	else
	{
		return;
	}
}
function Salir()
{
	window.close();
}
</script>
<form name="frmPrincipal" action="" method="post">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
<td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="74%" ><img src="archivos/sub_tit_archivos_relacionados.png" /></td><br>
    <td align="right"><a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0" /></a> </td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
<tr>
<td width="33%" height="25"  align="center" class="formulario2">
   Archivos Adjuntos
</span></a></td>  	
</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="1%" align="center" class="TituloTablaVerde"></td>
        <td align="left" class="formulario2"><table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" >
          <tr>
            <td colspan="6" align="left" class="TituloTablaNaranja" >Documentos Existentes</td>
          </tr>
          <tr align="center">
            <td width="18%" class="TituloTablaVerde">Elim.</td>		  
            <td width="18%" class="TituloTablaVerde">Tipo</td>
			<td width="17%" class="TituloTablaVerde">FACT / NC / ND</td>
            <td width="51%" class="TituloTablaVerde">Archivo</td>
            <td width="14%" class="TituloTablaVerde">Tama&ntilde;o(Kb)</td>
          </tr>
          <?
		  $Dir='doc';
		  $Consulta="select t1.numero,t1.adjunto,t2.nombre_subclase as nom_tipo from pcip_fac_compra_finos_relacion t1 ";
		  $Consulta.=" left join proyecto_modernizacion.sub_clase t2 on cod_clase='31018' and t1.tipo_factura=t2.cod_subclase";
		  $Consulta.=" where codigo='".$Cod."' and tipo_factura='1'";
		  $Resp=mysqli_query($link, $Consulta);
		  //echo $Consulta;
		  while($Fila=mysql_fetch_array($Resp))
		  {
				$NomArchivo=explode('_',$Fila[adjunto],2);
				echo "<tr class='FilaAbeja'>\n";
				echo "<td align='center' ><a href=\"JavaScript:DelFile('".$Fila[adjunto]."')\"><img src=\"archivos/elim_hito.png\" border='0' height='18' width='18'></a></td>\n";
				echo "<td align='center'>".$Fila[nom_tipo]."</td>\n";
				echo "<td align='center'>".$Fila[numero]."</td>\n";
				echo "<td ><a href=\"".$Dir."/".$Fila[adjunto]."\" target='_blank'>".$NomArchivo[1]."</a></td>\n";
				$Peso=filesize($Dir."/".$Fila[adjunto]);
				echo "<td align='right'>".number_format($Peso/1000,3,",",".")."</td>\n";
				echo "</tr>\n";
		  }	 
		?>
        </table><p>&nbsp;</p></td>
		<td width="0%" align="center" class="TituloTablaVerde"></td>
      </tr>
		<td width="0%" align="center" class="TituloTablaVerde"></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="TituloTablaVerde"></td>
      </tr>
  </table>
  </td>
    <td width="16" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>	  		
 
</form>