<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 85;
$Recargo='0';

if(isset($_REQUEST["p"])) {
	$p = $_REQUEST["p"];
}else{
	$p = "";
}
if(isset($_REQUEST["g"])) {
	$g = $_REQUEST["g"];
}else{
	$g = "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}

?>
<html>
<head>
<title>Traspaso Leyes desde Excel</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--LAYERS
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false

function muestra(numero) 
{
	//alert(numero);
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 130 ");
			//eval("Txt" + numero + ".style.top = document.checkTodos.top ");
			//eval("Txt" + numero + ".style.top = window.event.y ");
		}
	}
}

function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

// FIN LAYERS-->
function Proceso(Opcion)
{
	var frm=document.FrmTraspasoExcel;
	switch (Opcion)
	{
		case "P":
				if(frm.Archivo.value=='')
				{
					alert('Debe Seleccionar Documento')
					frm.Archivo.focus();
					return;
				}
				if(frm.Archivo.value.substring(frm.Archivo.value.lastIndexOf('.')+1)!='xls')
				{
					alert('La extension debe ser .xls')
					frm.Archivo.focus();
					return;
				}
				//if(frm.Archivo.value.lastIndexOf())				
				frm.action='cal_traspaso_leyes_excel_generica01.php?Opcion=P';
				frm.submit();
		break;
		case "G": 
			Datos=Recuperar(frm.name,'CheckSol');
			frm.Datos.value=Datos;
			if(Datos!='')
			{
				if(confirm("¿Esta seguro de cargar los datos seleccionados?"))
				{	
					frm.action='cal_traspaso_leyes_excel_generica01.php?Opcion=GE';
					frm.submit();
				}
				
			}
			else
			{
				alert("Debe Seleccionar Solicitud a traspasar ")	
			}
		break;	
		case "D":
			ValidarDetalle();
			break;			
		case "E":
			ValidarCambiarEstado();
			break;
		case "S":
	 		frm.action="../principal/sistemas_usuario.php?CodSistema=1";
			frm.submit();
		break;	 
	}	

}
function CheckearTodo(f,nomchk,nomchkT)
{
	var Check=new Object();
	var CheckT=new Object();
	
	try
	{
		eval("document."+f.name+"."+nomchk+"[0]");
		Check=eval("document."+f.name+"."+nomchk);
		CheckT=eval("document."+f.name+"."+nomchkT);
		for (i=1;i<Check.length;i++)
		{
			if (CheckT.checked==true){
				if(Check[i].disabled==false)
					Check[i].checked=true;
			}
			else{
				if(Check[i].disabled==false)
					Check[i].checked=false;
			}
		}
	}
	catch (e)
	{
	}
}
function Recuperar(f,inputchk)
{
	var Valores="";
	var Encontro=false;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
				Encontro=true;
			
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
var msj='<?php echo $g;?>'
if(msj=='s')
   alert('Solicitudes Guardadas con exito.');
</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmTraspasoExcel" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="756" align="center" valign="top"><table width="761" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
          <tr bgcolor="#FFFFFF"> 
            <td width="90">Usuario:</td>
            <td width="270">
              <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
			}
		  ?>
            </td>
            <td width="117">Fecha:</td>
            <td width="247"> 
           <?php 
		    echo $Fecha_Hora; 
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
		   ?>
              </strong></font></font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
            <td colspan="3"><input type="file" id="Archivo" name="Archivo" size="40" style="height:19;">&nbsp;<input name="BtnProcesar" type="button" id="BtnProcesar" value="Procesar" style="width:80" onClick="Proceso('P');">
            </td>
            <td>
            <input name="BtnProcesar" type="button" id="BtnProcesar" value="Guardar" style="width:80" onClick="Proceso('G');">
             <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:80" onClick="Proceso('S');"></td>
          </tr>
          </table>
          <table width="761" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
          <tr>
          <td bgcolor="#CCCCCC">
          <div style="height:10; width:10; background:#FF9191"></div>No existe Nº Solicitud con Recargo 0 en Sistema.
          </td>
          <td bgcolor="#CCCCCC">
          <div style="height:10; width:10; background:#FF0000"></div>Ley no Existe en Sistema.
          </td>
          <td bgcolor="#CCCCCC" colspan="2">
          <div style="height:10; width:10; background:#FFFF9F"></div>Solicitud no se encuentra: Enviada a laboratorio, at. quimico o finalizada.
          </td>
          </tr>
        </table>
        <br>        
        <table width="760" border="0" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaDetalle" >
          <tr align="center" class="ColorTabla01">
            <td width="38" height="34">Todos<br>
                <input name="ChkTodos" type="checkbox" onClick="CheckearTodo(this.form,'CheckSol','ChkTodos');" value="checkbox">
                <input name="CheckSol" type="hidden">                
                </td>                
	            <?php
				if($p=='s')
				{
					?>
					<td>SA</td>                       
					<?php
					$Consulta2 = "select t2.abreviatura,t1.cod_leyes from cal_web.tmp_leyes_generica t1 
					left join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes where run_registro='".$CookieRut."'  group by t1.cod_leyes order by ceiling(orden) asc";
					$Respuesta2 = mysqli_query($link, $Consulta2);
					while($Row2 = mysqli_fetch_array($Respuesta2))
					{
						if($Row2["abreviatura"]=='')
							$Row2["abreviatura"]=$Row2["cod_leyes"];
						?>
						<td><?php echo $Row2["abreviatura"];?></td>                       
						<td>Uni.</td>                       
						<?php
					}
					?>
                    </tr>
                    <?php
					
					$Consulta = "select nro_solicitud,existe from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."' group by nro_solicitud";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);$Cont2=0;
					while($Row = mysqli_fetch_array($Respuesta))
					{
						$Color="#FF8080";
						if($Row["existe"]=='S')
							$Color="#CCCCCC";
						$Consulta2 = "select cod_unidad,avg(valor) as valor,cod_leyes from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."' and nro_solicitud='".$Row["nro_solicitud"]."' group by nro_solicitud,cod_leyes order by ceiling(orden) asc";
						$Respuesta2 = mysqli_query($link, $Consulta2);$LeyExiste="S";
						while($Row2 = mysqli_fetch_array($Respuesta2))
						{
							$Consulta23 = "select abreviatura from  
							 proyecto_modernizacion.leyes where cod_leyes='".$Row2["cod_leyes"]."' group by cod_leyes";							 
							$Respuesta23 = mysqli_query($link, $Consulta23);
							if(!$Row23 = mysqli_fetch_array($Respuesta23))
							{
								$LeyExiste="N";
								//echo $Row2["cod_leyes"]."   l    ";
							}
							if($Row2["cod_unidad"]!='')
							{
								$Consulta23 = "select abreviatura from  
								 proyecto_modernizacion.unidades where cod_unidad='".$Row2["cod_unidad"]."'";
								// echo $Consulta23."<br>";
								$Respuesta23 = mysqli_query($link, $Consulta23);
								if(!$Row23 = mysqli_fetch_array($Respuesta23))
								{
									$LeyExiste="N";
								//	echo $Row2["cod_unidad"]."   u    ";
								}
							}
						}
						$Consulta="Select * from cal_web.estados_por_solicitud where nro_solicitud='".$Row["nro_solicitud"]."' and recargo in ('','0') and cod_estado in('4','5','6')";
						$Resp2 = mysqli_query($link, $Consulta);
						if(!$Row2 = mysqli_fetch_array($Resp2))
						{	$LeyExiste='N';$Color="#FFFF9F";}	
						//echo 	$Row["existe"]."   -    ".$LeyExiste."<br>";				
						?>
                        <tr bgcolor="<?php echo $Color;?>">
						<td><?php if($Row["existe"]=='S'){ if($LeyExiste=='S'){?><input name="CheckSol" type="checkbox"  value="<?php echo $Row["nro_solicitud"];?>"><?php }}?></td>                       
						<td><?php echo $Row["nro_solicitud"]?></td>                       
                        <?php
						$ConsultaLEYES = "select t2.abreviatura,t1.cod_leyes from cal_web.tmp_leyes_generica t1 
						left join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes where run_registro='".$CookieRut."'  group by t1.cod_leyes order by ceiling(orden) asc";
						$RespuestaLEYES = mysqli_query($link, $ConsultaLEYES);
						while($RowLEYES = mysqli_fetch_array($RespuestaLEYES))
						{
							$Color2="#CCCCCC";
							if($Color=="#FF8080")
								$Color2='#FF8080';
							if($Color=="#FFFF9F")
								$Color2='#FFFF9F';
							$Consulta23 = "select abreviatura from  
							 proyecto_modernizacion.leyes where cod_leyes='".$RowLEYES["cod_leyes"]."' group by cod_leyes";
							$Respuesta23 = mysqli_query($link, $Consulta23);
							if(!$Row23 = mysqli_fetch_array($Respuesta23))
								$Color2="#FF0000";	
														
							$Consulta2 = "select cod_unidad,avg(valor) as valor,cod_leyes,count(*) as cant_reg from cal_web.tmp_leyes_generica 
							where run_registro='".$CookieRut."' and nro_solicitud='".$Row["nro_solicitud"]."' and cod_leyes='".$RowLEYES["cod_leyes"]."'
							group by nro_solicitud,cod_leyes order by ceiling(orden) asc";
							$Respuesta2 = mysqli_query($link, $Consulta2);
							if($Row2 = mysqli_fetch_array($Respuesta2))
							{
								$ConsultaUni = "select abreviatura from  
								 proyecto_modernizacion.unidades where cod_unidad='".$Row2["cod_unidad"]."'";
								$RespuestaUni = mysqli_query($link, $ConsultaUni);
								$Abreviatura="";
								if($RowUni = mysqli_fetch_array($RespuestaUni))
									$Abreviatura=$RowUni["abreviatura"];
								$ValorLey=trim($Row2["valor"]);$Dec=4;
								if($Row2["cant_reg"]>1)
								{
									$ValorLey=round($ValorLey);$Dec=0;
								}
								?>
								<td bgcolor="<?php echo $Color2;?>"><?php if($ValorLey==0){ echo 0;}else{echo number_format($ValorLey,$Dec,',','.');}?></td>
								<td bgcolor="<?php echo $Color2;?>"><?php echo $Abreviatura;?></td>
								<?php
							}	
							else
							{
								?>
								<td bgcolor="<?php echo $Color2;?>">&nbsp;</td>
								<td bgcolor="<?php echo $Color2;?>">&nbsp;</td>
								<?php
							}							
						}
					}
					/*$Consulta = "select nro_solicitud,existe from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."' group by nro_solicitud";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);$Cont2=0;
					while($Row = mysqli_fetch_array($Respuesta))
					{
						$Color="#FF8080";
						if($Row["existe"]=='S')
							$Color="#CCCCCC";
						$Consulta2 = "select cod_unidad,avg(valor) as valor,cod_leyes from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."' and nro_solicitud='".$Row["nro_solicitud"]."' group by nro_solicitud,cod_leyes order by ceiling(orden) asc";
						$Respuesta2 = mysqli_query($link, $Consulta2);$LeyExiste="S";
						while($Row2 = mysqli_fetch_array($Respuesta2))
						{
							$Consulta23 = "select abreviatura from  
							 proyecto_modernizacion.leyes where cod_leyes='".$Row2["cod_leyes"]."' group by cod_leyes";							 
							$Respuesta23 = mysqli_query($link, $Consulta23);
							if(!$Row23 = mysqli_fetch_array($Respuesta23))
								$LeyExiste="N";
							if($Row2["cod_unidad"]!='')
							{
								$Consulta23 = "select abreviatura from  
								 proyecto_modernizacion.unidades where abreviatura='".$Row2["cod_unidad"]."'";
								$Respuesta23 = mysqli_query($link, $Consulta23);
								if(!$Row23 = mysqli_fetch_array($Respuesta23))
									$LeyExiste="N";
							}
						}
						$Consulta="Select * from cal_web.estados_por_solicitud where nro_solicitud='".$Row["nro_solicitud"]."' and recargo='' and cod_estado in('4','5','6')";
						$Resp2 = mysqli_query($link, $Consulta);
						if(!$Row2 = mysqli_fetch_array($Resp2))
						{	$LeyExiste='N';$Color="#FFFF9F";}
						
						?>
                        <tr bgcolor="<?php echo $Color;?>">
						<td><?php if($Row["existe"]=='S'){ if($LeyExiste=='S'){?><input name="CheckSol" type="checkbox"  value="<?php echo $Row["nro_solicitud"];?>"><?php }}?></td>                       
						<td><?php echo $Row["nro_solicitud"]?></td>                       
                        <?php

						$Consulta2 = "select cod_unidad,avg(valor) as valor,cod_leyes from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."' and nro_solicitud='".$Row["nro_solicitud"]."' group by nro_solicitud,cod_leyes order by ceiling(orden) asc";
						$Respuesta2 = mysqli_query($link, $Consulta2);
						while($Row2 = mysqli_fetch_array($Respuesta2))
						{
							$Color2="#CCCCCC";
							if($Color=="#FF8080")
								$Color2='#FF8080';
							if($Color=="#FFFF9F")
								$Color2='#FFFF9F';
							$Consulta23 = "select abreviatura from  
							 proyecto_modernizacion.leyes where cod_leyes='".$Row2["cod_leyes"]."' group by cod_leyes";
							$Respuesta23 = mysqli_query($link, $Consulta23);
							if(!$Row23 = mysqli_fetch_array($Respuesta23))
								$Color2="#FF0000";							
							?>
							<td bgcolor="<?php echo $Color2;?>"><?php if($Row2[valor]==0){ echo 0;}else{echo number_format($Row2[valor],4,',','.');}?></td>
							<td bgcolor="<?php echo $Color2;?>"><?php echo $Row2["cod_unidad"]?></td>
							<?php
						}
						?>
						</tr>
						<?php
					}*/
				}
			    ?>
            </td>
          </tr></table>
     </td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php");
function ValidaLeyes($Solicitud,$Recargo,$Leyes,$UnidadExcel,$Msje,$link)
{
 
	$Retorno=false;	
	$Consulta="Select * from cal_web.leyes_por_solicitud  t1 ";
	$Consulta.=" where t1.nro_solicitud='".$Solicitud."' and  ";
	if($Recargo=='R')
	{
			$Consulta.=" (t1.recargo='R') ";

	}
	else
	{
			$Consulta.=" (t1.recargo='0' or  t1.recargo='') ";

		}
	$Consulta.=" and ceiling(t1.cod_leyes)=ceiling('".$Leyes."')";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila = mysqli_fetch_array($Resp))
	{
		if($Fila["cod_unidad"]==$UnidadExcel)
			$Retorno=true;	
		
	}
	else
	{
		$Retorno=false;
		$Msje=' No existe ley en los registros. ';
	}
	
	return($Retorno);
 
}
 function ExisteSA($Solicitud,$link)
{
 
	$Retorno=false;	
	$Consulta="Select * from cal_web.solicitud_analisis  t1 where t1.nro_solicitud='".$Solicitud."' and  t1.estado_actual in (4,5) ";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila = mysqli_fetch_array($Resp))
	{
		$Retorno=true;	
	}
	return($Retorno);
 
}
function ObtenerDescripcionUnidad($Unidad,$link)
{
	$Retorno="S/U";	
	$Consulta="Select * from proyecto_modernizacion.unidades  t1 where t1.cod_unidad=CEILING('".$Unidad."')";
	// echo $Consulta."<br>";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila = mysqli_fetch_array($Resp))
	{
	$Retorno=$Fila["abreviatura"];	
	}
	return($Retorno);
}
 
if($g=='s')
{
	$Eliminar="delete from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."'";
	mysqli_query($link, $Eliminar);	
}	 
?>
<textarea name="Datos" style="visibility:hidden;"></textarea>
</form>
</body>
</html>
