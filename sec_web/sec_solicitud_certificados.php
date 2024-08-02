<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
	$CmbEstado = isset($_REQUEST["CmbEstado"])?$_REQUEST["CmbEstado"]:"";
	$Estado = isset($_REQUEST["Estado"])?$_REQUEST["Estado"]:"";
	$Mostrar= isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";

?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
}
function Consultar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_solicitud_certificados.php?Estado="+Frm.Estado.value+"&Mostrar=S";
	Frm.submit();
}
function Excel()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_xls_consulta_envios.php?CmbMes="+Frm.CmbMes.value+"&CmbAno="+Frm.CmbAno.value;
	Frm.submit();
}

function Imprimir()
{
	var Frm=document.FrmProceso;
	window.print();
}
function Solicitar()
{
	var Frm=document.FrmProceso;
	var Valores="";
	var Encontro=false;
	if(Frm.CmbEstado.value==-1)
	{
		alert("Debe Seleccionar tipo transporte");
		Frm.CmbEstado.focus();
		return;
	}
	for (i=1;i<Frm.checkbox.length;i++)
	{
		
		if (Frm.checkbox[i].checked)
		{
			Valores=Valores + Frm.checkbox[i].value +"//";
			Encontro=true;
		}
	}
	if(Encontro==true)
	{ 
			Valores=Valores.substr(0,Valores.length-2);
			Frm.action="sec_solicitud_certificados01.php?Valores="+Valores+"&Proceso=G";
			Frm.submit();
	}
	else
	{
		alert("Debe Seleccionar un Elemento");
	}
}

function Habilitar()
{
	var Frm=document.FrmProceso;
	var URL = "";
	var Valores="";
	var Encontro=false;
	
	for (i=0;i<Frm.elements.length;i++)
	{
	if  (Frm.elements[i].name== "radiolote" && Frm.elements[i].checked==true)
		{
			if (confirm("Al Habilitar Certificado Anulado Quedara en Estado de No Solicitado"))
			{
					Encontro=true;
					//alert(Frm.elements[i].value);
				Valores=(Frm.elements[i].value);
			}
			else
			{
				return;
			}
		}
	}
	if(Encontro==true)
	{ 
//alert (Valores);
		Frm.action = "sec_solicitud_certificados01.php?Valores="+Valores+"&Proceso=H";
		Frm.submit();
	}
	else
	{					
		alert("Debe Seleccionar un Elemento");
		return;
	}

}

function Certificado(Numero,IE)
{
	window.open("sec_con_certificado_creado.php?NumCertificado="+ Numero+"&Idioma=E&Valida=N","","top=50,left=10,width=700,height=600,scrollbars=yes,resizable = yes");					
}
	
function CodCliente(CodBulto, NumBulto, CodCliente, IE)
{
	window.open("sec_solicitud_certificados02.php?CodBulto=" + CodBulto + "&NumBulto=" + NumBulto + "&CodCliente=" + CodCliente + "&IE="+ IE,"","top=50,left=10,width=450,height=300,scrollbars=yes,resizable = yes");					
}	


</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<center>
<form name="FrmProceso" method="post" action="">
    <?php
	    $Tamaño = 0; //WSO
		if($Mostrar=='S')
		{
			if(($Estado=='P')||($Estado=='E'))
		 	{
				$Tamaño='780';
			}	
			else
			{
				//$Tamaño='616';
				$Tamaño='700';
			}
		}
	?>
	<!--<table width="<?php echo $Tamaño; ?>" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
      <tr>
      <td width="883" align="left"> 
        <br>-->
          <table width="<?php echo $Tamaño; ?>" border="0" class="TablaInterior">
            <tr> 
              <td colspan="2"  align="center"><div align="left"></div></td>
              
        <td  align="center" width="211"><strong>SOLICITUD DE CERTIFICADOS (Version 
          2)</strong></td>
              <td colspan="2"  align="center"><div align="left"></div></td>
              <td  align="center" width="79"> <div align="left"> </div></td>
            </tr>
            <tr> 
              <td width="3"  align="center"><div align="right"></div></td>
              <td width="66"  align="center"><div align="left"><strong>Fecha Envio :</strong></div></td>
              <td  align="center"> <div align="left"> 
                  <?php
			echo"<select name='CmbMes'>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMes)){
					if ($i==$CmbMes){
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}else{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}else{
					if ($i==date("n")){
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}else{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
			echo "</select>";
			echo "<select name='CmbAno'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno)){
					if ($i==$CmbAno){
							echo "<option selected value ='$i'>$i</option>";
					}else{
							echo "<option value='".$i."'>".$i."</option>";
					}
				}else{
					if ($i==date("Y")){
							echo "<option selected value ='$i'>$i</option>";
					}else{
							echo "<option value='".$i."'>".$i."</option>";
					}
				}		
			}
			echo "</select>";
	?>
                </div></td>
              <td width="53"  align="center"> <div align="left"> </div>
                <div align="left"><strong>Estado : </strong> </div></td>
              <td width="209"  align="center"><div align="left">
                  <select name="Estado">
                    <?php
				  	//if (isset($Estado))
					if ($Estado!="")
					{
						switch ($Estado)
						{	
							case "T":
					  			echo "<option value='T' selected>TODOS</option>";
								echo "<option value='N'>NO SOLICITADOS </option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A'>ANULADAS</option>";
								break;
							case "P":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='N'>NO SOLICITADOS </option>";
								echo "<option value='P' selected>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A'>ANULADAS</option>";
								break;
							case "E":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='N'>NO SOLICITADOS </option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E' selected>EMITIDOS</option>";
								echo "<option value='A'>ANULADAS</option>";
								break;
							case "N":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='N' selected>NO SOLICITADOS </option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A'>ANULADAS</option>";
								break;
							case "A":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='N'>NO SOLICITADOS </option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A' selected>ANULADAS</option>";
								break;			
						}
						
					}
					else
					{
						echo "<option value='T' selected>TODOS</option>";
						echo "<option value='N'>NO SOLICITADOS </option>";
						echo "<option value='P'>PENDIENTES</option>";
						echo "<option value='E'>EMITIDOS</option>";
						echo "<option value='A'>ANULADAS</option>";
					}
				  ?>
                  </select>
                </div></td>
              <td  align="center">&nbsp;</td>
            </tr>
            <tr> 
              <td  align="center"><div align="right"></div></td>
              <td  align="center"><div align="left"><strong>Tipo : </strong></div></td>
              <td  align="center"><div align="left"> 
            <select name="CmbEstado">
              <option value="-1">Seleccionar</option>
              <?php
				  $Consulta="SELECT * from proyecto_modernizacion.sub_clase ";
				  $Consulta.=" where cod_clase='3010' ";
				  $Respuesta0=mysqli_query($link, $Consulta);
				  while($Fila0=mysqli_fetch_array($Respuesta0))
				  {
				  	if($CmbEstado==$Fila0["cod_subclase"])
					{
						echo "<option value='".$Fila0["valor_subclase1"]."' selected>".$Fila0["nombre_subclase"]."</option>";
					}
					else
					{
						echo "<option value='".$Fila0["valor_subclase1"]."'>".$Fila0["nombre_subclase"]."</option>";
					}
				  }
				  ?>
            </select>
          </div></td>
              <td colspan="3"  align="center"><div align="left">
                  <input name="BtnConsultar" type="button" id="BtnConsultar2" value="Consultar" style="width:60px;" onClick="Consultar('<?php echo $CmbEstado ?>');">
                  <input name="BtnSolicitar" type="button" id="BtnSolicitar" value="Solicitar" style="width:60px;" onClick="Solicitar();">
                  <input name="BtnImprimir22" type="button" id="BtnImprimir223" value="Imprimir" style="width:60px;" onClick="Imprimir();">
				  <?php
				  if ($Estado !='A')
				  {
				  ?>
			      	<input name="BtnHabilitar"  type="button" id="BtnHabilitar" disabled style="width:70" onClick="Habilitar();" value="Re Solicitar"> 
									 
				 <?php 
				 }
				 else
				 {
				 ?>
					<input name="BtnHabilitar" type="button"  id="BtnHabilitar" style="width:70" onClick="Habilitar();" value="Re Solicitar"> 
					<?php
					}
					?>
					
                  <input type="button" name="BtnSalir2" value="Salir" style="width:60" onClick="Salir();">
                </div></td>
            </tr>
          </table>
		<br>
	<table width="<?php echo $Tamaño;  ?>" height="20" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
	  <tr class="ColorTabla01"> 
        <td width="18"><div align="left"></div></td>
		<?php
		if ($Estado == 'A')
		{
		?>
       		 
      		  	<td width="65" align="center"> <div align="left">LOTE</div></td>
      		  	<td width="133" align="center">PRODUCTO</td>
      		  	<td width="50" align="center">INST.EMB.</td>
       		 	<td width="70">FECHA SOL.</td>
       		 	<td width="82">SOLICITADO</td>
       		 	<td width="75">F. EMISION</td>
       		 	<td width="73">EMISOR</td>
       		 	<td width="72">NRO. CERT.</td>
		<?php
		}
		else
		{
		?>
        <td width="40"align="center">Envio</td>
        <td width="42" align="left"><div align="left">IE</div></td>
        <td width="50" align="left"><div align="left">Lote</div></td>
        <td width="42" align="left"><div align="left">Cant</div></td>
        <td width="58" align="left"><div align="center">Peso</div></td>
        <td width="92"><div align="center"></div>
          <div align="center">Marca Lote</div></td>
        <td width="92"><div align="center">Destino Certif.</div></td>
        <td width="183"><div align="center">Cliente</div></td>
        <td width="80"><div align="center">SubProducto</div></td>
		<?php
		}
		?>
		
        <?php
			 if($Mostrar=='S')
			 {
					
				  if(($Estado=='P')||($Estado=='E'))
				  {
					  echo "<td width='100'><div align='center'>F.Sol</div></td>";
					  echo "<td width='100'><div align='center'>Sol</div></td>";
					  
				  }
				  if($Estado=='E')
				  {
					  echo "<td width='100' align='center'><div align='center'>F.Gen</div></td>";
					  echo "<td width='100' align='center'><div align='center'>Gener</div></td>";
					  echo "<td width='69' align='center'><div align='center'>Cert</div></td>";
				  }
			 }
			 ?>
      </tr>
    <?php
	if ($Mostrar=='S')
	{
		if (strlen($CmbMes)==1)
		{
			$CmbMes="0".$CmbMes;
		}
		$Fecha_Envio=$CmbAno."-".$CmbMes;
        $Mes1 = $CmbMes - 1;
		$Mes2 =  $CmbMes + 1;
        if (strlen($Mes1)==1)
		{
			$Mes1="0".$Mes1;
		}
		if (strlen($Mes2)==1)
		{
			$Mes2="0".$Mes2;
		}

		
        $Fecha_Envio1 = $CmbAno."-".$Mes1;
		$Fecha_Envio2 = $CmbAno."-".$Mes2;
		//echo "FFFF".$Fecha_Envio2;  
		
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($Fecha_Envio,5,2))."'"	;
		$Respuesta_mes = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Filames = mysqli_fetch_array($Respuesta_mes))
		{
			$MesConsulta_mes = $Filames["nombre_subclase"];
		}

			//aqui validar que sea estado distindo de A	
		if ($Estado != 'A')
		{
			//$Eliminar="DELETE FROM sec_web.tmpCertificados";
			$Eliminar="DROP TABLE sec_web.tmpCertificados";
			mysqli_query($link, $Eliminar);
			$CrearTmp="CREATE table sec_web.tmpCertificados "; 
			$CrearTmp.=" (cod_producto varchar(2),cod_subproducto varchar(2),corr_ie bigint(8),cod_bulto varchar(2),num_bulto varchar(6),";
			$CrearTmp.=" paquetes bigint(8),peso_neto bigint(8),toneladas bigint(8),descripcion varchar(30),cod_marca varchar(10),fecha_creacion_lote varchar(10),";
			$CrearTmp.=" nombre_cliente varchar(30),cod_estado varchar(1),envio varchar(8),estado varchar(1))";
			mysqli_query($link, $CrearTmp);
				//echo $CrearTmp; 
			$Consulta = "SELECT STRAIGHT_JOIN t2.cod_producto,t2.cod_subproducto,t1.corr_enm,t1.cod_bulto,t1.num_bulto,count(*) as paquetes ,sum(t2.peso_paquetes)"; 
			$Consulta.= " as peso_neto,t4.cantidad_programada as toneladas, t3.descripcion,t1.cod_marca,t1.cod_estado,";
			$Consulta.= " (case when not isnull(t5.cod_cliente) then t5.cod_cliente else t6.cod_nave end) as nombre_cliente"; 
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2"; 
			$Consulta.= " on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete";
			$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto";
			$Consulta.= " and t2.cod_subproducto=t3.cod_subproducto";
			$Consulta.= " inner join sec_web.programa_codelco t4 on t1.corr_enm=t4.corr_codelco";
			$Consulta.= " left join sec_web.cliente_venta t5 on t4.cod_cliente=t5.cod_cliente"; 
			$Consulta.= " left join sec_web.nave t6 on ceiling(t4.cod_cliente)=t6.cod_nave";
			$Consulta.= " left  join sec_web.solicitud_certificado t7  on t1.corr_enm=t7.corr_enm";
			$Consulta.= " where  t1.fecha_creacion_paquete = t2.fecha_creacion_paquete"; 
			$Consulta.= " and t2.cod_producto='18' and t2.cod_subproducto not in  ('49','16','17')";
			$Consulta.= "  and t1.disponibilidad = 'T' ";
			if ($Estado=='N')
				$Consulta.= " and isnull(t7.corr_enm)";
			if(($Estado=='E')||($Estado=='P'))//||($Estado=='A'))
				$Consulta.= " and t7.corr_enm = t1.corr_enm";
			if($Estado=='E')
			{
				$Consulta.=" and t7.generacion='S' and (t7.estado_certificado='')";	
				$Consulta.=" and  (substring(t7.fecha_generacion,1,7) ='".$Fecha_Envio."' ";
				
				$Consulta.=" or  substring(t7.fecha_generacion,1,7) ='".$Fecha_Envio2."') ";
				
				$Consulta.=" and t1.cod_bulto = '".$MesConsulta_mes."'";
			}
			if($Estado=='P')
			{
				$Consulta.=" and t7.generacion='N' and (t7.estado_certificado='')	";
				$Consulta.=" and t1.cod_bulto = '".$MesConsulta_mes."'";
					
			}
			$Consulta.= " and  substring(t1.fecha_creacion_lote,1,7) ='".$Fecha_Envio."' ";
			$Consulta.= " group by t1.corr_enm, t1.cod_bulto,t1.num_bulto";
			$Consulta.= " order by t1.cod_bulto,t1.num_bulto";
			
			//echo "SS".$Consulta;  
			$Resp = mysqli_query($link, $Consulta);  
			while ($Filatmp=mysqli_fetch_array($Resp))
			{
				$Insertar="INSERT INTO sec_web.tmpCertificados(cod_producto,cod_subproducto,corr_ie,cod_bulto,num_bulto,";
				$Insertar.=" paquetes,peso_neto,toneladas,descripcion,cod_marca,fecha_creacion_lote,nombre_cliente,";
				$Insertar.=" cod_estado,envio,estado)";
				$Insertar.=" values ('".$Filatmp["cod_producto"]."','".$Filatmp["cod_subproducto"]."','".$Filatmp["corr_enm"]."','".$Filatmp["cod_bulto"]."',";
				$Insertar.=" '".$Filatmp["num_bulto"]."','".$Filatmp["paquetes"]."','".$Filatmp["peso_neto"]."','".$Filatmp["toneladas"]."','".$Filatmp["descripcion"]."',";
				$Insertar.=" '".$Filatmp["cod_marca"]."','".$Filatmp["fecha_creacion_lote"]."','".$Filatmp["nombre_cliente"]."','".$Filatmp["cod_estado"]."','S/E','".$Estado."')";
					//echo "UUUU".$Insertar."<br>";
				mysqli_query($link, $Insertar);
				$Consulta ="SELECT * from sec_web.embarque_ventana t1";
				$Consulta.=" where t1.corr_enm = '".$Filatmp["corr_enm"]."'";
				$Consulta.=" and (year(t1.fecha_envio) ='".$CmbAno."' or year(t1.fecha_envio) ='".($CmbAno - 1)."')";
				$Resp1    = mysqli_query($link, $Consulta);
					//echo "EEE".$Consulta;
				if($FilaEnvio=mysqli_fetch_array($Resp1))
				{
					$Actualizar="UPDATE sec_web.tmpCertificados set envio = '".$FilaEnvio["num_envio"]."'";
					$Actualizar.=" where corr_ie = '".$Filatmp["corr_enm"]."'";
					mysqli_query($link, $Actualizar);
				}
			}
			echo "<input name='checkbox' type='hidden'></td>";
			if ($Estado=='N')
			{
				$Consulta="SELECT * from sec_web.tmpCertificados";
				$Resp2 = mysqli_query($link, $Consulta);
				$Cont2=0;//WSO
				while ($FilaNS=mysqli_fetch_array($Resp2))
				{
					echo "<tr>";
					echo "<td width='18'><input name='checkbox' type='checkbox'  value='".$FilaNS["corr_ie"]."~~".$FilaNS["cod_bulto"]."~~".$FilaNS["num_bulto"]."'></td>";
					echo "<td width='40' align='center'>".$FilaNS["envio"]."</td>";
					$Cont2++;
					echo "<td width='37'>".$FilaNS["corr_ie"]."&nbsp;</td>";
					echo "<td width='70' align='center'>".$FilaNS["cod_bulto"]."-".$FilaNS["num_bulto"]."</td>\n";
					echo "<td width='42' align='center'>".$FilaNS["paquetes"]."</td>";
					echo "<td width='58' align='center'>".$FilaNS["peso_neto"]."&nbsp;</td>";
						//marca
					$Consulta="SELECT descripcion from sec_web.marca_catodos";
					$Consulta.=" where cod_marca = '".$FilaNS["cod_marca"]."'";
					$Resp3 = mysqli_query($link, $Consulta);
					if($Filamarca=mysqli_fetch_array($Resp3))
						echo "<td width='184' align='center'>".$Filamarca["descripcion"]."&nbsp;</td>";
					$CodCliente = $FilaNS["nombre_cliente"];
					$Consulta="SELECT * from sec_web.nave where cod_nave ='".$CodCliente."'";
					$Resp4=mysqli_query($link, $Consulta);
					if($Filanave=mysqli_fetch_array($Resp4))
					{
						if ($Filanave["nombre_nave"]!="")
							$Cliente=$Filanave["nombre_nave"];
						else
							$Cliente=$CodCliente;
					}
					else
					{
						$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente ='".$CodCliente."'";
						$Resp5=mysqli_query($link, $Consulta);
						if($Filacliente=mysqli_fetch_array($Resp5))
						{
							if ($Filacliente["sigla_cliente"]!="")
								$Cliente=$Filacliente["sigla_cliente"];
							else
								$Cliente=$CodCliente;
						}
					}
					echo "<td align='center'><a href=\"JavaScript:CodCliente('".$FilaNS["cod_bulto"]."','".$FilaNS["num_bulto"]."','".$FilaNS["nombre_cliente"]."','".$FilaNS["corr_ie"]."')\">".$Cliente."</a></td>";
					echo "<td width='183' align='center'>".$Cliente."&nbsp;</td>";
					$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto='".$FilaNS["cod_producto"]."' ";
					$Consulta.=" and cod_subproducto='".$FilaNS["cod_subproducto"]."' ";
					$Resp6=mysqli_query($link, $Consulta);
					$Filaprod=mysqli_fetch_array($Resp6);
					echo "<td width='80' align='center'>".$Filaprod["abreviatura"]."&nbsp;</td>";
				}	
			} //este el el fin del mio
			 //esto es lo que estaba
			if ($Estado!='N')
			{
			 	//aqui incluir select para certificado con stado = N(no solicitados) poly 05062009					
				
				//$Consulta="SELECT *, t1.corr_ie,t1.cod_bulto,t1.num_bulto from sec_web.tmpCertificados t1 ";
				$Consulta="SELECT t1.corr_ie, t1.cod_bulto, t1.num_bulto from sec_web.tmpCertificados t1 ";
				if(($Estado=='E')||($Estado=='P'))//||($Estado=='A'))
				{
					$Consulta.=" inner join sec_web.solicitud_certificado t2 on t1.corr_ie=t2.corr_enm";
				}
				$Consulta.=" inner join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca";
				
				$Consulta.=" where  ";//(substring(t2.fecha_hora,1,7) ='".$Fecha_Envio."' or substring(t2.fecha_hora,1,7) ='".$Fecha_Envio1."')";
				
				if($Estado=='E')
				{
					$Consulta.= " year(t2.fecha_hora) ='".$CmbAno."' ";

					$Consulta.=" and t2.generacion='S' and (t2.estado_certificado='')";	
					$Consulta.=" and  year(t2.fecha_generacion) = '".$CmbAno."' and ";
				}
				if($Estado=='P')
				{
					$Consulta.= " t1.corr_ie = t2.corr_enm and t1.cod_bulto = t2.cod_bulto and ";
					$Consulta.= " t1.num_bulto = t2.num_bulto and t1.estado = 'P' and ";
					$Consulta.="  t2.generacion='N' and (t2.estado_certificado='') and ";	
				}
				$Consulta.=" cod_producto in('18')	order by  t1.envio desc ";
				//echo "DDD".$Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);				
				echo "<input name='checkbox' type='hidden'></td>";
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Nombre="";  
					$Nombre1="";
					echo "<tr>"; 
					$Consulta2 = "SELECT * from sec_web.solicitud_certificado where corr_enm = '".$Fila["corr_ie"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta2);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$Emisor = $Fila2["rut"];
						$FechaEmision = $Fila2["fecha"];
							//if($Fila2["generacion"]=='S')
						if($Fila2["generacion"]=='S')
						{
							echo "<td width='18'><img src='../Principal/imagenes/ico_ok.gif'></td>\n";
						}
						else
						{
							echo "<td width='18'>&nbsp;</td>\n";
						}
		
					}
					echo "<td width='40' align='center'>".$Fila["envio"]."</td>";
					$Cont2++;
					echo "<td width='37'>".$Fila["corr_ie"]."&nbsp;</td>";
					echo "<td width='70' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>\n";
					echo "<td width='42' align='center'>".$Fila["paquetes"]."</td>";
					echo "<td width='58' align='center'>".$Fila["peso_neto"]."&nbsp;</td>";
					//sacar marca
					$Consulta="SELECT descripcion from sec_web.marca_catodos";
					$Consulta.=" where cod_marca = '".$Fila["cod_marca"]."'";
					$Resp8 = mysqli_query($link, $Consulta);
					//echo "RR".$Consulta;
					if($Filamarca2=mysqli_fetch_array($Resp8))
						echo "<td width='184' align='center'>".$Filamarca2["descripcion"]."&nbsp;</td>";
					$CodCliente = $Fila["nombre_cliente"];
					//echo $Fila["corr_enm"]." / ".$CodCliente."<br>";
					$Consulta="SELECT * from sec_web.nave where cod_nave ='".$CodCliente."'";
					$Respuesta2=mysqli_query($link, $Consulta);
					if($Fila2=mysqli_fetch_array($Respuesta2))
					{
						if ($Fila2["nombre_nave"]!="")
							$Cliente=$Fila2["nombre_nave"];
						else
							$Cliente=$CodCliente;
					}
					else
					{
						$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente ='".$CodCliente."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							if ($Fila2["sigla_cliente"]!="")
								$Cliente=$Fila2["sigla_cliente"];
							else
								$Cliente=$CodCliente;
						}
					}
					//------------------------------------
					$Consulta = "SELECT * from sec_web.solicitud_certificado where corr_enm = '".$Fila["corr_enm"]."'";	
					$RespAux = mysqli_query($link, $Consulta);
					if ($FilaAux = mysqli_fetch_array($RespAux))
					{
						if ($FilaAux["cod_cliente2"]!="")
						{
							$Consulta="SELECT * from sec_web.nave where cod_nave ='".$FilaAux["cod_cliente2"]."'";
							$Respuesta2=mysqli_query($link, $Consulta);
							if($Fila2=mysqli_fetch_array($Respuesta2))
							{
								if ($Fila2["nombre_nave"]!="")
									$Cliente2=$Fila2["nombre_nave"];
								else
									$Cliente2=$FilaAux["cod_cliente2"];
							}
							else
							{
								$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente ='".$FilaAux["cod_cliente2"]."'";
								$Respuesta2=mysqli_query($link, $Consulta);
								if($Fila2=mysqli_fetch_array($Respuesta2))
								{
									if ($FilaAux["cod_cliente2"]!="")
										$Cliente2=$Fila2["sigla_cliente"];
									else
										$Cliente2=$FilaAux["cod_cliente2"];
								}
							}
							echo "<td align='center'><a href=\"JavaScript:CodCliente('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$FilaAux["cod_cliente2"]."','".$Fila["corr_enm"]."')\">".$Cliente2."</a></td>";
						}
						else
						{
							echo "<td align='center'><a href=\"JavaScript:CodCliente('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["cod_cliente"]."','".$Fila["corr_enm"]."')\">".$Cliente."</a></td>";
						}
					}
					else
					{
						echo "<td align='center'><a href=\"JavaScript:CodCliente('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["cod_cliente"]."','".$Fila["corr_enm"]."')\">".$Cliente."</a></td>";
					}								
					echo "<td width='183' align='center'>".$Cliente."&nbsp;</td>";
					$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto='".$Fila["cod_producto"]."' ";
					$Consulta.=" and cod_subproducto='".$Fila["cod_subproducto"]."' ";
					$Respuesta5=mysqli_query($link, $Consulta);
					$Fila5=mysqli_fetch_array($Respuesta5);
					echo "<td width='80' align='center'>".$Fila5["abreviatura"]."&nbsp;</td>";
					if(($Estado=='E')||($Estado=='P'))
					{
						echo "<td width='100' align='left'>".$Fila["fecha_hora"]."&nbsp;</td>";
						$Consulta = "SELECT * from proyecto_modernizacion.funcionarios where rut = '".$Emisor."'";
						$Respuesta3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Nombre = substr(strtoupper($Fila3["nombres"]),0,1).". ".ucwords(strtolower($Fila3["apellido_paterno"]));
							echo "<td width='100' align='center'>".$Nombre."</td>";
						}
						else
						{
							echo "<td width='100' align='center'>&nbsp;</td>";	
						}
					}
					if($Estado=='E')
					{
						echo "<td width='100' align='left'>".$Fila["fecha_generacion"]."&nbsp;</td>";
						$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut_generador"]."'";
						$Respuesta4 = mysqli_query($link, $Consulta);
						if($Fila4 = mysqli_fetch_array($Respuesta4))
						{
							$Nombre1 = substr(strtoupper($Fila4["nombres"]),0,1).". ".ucwords(strtolower($Fila4["apellido_paterno"]));
							echo "<td width='100' align='center'>".$Nombre1."</td>";
						}
						else
						{
							echo "<td width='100' align='center'>&nbsp;</td>";	
						}
						echo "<td width='69' align='center'><a href=\"JavaScript:Certificado('".$Fila["num_certificado"]."','".$Fila["corr_enm"]."')\">\n";
						echo $Fila["num_certificado"]."</td>\n";
					}
					echo "</tr>";
				}
			}
		} 
	}	
						
	if ($Estado =='A')
	{
				$Consulta2 = "SELECT * from sec_web.solicitud_certificado t1, sec_web.programa_codelco t2";
				$Consulta2.= " where substring(fecha_hora,1,7)='".$Fecha_Envio."' ";
					//or substring(fecha_hora,1,7)='".$Fecha_Envio1."') ";
				$Consulta2.= " and  t1.corr_enm=t2.corr_codelco";
				$Consulta2.= " and estado_certificado = 'A' order by t1.fecha_hora";
							//echo "WW".$Consulta2;
				$Respuesta2 = mysqli_query($link, $Consulta2);
				while($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					echo "<tr>";
					$Emisor = $Fila2["rut_generador"];
					//$FechaEmision = $Fila2["fecha"];
					$NumCertificado = $Fila2["num_certificado"];
					echo "<td width='18'><input name='radiolote' type='radio'  value='".$Fila2["corr_enm"]."~~".$Fila2["cod_bulto"]."~~".$Fila2["num_bulto"]."'></td>";
					echo "<td width='70' align='center'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</td>\n";
					$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
					$Consulta.= " where cod_producto = '".$Fila2["cod_producto"]."' and cod_subproducto = '".$Fila2["cod_subproducto"]."'";
					$ResP = mysqli_query($link, $Consulta);
					if ($FilaP = mysqli_fetch_array($ResP))
					{
						echo "<td width='133' align='left'>".strtoupper($FilaP["descripcion"])."</td>\n";
					}
					else
					{
						echo "<td width='133' align='left'>&nbsp;</td>\n";	
					}
					echo "<td width='90' align='center'>".strtoupper($Fila2["corr_enm"])."</td>\n";
					echo "<td width='75' align='center'>".substr($Fila2["fecha_hora"],8,2).".".substr($Fila2["fecha_hora"],5,2).".".substr($Fila2["fecha_hora"],0,4)." ".substr($Fila2["fecha_hora"],11)."</td>\n";
					$Consulta2 = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila2["rut"]."'";
					$ResR = mysqli_query($link, $Consulta2);
					if ($FilaR = mysqli_fetch_array($ResR))
					{
						$Nombre = substr(strtoupper($FilaR["nombres"]),0,1).". ".ucwords(strtolower($FilaR["apellido_paterno"]));
						echo "<td width='82' align='center'>".$Nombre."</td>\n";
					}
					else
					{
						echo "<td width='82' align='center'>&nbsp;</td>\n";	
					}
					$Emisor = "";
					$FechaEmision = "";
					$Consulta2 = "SELECT * from sec_web.certificacion_catodos where corr_enm = '".$Fila2["corr_enm"]."' and (substring(fecha,1,7)='".$Fecha_Envio."' or substring(fecha,1,7)='".$Fecha_Envio1."') ";
					$ResF = mysqli_query($link, $Consulta2);
							//echo "RR".$Consulta2;
					if ($FilaF = mysqli_fetch_array($ResF))
					{
						$Emisor = $FilaF["rut"];
						$FechaEmision = $FilaF["fecha"];
						$NumCertificado = $FilaF["num_certificado"];
						$ConCertificado = "S";
						if ($FechaEmision != "")
							echo "<td width='75' align='center'>".substr($FechaEmision,8,2).".".substr($FechaEmision,5,2).".".substr($FechaEmision,0,4)." ".substr($FechaEmision,11)."</td>\n";
						else
							echo "<td width='75' align='center'>&nbsp;</td>\n";
						if ($Emisor != "")
						{
							$Consulta2 = "select * from proyecto_modernizacion.funcionarios where rut = '".$Emisor."'";
							$ResE = mysqli_query($link, $Consulta2);
							if ($FilaE = mysqli_fetch_array($ResE))
							{
								$Nombre = substr(strtoupper($FilaE["nombres"]),0,1).". ".ucwords(strtolower($FilaE["apellido_paterno"]));
								echo "<td width='73' align='center'>".$Nombre."</td>\n";
							}
							else
							{
								echo "<td width='73' align='center'>&nbsp;</td>\n";
							}		
						}
						if ($ConCertificado == "S")
						{
							//echo "<td width='72' align='center'><a href=\"JavaScript:Detalle('".$NumCertificado."','".$Idioma."')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'>\n";
							echo "<td width= '72' align='center'>".$NumCertificado."</td>\n";
						}
						else
						{
							echo "<td width='72' align='center'>&nbsp;</td>\n";
						}
					}	
					echo "</tr>";	
				}	
		} 
		?></table>
        <br> <table width="<?php echo $Tamaño; ?>" border="0" class="TablaInterior">
          <tr> 
            
        <td width="270" height="22"  align="center">
<div align="left"></div></td>
            <td  align="center" width="327"><div align="left"> 
                <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:60px;" onClick="Imprimir();">
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              </div></td>
          </tr>
        </table>
     <!-- </td>
  </tr>
</table>-->
  </form>
  </center>
</body>
</html>
