<?php
	include("../principal/conectar_pmn_web.php");
	include("pmn_funciones.php");	

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["PesoNeto"])){
		$PesoNeto = $_REQUEST["PesoNeto"];
	}else{
		$PesoNeto = "";
	}
	if(isset($_REQUEST["BACV"])){
		$BACV = $_REQUEST["BACV"];
	}else{
		$BACV = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia=$_REQUEST["Dia"];
	}else{
		$Dia="";
	}
	if(isset($_REQUEST["Mes"])){
			$Mes=$_REQUEST["Mes"];
		}else{
			$Mes="";
		}
	if(isset($_REQUEST["Ano"])){
			$Ano=$_REQUEST["Ano"];
	}else{
		$Ano="";
	}


	$Fecha = $Ano."-".$Mes."-".$Dia;
	$Fecha2 = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Insertar = "INSERT INTO pmn_web.pmn_pesa_bad_cabecera ";
			$Insertar.= "(lote,fecha_hora)";
			$Insertar.= "values('".$Lote."','".$Fecha."')";
			mysqli_query($link, $Insertar);
			

			$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
			$Consulta.= " where lote='".$Lote."' and recargo='".$Recargo."'";
			$Respuesta = mysqli_query($link, $Consulta);
			$Row = mysqli_fetch_array($Respuesta);
			$PesoNetoAnterior=$Row["pneto"];

			$Elimina="delete from pmn_web.pmn_pesa_bad_detalle where lote='".$Lote."' and recargo='".$Recargo."'";
			mysqli_query($link, $Elimina);
			
			$Insertar = "INSERT INTO pmn_web.pmn_pesa_bad_detalle ";
			$Insertar.= "(lote, recargo, fecha_hora,num_lixiviacion,pbruto,ptara,pneto,sint,sext,obs,peso_total) ";
			$Insertar.= "values('".$Lote."','".$Recargo."','".$Fecha2." ".date('G:i:s')."','".$Lixiviacion."','".str_replace(',','.',$PesoBruto)."','".str_replace(',','.',$PesoTara)."','".$PesoNeto."','".$SInt."','".$SExt."','".$Obs."','".str_replace(',','.',$PesoTotal)."')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			
			modificaStock($Lote,$Lixiviacion,$Recargo,$PesoNeto,'E',$PesoNetoAnterior);
			
			Bitacora($Lote,$Recargo,$Fecha,$Lixiviacion,str_replace(',','.',$PesoBruto),str_replace(',','.',$PesoTara),$PesoNeto,$SInt,$SExt,'Se ingresa peso - conformacin Lote. '.$Obs,'I','','','','');
			header("location:pmn_pesaje.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&LR=".$Lote."&Lixiviacion=".$Lixiviacion);
		break;
		case "G2": //GRABAR
			$Fecha2=$Ano."-".$Mes."-".$Dia;
			
			$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
			$Consulta.= " where lote='".$Lote."' and recargo='".$Recargo."'";
			$Respuesta = mysqli_query($link, $Consulta);
			$Row = mysqli_fetch_array($Respuesta);
			$PesoNetoAnterior=$Row["pneto"];
			$SInt=$Row["sint"];
			$SExt=$Row["sext"];
			$Obs=$Row["obs"];

			$PesoBruto=$PesoTara+$PesoNeto;
			$Insertar = "INSERT INTO pmn_web.pmn_pesa_bad_detalle ";
			$Insertar.= "(lote, recargo, fecha_hora,num_lixiviacion,pbruto,ptara,pneto,sint,sext,obs) ";
			$Insertar.= "values('".$Lote."','".$Recargo."','".$Fecha2." ".date('G:i:s')."','".$Lixiviacion."','".str_replace(',','.',$PesoBruto)."','".str_replace(',','.',$PesoTara)."','".str_replace(',','.',$PesoNeto)."','".$SInt."','".$SExt."','".$Obs."')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			
			modificaStock($Lote,$Lixiviacion,$Recargo,str_replace(',','.',$PesoNeto),'E',0);
			
			Bitacora($Lote,$Recargo,$Fecha2,$Lixiviacion,str_replace(',','.',$PesoBruto),str_replace(',','.',$PesoTara),$PesoNeto,$SInt,$SExt,'Se completa peso - conformacin Lote. '.$Obs,'I','','','','');
			header("location:pmn_ing_pesaje02.php?Lote=".$Lote."&Recargo=".$Recargo);
		break;		
		case "PPl":
			$Actualiz="UPDATE pmn_web.pmn_pesa_bad_cabecera set peso_palet_a='".str_replace(',','.',$pesoPaletA)."',peso_palet_b='".str_replace(',','.',$pesoPaletB)."' where lote='".$Lote."'";
			mysqli_query($link, $Actualiz);
			Bitacora($Lote,'',date('Y-m-d G:i:s'),'','','','','','','Se Peso Palet A Lote.','I','','',str_replace(',','.',$pesoPaletA),'');
			Bitacora($Lote,'',date('Y-m-d G:i:s'),'','','','','','','Se Peso Palet B Lote.','I','','',str_replace(',','.',$pesoPaletB),'');
			header("location:pmn_pesaje.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&LR=".$Lote."&Lixiviacion=".$Lixiviacion."&Msj=PplS");
		break;
		case "E":
			$Valores=explode('//',$Valores);
			while(list($c,$v)=each($Valores))
			{
				// ELIMINA DETALLE
				$Dato=explode('~',$v);
				$Consulta = "select recargo from pmn_web.pmn_pesa_bad_detalle ";
				$Consulta.= " where lote='".$Dato[0]."' order by recargo desc";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if($Row2 = mysqli_fetch_array($Respuesta2))
						$UltimoRec=$Row2["recargo"];
				if($UltimoRec <= $Dato[1])		
				{
					$Consulta = "select * from pmn_web.pmn_pesa_bad_detalle ";
					$Consulta.= " where lote='".$Dato[0]."' and recargo='".$Dato[1]."' and fecha_hora='".$Dato[2]."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if($Row = mysqli_fetch_array($Respuesta))
					{
						$Recargo=$Row["recargo"];
						$Lixiviacion=$Row["num_lixiviacion"];
						$Fecha=$Row["fecha_hora"];
						$PesoNeto=$Row["pneto"];
						$PesoTara=$Row["ptara"];
						$PesoBruto=$Row["pbruto"];
						$Obs=$Row["obs"];
						$SInt=$Row["sint"];
						$SExt=$Row["sext"];
						
						modificaStock($Lote,$Lixiviacion,$Recargo,$PesoNeto,'S','');
						
						Bitacora($Lote,$Recargo,$Fecha,$Lixiviacion,$PesoBruto,$PesoTara,$PesoNeto,$SInt,$SExt,'Se elimina peso - conformacin Lote. '.$Obs,'E','','','','');
						$Elimina="delete from pmn_web.pmn_pesa_bad_detalle where lote='".$Dato[0]."' and recargo='".$Dato[1]."' and fecha_hora='".$Dato[2]."'";
						//echo $Elimina."<br />";
						mysqli_query($link, $Elimina);
						if($Recargo==1)
						{
							$Elimina="delete from pmn_web.pmn_pesa_bad_cabecera where lote='".$Dato[0]."'";
							//echo $Elimina."<br />";
							//mysqli_query($link, $Elimina);
						}
					}
					header("location:pmn_pesaje.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&LR=".$Lote."&Msj=E&Lixiviacion=".$Lixiviacion);
				}
				else
					header("location:pmn_pesaje.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&LR=".$Lote."&Msj=EN&Lixiviacion=".$Lixiviacion);
			}			
			break;
		case "C": //CANCELAR
			header("location:pmn_pesaje.php");
			break;
		case "LAnt": //CANCELAR
			header("location:pmn_pesaje.php?Opcion=LAnt&Anor=".$Ano."&Mesr=".$Mes."&Diar=".$Dia);
			break;
		case "BAC":
			$Cnsulta="select * from pmn_web.pmn_pesa_bad_cabecera where lote='".$Lote."'";
			$Resp=mysqli_query($link, $Cnsulta);
			if($Fila=mysqli_fetch_assoc($Resp))
			{
				$Actualiz="UPDATE pmn_web.pmn_pesa_bad_cabecera set";
				if($BACV=='true')
				{	$Actualiz.=" BAC='S'"; $Msj='1';}
				if($BACV=='false')
				{	$Actualiz.=" BAC=null"; $Msj='2';}
				$Actualiz.=" where lote='".$Lote."'";
				//echo $Actualiz;
				mysqli_query($link, $Actualiz);	
			}
			else
			{
				$Inserta="INSERT INTO pmn_web.pmn_pesa_bad_cabecera value('".$Lote."','".date('Y-m-d G:h:s')."'";
				if($BACV=='true')
					$Inserta.=",'S'";
				else
					$Inserta.=",null";	
				$Inserta.=",null,null)";
				mysqli_query($link, $Inserta);	
			}
			header("location:pmn_pesaje.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&LR=".$Lote."&Lixiviacion=".$Lixiviacion."&Msj=Bac".$Msj);
		break;	
	}
?>