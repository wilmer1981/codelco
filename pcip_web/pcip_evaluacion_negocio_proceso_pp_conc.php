<? include("../principal/conectar_pcip_web.php");
$CodTipoAnalisis='2';
echo "<input type='hidden' name='CodTipoAnalisis' value='".$CodTipoAnalisis."'>";
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
  <tr class='formulario2'>
   <td>
   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
   <tr>
	 <td colspan="2" class='formulario2'>Todos
	   <?
	   if($MostrarTodos=='S')
	   {
	   ?>
       <a href="JavaScript:ProcesoExpCont('PP','MostrarTodos','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
       <?
	   }
	   else
	   {
	   ?>
	   <a href="JavaScript:ProcesoExpCont('PP','MostrarTodos','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	   <? }?>
	 </td>
	 </tr>
	 <tr align="center">
     <td width="194" class='formulario2'  align="center">Merma</td>
	 <td width="194" class='formulario2'><input type="text" name="ValorMerma" size="10"/> %&nbsp;&nbsp;
	 <a href="JavaScript:ProcesoVenta('NVEMERM')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> 
	 <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
       <tr>
         <td width="20%" align="center" class="TituloCabecera">&nbsp;</td>
		   <?
		   $ConsultaMerma="select valor,cod_unidad,cod_tipo_analisis from pcip_eva_merma ";
		   $ConsultaMerma.=" where corr='".$Cod."' and cod_tipo_analisis='".$CodTipoAnalisis."'";
		   $Resp=mysql_query($ConsultaMerma);
		   //echo $ConsultaMerma;
		   while($Fila=mysql_fetch_array($Resp))
		   {
					echo "<td width='15%' align='center' class='TituloCabecera'>Valor</td>";	
					echo "<td width='15%' align='center' class='TituloCabecera' >Unidad</td>";	
				echo "</tr>";				
				echo "<tr>";	
					$Codigo=$Cod."~".$Fila[cod_tipo_analisis];
					echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVEMERM','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
					echo "<td width='15%' align='center'>".number_format($Fila[valor],2,',','.')."</td>";
					echo "<td width='15%' align='center'>".$Fila[cod_unidad]."</td>";					
		   }
		   ?>
		 </tr>		 
     </table></td>
   </tr>
	 <tr align="center">
	   <td width="194" class='formulario2'>Recuperaciones Metal&uacute;rgicas</td>
	   <td width="1009" align="left" class='formulario2'><?
	   if($MostrarRec=='S'||$MostrarTodos=='S')
	   {
	   ?>
           <a href="JavaScript:ProcesoExpCont('PP','MostrarRec','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	       <tr>
	         <td class="TituloTablaVerde" align="center">Ingreso de Parametros </td>
           </tr>
	       <tr>
	         <td class='formulario2'>&nbsp;Recuperaci&oacute;n
               <select name="CmbRecup" onchange="JavaScript:Recuperaciones('PP','S')">
                 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31038' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbRecup==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
               </select>
               <a href="JavaScript:ProcesoNuevo('NREC','PP')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nueva Recuperaci�n" align="absmiddle" border="0" /></a>               </span>
	           Finos
               <select name="CmbLey" onchange="JavaScript:Recuperaciones('PP','S')">
                 <option value="T" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' and cod_subclase not in ('0')  order by cod_subclase";			
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
			   Valor
	           <input type="text" name="TxtValor" size="10">
	           Unidad
	           <select name="CmbUnidad">
	             <option value="T" class="Selected">Seleccionar</option>
	             <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051'";			
					if($CmbRecup==3)
						$Consulta.=" and cod_subclase in('9','10')";
					if($CmbRecup!=3)
						$Consulta.=" and cod_subclase in('9')";
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
				  <? if($CmbRecup==3)
					{
						if($CmbLey=='1')// SOLO COBRE TIENE EL TEXTO DE DESCUENTO	
						{
				  ?>	          
					  <input type="text" class="SinBorde" name="Des"  size="7" value="Descuento"/>
					  <input type="text" name="TxtDes" size="5" />
				  <?
						}
					}
				  ?>	
	           &nbsp;</span><a href="JavaScript:ProcesoVenta('NVER')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NREC','PP')"></a></td>
             </tr>
	       <tr>
	         <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
	           <tr>
	             <td width="20%" align="center" class="TituloCabecera">Recuperaciones</td>
				     <?
				   $ArraLeyes=array();
				   $Consulta="select nombre_subclase as nom_ley,t1.cod_ley from pcip_eva_negocios_deduc_recup t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' group by t1.cod_ley order by cod_ley";
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<td width='10%' align='center' class='TituloCabecera' colspan='2'>".$Fila[nom_ley]."</td>";	
					   	echo "<td width='10%' align='center' class='TituloCabecera'>Num. Orden</td>";
				    	echo "<td width='10%' align='center' class='TituloCabecera'>Descuento</td>";
						$ArraLeyes[$Fila[cod_ley]]=$Fila[cod_ley];
				   }
				   ?>
                 </tr>
				 <?
				   $Consulta="select nombre_subclase as nom_rec,cod_subclase as cod_rec from pcip_eva_negocios_deduc_recup t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31038' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' group by t1.cod_tipo order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						
						echo "<td  align='center'>".$Fila[nom_rec]."</td>";
						reset($ArraLeyes);
						while(list($c,$v)=each($ArraLeyes))
						{
						   $Consulta="select t1.cod_ley,t1.orden,t1.descuento,t1.valor,t2.nombre_subclase as nom_unidad from pcip_eva_negocios_deduc_recup t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31051' and t1.cod_unidad=t2.cod_subclase ";
						   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' and t1.cod_tipo='".$Fila[cod_rec]."' and t1.cod_ley='".$v."' order by t1.cod_ley";
						   //echo $Consulta."<br>";
						   $Resp2=mysqli_query($link, $Consulta);
						   if($Fila2=mysql_fetch_array($Resp2))
						   {
								echo "<td  align='center'>".number_format($Fila2[valor],2,',','.')."&nbsp;".$Fila2[nom_unidad]."</td>";
								$Codigo=$Cod."~".$v."~".$Fila[cod_rec];
								echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVER','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						  		echo "<td align='center'>".$Fila2[orden]."&nbsp;</td>";
								if($Fila2[cod_ley]!='1')
									$Fila2[descuento]='';
								else
									$Fila2[descuento];	
								echo "<td  align='center'>".$Fila2[descuento]."&nbsp;</td>";
						   }	
						   else
						   {
						   		echo "<td align='center' colspan='2'>&nbsp;</td>";
								echo "<td align='center'>&nbsp;</td>";
								echo "<td align='center'>&nbsp;</td>";
						   }
						}
						echo "<tr>";	
					}	
				 ?>
	           </table></td>
           </tr>
	       </table>
	     <?
	   
	   }
	   else
	   {
	   ?>
         <a href="JavaScript:ProcesoExpCont('PP','MostrarRec','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
         <? }?></td>
	 </tr>
	 <tr align="center">
	   <td class='formulario2'>Cargos</td>
	   <td align="left" class='formulario2'><?
	   if($MostrarCosto=='S'||$MostrarTodos=='S')
	   {
	   ?>
           <a href="JavaScript:ProcesoExpCont('PP','MostrarCosto','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	       <tr>
	         <td class="TituloTablaVerde" align="center">Ingreso de Parametros  </td>
           </tr>
	       <tr>
	         <td class='formulario2'>Cargos&nbsp;&nbsp;
               <select name="CmbCargo" onchange="JavaScript:Aparece2('PP','S')">
                 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31039' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbCargo==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
               </select>
               Unidad
               <select name="CmbUnidad2" onchange="JavaScript:Aparece('PP','S')">
                 <option value="T" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select * from pcip_eva_asig_cargo_unidad t1 inner join proyecto_modernizacion.sub_clase t2";
					$Consulta.= "  on t2.cod_clase='31051' and t1.cod_unidad=t2.cod_subclase where cod_cargo='".$CmbCargo."'";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad2==$Fila["cod_unidad"])
							echo "<option selected value='".$Fila["cod_unidad"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_unidad"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";																												
					}
					?>
               </select>
               Valor
	           <input type="text" name="TxtValor2" size="10" />
	           <?
			   	if($CmbUnidad2==5)
			    {
			   ?>
				1Lote=
				<input type="text" name="Lote1TMS" size="10" />
				TMS
				<?
			   	}
			   ?>
				Finos
				  <select name="CmbLeyCar">
                    <option value="T" class="Selected">Seleccionar</option>
                    <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' and cod_subclase not in ('0')  order by cod_subclase";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbLeyCar==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                  </select>
				  &nbsp;&nbsp;<br />
				1 Dolar=&nbsp;
				<input type="text" name="Dolar" size="10" />
				Euro
				<?
			   	if($CmbCargo==8||$CmbCargo==9)
			    {
			   ?>
				&nbsp;&nbsp;
				<input type="text" name="Obs" size="13"  value="OBSERVACI&Oacute;N" class="SinBorde" />
				<textarea name="Observacion"  cols="30"></textarea>
				<?
			    }
			   ?>&nbsp;&nbsp;</span><a href="JavaScript:ProcesoVenta('NVECCA')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> 
	           <a href="JavaScript:ProcesoNuevo('NCAR','PP','MostrarCosto')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo Cargo" align="absmiddle" border="0" /></a>             
	       		</td>  </tr>
		   <tr>
	         <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
	           <tr>
	             <td width="7%" align="center" class="TituloCabecera">Elim.</td>
				     <td width="32%" align="center" class="TituloCabecera">Cargos</td>
				     <td width="32%" align="center" class="TituloCabecera">Fino</td>					 
				     <td width="10%" align="center" class="TituloCabecera">Unidad</td>
				     <td width="7%" align="center" class="TituloCabecera">Valor</td>
				     <td width="7%" align="center" class="TituloCabecera">Lote</td>
				     <td width="7%" align="center" class="TituloCabecera">Dolar</td>
				     <td width="30%" align="center" class="TituloCabecera">Observaci�n</td>
                 </tr>
	           <?
				   $Consulta="select t1.observacion,t1.valor,t2.nombre_subclase as nom_cargo,t1.lote,t1.dolar,t2.cod_subclase as cod_cargo,t3.nombre_subclase as nom_unidad,t4.nombre_subclase as nom_fino,t4.cod_subclase as cod_fino from pcip_eva_negocios_costos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31037' and t1.cod_ley=t4.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' and t1.cod_tipo_costo='1' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_cargo]."~".$Fila[cod_fino];
						echo "<td align='center' ><a href=JavaScript:ProcesoVenta('EVECCA','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td  align='left'>".$Fila[nom_cargo]."</td>";
						echo "<td  align='left'>".$Fila[nom_fino]."</td>";
						echo "<td align='center'>".$Fila[nom_unidad]."</td>";
						echo "<td align='center'>".$Fila[valor]."</td>";
						echo "<td  align='center'>".$Fila[lote]."</td>";
						echo "<td align='center'>".$Fila[dolar]."</td>";
						echo "<td align='center'><textarea name='Muestra' readonly='readonly' cols='60'>".$Fila["observacion"]."</textarea></td>";						
						echo "<tr>";	
				   }
				 ?>
	           </table></td>
           </tr>
	       </table>
	     <?
	   
	   }
	   else
	   {
	   ?>
         <a href="JavaScript:ProcesoExpCont('PP','MostrarCosto','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
         <? }?>
         <!--<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
           <tr>
             <td class="TituloTablaVerde" align="center">Ingreso de Contables </td>
           </tr>
           <tr>
             <td class='formulario2'>&nbsp;Valor
               <input type="text" name="TxtValor3" size="10" />
               Unidad
               <select name="CmbUnidad3">
                 <option value="T" class="Selected">Seleccionar</option>
                 <?
					/*$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' and cod_subclase in('1','2','3','4','5','8','15','16','17','18')";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad3==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}*/
					?>
               </select>
               Contables
               <select name="CmbContable">
                 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                 <?
					/*$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbContable==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}*/
					?>
               </select>
               &nbsp;</span><a href="JavaScript:ProcesoVenta('NVECC0')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NLEY','PP')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
           </tr>
           <tr>
             <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
               <tr>
                 <td width="10%" align="center" class="TituloCabecera">Elim.</td>
                 <td width="30%" align="center" class="TituloCabecera">&nbsp;</td>
                 <td width="30%" align="center" class="TituloCabecera">Unidad</td>
                 <td width="30%" align="center" class="TituloCabecera">Valor</td>
               </tr>
               <?
				   /*$Consulta="select t1.valor,t2.nombre_subclase as nom_contable,t2.cod_subclase as cod_contable,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_costos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' and t1.cod_tipo_costo='2' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_contable];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVECC0','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_contable]."</td>";
						echo "<td width='15%' align='center'>".$Fila[valor]."</td>";
						echo "<td width='15%' align='center'>".$Fila[nom_unidad]."</td>";
						echo "<tr>";	
				   }*/
				 ?>
             </table></td>
           </tr>
         </table></td>
	   </tr>-->
	     <!--<tr align="center">
	   <td class='formulario2'>Castigos</td>
	   <td align="left" class='formulario2'><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
         <tr>
           <td class="TituloTablaVerde" align="center">Ingreso de Castigos </td>
         </tr>
         <tr>
           <td class='formulario2'>&nbsp;Valor
             <input type="text" name="TxtValor4" size="10" />
             Unidad
             <select name="CmbUnidad4">
               <option value="T" class="Selected">Seleccionar</option>-->
	     <?
					/*$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' and cod_subclase in('1','2','8','15','16','17','18')  ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad4==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}*/
					?>
	     <!--</select>
             Castigos
             <select name="CmbCastigo">
               <option value="-1" selected="selected" class="Selected">Seleccionar</option>-->
	     <?
					/*$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31040' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbCastigo==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}*/
					?>
	     </select>
	     <!--&nbsp;</span><a href="JavaScript:ProcesoVenta('NVECAS')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NCAS','PP')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
         </tr>
         <tr>
           <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
               <tr>
                 <td width="10%" align="center" class="TituloCabecera">Elim.</td>
                 <td width="30%" align="center" class="TituloCabecera">&nbsp;</td>
                 <td width="30%" align="center" class="TituloCabecera">Unidad</td>
                 <td width="30%" align="center" class="TituloCabecera">Valor</td>
               </tr>-->
	     <?
				   /*$Consulta="select t1.valor,t2.nombre_subclase as nom_castigo,t2.cod_subclase as cod_castigo,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_castigos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_castigo];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVECAS','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_castigo]."</td>";
						echo "<td width='15%' align='center'>".$Fila[valor]."</td>";
						echo "<td width='15%' align='center'>".$Fila[nom_unidad]."</td>";
						echo "<tr>";	
				   }*/
				 ?>
	     <!--</table></td>
         </tr>
       </table></td>
	   </tr>-->
        <tr align="center">
	   <td class='formulario2'>Premios</td>
	   <td align="left" class='formulario2'><?
	   if($MostrarPrem=='S'||$MostrarTodos=='S')
	   {
	   ?>
           <a href="JavaScript:ProcesoExpCont('<? echo $Ptl;?>','MostrarPrem','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	       <tr>
	         <td class="TituloTablaVerde" align="center">Ingreso de Parametros </td>
           </tr>
	       <tr>
	         <td class='formulario2'>&nbsp;Premios
               <select name="CmbPremios">
                 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31052' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbPremios==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
               </select>
               Valor
	           <input type="text" name="TxtValor8" size="12" />
	           Unidad
	           <select name="CmbUnidad8" onchange="JavaScript:Premio('')">
	             <option value="T" class="Selected">Seleccionar</option>
	             <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' and cod_subclase in('6','17')    ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad8==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
	             </select>
	           <input type="text" name="NomDolarPre" size="5" style="visibility:hidden" value="1 Dolar=" class="SinBorde">
	           <input type="text" name="TxtEuroPre" style="visibility:hidden" size="5"><input type="text" name="EUROPre" size="3" style="visibility:hidden" value="EURO" class="SinBorde"><br>
	           &nbsp;</span><a href="JavaScript:ProcesoVenta('NVEPREM')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> 
	           <!--<a href="JavaScript:ProcesoNuevo('NPREM','PP')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>-->
              </tr>
	       <tr>
	         <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
	           <tr>
	             <td width="10%" align="center" class="TituloCabecera">Elim.</td>
                   <td width="45%" align="center" class="TituloCabecera">Premios</td>
                   <td width="15%" align="center" class="TituloCabecera">Unidad</td>
                   <td width="15%" align="center" class="TituloCabecera">Valor</td>
				   <td width="15%" align="center" class="TituloCabecera">1 Dolar</td>
                 </tr>
	           <?
				   $Consulta="select t1.euro,t1.valor,t2.nombre_subclase as nom_premio,t2.cod_subclase as cod_premio,t3.nombre_subclase as nom_unidad from pcip_eva_premios t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31052' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		if($Fila[euro]==0)
							$Fila[euro]='';
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_premio];
						echo "<td align='center'><a href=JavaScript:ProcesoVenta('EVEPREM','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td  align='left'>".$Fila[nom_premio]."</td>";
						echo "<td  align='center'>".$Fila[valor]."</td>";
						echo "<td align='center'>".$Fila[nom_unidad]."</td>";
						echo "<td align='center'>".number_format($Fila[euro],2,',','.')."&nbsp;</td>";
						echo "<tr>";	
				   }
				 ?>
	           </table></td>
           </tr>
	       </table>
	     <?
	   
	   }
	   else
	   {
	   ?>
         <a href="JavaScript:ProcesoExpCont('<? echo $Ptl;?>','MostrarPrem','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
         <? }?></td>
        </tr>
	 <tr align="center">
	   <td class='formulario2'>Transporte</td>
	   <td align="left" class='formulario2'><?
	   if($MostrarTras=='S'||$MostrarTodos=='S')
	   {
	   ?>
           <a href="JavaScript:ProcesoExpCont('PP','MostrarTras','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	       <tr>
	         <td class="TituloTablaVerde" align="center">Ingreso de Parametros </td>
           </tr>
	       <tr>
	         <td class='formulario2'>Origen - Destino
               <select name="CmbOrigenDestinoTrans">
                 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31036' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbOrigenDestinoTrans==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
               </select>&nbsp;<a href="JavaScript:ProcesoNuevo('NDES','PP','MostrarTras')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a>
			   Finos
               <select name="CmbLey">
                 <option value="T" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' and cod_subclase not in ('0')  order by cod_subclase";			
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
               Valor
	           <input type="text" name="TxtValor5" size="10" />
	           Unidad
	           <select name="CmbUnidad5">
	             <option value="T" class="Selected">Seleccionar</option>
	             <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' and cod_subclase in('1','6','8','15','16','17','18') ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad5==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
	             </select>
	           &nbsp;</span><a href="JavaScript:ProcesoVenta('NVETRANS')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NDES','PP')"></a></td>
           </tr>
	       <tr>
	         <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
	           <tr>
	             <td width="10%" align="center" class="TituloCabecera">Elim.</td>
                   <td width="20%" align="center" class="TituloCabecera">Origen</td>
				   <td width="20%" align="center" class="TituloCabecera">Proceso Previo</td>
                   <td width="15%" align="center" class="TituloCabecera">Valor</td>
				   <td width="15%" align="center" class="TituloCabecera">Unidad</td>
                 </tr>
	           <?
				   $Consulta="select t1.valor,t2.nombre_subclase as nom_origen_destino,t2.cod_subclase as cod_origen_destino,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_transporte t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31036' and t1.cod_origen_destino=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_origen_destino";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_origen]."~".$Fila[cod_destino];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVETRANS','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_origen_destino]."</td>";
						echo "<td width='15%' align='center'>Ninguno</td>";
						echo "<td width='15%' align='center'>".$Fila[valor]."</td>";
						echo "<td width='15%' align='center'>".$Fila[nom_unidad]."</td>";
						echo "<tr>";	
				   }
				 ?>
	           </table></td>
           </tr>
	       </table>
	     <?
	   
	   }
	   else
	   {
	   ?>
         <a href="JavaScript:ProcesoExpCont('PP','MostrarTras','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
         <? }?></td>
	 </tr>
	 <tr align="center">
	   <td class='formulario2'>Precios</td>
	   <td align="left" class='formulario2'><?
	   if($MostrarPre=='S'||$MostrarTodos=='S')
	   {
	   ?>
           <a href="JavaScript:ProcesoExpCont('PP','MostrarPre','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	       <tr>
	         <td class="TituloTablaVerde" align="center">Ingreso de Parametros </td>
           </tr>
	       <tr>
	         <td class='formulario2'>&nbsp;&nbsp;Base o Digitar
               <select name="CmbDatosBuscar" onchange="JavaScript:SeleccionCombo('PP','S')">
                 <?
					switch($CmbDatosBuscar)
					{
						case "1":
								echo "<option selected value='1'>BASE DE DATOS</option>\n";
								echo "<option value='2'>INGRESAR</option>\n";
						break;
						case "2":
								echo "<option value='1'>BASE DE DATOS</option>\n";
								echo "<option selected value='2'>INGRESAR</option>\n";
						break;
						default:
								echo "<option value='1'>BASE DE DATOS</option>\n";
								echo "<option selected value='2'>INGRESAR</option>\n";
						break;
					}
				?>
               </select>
			   <?
					//Consulto para saber si existe un QP para este tipo de analisis y correlativo
				   $Consulta="select t1.QP from pcip_eva_negocios_precios t1 ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."'";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   if(!$Fila=mysql_fetch_array($Resp))
				   {
				    ?>
					QP
					<select name="CmbQP">
					  <option value="-1" selected="selected" class="Selected">Seleccionar</option>
					  <?
						for($i=1;$i<=6;$i++)
						 {
						   if($i==$CmbQP)
								echo "<option value='".$i."' selected>Mes+".$i."</option>";
						   else
								echo "<option value='".$i."'>Mes+".$i."</option>";
						 }
					 ?>
					</select>
				   	<?	
				   }
				   else
				   {
				   		$CmbQP=$Fila[QP];
				   		echo "&nbsp;&nbsp;MES+".$CmbQP;
				   		echo "<input name='CmbQP' type='hidden' value='".$CmbQP."'>";  				    
			   	   }
			   ?>
               <br />
               <?  if($CmbDatosBuscar==1)
					{
				 ?>
				Seleccione Fino	Base
					<select name="CmbFino" onchange="JavaScript:SeleccionCombo('PP','S')">
					  <option value="T" class="Selected" >Seleccionar</option>
					  <?
						$Consulta = "select distinct(cod_subclase),nombre_subclase from proyecto_modernizacion.sub_clase t1 inner join pcip_fac_compra_precios t2  where cod_clase='31012' and t1.cod_subclase=t2.cod_fino";			
						$Resp=mysqli_query($link, $Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							if ($CmbFino==$FilaTC["cod_subclase"])
								echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						}
					    ?>
				    </select>
						<?	  	
						$Consulta = "select t1.valor,t1.cod_moneda,t2.nombre_subclase as nom_uni from pcip_fac_compra_precios t1 inner join";
						$Consulta.= " proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31001' and t1.cod_moneda=t2.cod_subclase where t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.cod_fino='".$CmbFino."'";			
						$Resp=mysqli_query($link, $Consulta);
						if($FilaTC=mysql_fetch_array($Resp))
						{
							$ValorFino=$FilaTC[valor];
							$NomUni=$FilaTC[nom_uni];
							$CodUni=$FilaTC[cod_moneda];
						}
						else
						{
							//SI NO EXISTE EL VALOR CONSULTADO ANTERIORMENTE, SE SACARA EL ULTIMO VALOR INGRESADO DE LA BASE DE DATOS
							$Consulta = "select t1.valor,t1.cod_moneda,t2.nombre_subclase as nom_uni from pcip_fac_compra_precios t1 inner join";
							$Consulta.= " proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31001' and t1.cod_moneda=t2.cod_subclase where t1.ano='".$Ano."' and t1.cod_fino='".$CmbFino."' order by mes desc";			
							//echo $Consulta."<br>";
							$Resp=mysqli_query($link, $Consulta);
							if($FilaTC=mysql_fetch_array($Resp))
							{
								$ValorFino=$FilaTC[valor];
								$NomUni=$FilaTC[nom_uni];
								$CodUni=$FilaTC[cod_moneda];
							}	
						}							
						?>
						&nbsp;&nbsp;&nbsp;Valor 1
						<input readonly="readonly" type="text" onkeydown="SoloNumerosyNegativo(true,this)" name="TxtValor6" size="10" value="<? echo number_format($ValorFino,2,',','.');?>" />
						Valor 2
						<input type="text" onkeydown="SoloNumerosyNegativo(true,this)" name="TxtValor7" size="10" />
						<input type="hidden" class="SinBorde" name="CmbUnidad6" size="2" value="<? echo $CodUni;?>"/>
						<input type="text"  readonly="readonly" class="SinBorde"  name="Unidad" size="5" value="<? echo $NomUni;?>"/>
					<?
					}
					else
					{
				   ?>
						&nbsp;&nbsp;&nbsp;Valor 1
						<input type="text" onkeydown="SoloNumerosyNegativo(true,this)" name="TxtValor6" size="10" />
						&nbsp;Valor2
						<input type="text" onkeydown="SoloNumerosyNegativo(true,this)" name="TxtValor7" size="10" />
						Unidad
					<select name="CmbUnidad6">
					  <option value="T" class="Selected">Seleccionar</option>
				  <?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' and cod_subclase in('4','6','7''18','19','24')";			
						$Resp=mysqli_query($link, $Consulta);		
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbUnidad6==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						}
						?>
					</select>
				<?
				  	}
				 ?>
					<br />
					Finos
					<select name="CmbPrecios">
					  <option value="-1" selected="selected" class="Selected">Seleccionar</option>
				  <?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' and cod_subclase not in ('0')  order by cod_subclase";			
						$Resp=mysqli_query($link, $Consulta);		
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbPrecios==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						}
						?>
				</select>&nbsp;</span><a href="JavaScript:ProcesoVenta('NVEPRE')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> 
	           <a href="JavaScript:ProcesoNuevo('NLEY','PP')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
           </tr>
	       <tr>
	         <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
	           <tr>
	             <td width="10%" align="center" class="TituloCabecera">Elim.</td>
                   <td width="30%" align="center" class="TituloCabecera">&nbsp;</td>
                   <td width="30%" align="center" class="TituloCabecera">Unidad</td>
                   <td width="30%" align="center" class="TituloCabecera">Valor</td>
				   <td width="30%" align="center" class="TituloCabecera">Valor2</td>
				   <td width="30%" align="center" class="TituloCabecera">QP</td>
                 </tr>
	           <?
				   $Consulta="select t1.QP,t1.valor,t1.valor2,t2.nombre_subclase as nom_precio,t2.cod_subclase as cod_precio,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_precios t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		if($Fila[QP]=='0')
							$QP='&nbsp;';
						else
							$QP='MES+'.$Fila[QP];	
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_precio];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVEPRE','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_precio]."</td>";
						echo "<td width='15%' align='center'>".$Fila[nom_unidad]."</td>";
						echo "<td width='15%' align='center'>".$Fila[valor]."</td>";
						echo "<td width='15%' align='center'>".$Fila["valor2"]."</td>";
						echo "<td width='15%' align='center'>".$QP."</td>";
						echo "<tr>";	
				   }
				 ?>
	           </table></td>
           </tr>
	       </table>
	     <?
	   
	   }
	   else
	   {
	   ?>
         <a href="JavaScript:ProcesoExpCont('PP','MostrarPre','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
         <? }?></td>
	 </tr>
   </table>
   </td>
  </tr>
</table>