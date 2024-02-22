<?php 
if (!isset($NombreUsuario))
	$NombreUsuario="Usuario de Prueba";
if (!isset($FechaUltIngreso))
	$FechaUltIngreso=date("d/m/Y");
if (!isset($HoraUltIng))
	$HoraUltIng=date("H:i");
?>
<table width="98%" cellpadding="2" cellspacing="0">
  <tr>
    <td class="bold">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold" width="635">Bienvenido Sr. <?php echo $NombreUsuario; ?>, &uacute;ltimo ingreso al sistema <?php echo $FechaUltIngreso; ?> a las <?php echo $HoraUltIng; ?> Hrs. </td>
  </tr>
  <tr>
    <td class="titulo_cafe_bold_grande" width="635">Interfaces SAP - Divisi&oacute;n Ventanas
      <hr class="LineaCafe"></td>
  </tr>
  <tr>
    <td class="texto_normal">Este Sistema sirve para tener un orden en el periodo de Integraci&oacute;n <br></td>
  </tr>
  <tr>
    <td align="center" valign="top" class="texto_normal"><br>      
	<table width="95%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="23%">&nbsp;</td>
        <td colspan="4" align="center" class="titulos_tablas"><span class="titulo_rojo_tabla">Solicitudes</span></td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td class="titulos_tablas">Asunto</td>
        <td class="titulos_tablas" width="8%">De<br>      </td>
        <td width="13%" class="titulos_tablas">Para</td>
        <td width="11%" class="titulos_tablas">CC</td>
        <td width="16%" class="titulos_tablas">Fecha Envio </td>
        <td width="15%" class="titulos_tablas">Fecha Lectura </td>
        <td width="14%" class="titulos_tablas">Glosa</td>
      </tr>
      <tr onMouseOver="sobre(this,&#39;#e3e2e2&#39;);" onMouseOut="fuera(this,&#39;#FFFFFF&#39;);" height="20">
        <td class="glosa_tablas_blanco"><a href="">Asunto</a></td>
        <td onMouseOver="sobre(this,&#39;#e3e2e2&#39;);" onMouseOut="fuera(this,&#39;#FFFFFF&#39;);" class="glosa_tablas_blanco">usuario1</td>
        <td onMouseOver="sobre(this,&#39;#e3e2e2&#39;);" onMouseOut="fuera(this,&#39;#FFFFFF&#39;);" class="glosa_tablas_blanco">usuario 2 </td>
        <td class="glosa_tablas_blanco">usuario3</td>
        <td class="glosa_tablas_blanco">01/09/05 09:35 </td>
        <td class="glosa_tablas_blanco">02/09/05 08:30 </td>
        <td class="glosa_tablas_blanco">glosa del msg </td>
      </tr>
    </table></td>
  </tr>
</table>