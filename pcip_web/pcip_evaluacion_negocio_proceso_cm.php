<? include("../principal/conectar_pcip_web.php");
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
  <tr class='formulario2'>
   <td>
   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
	 <tr align="center">
	   <td width="16%" rowspan="2" class='formulario2'>Material Inicial<br>
	    Base C&aacute;lculo </td>
	   <td width="17%" align="left" class='formulario2'><input type="text" name="TxtTMH"value='<? echo $TxtTMH;?>'> TMH</td>
	   <td rowspan="2" align="left" class='formulario2'><a href="JavaScript:ProcesoMaterial('MMAT')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> &nbsp;</td>
	   </tr>
	 <tr align="center">
	   <td align="left" class='formulario2'><input type="text" name="TxtTMS" value='<? echo $TxtTMS;?>'> TMS</td>
	   </tr>
	 <tr align="center">
	   <td class='formulario2'>Leyes</td>
	   <td colspan="2" align="left" class='formulario2'><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
         <tr>
           <td class="TituloTablaVerde" align="center">Ingreso de Leyes </td>
         </tr>
         <tr>
           <td class='formulario2'>&nbsp;Ley
               <select name="CmbLey">
                 <option value="T" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' ";			
					$Resp=mysql_query($Consulta);		
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
                          <input type="text" name="TxtValor" size="6">
                          Unidad
                          <select name="CmbUnidad">
                            <option value="T" class="Selected">Seleccionar</option>
                            <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('1','19','20') ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                          </select>
                          Origen
                          <select name="CmbDivMat">
                            <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                            <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31036' ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbDivMat==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                          </select>
                          &nbsp;</span><a href="JavaScript:ProcesoMaterial('NMAT')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> 
						  			   <a href="JavaScript:ProcesoNuevo('NDES','CM')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0"></a></td>
           </tr>
         <tr>
           <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
                 <tr>
                   <td width="20%" align="center" class="TituloCabecera">Origen</td>
				   <?
				   $ArraLeyes=array();
				   $Consulta="select nombre_subclase as nom_ley,t1.cod_ley from pcip_eva_negocios_material t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' group by t1.cod_ley order by cod_ley";
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<td width='15%' align='center' class='TituloCabecera' colspan='2'>".$Fila[nom_ley]."</td>";	
						$ArraLeyes[$Fila[cod_ley]]=$Fila[cod_ley];
				   }
				   ?>
                 </tr>
				 <?
				   $Consulta="select nombre_subclase as nom_div,cod_subclase as cod_div from pcip_eva_negocios_material t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31036' and t1.cod_division=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' group by t1.cod_division order by cod_division";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						
						echo "<td width='15%' align='center'>".$Fila[nom_div]."</td>";
						reset($ArraLeyes);
						while(list($c,$v)=each($ArraLeyes))
						{
						   $Consulta="select t1.valor,t2.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.cod_unidad=t2.cod_subclase ";
						   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_division='".$Fila[cod_div]."' and t1.cod_ley='".$v."' order by t1.cod_ley";
						   $Resp2=mysql_query($Consulta);
						   if($Fila2=mysql_fetch_array($Resp2))
						   {
								echo "<td width='15%' align='center'>".number_format($Fila2[valor],2,',','.')."&nbsp;".$Fila2[nom_unidad]."</td>";
								$Codigo=$Cod."~".$v."~".$Fila[cod_div];
								echo "<td align='center' width='1%'><a href=JavaScript:ProcesoMaterial('EMAT','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						   }	
						   else
						   {
						   		echo "<td width='15%' align='center' colspan='2'>&nbsp;</td>";
						   }
						}
						echo "<tr>";	
				   }
				 ?>
             </table></td>
         </tr>
       </table></td>
	   </tr>
   </table>
   </td>
  </tr>
</table>