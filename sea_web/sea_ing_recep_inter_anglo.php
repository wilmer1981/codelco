<?php
$CodigoDeSistema = 2;
$CodigoDePantalla = 59;

$HoraAux=date('G');
$MinAux=date('i');
if(!isset($Hora))
{
	if(intval($HoraAux)>=0&&intval($HoraAux)<8)
	{
		$Hora="07";
		$Minutos="59";
	}
	if(intval($HoraAux)>=8&&intval($HoraAux)<16)
	{
		$Hora="15";
		$Minutos="59";
	}
	if(intval($HoraAux)>=16&&intval($HoraAux)<=23)
	{
		$Hora="23";
		$Minutos="59";
	}
}	
if(!isset($ano2))
{
	$ano2=date('Y');
	$mes2=date('m');
}
?>
<html>
<head>
<title>Recepci�n Productos Intermedios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Traspasa_Lote(f,pos)
{
var posi = pos;

	f.elements[posi+2].value = f.elements[posi-6].value;
}	

function Traspasa_Lote1(f,pos)
{
var posi = pos;

	
	if(f.elements[posi-9].value == '')
		f.elements[posi+3].value = f.elements[posi-5].value;
	else
		f.elements[posi+3].value = f.elements[posi-9].value;
	
}	

function Buscar_Lote(f,pos)
{
var posi = pos;
	subproducto = f.elements[posi].value;
	valores = "&proveedor=" + f.proveedor.value + "&subproducto=" + subproducto + "&pos=" + posi;
//	f.action="sea_ing_recep_inter.php?mostrar=S" + valores;
//	f.submit();
	
//	alert(posi);
}	

function buscar_guia()
{
	window.open("sea_ing_recep_ext03.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
}	

function Datos_Ingresados()
{
var f = frmPrincipal;

       	window.open("sea_ing_recep_ext04.php", "","menubar=no resizable=no Top=10 Left=200 width=590 height=700 scrollbars=no");

}


function Guardar_Datos()
{
var f = frmPrincipal;
var Valores='';

		if(f.proveedor.value='A-77762940-9')
		{
			for (i=9;i<=f.elements.length-2;i++)
			{
				if ((f.elements[i].name == "ValorTTE")&&(f.elements[i-1].value!=''||f.elements[i-1].value!=0))
				{
					Valores=Valores+f.elements[i].value+'~'+f.elements[i-2].value+'~'+f.elements[i-1].value+"//";
				}
			}
			Valores = Valores.substring(0,(Valores.length-2));
			f.action="sea_ing_recep_inter_anglo01.php?Proceso=G&GrabarTTE=S&DatosRecep="+Valores;
		}
		else
			f.action="sea_ing_recep_inter_anglo01.php?Proceso=G";
        f.submit();
  		
}



function Recarga()
{
var f = frmPrincipal;
		f.action="sea_ing_recep_inter_anglo.php?Proceso=V&Mostrar=S";
        f.submit();
  		
}


function mostrar_guia()
{
var f = frmPrincipal;

	f.action="sea_ing_recep_inter_anglo.php?mostrar=S";
	f.submit();

}

function mostrar_guia2(Est)
{
var f = frmPrincipal;

	f.action="sea_ing_recep_inter_anglo.php?Mostrar=S&Est="+Est;
	f.submit();

}

function salir_menu()
{
	
var f=frmPrincipal;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}	
function CalculaPeso(Valor,u,NumElemt,PiezasTot,PiezasRecep,PesoTot,PesoRecep,UnidIng,PesoIng)
{

	var f=frmPrincipal;
	var Dif=0;
	
	//alert(parseInt(PiezasRecep));
	//alert(parseInt(u.value));
	Dif=parseInt(PiezasRecep)+parseInt(u.value);
	if(Dif>PiezasTot)
	{	
		alert('Unidades Ingresadas no pueden ser Mayor a Unidades Totales');
		f.elements[NumElemt].value='';
		u.value='';
		u.focus();
		return;
	}
	if(u.value==PiezasTot)
	{
		f.elements[NumElemt].value=PesoTot;
		return;
	}
	if((parseInt(u.value)+parseInt(UnidIng))==PiezasTot)
	{
		f.elements[NumElemt].value=PesoTot-PesoIng;
		return;
	}

	if(u.value!=''&&u.value!='0')
		if(Valor*parseInt(u.value)+parseInt(PesoRecep)>parseInt(PesoTot))
			f.elements[NumElemt].value=parseInt(PesoTot)-parseInt(PesoRecep);
		else
			f.elements[NumElemt].value=Valor*parseInt(u.value);
	else
	{
		f.elements[NumElemt].value='';
		u.value='';
	}

}
function CerraRecep(Ck,SP,Lote,Guia)
{
	var f=frmPrincipal;
	
	if(Ck.checked==true)
	{
		if(confirm('Esta Seguro de Cerrar el Lote'))
		{
			f.action="sea_ing_recep_inter_anglo01.php?Proceso=CL&SubProducto="+SP+"&LoteVentana="+Lote+"&Guia="+Guia;
	        f.submit();
		}
	}	
}	
function CierreAnglo(Ck,SP,Lote,Rec,Guia,UnidR,PesoR,Origen,UnidO,PesoO,FechaGuia,Marca)
{
	var f=frmPrincipal;
	
	if(Ck.checked==true)
	{
		//alert(parseInt(UnidR));
		if(parseInt(UnidR)>0)
		{
			if(confirm('Esta Seguro de Cerra Lote y Traspasar lo Pendiente al Mes Siguiente'))
			{
				f.action="sea_ing_recep_inter_anglo01.php?Proceso=CT&SubProducto="+SP+"&LoteVentana="+Lote+"&Rec="+Rec+"&Guia="+Guia+"&UnidR="+UnidR+"&PesoR="+PesoR+"&LoteOrigen="+Origen+"&PesoO="+PesoO+"&UnidO="+UnidO+"&FechaGuia="+FechaGuia+"&Marca="+Marca;
				f.submit();
			}
		}	
		else
		{
			if(confirm('Esta Seguro de Eliminar Lote y Traspasar sus Unidades al Mes Siguiente'))
			{
				f.action="sea_ing_recep_inter_anglo01.php?Proceso=EL&SubProducto="+SP+"&LoteVentana="+Lote+"&Rec="+Rec+"&Guia="+Guia;
				f.submit();
			}
		}	
	}	
}	

function VerGuias()
{
  	window.open("sea_ing_recep_ext_guias.php", "","menubar=no resizable=yes Top=10 Left=200 width=630 height=700 scrollbars=yes");
}
function MostrarLotes(Lote,Guia,LoteOrigen)
{
  	//alert(Lote);
	window.open("sea_ing_recep_ext_lotes_guias.php?Lote="+Lote+"&Guia="+Guia+"&LoteOrigen="+LoteOrigen, "","menubar=no resizable=yes Top=10 Left=200 width=630 height=350 scrollbars=yes");
}

</script>

<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head> 

<body>
<form name="frmPrincipal" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  <input name="PProveedor" type="hidden" value="PProveedor">
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="800" align="center" valign="top" >
	  <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="73">Origen Anodo</td>
            <td width="269">
              <?php
			   echo'<SELECT name="proveedor" onChange="Recarga()">';
			   echo'<option value="-1" seleted>Seleccionar</option>';
               if($proveedor == "A-77762940-9")
			   	echo'<option value="A-77762940-9" SELECTed>ANODOS ANGLO AMERICA</option>';		   
               else
			   	echo'<option value="A-77762940-9">ANODOS ANGLO AMERICA</option>';		   
		    ?>
              <font color="#000000" size="2">&nbsp;            </font> </td>
            <td><font color="#000000" size="2">Fecha Mov.
              <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
			if($mostrar=='S' || $Proceso == 'V')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
              </SELECT>
              </font> <font color="#000000" size="2"> 
              <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($mostrar=='S' || $Proceso == 'V')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
              </SELECT>
    <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($mostrar=='S' || $Proceso == 'V')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
              </SELECT>
              </font></td>
            <td><input name="mostrar" type="hidden" value="Ok" onClick="mostrar_guia();">              
             <!-- <input name="nuevo" type="button" value="Ingreso Manual" style="width:100" onClick="nueva_guia();">
             --> <?php
			/*if($proveedor == "A-77762940-9")
			{
				echo "<input name='ver datos' type='button' value='Gu�as Anglo' style='width:80' onClick='VerGuias();'>&nbsp;";
				
			}*/
			?></td>
          </tr>
          <tr> 
            <td colspan="2">
			
			<?php 
			if($proveedor == "A-77762940-9")
			{

				if(!isset($Est))
					$Est='A';
				if($Est=='A')
				{  
					$Opt1='checked';
					$Opt2='';		
				}
				else
				{  
					$Opt1='';
					$Opt2='checked';		
				}
				echo "Abierto<input name='radiobutton' type='radio' value='radiobutton' onClick=mostrar_guia2('A') $Opt1>";
				echo "Cerrado<input name='radiobutton' type='radio' value='radiobutton' onClick=mostrar_guia2('C') $Opt2>";
			}	
			?>            <font color="#000000" size="2">
			<?php
			if($Est=='C')
			{
			?>
            <SELECT name="mes2" size="1"style="FONT-FACE:verdana;FONT-SIZE:10" onChange="mostrar_guia2('C')">
            <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
			if ($Mostrar=='S' || $Proceso == 'V')
			{
				for($i=1;$i<13;$i++)
				{
					if ($i==$mes2)
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}		
			}
			else
			{
				for($i=1;$i<13;$i++)
				{
					if ($i==date("n"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}  			 
			} 	  
		    ?>
            </SELECT>
            <SELECT name="ano2" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10" onChange="mostrar_guia2('C')">
              <?php
			if($Mostrar=='S' || $Proceso == 'V')
			{
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
				{
					if ($i==$ano2)
						echo "<option SELECTed value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}
			}
			else
			{
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
				{
					if ($i==date("Y"))
						echo "<option SELECTed value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				 }   
			}	
			?>
            </SELECT>			
            <?php
			}
			?>
</font> </td>
            <td width="273"><font size="1"><font size="2">Hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <SELECT name="Hora">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </SELECT>
              <strong>:</strong>
              <SELECT name="Minutos">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </SELECT>
            </font></font></td>
            <td width="118">
              <input name="ver datos" type="button" value="Datos Ingres." style="width:90" onClick="Datos_Ingresados();">
           <font color="#333333" size="2">
              <input name="buscar_g" type="hidden"  value="Modificar Gu&iacute;a" style="width:130" onClick="buscar_guia();">
              </font></td>
          </tr>
        </table>
	  <br>

        <table width="760" height="22" border="1" cellpadding="1" cellspacing="0" class="TablaDetalle">

<?php 
//PROVEEDOR ANGLO
 $codigo = substr($proveedor,0,1); 
 if($Mostrar=="S"&& $proveedor == "A-77762940-9")
 {
	
  if($Est=='A')
  {
  	  $prov = substr($proveedor,2,10);
	  echo'<tr class="ColorTabla01"> 
		<td width="17%"><div align="center">Guia</div></td>
		<td width="8%"><div align="center">Lote V.</div></td>
		<td width="8%"><div align="center">Recargo</div></td>
		<td width="15%"><div align="center">Peso Recep</div></td>
		<td width="15%"><div align="center">Hornada</div></td>
		<td width="12%"><div align="center">Peso Origen</div></td>
		<td width="15%"><div align="center">Unidades</div></td>
		<td width="15%"><div align="center">Lote O.</div></td>
		<td width="15%"><div align="center">Marca</div></td>
		<td width="10%"><div align="center">Unid.Tot</div></td>
		<td width="10%"><div align="center">Peso Ing</div></td>
		<td width="10%"><div align="center">Unid.Recep</div></td>
		<td width="5%"><div align="center">Cerrar</div></td>
		<td width="8%"><div align="center">Cierre ANGLO</div></td>
	  </tr>';
         $l = strlen($mes);
		 if ($l==1)
		     $mes = "0$mes";
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$cont = 20;
		$NumElemt=20;
        $Fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($fecha, 5, 2)) ,intval(substr($fecha, 8, 2)) + 1,intval(substr($fecha, 0, 4))));
		$Consulta="SELECT distinct guia,count(*) as cant,fecha_guia from sea_web.recepcion_externa_anglo where ";
		if($Est=='A')
		  $Consulta.="(estado not in ('C') and peso <> peso_recep) and (estado not in ('X'))";  //X---->GUIAS ANULADAS
		else-
		  $Consulta.="estado ='C' or peso = peso_recep ";
		$Consulta.="group by guia";
		$RespGuia=mysqli_query($link, $Consulta);
		while($FilaGuia=mysqli_fetch_array($RespGuia))
		{
			$FechaGuiaTTE=$FilaGuia[fecha_guia];
			$Consulta="SELECT count(*) as cant_guias from sea_web.recepcion_externa_anglo where guia='$FilaGuia["guia"]'";
			$RespCant=mysqli_query($link, $Consulta);
			$FilaCant=mysqli_fetch_array($RespCant);
			//echo "MM".$Est."<br>";
			//echo $FilaGuia["cant"]."<br>";
			//echo $FilaCant[cant_guias]."<br><br>";
			if($Est=='A'||$Est=='C'&&$FilaGuia["cant"]==$FilaCant[cant_guias])
			{
			echo'<tr class="ColorTabla02">';
			echo '<td>'.$FilaGuia["guia"].'</td>';
			echo '<td colspan="13">&nbsp;</td>';
			echo '</tr>'; 
			$Consulta="SELECT guia,lote_ventana from sea_web.recepcion_externa_anglo where ";
			if($Est=='A')
			  $Consulta.="estado <>'C' and peso <> peso_recep ";
			else
			  $Consulta.="estado ='C' or peso = peso_recep ";
			$Consulta.=" and guia='$FilaGuia["guia"]'";
			$RespGuia2=mysqli_query($link, $Consulta);
		//	echo $Consulta."<br>";
			while($FilaGuia2=mysqli_fetch_array($RespGuia2))
			{
				//echo $FilaGuia2[lote_ventana]."<br>";
				//echo $Est."<br>";
				if($Est=='A')
					$consulta = "SELECT lote as LOTE_A,guia_despacho,fecha,recargo FROM SIPA_WEB.recepciones WHERE guia_despacho='$FilaGuia2["guia"]' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '$prov' and peso_neto =0 and lote='$FilaGuia2[lote_ventana]' order by lote";				
	else
					$consulta = "SELECT lote as LOTE_A,guia_despacho,fecha,recargo FROM SIPA_WEB.recepciones WHERE guia_despacho='$FilaGuia2["guia"]' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '$prov' and peso_neto!=0 and lote='$FilaGuia2[lote_ventana]' order by lote";
				$rs = mysqli_query($link, $consulta);
			//	echo "Consulta 2 ".$consulta."<br>";
				while($row = mysqli_fetch_array($rs))
				{
					$FechaRec=$row["fecha"];
					$Encontrado = "S";
					$i = $i + 1;
					$unidades =0;$peso_recepcion=0;$producto = '';$hornada = '';$lote_origen = '';$marca = '';		                      
					$lote_ventana = $row[LOTE_A];
					$recargo = $row["recargo"];
					$Guia=$row[guia_despacho];
				  	$consulta = "SELECT lote_ventana AS LOTE_A,peso,peso_recep,piezas,piezas_recep from sea_web.recepcion_externa_anglo where guia='$FilaGuia["guia"]' and cod_producto='17' and cod_subproducto = '3' and lote_ventana='".$lote_ventana."'";
					//	echo "Consulta 2 ".$consulta."<br>";
					$RespRecep = mysqli_query($link, $consulta);
					if($FilaRecep= mysqli_fetch_array($RespRecep))
					{
						$peso_origen = $FilaRecep["peso"];
						$Unid=$FilaRecep[piezas];
						$PesoPieza=0;
						if($FilaRecep[piezas]!=0)
							$PesoPieza= round($FilaRecep["peso"]/$FilaRecep[piezas]);
						//echo $PesoPieza."<br>";	
						//if($FilaRecep[peso_recep]>=0)
						//{
							$peso_recepcion = $FilaRecep[peso_recep];
							$PesoRecep=$FilaRecep[peso_recep];
							$UnidRecep=$FilaRecep[piezas_recep];
							$unidades=$FilaRecep[piezas_recep];
						//}	
					}
					$consulta = "SELECT * from  sea_web.relaciones where lote_ventana = $row[LOTE_A]";
					//echo "uno".$consulta."<br>";
					$rs2 = mysqli_query($link, $consulta);
					if ($row2 = mysqli_fetch_array($rs2))
					{
					   $producto = $row2[cod_origen];
					   $hornada = $row2[hornada_ventana];		 
					   $lote_origen = $row2[lote_origen];
					   $marca = $row2['marca'];		 
					} 
					$Hora=date('H:i:s');
					if(date('d')=='01' && $Hora<='07:59:59')
					{
							$disabled="disabled";
							$readonly="";
					}
					else
					{
						if(substr($row[LOTE_A],2,2)==date('m'))
						{
							
								$disabled="disabled";
								$readonly="";
						
						}
						else
						{
							$readonly="readonly";
							$disabled="";
							
						}
					}
					
					?><tr>
					<input name="a[<?php echo $i;?>]" type="hidden" size="8">
					<input name="lote_ventana[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $lote_ventana?>">
					<input name="producto[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $producto;?>">
					<input name="FechaRec[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $FechaRec;?>">
					<td><input name="guia[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $Guia;?>"><?php echo $FechaGuiaTTE;?></td>
					<td><div align="center"><input name="lote_ventana[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $row[LOTE_A];?>"><a href="JavaScript:MostrarLotes('<?php echo $row[LOTE_A];?>','<?php echo $Guia;?>','<?php echo $lote_origen;?>')"><?php echo $row[LOTE_A];?></a></div></td>
					<td><div align="center"><input name="recargo[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $recargo;?>"><?php echo $recargo;?></div></td>
					<input name="peso_ant[<?php echo $i;?>]" type="hidden" size="7" value="<?php echo number_format($peso,0,'','');?>">
					<td><div align="center"><input name="peso_recepcion[<?php echo $i;?>]" type="text" value="" size="8" readonly></div></td>
					<input name="hornada_aux[<?php echo $i;?>]" type="hidden" size="5" value="<?php echo $hornada?>">
					<td><div align="center"><input name="hornada[<?php echo $i;?>]" type="text" size="5" value="<?php echo substr($hornada,6,6);?>" readonly></div></td>
					<td><div align="center"><input name="peso_origen[<?php echo $i;?>]" type="text" value="<?php echo $peso_origen;?>" size="8" readonly></div></td>
					<input name="unidades_ant[<?php echo $i;?>]" type="hidden" size="5" value="<?php echo $unidades;?>">
					<td align="center"><input name="unidades[<?php echo $i;?>]" type="text" size="5" <?php echo $readonly;?> value="" onBlur="CalculaPeso('<?php echo $PesoPieza;?>',this,'<?php echo $NumElemt;?>','<?php echo $Unid;?>','<?php echo $UnidRecep;?>','<?php echo $peso_origen;?>','<?php echo $PesoRecep;?>','<?php echo intval($unidades);?>','<?php echo intval($peso_recepcion);?>')"></td>
					<td><div align="center"><input name="lote_origen[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $lote_origen;?>">&nbsp;<?php echo $lote_origen;?></div></td>
					<td><div align="center"><input name="marca[<?php echo $i;?>]" type="hidden" size="8" value="<?php echo $marca;?>">&nbsp;<?php echo $marca;?></div></td>
					<td><div align="center">&nbsp;<?php echo $Unid;?></div></td>
					<td align="right">&nbsp;<?php echo $PesoRecep;?></td>
					<td align="right">&nbsp;<?php echo $unidades;?></td>
					<td align="center"><input type="checkbox"  alt="Cierre de Lote" name="CheckCerra" onClick="CerraRecep(this,'<?php echo $producto;?>','<?php echo $lote_ventana;?>','<?php echo $Guia;?>')"></td>
					<td align="center">
                  
                    <input type="checkbox" <?php echo $disabled;?> alt="Cierre mes y traspasa al siguiente"  name="CheckElimina"  onClick="CierreAnglo(this,'<?php echo $producto;?>','<?php echo $lote_ventana;?>','<?php echo $recargo;?>','<?php echo $Guia;?>','<?php echo $unidades;?>','<?php echo $PesoRecep;?>','<?php echo $lote_origen;?>','<?php echo $Unid;?>','<?php echo $peso_origen;?>','<?php echo $FechaGuiaTTE;?>','<?php echo $marca;?>')">
                   
                    </td>
					 </tr>
                     <?php 
					$Total_peso = $Total_peso + $peso_recepcion; 
					$Total_origen = $Total_origen + $peso_origen; 
					$Total_unid = $Total_unid + $unidades;	
					$NumElemt=$NumElemt+18;	
				}
			}
			echo'<tr class="Detalle02">';
			echo'<td colspan="5">Totales</td>';
			echo'<td align="center">&nbsp;'.$Total_origen.'</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'<td align="center" colspan="3">&nbsp;</td>';
			echo'<td align="right">'.$Total_peso.'</td>';
			echo'<td align="right">'.$Total_unid.'</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'</tr>';
			$Total_peso=0;$Total_origen=0;$Total_unid=0;
			}
	}
 }
 else
 {
  	    $prov = substr($proveedor,2,10);
	    echo'<tr class="ColorTabla01"> 
		<td width="10%"><div align="center">Guia</div></td>
		<td width="15%"><div align="center">Fecha</div></td>
		<td width="12%"><div align="center">Lote V.</div></td>
		<td width="8%"><div align="center">Lote O.</div></td>
		<td width="12%"><div align="center">Hornada</div></td>
		<td width="8%"><div align="center">Marca</div></td>
		<td width="12%"><div align="center">Peso Origen</div></td>
		<td width="12%"><div align="center">Peso Recep</div></td>
		<td width="12%"><div align="center">Unid Origen</div></td>
		<td width="12%"><div align="center">Unid Recep.</div></td>
	    </tr>';
		$FechaIniCon=$ano2."-".$mes2."-"."01";
		$FechaFinCon=$ano2."-".$mes2."-"."31";
		$TotalPeso=0;$TotalPesoR=0;$TotalPiezas=0;$TotalPiezasR=0;
		$Consulta="SELECT t1.guia,t1.fecha_guia,t1.lote_ventana,t2.lote_origen,t1.marca,t2.hornada_ventana,t1.peso,t1.peso_recep,t1.piezas,t1.piezas_recep,t1.estado ";
		$Consulta.="from sea_web.recepcion_externa_anglo t1 left join sea_web.relaciones t2 on t1.lote_ventana=t2.lote_ventana ";
		$Consulta.="where (fecha between '$FechaIniCon' and '$FechaFinCon') and (t1.estado in('C','X') or t1.peso = t1.peso_recep) order by t1.guia";
		//echo $Consulta."<br>";
		$RespGuia=mysqli_query($link, $Consulta);
		while($FilaGuia=mysqli_fetch_array($RespGuia))
		{
			if($FilaGuia["estado"]=='X')
				echo "<tr class='Detalle03'>";
			else
				echo "<tr>";	
			echo "<td align='center'>".$FilaGuia["guia"]."</td>";
			echo "<td align='center'>".$FilaGuia[fecha_guia]."</td>";		
			echo "<td align='center'><a href=JavaScript:MostrarLotes('".$FilaGuia[lote_ventana]."','".$FilaGuia["guia"]."','".$FilaGuia[lote_origen]."')>".$FilaGuia[lote_ventana]."</a></td>";		
			echo "<td align='center'>".$FilaGuia[lote_origen]."</td>";		
			echo "<td align='center'>".$FilaGuia[hornada_ventana]."</td>";		
			echo "<td align='center'>".$FilaGuia[marca]."</td>";		
			echo "<td align='right'>".number_format($FilaGuia["peso"],0,'','.')."</td>";
			echo "<td align='right'>".number_format($FilaGuia[peso_recep],0,'','.')."</td>";		
			echo "<td align='right'>".number_format($FilaGuia[piezas],0,'','.')."</td>";
			echo "<td align='right'>".number_format($FilaGuia[piezas_recep],0,'','.')."</td>";
			echo "</tr>";
			$TotalPeso=$TotalPeso+$FilaGuia["peso"];
			$TotalPesoR=$TotalPesoR+$FilaGuia[peso_recep];
			$TotalPiezas=$TotalPiezas+$FilaGuia[piezas];
			$TotalPiezasR=$TotalPiezasR+$FilaGuia[piezas_recep];
		}
		echo "<tr class='Detalle01'>";
		echo "<td colspan='6'>&nbsp;</td>";
		echo "<td align='right'>".number_format($TotalPeso,0,'','.')."</td>";
		echo "<td align='right'>".number_format($TotalPesoR,0,'','.')."</td>";
		echo "<td align='right'>".number_format($TotalPiezas,0,'','.')."</td>";
		echo "<td align='right'>".number_format($TotalPiezasR,0,'','.')."</td>";
		echo "</tr>";	
 }
}  
?>
        </table>
		<br>
        <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="766"><div align="center"><font color="#000000" size="2">&nbsp; 
                <?php
				 if($Est=='A')
					echo'<input name="grabar" type="button" style="width:70" value="Grabar" onClick="Guardar_Datos();">';
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades == '' && $codigo == "B")
					echo'<input name="grabar2" type="button" style="width:70" value="xxxGrabar" onClick="Guardar_Datos2(this.form,'.($cont).');">';
                ?>
				<input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
                </font></div></td>
          </tr>
      </table></td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
