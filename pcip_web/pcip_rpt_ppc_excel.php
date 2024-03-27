<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Consulta Programa Producci�n</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo11 {font-size: 11px}
-->
</style>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <tr>
      <td align="center"><span class="Estilo11">Asignaciones Reales de Producci&oacute;n</span></td>
      <td align="center"><span class="Estilo11">Titulo</span></td>
      <td align="center"><span class="Estilo11">Tipo</span></td>
      <?
			  if($CmbMostrar=='D')
			  {
					for($i=$Mes;$i<=$MesFin;$i++)
					{				
						echo "<td align='center'><span class='Estilo11'>".$Meses[$i-1]."</span></td>";
					}			  
			  }
			  ?>
      <td align="center"><span class="Estilo11">TOTAL</span></td>
    </tr>
    <?
		  //$CmbMostrar='X';
			$ArrayTotReal=array(); 
			$ArrayTotProg=array(); 
			$ArraySubTotalGrupoReal=array(); 
			$ArraySubTotalGrupoPpto=array(); 
			for($i=$Mes;$i<=$MesFin;$i++)
			{	
			$ArraySubTotalGrupoReal[$i][0]=0; 
			$ArraySubTotalGrupoPpto[$i][0]=0; 
			$ArraySVP[$i][0]=0;
			}
			$Buscar='S';
       if($Buscar=='S')
	   {
		  $Version=explode('-',$CmbVersion);
		  $CmbVersion=$Version[1];
		  if($CmbMostrar=='D')//DETALLE
		  {
			$Consulta="select t1.cod_producto,t1.nom_asignacion,t1.cod_asignacion,t2.version,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_ppc_detalle t2 on t1.cod_producto=t2.cod_procedencia ";
			$Consulta.="where t1.cod_asignacion='".$CmbProd."' and (t2.ano='".$Ano."' and t2.mes between '".$Mes."' and '".$MesFin."') and t2.version='".$CmbVersion."' and t1.mostrar_ppc='1'";
			if($CmbAsig!='-1')
				$Consulta.=" and t1.cod_producto='".$CmbAsig."'";
			$Consulta.=" group by t1.cod_producto order by t1.orden";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$TotalProd=0;
				$CantFilas=ObtieneCantFilasTitulos($Fila[cod_asignacion],$Fila["cod_producto"],$Ano,$Mes,$MesFin,$Fila[version]);
				echo "<tr>";
				if($CmbProd=='5')
					echo "<td rowspan='".($CantFilas*3)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				else
				   	echo "<td rowspan='".($CantFilas*2)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				$ConsultaGrupo="select distinct t3.cod_subclase,t3.nombre_subclase from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2";
				$ConsultaGrupo.=" on t1.cod_asignacion=t2.cod_asignacion inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase=t2.grupo where cod_clase='31042' and t2.grupo<>'' and t2.mostrar_ppc='1'"; 
				if($CmbProd!='-1')
					$ConsultaGrupo.=" and t2.cod_asignacion='".$CmbProd."'";
				$ConsultaGrupo.=" order by t3.cod_subclase";	
				//echo $ConsultaGrupo."<br>";
				$RespGrupo=mysql_query($ConsultaGrupo);$Cont=0;
				while($FilaGrupo=mysql_fetch_array($RespGrupo))
				{
					$Consulta="select distinct t1.cod_titulo,t1.cod_negocio,t2.nom_titulo from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_negocio=t2.cod_negocio and t1.cod_titulo=t2.cod_titulo ";
					$Consulta.="where t1.cod_asignacion='".$Fila[cod_asignacion]."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Fila[version]."' and t2.mostrar_ppc='1'";
					$Consulta.="and t1.cod_procedencia='".$Fila["cod_producto"]."' and t2.vigente='1' and t2.grupo='".$FilaGrupo["cod_subclase"]."' order by t2.grupo";
					//echo $Consulta;
					$RespTit=mysqli_query($link, $Consulta);$Cont=0;
					while($FilaTit=mysql_fetch_array($RespTit))
					{
					    if($Fila[cod_asignacion]!='5')
						{
							if($Cont>1)
							echo "<tr>";
							echo "<td rowspan='2' >".$FilaTit[nom_titulo]."</td>";
							echo "<td>Real</td>";$TotalDatosReal=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								ObtieneDatosSVP($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_negocio],$FilaTit[cod_titulo],$Ano,$i,$i,$Fila[version],&$ArrayTotReal,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";
								$Cont++;							
								$ArraySubTotalGrupoReal[$i][0]=$ArraySubTotalGrupoReal[$i][0]+$TotalTipoTit;
								$TotalDatosReal=$TotalDatosReal+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosReal,0,',','.')."</td>";						
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";$TotalDatosPpto=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								//OBTIENE DATOS PPC
								ObtieneDatosPPC($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_titulo],$Ano,$i,$i,$Fila[version],&$ArrayTotProg,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";								
								$Cont++;	
								$ArraySubTotalGrupoPpto[$i][0]=$ArraySubTotalGrupoPpto[$i][0]+$TotalTipoTit;	
								$TotalDatosPpto=$TotalDatosPpto+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosPpto,0,',','.')."</td>";						
							echo "</tr>";
						}
						else
						{
							if($Cont>1)
							echo "<tr>";
							echo "<td rowspan='3' >".$FilaTit[nom_titulo]."</td>";
							echo "<td>Real</td>";$TotalDatosReal=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								ObtieneDatosSVP($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_negocio],$FilaTit[cod_titulo],$Ano,$i,$i,$Fila[version],&$ArrayTotReal,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";
								$Cont++;							
								$ArraySubTotalGrupoReal[$i][0]=$ArraySubTotalGrupoReal[$i][0]+$TotalTipoTit;
								$TotalDatosReal=$TotalDatosReal+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosReal,0,',','.')."</td>";						
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";$TotalDatosPpto=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								//OBTIENE DATOS PPC
								ObtieneDatosPPC($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_titulo],$Ano,$i,$i,$Fila[version],&$ArrayTotProg,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";								
								$Cont++;	
								$ArraySubTotalGrupoPpto[$i][0]=$ArraySubTotalGrupoPpto[$i][0]+$TotalTipoTit;	
								$TotalDatosPpto=$TotalDatosPpto+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosPpto,0,',','.')."</td>";						
							echo "</tr>";
							echo "<tr>";
							echo "<td>Ventas</td>";$TotalDatosPpto=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
							    $Valor=ValorVentas($CmbProd,$Ano,$i,'12');
								echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";																
								$Cont++;	
								$TotalValorSVP=$TotalValorSVP+$Valor;
								$ArraySVP[$i][0]=$ArraySVP[$i][0]+$Valor;
							}
							echo "<td align='right'>".number_format($TotalValorSVP,0,',','.')."</td>";						
							echo "</tr>";
						}	
					}
					if($Cont>0)
					{
					    if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
						{
							echo "<tr>";
							echo "<td rowspan='3'>SUBTOTAL GRUPO</td>";
							echo "<td>Asig.</td>";
							$TotalGrupoAcum=0;		   
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalGrupo=$ArraySubTotalGrupoReal[$i][0];
								echo "<td align='right'>".number_format($TotalGrupo,0,',','.')."</td>";
								$ArraySubTotalGrupoReal[$i][0]=0;
								$TotalGrupoAcum=$TotalGrupoAcum+$TotalGrupo;
							}					
							echo "<td align='right'>".number_format($TotalGrupoAcum,0,',','.')."</td>";
							echo "</tr>";
							echo "<tr>";	
							echo "<td>Prog</td>";
							$TotalGrupoProgAcum=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$TotalGrupoProg=$ArraySubTotalGrupoPpto[$i][0];
								echo "<td align='right'>".number_format($TotalGrupoProg,0,',','.')."</td>";
								$TotalGrupoProgAcum=$TotalGrupoProgAcum+$TotalGrupoProg;
								$ArraySubTotalGrupoPpto[$i][0]=0;
							}	
							echo "<td align='right'>".number_format($TotalGrupoProgAcum,0,',','.')."</td>";
							echo "</tr>";
							echo "<tr>";	
							echo "<td>Ventas</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $ValorSubTotal=$ArraySVP[$i][0];
								echo "<td align='right'>".number_format($ValorSubTotal,0,',','.')."</td>";
								$TotalSVPSubTotalAcum=$TotalSVPSubTotalAcum+ValorSubTotal;
								$ArraySVP[$i][0]=0;
							}
							echo "<td align='right'>".number_format($TotalSVPSubTotalAcum,0,',','.')."</td>";
							echo "</tr>";
						}
						else
						{
							echo "<tr>";
							echo "<td rowspan='2'>SUBTOTAL GRUPO</td>";
							echo "<td>real</td>";
							$TotalGrupoAcum=0;		   
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalGrupo=$ArraySubTotalGrupoReal[$i][0];
								echo "<td align='right'>".number_format($TotalGrupo,0,',','.')."</td>";
								$ArraySubTotalGrupoReal[$i][0]=0;
								$TotalGrupoAcum=$TotalGrupoAcum+$TotalGrupo;
							}					
							echo "<td align='right'>".number_format($TotalGrupoAcum,0,',','.')."</td>";
							echo "</tr>";
							echo "<tr>";	
							echo "<td>Prog</td>";
							$TotalGrupoProgAcum=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$TotalGrupoProg=$ArraySubTotalGrupoPpto[$i][0];
								echo "<td align='right'>".number_format($TotalGrupoProg,0,',','.')."</td>";
								$TotalGrupoProgAcum=$TotalGrupoProgAcum+$TotalGrupoProg;
								$ArraySubTotalGrupoPpto[$i][0]=0;
							}	
							echo "<td align='right'>".number_format($TotalGrupoProgAcum,0,',','.')."</td>";
							echo "</tr>";
						}
					}		
				}	
				if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
				{
					echo "<tr>";
					echo "<td rowspan='3' colspan='2'>SUBTOTAL</td>";
					echo "<td>Asig.</td>";
					$TotalRealAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{				    
						$TotalReal=0;
						reset($ArrayTotReal);
						while(list($c,$v)=each($ArrayTotReal))
						{
							if($c==$Fila["cod_producto"])
								$TotalReal=$TotalReal+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
						$TotalRealAcum=$TotalRealAcum+$TotalReal;
					}
					echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
					echo "</tr>";
					echo "<tr>";	
					echo "<td>Prog</td>";
					$TotalProgAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$TotalProg=0;
						reset($ArrayTotProg);
						while(list($c,$v)=each($ArrayTotProg))
						{
							if($c==$Fila["cod_producto"])
								$TotalProg=$TotalProg+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
						$TotalProgAcum=$TotalProgAcum+$TotalProg;
					}
					echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
					echo "</tr>";
					echo "<tr>";	
					echo "<td>Ventas</td>";
					$TotalProgAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$ValorSubtotal=$ValorSubtotal+$TotalSVPSubTotalAcum;
						echo "<td align='right'>".number_format($ValorSubtotal,0,',','.')."</td>";
						$TotalProgAcumTotal=$TotalProgAcumTotal+$ValorSubtotal;
					}
					echo "<td align='right'>".number_format($TotalProgAcumTotal,0,',','.')."</td>";
					echo "</tr>";
				}
				else
				{
					echo "<tr>";
					echo "<td rowspan='2' colspan='2'>SUBTOTAL</td>";
					echo "<td>Real</td>";
					$TotalRealAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{				    
						$TotalReal=0;
						reset($ArrayTotReal);
						while(list($c,$v)=each($ArrayTotReal))
						{
							if($c==$Fila["cod_producto"])
								$TotalReal=$TotalReal+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
						$TotalRealAcum=$TotalRealAcum+$TotalReal;
					}
					echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
					echo "</tr>";
					echo "<tr>";	
					echo "<td>Prog</td>";
					$TotalProgAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$TotalProg=0;
						reset($ArrayTotProg);
						while(list($c,$v)=each($ArrayTotProg))
						{
							if($c==$Fila["cod_producto"])
								$TotalProg=$TotalProg+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
						$TotalProgAcum=$TotalProgAcum+$TotalProg;
					}
					echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
					echo "</tr>";
				}	
			}
			if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
			{
				echo "<tr>";
				echo "<td rowspan='3' colspan='2'>TOTALES</td>";
				echo "<td>Asig.</td>";
				$TotalRealAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalReal=0;
					reset($ArrayTotReal);
					while(list($c,$v)=each($ArrayTotReal))
					{
						$TotalReal=$TotalReal+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
					$TotalRealAcum=$TotalRealAcum+$TotalReal;
				}
				echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
				echo "</tr>";
				echo "<tr>";	
				echo "<td>Prog</td>";
				$TotalProgAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalProg=0;
					reset($ArrayTotProg);
					while(list($c,$v)=each($ArrayTotProg))
					{
						$TotalProg=$TotalProg+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
					$TotalProgAcum=$TotalProgAcum+$TotalProg;
				}
				echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
				echo "</tr>";
				echo "<tr>";	
				echo "<td>Ventas</td>";
				$TotalProgAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalTotalSVP=$TotalTotalSVP+$TotalProgAcumTotal ;
					echo "<td align='right'>".number_format($TotalTotalSVP,0,',','.')."</td>";
					$TotalProgAcum=$TotalProgAcum+$TotalTotalSVP;
				}
				echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr>";
				echo "<td rowspan='2' colspan='2'>TOTALES</td>";
				echo "<td>Real</td>";
				$TotalRealAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalReal=0;
					reset($ArrayTotReal);
					while(list($c,$v)=each($ArrayTotReal))
					{
						$TotalReal=$TotalReal+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
					$TotalRealAcum=$TotalRealAcum+$TotalReal;
				}
				echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
				echo "</tr>";
				echo "<tr>";	
				echo "<td>Prog</td>";
				$TotalProgAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalProg=0;
					reset($ArrayTotProg);
					while(list($c,$v)=each($ArrayTotProg))
					{
						$TotalProg=$TotalProg+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
					$TotalProgAcum=$TotalProgAcum+$TotalProg;
				}
				echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
				echo "</tr>";
			}	
		  }
		  if($CmbMostrar=='A')//ACUMULADO
		  {
			$Consulta="select t1.cod_producto,t1.nom_asignacion,t1.cod_asignacion,t2.version,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_ppc_detalle t2 on t1.cod_producto=t2.cod_procedencia ";
			$Consulta.="where t1.cod_asignacion='".$CmbProd."' and (t2.ano='".$Ano."' and t2.mes between '".$Mes."' and '".$MesFin."') and t2.version='".$CmbVersion."' and mostrar_ppc='1'";
			if($CmbAsig!='-1')
				$Consulta.=" and t1.cod_producto='".$CmbAsig."'";
			$Consulta.=" group by t1.cod_producto order by t1.orden";
			//echo $Consulta;
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$TotalProd=0;
				$CantFilas=ObtieneCantFilasTitulos($Fila[cod_asignacion],$Fila["cod_producto"],$Ano,$Mes,$MesFin,$Fila[version]);
				//echo $CantFilas."<br>";
				echo "<tr>";
				if($Fila[cod_asignacion]=='5')
					echo "<td rowspan='".($CantFilas*3)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				else
				   	echo "<td rowspan='".($CantFilas*2)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				$ConsultaGrupo="select distinct t3.cod_subclase,t3.nombre_subclase from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2";
				$ConsultaGrupo.=" on t1.cod_asignacion=t2.cod_asignacion inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase=t2.grupo where cod_clase='31042' and t2.grupo<>'' and t2.mostrar_ppc='1'"; 
				if($CmbProd!='-1')
					$ConsultaGrupo.=" and t2.cod_asignacion='".$CmbProd."'";
				$ConsultaGrupo.=" order by t3.cod_subclase";	
				//echo $ConsultaGrupo."<br>";
				$RespGrupo=mysql_query($ConsultaGrupo);$Cont=0;
				while($FilaGrupo=mysql_fetch_array($RespGrupo))
				{
					$Consulta="select distinct t1.cod_titulo,t1.cod_negocio,t2.nom_titulo from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_negocio=t2.cod_negocio and t1.cod_titulo=t2.cod_titulo and t2.vigente='1' and t2.grupo='".$FilaGrupo["cod_subclase"]."'";
					$Consulta.=" where t1.cod_asignacion='".$Fila[cod_asignacion]."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Fila[version]."' and t2.mostrar_ppc='1'";
					$Consulta.="and t1.cod_procedencia='".$Fila["cod_producto"]."'  order by t2.grupo";
					//echo $Consulta;
					$RespTit=mysqli_query($link, $Consulta);$Cont=0;
					while($FilaTit=mysql_fetch_array($RespTit))
					{
						$ValorReal=ObtieneDatosSVP($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_negocio],$FilaTit[cod_titulo],$Ano,$Mes,$MesFin,$Fila[version],&$ArrayTotReal,0);
						$ValorPPC=ObtieneDatosPPC($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_titulo],$Ano,$Mes,$MesFin,$Fila[version],&$ArrayTotProg,0);
						
						if($Fila[cod_asignacion]!='5')//CODIGO SUBPRODUCTO
						{
							if($Cont>1)		
								echo "<tr>";
							echo "<td rowspan='2'>".$FilaTit[nom_titulo]."&nbsp;</td>";
							echo "<td>Real</td>";						
							echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
							$TotalGrupo1=$TotalGrupo1+$ValorReal;
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";
							echo "<td align='right'>".number_format($ValorPPC,0,',','.')."</td>";
							$TotalGrupoProg2=$TotalGrupoProg2+$ValorPPC;
							echo "</tr>";
							$Cont++;
						}
						else
						{	
							if($Cont>1)
								echo "<tr>";
							echo "<td rowspan='3'>".$FilaTit[nom_titulo]."&nbsp;</td>";
							echo "<td>Asig.</td>";						
							echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
							$TotalGrupo1=$TotalGrupo1+$ValorReal;
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";
							//OBTIENE DATOS PPC
							echo "<td align='right'>".number_format($ValorPPC,0,',','.')."</td>";
							$TotalGrupoProg2=$TotalGrupoProg2+$ValorPPC;
							echo "</tr>";
							echo "<tr>";
							echo "<td>Ventas</td>";
							//OBTIENE ventas SVP
							echo "<td align='right'>".number_format(ValorVentas($Fila["cod_producto"],$Ano,$Mes,$MesFin),0,',','.')."</td>";
							$TotalGrupoSVP=$TotalGrupoSVP+ValorVentas($Fila["cod_producto"],$Ano,$Mes,$MesFin);
							echo "</tr>";
							$Cont++;
						}
					}
					if($Cont>0)
					{
					    if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
						{
							echo "<tr>";
							echo "<td rowspan='3'>SUBTOTAL GRUPO</td>";
							echo "<td>Asig.</td>";
							echo "<td align='right'>".number_format($TotalGrupo1,0,',','.')."</td>";
							$TotalGrupo1=0;
							echo "</tr>";
							echo "<tr>";	
							echo "<td>Prog</td>";
							echo "<td align='right'>".number_format($TotalGrupoProg2,0,',','.')."</td>";
							$TotalGrupoProg2=0;
							echo "</tr>";
							echo "<tr>";	
							echo "<td>Ventas</td>";
							echo "<td align='right'>".number_format($TotalGrupoSVP,0,',','.')."</td>";
							$TotalSubtotalSVP=$TotalSubtotalSVP+$TotalGrupoSVP;
							$TotalGrupoSVP=0;
							echo "</tr>";
						}
						else
						{
							echo "<tr>";
							echo "<td rowspan='2'>SUBTOTAL GRUPO</td>";
							echo "<td>Real</td>";
							echo "<td align='right'>".number_format($TotalGrupo1,0,',','.')."</td>";
							$TotalGrupo1=0;
							echo "</tr>";
							echo "<tr>";	
							echo "<td>Prog</td>";
							echo "<td align='right'>".number_format($TotalGrupoProg2,0,',','.')."</td>";
							$TotalGrupoProg2=0;
							echo "</tr>";
						}	
					}
				}	
				if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
				{
					echo "<tr>";
					echo "<td rowspan='3' colspan='2'>SUBTOTAL</td>";
					echo "<td>asig.</td>";
					reset($ArrayTotReal);$TotalReal=0;
					while(list($c,$v)=each($ArrayTotReal))
					{
						if($c==$Fila["cod_producto"])
							$TotalReal=$TotalReal+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
					echo "<tr>";	
					echo "<td>Prog</td>";
					reset($ArrayTotProg);$TotalProg=0;
					while(list($c,$v)=each($ArrayTotProg))
					{
						if($c==$Fila["cod_producto"])
							$TotalProg=$TotalProg+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
					echo "<tr>";	
					echo "<td>Ventas</td>";
					echo "<td align='right'>".number_format($TotalSubtotalSVP,0,',','.')."</td></tr>";
				}
				else
				{
					echo "<tr>";
					echo "<td rowspan='2' colspan='2'>SUBTOTAL</td>";
					echo "<td>Real</td>";
					reset($ArrayTotReal);$TotalReal=0;
					while(list($c,$v)=each($ArrayTotReal))
					{
						if($c==$Fila["cod_producto"])
							$TotalReal=$TotalReal+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
					echo "<tr>";	
					echo "<td>Prog</td>";
					reset($ArrayTotProg);$TotalProg=0;
					while(list($c,$v)=each($ArrayTotProg))
					{
						if($c==$Fila["cod_producto"])
							$TotalProg=$TotalProg+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
				}
			}
			if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
			{
				echo "<tr>";
				echo "<td rowspan='3' colspan='2'>TOTALES</td>";
				echo "<td>Asig.</td>";
				reset($ArrayTotReal);$TotalReal=0;
				while(list($c,$v)=each($ArrayTotReal))
				{
					$TotalReal=$TotalReal+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
				echo "<tr>";	
				echo "<td>Prog</td>";
				reset($ArrayTotProg);$TotalProg=0;
				while(list($c,$v)=each($ArrayTotProg))
				{
					$TotalProg=$TotalProg+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
				echo "<tr>";	
				echo "<td>Venta</td>";
				echo "<td align='right'>".number_format($TotalSubtotalSVP,0,',','.')."</td></tr>";
			}
			else
			{
				echo "<tr>";
				echo "<td rowspan='2' colspan='2'>TOTALES</td>";
				echo "<td>Real</td>";
				reset($ArrayTotReal);$TotalReal=0;
				while(list($c,$v)=each($ArrayTotReal))
				{
					$TotalReal=$TotalReal+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
				echo "<tr>";	
				echo "<td>Prog</td>";
				reset($ArrayTotProg);$TotalProg=0;
				while(list($c,$v)=each($ArrayTotProg))
				{
					$TotalProg=$TotalProg+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
			}	
		  }	
		}  	  
		  ?>
  </table>
</form>
<? 
    echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Asignaciones (s) Eliminado(s) Correctamente');";
	if($Mensaje!='1'&&$Cont==0&&$Buscar=='S')
		echo "alert('Informaci�n de Asignacion No Encontrada');";	
	echo "</script>";
?>	
</body>
</html>
<?
function NumOrdenesPorNegocio($CodAsig,$CodNeg,$Ano,$Mes,$MesFin,$Prod,$CmbVersion)
{
	$Consulta="select ifnull(count(*),0) as cantidad from pcip_svp_asignaciones_titulos t1 inner join pcip_ppc_detalle t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_negocio=t2.cod_negocio  and t1.cod_titulo=t2.cod_titulo ";
	$Consulta.=" where t1.vigente='S' and t1.cod_asignacion='".$CodAsig."' and t1.cod_negocio='".$CodNeg."' and t1.mostrar_ppc='1' and (t2.ano='".$Ano."' and t2.mes between '".$Mes."' and '".$MesFin."') and t2.version='".$CmbVersion."' ";
	if($Prod!='-1')
		$Consulta.="and t2.cod_procedencia='".$Prod."'";
	$Consulta.=" group by t1.cod_asignacion, t1.cod_negocio,t1.cod_titulo";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);$Cantidad=0;
	while($Fila=mysql_fetch_array($Resp))
	{	
		$Cantidad++;
	}
	return($Cantidad);	
}
function ObtieneDatosPPC($CodAsig,$CodProd,$CodTit,$Ano,$Mes,$MesFin,$Version,$ArrayTotProg,$TotalTipoTit)
{
	$Consulta="select sum(valor) as valor from pcip_ppc_detalle ";
	$Consulta.="where cod_asignacion='".$CodAsig."' and cod_procedencia='".$CodProd."' and cod_titulo='".$CodTit."' and (ano='".$Ano."' and mes between '".$Mes."' and '".$MesFin."') and version='".$Version."' ";
	//echo $Consulta."<br>";
	$Resp2=mysqli_query($link, $Consulta);$Cantidad=0;
	if($Fila2=mysql_fetch_array($Resp2))
	{
		$ArrayTotProg[$CodProd][$Mes]=$ArrayTotProg[$CodProd][$Mes]+$Fila2[valor];
		$TotalTipoTit=$TotalTipoTit+$Fila2[valor];

	return($Fila2[valor]);							
	}
	else
	{
		$Valor=0;
		return($Valor);		
	}
}
function ObtieneDatosSVP($CodAsig,$CodProd,$CodNeg,$CodTit,$Ano,$Mes,$MesFin,$Version,$ArrayTotReal,$TotalTipoTit)
{
		//OBTIENE DATOS SVP
		$Consulta="select t2.origen,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 ";
		$Consulta.="inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio ";
		$Consulta.="where t2.cod_asignacion='".$CodAsig."'  ";
		if($CodNeg!=99)
			$Consulta.=" and t2.cod_negocio='".$CodNeg."' and t2.cod_titulo='".$CodTit."' and t1.vigente='1'";
		$Consulta.=" and t2.cod_procedencia='".$CodProd."' and ano='".$Ano."' ";
		$Consulta.="order by t1.orden,t2.orden";
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);$Cantidad=0;
		while($Fila2=mysql_fetch_array($Resp2))
		{
			if($Fila2[origen]=='SVP')
			{
				//echo "entroooo SVP";
				$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes between '".$Mes."' and '".$MesFin."' ";
				if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
					$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
				if(!is_null($Fila2[cod_material]))
					$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
				if(!is_null($Fila2[consumo_interno]))
					$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
				if(!is_null($Fila2[vptm])&&$Fila2[vptm]!=0)
					$Consulta.=" and vptm='".$Fila2[vptm]."'";
				$Resp3=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				while($Fila3=mysql_fetch_array($Resp3))
				{
					$Cantidad=$Cantidad+$Fila3[VPcantidad];
				}
			}
			else//CDV
			{
				//echo"entroo CDV";
				$Consulta="select sum(kilos_finos) as kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$Mes."' group by mes";
				$Resp3=mysqli_query($link, $Consulta);
				//echo "CDV:   ".$Consulta."<br>";
				while($Fila3=mysql_fetch_array($Resp3))
				{
					$Cantidad=$Cantidad+$Fila3[kilos_finos];
				}
				
			}
		}
		if($Cantidad!=0)
		{
			$ArrayTotReal[$CodProd][$Mes]=$ArrayTotReal[$CodProd][$Mes]+$Cantidad;
			$TotalTipoTit=$TotalTipoTit+$Cantidad;

		return($Cantidad);	
		}
		else
		{
			$Valor=0;
			return($Valor);	
		}		
}
function ObtieneCantFilasTitulos($CodAsig,$CodProd,$Ano,$Mes,$MesFin,$Version)
{
	$Consulta="select ifnull(count(*),0) as cant from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_titulo=t2.cod_titulo";
	$Consulta.=" where t1.cod_asignacion='".$CodAsig."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Version."'";
	$Consulta.=" and t1.cod_procedencia='".$CodProd."'";
	$Consulta.=" and t2.grupo<>'' and t2.mostrar_ppc='1' group by  t1.cod_asignacion,t1.cod_procedencia,t1.ano,t1.cod_titulo";
	//echo $Consulta."<br>";
	$RespCant=mysqli_query($link, $Consulta);$Cant=0;
	while($FilaCant=mysql_fetch_array($RespCant))
		$Cant++;
		
	$Consulta1="select  t2.grupo from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2";
	$Consulta1.=" on t1.cod_asignacion=t2.cod_asignacion and t1.cod_titulo=t2.cod_titulo inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase=t2.grupo where cod_clase='31042' and t2.grupo<>''"; 
	$Consulta1.=" and t1.cod_asignacion='".$CodAsig."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Version."'";
	$Consulta1.=" and t1.cod_procedencia='".$CodProd."' and t2.mostrar_ppc='1'";
	$Consulta1.=" group by t1.cod_asignacion,t1.cod_procedencia,t1.ano,t2.grupo";	
	//echo $Consulta1."<br>";
	$RespCant1=mysql_query($Consulta1);
	while($FilaCant1=mysql_fetch_array($RespCant1))
		$Cant++;
	return($Cant);
}
?>