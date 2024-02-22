<?php
		echo "<br>";
		$datos=explode("~",$productos);
		$producto1=$datos[1];
		
		if($buscarOPT=="S" and $opconsulta=="1")
		{	
			$separador1=explode("-",$txtfecha2);
			$i=0;
			for ($txtfecha;$txtfecha<=$txtfecha2;$i++)
			{
				$separador=explode("-",$txtfecha);
				$i=$separador[1];
				$formato=str_pad($i,"0",STR_PAD_LEFT);
				echo $formato;
				$sql= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO 
				from enabal_base where (FECHA BETWEEN '$separador[0]-$formato-01' AND '$separador[0]-$formato-31') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$Var1=$sql;
				//echo $sql.$i."<br>";
				//echo "<br>";
				$consulta= "SELECT Sum(P_SECO) AS PESOSECO1, Sum(F_COBRE) AS FINOCOBRE1, Sum(F_PLATA) AS FINOPLATA1, Sum(F_ORO) AS FINOORO1 
				from enabal where (FECHA BETWEEN '$separador[0]-$formato-01' AND '$separador[0]-$formato-31') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				//echo $consulta.$i."<br>";
				//echo "<br>";
				$txtfecha=date('Y-m-d',mktime(0,0,0,substr($txtfecha,5,2)+1,substr($txtfecha,8,2),substr($txtfecha,0,4)));
				$Var1=$sql;
				//echo $Var1."<br>";
				//echo "<br>";
				$Var2=$consulta;
				//echo $Var2."<br>";
				//echo $sql3."<br>";
				MostrarDatos($Var1,$Var2);
				///MostrarDatos($sql.$i,$consulta.$i);
			}
		}
		$opconsulta=2;
		if($buscarOPT=="S" and $opconsulta=="2")
		{
			$j=0;
			$txtfecha1=$txtfecha;
			$txtfecha3=$txtfecha2;
			for ($txtfecha1;$txtfecha1<=$txtfecha3;$j++)
			{
				$separador1=explode("-",$txtfecha1);
				$j=$separador1[1];
				$formato1=str_pad($j,"0",STR_PAD_LEFT);
				$sqd= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO 
				from enabalpmn_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";
				$consultad= "SELECT Sum(P_SECO) AS PESOSECO1, Sum(F_COBRE) AS FINOCOBRE1, Sum(F_PLATA) AS FINOPLATA1, Sum(F_ORO) AS FINOORO1 
				from enabalpmn where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN.N_FLUJO='$txtflujo') and (ENABALPMN.NOM_PRODUCTO='$producto1') and ENABALPMN.T_MOV='$select2' ";
				$txtfecha1=date('Y-m-d',mktime(0,0,0,substr($txtfecha1,5,2)+1,substr($txtfecha1,8,2),substr($txtfecha1,0,4))); 
				$consulta=$sqld;
				$Var2=$consultad;
				MostrarDatos($Var1,$Var2);
			}
		}
		function MostrarDatos($Var1,$Var2)
		{
			//echo "CONS1:".$Var1."<br><BR>";
			//-------------------------------------------------------------------//
			//-------------------------------------------------------------------//
		 echo "<table width='537' border='1' align='center' cellpadding='2' cellspacing='0' class='TablaDetalle'>";
		 echo "<tr align='center' class='ColorTabla01'>";
         echo "<td>Tipo de Datos</td>";
         echo"<td>Peso Seco (Kg)</td>";
         echo "<td>Cobre (Kg)</td>";
         echo "<td>Plata (gr)</td>";
         echo "<td >Oro (gr)</td>";
			$resultados = mysql_query($Var1);
			while($fila1=mysql_fetch_array($resultados))
			{
				if(!is_null($fila1[PESOSECO]))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
						echo "<td> Datos Base </td>";
						echo "<td>".$formato=number_format($fila1[PESOSECO],'0',',','.')."</td>";$ps1=$fila1[PESOSECO];
						echo "<td>".$formato=number_format($fila1[FINOCOBRE],'0',',','.')."</td>";$f1=$fila1[FINOCOBRE];
						echo "<td>".$formato=number_format($fila1[FINOPLATA],'0',',','.')."</td>";$f2=$fila1[FINOPLATA];
						echo "<td>".$formato=number_format($fila1[FINOORO],'0',',','.')."</td>";$f3=$fila1[FINOORO];
						echo "</tr>";
					}				
										    				
	   		}
			
			$resultadosDos = mysql_query($Var2);
			while($fila=mysql_fetch_array($resultadosDos))
			{
				if($fila[PESOSECO1] != NULL)
				{
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
					echo "<td> Datos Finales </td>";
					echo "<td>".$formato=number_format($fila[PESOSECO1],'0',',','.')."</td>";$ps2=$fila[PESOSECO1];
					echo "<td>".$formato=number_format($fila[FINOCOBRE1],'0',',','.')."</td>";$f4=$fila[FINOCOBRE1];
					echo "<td>".$formato=number_format($fila[FINOPLATA1],'0',',','.')."</td>";$f5=$fila[FINOPLATA1];
					echo "<td>".$formato=number_format($fila[FINOORO1],'0',',','.')."</td>";$f6=$fila[FINOORO1];
					echo "</tr>";
					$auxiliar="1";	
				}		    				
	    	}
			
			if($auxiliar=="1")
			{
				$uno=$ps2-$ps1;
				$dos=$f4-$f1;
				$tres=$f5-$f2;
				$cuatro=$f6-$f3;
				echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
				echo "<td> Diferencias </td>";
				echo "<td>".$formato=number_format($uno,'0',',','.')."</td>";
				echo "<td>".$formato=number_format($dos,'0',',','.')."</td>";
				echo "<td>".$formato=number_format($tres,'0',',','.')."</td>";
				echo "<td>".$formato=number_format($cuatro,'0',',','.')."</td>";
				echo "</tr>";
				echo "</table>";
				echo "<br>";
			}

		}

	?>