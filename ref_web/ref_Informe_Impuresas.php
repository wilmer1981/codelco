<?php
	include("../principal/conectar_principal.php");

	if ($limpiar!='N') 
	   {
	    	$limpiar="delete from ref_web.leyes";
	    	mysqli_query($link, $limpiar);
			$Contador = 0; 
			
		}
 	
	
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Impurezas</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action ="ref_Informe_Impurezas_excel.php";
			f.submit();
			break;
	
	}
}
function traspasa(proceso)
{ 
  var f=document.frmPrincipal;

  f.Contador.value = parseInt(f.Contador.value) + 1; 
 	
  var TextoSelec = document.frmPrincipal.cmbleyes.value;
  var DiaIni=document.frmPrincipal.DiaIni.value;
  var MesIni=document.frmPrincipal.MesIni.value;
  var AnoIni=document.frmPrincipal.AnoIni.value;
  var DiaFin=document.frmPrincipal.DiaFin.value;
  var MesFin=document.frmPrincipal.MesFin.value;
  var AnoFin=document.frmPrincipal.AnoFin.value;
  var cmbcircuito=document.frmPrincipal.cmbcircuito.value;
  var Contador = f.Contador.value;
	
  if (TextoSelec=='')
     {alert('Debe seleccionar  Leyes');}
  else{f.action = "ref_proceso_informe_impurezas.php?cmbleyes=&TextoSelec="+TextoSelec+"&proceso="+proceso+"&AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin+"&cmbcircuito="+cmbcircuito+"&Contador="+Contador;} 
  f.submit();
 
}
function quita(proceso)
{ 
  var f=document.frmPrincipal;
  f.Contador.value = parseInt(f.Contador.value) - 1;
  var TextoSelec = document.frmPrincipal.cmbleyes2.value;
  var DiaIni=document.frmPrincipal.DiaIni.value;
  var MesIni=document.frmPrincipal.MesIni.value;
  var AnoIni=document.frmPrincipal.AnoIni.value;
  var DiaFin=document.frmPrincipal.DiaFin.value;
  var MesFin=document.frmPrincipal.MesFin.value;
  var AnoFin=document.frmPrincipal.AnoFin.value;
  var cmbcircuito=document.frmPrincipal.cmbcircuito.value;
  var Contador = f.Contador.value;
  if (TextoSelec=='')
     {alert('Debe seleccionar Leyes');}
  else {f.action = "ref_proceso_informe_impurezas.php?cmbleyes="+TextoSelec+"&proceso="+proceso+"&AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin+"&cmbcircuito="+cmbcircuito +"&Contador="+Contador;}
																																																							 
  f.submit();
}
function Buscar()
{
  	var  f=document.frmPrincipal;
	var TextoSelec = document.frmPrincipal.cmbleyes2.value;
	var DiaIni=document.frmPrincipal.DiaIni.value;
    var MesIni=document.frmPrincipal.MesIni.value;
    var AnoIni=document.frmPrincipal.AnoIni.value;
    var DiaFin=document.frmPrincipal.DiaFin.value;
    var MesFin=document.frmPrincipal.MesFin.value;
    var AnoFin=document.frmPrincipal.AnoFin.value;
    var cmbcircuito=document.frmPrincipal.cmbcircuito.value;
	
	var Contador = f.Contador.value;
	if (cmbcircuito=='-1')
	{
	   alert('Debe Seleccionar Circuito');
	}
	else
	{
		if (cmbcircuito=='GB')
		{
			if (f.Contador.value ==0)
			{
				alert('Debe Seleccionar Leyes')
				
			}
				else
				{		
					Ponderados();
					return;
				}	
		} 
		else
		{
			f.action="ref_informe_impuresas.php?mostrar=S"+"&limpiar=N"+"&AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin+"&cmbcircuito="+cmbcircuito;;
	    	f.submit();
		}
	}   	
}
function Ponderados()
  { 
    var  f=document.frmPrincipal;


    var DiaIni=document.frmPrincipal.DiaIni.value;
    var MesIni=document.frmPrincipal.MesIni.value;
    var AnoIni=document.frmPrincipal.AnoIni.value;
    var DiaFin=document.frmPrincipal.DiaFin.value;
    var MesFin=document.frmPrincipal.MesFin.value;
    var AnoFin=document.frmPrincipal.AnoFin.value;
	
	
	if ((f.cmbcircuito.value=='DP')||(f.cmbcircuito.value=='DT')||(f.cmbcircuito.value=='RETORNO')||(f.cmbcircuito.value=='1-HM')||(f.cmbcircuito.value=='TK-100'))
	   {
	    alert ('El Calculo de Ponderados es solo Para Circuitos Comerciales');   
	   }
	else {   
	      window.open("ref_ponderados2.php?AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin,"","menubar=no resizable=no top=20 left=30 width=820 height=550 scrollbars=yes");
		 } 
   } 
function Grafico()
{
	
	var  f=document.frmPrincipal;
	var cmbcircuito=document.frmPrincipal.cmbcircuito.value;
	if (cmbcircuito=='-1')
	{
	   	alert('Debe Seleccionar Circuito');
		return;
	}
	
		
	
	
	if (f.Contador.value > 3)
	{
		alert ('Ha Seleccionado + de 3 Elementos a Graficar, Revise...');
	}
	else
	{
		if (f.Contador.value == 0)
		{
			
			alert('Debe seleccionar Leyes');
		}
		else
		{
			var DiaIni=document.frmPrincipal.DiaIni.value;
    		var MesIni=document.frmPrincipal.MesIni.value;
    		var AnoIni=document.frmPrincipal.AnoIni.value;
    		var DiaFin=document.frmPrincipal.DiaFin.value;
    		var MesFin=document.frmPrincipal.MesFin.value;
    		var AnoFin=document.frmPrincipal.AnoFin.value;
    			//	window.open("ref_opc_grafico_impurezas_por_tipo.php?AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin+"&cmbcircuito="+f.cmbcircuito.value,"","menubar=yes resizable=yes top=30 left=30 width=820 height=250 scrollbars=yes");
			window.open("ref_grafico_impurezas_electrolito.php?AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin+"&cmbcircuito=" +f.cmbcircuito.value,"","menubar=no resizable=no top=30 left=30 width=920 height=730 scrollbars=no");
		}																																																     
	}
}   	
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <?php		
	
?>
  <tr align="center" > 
      <td colspan="4" class="ColorTabla01"><strong>INFORME IMPUREZAS POR TIPO</strong></td>
  </tr>
  <tr> 
    <td colspan="4">
	
	<input name="Contador" type="hidden" value="<?php echo $Contador;?>">
	</td>
  </tr>
  <tr> 
    <td width="92">Fecha Inicio:</td>
    <td width="263"><select name="DiaIni" style="width:50px;">
	
        <?php
		
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
      </select> <select name="MesIni" style="width:90px;">
        <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
      </select> <select name="AnoIni" style="width:60px;">
        <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
      </select></td>
    <td width="112">Fecha Termino:</td>
    <td width="264"><select name="DiaFin" style="width:50px;">
        <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
      </select> <select name="MesFin" style="width:90px;">
        <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
      </select> <select name="AnoFin" style="width:60px;">
        <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
      </select>
    </td>
  </tr>
   <tr align="center">
    <td colspan="4"> 
       <table width="738" height="132" border="0">
          <tr> 
            <td width="69" height="128">Circuito</td>
            <td width="279"> <select  name="cmbcircuito" id="cmbcircuito"  >
                <option value="-1" selected>SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sec_web.circuitos ";
				$consulta.= " ORDER BY cod_circuito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if  ($row[cod_circuito] == $cmbcircuito)
						echo '<option value="'.$row[cod_circuito].'" selected>Circuito '.$row[cod_circuito].'</option>';
					else 
						echo '<option value="'.$row[cod_circuito].'">Circuito '.$row[cod_circuito].'</option>';
				}
				//poly 09-03-2005
			  	if ($cmbcircuito=='GLOBALES')
			  	{	
				?>
				  <option value="GB" selected>GLOBALES</option>
			  	<?php
				}
				else
				{
				?>
					 <option value="GB">GLOBALES</option>		 		
				<?php 
				}
				//poly 09-03-2005
				?>
				
				<?php	
			 	if ($cmbcircuito=='DP')
			 	{ ?>
                <option value="DP" selected>Circuito DP</option>
                <?php } 
			   else { ?>
                <option value="DP">Circuito DP</option>
                <?php } ?>
                <?php if ($cmbcircuito=='DT')
			      { ?>
                <option value="DT" selected>Circuito DT</option>
                <?php } 
			   else { ?>
                <option value="DT">Circuito DT</option>
                <?php } ?>
                <?php if ($cmbcircuito=='RETORNO')
			      { ?>
                <option value="RETORNO" selected>Circuito RETORNO</option>
                <?php } 
			   else { ?>
                <option value="RETORNO">Circuito RETORNO</option>
                <?php } ?>
                <?php if ($cmbcircuito=='1-HM')
			      { ?>
                <option value="1-HM" selected>Circuito 1-HM</option>
                <?php } 
			   else { ?>
                <option value="1-HM">Circuito 1-HM</option>
                <?php } ?>
                <?php if ($cmbcircuito=='TK-100')
			      { ?>
                <option value="TK-100" selected>Circuito TK-100</option>
                <?php } 
			   else { ?>
                <option value="TK-100">Circuito TK-100</option>
                <?php } ?>
              </select>
          		<input name="buscar" type="button" value="buscar" onClick="Buscar()" >
				<input name="grafico" type="button" value="Grafico" onClick="Grafico()"> 
			</td>
            <td width="114">Tipo de Analisis </td>
            <td width="107"><select  style="width:70" name="cmbleyes" size="10" id="select" >
                <?php
				
				$consulta = "SELECT * FROM proyecto_modernizacion.leyes where Refineria='R'";
				$consulta.= " ORDER BY cod_leyes asc";
				echo $consulta;
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
		  			if  ($row["abreviatura"] == $cmbleyes)
						echo '<option value="'.$row["cod_leyes"].'" selected>'.$row["abreviatura"].'</option>';
					else 
						echo '<option value="'.$row["cod_leyes"].'">'.$row["abreviatura"].'</option>';
				}
				    
			?>
              </select></td>
            <td width="24"><input type="submit" name="Submit2" value="&gt;" onClick="traspasa('T')">
              <input type="submit" name="Submit22" value="&lt;" onClick="quita('Q')"></td>
            <td width="119"><select  style="width:70" name="cmbleyes2" size="10" id="cmbleyes2" >
               
                <?php
				
				$consulta = "SELECT * FROM ref_web.leyes";
				$consulta.= " ORDER BY cod_leyes asc";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
				   				 
		            if  ($cmbleyes2 == $row["cod_leyes"])
						echo '<option value="'.$row["cod_leyes"].'" selected>'.$row["abreviatura"].'</option>';
					else 
						echo '<option value="'.$row["cod_leyes"].'">'.$row["abreviatura"].'</option>';
				}
				    
			?>
				

              </select></td>
          </tr>
        </table>
		
	  </p>
        <p> 
          <?php 
          /*poly 09-03-2005 <input name="ponderados" type="button" value="Globales" onClick="Ponderados()" >
		 
          <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
          <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir">*/
		  ?> 
        </p></td>
  </tr>
</table>
<br>
<table width="786" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01"> 
      <td width="200" align="left"><strong>Circuito <?php echo $cmbcircuito; ?></strong></td>
	  <?php 
	     $consulta = "SELECT * FROM ref_web.leyes";
		 $consulta.= " ORDER BY cod_leyes asc";
		 $rs = mysqli_query($link, $consulta);
		 while ($row = mysqli_fetch_array($rs))
			{
				echo '<td width="73"><strong>'.$row["abreviatura"].'</strong></td>';   				 
		    }?>
   
  </tr>  
  <?php
       if ($mostrar=='S')
          {  
   			$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
			$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
			$consulta_ley="select * from ref_web.leyes order by cod_leyes asc";
			$Respuesta_ley = mysqli_query($link, $consulta_ley);
			while ($Fila_ley=mysqli_fetch_array($Respuesta_ley))
	    		{
					$Consulta_fecha="select distinct left(t1.fecha_muestra,10) as fecha from cal_web.solicitud_analisis as t1 ";
    				$Consulta_fecha.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
    				$Consulta_fecha.="where ceiling(t1.id_muestra)='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$Fila_ley["cod_leyes"]."' and left(t1.fecha_muestra,10) between '".$FechaInicio."' and '".$FechaTermino."' order by left(t1.fecha_muestra,10) asc";
					//echo $Consulta_fecha;
					$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
					while ($Fila_fecha = mysqli_fetch_array($Respuesta_fecha))
	       				{
				    		echo "<tr>\n";
							echo "<td align='right' width='100' class=detalle02>".$Fila_fecha["fecha"]."</td>\n";
				    		$consulta_ley="select * from ref_web.leyes order by cod_leyes asc";
	                		$Respuesta_ley = mysqli_query($link, $consulta_ley);
	                		while ($Fila_ley=mysqli_fetch_array($Respuesta_ley))
	                  			{
		        	    			$Consulta="select  left(t1.fecha_muestra,10) as fecha ,t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
        			    			$Consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
        			    			$Consulta.="where ceiling(t1.id_muestra)='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$Fila_ley["cod_leyes"]."' and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."'";
					    			$Respuesta_res = mysqli_query($link, $Consulta);
 	            	    			$Fila_res = mysqli_fetch_array($Respuesta_res);
									$consulta_unidad="select abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$Fila_res[cod_unidad]."'";
									$Respuesta_unidad = mysqli_query($link, $consulta_unidad);
 	            	    			$Fila_unidad = mysqli_fetch_array($Respuesta_unidad);
					    			if ($Fila_res=='')
					       				{echo "<td align='center'class=detalle02>&nbsp;</td>\n"; }
                        			else { $ley=number_format($Fila_res["valor"],"2",",","");
									       echo "<td align='center'  class=detalle01>$ley    ". $Fila_unidad["abreviatura"]."</td>\n";}
					  			}
					   		 echo "</tr>\n";
						}
				
					}
			
			}	
	
	?>
	
  
</table>
<br>
<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"> <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
        <input name="btnexcel" type="button" style="width:70" onClick="JavaScript:Proceso('E')" value="Excel"> 
        <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html> 
