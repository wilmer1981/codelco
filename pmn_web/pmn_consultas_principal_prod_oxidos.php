<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo7 {font-size: 14px}
-->
</style>
<form name="PrinElectPLata" method="post">
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="0">
      <tr>
        <td width="98" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Producci&oacute;n Oxidos Ag y Cu </td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','10')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('E','10')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
        <td width="10" align="right" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" class="formulario">Fecha</td>
        <td colspan="4" class="formulario"><select name="Mes">
          <option value="-1" selected="selected">Seleccionar</option>
          <?php
			for ($i=1;$i<=12;$i++)
			{
				if (isset($Mes))
				{
					if ($i == $Mes)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i == $MesActual)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}
		?>
        </select>
&nbsp;
<select name='Ano'>
  <option value="-1" selected="selected">Seleccionar</option>
  <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($Ano))
				{
					if ($i == $Ano)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == $AnoActual)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			?>
</select></td>
        </tr>
      <tr>
        <td colspan="6" class="formulario">&nbsp;</td>
        </tr>
    </table></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<br />
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr class="TituloCabeceraAzul">
        <td width="6%" align="center">D&iacute;a</td>
        <td width="9%" align="center">Hora</td>
        <td width="25%" align="center">Producto</td>
        <td width="27%" align="center">Subproducto</td>
        <td width="9%" align="center">valor</td>
        <td width="24%" align="center">Funcionario</td>
        </tr>
      <?php
	  if($Buscar=='S')
	  {
		  for($K=1;$K<=31;$K++)
		  {
		  	//echo $K."<br>";		
		  
				$Fecha=	$Ano."-".$Mes."-".$K;
				$ConsultaP = "select * from pmn_web.produccion_circulantes_oxidos ";
				$ConsultaP.= " where year(fecha)='".$Ano."' and month(fecha)='".$Mes."' and day(fecha)='".$K."' and cod_producto='39' and cod_subproducto='11'";
				//echo $ConsultaP."<br>";
				//echo $ConsultaP."<br>";
				$RespuestaP = mysqli_query($link, $ConsultaP);
				while ($Filas = mysqli_fetch_array($RespuestaP))
				{
					$Dia=substr($Filas["fecha"],0,10);
					$Dia=explode('-',$Dia);
					$Hora=substr($Filas["fecha"],11,20);		
					?>	
				  <tr>
					<td align="center" bgcolor="#CCCCCC"><?php echo $Dia[2];?></td>
					<td align="center" bgcolor="#CCCCCC"><?php echo $Hora;?></td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.productos where cod_producto ='".$Filas["cod_producto"]."'";
					//echo "producto:     ".$Consulta3."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Producto=$Row3["descripcion"]
					?>
					<td align="left" bgcolor="#CCCCCC"><?php echo ucwords(strtolower($Producto));?>&nbsp;</td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.subproducto where cod_producto ='".$Filas["cod_producto"]."' and cod_subproducto='".$Filas["cod_subproducto"]."'";
					//echo "Subproducto:     ".$Consulta3."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Subproducto=$Row3["descripcion"]
					?>
					<td align="left" bgcolor="#CCCCCC"><?php echo ucwords(strtolower($Subproducto));?>&nbsp;</td>
					<td align="right" bgcolor="#CCCCCC"><?php echo number_format($Filas["valor"],2,',','.');?>&nbsp;</td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.funcionarios where rut ='".$Filas[rut]."'";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Funcionario=$Row3["apellido_paterno"]." ".$Row3["apellido_materno"]." ".$Row3["nombres"]
					?>
					<td align="left" bgcolor="#CCCCCC"><?php echo ucwords(strtolower($Funcionario));?>&nbsp;</td>
				  </tr>
					<?php
				}
		  }		
	  }	
	  ?>	  
    </table>      
    �	</td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
