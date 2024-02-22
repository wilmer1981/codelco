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
	   <td width="194" class='formulario2'>Recuperaciones</td>
	   <td width="1009" align="left" class='formulario2'>
	   <?
	   if($MostrarRec=='S'||$MostrarTodos=='S')
	   {
	   ?>
	   <a href="JavaScript:ProcesoExpCont('PP','MostrarRec','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	   <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
         <tr>
           <td class="TituloTablaVerde" align="center">Ingreso de Recuperaciones </td>
         </tr>
         <tr>
           <td class='formulario2'>&nbsp;Recuperaci&oacute;n
             <select name="CmbRecup">
               <option value="-1" selected="selected" class="Selected">Seleccionar</option>
               <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31038' ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbRecup==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
             </select>
             Ley
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
                          <input type="text" name="TxtValor" size="10">
                          Unidad
                          <select name="CmbUnidad">
                            <option value="T" class="Selected">Seleccionar</option>
                            <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('19','20') ";			
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
                          &nbsp;</span><a href="JavaScript:ProcesoVenta('NVER')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NREC','PP','MostrarRec')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
           </tr>
         <tr>
           <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
                 <tr>
                   <td width="20%" align="center" class="TituloCabecera">&nbsp;</td>
				   <?
				   $ArraLeyes=array();
				   $Consulta="select nombre_subclase as nom_ley,t1.cod_ley from pcip_eva_negocios_deduc_recup t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' group by t1.cod_ley order by cod_ley";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<td width='15%' align='center' class='TituloCabecera' colspan='2'>".$Fila[nom_ley]."</td>";	
						$ArraLeyes[$Fila[cod_ley]]=$Fila[cod_ley];
				   }
				   ?>
                 </tr>
				 <?
				   $Consulta="select nombre_subclase as nom_rec,cod_subclase as cod_rec from pcip_eva_negocios_deduc_recup t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31038' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' group by t1.cod_tipo order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						
						echo "<td width='15%' align='center'>".$Fila[nom_rec]."</td>";
						reset($ArraLeyes);
						while(list($c,$v)=each($ArraLeyes))
						{
						   $Consulta="select t1.valor,t2.nombre_subclase as nom_unidad from pcip_eva_negocios_deduc_recup t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.cod_unidad=t2.cod_subclase ";
						   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' and t1.cod_tipo='".$Fila[cod_rec]."' and t1.cod_ley='".$v."' order by t1.cod_ley";
						   $Resp2=mysql_query($Consulta);
						   if($Fila2=mysql_fetch_array($Resp2))
						   {
								echo "<td width='15%' align='center'>".number_format($Fila2[valor],2,',','.')."&nbsp;".$Fila2[nom_unidad]."</td>";
								$Codigo=$Cod."~".$v."~".$Fila[cod_rec];
								echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVER','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
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
       </table>
	   <?
	   
	   }
	   else
	   {
	   ?>
	   <a href="JavaScript:ProcesoExpCont('PP','MostrarRec','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	   <? }?>
	   </td>
	   </tr>
	 <tr align="center">
	   <td class='formulario2'>Costos</td>
	   <td align="left" class='formulario2'><?
	   if($MostrarCosto=='S'||$MostrarTodos=='S')
	   {
	   ?>
           <a href="JavaScript:ProcesoExpCont('PP','MostrarCosto','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
	     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	       <tr>
	         <td class="TituloTablaVerde" align="center">Ingreso de Cargos </td>
           </tr>
	       <tr>
	         <td class='formulario2'>Cargos
               <select name="CmbCargo">
                 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                 <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31039' ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbCargo==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
               </select>
               Valor
	           <input type="text" name="TxtValor2" size="10" />
	           Unidad
	           <select name="CmbUnidad2">
	             <option value="T" class="Selected">Seleccionar</option>
	             <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('8','12','18') ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad2==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
	             </select>
	           &nbsp;</span><a href="JavaScript:ProcesoVenta('NVECCA')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NCAR','PP','MostrarCosto')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo " align="absmiddle" border="0" /></a></td>
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
				   $Consulta="select t1.valor,t2.nombre_subclase as nom_cargo,t2.cod_subclase as cod_cargo,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_costos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31013' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' and t1.cod_tipo_costo='1' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_cargo];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVECCA','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_cargo]."</td>";
						echo "<td width='15%' align='center'>".$Fila[valor]."</td>";
						echo "<td width='15%' align='center'>".$Fila[nom_unidad]."</td>";
						echo "<tr>";	
				   }
				 ?>
	           </table></td>
           </tr>
	       </table>
	       <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	         <tr>
	           <td class="TituloTablaVerde" align="center">Ingreso de Contables </td>
             </tr>
	         <tr>
	           <td class='formulario2'>Contables
                 <select name="CmbContable">
                   <option value="-1" selected="selected" class="Selected">Seleccionar</option>
                   <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbContable==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                 </select>&nbsp;Valor
	             <input type="text" name="TxtValor3" size="10" />
	             Unidad
	             <select name="CmbUnidad3">
	               <option value="T" class="Selected">Seleccionar</option>
	               <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('8','12','18') ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad3==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                  </select>
	             &nbsp;</span><a href="JavaScript:ProcesoVenta('NVECC0')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NLEY','PP','MostrarCosto')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
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
				   $Consulta="select t1.valor,t2.nombre_subclase as nom_contable,t2.cod_subclase as cod_contable,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_costos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31013' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' and t1.cod_tipo_costo='2' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_contable];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVECC0','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_contable]."</td>";
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
           <a href="JavaScript:ProcesoExpCont('PP','MostrarCosto','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
           <? }?></td>
	 </tr>
	 <tr align="center">
	   <td class='formulario2'>Castigos</td>
	   <td align="left" class='formulario2'><?
	   if($MostrarCast=='S'||$MostrarTodos=='S')
	   {
	   ?>
         <a href="JavaScript:ProcesoExpCont('PP','MostrarCast','N')"><img src="archivos/ico_contra.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
         <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
    <tr>
      <td class="TituloTablaVerde" align="center">Ingreso de Castigos </td>
           </tr>
    <tr>
      <td class='formulario2'> Castigos
        <select name="CmbCastigo">
          <option value="-1" selected="selected" class="Selected">Seleccionar</option>
          <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31040' ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbCastigo==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
        </select>&nbsp;Valor
        <input type="text" name="TxtValor4" size="10" />
        Unidad
        <select name="CmbUnidad4">
          <option value="T" class="Selected">Seleccionar</option>
          <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('8','12','18') ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad4==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
          </select>
        &nbsp;</span><a href="JavaScript:ProcesoVenta('NVECAS')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NCAS','PP','MostrarCast')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
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
				   $Consulta="select t1.valor,t2.nombre_subclase as nom_castigo,t2.cod_subclase as cod_castigo,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_castigos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31013' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_castigo];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVECAS','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_castigo]."</td>";
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
  <a href="JavaScript:ProcesoExpCont('PP','MostrarCast','S')"><img src="archivos/ico_expan.gif" alt="Agregar" width="15" height="15"  border="0" align="absmiddle" /></a>
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
      <td class="TituloTablaVerde" align="center">Ingreso de Transporte </td>
           </tr>
    <tr>
      <td class='formulario2'>&nbsp;
        Origen - Destino
          <select name="CmbOrigenDestinoTrans">
            <option value="-1" selected="selected" class="Selected">Seleccionar</option>
            <?
			$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31036' ";			
			$Resp=mysql_query($Consulta);		
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbOrigenDestinoTrans==$Fila["cod_subclase"])
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
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('8','12','18') ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad5==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
          </select>
        &nbsp;</span><a href="JavaScript:ProcesoVenta('NVETRANS')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NDES','PP','MostrarTras')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
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
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31013' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_origen_destino";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_origen_destino];
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
      <td class="TituloTablaVerde" align="center">Ingreso de Precios </td>
           </tr>
    <tr>
      <td class='formulario2'>&nbsp;
        Leyes
          <select name="CmbPrecios">
            <option value="-1" selected="selected" class="Selected">Seleccionar</option>
            <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31037' ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbPrecios==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
          </select>
Valor
        <input type="text" name="TxtValor6" size="10" />&nbsp;Valor2
        <input type="text" name="TxtValor7" size="10" />
        Unidad
        <select name="CmbUnidad6">
          <option value="T" class="Selected">Seleccionar</option>
          <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' and cod_subclase in('7','8','12','18') ";			
					$Resp=mysql_query($Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbUnidad6==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
          </select>
        &nbsp;</span><a href="JavaScript:ProcesoVenta('NVEPRE')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> <a href="JavaScript:ProcesoNuevo('NLEY','PP','MostrarPre')"><img src="archivos/btn_ingreso_obs2.png"  alt="Ingresar Nuevo" align="absmiddle" border="0" /></a></td>
           </tr>
    <tr>
      <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td width="10%" align="center" class="TituloCabecera">Elim.</td>
                   <td width="30%" align="center" class="TituloCabecera">&nbsp;</td>
                   <td width="30%" align="center" class="TituloCabecera">Unidad</td>
                   <td width="30%" align="center" class="TituloCabecera">Valor</td>
				   <td width="30%" align="center" class="TituloCabecera">Valor2</td>
                 </tr>
        <?
				   $Consulta="select t1.valor,t1.valor2,t2.nombre_subclase as nom_precio,t2.cod_subclase as cod_precio,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_precios t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31013' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$CodTipoAnalisis."' order by cod_tipo";
				   //echo $Consulta;
				   $Resp=mysql_query($Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
				   		echo "<tr>";
						$Codigo=$Cod."~".$Fila[cod_precio];
						echo "<td align='center' width='1%'><a href=JavaScript:ProcesoVenta('EVEPRE','".$Codigo."')><img src='archivos/elim_hito.png'  alt='Eliminar' align='absmiddle' border='0' width='15' height='15'></a></td>";
						echo "<td width='15%' align='center'>".$Fila[nom_precio]."</td>";
						echo "<td width='15%' align='center'>".$Fila[nom_unidad]."</td>";
						echo "<td width='15%' align='center'>".$Fila[valor]."</td>";
						echo "<td width='15%' align='center'>".$Fila[valor2]."</td>";
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