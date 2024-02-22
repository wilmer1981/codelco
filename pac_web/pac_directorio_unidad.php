<?php

if(isset($cl))
{
	if(strtoupper($cl)=='NEMESIS')	
		$ps='S';
	else
		echo "CLAVE INGRESADA NO VALIDA.";	
}
if($ps=='S')
{
	if($Abre!='S')
	{
		?>
<script>
			function abre(directorio)
			{
				var f=document.Frm;f.Directorio.value=directorio.replace('//','/');
				busca();
			}
			function Descarga(directorio,file)
			{
				DDDD="pac_directorio_unidad.php?Abre=S&Dir="+directorio+"&file="+file+"&cl=<?php echo $cl;?>";
				//alert(DDDD)
				opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=100,height=100,scrollbars=1';
				popup=window.open(DDDD,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 1024));
			}
			function Eliminar(directorio,file)
			{
				if(confirm("ESTA SEGURO DE ELIMINAR "+file))
				{
					f=document.Frm;
					window.location="pac_directorio_unidad.php?Abre=N&EM=ELI&Directorio="+directorio+"&Dir="+directorio+"&fileD="+file+"&cl=<?php echo $cl;?>";
					//f.submit();
				}
			}
			function busca()
			{ var f=document.Frm;window.location="pac_directorio_unidad.php?cl=<?php echo $cl;?>&Directorio="+f.Directorio.value;
			}
			</script>
         			<form name="Frm">
<?php

	}
}

if($ps=='S')
{

	
	if($Abre=='S')
	{
		//echo "FILE ".$file."<br>";
		header("Content-disposition: attachment; filename=$file"); 
		//echo "Dir ".$Dir."<br>";
		header("Content-type: application/octet-stream"); 
		readfile($Dir);
	}
	else
	{
			?>
			<table>
			<tr>
			<td><input type="hidden" name="cl" value="<?php echo $cl;?>" />Directorio</td>
			<td><input type="text" name="Directorio" value="<?php echo $Directorio;?>" size="100" />&nbsp;<input type="button" value="Buscar" onclick="busca();" /></td>
			</tr>
			</table>
			
			<?php
			//$dir = "E:/asdtfs/fotografias/respaldos/16302718/";
			if($Directorio!='')
			{
			set_time_limit('4000');
			$dir=$Directorio;
			echo "Directorio Buscado ".$dir."<br>";
			?>
			<table border="1" width="90%">
		<tr align="center" ><td><strong>Nombre</strong></td><td><strong>Fecha Modificaci&oacute;n</strong></td><td><strong>Tama&ntilde;o</strong></td><td><strong>Acci&oacute;n</strong></td>
        </tr>
			<?php
            // Abre un directorio conocido, y procede a leer el contenido
			if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) {
						 ?>	<tr><?php
						//echo "nombre archivo: $file : tipo archivo: " . filetype($dir . $file) . "<br>";
						if(filetype($dir."/".$file)=='dir')
						{
							?><td ><a href="Javascript:abre('<?php echo $dir."/".$file."/"?>')"><?php echo $file;?></a></td><td align="right"><?php echo date ("d/m/Y H:i:s.", filemtime($dir."/".$file));?></td><td align="right"><?php echo number_format((filesize($dir."/".$file)/1024),0)."&nbsp;KB";?></td><td align="right"></td><?php	
						}
						if(filetype($dir."/".$file)=='file')
						{
							?><td ><?php echo $file;?></td><td align="right"><?php echo date ("d/m/Y H:i:s.", filemtime($dir."/".$file));?></td><td align="right"><?php echo number_format((filesize($dir."/".$file)/1024),0)."&nbsp;KB";?></td><td><a href="javascript:Descarga('<?php echo $dir.$file;?>','<?php echo $file;?>')">Descargar</a>&nbsp;
                            <?php
							if(strtolower(substr($file,strlen($file)-4,4))!='.php')
							{
							?>
                            <a href="javascript:Eliminar('<?php echo $dir;?>','<?php echo $file;?>')">Eliminar</a>
                            <?php }?>
                            </td><?php	
						}
						if(filetype($dir."/".$file)=='jpg')
						{
							$base64 = file_get_contents($dir."/".$file);
							$string = chunk_split(base64_encode($base64), 64, "\n");
							?><img src="data:image/jpeg;base64,<?php echo $string;?>" width='55' height='50'><?php
						}
						 ?>	</tr><?php
					}
					closedir($dh);
				}
			}
		}
	}
	if($EM=='ELI')
		{
			if(is_file($Dir.$fileD))
			{
				if(unlink($Dir.$fileD))
				{
					?>
				<script language="javascript">
				alert("Archivo Eliminado");
					var f=document.Frm;
									
					busca();
				</script>
				
				<?php
				
				}
			}
		}
	if($Abre!='S')
	{	?>
		</form>
		<?php
	}
}
else
{	
	?>
    <script>function acc(){ var f=document.eee;f.action="pac_directorio_unidad.php?cl="+f.cl.value;f.submit();}</script>
    <form name="eee">
    <table>
    <tr>
    <td>Ingrese Clave: </td><td><input type="text" name="cl" />&nbsp;<input type="button" name="sss" value="Enviar" onclick="acc();" /></td>
    </tr>
    </table>
    </form>
    <?php	
}

?>