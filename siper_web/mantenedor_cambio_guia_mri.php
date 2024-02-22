<?
include('conectar_ori.php');
$TxtDescripcion='';

?>
<html>
<head>
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Graba()
{
	Frm=document.MantenedorPel;
	Frm.action='mantenedor_cambio_guia_mri01.php?Carga=S';
	Frm.submit();
	
}

function Salir()
{
	window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mantenedor Guía MRi</title></head>
</html>
<html>
<head>
</head>

<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="MantenedorPel" method="post"  ENCTYPE="multipart/form-data">
<? echo $ProcesaArchivo;?>
  <table width="80%" align="center" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td align="center">
      <table width="70%" height="87" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
          <td width="820" height="15" background="imagenes/interior2/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" ></td>
          <td width="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
        </tr>
        <tr>
           <td width="15" height="56" background="imagenes/interior2/form_izq.gif"></td>
          <td align="center">
		  
		  <table width="90%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" class="TituloCabecera2">Mantenedor de Guía MRi</td>
			  <td colspan="2" align="right">
			  <a href="javascript:Graba('')"><img src="imagenes/btn_guardar.png" alt='Guarda Guía MRi' border="0" align="absmiddle" /></a>
			  <a href="JavaScript:Salir('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>			  </td>
            </tr>
               <td colspan="3" align="right">&nbsp;</td>
            </tr>
			</table>
			<table width="80%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="24%" align="left" class="TituloCabecera2"><font size="2">Carga Gu&iacute;a (pdf): </font></td>
               <td width="76%" colspan="2" align="left"><span class="formulario2">
                 <input type="file" name="Archivo" id="Archivo" />
               </span></td>
            </tr>
            <tr>
              <td colspan="3" align="center">&nbsp;</td>
			</tr>
			</table>
			</td>
          <td width="15" background="imagenes/interior2/form_der.gif"></td>
        </tr>
        <tr>
          <td height="1%"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
          <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
          <td><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
        </tr>
      </table>
	</td>
</tr>
</table>
</form>
</body>
</html>

<?
	echo "<script languaje='JavaScript'>";
	if($Msj=='S')
		echo "alert('Archivo Reemplazado Exitosamente');";
	if($Msj=='N')
		echo "alert('El Archivo no es el Correcto, Formato de Archivo (PDF)');";
	echo "</script>";

?>