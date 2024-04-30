
<?php
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
	include("funciones_administrador.php");

	$dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$siguiente    = isset($_REQUEST["siguiente"])?$_REQUEST["siguiente"]:"";
	$anterior     = isset($_REQUEST["anterior"])?$_REQUEST["anterior"]:"";
	$mostrar     = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";

	$Sig    = isset($_REQUEST["Sig"])?$_REQUEST["Sig"]:"";
	$Ant    = isset($_REQUEST["Ant"])?$_REQUEST["Ant"]:"";

	$fecha=$ano1.'-'.$mes1.'-'.$dia1;
	if ($siguiente=='S')
      {
       $fecha=aumentar_dias($fecha,1);
	   $mes1=substr($fecha,5,2);
	   $ano1=substr($fecha,0,4);
	   $dia1=substr($fecha,8,2);
	  }
    if ($anterior=='S')
     {
      $fecha=restar_dias($fecha,1);
	  $mes1=substr($fecha,5,2);
	  $ano1=substr($fecha,0,4);
	  $dia1=substr($fecha,8,2);
	 }
   
	
?>




<html>
<head>
<script language="JavaScript">
function Buscar()
{
	var  f=document.form1;

	f.action='turno_b.php?mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarant()
{
	var  f=document.form1;

	f.action='turno_b.php?mostrar=S&anterior=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarsig()
{
	var  f=document.form1;

	f.action='turno_b.php?mostrar=S&siguiente=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
function Excel()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	document.location = "../ref_web/ref_web_xls.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}
function Tabla1()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	document.location = "../ref_web/tabla1.php?fecha="+fecha;
}
function Tabla2()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	document.location = "../ref_web/tabla2.php?fecha="+fecha;
}
function Tabla3()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	document.location = "../ref_web/tabla3.php?fecha="+fecha;
}
function Tabla4()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;	
	document.location = "../ref_web/tabla4.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}
function Tabla5()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	document.location = "../ref_web/tabla5.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}

function Tabla6()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	document.location = "../ref_web/Tabla6.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}


function Grafico()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/ejemplo_grafico.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");
}
function Grafico2()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico2.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");
}
function Grafico3()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico3.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");

}
function Imprimir()
{
	window.print();
}
function detalle(fecha,grupo,turno)
{
	var Frm=document.form1;
	window.open("detalle_rechazos.php?fecha="+ fecha+"&grupo="+grupo+"&turno="+turno,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
}
function detalle_produccion(fecha,grupo)
{
	var Frm=document.form1;
	window.open("ref_detalle_produccion_cubas.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}


</script>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<title>Sistema Informacion Refineria Electrolitica Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
<?php include("../principal/encabezado.php");?>

 <table width="772" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 <tr>
 <td width="760" align="center" valign="middle">
          <table width="750" border="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="168"><input name="buscar2" type="button" value="&lt;&lt; Anterior" onClick="Buscarant('<?php echo $fecha;?>')" > 
            </td>
            <td width="95"> <strong>Informe del: </strong></td>
            <td width="322"> <select name="dia1" size="1" >
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{   
					    if (($mostrar == "S") && ($i == $dia1))
						   {  if (($mostrar == "S") && ($Sig == "S"))
						         { 
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
								   $i=$i+1;
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
							     }
							  else if  (($mostrar == "S") && ($Ant == "S"))
							          {
									   $i=$i-1;
									   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
									   $i=$i+1;
									   
									  }
								 
								 
							       else echo '<option selected value="'.$i.'">'.$i.'</option>';
					       }  
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
							
					}
				?>
              </select> <select name="mes1" size="1" id="mes1">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
              </select> <select name="ano1" size="1" id="select4">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> &nbsp;&nbsp; <input name="buscar" type="button" value="buscar" onClick="Buscar()" > 
            </td>
            <td width="128"> 
              <input name="buscar22" type="button" value="Siguiente &gt;&gt;" onClick="Buscarsig('<?php echo $fecha;?>')" ></td>
          </tr>
        </table>
<TABLE cellSpacing=0 cellPadding=0 width="750" border=0>
  <TBODY>
    <TR vAlign=bottom> 
      
      <TD>
          <TBODY>
            <TR> 
             <TD width="52"   class=tabsoff      align=middle><IMG height=40 alt=""  src="archivos/tab-front_off.gif" width=52 border=0></TD>
              <?php echo '<TD width="175"  class=tabsoffline align=middle><B><A class=tabstext href="turno_a.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.'">Produccion</A></B></TD>'; ?>
              <TD width="22"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tab-mid_on1.gif" width=22 border=0></TD>
              <TD width="113"  class=tabsonline align=middle><B class=tabstext>Leyes</B></TD>
             
              <TD width="68"   class=tabsline 	 align=middle><SPAN class=dMSNME_1></SPAN></TD>
			   <TD width="22"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
               <?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.' "><B>Informe 
                   Completo </B></A></TD>'; ?>
              
			    <TD width="22"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
			  <?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_graficos_inf_diario.php?ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&fecha='.$fecha.'"><B>Graficos</B></A></TD>'; ?>	
			   <TD width="10"   class=tabsoff     align=middle> <IMG height=40 alt="" src="archivos/tab-end_on.gif" width=10 border=0></TD>
               <?php echo '<TD width="600%" class=tabsline    align=center><B><A style="COLOR: #ffffff" href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.'" target=_top><SPAN style="COLOR: #ffffcc"><font size="4">
                  </font></SPAN></A></B></TD>'; ?>
            </TR>
          </TBODY>
  </TBODY>

	             <table width="87%" border="1">
                <tr align="center"  class="ColorTabla01"> 
                  <td colspan="22"><strong>4.-CALIDAD FISICA Y QUIMICA CATODOS 
                    COMERCIALES </strong></td>
                </tr>
                <tr> 
                  <td width="90" align="center"><strong>GRUPO</strong></td>
                  <td width="48" align="center"><p><strong>Ag</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Au</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="58" align="center"><p><strong>As</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Sb</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Zn</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>S</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Bi</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Sn</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Fe</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Ni</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Pb</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Se</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Te</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>O</strong></p>
                    <p><strong>ppm</strong></p></td>
                 
                </tr>
	<?php 
		/*if ($Sig=='S')
	  	{
			$dia1=strval(intval($dia1+1));
	     	if ($dia1=='31')
	        { 
				$mes1=strval(intval($mes+1));
		       	$dia1='1';
			} 
	     	if  ($mes=='12')
	        { 
				$ano1=strval(intval($ano1+1));
		       	$mes1='1';
			   	$dia1='1';
			}      
	   	}
    	if ($Ant=='S')
	   	{
			$dia1=strval(intval($dia1-1));
			} 
			if (strlen($dia1) == 1)
			{
				$dia1 = '0'.$dia1;
		}
		if (strlen($mes1) ==1) 
  		{
			$mes1 = '0'.$mes1;
		}
		$fecha=$ano1."-".$mes1."-".$dia1;
		*/
		
		//****************INICIO ****************** 
		//REMPLAZADO POR LINEAS COMENTADAS SUPERIORES DVS 26-06-2014  LACC
		if ($Sig=='S') 
		{ 
			$fecha=strtotime("+ 1 day",$ano1."-".$mes1."-".$dia1);      
		}	
		if ($Ant=='S')
		{
			$fecha=strtotime("- 1 day",$ano1."-".$mes1."-".$dia1); 
		}
		//***************FIN**************  //
		
		$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
		$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
		$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
		$Respuesta = mysqli_query($link, $Consulta);
		$total_prod=0;
		$total_rec=0;
		$total_rech=0;
		$total_cuba=0;
		$cont=0;
		$i=0;
		$grupos=array(); //WSO
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont=$cont+1;
			$grupos[$i]=$Fila["cod_grupo"];
			$i=$i+1;
		}
		$total = 0;
		$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	    $Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
		$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
					//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
		    echo "<td align='center'>".$Fila["cod_grupo"]."&nbsp</td>\n";
			if (($Fila["cod_grupo"]=='01') or ($Fila["cod_grupo"]=='02') or ($Fila["cod_grupo"]=='03') or ($Fila["cod_grupo"]=='04') or ($Fila["cod_grupo"]=='05') or ($Fila["cod_grupo"]=='06') or ($Fila["cod_grupo"]=='07') or ($Fila["cod_grupo"]=='08') or($Fila["cod_grupo"]=='09'))
			{
				$grupo_aux=substr($Fila["cod_grupo"],1,1);
				$Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and (id_muestra='".$Fila["cod_grupo"]."' or id_muestra='$grupo_aux') and cod_producto='18' and cod_subproducto='1' and cod_analisis='1' and cod_tipo_muestra='3'";
			}
			else
			{
				$Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='".$Fila["cod_grupo"]."' and cod_producto='18' and cod_subproducto='1' and cod_analisis='1' and cod_tipo_muestra='3'";} 
				$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
				$Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
				$fecha2 = isset($Fila_fecha["fecha2"])?$Fila_fecha["fecha2"]:"";
				if (($Fila["cod_grupo"]=='01') or ($Fila["cod_grupo"]=='02') or ($Fila["cod_grupo"]=='03') or ($Fila["cod_grupo"]=='04') or ($Fila["cod_grupo"]=='05') or ($Fila["cod_grupo"]=='06') or ($Fila["cod_grupo"]=='07') or ($Fila["cod_grupo"]=='08') or($Fila["cod_grupo"]=='09'))
				{
    				$Consulta_electrolitos="select ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where (t1.id_muestra='".$Fila["cod_grupo"]."' or t1.id_muestra='$grupo_aux') and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$fecha2."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
	 			}
				else
				{
					$Consulta_electrolitos="select  ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='".$Fila["cod_grupo"]."'  and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$fecha2."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
				}	
				$Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
				while ($Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos))
				{  
					if ($Fila_electrolitos["valor"] < 0)
					{
						$total=number_format($Fila_electrolitos["valor"],"2","","");
						if ($Fila_electrolitos["signo"] !='=')
                        {
							echo "<td align='center'>".$Fila_electrolitos["signo"]."$total&nbsp</td>\n";
							$poly =($Fila_electrolitos["signo"].$total);
						}
						else 
						{
							echo "<td align='center'>$total&nbsp</td>\n";
							$poly =($Fila_electrolitos["signo"].$total);
						} 
					}
					else
					{
						$total=number_format($Fila_electrolitos["valor"],"2","","");
						echo "<td align='center'>&nbsp;".$Fila_electrolitos["signo"]."$total</td>";
						$poly =($Fila_electrolitos["signo"].$total);
					}
				}
				//echo "grupo:".$Fila["cod_grupo"];

				if ($total ==0)
				{
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
				
				}
			
			$total = 0;		 
		echo "</tr>\n";
		}
	?>
    </table>
    <p>
        <input type="button" name="btnexcel359" value="Excel Tabla 4" style="width:80" onClick="Tabla4()" title="Excel de Renovacion Anodos Hojas Madres">
     </p>
     <p>&nbsp;</p>
	 
		<table width="87%" border="1" cellpadding="2">
        	<tr align="center"  class="ColorTabla01"> 
        		<td colspan="18"><strong>5.-RENOVACION ELECTRODOS</strong></td>
       		 </tr>
             <tr> 
                 <td width="12%" rowspan="2" align="center"><strong>CIRCUITO</strong></td>
                 <td width="9%" rowspan="2" align="center"><strong>GRUPO</strong></td>
                 <td colspan="2" align="center"><strong>TIPO DE ANODOS</strong></td>
                 <td colspan="8" align="center">COMPOSICION ANODO NUEVO (PPM)</td>
             </tr>
             <tr> 
                  <td width="8%" height="27" align="center"><strong>SEMI</strong></td>
                  <td width="8%" align="center"><strong>NUEVO</strong></td>
                  <td width="8%" align="center"><p><strong>As</strong></p>
                   <p><strong>&lt;1500</strong></p></td>
                  <td width="10%" align="center"><p><strong>Sb</strong></p>
                   <p><strong>&lt;500</strong></p></td>
                  <td width="10%" align="center"><p><strong>Bi</strong></p>
                    <p><strong>&lt;15</strong></p></td>
				   <td width="5%" align="center"><p><strong>Fe</strong></p>
                    <p><strong>&lt;30</strong></p></td>
					<td width="6%" align="center"><p><strong>Ni</strong></p>
                    <p><strong>&lt;150</strong></p></td>
				  	<td width="9%" align="center"><p><strong>Se</strong></p>
                    <p><strong>&lt;300</strong></p></td>
                  	<td width="7%" align="center"><p><strong>Te</strong></p>
                    <p><strong>&lt;50</strong></p></td>
                  	<td width="8%" align="center"><p><strong>O</strong></p>
                    <p><strong>&lt;2000</strong></p></td>
            </tr>
  <?php 
		if ($mostrar == "S")
		{
			$limites=array(1500,500,15,30,150,300,50,2000);
		
			if(count($grupos)>0)
			{	
			reset ($grupos);
			foreach($grupos as $a => $b)
			{			 	
				$grupo= intval($b);
				$consulta2="select distinct cod_circuito from ref_web.grupo_electrolitico2 where cod_grupo='".$b."'";
				$Respuesta3 = mysqli_query($link, $consulta2);
				$Fila3 = mysqli_fetch_array($Respuesta3);
			echo "<tr>";
				echo "<td align='center'>".$Fila3["cod_circuito"]."&nbsp</td>\n";  
				echo "<td align='center'>$b&nbsp</td>\n";
				$arr_meses=array('Enero','Febrero_nor','Marzo','Abril','Mayo','Junio','Julio','Agosto','septiembre','Octubre','Noviembre','Diciembre');
				$arr_dias=array(31,28,31,30,31,30,31,31,30,31,30,31); 
				$ano_aux=intval($ano1);
				$mes_aux=intval($mes1);
				$calculo=$ano_aux/4;
				$calculo2=number_format($calculo,"0","","");
				$resto=$calculo2-$calculo;
				if ($resto==0)
				{
					$bisiesto='S';
					$mes_dia=28;
				}
				else
				{
					$bisiesto='N';}
					$dia_aux=intval($dia1);
					if ($dia_aux < 9)
					{
						$restantes= 8-$dia_aux;
						if ($mes_aux==1)
						{
							$mes_aux=strval(12);
							$ano_aux=strval($ano_aux-1);
							$dia_aux=$arr_dias[(intval($mes_aux))-1];
							$dia_aux=strval($dia_aux-$restantes);
						}
						else if (($mes_aux==3) and ($bisiesto=='N'))
						{
							$mes_aux=strval(2);
							$dia_aux=$arr_dias[intval($mes_aux)-1];
							$dia_aux=strval($dia_aux-$restantes);
						}
						else if (($mes_aux==3) and ($bisiesto=='S'))
						{
							$mes_aux=strval(2);
							$dia_aux=strval($mes_dia-$restantes);
					} 	  
					else
					{
						$mes_aux=strval(intval($mes_aux)-1);	
						$dia_aux=$arr_dias[intval($mes_aux)-1];
						$dia_aux=strval($dia_aux-$restantes);
					}
				}
				else
				{
					$dia_aux=strval($dia_aux-8);
					$mes_aux=strval($mes_aux);
					$ano_aux=strval($ano_aux);
				}		
				if (strlen($dia_aux)==1)
				{
					$dia_aux='0'.$dia_aux;
				}
				if (strlen($mes_aux)==1)
				{
					$mes_aux='0'.$mes_aux;
				}	
							
				$fecha_ant=$ano_aux."-".$mes_aux."-".$dia_aux;
				$cons_subp2="select distinct t1.cod_subproducto as producto from sea_web.movimientos as t1 ";
				$cons_subp2=$cons_subp2."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha_ant."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') group by t1.hornada";
				$Resp_subp2 = mysqli_query($link, $cons_subp2);
				$Fila_subp2 = mysqli_fetch_array($Resp_subp2);
				$producto=isset($Fila_subp2["producto"])?$Fila_subp2["producto"]:"";
				if ($producto==1)
				{
					echo "<td align='center'>HVL&nbsp</td>\n";
				}
				else if ($producto==4)
				{
					echo "<td align='center'>Ventana&nbsp</td>\n";
				}
				else if ($producto==2)
				{
					echo "<td align='center'>Teniente&nbsp</td>\n";
				}
				else if ($producto==3)
				{
					echo "<td align='center'>Disputada&nbsp</td>\n";
				}
			else
			{
				echo "<td align='center'>&nbsp</td>\n";
			}
			$cons_subp="select distinct t1.cod_subproducto as producto from sea_web.movimientos as t1 ";
			$cons_subp=$cons_subp."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') group by t1.hornada";
			$Resp_subp = mysqli_query($link, $cons_subp);
			$Fila_subp = mysqli_fetch_array($Resp_subp);
			$producto=isset($Fila_subp["producto"])?$Fila_subp["producto"]:"";
			if ($producto==1)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo HVL."</td>\n";
			}
			else if ($producto==4)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Ventana."</td>\n";}
			else if ($producto==2)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Teniente."</td>\n";}
			else if ($producto==3)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Disputada."</td>\n";
		}
		else
		{
			echo "<td align='center'>&nbsp</td>\n";
		}
			$i = 0;
			$a=array("08","09","27","31","36","40","44","48");
					
			
				$consulta="select sum(t1.peso) as peso_cargado from sea_web.movimientos as t1 ";
				$consulta=$consulta."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08')  ";
				$Respuesta = mysqli_query($link, $consulta);
				$Fila = mysqli_fetch_array($Respuesta);
				$l=0;
				
		for ($i = 0;$i<8;$i++)
		{
			$codley=$a[$i];
				//echo "peso cargado".$Fila["peso_cargado"];
			$consulta2="select t1.peso as peso_cargado,t2.cod_leyes,t2.valor as ley,t1.cod_subproducto as subproducto ";
			$consulta2.=", sum(t1.peso * t2.valor / '".$Fila["peso_cargado"]."') as calculo ";
			$consulta2.="from sea_web.movimientos as t1  ";
			$consulta2.="inner join sea_web.leyes_por_hornada as t2 "; 
			$consulta2.="on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto  ";
			$consulta2.="and t1.cod_subproducto=t2.cod_subproducto  ";
			$consulta2.="where t1.tipo_movimiento='2' and t1.campo2=$grupo and  ";
			$consulta2.="t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') ";
			//$consulta2.="and t2.cod_leyes in ('08','09','27','44','48','40','31','36') group by t2.cod_leyes ";
			$consulta2.="and t2.cod_leyes = '".$codley."'  group by t2.cod_leyes ";

			$consulta2.="order by t2.cod_leyes ";
			$Respuesta2 = mysqli_query($link, $consulta2);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			$total_total_ley=0;
			
			//while ($Fila2 = mysqli_fetch_array($Respuesta2))
			$cod_leyes=isset($Fila2["cod_leyes"])?$Fila2["cod_leyes"]:"";
				if ($cod_leyes== "")
				{
					echo "<td align='center'>&nbsp</td>\n";
				}
				else
				{
						
					if ($Fila2["calculo"] >= $limites[$l])
					{
						echo "<td align='center'><font color='red'><strong> ".number_format($Fila2["calculo"],"",",","")."&nbsp</strong></fornt></td>\n";
					}	 
					else
					{				
						echo "<td align='center'>".number_format($Fila2["calculo"],"",",","")."&nbsp</td>\n";
						
					}
				$l=$l+1;	
				}	 	
			}
			echo "</tr>\n";
			}
			}
			else
			{
				?>
				  <tr> 
                  <td width="8%"  colspan="12">Sin grupo Electrol&iacute;tico</td>
                 
            </tr>
				<?php
				
			}
		
		}	
	?>
	</table>
    <p>
		<input type="button" name="btnexcel3592" value="Excel Tabla 5" style="width:80" onClick="Tabla5()" title="Excel de Renovacion de Electrodos">
	</p>
	<table width="87%" height="12" border="1" cellpadding="2">
	<tr align="center"  class="ColorTabla01"> 
                  <td colspan="22"><strong>6.- ELECTROLITO</strong></td>
                </tr>
                <tr> 
                  <td width="40" align="center"><strong>CIRCUITO</strong></td>
                  <td width="40" height="63" align="center"><p><strong>Cu</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>H2SO4</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>As</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Sb</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Ca</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Fe</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" height="3" align="center"><p><strong>Mg</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Ni</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Zn</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Bi</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Pb</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Cl</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Se</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="19" align="center"><p><strong>Te</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="19" align="center"><p><strong>SS</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                </tr>
                <?php  
					if ($mostrar == "S")
					{
       					$cod_leyes=array('02','22','08','09','56','31','60','36','10','27','39','11','40','44','72');
						$circuitos=array('1','2','3','4','5','6','DP','DT','RETORNO');
						foreach($circuitos as $a => $b)
							{
							       $Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                                   $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							       $Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
							       $Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								   //echo $Consulta_fecha;
				    		  echo "<td align='center'>$b&nbsp</td>\n";
							  reset($cod_leyes); 
							  foreach($cod_leyes as $c => $v)
								 {
    							    $Consulta_electrolitos="select  t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
									$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
									$Consulta_electrolitos=$Consulta_electrolitos."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."' and t2.cod_leyes='$v' and t2.candado='1'";
									$Consulta_electrolitos;
								    $Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
									$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
									$valor= isset($Fila_electrolitos["valor"])?$Fila_electrolitos["valor"]:0;
									if ($valor <> 0)
									    {$total=number_format($Fila_electrolitos["valor"],"2","","");
										 if (($Fila_electrolitos["cod_unidad"]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
										     {echo "<td align='center'>$total gr/lt&nbsp</td>\n";  }  
										 else { echo "<td align='center'>$total&nbsp</td>\n";}
										 }
									else{echo "<td align='center'>&nbsp</td>\n";}
								}
							    echo "</tr>\n";
							 }
/****************************************************************************************************************************************/   						 
						 $HM=array('HM','H.M.','1HM','1-HM','H-M','HM.','-1HM');
						 reset($cod_leyes);
						 reset($HM);
						 foreach($HM as $a => $b)
						 	{ 
							   //$Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                               //$Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							   //$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
							   //$Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								$Consulta_hm="select  t2.id_muestra from cal_web.solicitud_analisis as t1 ";
								$Consulta_hm=$Consulta_hm."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_hm=$Consulta_hm."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."'";
								//echo $Consulta_hm;
								$Respuesta_hm = mysqli_query($link, $Consulta_hm);
								$Fila_hm = mysqli_fetch_array($Respuesta_hm);
								$id_muestra = isset($Fila_hm["id_muestra"])?$Fila_hm["id_muestra"]:0;
								if ($id_muestra==$b)
									{
										$idmuestra=$Fila_hm["id_muestra"];
										echo "<td align='center'>".$Fila_hm["id_muestra"]."&nbsp</td>\n";
										reset($cod_leyes);	
											 foreach($cod_leyes as $c => $v)
							   				{
								 				$Consulta_electrolitos="select  t1.valor as valor,t1.candado,t1.cod_unidad,t1.cod_leyes from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t2.fecha_muestra,10)='".$fecha."' and t1.cod_leyes='$v' and t1.candado='1'";
												$Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
												$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
												$valor = isset($Fila_electrolitos["valor"])?$Fila_electrolitos["valor"]:0;
												if ($valor <> 0)
									    			{$total=number_format($Fila_electrolitos["valor"],"2","","");
										 			 if (($Fila_electrolitos["cod_unidad"]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
										                {echo "<td align='center'>$total gr/lt&nbsp</td>\n";  }  
										             else { echo "<td align='center'>$total&nbsp</td>\n";}
										            }
												else{echo "<td align='center'>&nbsp</td>\n";}
											}
										echo "</tr>\n";
									}	
							}
							
						 							
/*******************************************************************************************************************************************************/							
						 $e100=array('E-100','E100','TK-100');
						 reset($e100);
						 reset($cod_leyes);
						 foreach($e100 as $a => $b)
						 	{
								$Consulta_e="select  t2.id_muestra from cal_web.solicitud_analisis as t1 ";
								$Consulta_e=$Consulta_e."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_e=$Consulta_e."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."'";
								$Respuesta_e = mysqli_query($link, $Consulta_e);
								$Fila_e = mysqli_fetch_array($Respuesta_e);
								$id_muestra = isset($Fila_e["id_muestra"])?$Fila_e["id_muestra"]:0;
								if ($id_muestra<>"")
									{
										$idmuestra=$id_muestra;
										echo "<td align='center'>".$id_muestra."&nbsp</td>\n";
    									reset($cod_leyes);	
										  foreach($cod_leyes as $c => $v)
							   				{
								 				$Consulta_v="select  t1.valor as valor,t1.candado from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_v=$Consulta_v."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_v=$Consulta_v."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t2.fecha_muestra,10)='".$fecha."' and t1.cod_leyes='$v' and t1.candado='1'";
												$Respuesta_v = mysqli_query($link, $Consulta_v);
												$Fila_v = mysqli_fetch_array($Respuesta_v);
												$valor = isset($Fila_v["valor"])?$Fila_v["valor"]:0;
												if ($valor <> 0)
									    			{$total=number_format($valor,"2","","");
										 		 	 echo "<td align='center'>$total&nbsp</td>\n";}
												else{echo "<td align='center'>&nbsp</td>\n";}
											}
										echo "</tr>\n";
									}	
							 }
						}
	?>
              </table>
              <p>
                <input type="button" name="btnexcel35922" value="Excel Tabla 6" style="width:80" onClick="Tabla6()" title="Excel de Tabla Electrolitos">
              </p>
              <p> 
			  <?php
               // <input type="button" name="btnexcel3" value="Excel Informe Completo" style="width:170" onClick="Excel()" title="Ejecutar Planilla Excel con datos de informes">?>
				<input type="button" name="btnimprimir" value="Imprimir" style="width:70" onClick="Imprimir()" title="Imprime informe diario">
                <input type="button" name="btnsalir" value="salir" style="width:70" onClick="Salir()">
              </p>
              <p>&nbsp; </p></td>
  </tr>
</table>
</table>
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
