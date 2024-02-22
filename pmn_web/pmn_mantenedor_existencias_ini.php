<?php 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 10;
	include("../principal/conectar_principal.php");
	if(!isset($TipoBusq))
		$TipoBusq='0';
	
?>
<html>
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(Proceso,MES)
{
	var f=document.FrmIngFun;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "G":
			for (i=1;i<f.elements.length;i++)
			{			
				var Nom= f.elements[i].name								
				if (f.elements[i].name=="Check" && f.elements[i].value==MES)
				{	
					if(f.elements[i+1].value!='0,00' || f.elements[i+2].value!='0,00' || f.elements[i+3].value!='0,00' || f.elements[i+4].value!='0,00' || f.elements[i+8].value!='0' || f.elements[i+9].value!='0' || f.elements[i+10].value!='0' || f.elements[i+11].value!='0')
						Valores = Valores+f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.elements[i+2].value+"~"+f.elements[i+3].value+"~"+f.elements[i+4].value+"~"+f.elements[i+5].value+"~"+f.elements[i+6].value+"~"+f.elements[i+7].value+"~"+f.elements[i+8].value+"~"+f.elements[i+9].value+"~"+f.elements[i+10].value+"~"+f.elements[i+11].value+"~"+f.elements[i+12].value+"~"+f.elements[i+13].value+"~"+f.elements[i+14].value+"//";
				}	
			}
			Valores=Valores.substr(0,Valores.length-2);
			f.Valores.value=Valores;
			//alert(Valores+"/n")
			f.action= "pmn_mantenedor_existencias_ini01.php?Graba=S&Mes="+MES;
	 		f.submit();
			break;
		case "R":
			f.action= "pmn_mantenedor_existencias_ini.php";
	 		f.submit();
			break;
	} 
}
function Salir()
{
	var Frm=document.FrmIngFun;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=6";
	Frm.submit();
}
</script>
<title>PMN - Asociaci&oacute;n Funcionario Proceso</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngFun" method="post" action="">
  <?php //include("../principal/encabezado.php")?>
  <br>
  <table width="70%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="archivos/images/interior/esq3.png"></td>
      <td width="98%" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif"></td>
      <td height="1%"><img src="archivos/images/interior/esq2.png"></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
      <td align="center">
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">

          <tr>
            <td width="34" align="left" valign="top" class="formulario">A&ntilde;o</td>
            <td width="70" align="left" valign="top"><select name='Ano' style='width:60px' onChange="Proceso('R');">
                <?php
				for ($i=date("Y")-2;$i<=date("Y")+1;$i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date('Y'))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select>            </td>
            <td width="64" align="left" valign="top"><span class="formulario">Producto</span></td>
            <td width="281" align="left" valign="top"><select name='Productos' onChange="Proceso('R');" style='width:220px'>
              <?php 
					echo "<option value='S'>Seleccionar</option>\n";
					$Consulta = "select t1.cod_producto, t2.descripcion ";
					$Consulta.= " from pmn_web.stock_pmn t1";
					$Consulta.= " inner join proyecto_modernizacion.productos t2 on ";
					$Consulta.= " t1.cod_producto=t2.cod_producto";
					$Consulta.= " group by t1.cod_producto order by t1.cod_producto";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Productos == $Row["cod_producto"])
							echo "<option selected value='".$Row["cod_producto"]."'>".ucwords(strtolower($Row["descripcion"]))."</option>\n";														
						else	
							echo "<option value='".$Row["cod_producto"]."'>".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
				?>
            </select>
              <?php //echo $Consulta;?></td>
            <td width="79" align="left" valign="top"><span class="formulario">Subproducto</span></td>
            <td width="155" align="left" valign="top"><select name="Subproductos" id="Subproductos" onChange="Proceso('R');"  style="width:220px">
              <option value="S">Seleccionar</option>
              <?php
				$Consulta = "select t2.cod_subproducto, t2.descripcion ";
				$Consulta.= " from pmn_web.stock_pmn t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.cod_producto='".$Productos."' ";
				$Consulta.= " and t2.cod_producto='".$Productos."'";
				$Consulta.= " group by t2.cod_producto,t2.cod_subproducto order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Subproductos == $Row["cod_subproducto"])
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					else	echo "<option value='".$Row["cod_subproducto"]."'>";
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}

			?>
            </select>
              <?php //echo $Consulta;?></td>
            <td align="right" valign="top">&nbsp; <!--<a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar" width="24" height="24" border="0" align="absmiddle"></a>-->&nbsp; <a href="JavaScript:Salir()"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a></td>
          </tr>
        </table>	  
	  <table width="100%" border="1" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
			<tr>		
				<td width="15%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" style="border-right-color:#FFFFFF; border-right-style:solid; border-right-width:thin;">Mes</td>					
				<td width="13%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" style="border-right-color:#FFFFFF; border-right-style:solid; border-right-width:thin;">Exist. Inicial Peso</td>					
				<td width="9%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Prod. Peso </td>					
				<td width="9%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Bene. Peso </td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Exist. Final </td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Ajuste +</td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Ajuste -</td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Observaci&oacute;n</td>					
				<td width="12%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" style="border-right-color:#FFFFFF; border-right-style:solid; border-right-width:thin;">Exist. Inicial Cant.</td>					
				<td width="11%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Prod. Cant. </td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Bene. Cant. </td>					
				<td width="11%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Exist. Cant. </td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Ajuste +</td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Ajuste -</td>					
				<td width="10%" align="center" valign="top" bgcolor="#CCCCCC" class="TituloCabeceraAzul" >Observaci&oacute;n</td>					
			</tr>	
		<?php
		 for($i=1;$i<=12;$i++)
		 {
			   $StockIniP=0;$ProdPeso=0;$BenePeso=0;$StockFinP=0;$StockIniC=0;$ProdCant=0;$BeneCant=0;$StockFinC=0;
			   $Consulta23="select * from pmn_web.stock_pmn where mes='".$i."' and ano='".$Ano."' and cod_producto='".$Productos."' and cod_subproducto='".$Subproductos."'";
			   //echo $Consulta23;
			   $Resp=mysqli_query($link, $Consulta23);
			   if($Fila=mysqli_fetch_array($Resp))
			   {
			   		if($i=='1')
					{
						$StockIniPFuncion=TraeStockFinalAnoAnterior($Ano,$i,$Productos,$Subproductos,'P');
						$StockIniCFuncion=TraeStockFinalAnoAnterior($Ano,$i,$Productos,$Subproductos,'B');
						$StockIniP=$StockIniPFuncion;
						$StockIniC=$StockIniCFuncion;
					}	
					else	
					{
				   		$StockIniP=$Fila[si_p];
				   		$StockIniC=$Fila[si_c];
					}	
						
			   		$ProdPeso=$Fila[pr_p];
			   		$BenePeso=$Fila[bn_p];
			   		$StockFinP=$Fila[sf_p];
			   		$AjusteMasP=$Fila[ajuste_posi_p];
			   		$AjusteMenosP=$Fila[ajuste_nega_p];

			   		$ProdCant=$Fila[pr_c];
			   		$BeneCant=$Fila[bn_c];
			   		$StockFinC=$Fila[sf_c];
			   		$AjusteMasC=$Fila[ajuste_posi_c];
			   		$AjusteMenosC=$Fila[ajuste_nega_c];
			   }	
				if($ProdPeso=='0' && $BenePeso=='0')
				{
					$StockIniP=0;$StockFinP=0;
				}	
				if($ProdCant=='0' && $BeneCant=='0')
				{
					$StockIniC=0;$StockFinC=0;
				}
				$Disabled='';
				if($ProdPeso=='0' && $BenePeso=='0')	
					$Disabled='disabled=disabled';
				$Disabled2='';
				if($ProdCant=='0' && $BeneCant=='0')	
					$Disabled2='disabled=disabled';
				?>
				<tr>		
				  <td align="left" valign="top" bgcolor="#CCCCCC" class="formulario" style="border-right-color:#FFFFFF; border-right-style:solid; border-right-width:thin;"><?php echo $Meses[$i-1];?><input type="hidden" name="Check" checked="checked" value="<?php echo $i;?>"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SIP" size="9" maxlength="9" disabled="disabled" value="<?php echo number_format($StockIniP,2,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="PP" size="9" disabled="disabled" maxlength="9" value="<?php echo number_format($ProdPeso,2,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="BP" size="9" disabled="disabled" maxlength="9" value="<?php echo number_format($BenePeso,2,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SFP" size="9" <?php echo $Disabled;?> maxlength="9" value="<?php echo number_format($StockFinP,2,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)" onBlur="Proceso('G','<?php echo $i;?>')"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SFC" size="9" <?php echo $Disabled;?> maxlength="9" value="<?php echo number_format($AjusteMasP,2,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)" onBlur="Proceso('G','<?php echo $i;?>')"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SFC" size="9" <?php echo $Disabled;?> maxlength="9" value="<?php echo number_format($AjusteMenosP,2,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)" onBlur="Proceso('G','<?php echo $i;?>')"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><textarea name="Observ" onBlur="Proceso('G','<?php echo $i;?>')"><?php echo $Fila[observacion_p];?></textarea></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SIC" size="9" disabled="disabled" maxlength="9" value="<?php echo number_format($StockIniC,0,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="PC" size="9" disabled="disabled" maxlength="9" value="<?php echo number_format($ProdCant,0,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="BC" size="9" disabled="disabled" maxlength="9" value="<?php echo number_format($BeneCant,0,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SFC" size="9" <?php echo $Disabled2;?> maxlength="9" value="<?php echo number_format($StockFinC,0,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)" onBlur="Proceso('G','<?php echo $i;?>')"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SFC" size="9" <?php echo $Disabled2;?> maxlength="9" value="<?php echo number_format($AjusteMasC,0,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)" onBlur="Proceso('G','<?php echo $i;?>')"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><input type="text" name="SFC" size="9" <?php echo $Disabled2;?> maxlength="9" value="<?php echo number_format($AjusteMenosC,0,',','.');?>" class="InputDer" onKeyDown="SoloNumeros(true,this)" onBlur="Proceso('G','<?php echo $i;?>')"></td>					
					<td align="right" valign="top" bgcolor="#CCCCCC"><textarea name="Observ" onBlur="Proceso('G','<?php echo $i;?>')"><?php echo $Fila[observacion_c];?></textarea></td>					
				</tr>	
				<?php
		 }
		?>           
      </table></td>
      <td width="1%" background="archivos/images/interior/derecho.png"></td>
    </tr>
    <tr>
      <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"></td>
      <td height="15" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
    </tr>
  </table>
  <?php //include("../principal/pie_pagina.php")?>
<textarea name="Valores" cols="200" style="visibility:hidden;" rows="3"></textarea>  
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
	
function TraeStockFinalAnoAnterior($Ano,$Mes,$Productos,$Subproductos,$Tipo)
{
   $MesAnoAnt=date('Y-m',mktime(0,0,0,$Mes-1,1,$Ano));
   $MesAnoAnt=explode('-',$MesAnoAnt);
   $Consulta23="select sf_p,sf_c from pmn_web.stock_pmn where mes='".$MesAnoAnt[1]."' and ano='".$MesAnoAnt[0]."' and cod_producto='".$Productos."' and cod_subproducto='".$Subproductos."'";
   $Resp23=mysqli_query($link, $Consulta23);
   if($Fila23=mysqli_fetch_array($Resp23))
   {
   		if($Tipo=='P')
			return($Fila23[sf_p]);
   		if($Tipo=='B')
			return($Fila23[sf_c]);
   }
}
?>