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
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Producci&oacute;n &Aacute;nodos D&oacute;re </td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','6')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('E','6')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
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
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr class="TituloCabeceraAzul">
        <td width="6%" rowspan="2" align="center">D&iacute;a</td>
        <td width="7%" rowspan="2" align="center">Te Ppm </td>
        <td width="7%" rowspan="2" align="center">Se Ppm </td>
        <td width="7%" rowspan="2" align="center">Cu Ppm </td>
        <td width="9%" rowspan="2" align="center" >N&deg; Hornada </td>
        <td width="10%" rowspan="2" align="center" >Cantidad anodos (Un) </td>
        <td width="9%" rowspan="2" align="center" >Peso Hornada (Kg) </td>
        <td width="12%" rowspan="2" align="center" >Gas Natural Inicio (M3) </td>
        <td width="16%" rowspan="2" align="center" >Consumo Gas Natural Final (M3) </td>
        <td width="7%" align="center">Color</td>
        <td align="center">Personal</td>
      </tr>
      <tr class="TituloCabeceraAzul">
        <td width="7%" align="center">Anodos</td>
        <td width="10%" align="center">Jefe de Turno </td>
      </tr>
      <?php
	  if($Buscar=='S')
	  {
		  for($K=1;$K<=31;$K++)
		  {
		  	//echo $K."<br>";		
		  
				$Fecha=	$Ano."-".$Mes."-".$K;
				$ConsultaP = "select * from pmn_web.produccion_horno_trof ";
				$ConsultaP.= " where fecha ='".$Fecha."'";
				//$Consulta.= " and hornada = '".$Hornada."'";
				//echo $ConsultaP."<br>";
				$RespuestaP = mysqli_query($link, $ConsultaP);
				while ($Filas = mysqli_fetch_array($RespuestaP))
				{
					$Fecha=explode('-',$Filas["fecha"]);
					$Ano=$Fecha[0];
					$Mes=$Fecha[1];
					$Dia=$Fecha[2];
		
					$Hornada = $Filas["hornada"];
					$Obs = $Filas["observacion"];
					$GasIni = $Filas[gas_natural_ini];
					$GasFin = $Filas[gas_natural_fin];
					$NumAnodos = $Filas[num_anodos];
					$Peso = $Filas["peso"];
					$Operador = $Filas[operador];
					$Color = $Filas[color];
					
					$Consulta1 = "select t1.cod_leyes, t2.abreviatura, t1.muestra01";
					$Consulta1.= " from pmn_web.leyes_prod_horno_trof t1 inner join proyecto_modernizacion.leyes t2 on ";
					$Consulta1.= " t1.cod_leyes = t2.cod_leyes ";
					$Consulta1.=" inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad  ";
					$Consulta1.= " where fecha = '".$Filas["fecha"]."'";
					$Consulta1.= " and hornada = '".$Filas["hornada"]."'";
					$Consulta1.= " order by cod_leyes";
					//echo $Consulta1."<br>";
					$Respuesta = mysqli_query($link, $Consulta1);
					$i=1;$ValorCU='';$ValorSE='';$ValorTE='';
					while ($Row1 = mysqli_fetch_array($Respuesta))
					{
						if($Row1["cod_leyes"]=='02')
							$ValorCU=$Row1[muestra01];
						if($Row1["cod_leyes"]=='40')
							$ValorSE=$Row1[muestra01];
						if($Row1["cod_leyes"]=='44')
							$ValorTE=$Row1[muestra01];
					}
					?>	
				  <tr>
					<td align="center" bgcolor="#CCCCCC"><?php echo $Dia;?></td>
					<td align="right" bgcolor="#CCCCCC"><?php echo $ValorTE;?>&nbsp;</td>
					<td align="right" bgcolor="#CCCCCC"><?php echo $ValorSE;?>&nbsp;</td>
					<td align="right" bgcolor="#CCCCCC"><?php echo $ValorCU;?>&nbsp;</td>
					<td align="center" bgcolor="#CCCCCC" class="TituloCabeceraOz"><?php echo $Hornada;?></td>
					<td align="right" bgcolor="#CCCCCC"><?php echo $NumAnodos;?></td>
					<td align="right" bgcolor="#CCCCCC"><?php echo number_format($Peso,4,',','.');?></td>
					<td align="right" bgcolor="#CCCCCC"><?php echo number_format($GasIni,2,',','.');?></td>
					<td align="right" bgcolor="#CCCCCC"><?php echo number_format($GasFin,2,',','.');?></td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.sub_clase where cod_clase = 6001 and cod_subclase='".$Color."' order by cod_subclase ";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Color=$Row3["nombre_subclase"]
					?>
					<td align="center" bgcolor="#CCCCCC"><?php echo $Color;?></td>
					<?php
					$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$Filas[operador]."'";
					$result2 = mysqli_query($link, $sql);
					if ($row2=mysqli_fetch_array($result2))
						$TxtOperador = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
					else	$TxtOperador = "No Encontrado";
					?>
					<td align='left' bgcolor="#CCCCCC" valign='middle'><?php echo $TxtOperador;?></td>
		  </tr>
					<?php
					$TotaleAnod=$TotaleAnod+$NumAnodos;
					$TotalePeso=$TotalePeso+$Peso;
				}
		  }		
		  ?>
		  <tr>
		  	  <td colspan="5" align='right' class="TituloCabeceraOz">Totales</td>
		  	  <td align='right' class="TituloCabeceraOz"><?php echo number_format($TotaleAnod,0,',','.');?></td>
		  	  <td align='right' class="TituloCabeceraOz"><?php echo number_format($TotalePeso,4,',','.');?></td>
		  	  <td colspan="4" class="TituloCabeceraOz">&nbsp;</td>
		  </tr>
		  <?php	
	  }	
	  ?>	  
    </table>      	</td>
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
