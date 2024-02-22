<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;

if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes =  date("m");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT =  date("m");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}
if(isset($_REQUEST["IdInicial"])) {
	$IdInicial = $_REQUEST["IdInicial"];
}else{
	$IdInicial =  "";
}
if(isset($_REQUEST["IdFinal"])) {
	$IdFinal = $_REQUEST["IdFinal"];
}else{
	$IdFinal =  "";
}
if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar =  "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni =  0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin =  10;
}

?>
<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
//function Proceso(Opcion,FechaAtencion)
function Proceso(Opcion)
{
	var frm=document.FrmConsultaRecepcion;
	switch (Opcion)
	{
		case "B": 
			var TotalDiasT=0;
			var CantDiasI=0;
			var CantDiasT=0;
			var TotalDiasI=0;
			var DifDias=0;
			var Mostrar =1;
			CantDiasI=365*parseInt(frm.CmbAno.value);
			TotalDiasI=parseInt(CantDiasI)+(31*parseInt(frm.CmbMes.value))+parseInt(frm.CmbDias.value);
			CantDiasT=365*parseInt(frm.CmbAno.value);
			TotalDiasT=CantDiasT+(31*parseInt(frm.CmbMesT.value))+parseInt(frm.CmbDiasT.value);
			DifDias=TotalDiasT-TotalDiasI;
			if (DifDias > 32)
			{
				alert("Rango de busqueda debe ser 1 meses aprox.")
				Mostrar=2;
				return;
			}
			if (frm.CmbAnoT.value==frm.CmbAno.value)
			{
				if ((frm.CmbMesT.value-frm.CmbMes.value)>1)
				{
					alert("El rango de fecha debe ser menor o igual a 1 meses");
					Mostrar=2;
					return;
				}
			}
			if (Mostrar == 1)
			{
				if (frm.IdInicial.value =='')
				{
					alert("Debe Ingresar Idmuestra Inicial");
					frm.IdInicial.focus();
					return;
				}
				if (frm.IdFinal.value =='')
				{
					alert("Debe Ingresar Idmuestra Final");
					frm.IdFinal.focus();
					return;
				}
				if ((frm.IdInicial.value =='')&&(frm.IdFinal.value ==''))
				{
					alert("Debe Ingresar Idmuestra ");
					frm.IdInicial.focus();
					return;
				}
				frm.action ="cal_con_lotes.php?Mostrar=S";  
				frm.submit();
			}
			break;	
		case "E":
			ValidarCertificado();
			break;
		case "S":
			Salir();
			break;	
	}	
}
function ValidarCertificado()
{
	var frm =document.FrmConsultaRecepcion;
	var ValoresSA="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
	ValoresSA=RecuperarSolicitud();
	if (ValoresSA!="")
	{	
		window.open("cal_generacion_certificados_analisis.php?SolRecargo="+ ValoresSA,"","top=50,left=50,width=610,height=500,scrollbars=yes,resizable = yes");
	}
} 
function RecuperarSolicitud()
{
	var frm=document.FrmConsultaRecepcion;
	var Encontro=false;
	var SA ="";
	try 
	{
		frm.checkSA[0];
		for (i=1;i<frm.checkSA.length;i++)
		{
			if (frm.checkSA[i].checked==true)
			{
				SA = SA + frm.TxtSAO[i].value + "//" ;
				Encontro=true;
			}
		}
	}	
	catch (e)
	{
	 	 alert("No hay Elementos para Seleccionar");
	}
	if (Encontro==false)
	{
		alert("No hay Elementos para Seleccionar");
		return(SA);
	}
	else
	{
		return(SA);
	}
}

function Excel()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action ="cal_xls_lotes.php?Mostrar=S";  
	frm.submit();
	
}
function Salir()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit(); 
}
function Historial(SA)
{
	window.open("cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Recarga(URL,LimiteIni)
{
	var frm=document.FrmConsultaRecepcion;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
<?php
	/*if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <tr> <td width="756"></tr>
  <tr>
    <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td width="87"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            Usuario:</font></font></div></td>
        <td colspan="3"><strong> 
          <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
          </strong></td>
        <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:<strong> 
          </strong></font></font></td>
        <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
          <?php echo $Fecha_Hora ?>
          </strong>&nbsp; <strong> 
          <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
          </strong></font></font></td>
      </tr>
      <tr> 
        <td height="31">Fecha Inicio<font size="2">:&nbsp; </font></td>
        <td colspan="3"><font size="2"> 
          <select name="CmbDias" style="width:40px;">
            <?php
				
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
			?>
          </select>
          </font> <font size="2"> 
          <select name="CmbMes" style="width:90px;">
            <?php
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
		    ?>
          </select>
          </font> <select name="CmbAno" style="width:70px;">
            <?php
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
			?>
          </select> </td>
        <td width="94">Fecha Termino:</td>
        <td width="315"> <select name="CmbDiasT" style="width:40px;">
            <?php
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDiasT))
				{
					if ($i==$CmbDiasT)
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
			?>
          </select> <select name="CmbMesT" style="width:90px;">
            <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMesT))
				{
					if ($i==$CmbMesT)
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
		   ?>
          </select> <select name="CmbAnoT" style="width:70px;">
            <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAnoT))
				{
					if ($i==$CmbAnoT)
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
			?>
          </select></td>
      </tr>
      <tr> 
        <td height="31">Lote Inicial</td>
        <td width="71"><input name="IdInicial" type="text" id="IdInicial" value="<?php echo $IdInicial; ?>" size="12" maxlength="12"></td>
        <td width="64">Lote Final</td>
        <td width="94"><input name="IdFinal" type="text" id="IdIFinal" value="<?php echo $IdFinal; ?>" size="12" maxlength="12"></td>
        <td>Lineas por P&aacute;g.</td>
        <td><input name="LimitFin" type="text" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12"></td>
      </tr>
      <tr> 
        <td height="31">&nbsp;</td>
        <td colspan="3"> <div align="left"> </div></td>
        <td colspan="2"><input name="BtnBuscar" type="button" id="BtnBuscar2" style="width:70" value="Buscar" onClick="Proceso('B');"> 
          <input name="BtnCertificado" type="button" id="BtnCertificado" value="Certificado" onClick="Proceso('E');">
          <input name="BtnExcel" type="button" style="width:70" value="Excel" onClick="Excel();" > 
          <input name="BtnSalir2" type="button" id="BtnSalir22" value="Salir" style="width:70" onClick="Proceso('S');"></td>
      </tr>
    </table>
    <br>
    <table width="873" border="1" cellpadding="0" cellspacing="0" >
      <tr class="ColorTabla01"> 
        <td width="19" height="20"><div align="center"></div></td>
        <td width="103">S.A</td>
        <td width="81" height="20">Agrupacion</td>
		<td width="144" height="20">Id Muestra</td>
        <td width="171" height="20"><div align="center">F Muestra</div></td>
        <td width="94"><div align="left"> 
            <div align="center"></div>
            <div align="center">F.Creacion</div>
          </div></td>
        <td width="128"><div align="center">Producto</div></td>
        <td width="198"><div align="center">SubProducto</div></td>
      </tr>
      <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		$Consulta=" select STRAIGHT_JOIN t1.lote_origen,t1.cod_origen from sea_web.relaciones t1";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote_origen = t2.id_muestra";
		$Consulta.=" where (t1.lote_ventana between '".$IdInicial."' and '".$IdFinal."') ";
		//echo $Consulta."<br>";
		$Respuesta=mysqli_query($link, $Consulta);
		$i=0;
		$Encontro=false;
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			if ($Fila["cod_origen"]=='1')
			{
					if ($i==0)
					{
						$LoteOrigen=$Fila["lote_origen"];
					}
					$LoteFinal=$Fila["lote_origen"];
					$Encontro=true;
					$i++;
			}
		}
		if ($Encontro==true)
		{
			$Pregunta.=" (t1.id_muestra between '".$LoteOrigen."' and '".$LoteFinal."')or (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') and (t1.fecha_muestra between  '".$FechaI."' and '".$FechaT."') and ((t1.agrupacion = 1)or(t2.lotes='S')) ";
		}
		else
		{
			$Pregunta = "   (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') and (t1.fecha_muestra between  '".$FechaI."' and '".$FechaT."') and ((t1.agrupacion = 1)or(t2.lotes='S')) ";
		}
		$Consulta = "select STRAIGHT_JOIN distinct(t1.nro_solicitud),t1.fecha_hora,t1.fecha_muestra,t1.cod_producto,t1.cod_subproducto,t1.rut_funcionario,t1.id_muestra,t1.fecha_hora as FechaCreacion,t1.tipo_solicitud,t1.agrupacion,t1.estado_actual from cal_web.solicitud_analisis t1 ";		
		$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta = $Consulta." where (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '') and ";
		$Consulta = $Consulta.$Pregunta; 
		//echo $Consulta."<br>";
		$Respuesta= mysqli_query($link, $Consulta);
		$Coincidencias=0;
		$Chanta="";
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
				if (($Fila["tipo_solicitud"]=='R') && ($Fila["estado_actual"] =='6')) 				
				{
					//$Chanta=$Chanta."t1.nro_solicitud=".$Fila["nro_solicitud"]." or ";
					$Chanta=" t1.nro_solicitud=".$Fila["nro_solicitud"]." or ";
					$Coincidencias=$Coincidencias+1;
				
				}
				if ($Fila["tipo_solicitud"]=='A')
				{
					$Consulta = " select count(*) as NroSol from cal_web.solicitud_analisis where nro_solicitud = '".$Fila["nro_solicitud"]."'"; 
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Fila2 = mysqli_fetch_array($Respuesta2);
					$N1 = $Fila2["NroSol"];
					$Consulta = " select count(*) as NroSolF from cal_web.solicitud_analisis where nro_solicitud = '".$Fila["nro_solicitud"]."' and estado_actual = '6'"; 
					$Respuesta3 = mysqli_query($link, $Consulta);
					$Fila3=mysqli_fetch_array($Respuesta3);
					$N2=$Fila3["NroSolF"];
					if (($Fila2["NroSol"]) == ($Fila3["NroSolF"]))
					{		
						//$Chanta=$Chanta."t1.nro_solicitud=".$Fila["nro_solicitud"]." or ";
						$Chanta= " t1.nro_solicitud=".$Fila["nro_solicitud"]." or ";
						$Coincidencias=$Coincidencias+1;						
					}	
				}
		}
		//echo "chantasunsub".$Chanta."<br>";
		$Chanta=substr($Chanta,0,strlen($Chanta)-3);
		//echo "chantaconnsub".$Chanta."<br>";
		if ($Chanta!="")
		{
			$Consulta = "select distinct(t1.nro_solicitud), t1.nro_sa_lims,t1.fecha_hora,t1.fecha_muestra,t1.cod_producto,t1.cod_subproducto,t1.rut_funcionario,t1.id_muestra,t1.fecha_hora as FechaCreacion,t1.tipo_solicitud,t1.agrupacion,t1.estado_actual from cal_web.solicitud_analisis t1 ";		
			$Consulta = $Consulta." where ".$Chanta;  
			//echo $Consulta."<br>";
			$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
			echo "<input type='hidden' name='checkSA'><input name ='TxtSAO' type='hidden'><input name ='TxtRutO' type='hidden'><input name ='TxtRecargoO' type='hidden'><input name='SolictudesO' type='hidden'><input name='TxtFechaO' type='hidden'><input name='TxtHoraO' type='hidden'><input name='TxtLotes' type='hidden'><input name='TxtIdMuestra' type='hidden'><input name='TxtProducto' type='hidden'>";
			$Respuesta= mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Agrupacion=$Fila["agrupacion"]."<br>";
				
				echo "<tr>";
					if (($Fila["tipo_solicitud"]=='R') && ($Fila["estado_actual"] =='6')) 				
					{
						echo "<td width='2'><input type='checkbox' name ='checkSA' value=''></td>"; 

							if ($Fila["nro_sa_lims"]=='') {
              					$VarSA=$Fila["nro_solicitud"];
              				}else{
              					$VarSA=$Fila["nro_sa_lims"];
              				}

              				echo "<td width='100'>
              				<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].")\">".$TxtSA = $VarSA."</a>
              				<input name = 'TxtRecargo' type = 'hidden' value ='N'>
              				 
              				<input name='TxtVarSA' type='text' readonly style='width:100' maxlength='100' value =".$VarSA.">
              				</td>";

 			
						$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Fila["agrupacion"]."'";
						$Resp1=mysqli_query($link, $Consulta);
						$Fil1=mysqli_fetch_array($Resp1);
						echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
						
						$Consulta=" select STRAIGHT_JOIN t1.lote_ventana from sea_web.relaciones t1";
						$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote_origen = t2.id_muestra";
						$Consulta.=" where (t2.id_muestra='".$Fila["id_muestra"]."') ";
						$Resp20=mysqli_query($link, $Consulta);
						if ($Fil20=mysqli_fetch_array($Resp20))
						{
							echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fil20["lote_ventana"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
						}
						else
						{
							echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
						}
						echo "<td width ='150'><div align ='left'>".$Fila["fecha_muestra"]."&nbsp;</div></td>";		
						echo "<td width ='150'><div align ='left'>".$Fila["FechaCreacion"]."&nbsp;</div></td>";		
						//----------------------Producto y  Subproducto --------------------------------------
						$Consulta = "select STRAIGHT_JOIN t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
						$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
						$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
						$Consulta.= " where t1.nro_solicitud = '".$Fila["nro_solicitud"]."' ";
						echo "<input type='hidden' name='checkSA'><input name ='TxtSAO' type='hidden'><input name ='TxtRecargoO' type='hidden'>";
						$Resp=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp);  
						echo "<td align ='center'>".$Fila1["AbrevProducto"]."</td>";
						echo "<td align = 'center'>".$Fila1["AbrevSubProducto"]."</td>";
						echo "</tr>";
					}
					if ($Fila["tipo_solicitud"]=='A')
					{
						$Consulta = " select count(*) as NroSol from cal_web.solicitud_analisis where nro_solicitud = '".$Fila["nro_solicitud"]."'"; 
						$Respuesta2 = mysqli_query($link, $Consulta);
						$Fila2 = mysqli_fetch_array($Respuesta2);
						$N1 = $Fila2["NroSol"];
						$Consulta = " select count(*) as NroSolF from cal_web.solicitud_analisis where nro_solicitud = '".$Fila["nro_solicitud"]."' and estado_actual = '6'"; 
						$Respuesta3 = mysqli_query($link, $Consulta);
						$Fila3=mysqli_fetch_array($Respuesta3);
						$N2=$Fila3["NroSolF"];
						
						if ($Fila2["NroSol"] == $Fila3["NroSolF"])
						{		
							echo "<tr>";
							echo "<td width='2'><input type='checkbox' name ='checkSA' value=''></td>";

							if ($Fila["nro_sa_lims"]=='') {
              					$VarSA=$Fila["nro_solicitud"];
              				}else{
              					$VarSA=$Fila["nro_sa_lims"];
              				}

              				echo "<td width='100'>
              				<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].")\">".$TxtSA = $VarSA."</a>
              				<input name = 'TxtRecargo' type = 'hidden' value ='N'>
              				 
              				<input name='TxtVarSA' type='hidden' readonly style='width:100' maxlength='100' value =".$VarSA.">
              				</td>";


							 







							$Consulta ="select STRAIGHT_JOIN t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
							$Consulta.= " inner join cal_web.solicitud_analisis t1 on  t1.agrupacion = t2.cod_subclase and t2.cod_clase = 1004  "; 
							$Consulta.= " where t1.nro_solicitud = ".$Fila["nro_solicitud"]." ";
							$Resp1=mysqli_query($link, $Consulta);
							$Fil1=mysqli_fetch_array($Resp1);
							echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
							echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
							echo "<td width ='150'><div align ='left'>".$Fila["fecha_muestra"]."&nbsp;</div></td>";		
							echo "<td width ='150'><div align ='left'>".$Fila["FechaCreacion"]."&nbsp;</div></td>";		
							//----------------------Producto y  Subproducto --------------------------------------
							$Consulta = "select STRAIGHT_JOIN  t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
							$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
							$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
							$Consulta.= " where t1.nro_solicitud = '".$Fila["nro_solicitud"]."' ";
							$Resp=mysqli_query($link, $Consulta);
							$Fila1=mysqli_fetch_array($Resp);  
							echo "<td align ='center'>".$Fila1["AbrevProducto"]."</td>";
							echo "<td align = 'center'>".$Fila1["AbrevSubProducto"]."</td>";
							echo "</tr>";
						}	
					}
				}
			}	
	   ?>
    </table>
    <br>
    <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
      <tr> 
        <td width="314"><div align="right"> </div></td>
        <td width="160"><div align="center"> </div>
          <div align="center"> 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
          </div></td>
        <td width="116">&nbsp;</td>
        <td width="144">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  	<table width="760" border="0" cellpadding="0" cellspacing="0">
         <tr>
         <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
         <?php		
		if ($Chanta!="")
		{
			$NumPaginas = ($Coincidencias / $LimitFin);
			$LimitFinAnt = $LimitIni;
			$StrPaginas = "";
			for ($i = 0; $i <= $NumPaginas; $i++)
			{
				$LimitIni = ($i * $LimitFin);
				if ($LimitIni == $LimitFinAnt)
				{
					$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
				}
				else
				{
					$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_lotes.php','".($i * $LimitFin)."');>";
					$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
				}
			}
			echo substr($StrPaginas,0,-15);
		}			
		?>
            </td>
          </tr></table>
</form>
</body>
</html>
