<? include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
if ($Elim=="S")
	{
		$Dir = 'doc';
		$Archivo=$ArchivoElim;
		$ArchivoElim = $Dir."/".$ArchivoElim;
		if (file_exists($ArchivoElim))
			unlink($ArchivoElim);
		$Eliminar="delete from sget_documentos where nombre_archivo='".$Archivo."'";
		mysql_query($Eliminar);	
	}	
	?> 
	<title>
Documentos Existentes
</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">

<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
	
function Proceso(Op)	
{
	var f=document.FrmProceso;
	switch (Op)
	{
		case 'S':
			window.opener.document.FrmProceso.action="sget_hoja_ruta.php?Pagina="+f.Pagina.value+"&Opt=M&TxtHoja="+f.TxtHoja.value;
			window.opener.document.FrmProceso.submit();		
			window.close();	
		break;
	}
}
	
function DelFile(arch)
{
	var f=document.FrmProceso;
	var msg=confirm("�Desea Eliminar este Archivo?");
	if (msg==true)
	{
		f.action="sget_cant_documento_solp.php?Elim=S&ArchivoElim="+arch;
		f.submit();
	}
	else
	{
		return;
	}
}
</script>
<form name="FrmProceso" action="" method="post" ENCTYPE="multipart/form-data">
	  <input type="hidden" name="TxtHoja"  value="<? echo $TxtHoja;?>" />
	   <input type="hidden" name="Pagina"  value="<? echo $Pagina;?>" />
	<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="928" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" >
		
			<tr>
		<td colspan="4" align="right" ><a href="JavaScript:Proceso('S')"><img src="archivos/close.png"  alt="Cerrar" border="0" align="absmiddle" /></a></td>
		</tr>
		
		<tr>
		<td colspan="4" align="left" class="TituloTablaNaranja" >Documentos Existentes</td>
		</tr>
		<tr align="center">
		  <td width="5%" class="TituloCabecera">Elim</td>
		  <td width="50%" class="TituloCabecera">Archivo</td>
		  <td width="30%" class="TituloCabecera">Fecha</td>
		  <td width="15%" class="TituloCabecera">Tama&ntilde;o(Kb)</td>
	    </tr>
		<?
		$ArrArchivos = array();
		$Dir='doc';
		$Directorio=opendir('doc');
		$i=0;
		while ($Archivo = readdir($Directorio)) 
		{
			if($Archivo != '..' && $Archivo !='.' && $Archivo !='')
			{ 		
				
				//echo $Archivo." - ".substr($Archivo,4,9)."-".substr($Archivo,0,1)."<br>";
				if(str_pad($TxtHoja,9,'0',STR_PAD_LEFT)==substr($Archivo,4,9) && substr($Archivo,0,1) =='H')
				{
					$FechaHora = date("d-m-Y H:i:s", filemtime($Dir."/".$Archivo));
					$Peso = filesize($Dir."/".$Archivo);
					$ArrArchivo[$i][0] = $Archivo;
					$ArrArchivo[$i][1] = $FechaHora;
					$ArrArchivo[$i][2] = $Peso;
				}	
			}
			$i++;
		}
		closedir($Directorio);
		if (count($ArrArchivo)>0)
		{
			reset($ArrArchivo);
			krsort($ArrArchivo);
			while (list($k,$v)=each($ArrArchivo))
			{		
				echo "<tr>\n";
				echo "<td align='center' ><a href=\"JavaScript:DelFile('".$v[0]."')\"><img src=\"archivos/elim_hito.png\" border='0' height='18' width='18'></a></td>\n";
				echo "<td ><a href=\"".$Dir."/".$v[0]."\" target='_blank'>".substr($v[0],14)."</a></td>\n";
				echo "<td align='center' >".str_replace('-','/',$v[1])."</td>\n";
				echo "<td align='right'>".number_format($v[2]/1000,3,",",".")."</td>\n";
				echo "</tr>\n";
			}
		}
		clearstatcache();
		?>
			
 </table></td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
   </table>
	</form>