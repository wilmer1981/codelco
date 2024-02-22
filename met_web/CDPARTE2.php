 <?
if ($buscarOPT=="S")
	{
		$AnoIni=$ano;
		$AnoFin=$anno;
		$bgColor="#FFFFFF";
		$fechainicio=$AnoIni."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-01";
		$fechafinal=$AnoFin."-".str_pad($mess,2,"0",STR_PAD_LEFT)."-31";
		while ($AnoIni <= $AnoFin)
		{
			if ($bgColor=="#FFFFFF")
			$bgColor="";
			else
			$bgColor="#FFFFFF";
			$PESOBASE=array("0","0","0","0","0","0","0","0","0","0","0","0");
			$PESOFINAL=array("0","0","0","0","0","0","0","0","0","0","0","0");
			$PESODIF=array("0","0","0","0","0","0","0","0","0","0","0","0");		
			$j=0;
			while ($fechainicio <= $fechafinal)
			{
				$forma=str_pad(substr($fechainicio,5,2),2,"0",STR_PAD_LEFT);
				$fechaini=$ano."-$forma"."-01";
				$fechafin=$ano."-$forma"."-31";
				$sql= "SELECT Sum(P_SECO) AS PESOSECO from enabal_base where (FECHA BETWEEN '$fechaini' AND 'fechafin') AND (ENABAL_BASE.NOM_PRODUCTO='$producto1') and (ENABAL_BASE.N_FLUJO='$txtflujo') and ENABAL_BASE.T_MOV='$select2' ";
				$sql1= "SELECT Sum(P_SECO) AS PESOSECO1 from enabal where (FECHA BETWEEN '$fechaini' AND 'fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				PESOSECOENABAL($sql,$sql1);
				$fechainicio=date('Y-m-d',mktime(0,0,0,substr($fechainicio,5,2)+1,substr($fechainicio,8,2),substr($fechainicio,0,4)));
				$fechaini=date('Y-m-d',mktime(0,0,0,substr($fechaini,5,2)+1,substr($fechaini,8,2),substr($fechaini,0,4)));
				$j=$j+1;
				reset($Valores);
				$suma=0;
				$totalpesobase=0;
				for ($i=0;$i<12;$i++)
				{
					$suma= $PESOBASE[$i];
					$totalpesobase= $total+$suma;
				}
				$suma1=0;
				$totalpesofinal=0;
				for ($i=0;$i<12;$i++)
				{
					$suma1= $PESOFINAL[$i];
					$totalpesofinal= $totalrechazo+$suma1;
				}
				$totalRechazo=$totalrechazo/12;
			}
?>	
        <tr bgcolor="<? echo $bgColor;?>"align="center">
          <td rowspan="2"><? echo $AnoIni; ?></td>
          <td><strong>Fino Cu</strong></td>
          <td><? echo $formato=number_format($Valores[0],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[1],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[2],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[3],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[4],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[5],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[6],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[7],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[8],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[9],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[10],'0',',','.'); ?></td>
          <td><? echo $formato=number_format($Valores[11],'0',',','.'); ?></td>
          <td><? echo $format=number_format($total,'0',',','.'); $total=0;?></td>
        </tr>
        <tr bgcolor="<? echo $bgColor;?>">
          <td><strong>(%) de Rechazo </strong></td>
          <td><? echo $formato=number_format($Rechazo[0],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[1],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[2],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[3],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[4],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[5],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[6],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[7],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[8],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[9],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[10],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($Rechazo[11],'2',',','.'); ?></td>
          <td><? echo $formato=number_format($totalRechazo,'2',',','.'); $totalrechazo=0; $totalRechazo=0; ?></td>
        </tr>
<?
		$AnoIni++;
	}
	}
?>		
      </table></td>