<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$RutOperador=$CookieRut;
	switch($Proceso)
	{
		case "PRV"://ACTUALIZAR PROVEEDORES
			$Consulta="SELECT * from rec_web.proved ";
			$RespPrv=mysqli_query($link, $Consulta);
			while($FilaPrv=mysqli_fetch_array($RespPrv))
			{
				$Consulta="SELECT * from sipa_web.proveedores where rut_prv='".$FilaPrv[RUTPRV_A]."'";
				$RespPrv2=mysqli_query($link, $Consulta);
				if(!$FilaPrv2=mysqli_fetch_array($RespPrv2))
				{
					$Insertar="INSERT INTO sipa_web.proveedores (rut_prv,nombre_prv) values(";
					$Insertar.="'$FilaPrv[RUTPRV_A]."','$FilaPrv[NOMPRV_A]."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
				}
			}
			break;
		case "LEI"://ACTUALIZAR LEYES E IMPUREZAS
			$Consulta="SELECT * from age_web.relaciones ";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Resp))
			{
				$Consulta="SELECT distinct t2.cod_leyes from age_web.lotes t1 inner join age_web.leyes_por_lote t2 on t1.lote=t2.lote ";
				$Consulta.="where t1.cod_producto='1' and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.rut_proveedor='".$Fila["rut_proveedor"]."' and t2.cod_leyes<>'01'";
				$Resp2=mysqli_query($link, $Consulta);
				$Leyes='';$Impurezas='';
				while($Fila2=mysqli_fetch_array($Resp2))
				{
					if($Fila2["cod_leyes"]=='02'||$Fila2["cod_leyes"]=='04'||$Fila2["cod_leyes"]=='05')
						$Leyes=$Leyes.$Fila2["cod_leyes"]."~";
					else
						$Impurezas=$Impurezas.$Fila2["cod_leyes"]."~";
				}
				$Leyes=substr($Leyes,0,strlen($Leyes)-1);
				$Impurezas=substr($Impurezas,0,strlen($Impurezas)-1);
				$Actualizar="UPDATE age_web.relaciones set leyes='$Leyes',impurezas='$Impurezas'";
				$Actualizar.="where cod_producto='1' and cod_subproducto='".$Fila["cod_subproducto"]."' and rut_proveedor='".$Fila["rut_proveedor"]."'";
				mysqli_query($link, $Actualizar);
			}
			header('location:rec_recepcion.php');
			break;
	}
?>