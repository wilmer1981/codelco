<?php
	include("../principal/conectar_sec_web.php");
	$Entro=false;
	
	$TxtGuia1   = $_REQUEST["TxtGuia1"];
	$TxtGuia2   = $_REQUEST["TxtGuia2"];

	$Procesa = 0;
	$Consulta="select num_guia,fecha_guia,patente_guia from sec_web.guia_despacho_emb where num_guia= '".$TxtGuia1."' order by fecha_guia desc";
	$Resp1=mysqli_query($link, $Consulta);
	if ($Fila1=mysqli_fetch_array($Resp1))
	{
		$NumGuia1=$Fila1["num_guia"];
		$FechaGuia1=$Fila1["fecha_guia"];
		$Procesa  = $Procesa  + 1;
	}
	$Consulta="select num_guia,fecha_guia,patente_guia from sec_web.guia_despacho_emb where num_guia= '".$TxtGuia2."' order by fecha_guia desc ";
	$Resp2=mysqli_query($link, $Consulta);
	if ($Fila2=mysqli_fetch_array($Resp2))
	{
		$NumGuia2=$Fila2["num_guia"];
		$FechaGuia2=$Fila2["fecha_guia"];
		$Procesa  = $Procesa  + 1;
	}
	if ($Procesa ==2)
	{
		$Actualizar=" UPDATE sec_web.guia_despacho_emb set  num_guia_aux='".$NumGuia1."',num_guia='999999' ";
		$Actualizar.="   where num_guia ='".$TxtGuia1."' and fecha_guia='".$FechaGuia1."'";
		mysqli_query($link, $Actualizar);

		$Actualizar=" UPDATE sec_web.det_guia_despacho_emb set num_guia_aux='".$NumGuia1."',num_guia='999999'  ";
		$Actualizar.="   where num_guia ='".$TxtGuia1."' and fecha_guia='".$FechaGuia1."'";
		mysqli_query($link, $Actualizar);	

    	$Actualizar1=" UPDATE sec_web.guia_despacho_emb set num_guia='".$TxtGuia1."',fecha_guia='".$FechaGuia1."' ";
		$Actualizar1.="  where num_guia ='".$TxtGuia2."' and fecha_guia='".$FechaGuia2."'";
		mysqli_query($link, $Actualizar1);
	
		$Actualizar=" UPDATE sec_web.det_guia_despacho_emb set num_guia_aux='".$NumGuia2."',num_guia='".$TxtGuia1."'  ";
		$Actualizar.="   where num_guia ='".$TxtGuia2."' and fecha_guia='".$FechaGuia2."'";
		mysqli_query($link, $Actualizar);

		$Actualizar2=" UPDATE sec_web.guia_despacho_emb set num_guia='".$TxtGuia2."',fecha_guia='".$FechaGuia2."' ";
		$Actualizar2.="   where num_guia ='999999' ";
		mysqli_query($link, $Actualizar2);

		$Actualizar=" UPDATE sec_web.det_guia_despacho_emb set num_guia='".$TxtGuia2."'  ";
		$Actualizar.="   where num_guia ='999999'";
		mysqli_query($link, $Actualizar);	
	
		$Actualizar=" UPDATE sec_web.paquete_catodo set fecha_embarque='".$FechaGuia2."',num_guia='999999'  ";
		$Actualizar.="   where num_guia = '".$TxtGuia1."' and fecha_embarque='".$FechaGuia1."'";
		mysqli_query($link, $Actualizar);

		$Actualizar1=" UPDATE sec_web.paquete_catodo set fecha_embarque='".$FechaGuia1."',num_guia='".$TxtGuia1."'  ";
		$Actualizar1.="   where num_guia = '".$TxtGuia2."' and fecha_embarque='".$FechaGuia2."' ";
		mysqli_query($link, $Actualizar1);
	
		$Actualizar=" UPDATE sec_web.paquete_catodo set num_guia='".$TxtGuia2."' ";
		$Actualizar.="   where num_guia = '999999' ";
		mysqli_query($link, $Actualizar);
	}
	if ($Procesa ==1)
	{
	    $Actualizar1=" UPDATE sec_web.guia_despacho_emb set num_guia='".$TxtGuia2."', fecha_guia = '".$FechaGuia1."' ";
		$Actualizar1.="  where num_guia ='".$TxtGuia1."' and fecha_guia='".$FechaGuia1."'";
		mysqli_query($link, $Actualizar1);
		
		$Actualizar=" UPDATE sec_web.det_guia_despacho_emb set num_guia='".$TxtGuia2."' ";
		$Actualizar.="   where num_guia ='".$TxtGuia1."' and fecha_guia='".$FechaGuia1."'";
		mysqli_query($link, $Actualizar);	

		$Actualizar1=" UPDATE sec_web.paquete_catodo set num_guia='".$TxtGuia2."'  ";
		$Actualizar1.="   where num_guia = '".$TxtGuia1."' and fecha_embarque='".$FechaGuia1."' and cod_estado = 'c' ";
		mysqli_query($link, $Actualizar1);

	}
	
	header("location:sec_modifica_numguia.php?TxtGuia1=".$TxtGuia1."&TxtGuia2=".$TxtGuia2."&Mensaje=S");
	
		
	
mysqli_close($link);
?>