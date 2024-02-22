       ARREGLO DEL LOTE DEVUELTO POR FUNCION
---------------------------------------------------
$Lote["lote"] = $FilaPeso["peso_muestra"];
$Lote["recargo"] = $FilaPeso["peso_retalla"];
$Lote["peso_muestra"] = $FilaPeso["peso_muestra"];
$Lote["peso_retalla"] = $FilaPeso["peso_retalla"];
$Lote["cod_producto"] = $FilaPeso["cod_producto"];
$Lote["cod_subproducto"] = $FilaPeso["cod_subproducto"];
$Lote["fecha_recepcion"] = $FilaPeso["fecha_recepcion"];
$Lote["rut_proveedor"] = $FilaPeso["rut_proveedor"];
$Lote["cod_faena"] = $FilaPeso["cod_faena"];
$Lote["cod_recepcion"] = $FilaPeso["cod_recepcion"];
$Lote["clase_producto"] = $FilaPeso["clase_producto"];
$Lote["num_conjunto"] = $FilaPeso["num_conjunto"];
$Lote["peso_humedo"] = $PesoHumedo;
$Lote["peso_seco"] = $PesoSeco;	

       ARREGLO DE LEYES DEVUELTO POR FUNCION
---------------------------------------------------
$Leyes[$FilaLeyes["cod_leyes"]][0] --> CODIGO LEY
$Leyes[$FilaLeyes["cod_leyes"]][1] --> ABREVIATURA
$Leyes[$FilaLeyes["cod_leyes"]][2] --> VALOR
$Leyes[$FilaLeyes["cod_leyes"]][3] --> COD UNIDAD
$Leyes[$FilaLeyes["cod_leyes"]][4] --> NOM UNIDAD
$Leyes[$FilaLeyes["cod_leyes"]][5] --> CONVERSION
$Leyes[$FilaLeyes["cod_leyes"]][12] --> VALOR RETALLA
$Leyes[$FilaLeyes["cod_leyes"]][13] --> COD UNIDAD RETALLA
$Leyes[$FilaLeyes["cod_leyes"]][14] --> NOM UNIDAD RETALLA
$Leyes[$FilaLeyes["cod_leyes"]][15] --> CONVERSION RETALLA
$Leyes[$FilaLeyes["cod_leyes"]][22] --> VALOR INCIDENCIA

