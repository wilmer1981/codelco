<?php
$CodigoDeSistema = 2;
$CodigoDePantalla = 3;
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

function Guardar_Datos2(f,i)
{
var f = frmPrincipal;
var posi = 17;
var posi2 = 25;
var tope = i;
	if(i != '')	
	{
		for(j = 0; j < tope; j++)
		{   
			if(f.elements[posi].value == -1)
			{ 
				alert("Debe Seleccionar El Subproducto");
				f.elements[posi].focus()
				return
			}
			posi = posi + 18;
		}

		for(j = 0; j < tope; j++)
		{   
			if(f.elements[posi2].value == '')
			{ 
				alert("Debe Ingresar las Unidades");
				f.elements[posi2].focus()
				return
			}
			posi2 = posi2 + 18;
		}
	}
		f.action="sea_ing_recep_inter01.php?Proceso=G";
        f.submit();
  		
}

function Guardar_Datos()
{
var f = frmPrincipal;
var Valores='';

		if(f.proveedor.value='A-61704005-0')
		{
			for (i=9;i<=f.elements.length-2;i++)
			{
				if ((f.elements[i].name == "ValorTTE")&&(f.elements[i-1].value!=''||f.elements[i-1].value!=0))
				{
					Valores=Valores+f.elements[i].value+'~'+f.elements[i-2].value+'~'+f.elements[i-1].value+"//";
				}
			}
			Valores = Valores.substring(0,(Valores.length-2));
			f.action="sea_ing_recep_inter_tte01.php?Proceso=G&GrabarTTE=S&DatosRecep="+Valores;
		}
		else
			f.action="sea_ing_recep_inter_tte01.php?Proceso=G";
        f.submit();
  		
}

function Modificar_Datos()
{
var f = frmPrincipal;
  		f.action="sea_ing_recep_inter01.php?Proceso=M";
        f.submit();
  		
}

function Recarga()
{
var f = frmPrincipal;
		f.action="sea_ing_recep_inter_tte.php?Proceso=V&mostrar=S";
        f.submit();
  		
}

function Crear_Detalle()
{
var f = frmPrincipal;
var guia = '';
var patente = '';
var fecha = '';
var LargoForm = f.elements.length;
var Valores = "";
var valor=0;

	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio") && (f.elements[i].checked == true))
		{
			    valor = f.elements[i].value.length;

				if(valor ==13)
				{
			 		guia = f.elements[i].value.substr(0,6); 
			 		patente = f.elements[i].value.substr(6,7); 
                }

				if(valor == 14)
				{
			 		guia = f.elements[i].value.substr(0,7); 
			 		patente = f.elements[i].value.substr(7,7); 
                }

            fecha=f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
			
			Valores = "?mostrar2=S&guia_aux=" + guia + "&patente=" + patente  + "&fecha=" + fecha ;  
        	window.open("sea_ing_recep_ext.php"+ Valores, "","menubar=no resizable=no Top=50 Left=200 width=770 height=410 scrollbars=no");
		}
	}
	

}

function nueva_guia()
{
var f = frmPrincipal;
   	window.open("sea_ing_guia.php", "","menubar=no resizable=no Top=50 Left=200 width=550 height=300 scrollbars=no");
}

function Agregar(f,p)
{
	
var valor = f.elements[p-1].value;

	if (valor == -1)
	{
		alert("Debe Seleccionar un Color");
		return;
	}
	
	if (valor == -2) 
		document.formulario.elements[p-2].value = "";
	else
		document.formulario.elements[p-2].value = f.elements[p-2].value + valor;				 
}

function mostrar_guia()
{
var f = frmPrincipal;

	f.action="sea_ing_recep_inter_tte.php?mostrar=S";
	f.submit();

}

function mostrar_guia2(Est)
{
var f = frmPrincipal;

	f.action="sea_ing_recep_inter_tte.php?mostrar=S&Est="+Est;
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
	
	/*if(PiezasRecep+parseInt(u.value)>PiezasTot)
	{	
		alert('Unidades Ingresadas no pueden ser Mayor a Unidades Totales');
		f.elements[NumElemt].value=0;
		u.focus();
		return;
	}*/
	Dif=parseInt(PiezasRecep)-parseInt(UnidIng)+parseInt(u.value);
	if(Dif>PiezasTot)
	{	
		alert('Unidades Ingresadas no pueden ser Mayor a Unidades Totales');
		f.elements[NumElemt].value=PesoIng;
		u.value=parseInt(UnidIng);
		u.focus();
		return;
	}
	if(u.value!=''&&u.value!='0')
		/*if((PiezasRecep+parseInt(u.value)-parseInt(PesoIng))==PiezasTot)
			f.elements[NumElemt].value=parseInt(PesoTot)-parseInt(PesoRecep);
		else
			f.elements[NumElemt].value=Valor*parseInt(u.value);*/
		/*if(parseInt(u.value)==PiezasTot)
			f.elements[NumElemt].value=parseInt(PesoTot);
		else	
			if((Valor*parseInt(u.value)+parseInt(PesoRecep)-PesoIng)>parseInt(PesoTot))
				f.elements[NumElemt].value=parseInt(PesoTot)-(parseInt(PesoRecep)-parseInt(PesoIng));
			else
			{
				if((Valor*parseInt(u.value)+parseInt(PesoRecep)-PesoIng)-parseInt(PesoTot)<=Valor)
					f.elements[NumElemt].value=parseInt(PesoTot)-(parseInt(PesoRecep)-parseInt(PesoIng));
				else
					f.elements[NumElemt].value=Valor*parseInt(u.value);
				//alert(Valor*parseInt(u.value));
			}	*/
		if(parseInt(u.value)+parseInt(PiezasRecep)-parseInt(UnidIng)==PiezasTot)
		{
			f.elements[NumElemt].value=parseInt(PesoTot)-(parseInt(PesoRecep)-parseInt(PesoIng));
		}	
		else
			f.elements[NumElemt].value=Valor*parseInt(u.value);
	else
	{
		f.elements[NumElemt].value=0;
		u.value='';
	}

}
function CerraRecep(Ck,SP,Lote)
{
	var f=frmPrincipal;
	
	if(Ck.checked==true)
	{
		if(confirm('Esta Seguro de Cerrar el Lote'))
		{
			f.action="sea_ing_recep_inter01.php?Proceso=CL&SubProducto="+SP+"&LoteVentana="+Lote;
	        f.submit();
		}
	}	
}	
function VerGuias()
{
  	window.open("sea_ing_recep_ext_guias.php", "","menubar=no resizable=yes Top=10 Left=200 width=630 height=700 scrollbars=yes");
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
            <td>Origen Anodo-Blister</td>
            <td>
              <?php
			   echo'<SELECT name="proveedor" onChange="Recarga()">';
			   echo'<option value="-1" seleted>Seleccionar</option>';

               /*if($proveedor == "A-00001100-2")
			   	echo'<option value="A-00001100-2" SELECTed>ANODOS HVL</option>';		   
               else
			   	echo'<option value="A-00001100-2">ANODOS HVL</option>';		 */  

               if($proveedor == "A-61704005-0")
			   	echo'<option value="A-61704005-0" SELECTed>ANODOS TENIENTE</option>';		   
               else
			   	echo'<option value="A-61704005-0">ANODOS TENIENTE</option>';		   

               /*if($proveedor == "A-90132000-4")
			   	echo'<option value="A-90132000-4" SELECTed>ANODOS SUR ANDES</option>';		   
			   else
			   	echo'<option value="A-90132000-4">ANODOS SUR ANDES</option>';		   

				echo '<option value="0">--------------------</option>';
			//BLISTER
			/*consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);		
			while ($row = mysqli_fetch_array($rs))
			{				
				if ('B-'.$row["cod_subclase"] == $proveedor)					
					echo '<option value="B-'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="B-'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}			*/											   
		    ?>
            </td>
            <td>Fecha</td>
            <td><font color="#000000" size="2">
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
            <td><input name="mostrar" type="button" value="Ok" onClick="mostrar_guia();">              
              <input name="nuevo" type="hidden" value="Ingreso Manual" style="width:100" onClick="nueva_guia();">            </td></tr>
          <tr> 
            <td width="109"><?php
			if($proveedor == "A-61704005-0")
			{
				echo "<input name='ver datos' type='button' value='Ver Guias TTE' style='width:100' onClick='VerGuias();'>&nbsp;";
				
			}
			?></td>
            <td width="231">
			
			<?php 
			if($proveedor == "A-61704005-0")
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
			?>
			</td>
            <td width="34">&nbsp;</td>
            <td width="196">&nbsp;</td>
            <td width="157">
              <input name="ver datos" type="button" value="Datos Ingresados" style="width:130" onClick="Datos_Ingresados();">
              <font color="#333333" size="2">
              <input name="buscar_g" type="hidden"  value="Modificar Gu&iacute;a" style="width:130" onClick="buscar_guia();">
              </font></td>
          </tr>
        </table>
	  <br>

        <table width="760" height="22" border="1" cellpadding="1" cellspacing="0" class="TablaDetalle">

<?php //Proveedores TTE
 $codigo = substr($proveedor,0,1); 
 if ($mostrar=="S" && $proveedor == "A-61704005-0" && $codigo != "B")
 {
	  $prov = substr($proveedor,2,10);
	  echo'<tr class="ColorTabla01"> 
		<td width="14%"><div align="center">Guia</div></td>
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
	  </tr>';
         $l = strlen($mes);
		 if ($l==1)
		     $mes = "0$mes";
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$cont = 20;$NumElemt=20;
        $Fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($fecha, 5, 2)) ,intval(substr($fecha, 8, 2)) + 1,intval(substr($fecha, 0, 4))));
		$Consulta="SELECT distinct guia from sea_web.recepcion_externa where ";
		if($Est=='A')
		  $Consulta.="estado <>'C' and peso <> peso_recep";
		else
		  $Consulta.="estado ='C' or peso = peso_recep";
		//echo  $Consulta;
		$RespGuia=mysqli_query($link, $Consulta);
		while($FilaGuia=mysqli_fetch_array($RespGuia))
		{
			echo'<tr class="ColorTabla02">';
			echo '<td>'.$FilaGuia["guia"].'</td>';
			echo '<td colspan="12">&nbsp;</td>';
			echo '<tr>'; 
			$consulta = "SELECT lote as LOTE_A,guia_despacho,fecha,recargo FROM SIPA_WEB.recepciones WHERE guia_despacho='$FilaGuia["guia"]' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '$prov' order by lote";
			//echo $consulta;
			include("../principal/conectar_rec_web.php");
			$rs = mysqli_query($link, $consulta);
			while($row = mysqli_fetch_array($rs))
			{
				$FechaRec=$row["fecha"];
				$Encontrado = "S";
				$i = $i + 1;
				$unidades = '';
				include("../principal/conectar_rec_web.php");
				$consulta = "SELECT * FROM SIPA_WEB.recepciones ";
				$consulta.= " WHERE guia_despacho='$FilaGuia["guia"]'  and fecha ='$row["fecha"]' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND LOTE = $row[LOTE_A] AND recargo='$row["recargo"]' and RUT_PRV = '$prov'";
				$result = mysqli_query($link, $consulta);
				if($row1 = mysqli_fetch_array($result))
				{
					$recargo = $row1["recargo"];
					
					$lote_ventana = $row[LOTE_A];
					$Guia=$row["guia_despacho"];
					$consulta = "SELECT lote_ventana AS LOTE_A,peso,peso_recep,piezas,piezas_recep from sea_web.recepcion_externa where guia='$FilaGuia["guia"]' and cod_producto='17' and cod_subproducto = '2' and lote_ventana='".$lote_ventana."'";
					//echo $consulta;
					$RespRecep = mysqli_query($link, $consulta);
					if($FilaRecep= mysqli_fetch_array($RespRecep))
					{
						$unidades = '';
						$peso_recepcion = 0;
						$peso_origen = $FilaRecep["peso"];
						$PesoRecep=$FilaRecep[peso_recep];
						$PesoPieza=0;
						if($FilaRecep[piezas]!=0)
							$PesoPieza= round($FilaRecep["peso"]/$FilaRecep[piezas]);
						$Unid=$FilaRecep[piezas];
						$UnidRecep=$FilaRecep[piezas_recep];
					}
					$consulta_s = "SELECT SUM(PESO_NETO) AS peso_t FROM SIPA_WEB.recepciones WHERE LOTE = $row[LOTE_A] AND recargo='$recargo' and fecha='$row["fecha"]' and COD_PRODUCTO='1' AND COD_SUBPRODUCTO = 17 AND RUT_PRV = '$prov'";
					$result_s = mysqli_query($link, $consulta_s);
					if ($row_s = mysqli_fetch_array($result_s))
						  $peso_recepcion = $row_s[peso_t];
					if($lote_ventana != '')
					{
						  $consulta = "SELECT * FROM relaciones WHERE lote_ventana = $row[LOTE_A]";
						  //echo $consulta."<br>";
						  include("../principal/conectar_sea_web.php");
						  $rs2 = mysqli_query($link, $consulta);
						  if ($row2 = mysqli_fetch_array($rs2))
						  {
							   $producto = $row2[cod_origen];
							   $hornada = $row2[hornada_ventana];		 
							   $lote_origen = $row2[lote_origen];
							   $marca = $row2['marca'];		 
						  } 
						  else 
						  {
							   $producto = '';
							   $hornada = '';		 
							   $lote_origen = '';
							   $marca = '';		                      
						  }	
						  if($hornada != '')
						  {
							   /*$unidades = '';
							   $consulta_u = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso, SUM(peso_origen) AS peso_origen FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento ='$row["fecha"]' AND hornada = $hornada";
							   include("../principal/conectar_sea_web.php"); 
							   $result_u = mysqli_query($link, $consulta_u);
							   if ($row_u = mysqli_fetch_array($result_u))
							   {
									$unidades = $row_u[unid];
									$peso = $row_u["peso"];
									//$peso_origen = $row_u[peso_origen];
									// if($peso_origen == '')
									//	$peso_origen = 0;
							   }*/
							   $Consulta="SELECT peso_neto,observacion from sipa_web.recepciones where lote='$lote_ventana' and recargo='$recargo'";
							   $RespUnid=mysqli_query($link, $Consulta);
							   if($FilaUnid=mysqli_fetch_array($RespUnid))
							   {
   									$unidades =intval($FilaUnid["observacion"]);
									$peso = $FilaUnid["peso_neto"];
									//$PesoRecep=$FilaUnid["peso_neto"];
							   }
						  } 
						  else 
						  {
								$unidades = '';
								$peso_origen = 0;
						  }
					 }	
				}			
				echo'<tr> ';
				echo'<input name="a['.$i.']" type="hidden" size="8">';
				echo'<input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$lote_ventana.'">';
				echo'<input name="producto['.$i.']" type="hidden" size="8" value="'.$producto.'">';
				echo'<input name="FechaRec['.$i.']" type="hidden" size="8" value="'.$FechaRec.'">';
				echo'<td><input name="guia['.$i.']" type="hidden" size="8" value="'.$Guia.'">'.$FechaRec.'</td>';
				echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$row[LOTE_A].'">'.$row[LOTE_A].'</div></td>';
				echo'<td><div align="center"><input name="recargo['.$i.']" type="hidden" size="8" value="'.$recargo.'">'.$recargo.'</div></td>';
				echo'<input name="peso_ant['.$i.']" type="hidden" size="7" value="'.number_format($peso,0,'','').'">';
				echo'<td><div align="center"><input name="peso_recepcion['.$i.']" type="text" value="'.$peso_recepcion.'" size="8" readonly></div></td>';
				echo'<input name="hornada_aux['.$i.']" type="hidden" size="5" value="'.$hornada.'">';
				echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="5" value="'.substr($hornada,6,6).'" readonly></div></td>';
				echo'<td><div align="center"><input name="peso_origen['.$i.']" type="text" value="'.$peso_origen.'" size="8" readonly></div></td>';
				echo'<input name="unidades_ant['.$i.']" type="hidden" size="5" value="'.$unidades.'">';
				echo'<td align="center"><input name="unidades['.$i.']" type="text" size="5" value="'.$unidades.'" onblur=CalculaPeso('.$PesoPieza.',this,'.$NumElemt.','.$Unid.','.$UnidRecep.','.$peso_origen.','.$PesoRecep.','.intval($unidades).','.intval($peso_recepcion).')></td>';
				//echo'<td><div align="center"><input name="unidades['.$i.']" type="text" size="5" value="'.$unidades.'"></div></td>';					
				echo'<td><div align="center"><input name="lote_origen['.$i.']" type="hidden" size="8" value="'.$lote_origen.'">&nbsp;'.$lote_origen.'</div></td>';
				echo'<td><div align="center"><input name="marca['.$i.']" type="hidden" size="8" value="'.$marca.'">&nbsp;'.$marca.'</div>';
				echo'<td>'.$Unid.'</td>';
				echo'<td align="right">'.$PesoRecep.'</td>';
				echo'<td align="right">'.$unidades.'</td>';
				echo'<td align="center"><input type="checkbox" name="CheckCerra" onclick=CerraRecep(this,"'.$producto.'","'.$lote_ventana.'")></td>';
				echo'</td>
				 </tr>';
				$Total_peso = $Total_peso + $peso_recepcion; 
				$Total_origen = $Total_origen + $peso_origen; 
				$Total_unid = $Total_unid + $unidades;					
				$NumElemt=$NumElemt+17;	
			}
				echo'<tr class="Detalle02">';
				echo'<td colspan="5">Totales</td>';
				echo'<td align="center">&nbsp;'.$Total_origen.'</td>';
				echo'<td align="center">&nbsp;</td>';
				echo'<td align="center" colspan="3">&nbsp;</td>';
				echo'<td align="right">'.$Total_peso.'</td>';
				echo'<td align="right">'.$Total_unid.'</td>';
				echo'<td align="center">&nbsp;</td>';
				echo'</tr>';
	}			
 }  
?>

        </table>
		<br>
        <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="766"><div align="center"><font color="#000000" size="2">&nbsp; 
                <?php
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades == '' && $codigo != "B" && $Est=='A')
					echo'<input name="grabar" type="button" style="width:70" value="Grabar" onClick="Guardar_Datos();">';
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades == '' && $codigo == "B")
					echo'<input name="grabar2" type="button" style="width:70" value="Grabar" onClick="Guardar_Datos2(this.form,'.($cont).');">';
				 //if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades != '')
				//	echo'<input name="modificar" type="button" style="width:70" value="Modificar" onClick="Modificar_Datos();">';
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
