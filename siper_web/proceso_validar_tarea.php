<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
		<table width="90%" border="0" cellpadding="0" cellspacing="4">
		<tr>
			<td align="left"><? echo DescripOrganica2($CodSelTarea);?></td>
			<td align="right">
			<?
			$CODAREA=ObtenerCodParent($CodSelTarea);			
			$SIVAL='1';
			$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.MVALIDADO,t1.MR1,t1.MR2,t1.QPROBHIST,t1.QCONSECHIST from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$CODAREA."' group by t1.CPELIGRO order by CCONTACTO";
			//echo $Consulta."<br>";
			$Resultado=mysqli_query($link, $Consulta);
			if ($Fila=mysql_fetch_array($Resultado))
			{
				$Consulta="SELECT * from sgrs_siperpeligros where CAREA='".$CODAREA."' and MVALIDADO='0'";
				//echo $Consulta."<br>";
				$Resultado=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resultado))
					$EXISTEUNO='SI';//TODOS VALIDADOS
				else
					$EXISTEUNO='NO';
				if($EXISTEUNO=='NO')
				{
					//echo "aca";
					$Consulta1="SELECT MVALIDADO from sgrs_siperoperaciones where CAREA='".$CODAREA."'";
					//echo $Consulta1."<br>";
					$Resultado1=mysql_query($Consulta1);
					$Fila1=mysql_fetch_array($Resultado1);
					$AREAVALID=$Fila1[MVALIDADO];
					
					if($AREAVALID=='0')
					{
					?>
						<a href="javascript:ValidarTarea('VT')"><img src="imagenes/acepta.png" alt='Validar Tarea' border="0" align="absmiddle"></a>&nbsp;<span class="formulario">Validar Tarea</span>
					<?
						$SIVAL='1';
					}
					else
					{
					?>
						<a href="javascript:ValidarTarea('DVT')"><img src="imagenes/acepta.png" alt='Desvalidar Tarea' border="0" align="absmiddle"></a>&nbsp;<span class="formulario">Desvalidar</span>
					<?
						$SIVAL='2';
					}
				}	
				else
					echo "<span class='InputRojo'>No se puede Validar Tarea, Faltan Peligros por Validar.</span>";
			}
			else
				echo "<span class='InputRojo'>No se puede Validar Tarea, Faltan Peligros por Validar.</span>";
			?>			
			
			</td>
		</tr>
		</table>
	    <div id='Resumen'  style='overflow:auto;WIDTH: 100%; height:360px;left: 15px; top: 65px;'>
           <table width="140%" border="1" cellpadding="0" cellspacing="0" align="left">
			<tr>
				<td width="3%" class="TituloCabecera" align="center" >Desvalidar</td>
				<td width="25%" class="TituloCabecera" align="center" >Peligro</td>
				<td width="10%" class="TituloCabecera" align="center">Descripci�n</td>
				<td align='center' width='2%' class='TituloCabecera' >MRi</td>
				<td align='left' width='30%' class='TituloCabecera' ><table width="100%" border="0" cellpadding="0" cellspacing="0"><td width="60%">Famila de Controles</td><td>Especificaci�n de Controles</td></table>
				<td width='40%' class='TituloCabecera'><table width="100%" border="0" cellpadding="0" cellspacing="0"><td align="left">Familia de Verificadores</td><td align="left">Especificaci�n de Verificadores</td></table>
				<td width="4%" class="TituloCabecera" >MRr</td>
			 </tr>

			<? 			
			$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.MVALIDADO,t1.MR1,t1.MR2,t1.QPROBHIST,t1.QCONSECHIST from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$CODAREA."' group by t1.CPELIGRO order by t2.NCONTACTO";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resultado))
			{
				$PH='';$CH='';$PC='';$CC='';$Validado='';
				if($Fila[MVALIDADO]=='1')
					$Validado='SI';
				CalculoMR($Fila[CCONTACTO],$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
				CalculoMRI($Fila[QPROBHIST],$Fila[QCONSECHIST],&$DESMRI,&$SEMAMRI);							
				if($SIVAL=='1')
				{
					if($Validado=='SI')
					{
						if($Fila[MR1]==$Fila[MR2])//----------------DESVALIDAMOS EL PELIGRO POR SI SOLO--------------------
							$Des="<a href=JavaScript:Desvalida('".$CODAREA."','".$Fila[CPELIGRO]."')><img src='imagenes/acepta.png' alt='Desvalidar Peligro' border='0' align='absmiddle'></a>";
						else
							$Des='&nbsp;';	
					}
					else
						$Des='&nbsp;';	
				}
				else
					$Des='&nbsp;';	
				echo "<tr>";
				echo "<td align='center' width='3%'>".$Des."</td>";
				echo "<td align='left' width='25%'>".$Fila[NCONTACTO]."</td>";
				echo "<td align='center' width='15%'><textarea rows='3' cols='30' readonly>".$Fila[TOBSERVACION]."</textarea></td>";
				//if($Descrip!='NO CALCULADO')
					echo "<td align='center'><img src='imagenes/$SEMAMRI' border=0 width='18' height='30'></td>";
				//else
					//echo "<td align='left'>&nbsp;</td>";	
				echo "<td align='left' width='40%'>&nbsp;";
				if($Descrip!="ACEPTABLE"&&$Descrip!="MODERADO"&&$Descrip!="INACEPTABLE")
					echo $Descrip;
				echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
					$Consulta="SELECT t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
					$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
					$Consulta.=" where t1.CPELIGRO ='".$Fila[CPELIGRO]."'";
					//echo $Consulta."<br>";
					$RespCtrl=mysqli_query($link, $Consulta);
					while($FilaCtrl=mysql_fetch_array($RespCtrl))
					{
						echo "<tr>";
						$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysql_query($ConsuOBS);$Rows=0;
						while($FilaOBS=mysql_fetch_array($RespOBS))
							$Rows=$Rows+1;
						echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaCtrl[NCONTROL]."&nbsp;&nbsp;&nbsp;</td>";
						$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysql_query($ConsuOBS);
						if($FilaOBS=mysql_fetch_array($RespOBS))
						{
							$ConsuOBS="SELECT * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
							$RespOBS=mysql_query($ConsuOBS);
							while($FilaOBS=mysql_fetch_array($RespOBS))
							{
								echo "<td align='left' width='30%'>&nbsp;<textarea cols='40' readonly>&nbsp;".$FilaOBS[TOBSERVACION]."</textarea></td>";
								echo "</tr>";
							}	
						}
						else
							echo "<td align='left' width='30%'>&nbsp;</td>";
					}
					echo "</table>";
					echo "</td>";
					echo "<td><br>";
					$ConsuVeri="SELECT * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
					$RespVeri=mysql_query($ConsuVeri);
					if($FilaVeri=mysql_fetch_array($RespVeri))
					{
						echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";														
						$ConsuVeri="SELECT * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
						$RespVeri=mysql_query($ConsuVeri);
						while($FilaVeri=mysql_fetch_array($RespVeri))
						{
							echo "<tr>";
							$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysql_query($ConsuOBS);$Rows=0;
							while($FilaOBS=mysql_fetch_array($RespOBS))
								$Rows=$Rows+1;
							$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysql_query($ConsuOBS);
							if($FilaOBS=mysql_fetch_array($RespOBS))
							{
								echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaVeri[DESCRIP_VERIFICADOR]."&nbsp;&nbsp;&nbsp;</td>";
								$ConsuOBS="SELECT * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
								$RespOBS=mysql_query($ConsuOBS);
								while($FilaOBS=mysql_fetch_array($RespOBS))
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
						echo "<td coslpan='2' align='left'>SIN VERIFICADORES</td>";
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
				echo "</tr>";
			}
		 ?>
          </table>
      </div>
	 </td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>