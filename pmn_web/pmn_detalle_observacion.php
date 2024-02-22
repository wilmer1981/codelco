<?php

include("../principal/conectar_pmn_web.php");
$Rut =$CookieRut;
$RutOperador = $Operador01;
$Fecha = $Ano."-".$Mes."-".$Dia; 

$Hornada = $NumHorno."-".$NumFunda."-".$HornadaTotal."-".$HornadaParcial;
			
//echo "texto".$textotxt;
	
			$Consulta = "select * from pmn_web.observaciones where  fecha = '".$Fecha."'";
			$Consulta.= " and num_horno = '".$NumHorno."' and num_funda = '".$NumFunda."' and hornada_total = '".$HornadaTotal."' and hornada_parcial = '".$HornadaParcial."'";
	

			//echo $Consulta."<br>";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
				//Actualiza
		//echo "entro";
				$Actualizar = "UPDATE pmn_web.observaciones set";
				$Actualizar.= " observacion = '".$textotxt."',cod_subproducto ='".$SubProd."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and num_horno = '".$NumHorno."'";
				$Actualizar.= " and num_funda = '".$NumFunda."'";
				$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
				$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
				

				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
		}
		else 		
		{
		
			$insertar="INSERT INTO observaciones(rut,fecha,num_horno,num_funda,hornada_total,hornada_parcial,kwh_ini,kwh_fin,sacos_carbon,turno,cod_producto,cod_subproducto,observacion)";			
			$insertar.=" values ('".$RutOperador."','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$KwhIni."','".$KwhFin."','".$SacosCarbon."','".$Turno."','".$Prod."','".$SubProd."','".$textotxt."')";
			//echo $insertar."<br>";
			

			mysqli_query($link, $insertar);	
		}	
		header("location:pmn_principal_reportes.php?Mostrar=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&Tab8=true");


?>
