<?php
if($Pag=='1')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
<td rowspan="2" align="center">Día</td>
<td rowspan="2" align="center">Turno</td>
<td colspan="3" align="center">Existencia de Anodos</td>
<td colspan="3" align="center">Ingreso Anodos</td>
<td colspan="3" align="center">Salida Anodos</td>
<td colspan="3" align="center">Personal</td>
</tr>
<tr>
<td align="center">Codelco</td>
<td align="center">Repr.</td>
<td align="center">Circ.</td>
<td align="center">Codelco</td>
<td align="center">Repr.</td>
<td align="center">Circ.</td>
<td align="center">Codelco</td>
<td align="center">Repr.</td>
<td align="center">Circ.</td>
<td align="center">Codelco</td>
<td align="center">Repr.</td>
<td align="center">Circ.</td>
</tr>
</table>
<?php
}
if($Pag=='2')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td rowspan="2" align="center">D&iacute;a</td>
    <td rowspan="2" align="center">Turno</td>
    <td align="center" >Stock</td>
    <td align="center" >Producci&oacute;n</td>
    <td colspan="2" align="center">Preparaci&oacute;n Mezcla </td>
    <td align="center">Stock</td>
    <td colspan="2" align="center">Personal</td>
  </tr>
  <tr>
    <td align="center">Inicial</td>
    <td align="center">Peso Kg. </td>
    <td align="center">Kg. BAD (Lix) </td>
    <td align="center">Lote Tambor </td>
    <td align="center">Final</td>
    <td align="center">Jefe de Turno </td>
    <td align="center">Operador Plasel </td>
  </tr>
</table>
<?php
}
if($Pag=='3')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno</td>
    <td width="9%" align="center" >Lixiviaci&oacute;n</td>
    <td colspan="2" align="center" >Carga</td>
    <td width="10%" align="center">Acido</td>
    <td colspan="2" align="center">Analisis</td>
    <td width="9%" align="center">&lt; T&deg; </td>
    <td width="8%" align="center">Filtrado</td>
    <td width="9%" align="center">Producci&oacute;n</td>
    <td colspan="2" align="center">Personal</td>
  </tr>
  <tr>
    <td align="center">N&deg;</td>
    <td width="7%" align="center">D&iacute;a</td>
    <td width="6%" align="center">Hora</td>
    <td align="center">Lts</td>
    <td width="6%" align="center">Hora</td>
    <td width="6%" align="center">% CU</td>
    <td align="center">Lix - 1 </td>
    <td align="center">Hora</td>
    <td align="center">Peso H20 </td>
    <td width="9%" align="center">Jefe de Turno </td>
    <td width="13%" align="center">Operador Lixiviaci&oacute;n </td>
  </tr>
</table>
<?php
}
if($Pag=='4')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno</td>
    <td width="9%" align="center" >Hornada</td>
    <td colspan="3" align="center" >Barro Anodico(Kg) </td>
    <td width="9%" rowspan="2" align="center">Hora Conexi&oacute;n </td>
    <td colspan="2" align="center">Personal</td>
  </tr>
  <tr>
    <td align="center">N&deg;</td>
    <td width="7%" align="center">Ventana</td>
    <td width="3%" align="center">Externo</td>
    <td width="3%" align="center">Reproceso</td>
    <td width="9%" align="center">Jefe de Turno </td>
    <td width="13%" align="center">Operador Plasel </td>
  </tr>
</table>
<?php
}
if($Pag=='5')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno</td>
    <td width="9%" rowspan="2" align="center" >Existencia Inicial (Kg.) </td>
    <td width="9%" rowspan="2" align="center" >Producci&oacute;n Kg. </td>
    <td colspan="2" align="center" >Beneficio Horno Trof </td>
    <td width="9%" align="center">Stock Final </td>
    <td colspan="2" align="center">Personal</td>
  </tr>
  <tr>
    <td width="7%" align="center">Hornada</td>
    <td width="3%" align="center">Kg.</td>
    <td width="9%" align="center">Kg</td>
    <td width="9%" align="center">Jefe de Turno </td>
    <td width="13%" align="center">Operador H. Trof </td>
  </tr>
</table>
<?php
}
if($Pag=='6')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Te Ppm </td>
    <td width="4%" rowspan="2" align="center">Se Ppm </td>
    <td width="4%" rowspan="2" align="center">Cu Ppm </td>
    <td width="9%" rowspan="2" align="center" >N&deg; Hornada </td>
    <td width="9%" rowspan="2" align="center" >Cantidad anodos </td>
    <td width="7%" rowspan="2" align="center" >Peso Hornada </td>
    <td width="3%" rowspan="2" align="center" >Consumo Gas Natural </td>
    <td width="9%" align="center">Color</td>
    <td colspan="2" align="center">Personal</td>
  </tr>
  <tr>
    <td width="9%" align="center">Anodos</td>
    <td width="9%" align="center">Jefe de Turno </td>
    <td width="13%" align="center">Operador H. Trof </td>
  </tr>
</table>
<?php
}
if($Pag=='7')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno </td>
    <td width="4%" rowspan="2" align="center">Grupo M </td>
    <td width="4%" rowspan="2" align="center">Electrol. N&deg; </td>
    <td width="9%" rowspan="2" align="center" >Correl Homog. </td>
    <td colspan="3" align="center" >Anodos de Carga </td>
    <td colspan="2" align="center">Personal</td>
    <td width="13%" rowspan="2" align="center">Aditivos ISO </td>
  </tr>
  <tr>
    <td width="9%" align="center" >N&deg;</td>
    <td width="7%" align="center" >Hornaa</td>
    <td width="3%" align="center" >Peso</td>
    <td width="9%" align="center">Jefe de Tueno </td>
    <td width="9%" align="center">Operador E-Ag </td>
  </tr>
</table>
<?php
}
if($Pag=='8')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno </td>
    <td width="4%" rowspan="2" align="center">N&deg; Electrolisis  </td>
    <td width="4%" rowspan="2" align="center">M</td>
    <td width="9%" rowspan="2" align="center" >Cantidad Orejas </td>
    <td width="9%" rowspan="2" align="center" >Peso Restos </td>
    <td colspan="2" align="center" >Acumulados</td>
    <td colspan="2" align="center">Personal</td>
  </tr>
  <tr>
    <td width="7%" align="center" >Cantidad</td>
    <td width="3%" align="center" >Peso</td>
    <td width="9%" align="center">Jefe de Tueno </td>
    <td width="9%" align="center">Operador E-Ag </td>
  </tr>
</table>
<?php
}
if($Pag=='9')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno </td>
    <td width="4%" rowspan="2" align="center">Producto </td>
    <td width="4%" rowspan="2" align="center">Peso Kg. </td>
    <td width="9%" rowspan="2" align="center" >Funcionario Entrega </td>
    <td colspan="3" align="center" >Beneficio H. Trof </td>
    <td colspan="2" align="center" >Jefe Turno  </td>
    <td width="5%" rowspan="2" align="center">Operador H. Trof </td>
    <td width="4%" rowspan="2" align="center">CU % </td>
    <td width="9%" rowspan="2" align="center">Pb%</td>
  </tr>
  <tr>
    <td width="4%" align="center" >Hornada</td>
    <td width="2%" align="center" >D&iacute;a</td>
    <td width="3%" align="center" >Turno</td>
    <td width="7%" align="center" >Recibe</td>
    <td width="3%" align="center" >Procesa</td>
  </tr>
</table>
<?php
}
if($Pag=='10')
{
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="4%" rowspan="2" align="center">D&iacute;a</td>
    <td width="4%" rowspan="2" align="center">Turno </td>
    <td width="4%" rowspan="2" align="center">Exis. inic Kg. </td>
    <td width="4%" rowspan="2" align="center">PRoducci&oacute;n Kg.  </td>
    <td colspan="2" align="center" >Beneficio H. Trof </td>
    <td width="3%" colspan="2" rowspan="2" align="center" >Stock Final Kg. </td>
    <td width="5%" rowspan="2" align="center">Jefe de Turno </td>
    <td width="4%" rowspan="2" align="center">Operador H. Trof </td>
  </tr>
  <tr>
    <td width="4%" align="center" >Hornada</td>
    <td width="2%" align="center" >Kg.</td>
  </tr>
</table>
<?php
}
?>