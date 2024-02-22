<?php
	function ObtenerProveedorDespacho($TipoProceso,$RutPrv,$Corr,$Guia,$RutProved,$NombreProved)			
	{
		switch($TipoProceso)
		{
			case "R":
				break;
			case "D":
				$Consulta_1 = "SELECT distinct rut as rut_cliente,sigla_cliente from sec_web.cliente_venta ";
				$Consulta_1.= "where rut='$RutPrv'";
				//echo "uno".$Consulta_1;
				$Resp1 = mysqli_query($link, $Consulta_1);
				if($Fila1 = mysqli_fetch_array($Resp1))
				{
					$RutProved=$Fila1[rut_cliente];
					$NombreProved=$Fila1["sigla_cliente"];
				}
				else
				{
					$Consulta_2 = "SELECT distinct t2.rut_cliente,nombre_nave as sigla_cliente from sec_web.nave t1 inner join ";
					$Consulta_2.= "sec_web.sub_cliente_vta t2 on t1.cod_nave=t2.cod_cliente where rut_cliente ='$RutPrv' group by rut_cliente";
					//echo "dos".$Consulta_2;
					$Resp2 = mysqli_query($link, $Consulta_2);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{
						$RutProved=$Fila2[rut_cliente];
						$NombreProved=$Fila2["sigla_cliente"];
					}
					else
					{
						$Consulta_3 ="SELECT t3.cod_acopio,t3.cod_estiba,t3.tipo_embarque from sec_web.guia_despacho_emb t1 ";
						$Consulta_3.="inner join sec_web.embarque_ventana t3 on t3.num_envio=t1.num_envio and year (t3.fecha_embarque)='".date('Y')."'";
						$Consulta_3.="where  t1.num_guia='$Guia' and t1.cod_estado <> 'A'";
						$Consulta_3.="group by t3.cod_producto,t3.cod_subproducto	";
						//echo "tres".$Consulta_3;
						$RespSec=mysqli_query($link, $Consulta_3);
						$FilaSec=mysqli_fetch_array($RespSec);
						switch($FilaSec[tipo_embarque])
						{
							case "A":
								if($FilaSec[cod_acopio]!='')
									$CodPrestador=$FilaSec[cod_acopio];
								else
									$CodPrestador=$FilaSec["cod_estiba"];
								break;	
							case "E":
								if($FilaSec["cod_estiba"]!='')
									$CodPrestador=$FilaSec[cod_estiba];
								else
									$CodPrestador=$FilaSec[cod_acopio];
								break;	
						}	
						$Consulta_4= "SELECT distinct rut as rut_cliente,sigla as sigla_cliente from sec_web.prestador ";
						$Consulta_4.= "where cod_prestador_servicio='$CodPrestador' and rut ='$RutPrv' group by rut";
						//echo "cuatro".$Consulta_4;
						$Resp4 = mysqli_query($link, $Consulta_4);
						if($Fila4 = mysqli_fetch_array($Resp4))
						{
							$RutProved=$Fila4[rut_cliente];
							$NombreProved=$Fila4["sigla_cliente"];
						}
						else
						{
							$Consulta_5 = "SELECT distinct rut_cliente,nombre from pac_web.clientes where rut_cliente='$RutPrv'";
							//echo "cinco".$Consulta_5;
							$Resp5 = mysqli_query($link, $Consulta_5);
							if($Fila5 = mysqli_fetch_array($Resp5))
							{
								$RutProved=$Fila5[rut_cliente];
								$NombreProved=$Fila5["nombre"];
							}
							else
							{
								$Consulta_6 = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores where rut_prv='$RutPrv'";
								$Resp6 = mysqli_query($link, $Consulta_6);
								//echo "seis".$Consulta_6;
								if ($Fila6 = mysqli_fetch_array($Resp6))
								{
									$RutProved=$Fila6[rut_prv];
									$NombreProved=$Fila6["nombre_prv"];
									
								}
								else
								{
									$RutProved='9';
									$NombreProved='x';
								}
							}				
						}
					}
				}
				break;
		}		
	}
?>
