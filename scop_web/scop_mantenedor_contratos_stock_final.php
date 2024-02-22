<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function RecargaSF(Opc,check)
{
	var f= document.FrmPopupProceso;
	var R='';
	f.action = "scop_mantenedor_contratos_proceso.php?Opc="+Opc+"&TabSF=true&CheckSF="+check+"&R=S";
	f.submit();
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0">	
  <tr class="formulario2">
	 <td width="70%">
	   Tipo de Flujos
	     <input name="radiostockfinal" id="cbbCustomer" onclick="RecargaSF('<? echo $Opc;?>','1')" type="radio" class="SinBorde" value="1" <? if($CheckSF=='1') echo " checked ";?>>
		Enabal
		<input name="radiostockfinal" id="cbbCustomer" onclick="RecargaSF('<? echo $Opc;?>','2')" type="radio" class="SinBorde" value="2" <? if($CheckSF=='2') echo " checked ";?>>
		Pmn
		<input name="radiostockfinal" id="cbbCustomer" onclick="RecargaSF('<? echo $Opc;?>','3')" type="radio" class="SinBorde" value="3" <? if($CheckSF=='3') echo " checked ";?>>
	   Otros<br>	   
		<?
		  if($CheckSF=='1')
		  	$TipoFlujo='ENA';
		  if($CheckSF=='2')
		  	$TipoFlujo='PMN';
		  if($CheckSF=='3')		
		  	$TipoFlujo='OTRO';
		 $In='';
		 $Consulta = "select t1.flujo from scop_contratos_flujos t1  ";			
		 $Consulta.= " where t1.cod_contrato='".$TxtContrato."' and tipo_inventario=4 and tipo_flujo='".$TipoFlujo."'";
		 $Resp=mysql_query($Consulta);
		 while ($Fila=mysql_fetch_array($Resp))
		 {
			$In=$In."'".$Fila["flujo"]."',";
		 }
		 if($In<>'')
			$In="(".substr($In,0,strlen($In)-1).")";
		 //echo "IN".$In; 
		 if($R=='S')
		 {
			?>
			 <select name="CmbFlujoFin" style="width:300">
			   <option value="T" class="Selected">Seleccionar</option>
			<?
				$Consulta="select distinct cod_flujo,nom_flujo from scop_datos_enabal where origen='".$TipoFlujo."' and tipo_mov='3'";							
				if($In!='')
					$Consulta.=" and cod_flujo not in $In";
				$Consulta.="  order by cod_flujo";
				$result = mysql_query($Consulta);
				while($Fila=mysql_fetch_assoc($result))
				{
					if ($CmbFlujoFin==$Fila["cod_flujo"])
						echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],10,'0',STR_PAD_LEFT)." - ".ucfirst(strtolower($Fila["nom_flujo"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],2,'0',STR_PAD_LEFT)." - ".ucfirst(strtolower($Fila["nom_flujo"]))."</option>\n";
				}
			?>
			</select><? //echo 	$Consulta."<br>";?>
		<?
		 }
		 else
		 {
			 echo "<select name='CmbFlujoFin' style='width:300'>";
			   echo "<option value='T' class='Selected'>Seleccionar</option>";
		 	echo "</select>";
		 }	
		?>	
		 &nbsp;&nbsp;&nbsp;
		 <select name="CmbSignoSF" style="width:60">
		   <option value="T" class="Selected">Selec.</option>
			<?
				switch($CmbSignoSF)
				{
					case "1":
							 echo "<option value='1' selected>+</option>";
							 echo "<option value='2'>-</option>";
					break;
					case "2":
							 echo "<option value='1'>+</option>";
							 echo "<option value='2' selected>-</option>";
					break;
					default:
							 echo "<option value='1'>+</option>";
							 echo "<option value='2'>-</option>";
					break;
				}
			?>
	   </select>
		&nbsp;<a href="JavaScript:ProcesoNuevo('NSKFIN','<? echo $CheckSF;?>','<? echo $R;?>')"><img src="archivos/agregar.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a>
    </td>
	 <td width="30%">Agregar Otros Flujos <a href="JavaScript:ProcesoFlujo()"><img src="archivos/btn_ingreso_obs2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a></td>
  </tr>
      <tr>
         <td colspan="3">
            <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
			   <tr class="TitulotablaVerde">
				 <td width="7%" align="center" >Eliminar</td>
				 <td width="18%" align="center" >Contrato</td>
				 <td width="45%" align="center" >Flujo</td>
				 <td width="20%" align="center" >Tipo Flujo</td>
				 <td width="10%" align="center" >Tipo Inventario</td>
				 <td width="10%" align="center" >Signo</td>
			  </tr>
				<?
				  $Consulta="select distinct t1.cod_contrato,t3.num_contrato,t1.tipo_flujo,t2.nom_flujo,t1.flujo,t1.signo from scop_contratos_flujos t1";
				  $Consulta.=" inner join scop_datos_enabal t2 on t1.flujo=t2.cod_flujo and t1.tipo_flujo=t2.origen";
				  $Consulta.=" inner join scop_contratos t3 on t1.cod_contrato=t3.cod_contrato and t1.tipo_flujo=t2.origen";
				  $Consulta.=" where t1.cod_contrato='".$TxtContrato."' and t1.tipo_inventario=4 and t2.tipo_mov=3  order by cod_flujo";
				  $Resp=mysql_query($Consulta);	
				  while ($Fila=mysql_fetch_array($Resp))
				  {
						$Contrato=$Fila["cod_contrato"];
						$NumContrato=$Fila[num_contrato];
						$NomFlujo=$Fila[nom_flujo];	
						$TipoFlujo=$Fila[tipo_flujo];	
						$TipoInventario=$Fila[tipo_inventario];
						$CodFlujo=$Fila["flujo"];
						$TipoInventario='STOCK FINAL';
						$Cod=$Contrato."~".$CodFlujo."~".$TipoFlujo;
						if($Fila["signo"]=='1')
							$Signo='+';
						else
							$Signo='-';	
						?><tr>
							<td align='center' width='1%'><a href="JavaScript:ProcesoEliminar('ESKFIN','<? echo $Cod;?>')"><img src='archivos/eliminar2.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>
							<td align='left'><? echo $NumContrato;?></td>
							<td align='left'><? echo str_pad($CodFlujo,3,'0',STR_PAD_LEFT)." - ".$NomFlujo;?></td>	
							<td align='left'><? echo $TipoFlujo;?></td>	
							<td align='center'><? echo $TipoInventario;?></td>	
							<td align='center'><? echo $Signo;?></td>	
						</tr><?	
				  }
				?>
	  	    </table>
	     </td>
	  </tr>
</table>