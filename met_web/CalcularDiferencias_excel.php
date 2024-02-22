<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

function Buscar(opt)
{	
	var f=document.form1;

	if(f.txtflujo.value=='')
	{
		alert ("Debe Ingresar Numero de Flujo");
		f.txtflujo.focus();
		return false;
	}
	if(isNaN(parseInt(f.txtflujo.value)))
	{
		alert ("N�mero de Flujo s�lo acepta el ingreso de n�meros");
		return false;
	}		
	switch (opt)
	{
		case "W":
		var VRadio='';
		if(f.radio1[0].checked==true)
		VRadio=1;
	else
		VRadio=2;
		f.action="CalcularDiferencias.php?buscarOPT=S&ValorRadio="+VRadio;

			f.submit();
			break;
		case "E":
			f.action="CalcularDiferencias_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}

function Rescatar()
{
	var f=document.form1;
	var Flujo ='';
	Flujo=f.productos.value.split('~');
 	//alert(Flujo[0]);
 	//alert(Flujo[1]);
	f.txtflujo.value=Flujo[0];
	f.textfield.value=f.productos.options[f.productos.selectedIndex].text;
}

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}
function BuscarProducto()
{	
	var f=document.form1;
	var VRadio='';
	
	if(f.radio1[0].checked==true)
		VRadio=1;
	else
		VRadio=2;
	f.action="CalcularDiferencias.php?buscarproductoOPT=S&ValorRadio="+VRadio;
	f.submit();
}

</script>

</head>
<form name="form1" method="post" action="">
<?php 
	include("conectar.php");
?>

<body>
<?
				$pesobase= array		("0","0","0","0","0","0","0","0","0","0","0","0");
				$pesofinal= array		("0","0","0","0","0","0","0","0","0","0","0","0");
				$pesodif= array			("0","0","0","0","0","0","0","0","0","0","0","0");
				$finocobrebase=array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finocobrefinal=array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finocobredif= array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoplatabase = array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoplatafinal = array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoplatadif = array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoorobase = array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoorofinal = array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoorodif = array		("0","0","0","0","0","0","0","0","0","0","0","0");
				$pesobasepmn= array		("0","0","0","0","0","0","0","0","0","0","0","0");
				$pesofinalpmn= array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$pesodifpmn= array		("0","0","0","0","0","0","0","0","0","0","0","0");
				$finocobrebasepmn= array("0","0","0","0","0","0","0","0","0","0","0","0");
				$finocobrefinalpmn=array("0","0","0","0","0","0","0","0","0","0","0","0");
				$finocobredifpmn= array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoplatabasepmn =array("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoplatafinalpmn=array("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoplatadifpmn = array("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoorobasepmn = array	("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoorofinalpmn = array("0","0","0","0","0","0","0","0","0","0","0","0");
				$finoorodifpmn = array	("0","0","0","0","0","0","0","0","0","0","0","0");
?>
<table width="770" border="1">
  <tr>
    <td><p><table width="503" border="1" align="center">
        <tr align="center">
          <td colspan="3"><strong>Porcentaje Rechazo Catodos</strong> </td>
        </tr>
        <tr>
          <td width="223" align="right">
            <div align="center"><strong>A&ntilde;o: </strong></div></td>
          <td colspan="2" align="center">
		  <? echo $ano; ?>
</td>
        </tr>
        <tr>
          <td align="right"><div align="center"><strong>N&uacute;mero de Flujo:
          <?php echo $txtflujo;?>
          </strong></div></td>
          <td width="157" align="center"><strong>Tipo Movimiento:</strong> <? echo $select2; ?>		  
          <td width="101" align="center"><? echo $productos; ?>
            <?php
				if($radio1[0]=='2')
				{								
					$sql1 = "SELECT DISTINCT NOM_PRODUCTO,N_FLUJO FROM enabalpmn ";
					$opconsulta="2";
				}
				else
				{		
					$sql1 = "SELECT DISTINCT NOM_PRODUCTO,N_FLUJO FROM enabal ";
					$opconsulta="1";
				}
				if($txtflujo!='')
					$sql1.= "where N_FLUJO='".$txtflujo."'";
				$resultados = mysql_query($sql1);
					 if($productos==$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO])
 				     {
					  	echo "<option value='".$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO]."'selected>".$columna[NOM_PRODUCTO]."</option>";
						$txtflujo=$columna[N_FLUJO];
					 }	
					 else
						echo "<option value='".$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO]."'>".$columna[NOM_PRODUCTO]."</option>";
		
		?>
          <input type="hidden" name="textfield" value="<?php echo $productos; ?>" ></td>
        </tr>
      </table>
    �</p>
    <table width="737" border="1" cellpadding="1" cellspacing="0">
	    	 <tr align="center">
	    	   <td colspan="16">DETALLE</td>
        </tr>
            <td width="38"><div align="right">A&ntilde;o</div></td>
            <td colspan="2">Item</td>
            <td width="34">Ene</td>
            <td width="32">Feb</td>
            <td width="37">Mar</td>
            <td width="39">Abr</td>
            <td width="36">May</td>
            <td width="31">Jun</td>
            <td width="30">Jul</td>
            <td width="31">Ago</td>
            <td width="33">Sep</td>
            <td width="33">Oct</td>
            <td width="40">Nov</td>
            <td width="41">Dic</td>
            <td width="52">Total</td>
          	</tr>
		<p><br>
<?
		//echo "<br>";
		$datos=explode("~",$productos);
		$producto1=$datos[1];
		$m=0;
		$j=0;
		$l=0;
if($buscarOPT=="S")
{	
switch ($opconsulta)
{
	case "1":
				$AnoIni=$ano;
				$bgColor="#FFFFFF";
				$fechainicio=$AnoIni."-"."01"."-01";
				$fechafinal=$AnoIni."-"."12"."-31";
			while ($fechainicio <= $fechafinal)
			{ 
				$forma=str_pad(substr($fechainicio,5,2),2,"0",STR_PAD_LEFT);
				$fechainicio1=$ano."-$forma"."-01";
				$fechafin=$ano."-$forma"."-31";
				//echo "FECHA INICIO"."\t".$fechainicio1."<br>";
				$sql = "SELECT Sum(P_SECO) AS  PESOSECO   from enabal_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql0= "SELECT Sum(P_SECO) AS  PESOSECO1  from enabal          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql2= "SELECT Sum(F_COBRE) AS FINOCOBRE  from enabal_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql3= "SELECT Sum(F_COBRE) AS FINOCOBRE1 from enabal          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql4= "SELECT Sum(F_PLATA) AS FINOPLATA  from enabal_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql5= "SELECT Sum(F_PLATA) AS FINOPLATA1 from enabal          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql6= "SELECT Sum(F_ORO) AS   FINOORO    from enabal_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql7= "SELECT Sum(F_ORO) AS   FINOORO1   from enabal          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				////////////****** ************///////////////////////////////
					$resul=mysql_query($sql);
					if($cod=mysql_fetch_array($resul))
						$pesobase[intval($forma)-1]=$cod[PESOSECO];
					if($pesobase[intval($forma)-1]=="NULL")
						 $pesobase[intval($forma)-1]=0;
						// echo $pesobase[intval($forma)-1]."<br>";
						 //*** PESO FINAL ENABAL/**////
					$resul=mysql_query($sql0);
					if($cod=mysql_fetch_array($resul))
						$pesofinal[intval($forma)-1]=$cod[PESOSECO1];
					if($pesofinal[intval($forma)-1]=="NULL")
						 $pesofinal[intval($forma)-1]=0;
						 $pesodif[intval($forma)-1]=abs($pesobase[intval($forma)-1] - $pesofinal[intval($forma)-1]);

					//******************************///////////////////////////////////////
					$resultado1=mysql_query($sql2);
				if($cod=mysql_fetch_array($resultado1))
					$finocobrebase[intval($forma)-1]=$cod[FINOCOBRE];
				if($finocobrebase[intval($forma)-1]=="NULL")
					$finocobrebase[intval($forma)-1]=0;
				$resul1=mysql_query($sql3);
				if($cod=mysql_fetch_array($resul1))
					$finocobrefinal[intval($forma)-1]=$cod[FINOCOBRE1];
				if($finocobrefinal[intval($forma)-1]=="NULL")
					$finocobrefinal[intval($forma)-1]=0;
				$finocobredif[intval($forma)-1]=abs($finocobrebase[intval($forma)-1] - $finocobrefinal[intval($forma)-1]);
				///echo $finocobredif[intval($forma)-1]."<br>";
				//******************************************
				$resultado2=mysql_query($sql4);
				if($cod=mysql_fetch_array($resultado2))
					$finoplatabase[intval($forma)-1]=$cod[FINOPLATA];
				if($finoplatabase[intval($forma)-1]=="NULL")
					$finoplatabase[intval($forma)-1]=0;
				$resul2=mysql_query($sql5);
				if($cod=mysql_fetch_array($resul2))
					$finoplatafinal[intval($forma)-1]=$cod[FINOPLATA1];
				if($finoplatafinal[intval($forma)-1]=="NULL")
					$finoplatafinal[intval($forma)-1]=0;
				$finoplatadif[intval($forma)-1]=abs($finoplatabase[intval($forma)-1] - $finoplatafinal[intval($forma)-1]);	
				//**********************************************
				$resultado=mysql_query($sql6);
				if($cod=mysql_fetch_array($resultado))
					$finoorobase[intval($forma)-1]=$cod[FINOORO];
				if($finoorobase[intval($forma)-1]=="NULL")
					$finoorobase[intval($forma)-1]=0;
				$resul=mysql_query($sql7);
				if($cod=mysql_fetch_array($resul))
					$finoorofinal[intval($forma)-1]=$cod[FINOORO1];
				if($finoorofinal[intval($forma)-1]=="NULL")
					$finoorofinal[intval($forma)-1]=0;
				$finoorodif[intval($forma)-1]=abs($finoorobase[intval($forma)-1] - $finoorofinal[intval($forma)-1]);
				$fechainicio=date('Y-m-d',mktime(0,0,0,substr($fechainicio1,5,2)+1,substr($fechainicio1,8,2),substr($fechainicio1,0,4)));
				$j=$j+1;
			}
			
			//-----------------------------------------------------//
			//-----------------------------------------------------//
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Peso Seco</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($pesobase))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total=$total+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total,'0',',','.')."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Peso Seco</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($pesofinal))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total1=$total1+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total1,'0',',','.')."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Peso Seco</td>";
			echo "<td width='72'>Diferencias</td>";
			$totales=0;
			while(list($c,$v)=each($pesodif))
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
								$totales=$total-$total1;

			}
			echo "<td align='right'>".abs($formato=number_format($totales,'0',',','.'))."</td>";
			reset($pesodif);
			reset($pesobase);
			reset($pesofinal);


			$total2=0;
			$total1=0;
			$totales=0;
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Cobre</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($finocobrebase))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total3=$total3+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total3,'0',',','.')."</td>";
			reset($finocobrebase);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Cobre</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($finocobrefinal))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total4=$total4+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total4,'0',',','.')."</td>";
			reset($finocobrefinal);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Cobre</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($finocobredif))
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
				$sumar=$total3-$total4;

			}
			echo "<td align='right'>".abs($formato=number_format($sumar,'0',',','.'))."</td>";
			reset($finocobredif);
			$sumar=0;
			$total3=0;
			$total4=0;
				echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Plata</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($finoplatabase))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total5=$total5+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total5,'0',',','.')."</td>";
			reset($finoplatabase);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Plata</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($finoplatafinal))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total6=$total6+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($total6,'0',',','.')."</td>";
			reset($finoplatafinal);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Plata</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($finoplatadif))
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
			reset($finoplatadif);
			$sumas=0;
			$total5=0;
			$total6=0;
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Oro</td>";
			echo "<td width='72'>Datos Bases</td>";
			while(list($c,$v)=each($finoorobase))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total7=$total7+$v;
				}	
				
			}
			echo "<td align='right'>".$formato=number_format($total7,'0',',','.')."</td>";
			reset($finoorobase);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Oro</td>";
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($finoorofinal))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$suma=$suma+$v;
				}	
			}
			echo "<td align='right'>".$formato=number_format($suma,'0',',','.')."</td>";
			reset($finoorofinal);
			echo "</tr>";
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Fino Oro</td>";
			echo "<td width='72'>Diferencias</td>";
			while(list($c,$v)=each($finoorodif))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$sumar=$total7-$suma;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
									$sumar=$total7-$suma;

			}
			echo "<td align='right'>".abs($formato=number_format($sumar,'0',',','.'))."</td>";
			reset($finoorodif);
			$sumar=0;
			$total7=0;
			$suma=0;
			echo "</tr>";
		break;
		//---------------------------------------------------------------//
		//---------------------------------------------------------------//
		case "2":
				$AnoIni=$ano;
				$bgColor="#FFFFFF";
				$fechainicio=$AnoIni."-"."01"."-01";
				$fechafinal=$AnoIni."-"."12"."-31";
			while ($fechainicio <= $fechafinal)
			{ 
				$forma=str_pad(substr($fechainicio,5,2),2,"0",STR_PAD_LEFT);
				$fechainicio1=$ano."-$forma"."-01";
				$fechafin=$ano."-$forma"."-31";
				//echo "FECHA INICIO"."\t".$fechainicio1."<br>";
				$sql = "SELECT Sum(P_SECO) AS  PESOSECO   from enabalpmn_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql0= "SELECT Sum(P_SECO) AS  PESOSECO1  from enabalpmn          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql2= "SELECT Sum(F_COBRE) AS FINOCOBRE  from enabalpmn_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql3= "SELECT Sum(F_COBRE) AS FINOCOBRE1 from enabalpmn          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql4= "SELECT Sum(F_PLATA) AS FINOPLATA  from enabalpmn_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql5= "SELECT Sum(F_PLATA) AS FINOPLATA1 from enabalpmn          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql6= "SELECT Sum(F_ORO) AS   FINOORO    from enabalpmn_base     where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				$sql7= "SELECT Sum(F_ORO) AS   FINOORO1   from enabalpmn          where (FECHA BETWEEN '$fechainicio1' AND '$fechafin') AND (NOM_PRODUCTO='$producto1') and (N_FLUJO='$txtflujo') and T_MOV='$select2' ";
				////////////****** ************///////////////////////////////
					$resul=mysql_query($sql);
					if($cod=mysql_fetch_array($resul))
						$pesobasepmn[intval($forma)-1]=$cod[PESOSECO];
					if($pesobasepmn[intval($forma)-1]=="NULL")
						 $pesobasepmn[intval($forma)-1]=0;
						// echo $pesobasepmn[intval($forma)-1]."<br>";
						 //*** PESO FINAL ENABALPMN/**////
					$resul=mysql_query($sql0);
					if($cod=mysql_fetch_array($resul))
						$pesofinalpmn[intval($forma)-1]=$cod[PESOSECO1];
					if($pesofinalpmn[intval($forma)-1]=="NULL")
						 $pesofinalpmn[intval($forma)-1]=0;
						 $pesodifpmn[intval($forma)-1]=abs($pesobasepmn[intval($forma)-1] - $pesofinalpmn[intval($forma)-1]);	

					//******************************///////////////////////////////////////
					$resultado1=mysql_query($sql2);
				if($cod=mysql_fetch_array($resultado1))
					$finocobrebasepmn[intval($forma)-1]=$cod[FINOCOBRE];
				if($finocobrebasepmn[intval($forma)-1]=="NULL")
					$finocobrebasepmn[intval($forma)-1]=0;
				$resul1=mysql_query($sql3);
				if($cod=mysql_fetch_array($resul1))
					$finocobrefinalpmn[intval($forma)-1]=$cod[FINOCOBRE1];
				if($finocobrefinalpmn[intval($forma)-1]=="NULL")
					$finocobrefinalpmn[intval($forma)-1]=0;
				$finocobredifpmn[intval($forma)-1]=abs($finocobrebasepmn[intval($forma)-1] - $finocobrefinalpmn[intval($forma)-1]);	
				///echo $finocobredifpmn[intval($forma)-1]."<br>";
				//******************************************
				$resultado2=mysql_query($sql4);
				if($cod=mysql_fetch_array($resultado2))
					$finoplatabasepmn[intval($forma)-1]=$cod[FINOPLATA];
				if($finoplatabasepmn[intval($forma)-1]=="NULL")
					$finoplatabasepmn[intval($forma)-1]=0;
				$resul2=mysql_query($sql5);
				if($cod=mysql_fetch_array($resul2))
					$finoplatafinalpmn[intval($forma)-1]=$cod[FINOPLATA1];
				if($finoplatafinalpmn[intval($forma)-1]=="NULL")
					$finoplatafinalpmn[intval($forma)-1]=0;
				$finoplatadifpmn[intval($forma)-1]=abs($finoplatabasepmn[intval($forma)-1] - $finoplatafinalpmn[intval($forma)-1]);	
				//**********************************************
				$resultado=mysql_query($sql6);
				if($cod=mysql_fetch_array($resultado))
					$finoorobasepmn[intval($forma)-1]=$cod[FINOORO];
				if($finoorobasepmn[intval($forma)-1]=="NULL")
					$finoorobasepmn[intval($forma)-1]=0;
				$resul=mysql_query($sql7);
				if($cod=mysql_fetch_array($resul))
					$finoorofinalpmn[intval($forma)-1]=$cod[FINOORO1];
				if($finoorofinalpmn[intval($forma)-1]=="NULL")
					$finoorofinalpmn[intval($forma)-1]=0;
				$finoorodifpmn[intval($forma)-1]=abs($finoorobasepmn[intval($forma)-1] - $finoorofinalpmn[intval($forma)-1]);
				$fechainicio=date('Y-m-d',mktime(0,0,0,substr($fechainicio1,5,2)+1,substr($fechainicio1,8,2),substr($fechainicio1,0,4)));
				$j=$j+1;
			}
			
			//-----------------------------------------------------//
			//-----------------------------------------------------//
			echo "<tr>";
			echo "<td>".$AnoIni."</td>";
			echo "<td width='57'>Peso Seco</td>";
			echo "<td width='72'>Datos Bases</td>";
			$total=0;
			while(list($c,$v)=each($pesobasepmn))
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
			echo "<td width='72'>Datos Finales</td>";
			while(list($c,$v)=each($pesofinalpmn))
			{
				if($v!="")
				{
					echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
					$total1=$total1+$v;
				}	
				if ($v==0)
				{
				$v=0;
				echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
				}
			}
			echo "<td align='right'>".$formato=number_format($total1,'0',',','.')."</td>";
			reset($pesofinalpmn);
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
			}
			}
?>		
  </table>
	<br>
	<br>
  </tr>
</table>

<?
	include("cerrarconexion.php");
?>

</form>
</body>
</html>