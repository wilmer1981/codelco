<?

$AnoIni=$ano;
$fechainicio=$AnoIni."-"."01"."-01";
$fechafinal=$AnoIni."-"."12"."-31";
while ($fechainicio <= $fechafinal)
{ 
$forma=str_pad(substr($fechainicio,5,2),2,"0",STR_PAD_LEFT);
$fechainicio1=$ano."-$forma"."-01";
$fechafin=$ano."-$forma"."-31";
			$consulta0="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='92' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta1="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='93' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta2="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='95' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta3="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='99' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta4="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='129' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta5="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='131' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta6="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='145' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta7="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='402' and FECHA BETWEEN $fechaini and $fechafin";
			$consulta8="SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE T_MOV='2' AND N_FLUJO='404' and FECHA BETWEEN $fechaini and $fechafin";

$resultado=mysql_query($consulta0);
$resultado1=mysql_query($consulta1);
$resultado2=mysql_query($consulta2);
$resultado3=mysql_query($consulta3);
$resultado4=mysql_query($consulta4);
$resultado1=mysql_query($consulta5);
$resultado2=mysql_query($consulta6);
$resultado3=mysql_query($consulta7);
$resultado4=mysql_query($consulta8);

if ($linea=mysql_fetch_array($resultado))
{
$ps=$linea[PESOSECO];
$fc=$linea[FINOCOBRE];
$fp=$linea[FINOPLATA];
$fo=$linea[FINORO];
}
if ($linea1=mysql_fetch_array($resultado1))
{
$ps1=$linea1[PESOSECO];
$fc1=$linea1[FINOCOBRE];
$fp1=$linea1[FINOPLATA];
$fo1=$linea1[FINORO];
}
if ($linea2=mysql_fetch_array($resultado2))
{
$ps2=$linea2[PESOSECO];
$fc2=$linea2[FINOCOBRE];
$fp2=$linea2[FINOPLATA];
$fo2=$linea2[FINORO];
}
if ($linea3=mysql_fetch_array($resultado3))
{
$ps3=$linea3[PESOSECO];
$fc3=$linea3[FINOCOBRE];
$fp3=$linea3[FINOPLATA];
$fo3=$linea3[FINORO];
}
if ($linea4=mysql_fetch_array($resultado4))
{
$ps4=$linea4[PESOSECO];
$fc4=$linea4[FINOCOBRE];
$fp4=$linea4[FINOPLATA];
$fo4=$linea4[FINORO];
}
if ($linea5=mysql_fetch_array($resultado5))
{
$ps5=$linea5[PESOSECO];
$fc5=$linea5[FINOCOBRE];
$fp5=$linea5[FINOPLATA];
$fo5=$linea5[FINORO];
}
if ($linea6=mysql_fetch_array($resultado6))
{
$ps6=$linea6[PESOSECO];
$fc6=$linea6[FINOCOBRE];
$fp6=$linea6[FINOPLATA];
$fo6=$linea6[FINORO];
}
if ($linea7=mysql_fetch_array($resultado7))
{
$ps7=$linea7[PESOSECO];
$fc7=$linea7[FINOCOBRE];
$fp7=$linea7[FINOPLATA];
$fo7=$linea7[FINORO];
}
if ($linea8=mysql_fetch_array($resultado8))
{
$ps8=$linea8[PESOSECO];
$fc8=$linea8[FINOCOBRE];
$fp8=$linea8[FINOPLATA];
$fo8=$linea8[FINORO];
}
$totalps=ps+ps1+ps2+ps3+ps4+ps5-ps6-ps7-ps8;
$totalfc=fc+fc1+fc2+fc3+fc4+fc5-fc6-fc7-fc8;
$totalfp=fp+fp1+fp2+fp3+fp4+fp5-fp6-fp7-fp8;
$totalfo=fo+fo1+fo2+fo3+fo4+fo5-fo6-fo7-fo8;

$pesoseco[intval($forma-1)]=$totalps;
$finocobre[intval($forma-1)]=$totalfc;
$finoplata[intval($forma-1)]=$totalfp;
$finoro[intval($forma-1)]=$totalfo;
}
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Peso Seco</td>";
			$total=0;
			while(list($c,$v)=each($pesoseco))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total=$total+$v;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
				
			}
			echo "<td align='right'>".$formato=number_format($total,'0',',','.')."</td>";
			reset($pesobasepmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Peso Seco</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($pesodifpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
			}
			$totals=$total-$total1;
			echo "<td align='right'>".abs($formato=number_format($totals,'0',',','.'))."</td>";
			reset($pesodifpmn);
			$total2=0;
			$total1=0;
			$totall1=0;
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Cobre</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($finocobrebasepmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total3=$total3+$v;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
			}
			echo "<td align='right'>".$formato=number_format($total3,'0',',','.')."</td>";
			reset($finocobrebasepmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Cobre</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($finocobrefinalpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total4=$total4+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total4,'0',',','.')."</td>";
			reset($finocobrefinalpmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Cobre</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($finocobredifpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$sumar=$total3-$total4;
				}	
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
			}
			echo "<td align='right'>".abs($formato=number_format($sumar,'0',',','.'))."</td>";
			reset($finocobredifpmn);
			$sumar=0;
			$total3=0;
			$total4=0;
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Plata</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($finoplatabasepmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total5=$total5+$v;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
				
			}
			echo "<td align='right'>".$formato=number_format($total5,'0',',','.')."</td>";
			reset($finoplatabasepmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Plata</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($finoplatafinalpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total6=$total6+$v;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
			}
			echo "<td align='right'>".$formato=number_format($total6,'0',',','.')."</td>";
			
			reset($finoplatafinalpmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Plata</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($finoplatadifpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
									$sumas=$total5-$total6;

			}
			echo "<td align='right'>".abs($formato=number_format($sumas,'0',',','.'))."</td>";
			reset($finoplatadifpmn);
			$sumas=0;
			$total5=0;
			$total6=0;
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Oro</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($finoorobasepmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total7=$total7+$v;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
									

			}
			echo "<td align='right'>".$formato=number_format($total7,'0',',','.')."</td>";
			reset($finoorobasepmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Oro</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($finoorofinalpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$suma=$suma+$v;
				}	
				//if ($v==0)
				//{
				//$v=0;
				//echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				//}
			}
			echo "<td align='right'>".$formato=number_format($suma,'0',',','.')."</td>";
			reset($finoorofinalpmn);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Oro</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($finoorodifpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
			}
			$sumar=$total7-$suma;
			echo "<td align='right'>".$formato=number_format($sumar,'0',',','.')."</td>";
			reset($finoorodifpmn);
			$sumar=0;
			$total7=0;
			$suma=0;
			echo "</tr>";
			break;