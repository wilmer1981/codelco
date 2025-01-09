<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
<?php //echo "tipo control:   ".$TipoControl;?>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
		<table width="90%" border="0" cellpadding="0" cellspacing="4">
		<tr>
			<td align="left"><?php echo DescripOrganica2($CodSelTarea);?></td>
			<td align="right"><span class="formulario">Fin Identificacion Peligros&nbsp;</span><a href="javascript:ValidarFinIdentPel('VFIP','<?php echo $CodSelTarea;?>')"><img src="imagenes/acepta.png" alt='Aceptar Fin Identificacion Peligros' border="0" align="absmiddle"></a></td>
			<?php //echo $CodSelTarea;?>
		</tr>
		</table>
		<!--<table width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
		<tr>
			<td width="29%" class="TituloCabecera" >Peligro</td>
			<td width="25%" class="TituloCabecera" >Obs/Comentario</td>
			<td width="25%" class="TituloCabecera" >Controles</td>
			<td width="3%" class="TituloCabecera" >PH</td>
			<td width="3%" class="TituloCabecera" >CH</td>
			<td width="3%" class="TituloCabecera" >PC</td>
			<td width="3%" class="TituloCabecera" >CC</td>
			<td width="4%" class="TituloCabecera" >&nbsp;</td>
			<td width="5%" class="TituloCabecera" >Validado</td>
		 </tr>
	    </table>-->
	    <div id='Resumen'  style='overflow:auto;WIDTH: 100%; height:360px;left: 15px; top: 45px;'>
          <table width="140%" border="1" cellpadding="0" cellspacing="0" align="left">
			<tr>
				<td width="20%" class="TituloCabecera" align="center" >Peligro</td>
				<td width="10%" class="TituloCabecera" align="center">Descripción</td>
				<td align='center' width='3%' class='TituloCabecera' >MRi</td>
				<td align='left' width='30%' class='TituloCabecera' ><table width="100%" class="TituloCabecera"><td width="70%">Famila de Controles</td><td width="30%">Especificación</td></table></td>
				<td width="35%" class="TituloCabecera"><table width="100%" class="TituloCabecera"><td width="70%">Familia de Verificadores</td><td width="30%">Especificación</td></table></td>
				<td width="3%" class="TituloCabecera" >MRr</td>
				<td width="3%" class="TituloCabecera" align="center">Val</td>
		    </tr>

			<?php 
			$CODAREA=ObtenerCodParent($CodSelTarea);
			$Consulta="select t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.MVALIDADO,t1.MR1,t1.MR2,t1.QPROBHIST,t1.QCONSECHIST from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$CODAREA."' group by t1.CPELIGRO order by NCONTACTO";
			//echo $Consulta;
			$Resultado=mysqli_query($link,$Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{				
				$PH='';$CH='';$PC='';$CC='';$Validado='';
				if($Fila[MVALIDADO]=='1')
					$Validado='SI';
				CalculoMR($Fila[CCONTACTO],$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
				CalculoMRI($Fila[QPROBHIST],$Fila[QCONSECHIST],&$DESMRI,&$SEMAMRI);							
				
				$Concontacto=$Concontacto.$Fila[CCONTACTO]."~";
				echo "<tr>";
				echo "<td align='left' width='15%'>".$Fila[NCONTACTO]."</td>";
				echo "<td align='center' width='10%'><textarea rows='3' cols='30' readonly>".$Fila[TOBSERVACION]."</textarea></td>";
				//if($Descrip!='NO CALCULADO')
					echo "<td align='center'><img src='imagenes/$SEMAMRI' border=0 width='18' height='30'></td>";
				//else
					//echo "<td align='left'>&nbsp;</td>";	
				echo "<td align='left' width='20%' style='vertical-align:top;'>";
				echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
				$Consulta="select t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
				$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
				$Consulta.=" where t1.CPELIGRO ='".$Fila[CPELIGRO]."'";
				//echo $Consulta."<br>";
				$RespCtrl=mysqli_query($link,$Consulta);
				if($FilaCtrl=mysqli_fetch_array($RespCtrl))
				{
					$Consulta="select t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
					$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
					$Consulta.=" where t1.CPELIGRO ='".$Fila[CPELIGRO]."'";
					//echo $Consulta."<br>";
					$RespCtrl=mysqli_query($link,$Consulta);
					while($FilaCtrl=mysqli_fetch_array($RespCtrl))
					{
						echo "<tr>";
						$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysqli_query($link,$ConsuOBS);$Rows=0;
						while($FilaOBS=mysqli_fetch_array($RespOBS))
							$Rows=$Rows+1;
						echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaCtrl[NCONTROL]."&nbsp;&nbsp;&nbsp;</td>";
						$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						//echo $ConsuOBS."<br>";
						$RespOBS=mysqli_query($link,$ConsuOBS);
						if($FilaOBS=mysqli_fetch_array($RespOBS))
						{
							$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";							
							$RespOBS=mysqli_query($link,$ConsuOBS);
							while($FilaOBS=mysqli_fetch_array($RespOBS))
							{
								echo "<td align='left' width='30%'>&nbsp;<textarea cols='40' readonly>&nbsp;".$FilaOBS[TOBSERVACION]."</textarea></td>";
								echo "</tr>";
							}	
						}
						else
							echo "<td align='left' width='30%'>&nbsp;</td>";
					}
				}
				else
					echo "SIN CONTROLES";
				echo "</table>";
				echo "</td>";
				echo "<td style='vertical-align:top;'>";
				$ConsuVeri="select * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
				$RespVeri=mysqli_query($link,$ConsuVeri);
				if($FilaVeri=mysqli_fetch_array($RespVeri))
				{
					echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";														
					$ConsuVeri="select * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
					$RespVeri=mysqli_query($link,$ConsuVeri);
					while($FilaVeri=mysqli_fetch_array($RespVeri))
					{
						echo "<tr>";
						$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
						$RespOBS=mysqli_query($link,$ConsuOBS);$Rows=0;
						while($FilaOBS=mysqli_fetch_array($RespOBS))
							$Rows=$Rows+1;
						echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaVeri[DESCRIP_VERIFICADOR]."&nbsp;&nbsp;&nbsp;</td>";
						$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
						//echo $ConsuOBS."<br>";
						$RespOBS=mysqli_query($link,$ConsuOBS);
						if($FilaOBS=mysqli_fetch_array($RespOBS))
						{
							$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysqli_query($link,$ConsuOBS);
							while($FilaOBS=mysqli_fetch_array($RespOBS))
							{
								echo "<td align='left' width='30%'>&nbsp;<textarea cols='40' readonly>&nbsp;".$FilaOBS[TOBSERVACION]."</textarea></td>";
								echo "</tr>";
							}	
						}
					}
					echo "</table>";

				}
				else
				{
					echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";														
					echo "<tr>";
					echo "<td coslpan='2'>SIN VERIFICADORES</td>";
					echo "</tr>";
					echo "</table>";
				}					
				echo "</td>";
/*				echo "<td align='center' width='3%'>".$PH."</td>";
				echo "<td align='center' width='3%'>".$CH."</td>";
				echo "<td align='center' width='3%'>".$PC."&nbsp;</td>";
				echo "<td align='center' width='3%'>".$CC."&nbsp;</td>";
*/
				if($Fila[MR1]==$Fila[MR2]&&$Fila[MR1]!=0&&$Fila[MR2]!=0)// SI SON IGUALES
				{
					if($Fila[MR1]==1&&$Fila[MR2]==1)// SI SON IGUALES VERDE
						$SEMAMRI="<img src='imagenes/semaforo_verde.jpg' border=0 width='18' height='30'>";
					if($Fila[MR1]==2&&$Fila[MR2]==2)// SI SON IGUALES AMARILLO
						$SEMAMRI="<img src='imagenes/semaforo_amarillo.jpg' border=0 width='18' height='30'>";
					if($Fila[MR1]==3&&$Fila[MR2]==3)// SI SON IGUALES ORJO
						$SEMAMRI="<img src='imagenes/semaforo_rojo.jpg' border=0 width='18' height='30'>";
				}
				else
					$SEMAMRI="<img src='imagenes/semaforo_nada.jpg' border=0 width='18' height='30'>";
				echo "<td align='center' width='4%'>".$SEMAMRI."</td>";
				//echo "<td align='center' width='4%'><img src='imagenes/$Semaforo' border=0 width='18' height='30'></td>";
				echo "<td align='center' width='5%'>".$Validado."&nbsp;</td>";
				echo "</tr>";
			}
		    if($Concontacto !='')
			   $Concontacto=substr($Concontacto,0,strlen($Concontacto)-1);	
			echo "<input type='hidden' size='100' name='CODCONTACTO' value='".$Concontacto."'> ";
		 ?>
          </table>
      </div>
	 </td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>