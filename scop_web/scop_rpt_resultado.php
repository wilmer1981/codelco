<?
    include("../principal/conectar_scop_web.php");
    include("funciones/scop_funciones.php");

if(!isset($Ano))
	$Ano=date("Y");
?>
<html>
<head>
<title>Consulta Resultado</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<script language="javascript" src="../scop_web/funciones/scop_funciones.js"></script>
<script language="javascript">
var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			var DivChecked='';
			for(i=0;i<=5;i++)
			{
				if(f.Division[i].checked==true)
					DivChecked=DivChecked+f.Division[i].value+"~";
			}
			if(DivChecked!='')
			{
				DivChecked=DivChecked.substr(0,DivChecked.length-1);			
				f.action="scop_rpt_resultado.php?Buscar=S&DivChecked="+DivChecked;
				f.submit();
			}
			else
			{
				alert("Debe seleccionar Division(es)")
			}
		break;
		case "I"://IMPRIMIR
			window.print();
		break;			
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=33";
		break;
	}	
}
function Excel()
{
	var f=document.FrmPrincipal;
	var DivChecked='';
	for(i=0;i<=5;i++)
	{
		if(f.Division[i].checked==true)
			DivChecked=DivChecked+f.Division[i].value+"~";
	}
	if(DivChecked!='')
	{
		DivChecked=DivChecked.substr(0,DivChecked.length-1);			
		URL='scop_rpt_resultado_excel.php?&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&DivChecked='+DivChecked;
		window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
	}
	else
		alert("No Hay Divisiones Seleccionadas")
}
function Detalle(Datos)
{
	var f=document.FrmPrincipal;
	var Datos2='';
	Datos2=Datos.split("~")
	URL = "scop_proceso_cobertura_imputacion_cc_detalle.php?Ano="+Datos2[0]+"&Mes="+Datos2[1];
	opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1200,height=400,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
}

</script>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'rpt_resultado.png')
 ?>
   <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="../scop_web/archivos/images/interior/form_arriba.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq2em.png" width="15" height="15" /></td>
      </tr>
    <tr>
      <td width="15" background="../scop_web/archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				<td width="19%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	            <td align="right" class='formulario2' >
				<a href="JavaScript:Proceso('C')"><img src="archivos/buscar.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
				<a href="JavaScript:Excel('')"><img src="archivos/excel.png"   alt="Excel"  border="0" align="absmiddle" /></a>
				<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
				<a href="JavaScript:Proceso('E')"></a>
				<a href="JavaScript:Proceso('S')"><img src="archivos/salir.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
		  </tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>A&ntilde;o</td>
    	<td colspan="3" class="formulario2" ><select name="Ano" id="Ano">
          <option value="-1" class="NoSelec">Seleccionar</option>
          <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>
        </select>
    	</tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>Mes</td>
    	<td colspan="3" class="formulario2" ><select name="Mes" id="Mes" >
          <option value="T" selected="selected" >Todos</option>
          <?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$Mes)
						echo "<option selected value=".$i.">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=".$i.">".$Meses[$i-1]."</option>\n";
				}
				?>
        </select>         
      </tr>	 
      <tr>
    	<td width="19%" height="17" class='formulario2'>Divisi&oacute;n</td>
    	<td colspan="3" class="formulario2" >
		<?
			$Datos=explode('~',$DivChecked);
			foreach($Datos as $c => $v)
			{
				switch($v)
				{
					case "1":
						$CheckCaMa='checked';
					break;
					case "3":
						$CheckCoNorte='checked';
					break;
					case "4":
						$CheckSalva='checked';
					break;
					case "5":
						$CheckTeni='checked';
					break;
					case "2":
						$CheckVenta='checked';
					break;
				}	
			}		
		?>
		<input type="hidden" name="Division">
		 Casa Matriz<input name="Division" type="checkbox" class="SinBorde" value="1" <? echo $CheckCaMa;?>>&nbsp;&nbsp;
		 Ventanas<input name="Division" type="checkbox" class="SinBorde" value="2" <? echo $CheckVenta;?>>
		 Codelco Norte<input name="Division" type="checkbox" class="SinBorde" value="3" <? echo $CheckCoNorte;?>>&nbsp;&nbsp;
		 Salvador<input name="Division" type="checkbox" class="SinBorde" value="4" <? echo $CheckSalva;?>>&nbsp;&nbsp;
		 Teniente<input name="Division" type="checkbox" class="SinBorde" value="5" <? echo $CheckTeni;?>>&nbsp;&nbsp;
		</tr>
	   </table>   
	</td>
      <td width="15" background="../scop_web/archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="../scop_web/archivos/images/interior/form_abajo.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
  <br>	
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
  <td><img src="../scop_web/archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="../scop_web/archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
      <tr>
       <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td align="center">  
	    <table width="100%" border="1" cellpadding="4" cellspacing="0" >     
	  <tr align="center">
          <td width="10%" rowspan="2" class="TituloTablaVerde">Mes</td>
          <td width="10%" rowspan="2" class="TituloTablaVerde">Divisi�n</td>
          <td width="10%" colspan="3" class="TituloTablaVerde">Resultado</td>
          <td width="10%" rowspan="2" class="TituloTablaVerde">Total</td>
          </tr>
	  <tr  bgcolor="#FFFFFF">
		 <td width="20%" align="center" class="TituloTablaVerde">Cobre [USD]</td>
		 <td width="20%" align="center" class="TituloTablaVerde">Plata [USD]</td>
		 <td width="20%" align="center" class="TituloTablaVerde">Oro [USD]</td>
	  </tr>		  
<?
if($Buscar=='S')
{
	$HayDatos='N';
	//MOSTRARE SOLO SI EL ESTADO DEL CARRY COST ES IGUAL A 6
	$ConsultaExiste="select * from scop_carry_cost where ano='".$Ano."' and estado='6'";
	if($Mes!='T')
		$ConsultaExiste.=" and mes='".$Mes."'";
	$RespExiste=mysql_query($ConsultaExiste);
	if($FilaExiste=mysql_fetch_array($RespExiste))
	{
		$Datos=explode('~',$DivChecked);
		foreach($Datos as $c => $v)
		{
			$DatoDiv=$DatoDiv."'".$v."',";
		}	
		if($DatoDiv!='')
			$DatoDiv=substr($DatoDiv,0,strlen($DatoDiv)-1);			
		$Consulta="select * from scop_imputacion where ano='".$Ano."'";
		if($Mes!='T')
			$Consulta.=" and mes='".$Mes."'";
		$Consulta.=" and cod_division in ($DatoDiv)";
		$Consulta.=" group by ano,mes";	
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			$Detalle=$Fila["ano"]."~".$Mes=$Fila["mes"];
			$HayDatos='S';
			$ConsultaDiv="select * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
			$ConsultaDiv.=" where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
			$ConsultaDiv.=" and cod_division in ($DatoDiv)";
			$ConsultaDiv.=" group by cod_division";
			$Resp1=mysql_query($ConsultaDiv);$Cont=0;$Cant=0;
			while ($Fila1=mysql_fetch_array($Resp1))
			{
				$ConsultaFilas="select distinct * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
				$ConsultaFilas.=" where t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."' and cod_division='".$Fila1[cod_division]."' group by ano,mes,cod_division";
				$RespFilas=mysql_query($ConsultaFilas);
				while ($FilaFilas=mysql_fetch_array($RespFilas))
					$Cant=$Cant+1;	
			}
		?>
		  <tr <? echo ColorGrilla($Cont);?>>
			<? echo "<td class='formulario' rowspan=".$Cant." align='center'><a href=JavaScript:Detalle('".$Detalle."') class='LinksinLinea'>".$Meses[$Fila["mes"]-1]."</a></td>";?>
				<?
				$ConsultaDiv="select * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
				$ConsultaDiv.=" where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
				$ConsultaDiv.=" and cod_division in ($DatoDiv)";
				$ConsultaDiv.=" group by t1.cod_division";
				$Resp1=mysql_query($ConsultaDiv);$Cont=0;
				while ($Fila1=mysql_fetch_array($Resp1))
				{
					$Cont=$Cont+1;
				?>		  	
						<td align="left" <? echo ColorGrilla($Cont);?>><? echo $Fila1["nombre_subclase"]; ?></td>
						<?
						$ConsultaRes="select * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
						$ConsultaRes.=" where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
						$ConsultaRes.=" and cod_division='".$Fila1[cod_division]."'";
						$RespRes=mysql_query($ConsultaRes);$Cu=0;$Ag=0;$Au=0;$ValorCu='- - -';$ValorAg='- - -';$ValorAu='- - -';$Total=0;
						while ($FilaRes=mysql_fetch_array($RespRes))
						{
							if($FilaRes["cod_ley"]==1)
							{
								$Cu=$FilaRes[valor_imputado];
								if($Cu==0)
									$ValorCu='- - -';	
								else
								{
									$ValorCu=number_format($FilaRes[valor_imputado],0,',','.');
									$Total=$Total+$FilaRes[valor_imputado];
									$TotalCu=$TotalCu+$FilaRes[valor_imputado];
								}
							}
							if($FilaRes["cod_ley"]==2)
							{
								$Ag=$FilaRes[valor_imputado];
								if($Ag==0)
									$ValorAg='- - -';	
								else
								{
									$ValorAg=number_format($FilaRes[valor_imputado],0,',','.');
									$Total=$Total+$FilaRes[valor_imputado];
									$TotalAg=$TotalAg+$FilaRes[valor_imputado];
								}
							}
							if($FilaRes["cod_ley"]==3)
							{
								$Au=$FilaRes[valor_imputado];
								if($Au==0)
									$ValorAu='- - -';
								else
								{
									$ValorAu=number_format($FilaRes[valor_imputado],0,',','.');
									$Total=$Total+$FilaRes[valor_imputado];
									$TotalAu=$TotalAu+$FilaRes[valor_imputado];
								}
							}
						}
						echo "<td align='right' ".ColorGrilla($Cont).">".$ValorCu."</td>";
						echo "<td align='right' ".ColorGrilla($Cont).">".$ValorAg."</td>";
						echo "<td align='right' ".ColorGrilla($Cont).">".$ValorAu."</td>";
						echo "<td align='right' ".ColorGrilla($Cont)." >".number_format($Total,0,',','.')."</td>";
						$Total2=$Total2+$Total;
						?>		  							
					</tr>
				<?
				}	
		}
		echo "<tr  bgcolor='#FFFFFF'>";
			echo "<td colspan='2' align='right' class='formulario'>Total</td>";
			echo "<td align='right' class='formulario'>".number_format($TotalCu,0,',','.')."</td>";
			echo "<td align='right' class='formulario'>".number_format($TotalAg,0,',','.')."</td>";
			echo "<td align='right' class='formulario'>".number_format($TotalAu,0,',','.')."</td>";
			echo "<td align='right' class='formulario'>".number_format($Total2,0,',','.')."</td>";
		echo "</tr>";
	}
}	
?>			
     </table>
	</td>
 </td>
   <td width="10" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
   </tr>
    <tr>
      <td width="15"><img src="../scop_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="../scop_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
 </tr>
</table>
<? include("pie_pagina.php");?>
</form>
</body>
</html>
<?
	echo "<script languaje='JavaScript'>";
	if ($Mensaje=='E')
		echo "alert('No se puede Eliminar, Existen Flujos Asociados');";
	if ($Mensaje=='S')
		echo "alert('Contrato Eliminado Exitosamente');";
	if ($HayDatos=='N')
		echo "alert('No Existen Valores Imputados');";
	echo "</script>";
?>