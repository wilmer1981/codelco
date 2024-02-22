<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 20;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$FechaProgramada=$Datos2[0];
		$CodNave=$Datos2[1];
		$NombreNave=$Datos2[2];
		$CodAgAduanero=$Datos2[3];
		$CodAgEstiva=$Datos2[4];
		$FechaSantiago=$Datos2[5];
		$FechaEmbarqueVen=$Datos2[6];
		$Consulta="select nombre from sec_web.prestador where cod_prestador_servicio='".$CodAgAduanero."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAgAduanero=$Fila["nombre"];
		$Consulta="select nombre from sec_web.prestador where cod_prestador_servicio='".$CodAgEstiva."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAgEstiva=$Fila["nombre"];
	}		
if (!isset($CmbAno))
{
	$CmbAno=date('Y');
}
if (!isset($CmbMes))
{
	$CmbMes=date('n');
}
?>
<html>
<head>
<script language="JavaScript">
function Recuperar(T)
{
	var Frm=document.FrmConfirmacion;
	var Valores="";
	var Encontro=false;
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		
		if (Frm.OptSeleccionar[i].checked)
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
			Encontro=true;
		}
	}
	if(Encontro==true)
	{ 
		Valores=Valores.substr(0,Valores.length-2);
		window.open("sec_confirmacion_num_envio_codelco_proceso.php?Valores="+Valores+"&Tipo="+T,"","top=195,left=180,fullscreen=no,width=450,height=220,scrollbars=yes,resizable = yes");
	}
	else
	{
		alert("Debe Seleccionar un Elemento");
	}
}	

function Salir()
{
	var Frm=document.FrmConfirmacion;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
}
function Fax(T)
{
	var Frm=document.FrmConfirmacion;
	var Tipo=T;
	ValoresCheck=RecuperarFax();
	if (ValoresCheck!="")
	{
		ValoresCheck=ValoresCheck.substr(0,ValoresCheck.length-2);
		Frm.target="_blank";
		Frm.action="sec_con_fax_codelco.php?ValoresCheck="+ValoresCheck+"&Tipo="+Tipo;
		Frm.submit();
		Frm.target="_parent";
		//window.open("sec_con_fax_codelco.php?ValoresCheck="+ValoresCheck+"&Tipo="+Tipo,"","top=50,left=50,fullscreen=no,width=760,height=600,scrollbars=yes,resizable = yes");
	}
}
function RecuperarFax()
{
	var Frm=document.FrmConfirmacion;
	var Valores="";
	var Encontro=false;
	var cont=0;
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		
		if (Frm.OptSeleccionar[i].checked)
		{
			Valores=Valores + Frm.FaxO[i].value +"//";
			Encontro=true;
			cont++;
		}
	}
	if(Encontro==true)
	{
		//alert(Valores);
		return(Valores);
	}
	else
	{
		alert("Debe Seleccionar un Elemento");
		return(Valores);
	}
}
function Recarga()
{
	var Frm=document.FrmConfirmacion;
	var Tipo="";
	if(Frm.radio[0].checked)
	{
		Tipo="ConEnvio";
	
	}
	else
	{
		Tipo="SinEnvio";
	
	}
	Frm.action= "sec_confirmacion_num_envio_codelco.php?Tipo="+Tipo;
	Frm.submit();
}


function EliminarEnvio(T)
{
	var Frm=document.FrmConfirmacion;
	var Valores="";
	var Encontro=false;
	var mensaje = confirm("�Seguro que desea Quitar la Relacion Envio - Inst.Embarque ? ");
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.OptSeleccionar[i].checked)
		{
			Valores=Valores + Frm.NumEnvioO[i].value +"//";
			Encontro=true;
		}
	}
	if (Encontro==true)
	{
		Valores=Valores.substr(0,Valores.length-2);
		if (Valores=="")
		{
			alert("Esta Inst.Embarque no tiene Num.Envio ");
		}
		else
		{
			if (mensaje==true)
			{
				Frm.action="sec_confirmacion_num_envio_codelco01.php?Valores="+Valores+"&Tipo="+T+"&Proceso=E";
				Frm.submit();
			}
			else
			{
				return;
			}
		}
	}
	else
	{
		alert("Debe Seleccionar un Elemento");
	}
}
function Asignar(T)
{
	var Frm=document.FrmConfirmacion;
	var Valores="";
	var Encontro=false;
	var cont=0;
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		
		if (Frm.OptSeleccionar[i].checked)
		{
			Valores=Valores + Frm.CodelcoO[i].value +"//";
			Encontro=true;
			cont++;
		}
	}
	if(Encontro==true)
	{ 
		if (cont==1)
		{
			Valores=Valores.substr(0,Valores.length-2);
			window.open("sec_confirmacion_asignar_num_envio_codelco.php?Valores="+Valores+"&Tipo="+T,"","top=195,left=180,fullscreen=no,width=450,height=220,scrollbars=yes,resizable = yes");
		}
		else
		{
			alert("Debe Seleccionar solo un elemento");
		}
	}
	else
	{
		alert("Debe Seleccionar un Elemento");
	}
}		

function MostrarPaquetes(cod_bulto,num_bulto,ie,fecha)
{


	window.open("sec_paquetes_series.php?CodBulto="+cod_bulto+"&NumBulto="+num_bulto+"&IE="+ie+"&fecha="+fecha,"","top=110,left=3,width=770,height=340,scrollbars=no,resizable = yes");
}

function Imprimir(opt)
{
	var f=document.FrmConfirmacion;
	switch (opt)
	{
		case "W":
			window.open("sec_confirmacion_num_envio_codelco_imp_web.php", "","menubar=no resizable=yes Top=30 Left=50 width=670 height=500 scrollbars=yes");
			 break;
	}
}

</script>
<title>Confirmacion - Codelco</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body>
<form name="FrmConfirmacion" method="post" action="">
 <?php include("../principal/encabezado.php")?>
  <table width="770" height="350" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
  <tr> 
	  <td align="center"><br>
      <div style="position:absolute; left: 8px; top: 77px; width: 764px; height: 36px; OVERFLOW: auto;" id="div2"> 
    <table width="730" border="0">
      <tr> 
        <td width="354" align="center"> ConEnvio 
		<?php
		if ($Tipo=="ConEnvio")
		{	
			echo "<input name='radio' type='radio'  value='ConEnvio' onClick='Recarga();' checked>";
	    	echo"<select name='CmbMes'  onChange='Recarga();' >";
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
			echo "<select name='CmbAno' onChange='Recarga();'>";
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
			echo "</select>&nbsp;<input name='BtnFax' type='button' style='width:90' value='Fax' onClick=\"Fax('$Tipo');\">";
		}
		else
		{
				echo "<input name='radio' type='radio'  value='ConEnvio' onClick='Recarga();' >";
		}
		?>
		</td>
        <td width="366" align="center">
<?php
		if ($Tipo=="SinEnvio")
			echo "<input name='radio' type='radio'  value='SinEnvio' onClick='Recarga();' checked>";
			else
				echo "<input name='radio' type='radio'  value='SinEnvio' onClick='Recarga();'>";
        ?>		  
Sin Envio </td>
      </tr>
    </table>
  </div>
	 
	    <br>
	   <div style="position:absolute; left: 8px; top: 123px; width: 765px; height: 250px; OVERFLOW: auto;" id="div2"> 
          <table width="750px" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width='11' align="center">&nbsp;</td>
              <td width='50' align="center">Ins.Emb</td>
              <td width='40' align="right">N&deg; Envio</td>
              <td width='100' align="center"><div align="center">Cliente</div></td>
              <td width='70' align="center">Lote</td>
              <td width='40' align="left"><div align="left">Cant.P  </div></td>
              <td width='50' align="center"><div align="center">Peso</div></td>
              <td width='135' align="center">Marca</td>
              <td width='80' align="center">Fecha.Prog</td>
			  <td width='50' align="center">Estado</td>
			  <td width='49' align="center">Embarque</td>
            </tr>
          </table>
        </div>
		<div style="position:absolute; left: 4px; top: 160px; width: 765px; height: 199px; OVERFLOW: auto;" id="div2"> 
          <?php
			echo "<table width='740' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			//CONSULTA TABLA PROGRAMA ENAMI
			if($Tipo=="ConEnvio")
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$Fecha_Envio=$CmbAno."-".$CmbMes;
				$Consulta=" select distinct t1.corr_codelco,t1.cod_cliente,t2.sigla_cliente,t4.num_envio,t4.tipo_embarque,t1.fecha_programacion,t5.cod_via_transporte,    ";
				$Consulta.=" t1.fecha_disponible,t1.fecha_programacion,t1.cod_producto,t1.cod_subproducto,t2.sigla_cliente as nombre,t5.nombre_nave as nombre	";
				$Consulta.=" from sec_web.programa_codelco t1";
				$Consulta.=" left join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente ";
				$Consulta.=" inner join sec_web.lote_catodo t3 on t1.corr_codelco=t3.corr_enm	";
				$Consulta.=" inner join sec_web.embarque_ventana t4 on t1.corr_codelco=t4.corr_enm 			";
				$Consulta.=" left join sec_web.nave t5 on t1.cod_cliente=t5.cod_nave 			";
				$Consulta.=" where (t1.estado2 <> 'A')  and (not isnull(t1.num_prog_loteo)) ";
				//$Consulta.=" and left(t3.disponibilidad,1)='E' and substring(t4.fecha_envio,1,7) ='".$Fecha_Envio."'   order by t1.corr_codelco,t4.num_envio";
				$Consulta.=" and t3.disponibilidad='T' and substring(t4.fecha_envio,1,7) ='".$Fecha_Envio."'   order by t4.num_envio desc,t1.corr_codelco";				
			}
			else
			{
				$Consulta=" select distinct t1.corr_codelco,t1.cod_cliente,t2.sigla_cliente as nombre,t5.nombre_nave as nombre,t4.num_envio,t1.fecha_programacion,    ";
				$Consulta.=" t1.fecha_disponible,t1.fecha_programacion,t1.cod_producto,t1.cod_subproducto,t4.tipo_embarque		";
				$Consulta.=" from sec_web.programa_codelco t1";
				$Consulta.=" left join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente ";
				$Consulta.=" inner join sec_web.lote_catodo t3 on t1.corr_codelco=t3.corr_enm	";
				$Consulta.=" left join sec_web.embarque_ventana t4 on t1.corr_codelco=t4.corr_enm 			";
				$Consulta.=" left join sec_web.nave t5 on t1.cod_cliente=t5.cod_nave 			";
				$Consulta.=" where (t1.estado2 <> 'A')  and (not isnull(t1.num_prog_loteo)) ";
				//$Consulta.=" and left(t3.disponibilidad,1)='E' and  isnull(t4.corr_enm) order by t1.corr_codelco,t4.num_envio";
				$Consulta.=" and t3.disponibilidad='T' and  isnull(t4.corr_enm) order by t1.corr_codelco,t4.num_envio";			
				//echo $Consulta;
				}
			$Respuesta=mysqli_query($link, $Consulta);
			//echo "CCC".$Consulta;
			echo "<input type='hidden' name='OptSeleccionar'><input type='hidden' name='NumEnvioO'><input type='hidden' name='CodelcoO'><input type='hidden' name='FaxO'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Consulta="select t1.disponibilidad, t1.cod_estado, t3.descripcion as marca, t1.cod_bulto, t1.num_bulto, t1.cod_marca, ";
				$Consulta.=" sum(t2.peso_paquetes) as peso_preparado, sum(t1.num_paquete) as unidades, t1.fecha_creacion_lote as fecha  from sec_web.lote_catodo t1";
				$Consulta.="  inner join sec_web.paquete_catodo t2 on ";
				$Consulta=$Consulta." t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
				$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca = t3.cod_marca ";
				if($Tipo=="ConEnvio")
				{
					$Consulta=$Consulta." where t1.corr_enm='".$Fila["corr_codelco"]."'  and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete group by t1.corr_enm";
				}
				else
				{
					$Consulta=$Consulta." where t1.corr_enm='".$Fila["corr_codelco"]."' and t1.cod_estado='a' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_estado = t2.cod_estado  group by t1.corr_enm";
				}	
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$Consulta="select count(*) as cantpaquetes from sec_web.lote_catodo";
				if($Tipo=="ConEnvio")
				{
					$Consulta=$Consulta." where corr_enm=".$Fila["corr_codelco"];
				}
				else
				{
					$Consulta=$Consulta." where corr_enm=".$Fila["corr_codelco"]." and cod_estado='a'";
				}	
				$Respuesta3=mysqli_query($link, $Consulta);
				//echo "CC".$Consulta;
				$Fila3=mysqli_fetch_array($Respuesta3);
				$MostrarBoton=true;
				echo "<tr>"; 
				
				$Cont2++;
				$Campos=$Fila["corr_codelco"]."~~".$Fila2["cod_bulto"]."~~".$Fila2["num_bulto"]."~~".$Fila["fecha_programacion"]."~~";
				$Campos=$Campos.$Fila["fecha_disponible"]."~~".$Fila2["peso_preparado"]."~~".$Fila3["cantpaquetes"]."~~";
				$Campos=$Campos.$Fila2["cod_marca"]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["cod_cliente"];
				
				echo "<td width='14'align='center'><input type='checkbox' name='OptSeleccionar' value='".$Campos."'><input type='hidden' name='NumEnvioO' value='".$Fila["num_envio"]."~".$Fila["corr_codelco"]."'><input type='hidden' name='CodelcoO' value='".$Fila["corr_codelco"]."'><input type='hidden' name='FaxO' value='".$Fila["corr_codelco"]."~~".$Fila["cod_via_transporte"]."~~".$Fila["num_envio"]."'></td>"; 
				echo "<td width='66' align='right'>".$Fila["corr_codelco"]."&nbsp;</td>";
				echo "<td width='59' align='right'>".$Fila["num_envio"]."&nbsp;</td>";
				echo "<td width='85'>".$Fila["nombre"]."&nbsp;</td>";
				//echo "FF".$Fila2[fecha_creacion_paquete];
				
				echo "<td width='70' align='right'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila["corr_codelco"]."','".$Fila2["fecha"]."')\">\n";
				echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a>&nbsp;</td>";
				echo "<td width='30' align='right'>".$Fila3["cantpaquetes"]."&nbsp;</td>";
				echo "<td width='50' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
				echo "<td width='144' align='left'>".$Fila2["marca"]."&nbsp;</td>";
				echo "<td width='80' align='left'>".$Fila["fecha_programacion"]."&nbsp;</td>";
				
				if ($Fila2["cod_estado"]=='a')
					$Estado="Abierto";
				else
					$Estado="Cerrado";
				echo "<td width='50' align='left'>".$Estado."&nbsp;</td>";
				if ($Fila["tipo_embarque"]=="T")
					$TipoEmbarque="Terrestre";
				if ($Fila["tipo_embarque"]=="A")
					$TipoEmbarque="Acopio";	
				if ($Fila["tipo_embarque"]=="E")
					$TipoEmbarque="Estiba";	
				echo "<td width='49' align='center'>".$TipoEmbarque."&nbsp;</td>";
				echo "</tr>";
			}
			echo "</table>";	
		?>
        </div>
        <br>
		<div style="position:absolute; left: 8px; top: 370px; width: 764px; height: 250px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center"> 
			  <?php	
				if ($Tipo=="SinEnvio")
				{
			  		echo "<input name='BtnEnvio' type='button' style='width:90' onClick=\"Recuperar('$Tipo');\" value='N&ordm; Envio'>";
                	echo "<input name='BtnAsignar' type='button' style='width:90' onClick=\"Asignar('$Tipo');\" value='Asignar'>";
				}
				else
				{
					
					echo "<input name='BtnEliminar' type='button' style='width:90' value='Eliminar' onClick=\"EliminarEnvio('$Tipo');\">";
                }
			   ?>
			    <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:90" onClick="Imprimir('W');" value="Imprimir">
			    <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">			</td>
          </tr>
        </table></div><br></td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php")?>
 

</form>
</body>
</html>
<?php
	if ($Mensaje!="")
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
?>
		
