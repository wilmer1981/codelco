<?php 	
	include("../principal/conectar_sec_web.php");	
	
	//$link = mysql_connect('10.56.11.7','adm_bd','672312');
	//mysql_SELECT_db("sec_web", $link);	
	
	$Consulta ="SELECT p.fecha_creacion_paquete,d.cod_paquete, d.num_paquete, p.peso_paquetes, p.num_unidades ";
	$Consulta.=" from  sec_web.paquete_catodo p, sec_web.det_guia_despacho_emb d where p.cod_paquete = d.cod_paquete ";
	$Consulta.=" and p.num_paquete = d.num_paquete and p.num_guia = d.num_guia and p.num_guia = '".$TxtGuia2."' ";
	$Consulta.=" and d.num_guia = '".$TxtGuia2."'";
	//echo $Consulta."<br><br>";
	$R=mysqli_query($link, $Consulta);
	$Contador=mysql_num_rows($R);$Log='';
	while($Listar=mysqli_fetch_assoc($R))
	{
		//FechaAux = Year(paquetes.TextMatrix(i, 6)) & "-" & Month(paquetes.TextMatrix(i, 6)) & "-" & Day(paquetes.TextMatrix(i, 6))
		$Actualiza= "UPDATE paquete_catodo set cod_estado='a',fecha_embarque='0000-00-00',num_guia='0',sw='2' where cod_paquete = '".$Listar["cod_paquete"]."' and num_paquete = '".$Listar["num_paquete"]."' and fecha_creacion_paquete='".$Listar[fecha_creacion_paquete]."'";
		//echo $Actualiza."<br><br>";
		mysqli_query($link, $Actualiza);
		$Log.=$Actualiza."<br>";

        //MsgBox "actualizo lote_catodo"
        //FechaAux = Year(paquetes.TextMatrix(i, 6)) & "-" & Month(paquetes.TextMatrix(i, 6)) & "-" & Day(paquetes.TextMatrix(i, 6))
        $p2 = "UPDATE lote_catodo set cod_estado='a',sw='2' WHERE  COD_bulto = '".$CodLote."' AND NUM_bulto = '".$NumLote."' and cod_paquete = '".$Listar["cod_paquete"]."' and num_paquete = '".$Listar["num_paquete"]."' and fecha_creacion_paquete='".$Listar[fecha_creacion_paquete]."'";
		//echo $p2."<br><br>";
        mysqli_query($link, $p2);
		$Log.=$p2."<br>";

        //actualizo embarque_ventana
		//echo $despacho_paquetes_aux." - ".$contador."<br>";
		$Resta1=$despacho_paquetes_aux - $contador;
		//echo $despacho_peso_aux." - ".$aux_peso_neto."<br>";
		$Resta2=$despacho_peso_aux - $aux_peso_neto;
        $Consulta = "UPDATE embarque_ventana set despacho_paquetes=".$Resta1.",despacho_peso=".$Resta2.",sw='2' where num_envio = ".$Numenvio." and corr_enm = ".$InsEmb." and cod_bulto = '".$CodLote."'  and num_bulto = '".$NumLote."'";
   		//echo $Consulta."<br><br>";
		mysqli_query($link, $Consulta);
		$Log.=$Consulta."<br>";

        $Consulta = "UPDATE guia_despacho_emb set cod_estado='A',sw='2' where num_guia = '".$TxtGuia2."' and (cod_estado = 'I' or cod_estado = 'A')";
   		//echo $Consulta."<br><br>";
        mysqli_query($link, $Consulta);
		$Log.=$Consulta."<br>";

        $Consulta = "UPDATE control_guia set cod_guia='A' where numero_guia = '".$TxtGuia2."'";
   		//echo $Consulta."<br><br>";
        mysqli_query($link, $Consulta);
		$Log.=$Consulta."<br>";

        $Consulta = "delete from det_guia_despacho_emb WHERE num_guia  = '".$TxtGuia2."'";
   		//echo $Consulta."<br><br>";
        mysqli_query($link, $Consulta);
		$Log.=$Consulta."<br>";
        
        $Elimina = "delete from tmp_op26_139 WHERE num_guia  = '".$TxtGuia2."' and cod_lote = '".$CodLote." ' and num_lote = '".$NumLote."'";
   		//echo $Elimina."<br><br>";
        mysqli_query($link, $Elimina);
		$Log.=$Elimina."<br>";
        
        $Msj="Anulada";
        $Elimina = "delete from tmp_op26_16 where tmp_num_guia  = '".$TxtGuia2."' and tmp_cod_lote = '".$CodLote." ' and tmp_num_lote = '".$NumLote."'";
   		//echo $Elimina."<br>";
        mysqli_query($link, $Elimina);
		$Log.=$Elimina."<br><br><br>";
	}
	//CreaTablaRegistro();//CREA LA TABLA LOG SI NO EXISTE
	$GrabaLog="insert into sec_registro_log (fecha_hora,rut,log,descripcion)";
	$GrabaLog.="values('".date('Y-m-d G:i:s')."','".$CookieRut."','".str_replace("'","",$Log)."','Anulación de guía')";
	mysqli_query($link, $GrabaLog);
	header('location:sec_adm_anula_guia.php?Msj='.$Msj);
	
function CreaTablaRegistro()
{
	$CreateTable="
	CREATE TABLE IF NOT EXISTS sec_registro_log (
	  fecha_hora datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	  rut varchar(10) NOT NULL DEFAULT '',
	  log text,
	  descripcion varchar(255),
	  registro_actual text DEFAULT NULL,
	  registro_modificado text DEFAULT NULL,
	  PRIMARY KEY (fecha_hora,rut)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;
	";
}
?>