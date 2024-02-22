<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script>
function busqueda()
{
	var f=document.form1;
	f.action='Busqueda.php?buscaropt=S"';
	alert(f.file.value);
	f.submit();
	
}



</script>
<body>
<table width="361" border="1" align="center">
  <tr>
    <td align="center"><form action="" method="post" enctype="multipart/form-data" name="form1">
	<table width="302" border="1">
      <tr align="center">
        <td colspan="2">Busqueda Archivo Mae </td>
        </tr>
      <tr>
        <td width="48">Archivo</td>
        <td width="238"><input type="file" name="file"></td>
      </tr>
      <tr align="center">
        <td colspan="2"><input type="button" name="Enviar" value="Enviar" onClick="busqueda()"></td>
        </tr>
    </table>
	<br>
        </form></td>
  </tr>
</table>
</body>
</html>
