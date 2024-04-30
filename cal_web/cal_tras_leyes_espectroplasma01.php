<?php
include("../principal/conectar_principal.php");

if($Opcion=='Procesa')
{
	if($file_name!='none')
	{
		$Acento=false;
		$Extension=explode('.',$file_name);
		for ($j = 0;$j <= strlen($file_name[$Cont]); $j++)
		{
			switch(substr($file_name[$Cont],$j,1))
			{
				case "":
					$file_name=str_replace( "","a",$file_name);
				break;
				case "":
					$file_name=str_replace( "","A",$file_name);
				break;
				case "":
					$file_name=str_replace( "","e",$file_name);
				break;
				case "":
					$file_name=str_replace( "","E",$file_name);
				break;
				case "":
					$file_name=str_replace( "","i",$file_name);
				break;
				case "":
					$file_name=str_replace( "","I",$file_name);
				break;
				case "":
					$file_name=str_replace( "","o",$file_name);
				break;
				case "":
					$file_name=str_replace( "","O",$file_name);
				break;
				case "":
					$file_name=str_replace( "","u",$file_name);
				break;
				case "":
					$file_name=str_replace( "","U",$file_name);
				break;
				case "&":
					$file_name=str_replace( "&","",$file_name);
				break;
				case "$":
					$file_name=str_replace( "$","",$file_name);
				break;
				case "#":
					$file_name=str_replace( "#","",$file_name);
				break;
				case "'":
					$file_name=str_replace( "'","",$file_name);
				break;		
			}
		}
		if($Acento==false)
		{
			$NombreArchivo="EspectroPlasma.".$Extension[1];
			if(file_exists($NombreArchivo))
			{
				unlink($NombreArchivo);
			}	
			if (copy($file, $NombreArchivo))
			{
				$ProcesaArchivo = "S";
			}
			else
			{
				$ProcesaArchivo = "N";
				?>
				<script type="text/javascript">
				location.replace("cal_tras_leyes_espectroplasma.php?Msj=NC");
				</script>
				<?php
			}	
		}
	}
	if($ProcesaArchivo=='S')
	{
		  $ar=fopen("EspectroPlasma.txt","r") or die("No se pudo abrir el archivo");
		  $Comienza='N';
		  while (!feof($ar))
		  {
			$linea=fgets($ar);
			$lineasalto=explode(',',nl2br($linea));
			if(is_numeric($lineasalto[0]))
			{
				$CodLey=explode(' ',$lineasalto[1]);
				$Cadena=$Cadena.$lineasalto[0]."~".$CodLey[0]."~".$lineasalto[2]."//";
				$Comienza='S';
			}	
		  }
		  fclose($ar);
	
		$Elimina="delete from cal_web.tmp_espectroplasma where rut='".$CookieRut."'";
		mysqli_query($link, $Elimina);$SA='';
		if($Comienza=='S')
		{
		$Cadena=explode('//',$Cadena);
		while(list($c,$Datos2)=each($Cadena))
		{
			if($Datos2!='')
			{
				$Datos=explode('~',$Datos2);$Ley='';
				$ConsultaLey="select t1.cod_leyes from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
				$ConsultaLey.=" where t1.nro_solicitud='".$Datos[0]."' and upper(t2.abreviatura) like '".strtoupper($Datos[1])."%'";
				//$ConsultaLey="select cod_leyes from proyecto_modernizacion.leyes where upper(abreviatura)='".strtoupper($Datos[1])."'";
				$RespLey=mysqli_query($link, $ConsultaLey);
				if($FilasLey=mysqli_fetch_assoc($RespLey))
				{
					$Ley=$FilasLey["cod_leyes"];		
				}
				//echo $Datos[2]."<br>";
				$Valor=str_replace(',','.',$Datos[2]);
				$Inserta="insert into cal_web.tmp_espectroplasma (SA,ley,valor,rut) values('".$Datos[0]."','".$Ley."','".$Valor."','".$CookieRut."')";
				//echo $Inserta."<br>";
				mysqli_query($link, $Inserta);
			}
		}
			$Formato='S';
		}
		else
			$Formato='N';
		unlink("EspectroPlasma.txt");
	}	
	//header('location:cal_tras_leyes_espectroplasma.php?Msj=P&M=S&For='.$Formato);	
	?>
	<script type="text/javascript">
	//var Formato=<?php echo $Formato;?>;
	location.replace("cal_tras_leyes_espectroplasma.php?Msj=P&M=S&For=<?php echo $Formato;?>");
	</script>
	<?php
}
if($Opcion=='Guarda')
{
	$Consulta="select t1.ley,t1.SA,t1.cod_unidad,t1.signo,AVG(t1.valor) as valor_ley from cal_web.tmp_espectroplasma t1 where t1.rut='".$CookieRut."' and t1.graba='S' group by t1.rut,t1.SA,t1.ley";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);
	while($Filas=mysqli_fetch_assoc($Resp))
	{
		$Ley=$Filas[ley];
		$SA=$Filas[SA];
		$Unidad=$Filas[cod_unidad];
		$Signo=$Filas["signo"];
		$Valor=str_replace(',','.',$Filas[valor_ley]);
		$Consulta2 = "select t1.recargo";
		$Consulta2.=" from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2";
		$Consulta2.=" on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
		$Consulta2.=" where t1.nro_solicitud = '".$SA."' and t2.cod_leyes='".$Ley."'";
		$Consulta2.=" and (t1.recargo = '0' or t1.recargo = '' or isnull(t1.recargo)) ";
		$Consulta2.=" and (t1.estado_actual = '4' or t1.estado_actual='5')";
		$Consulta2.=" and (t2.proceso = '0' or t2.proceso = '2') ";
		$Resp2=mysqli_query($link, $Consulta2);
		//echo $Consulta2."<br>";
		if($Filas2=mysqli_fetch_assoc($Resp2))
		{
			$Consulta3="select t2.valor,t2.signo from cal_web.solicitud_analisis t1";
			$Consulta3.=" inner join cal_web.clasificacion_metodos_plasma t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta3.=" where t1.nro_solicitud = '".$SA."' and t1.recargo='".$Filas2["recargo"]."' and t2.cod_leyes='".$Ley."'";
			$Resp3=mysqli_query($link, $Consulta3);
			if($Fila3=mysqli_fetch_assoc($Resp3))
			{
				switch($Fila3["signo"])
				{
					case "<":
						if(floatval($Filas[valor_ley]) < floatval($Fila3[valor]))
						{
							$Valor=$Fila3[valor];
						}
					break;
					case ">":
						if(floatval($Fila3[valor]) > floatval($Filas[valor_ley]))	
						{
							$Valor=$Fila3[valor];
						}	
					break;
				}
			}	
			$Actualizar ="UPDATE cal_web.leyes_por_solicitud set";
			$Actualizar.=" valor = '".$Valor."',";
			$Actualizar.=" cod_unidad = '".$Unidad."',";
			$Actualizar.=" candado = '1',";
			$Actualizar.=" signo = '".$Signo."',";
			$Actualizar.=" proceso = '2',";
			$Actualizar.=" rut_quimico = '00000000-2'";
			$Actualizar.=" where nro_solicitud = '".$SA."' ";
			$Actualizar.=" and (recargo = '0' or recargo = '' or isnull(recargo)) ";
			$Actualizar.=" and (proceso = '0' or proceso = '2') ";
			$Actualizar.=" and cod_leyes = '".$Ley."'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar."<br>";
			$Consulta = "select * from cal_web.registro_leyes where nro_solicitud='".$SA."' and recargo='".$Filas2["recargo"]."'";
			$Consulta.= " and cod_leyes='".$Ley."' and valor='".$Valor."' and cod_unidad='".$Unidad."'";
			//echo $Consulta."<br>";
			$Resp3=mysqli_query($link, $Consulta);
			if(!$Fila3=mysqli_fetch_assoc($Resp3))
			{
				$FechaHora = date('Y-m-d H:i:s');
				$Insertar = "insert into cal_web.registro_leyes ";
				$Insertar.= " (rut_funcionario, fecha_hora, nro_solicitud, recargo, ";
				$Insertar.= " cod_leyes, valor, cod_unidad, candado, signo) values (";
				$Insertar.= " '00000000-2','".$FechaHora."','".$SA."',";
				$Insertar.= " '".$Filas2["recargo"]."','".$Ley."',";
				$Insertar.= "'".$Valor."'";
				$Insertar.= ",'".$Unidad."','1','".$Signo."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
		}
	}
	FinalizoSA();//FINALIZA SA Y TRASPASA A PI SI EL PRODUCTO-SUBPRODUCTO ESTA CONFIGURADO EN BD RAF_WEB TABLA ti_interfaces_cal_productos
	$Elimina="delete from cal_web.tmp_espectroplasma where rut='".$CookieRut."'";
	mysqli_query($link, $Elimina);
	?>
	<script type="text/javascript">
	location.replace("cal_tras_leyes_espectroplasma.php?Msj=C");
	</script>
	<?php
}

if($Opcion=='Elimina')
{
	$Dato=explode('~',$Valor);
	$Elimina="delete from cal_web.tmp_espectroplasma where rut='".$CookieRut."' and SA='".$Dato[0]."' and ley='".$Dato[1]."' and valor='".$Dato[2]."'";
	mysqli_query($link, $Elimina);
	?>
	<script type="text/javascript">
	location.replace("cal_tras_leyes_espectroplasma_proceso.php?Msj=E&SA=<?php echo $Dato[0];?>&Ley=<?php echo $Dato[1];?>");
	</script>
	<?php
}


function FinalizoSA()
{
	global $CookieRut;
	$Consulta="select SA from cal_web.tmp_espectroplasma t1 where t1.rut='".$CookieRut."' and graba='S' group by t1.SA";
	$Resp=mysqli_query($link, $Consulta);
	while($Filas=mysqli_fetch_assoc($Resp))
	{
		//$SA=date('Y').str_pad($Filas[SA],6,0,STR_PAD_LEFT);
		$SA=$Filas[SA];
		$Consulta = "select t1.cod_producto, t1.cod_subproducto, t1.nro_solicitud, t1.recargo, ";
		$Consulta.= " t2.proceso, t2.cod_leyes, t2.valor, t2.candado, t1.rut_funcionario, t1.estado_actual ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2";
		$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";
		$Consulta.= " and (t1.recargo = '0' or t1.recargo = '' or isnull(t1.recargo)) ";
		$RespFinal=mysqli_query($link, $Consulta);$TotalCandados=0;$TotalLeyes=0;
		while($FilasFinal=mysqli_fetch_assoc($RespFinal))
		{
				$Producto=$FilasFinal["cod_producto"];
				$SubProducto=$FilasFinal["cod_subproducto"];
				$RecargoAux = $FilasFinal["recargo"];
				$RutFuncionario = $FilasFinal["rut_funcionario"];
				$EstadoActual = $FilasFinal["estado_actual"];
				if($FilasFinal["candado"]== '1')
					$TotalCandados = $TotalCandados + 1;
				$TotalLeyes = $TotalLeyes + 1;
		}
		if(($TotalLeyes == $TotalCandados) && ($TotalLeyes > 0 && $TotalCandados > 0))
		{
			if(intval($EstadoActual)!='6')
			{
				/*ACTUALIZA ESTADO SOLICITUD_ANALISIS*/
				$Actualizar = "UPDATE cal_web.solicitud_analisis set ";
				$Actualizar.= " estado_actual = '6' ";
				$Actualizar.= " where nro_solicitud = '".$SA."' ";
				$Actualizar.= " and (recargo = '0' or recargo = '' or isnull(recargo)) ";
				mysqli_query($link, $Actualizar);
				
				/*INSERTA REGISTRO ESTADOS_POR_SOLICITUD*/
				$FechaHora = date('Y-m-d H:i:s');
				$Insertar = "insert into cal_web.estados_por_solicitud ";
				$Insertar.= "(rut_funcionario, nro_solicitud, recargo, cod_estado, fecha_hora, ult_atencion, rut_proceso) ";
				$Insertar.= " values('".$RutFuncionario."','".$SA."','".$RecargoAux."','6','".$FechaHora."','N','00000000-2')";
				mysqli_query($link, $Insertar);
			}
		}
		TraspasarDatoPI($Producto,$SubProducto,$SA);
	}
}
function TraspasarDatoPI($Producto,$SubProducto,$SA)
{
	$Consulta = "select t1.cod_producto,t1.cod_subproducto,t1.oblig_sa_fin,t2.descripcion as nom_producto,t3.descripcion as nom_subproducto ";
	$Consulta.=" from raf_web.ti_interfaces_cal_productos t1 inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.=" where t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."'";
	//echo $Consulta."<br>";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Cod_Prod=$Fila["cod_producto"];
		$Cod_SubProd=$Fila["cod_subproducto"];
		$Nom_Prod=$Fila["nom_producto"];
		$Nom_SubProd=$Fila["nom_subproducto"];
		$ObligaFin=$Fila["oblig_sa_fin"];
		$Consulta= "select t1.nro_solicitud,t1.fecha_hora,t1.id_muestra,t1.fecha_muestra,t2.valor,t3.abreviatura as nombre_leyes,t4.abreviatura as nombre_unidad ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora ";
		$Consulta.= " and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes inner join proyecto_modernizacion.unidades t4 on t2.cod_unidad=t4.cod_unidad ";
		$Consulta.= " where t1.nro_solicitud='".$SA."' and t1.cod_producto='".$Cod_Prod."' and t1.cod_subproducto='".$Cod_SubProd."'";
		if($ObligaFin=='S')
			$Consulta.= " and t1.estado_actual in ('6') ";
		else
			$Consulta.= " and t1.estado_actual in ('5','6') ";
		//echo 	$Consulta."<br>";	
		$RespLey=mysqli_query($link, $Consulta);$EncontroFecCos='N';$FechaCosecha=NULL;
		while($FilaLey=mysqli_fetch_array($RespLey))
		{
			$Fecha_hora=$FilaLey["fecha_hora"];
			$Id_Muestra=$FilaLey["id_muestra"];
			$Fecha_Muestra=$FilaLey["fecha_muestra"];
			$Ley=$FilaLey["nombre_leyes"];
			/*if is_null($FilaLey["valor"])
				$Valor_Ley="";
			else*/
				$Valor_Ley=$FilaLey["valor"];
			$Unidad=$FilaLey["nombre_unidad"];
			
			$FechAuxGrupo='';
			/*if($Cod_Prod=='18')//SOLO PARA CATODOS OBTENER FECHA COSECHA
			{
				$FechaSep=explode('-',$Fecha_Muestra);
				$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-2,$FechaSep[0]));	
				$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2]+2),$FechaSep[0]));
				$FecActual=date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2],$FechaSep[0]));
				$FecMuestraSup=date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+2,$FechaSep[0]));
				list($anoX,$mesX,$diaX)=explode('-',$FecMuestraSup);
				$FecMuestraSup=mktime(0,0,0,$mesX,$diaX,$anoX);
				$FecMuestraInf=date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-2,$FechaSep[0]));
				list($anoX,$mesX,$diaX)=explode('-',$FecMuestraInf);
				$FecMuestraInf=mktime(0,0,0,$mesX,$diaX,$anoX);
				$Consulta="select fecha_renovacion,dia_renovacion from sec_web.renovacion_prog_prod where ceiling(cod_grupo) ='".intval($Id_Muestra)."' and cod_grupo <>'' and cod_concepto <> 'D' ";
				$Consulta.=" order by fecha_renovacion desc,dia_renovacion desc";
				//echo $Consulta."<br>";
				$RespCosecha=mysqli_query($link, $Consulta);
				while($FilaCosecha=mysqli_fetch_array($RespCosecha))
				{
					$FechAuxGrupo=explode('-',$FilaCosecha[fecha_renovacion]);
					$FechAuxGrupo=$FechAuxGrupo[0]."-".intval($FechAuxGrupo[1])."-".$FilaCosecha[dia_renovacion];
					$fecha_operar=$FechAuxGrupo;
					list($anoX,$mesX,$diaX)=explode('-',$fecha_operar);
					$fecha_operar=mktime(0,0,0,$mesX,$diaX,$anoX);
					if ($fecha_operar<=$FecMuestraSup&&$fecha_operar>=$FecMuestraInf)
						break;
				}
				$FechaCosecha=$FechAuxGrupo;
			}*/
			$Consulta="select * from raf_web.ti_interfaces_cal where NUM_SOLICITUD='".$SA."' and FECHA_CREACION='".$Fecha_hora."' and COD_PRODUCTO='".$Cod_Prod."' and COD_SUBPRODUCTO ='".$Cod_SubProd."' and C_ELEMENTO='".$Ley."'";
			$Resp3=mysqli_query($link, $Consulta);
			if($FilaResp=mysqli_fetch_array($Resp3))
			{
				$Actualizar="UPDATE raf_web.ti_interfaces_cal set C_LEY='".str_replace(",", ".",$Valor_Ley)."',C_UNIDAD_ELEMENTO='".$Unidad."',FECHA_COSECHA='".$FechaCosecha."' where NUM_SOLICITUD='".$SA."' and FECHA_CREACION='".$Fecha_hora."' and COD_PRODUCTO='".$Cod_Prod."' and COD_SUBPRODUCTO ='".$Cod_SubProd."' and C_ELEMENTO='".$Ley ."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				$Insertar="insert into raf_web.ti_interfaces_cal (NUM_SOLICITUD,FECHA_CREACION,COD_PRODUCTO,COD_SUBPRODUCTO,NOM_PRODUCTO,NOM_SUBPRODUCTO,ID_MUESTRA,FECHA_MUESTRA,C_ELEMENTO,C_LEY,C_UNIDAD_ELEMENTO,FECHA_COSECHA) values ";
				$Insertar.="('".$SA."','".$Fecha_hora."','".$Cod_Prod."','".$Cod_SubProd."','".$Nom_Prod."','".$Nom_SubProd."','".$Id_Muestra."','".$Fecha_Muestra."','".$Ley."','".str_replace(",", ".",$Valor_Ley)."','".$Unidad."','".$FechaCosecha."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
		}
	}
}

?>