<? include("../principal/conectar_pcip_web.php");
   $Consulta="select ifnull(sum(t1.valor),0) as peso_seco from pcip_eva_negocios_material t1  ";
   $Consulta.=" where t1.corr='".$Cod."' and cod_ley='0'";
   //echo $Consulta;
   $Resp=mysqli_query($link, $Consulta);
   $Fila=mysql_fetch_array($Resp);
   $TxtTMS=$Fila[peso_seco];
   $TxtTMH=$TxtTMS/(1-$TxtHum/100);//CARACTERISTICA MATERIAL CONCENTRADO
   
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
  <tr class='formulario2'>
   <td>
   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
	 <tr align="center">
	   <td width="16%" rowspan="2" class='formulario2'>Material Inicial<br>
	    Base C&aacute;lculo </td>
	   <td width="22%" align="left" class='formulario2'><input type="text" name="TxtTMH"value='<? echo number_format($TxtTMH,2,',','.');?>' readonly=""> TMH</td>
	   <td width="17%" rowspan="2" align="left" class='formulario2'><input type="text" name="TxtHum"value='<? echo $TxtHum;?>' size="5" maxlength="4" >
	     Humedad [%]</td>
	   <td width="45%" rowspan="2" align="left" class='formulario2'><a href="JavaScript:ProcesoMaterial('MMATCONS')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> &nbsp;</td>
	 </tr>
	 <tr align="center">
	   <td align="left" class='formulario2'><input type="text" name="TxtTMS" value='<? echo number_format($TxtTMS,2,',','.');?>' readonly=""> TMS</td>
	   </tr>
	 <tr align="center">
	   <td class='formulario2'>Leyes / Material Inicial Seco </td>
	   <td colspan="3" align="left" class='formulario2'><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
         <tr>
           <td class="TituloTablaVerde" align="center">Ingreso de Material Inicial Seco - Leyes </td>
         </tr>
         <tr>
           <td class='formulario2'>&nbsp;Ley / Mat. Ini. Seco
               <select name="CmbLey"  onchange="JavaScript:RecargaUni('CM')">
                 <option value="T" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' order by cod_subclase";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbLey==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
               </select>
					  </span>Valor
					  <input type="text" name="TxtValor" size="10">
					   <?
					   	if($CmbLey!='T')
						{
							//CONSULTARE SI EXISTE LA LEY ESCOGUIDA, SI ES ASI SE DEJA LA MISMA UNIDAD YA GUARDADA PARA LOS DEMAS MESE Y ESA LEY SI NO EL COMBO DE UNIDADES. 
							$Consulta = "select t1.cod_unidad,t2.nombre_subclase as nom_uni from pcip_eva_negocios_material t1 inner join proyecto_modernizacion.sub_clase t2 ";			
							$Consulta.= " on t2.cod_clase='31051' and t1.cod_unidad=t2.cod_subclase where corr='".$Cod."' and cod_ley='".$CmbLey."'";
								//echo $Consulta."<br>";
							$Resp=mysqli_query($link, $Consulta);		
							if($Fila=mysql_fetch_array($Resp))
							{
								echo "Unidad&nbsp;";
								echo"<input type='hidden' name='CmbUnidad' size='10' value='".$Fila["cod_unidad"]."'>";
								echo"<input type='text' name='Unidad' size='6' value='".$Fila[nom_uni]."'>&nbsp;";
							}
							else
							{	
								$CmbUnidad='T';													
						   ?>
							  Unidad
							  <select name="CmbUnidad">
								<option value="T" class="Selected">Seleccionar</option>
								<?
								$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' ";			
								if($CmbLey=='0')
									$Consulta.= " and cod_subclase in ('12','14')";
								if($CmbLey!='0')
									$Consulta.= " and cod_subclase in ('13','14','11','20','21','9','10','22') order by cod_subclase";									
								$Resp=mysqli_query($link, $Consulta);		
								while ($Fila=mysql_fetch_array($Resp))
								{
									if ($CmbUnidad==$Fila["cod_subclase"])
										echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
									else
										echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
								}
								?>
							  </select>
							<? 
							 }
						  }	
						  if($CmbLey=='T')	
						  {	
						  	$CmbUnidad='T';						   
						 ?>  
							  Unidad
							  <select name="CmbUnidad">
								<option value="T" class="Selected">Seleccionar</option>
								<?
								$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' ";			
								if($CmbLey=='0')
									$Consulta.= " and cod_subclase in ('11','12','14')";
								if($CmbLey!='0')
									$Consulta.= " and cod_subclase in ('13','14','11','20','21','9','10','22') order by cod_subclase";									
								$Resp=mysqli_query($link, $Consulta);		
								while ($Fila=mysql_fetch_array($Resp))
								{
									if ($CmbUnidad==$Fila["cod_subclase"])
										echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
									else
										echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
								}
								?>
							  </select>
						  <? }?>	  
                          A&ntilde;o 
                          <select name="Ano" id="Ano">
                            <?
								for ($i=2003;$i<=date("Y");$i++)
								{
									if ($i==$Ano)
										echo "<option selected value=\"".$i."\">".$i."</option>\n";
									else
										echo "<option value=\"".$i."\">".$i."</option>\n";
								}
							?>
                          </select>
		                  Mes
       			        <select name="Mes" id="Mes">
						<?
							for ($i=1;$i<=12;$i++)
							{
								if ($i==$Mes)
									echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
								else
									echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
							}
						?>
	                    </select>                          
                &nbsp;</span><a href="JavaScript:ProcesoMaterial('NMATCONS')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> </td>
           </tr>
         <tr>
           <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
                 <tr>
                   <td width="20%" align="center" class="TituloCabecera">Datos</td>
				   <?
				   $ArraLeyes=array();
				   $ArraTotal=array();
				   $Consulta="select nombre_subclase as nom_ley,t1.cod_ley from pcip_eva_negocios_material t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' group by t1.cod_ley order by cod_ley";
				   $Resp=mysqli_query($link, $Consulta);
				   //echo $Consulta;
				   while($Fila=mysql_fetch_array($Resp))
				   {
						echo "<td width='15%' align='center' class='TituloCabecera' colspan='2'>".$Fila[nom_ley]."</td>";
						$ArraLeyes[$Fila[cod_ley]]=$Fila[cod_ley];
						$ArraTotal[$Fila[cod_ley]]=0;
				   }
				   ?>
                 </tr>
				 <?
				   $Consulta="select t1.cod_division from pcip_eva_negocios_material t1  ";
				   $Consulta.=" where t1.corr='".$Cod."' group by cod_division order by cod_division";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		$AnoAux=substr($Fila[cod_division],0,4);
						$MesAux=substr($Fila[cod_division],4);
						echo "<tr>";
						echo "<td width='15%' align='center'>".$AnoAux." - ".strtoupper(substr($Meses[$MesAux-1],0,3))."</td>";
						reset($ArraLeyes);
						while(list($c,$v)=each($ArraLeyes))
						{
						   $Consulta="select t1.valor,t2.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31051' and t1.cod_unidad=t2.cod_subclase ";
						   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_division='".$Fila[cod_division]."' and t1.cod_ley='".$v."' order by t1.cod_ley";
						   $Resp2=mysqli_query($link, $Consulta);
						   if($Fila2=mysql_fetch_array($Resp2))
						   {
								echo "<td width='15%' align='center'>".number_format($Fila2[valor],3,',','.')."&nbsp;".$Fila2[nom_unidad]."</td>";
								//$Total=$Total+$Fila2[valor];
								$ArraTotal[$v]=$ArraTotal[$v]+$Fila2[valor];
								$Codigo=$Cod."~".$v."~".$Fila[cod_division];
								echo "<td align='center' width='1%'><a href=JavaScript:ProcesoMaterial('EMATCONS','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						   }	
						   else
						   {
						   		echo "<td width='15%' align='center' colspan='2'>&nbsp;</td>";
						   }						  
						}
						echo "</tr>";											
				   }
					echo "<tr>";
					echo "<td width='15%' align='center'>Total</td>";
					reset($ArraLeyes);
					while(list($c,$v)=each($ArraLeyes))
					{
						echo "<td width='15%' align='center' colspan='2'>".number_format($ArraTotal[$c],3,',','.')."</td>";
					}
					echo "</tr>";													
				 ?>
             </table></td>
         </tr>
       </table></td>
	   </tr>
   </table>
   </td>
  </tr>
</table>