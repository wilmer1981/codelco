<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 29;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	//$Mensaje   = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Traspasado   = isset($_REQUEST["Traspasado"])?$_REQUEST["Traspasado"]:"N";
	
	$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date('d');
	$CmbMes  = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno  = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');

	/*
	if (!isset($Traspasado))
	{
		$Traspasado='N';
	}
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	if (!isset($CmbDias))
	{
		$CmbDias=date('d');
	}
	*/
    $FechaMenos = $CmbAno - 1;
    

?>
<html>
<head>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function MostrarPaquetes(cod_bulto,num_bulto,ie)
{
	window.open("sec_paquetes_series.php?CodBulto="+cod_bulto+"&NumBulto="+num_bulto+"&IE="+ie,"","top=110,left=3,width=770,height=340,scrollbars=no,resizable = yes");
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function RecuperarValores()
{
	var Frm=document.FrmVerificar;
	var Valores=new String();
	
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.OptSeleccionar[i].checked==true)
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
		}
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 
function Recarga()
{
	var Frm=document.FrmVerificar;
	var Traspasado="";
	
	if (Frm.OpcTraspasado[0].checked)
	{
		Traspasado="N";
	}
	if (Frm.OpcTraspasado[1].checked)
	{
		Traspasado="S";
	}
	Frm.action="sec_verificar_traspaso_ie.php?Traspasado="+Traspasado;
	Frm.submit();
	
}

function Traspasar()
{
	var Frm=document.FrmVerificar;
	var Valores="";

	Valores=RecuperarValores();
	if (Valores!='')
	{
		if (confirm("Esta Seguro de Traspasar los Datos"))
		{
			Frm.action="sec_verificar_traspaso_ie01.php?Valores="+Valores;
			Frm.submit();
			
		}
	}		
}
function Salir()
{
	var Frm=document.FrmVerificar;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}
</script>
<title>Verificar Traspaso Santiago</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmVerificar" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="365" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
    <tr>
      <td align="center"><br>
	  <div style="position:absolute; left: 15px; top: 55px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0">
	  <tr>  
	  <?php
	  		$sinmarca='Sin Marca';
			switch ($Traspasado)
			{
				case "N":
					echo "<td>No Traspasada<input type='radio' name='OpcTraspasado' value='' onclick='Recarga()' checked>&nbsp;";
					echo "<td>Traspasada<input type='radio' name='OpcTraspasado' value='' onclick='Recarga()'><td>";								
					break;
				case "S":
					echo "<td>No Traspasada<input type='radio' name='OpcTraspasado' value='' onclick='Recarga()'></td>";		
					echo "<td>Traspasada<input type='radio' name='OpcTraspasado' value='' onclick='Recarga()' checked>&nbsp;&nbsp;";	
					echo "<select name='CmbDias' onchange='Recarga()'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDias))
						{
							if ($i==$CmbDias)
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}
						else
						{
							if ($i==date("j"))
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}	
					}
					echo"</select>";
					echo"<select name='CmbMes' onchange='Recarga()'>";
					for($i=1;$i<13;$i++)
					{
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
					}
					echo "</select>";
					echo "<select name='CmbAno' onchange='Recarga()'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAno))
						{
							if ($i==$CmbAno)
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}		
					}
					echo "</select></td>";			
					break;
			}
	  ?>
	  </tr>
	  </table></div><br>	  
	  <div style="position:absolute; left: 15px; top: 85px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2"> 
          <table width="740" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="10" align="center"></td>
              <td width='20' align="center">Prog.N�</td>
              <td width='55' align="center">I.E</td>
              <td width='90' align="center">Nave/Cliente</td>
              <td width='60' align="center">Fecha Emb</td>
              <td width='70' align="center">Peso Prog.</td>
              <td width='60' align="center">Peso Prep.</td>
              <td width='50' align="center">Dif.</td>
              <td width='40' align="center">N� Lote</td>
              <td width="10" align="center">Paq.</td>
              <td width="60" align="center">Marca</td>
              <td width="20" align="center">Est</td>
            </tr>
          </table>
        </div>
		<div style="position:absolute; left: 15px; top: 104px; width: 750px; height: 278px; OVERFLOW: auto;" id="div2"> 
          <?php
			echo "<table width='740' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$CrearTmp ="CREATE temporary table if not exists sec_web.tmpprograma "; 
			$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
			$CrearTmp =$CrearTmp."cantidad_programada double,num_prog_loteo varchar(3),producto varchar(30),";
			$CrearTmp =$CrearTmp."subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
			$CrearTmp =$CrearTmp."tipo char(1),cod_contrato varchar(10),estado char(1),estado2 char(1),estado3 char(1),fecha_disponible date,fecha_confirmacion datetime)";
			mysqli_query($link, $CrearTmp);
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta="SELECT t1.fecha_confirmacion,t1.fecha_disponible,t1.estado3,t1.estado2,t1.estado1,t6.descripcion as producto,t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,t5.sigla_cliente,";
			$Consulta=$Consulta."t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.num_prog_loteo";
			$Consulta=$Consulta." from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta=$Consulta." where ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo))and(t1.tipo<>'V'))";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,producto,subproducto,pto_destino ,pto_emb,tipo,estado,estado2,estado3,fecha_disponible,fecha_confirmacion) values(";
				$Insertar=$Insertar." '".$Fila["corr_enm"]."','".$Fila["sigla_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["producto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["estado3"]."','".$Fila["fecha_disponible"]."','".$Fila["fecha_confirmacion"]."')";
				mysqli_query($link, $Insertar);
			}
			//CONSULTA TABLA PROGRAMA CODELCO
			$Consulta="SELECT t1.fecha_confirmacion,t1.fecha_disponible,t1.estado1,t1.estado2,t1.estado3,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada,t1.num_prog_loteo";
			$Consulta=$Consulta." from sec_web.programa_codelco  t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
			$Consulta=$Consulta." where ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";

             //echo "CC".$Consulta;
			$Resultado=mysqli_query($link, $Consulta);

			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,producto,subproducto,tipo,estado,estado2,estado3,fecha_disponible,fecha_confirmacion) values(";
				$Insertar=$Insertar." '".$Fila["corr_codelco"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_programada"]."','".$Fila["num_prog_loteo"]."','".$Fila["producto"]."','".$Fila["subproducto"]."','C','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["estado3"]."','".$Fila["fecha_disponible"]."','".$Fila["fecha_confirmacion"]."')";

    //
                 // echo "UINSERT".$Insertar;
				mysqli_query($link, $Insertar);
			}

			switch ($Traspasado)
			{
				case "N":
					$Consulta="SELECT * from sec_web.tmpprograma where estado2='R' and (estado='T' or estado='C') and estado3='' order by fecha_disponible ";
     //echo "tmp".$Consulta;
					break;
				case "S":
					if (strlen($CmbMes)==1)
					{
						$CmbMes="0".$CmbMes;
					}
					if (strlen($CmbDias)==1)
					{
						$CmbDias="0".$CmbDias;
					}
					$FechaConfirmadoDesde=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:00";
					$FechaConfirmadoHasta=$CmbAno."-".$CmbMes."-".$CmbDias." 23:59:59";
					$Consulta="SELECT * from sec_web.tmpprograma where estado2='R' and (estado3='L' or estado3='C') and fecha_confirmacion between '$FechaConfirmadoDesde' and '$FechaConfirmadoHasta' order by fecha_disponible ";
					break;
			}
			$Respuesta=mysqli_query($link, $Consulta);

			echo "<input type='hidden' name='OptSeleccionar'><input type='hidden' name='TxtDisp' >";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($Fila["estado"]=='A')
				{
					echo "<tr class='colortabla04'>"; 
				}
				else
				{
					if ($Fila["estado"]=='M')
					{
						echo "<tr class='colortabla03'>";
					}	 							
					else
					{					
						echo "<tr>";
					}	 
				}
				$Consulta="SELECT t2.fecha_creacion_paquete,t1.disponibilidad,t3.descripcion as marca,t1.cod_bulto,t1.num_bulto,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
				$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete and t1.cod_estado=t2.cod_estado";
				$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
                //poly 23-05-2008 buscar año - 1 para que tome lotes del año anteriror  que no se han traspasado
				//$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and (year(t1.fecha_creacion_lote) >=".$CmbAno." or (year(t1.fecha_creacion_lote) -1))";
    
               $Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and (year(t1.fecha_creacion_lote) >=".$CmbAno." or (year(t1.fecha_creacion_lote) = ".$FechaMenos."))";
    
                $Consulta=$Consulta." and t1.disponibilidad='T' and t2.fecha_creacion_paquete = t1.fecha_creacion_paquete group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";

                 // echo $Consulta;
				$Respuesta2=mysqli_query($link, $Consulta);
				$MostrarBoton=true;
				
				while ($Fila2=mysqli_fetch_array($Respuesta2)) 
				{
					$Consulta="SELECT count(*) as cantpaquetes from sec_web.lote_catodo";
					$Consulta=$Consulta." where cod_bulto='".$Fila2["cod_bulto"]."' and num_bulto=".$Fila2["num_bulto"]." and corr_enm=".$Fila["corr_ie"];
					$Respuesta3=mysqli_query($link, $Consulta);
					$Fila3=mysqli_fetch_array($Respuesta3);
					$Cont2++;
					
					echo "<td width='10' align='center'><input type='checkbox' name='OptSeleccionar' value='".$Fila["corr_ie"]."~~".$Fila["tipo"]."'></td>";
					echo "<td width='40' align='center'>".$Fila["num_prog_loteo"]."</td>";
					echo "<td width='55'  onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
					echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
					echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$Fila["producto"]."&nbsp;<b>Sub-Producto:&nbsp;</b>".$Fila["subproducto"]." </font><br>";
					echo "<font face='courier' color='#000000' size=1><b>Puerto Embarque: </b>".$Fila["pto_emb"]."&nbsp;<b>Puerto Destino: </b>".$Fila["pto_destino"]."&nbsp;<b>Marca: </b>".$Fila2["marca"]."</font><br>";
					echo "<font face='courier' color='#000000' size=1><b>Fecha Confirmacion:&nbsp;</b>".$Fila["fecha_confirmacion"]."</font><br>";
					echo "</div>".$Fila["corr_ie"]."</td>";
					echo "<td width='100'>".$Fila["cliente_nave"]."&nbsp;</td>";
					echo "<td width='80' align='center'>".$Fila["fecha_disponible"]."</td>";
					echo "<td width='80' align='right'>".($Fila["cantidad_programada"]*1000)."</td>";
					echo "<td width='70' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
					echo "<td width='60' align='right'>".abs($Fila["cantidad_programada"]*1000-$Fila2["peso_preparado"])."&nbsp;</td>";
					echo "<td width='60' align='right'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila["corr_ie"]."')\">\n";
					echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";
					//echo "<td width='80' align='right'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."&nbsp;</td>";
					echo "<td width='20' align='center'>".$Fila3["cantpaquetes"]."&nbsp;</td>";
					
					echo "<td width='30' align='center'>".$Fila2["marca"]."&nbsp;</td>";
					if ($Fila["estado3"]=='L')
					{
						echo "<td width='30' align='center'><img src='../principal/imagenes/ico_ok.gif'></td>";
					}
					else
					{
						echo "<td width='30' align='center'>&nbsp;</td>";
					}
				}
				echo "</tr>";
			}
			echo "</table>";	
		?>
        </div>
        <br>
		<div style="position:absolute; left: 16px; top: 387px; width: 750px; height: 40px; OVERFLOW: auto;" id="div2"> 
          <table width="731" border="0" class="tablainterior">
          <tr>
              <td width="722" align="center">
			  <?php
				switch ($Traspasado)
				{
					case "N":
						echo "<input type='button' name='BtnGrabar' value='Traspasar' style='width:90' onClick='Traspasar();'>";
						break;
				}			  
			  ?>
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
			</td>
          </tr>
        </table></div><br></td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if (isset($EncontroRelacion))
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
?>
