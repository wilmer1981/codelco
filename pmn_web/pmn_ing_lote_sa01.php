<?php
	include("../principal/conectar_pmn_web.php");
	include("pmn_funciones.php");	

	switch ($Proceso)
	{
		case "G": //GRABAR
			$Valores=explode('//',$Valores);
			while(list($c,$v)=each($Valores))
			{
				$PPalet=str_replace('.','',$PesoPale[$v]);
				$PPalet=str_replace(',','.',$PPalet);
				$SA2=$SA[$v];
					
				$Insertar = "UPDATE pmn_web.pmn_pesa_bad_cabecera set nro_solicitud='".$SA2."',peso_palet='".$PPalet."'";
				$Insertar.= " where lote='".$v."'";
				mysqli_query($link, $Insertar);
				Bitacora($v,'','','','','','','','','','I','',$SA2,$PPalet,'');			
			}
			header("location:pmn_lote_sa.php?Consulta=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Msj=A");
			break;
		case "C": //CANCELAR
			header("location:pmn_embarque.php");
			break;
		case "ELote":	
			$Insertar = "UPDATE pmn_web.pmn_pesa_bad_cabecera set correlativo_sipa=null,fecha_embarque=null";
			$Insertar.= " where lote in (".str_replace('//',',',$Valores).")";
			mysqli_query($link, $Insertar);
			header("location:pmn_ing_embarque02.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&DiaF=".$DiaF."&MesF=".$MesF."&AnoF=".$AnoF."&Corr=".$Corr);
		break;
	}
?>