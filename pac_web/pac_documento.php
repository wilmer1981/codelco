
<html>
<head>
<title>Atachar Documento</title>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	switch(Opcion)
	{
		case "G":
		
			f.action='pac_documento.php?Copiar=S';
			f.submit();
			
			break;
		
	}
}
</script>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="FrmPopupProceso">
  <table width="441" border="0" align="center" cellpadding="3" cellspacing="0" class="BordeTabla">
    <tr>
      <td colspan="6" class="TituloTablaCafeBold">Atachar Documentos (Archivos) </td>
    </tr>

   <tr>
     <td align="right" class="texto_bold">RUTA</td>
     <td class="BordeBajo">&nbsp;</td>
     <td colspan="4" class="BordeBajo">
      <input type="text" name="Directorio" size="100" id="Directorio" value="<?php echo $Directorio;?>"></td>
   </tr>
      <td width="3" class="BordeBajo">:</td>
      <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="Calcula
   <tr>
      <td width="107" align="right" class="texto_bold">Documento</td>Dv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<?php echo $TxtRutPrv;?>" size="12" maxlength="10" <?php echo $EstadoRutPrv?>>-->
      <td width="293" colspan="4" class="BordeBajo">
        <input type="file" name="Archivo" id="Archivo">
      </td>
    </tr>
    <tr align="center">
      <td colspan="6" class="texto_bold">
	<input type="button" onClick="JavaScript:Proceso('G')" value="ACEPTAR">
    </tr>
   
  </table>
</form>
</body>
</html>
<?php 

//hola
	if($Copiar=='S')
	{
		if($Archivo_name!='none')
			{
				
				
				if(is_file($Directorio."/".$Archivo_name))
				{
					rename($Directorio."/".$Archivo_name,$Directorio."/".$Archivo_name."-".date('Y_m_d_H_i_s'));	
				}	
					
				if (copy($Archivo, $Directorio."/".$Archivo_name))
				{
				?>
					<script language="javascript">
					alert('Archivo Copiado');
					</script>
				<?php
				}
			
				}	
	}
?>
