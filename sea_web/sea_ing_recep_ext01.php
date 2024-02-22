<?php  
    include("../principal/conectar_sea_web.php");

//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = '';
}
if(isset($_REQUEST["mes"])) {
	$mes= $_REQUEST["mes"];
}else{
	$mes = '';
}
if(isset($_REQUEST["dia"])) {
	$dia= $_REQUEST["dia"];
}else{
	$dia = '';
}
	
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
//*******************************************************************************//
//Proceso=M&&valores_cmbanodos=&valores_lote=&valores_recargo=&valores_hornada=&valores_unidades=&valores_peso=
if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["valores_cmbanodos"])) {
	$valores_cmbanodos = $_REQUEST["valores_cmbanodos"];
}else{
	$valores_cmbanodos = '';
}
if(isset($_REQUEST["valores_lote"])) {
	$valores_lote = $_REQUEST["valores_lote"];
}else{
	$valores_lote = '';
}
if(isset($_REQUEST["valores_recargo"])) {
	$valores_recargo = $_REQUEST["valores_recargo"];
}else{
	$valores_recargo = '';
}
if(isset($_REQUEST["valores_hornada"])) {
	$valores_hornada = $_REQUEST["valores_hornada"];
}else{
	$valores_hornada = '';
}
if(isset($_REQUEST["valores_unidades"])) {
	$valores_unidades = $_REQUEST["valores_unidades"];
}else{
	$valores_unidades = '';
}
if(isset($_REQUEST["valores_peso"])) {
	$valores_peso = $_REQUEST["valores_peso"];
}else{
	$valores_peso = '';
}

if(isset($_REQUEST["Hora"])) {
	$Hora = $_REQUEST["Hora"];
}else{
	$Hora = '';
}
if(isset($_REQUEST["Minutos"])) {
	$Minutos = $_REQUEST["Minutos"];
}else{
	$Minutos = '';
}


//Modificar
if ($Proceso == 'M')
{
    $fecha = $ano.'-'.$mes.'-'.$dia;
	$FechaHora=$fecha." ".$Hora.":".$Minutos.":00";	
	//while (list($clave,$valor) = each($a))
	foreach ($a as $clave => $valor)
	{
	    $unidades_nuevas = '';
		$consulta = "SELECT *  from hornadas where hornada_ventana = '".$hornada[$clave]."' ";
		$rs = mysqli_query($link, $consulta);
		if($row = mysqli_fetch_array($rs))
		{
           $unidades_nuevas = $row["unidades"] - $unidades_ant[$clave];
		   $unidades_nuevas = $unidades_nuevas + $unidades[$clave];

           $peso_unidades = $row["peso_unidades"] - $peso_ant[$clave];
		   $peso_unidades = $peso_unidades + $peso[$clave];
 
		$Actualizar = "UPDATE hornadas set unidades = '".$unidades_nuevas."', peso_unidades = '".$peso_unidades."' WHERE hornada_ventana = '".$hornada[$clave]."' ";
        mysqli_query($link, $Actualizar);
		

		}


		$Actualizar1 = "UPDATE movimientos set fecha_movimiento='".$fecha."',hora='".$FechaHora."',unidades = '".$unidades[$clave]."', peso = '".$peso[$clave]."' WHERE fecha_movimiento = '".$FechaMov."' AND campo1 = '".$guia."'  AND campo2 = '".$patente."' AND hornada = '".$hornada[$clave]."' ";
        mysqli_query($link, $Actualizar1);  
        //echo   $Actualizar1;
	}			

		echo "<Script>
			JavaScript:window.close();
			</Script>";

}

if($Proceso == "E")
{
    $fecha = $ano.'-'.$mes.'-'.$dia;
	//while (list($clave,$valor) = each($checkbox))
	foreach ($checkbox as $clave => $valor)
	{

		 $Consulta = "SELECT * FROM hornadas WHERE hornada_ventana = '".$checkbox[$clave]."' ";
		 $rs = mysqli_query($link, $Consulta);
   		 if($row = mysqli_fetch_array($rs))
		 {		 
           $saldo_unidades = $row["unidades"] - $unidades[$clave];
           $saldo_peso = $row["peso_unidades"] - $peso[$clave];
		 }  		  		
         
 		 $Consulta = "SELECT SUM(unidades) as unid FROM movimientos WHERE tipo_movimiento in ('2','4') AND hornada = '".$checkbox[$clave]."' ";
         $rs2 = mysqli_query($link, $Consulta);
	
		 if($row2 = mysqli_fetch_array($rs2))
		 {		 
		    $unid_benef = $row2["unid"];
		 }
		 else
		 {
		    $unid_benef = 0;
		 }

         if($unid_benef <= $saldo_unidades)
		 {
			//$Actualizar = "UPDATE hornadas SET unidades = $saldo_unidades, peso_unidades = $saldo_peso WHERE hornada_ventana = $checkbox[$clave]";
			//mysqli_query($link, $Actualizar);
		
			//$Eliminar = "DELETE FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND campo1= '$guia' AND campo2 = '$patente' AND hornada = $checkbox[$clave]";		 
			//mysqli_query($link, $Eliminar);		 
		 }
		 else
		{
		 
		  	echo '<script language="JavaScript">';
			echo 'alert("Movimiento a eliminar mayor que saldo de Hornada");';
			echo 'window.history.back()';
			echo '</script>';
			break;
		}

    }

    $valores = "?mostrar2=S&guia=".$guia."&patente=".$patente."&fecha=".$fecha;
	header("Location:sea_ing_recep_ext.php".$valores);	

}
    include("../principal/cerrar_sea_web.php");
?>