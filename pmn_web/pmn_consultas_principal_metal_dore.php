<?php
if(!isset($MesM))
{
	$MesMActual=date('m');
	$MesM=$MesMActual;
}	
if(!isset($AnoM))
{
	$AnoMActual=date('Y');
	$AnoM=$AnoMActual;
}	
	
?>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<table width="65%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="0">
      <tr>
        <td width="135" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
        <td colspan="3" align="center" class="formulario"><strong>Control de Existencia Metal Dore </strong></td>
        <td width="156" align="right" class="formulario"><a href="JavaScript:Proceso('B','1')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;<a href="javascript:Proceso('E','1')"><img src="archivos/excel.png" alt='Imprimir' width="25" height="25" border="0" align="absmiddle" /></a> <a href="javascript:Proceso('GF')"></a>&nbsp; <a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
      </tr>
      <tr>
        <td align="left" class="formulario">Mes - A&ntilde;o </td>
        <td colspan="4" class="formulario"><select name="MesM">
          <option value="-1" selected="selected">Seleccionar</option>
          <?php
			for ($i=1;$i<=12;$i++)
			{
				if (isset($MesM))
				{
					if ($i == $MesM)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i == $MesMActual)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}
		?>
        </select>
&nbsp;
<select name='AnoM'>
  <option value="-1" selected="selected">Seleccionar</option>
  <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoM))
				{
					if ($i == $AnoM)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == $AnoMActual)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			?>
</select></td>
        </tr>
      <tr>
	   <?php
		   $MesAno=explode('-',date('Y-m',mktime(0,0,0,$MesM-1,1,$AnoM)));
		   $Consulta23="select sf_p,si_c from pmn_web.stock_pmn where mes='".$MesM."' and ano='".$AnoM."' and cod_producto='44' and cod_subproducto='1'";
		   $Resp=mysqli_query($link, $Consulta23);
		   if($Fila=mysqli_fetch_array($Resp))
				$Exist=$Fila[si_c];
		?>
        <td class="formulario">Existencia Inicial </td>
        <td colspan="4" class="formulario"><input type="text" name="Exist" size="6" maxlength="4" readonly="" onkeydown="SoloNumeros(true,this)"  value='<?php echo $Exist;?>'/>&nbsp;<a href="javascript:window.print()"></a></td>
        </tr>
      <tr>
        <td colspan="5" class="formulario">&nbsp;</td>
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
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center">
	<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr class="TituloCabeceraAzul">
        <td rowspan="2" align="center">D&iacute;a</td>
        <td colspan="3" align="center">Ingreso Anodos</td>
        <td colspan="3" align="center">Salida Anodos</td>
        <td colspan="3" align="center">Existencia de Anodos</td>
      </tr>
      <tr class="TituloCabeceraAzul">
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
       <?php
		  for($i=1;$i<=31;$i++)
		  {		
				$Fecha=	$AnoM."-".$MesM."-".$i;
			$Consulta = "select * from pmn_web.produccion_horno_trof ";
			$Consulta.= " where fecha='".$Fecha."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);$Cont=1;$Pasa1='N';
			if($Row = mysqli_fetch_array($Respuesta))
				$Pasa1='S';
			$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
			$Consulta.= " where fecha='".$Fecha."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);$Cont=1;$Pasa2='N';
			if($Row = mysqli_fetch_array($Respuesta))
				$Pasa2='S';	
			if($Pasa1=='S' || $Pasa2=='S')				
			{
				//echo $i."<br>";
				$Consulta = "select * from pmn_web.produccion_horno_trof ";
				$Consulta.= " where fecha='".$Fecha."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);$Rows=0;
				while($Row = mysqli_fetch_array($Respuesta))
					$Rows=$Rows+1;
				?>
				<tr>
				<td align="center" ><?php echo $i;?></td>
				<?php		
				//ENTRADAS DE ANODOS
				$Consulta = "select sum(num_anodos) as ProdAnodos from pmn_web.produccion_horno_trof ";
				$Consulta.= " where fecha='".$Fecha."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);$Cont=1;$AnodosProd=0;
				if($Row = mysqli_fetch_array($Respuesta))
				{
					$AnodosProd=$AnodosProd+$Row[ProdAnodos];
					if($AnodosProd=='')
						$AnodosProd=0;	
				}
				else
					$AnodosProd=0;	

				//SALIDA DE ANODOS
				$Consulta2 = "select sum(cant_anodos) as SalidaAnodos from pmn_web.carga_electrolisis_plata ";
				$Consulta2.= " where fecha='".$Fecha."'";
				//echo $Consulta2."<br>";
				$Respuesta2 = mysqli_query($link, $Consulta2);$Cont=1;$AnodosSalida=0;
				if($Row2 = mysqli_fetch_array($Respuesta2))
				{
					$AnodosSalida=$Row2[SalidaAnodos];
					if($AnodosSalida=='')
						$AnodosSalida=0;	
				}	
				else
					$AnodosSalida=0;
					
				$ExistenciaAux=$Exist;
				//echo $ExistenciaAux."+".$AnodosProd."-".$AnodosSalida."<br>";
				$ExistIniF=$ExistenciaAux+$AnodosProd-$AnodosSalida;
				?>
				<td align="right"><?php echo $AnodosProd;?></td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="right"><?php echo $AnodosSalida;?>&nbsp;</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="right"><?php echo $ExistIniF;?></td>
				<td align="center">-</td>
				<td align="center">-</td>
				</tr>
				<?php
				$Exist=$ExistIniF;
		    }		
		 }
	   ?>
    </table>      
 </td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<p>&nbsp;</p>
