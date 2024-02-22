<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo7 {font-size: 14px}
-->
</style>
<form name="PrinElectPLata" method="post">
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
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
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Carga Electrolisis de Plata (Mov de Anodos)</td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','7')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('E','7')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
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
<table width="80%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td width="4%" colspan="11" align="left" >Mes - A&ntilde;o </td>
	  </tr>	
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td width="4%" rowspan="2" align="center" >D&iacute;a</td>
        <td width="7%" rowspan="2" align="center">Turno </td>
        <td width="7%" rowspan="2" align="center">Grupo M </td>
        <td width="9%" rowspan="2" align="center">Electrol. N&deg; </td>
        <td width="7%" rowspan="2" align="center" >Correl Homog. </td>
        <td colspan="3" align="center" >Anodos de Carga </td>
        <td colspan="2" align="center">Personal</td>
        <td width="7%" rowspan="2" align="center">Aditivos ISO </td>
      </tr>
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td width="7%" align="center" >N&deg;</td>
        <td width="7%" align="center" >Hornada</td>
        <td width="8%" align="center" >Peso</td>
        <td width="18%" align="center">Jefe de Tueno </td>
        <td width="16%" align="center">Operador E-Ag </td>
      </tr>
	  <?php
	  if($Buscar=='S')
	  {
	  	?>
			<tr>
			  <td colspan="11" align="left" class="titulo_azul"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
			</tr>
	    <?php
		  for($K=1;$K<=31;$K++)
		  {
				$Fecha=	$Ano."-".$Mes."-".$K;
				$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
				$Consulta.= " where fecha ='".$Fecha."'";	  
				$Consulta.= " group by fecha  order by fecha asc, turno, grupo, num_electrolisis, hornada, correlativo";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Fecha=explode('-',$Row["fecha"]);
					$Ano=$Fecha[0];
					$Mes=$Fecha[1];
					$Dia=$Fecha[2];
		
					$Consulta1 = "select * from pmn_web.carga_electrolisis_plata ";
					$Consulta1.= " where fecha='".$Row["fecha"]."'";	  
					$Consulta1.= " order by turno, grupo, num_electrolisis, hornada, correlativo";
					$Respuesta1 = mysqli_query($link, $Consulta1);
					$Cont=0;
					while ($Row1 = mysqli_fetch_array($Respuesta1))
						$Cont=$Cont+1;
					?>
					<tr >
					<td rowspan="<?php echo $Cont;?>" align="center" bgcolor="#CCCCCC"><?php echo $Dia;?></td>
					<?php
					$Consulta2 = "select * from pmn_web.carga_electrolisis_plata ";
					$Consulta2.= " where fecha='".$Row["fecha"]."'";	  
					$Consulta2.= " order by turno, grupo, num_electrolisis, hornada, correlativo";			
					$Respuesta2 = mysqli_query($link, $Consulta2);
					$i=1;$Total=0;
					while ($Row2= mysqli_fetch_array($Respuesta2))
					{
						$Consulta3 = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row2[turno];
						$Resp3 = mysqli_query($link, $Consulta3);
						if ($Row3 = mysqli_fetch_array($Resp3))
						{
							?><td align="center" bgcolor="#CCCCCC"><?php echo strtoupper($Row3["nombre_subclase"]);?></td>
					<?php
						}
						else
						{
							?><td bgcolor="#CCCCCC">&nbsp;</td><?php
						}
						?>
						<td align="right" bgcolor="#CCCCCC"><?php echo $Row2["grupo"];?></td>
						<td align="right" bgcolor="#CCCCCC"><?php echo $Row2[num_electrolisis];?></td>
						<td align="right" bgcolor="#CCCCCC"><?php echo $Row2[correlativo];?></td>
						<td align="right" bgcolor="#CCCCCC"><?php echo $Row2[cant_anodos];?></td>
						<td align="right" class="TituloTablaNaranjaSuave"><?php echo $Row2["hornada"];?></td>
						<td align="right" bgcolor="#CCCCCC"><?php echo $Row2[peso_anodos];?></td>
						<?php
						//echo "PEso:   ".$Row2[peso_anodos]."<br>";
						$Total=$Total+$Row2[peso_anodos];
						
						$Jefe = "select rut, apellido_paterno, apellido_materno, nombres from proyecto_modernizacion.funcionarios  where rut='".$Row2[jefe_turno]."' ";
						//echo $Jefe."<br>";
						$resJefe = mysqli_query($link, $Jefe);
						if ($rowJefe = mysqli_fetch_array($resJefe))
						{
							?><td bgcolor="#CCCCCC"><?php echo $Nombre = ucwords(strtolower($rowJefe["apellido_paterno"]." ".$rowJefe["apellido_materno"]." ".$rowJefe["nombres"]));?></td><?php
						}
						else
						{
							?><td bgcolor="#CCCCCC">&nbsp;</td><?php
						}	
						?>
						<?php
						$Jefe = "select rut, apellido_paterno, apellido_materno, nombres from proyecto_modernizacion.funcionarios  where rut='".$Row2[operador]."' ";
						//echo $Jefe."<br>";
						$resJefe = mysqli_query($link, $Jefe);
						if ($rowJefe = mysqli_fetch_array($resJefe))
						{
							?><td width="2%" bgcolor="#CCCCCC"><?php echo $Nombre = ucwords(strtolower($rowJefe["apellido_paterno"]." ".$rowJefe["apellido_materno"]." ".$rowJefe["nombres"]));?></td><?php
						}
						else
						{
							?><td width="0%" bgcolor="#CCCCCC">&nbsp;</td><?php
						}	
						?>
						<td width="1%" align="center" bgcolor="#CCCCCC">-</td>				
					</tr>
						<?php
					}
					?>
					<tr>
					<td colspan="7" align="right" class="titulo_azul">Peso Total: </td>
					<td align="right" class="TituloCabeceraAzul"><?php echo $Total;?></td>
					<td colspan="3" align="center">&nbsp;</td>
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
