<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	include("../principal/conectar_principal.php");
	$Mostrar='N';
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta ="select t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.descripcion as nom_subproducto,t1.rut_proveedor,t4.NOMPRV_A as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="rec_web.proved t4 on t1.rut_proveedor=t4.RUTPRV_A left join ";
		$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase ";
		$Consulta.= "where t1.lote = '".$TxtLote."'";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$Mostrar='S';
			$TxtLote = $Fila["lote"];
			$CodSubProducto = $Fila["cod_subproducto"];
			$NombreSubProducto=$Fila["nom_subproducto"];
			$RutProveedor = $Fila["rut_proveedor"];
			$NombrePrv=$Fila["nom_prv"];
			$CodFaena=$Fila["cod_faena"];
			$NombreFaena = $Fila["nom_faena"];
			$Recepcion = $Fila["nom_recepcion"];
			$ClaseProducto = $Fila["nom_clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$EstadoLote = $Fila["nom_estado_lote"];
			$PesoRetalla=$Fila["peso_retalla"];
			$PesoMuestra=$Fila["peso_muestra"];
			//SE OBTIENE LAS LEYES A CANJEAR DEPENDIENDO DEL PRODUCTO
			$ArrayLeyes=array();
			$Consulta ="select * from age_web.leyes_canje where cod_producto='1' and cod_subproducto='".$Fila["cod_subproducto"]."'";
			$EncontroLeyes=false;
			$Leyes="in('";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$ArrayLeyes[$FilaLeyes["cod_ley"]][0]='';//NOMBRE DE LA LEY
				$ArrayLeyes[$FilaLeyes["cod_ley"]][1]='';//UNIDAD DE LA LEY
				$ArrayLeyes[$FilaLeyes["cod_ley"]][2]='';//VALOR LEY PQTE 1 
				$ArrayLeyes[$FilaLeyes["cod_ley"]][3]='';//VALOR LEY PQTE 2 
				$ArrayLeyes[$FilaLeyes["cod_ley"]][4]='';//VALOR LEY PQTE 3 
				$ArrayLeyes[$FilaLeyes["cod_ley"]][5]='';//VALOR LEY PQTE 4 
				$ArrayLeyes[$FilaLeyes["cod_ley"]][6]='';//LEY RETALLA
				$ArrayLeyes[$FilaLeyes["cod_ley"]][7]='';//INCIDENCIA RETALLA
				$ArrayLeyes[$FilaLeyes["cod_ley"]][8]='';//LEY CANJE
				$ArrayLeyes[$FilaLeyes["cod_ley"]][9]='';//LEY PAGO
				$ArrayLeyes[$FilaLeyes["cod_ley"]][10]='';//NUM PAQUETE
				$Leyes=$Leyes.$FilaLeyes["cod_ley"]."','";
				$EncontroLeyes=true;
			}
			if($EncontroLeyes==true)
			{
				$Leyes=substr($Leyes,0,strlen($Leyes)-3);
				$Leyes=$Leyes."')";
				reset($ArrayLeyes);
				$Consulta="select t1.recargo,t1.cod_leyes,t1.valor,t1.cod_unidad,t2.abreviatura,t3.abreviatura as nomley from age_web.leyes_por_lote t1 ";
				$Consulta.="left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes ";
				$Consulta.="where lote='$TxtLote' and recargo in ('0','R') and t1.cod_leyes ".$Leyes;
				//echo $Consulta;
				$RespLeyes=mysqli_query($link, $Consulta);
				while($FilaLeyes=mysqli_fetch_array($RespLeyes))
				{
					switch($FilaLeyes["recargo"])
					{
						case "0":
							$ArrayLeyes[$FilaLeyes["cod_leyes"]][0]=$FilaLeyes[nomley];
							$ArrayLeyes[$FilaLeyes["cod_leyes"]][1]=$FilaLeyes["abreviatura"];
							$ArrayLeyes[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes[valor];
							$ArrayLeyes[$FilaLeyes["cod_leyes"]][10]='1';
							break;
						case "R":
							$ArrayLeyes[$FilaLeyes["cod_leyes"]][6]=$FilaLeyes[valor];
							break;		
					}
				}
				//PARA SABER SI ESTE LOTE YA TIENE CANJE GUARDADO
				$Consulta="select * from age_web.leyes_por_lote_canje where lote='$TxtLote'";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$ArrayLeyes[$Fila["cod_leyes"]][2]=$Fila[valor1];//VALOR LEY PQTE 1 
					$ArrayLeyes[$Fila["cod_leyes"]][3]=$Fila[valor2];//VALOR LEY PQTE 2 
					$ArrayLeyes[$Fila["cod_leyes"]][4]=$Fila[valor3];//VALOR LEY PQTE 3 		
					$ArrayLeyes[$Fila["cod_leyes"]][4]=$Fila[valor3];//VALOR LEY PQTE 3 
					$ArrayLeyes[$Fila["cod_leyes"]][5]=$Fila[valor4];//VALOR LEY PQTE 4 
					$ArrayLeyes[$Fila["cod_leyes"]][6]=$Fila[valor_retalla];//LEY RETALLA
					$ArrayLeyes[$Fila["cod_leyes"]][7]=$Fila[inc_retalla];//INCIDENCIA RETALLA
					$ArrayLeyes[$Fila["cod_leyes"]][8]=$Fila[ley_canje];//LEY CANJE
					$ArrayLeyes[$Fila["cod_leyes"]][9]=$Fila[inc_retalla]+$Fila[ley_canje];//LEY PAGO
					$ArrayLeyes[$Fila["cod_leyes"]][10]=$Fila[paquete_canje];//NUM PAQUETE
				}
			}	
		}
	}
	if($Calcular=='S')
	{
		$Datos=explode('//',$Valores);
		while(list($c,$v)=each($Datos))
		{
			$Datos2=explode('~~',$v);
			$CodLey=$Datos2[0];
			$NomLey=$Datos2[1];
			$NomUnidad=$Datos2[2];
			$ValorLey1=$Datos2[3];
			$ValorLey2=$Datos2[4];
			$ValorLey3=$Datos2[5];
			$ValorLey4=$Datos2[6];
			$ValorLeyR=$Datos2[7];
			$ValorIncR=$Datos2[8];
			$ValorLeyC=$Datos2[9];
			$ValorLeyF=$Datos2[10];
			$NumPqte=$Datos2[11];
			switch($NumPqte)
			{
				case "1":
					$ArrayLeyes[$CodLey][0]=$NomLey;
					$ArrayLeyes[$CodLey][1]=$NomUnidad;
					$LeyCanje=$ValorLey1;
					if($PesoMuestra!=0)
						$IncRetalla=(abs($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					else
						$IncRetalla=0;
					$ArrayLeyes[$CodLey][8]=$LeyCanje;//LEY CANJE
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','.');
					$ArrayLeyes[$CodLey][10]='1';//NUM_PAQUETE
					break;
				case "2":
					$ArrayLeyes[$CodLey][3]=$ValorLey2;//LEY CANJE
					$Consulta="select * from age_web.limites_particion where cod_plantilla=1 and cod_ley='$CodLey' and ".$ValorLey1." between rango1 and rango2";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$LimParticion=$Fila[limite_particion]*1;
					$Dif=abs($ValorLey1-$ValorLey2)*1;
					if($LimParticion<=$Dif)
						$LeyCanje=($ValorLey1+$ValorLey2)/2;//LEY CANJE
					else
						if($ValorLey1<=$ValorLey2)
							$LeyCanje=$ValorLey1;//LEY CANJE
						else
							$LeyCanje=$ValorLey2;//LEY CANJE
					if($PesoMuestra!=0)
						$IncRetalla=(abs($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					else
						$IncRetalla=0;
					$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','.');//INCIDENCIA RETALLA
					$ArrayLeyes[$CodLey][8]=$LeyCanje;
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','.');
					$ArrayLeyes[$CodLey][10]='2';//NUM_PAQUETE
					break;
				case "3":
					$ArrayValorLeyes=array($ValorLey1,$ValorLey2,$ValorLey3);
					sort($ArrayValorLeyes);
					$LeyCanje=$ArrayValorLeyes[1];//LA LEY DEL MEDIO
					$ArrayLeyes[$CodLey][3]=$ValorLey2;//LEY CANJE	1		
					$ArrayLeyes[$CodLey][4]=$ValorLey3;//LEY CANJE	2
					if($PesoMuestra!=0)
						$IncRetalla=(abs($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					else
						$IncRetalla=0;
					$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','.');//INCIDENCIA RETALLA
					$ArrayLeyes[$CodLey][8]=$LeyCanje;
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','.');
					$ArrayLeyes[$CodLey][10]='3';//NUM_PAQUETE
					break;
				case "4":
					$ArrayValorLeyes=array($ValorLey1,$ValorLey2,$ValorLey4);
					sort($ArrayValorLeyes);
					$LeyCanje=$ArrayValorLeyes[1];//LA LEY DEL MEDIO
					$ArrayLeyes[$CodLey][3]=$ValorLey2;//LEY CANJE 2			
					$ArrayLeyes[$CodLey][4]=$ValorLey3;//LEY CANJE 3
					$ArrayLeyes[$CodLey][5]=$ValorLey4;//LEY CANJE 4
					$IncRetalla=(abs($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','.');//INCIDENCIA RETALLA
					$ArrayLeyes[$CodLey][8]=$LeyCanje;
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','.');				
					$ArrayLeyes[$CodLey][10]='4';//NUM_PAQUETE
					break;
			}
		}
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="650"  border="1" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="438" align="center"><strong>CANJE DE LEYES</strong></td>
	<td width="197" align="right">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:60px " onClick="Proceso('I')">
		<input name="BtnExcel" type="button" value="Excel" style="width:60px " onClick="Proceso('E','<?php echo TxtLote;?>','<?php echo $Valores;?>')">
		<input name="BtnSalir" type="button" value="Salir" style="width:60px " onClick="Proceso('S')">
	</td>
  </tr>
  </table><br>
  <table width="650"  border="1" align="center" cellpadding="2" cellspacing="0"> 
  <tr>
    <td width="88" ><strong>Lote:</strong></td>
    <td><?php echo $TxtLote; ?>
    <td align="right"><strong>Num.Conjunto:</strong></td>
    <td width="145"><?php if(isset($TxtConjunto)) echo $TxtConjunto; else echo "&nbsp;";?></td>
  </tr>
  <tr>
    <td><strong>SubProducto:</strong></td>
    <td><?php if(isset($CodSubProducto)) echo $CodSubProducto." - ".$NombreSubProducto; else echo "&nbsp;";?></td>
    <td align="right" ><strong>Clase Producto:</strong></td>
    <td><?php if(isset($ClaseProducto)) echo $ClaseProducto; else echo "&nbsp;";?></td>
  </tr>
  <tr>
    <td><strong>Proveedor:</strong></td>
    <td><?php if(isset($RutProveedor)) echo $RutProveedor." - ".$NombrePrv; else echo "&nbsp;";?></td>
    <td align="right" ><strong>Cod.Recepcion:</strong></td>
    <td><?php if(isset($Recepcion)) echo $Recepcion; else echo "&nbsp;";?></td>
  </tr>
  <tr>
    <td ><strong>Cod Faena:</strong></td>
    <td ><?php if(isset($CodFaena)) echo $CodFaena." - ".$NombreFaena; else echo "&nbsp;";?></td>
    <td align="right" ><strong>Peso Retalla:</strong></td>
    <td ><?php if(isset($PesoRetalla)) echo $PesoRetalla; else echo "&nbsp;";?></td>
  </tr>
  <tr >
    <td ><strong>Estado Lote:</strong></td>
    <td ><?php if(isset($EstadoLote)) echo strtoupper($EstadoLote); else echo "&nbsp;";?></td>
    <td align="right" ><strong>Peso Muestra:</strong></td>
    <td ><?php if(isset($PesoMuestra)) echo $PesoMuestra; else echo "&nbsp;";?></td>
  </tr>
  </table>
  <br>
	<table width="650"  border="1" align="center" cellpadding="2" cellspacing="0" >
	  <tr align="center">
		<td width="40">Ley</td>
		<td width="40">Unidad</td>
		<td width="70">Ley 1ra</td>
		<td width="70">Ley 2da</td>
		<td width="70">Ley 3era</td>
		<td width="70">Ley 4ta</td>
		<td width="70">Ley Retalla</td>
		<td width="70">Inc. Retalla</td>
		<td width="70">Ley Canje</td>
		<td width="70">Ley Final</td>
	  </tr>
	  <?php
	  if ($Mostrar=='S')
	  {
		  while(list($c,$v)=each($ArrayLeyes))
		  {
			if ($v[0]!='')
			{
				echo "<tr align='left'>";
				echo "<td>&nbsp;&nbsp;$v[0]</td>";
				echo  "<td align='center'>$v[1]</td>";
				switch($v[10])//INDICA EL NUMERO DE PAQUETE
				{
					case "1"://PAQUETE PRIMERO
						$Color1='bgcolor=#CCCCCC';$Color2='';$Color3='';$Color4='';
						break;
					case "2"://PAQUETE SEGUNDO
						$Color1='';$Color2='bgcolor=#CCCCCC';$Color3='';$Color4='';
						break;
					case "3"://PAQUETE TERCERO
						$Color1='';$Color2='';$Color3='bgcolor=#CCCCCC';$Color4='';
						break;
					case "4"://PAQUETE CUARTO
						$Color1='';$Color2='';$Color3='';$Color4='bgcolor=#CCCCCC';
						break;
				}
				echo "<td align='right' $Color1>$v[2]&nbsp;</td>";
				echo "<td align='right' $Color2>$v[3]&nbsp;</td>";
				echo "<td align='right' $Color3>$v[4]&nbsp;</td>";
				echo "<td align='right' $Color4>$v[5]&nbsp;</td>";
				echo "<td align='right'>$v[6]&nbsp;</td>";
				echo "<td align='right'>$v[7]&nbsp;</td>";
				echo "<td align='right'>$v[8]&nbsp;</td>";
				echo "<td align='right'>$v[9]&nbsp;</td>";
				echo "</tr>";
			}	
		  }
	  } 
	  ?>
	</table>
</form>
</body>
</html>
