<?php
require_once('lib/nusoap.php');
require_once("../bd_mysqli.php");
require_once("../functions.php");

$URL       = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$namespace = $URL;

$server    = new soap_server;
$server->configureWSDL('Server_CalWeb_LIMS', $namespace);
$server->wsdl->schematargetNamespace = $namespace;

//------------------------METODO BUSCA SOLICITUD DEPENDIENDO DEL NUMERO DE SOLCIITUD O SOLICITUD LIMS-------------------------
$server->wsdl->addComplexType('responseConnectionBuscador','complexType','array','','SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:responseConnectionBuscador[]'
        )
    )
);

$server->register("sa_buscar_soap",
    array('numero_sa' => 'xsd:string','numero_sa_lims' => 'xsd:string'),
    array('result' => 'xsd:bool', 'response' => 'tns:responseConnectionBuscador', 'error' => 'xsd:string'),
    'urn:'.$namespace,
    'urn:closingorder#sa_buscar_soap',
    'rpc',
    'encoded',
    'Metodo solo para poder buscar una solicitud en la tabla, por numero de SA CALWEB o SA LIMS'
);



//------------------------METODO PARA LA INSERCIÓN DE LA SOLICITUD-------------------------
$server->wsdl->addComplexType('datos_sa_entrada', 
    'complexType', 
    'struct', 
    'all', 
    '',
    array(
    'rut_funcionario'   => array('name' => 'rut_funcionario'    , 'type' => 'xsd:string'),
    'fecha_hora'        => array('name' => 'fecha_hora'         , 'type' => 'xsd:string'),
    'id_muestra'        => array('name' => 'id_muestra'         , 'type' => 'xsd:string'),
    'recargo'           => array('name' => 'recargo'            , 'type' => 'xsd:string'),
    'nro_solicitud'     => array('name' => 'nro_solicitud'      , 'type' => 'xsd:string'),
    'peso_muestra'      => array('name' => 'peso_muestra'       , 'type' => 'xsd:string'),
    'cod_ccosto'        => array('name' => 'cod_ccosto'         , 'type' => 'xsd:string'),
    'cod_area'          => array('name' => 'cod_area'           , 'type' => 'xsd:int'),
    'cod_periodo'       => array('name' => 'cod_periodo'        , 'type' => 'xsd:string'),
    'cod_producto'      => array('name' => 'cod_producto'       , 'type' => 'xsd:string'),
    'cod_subproducto'   => array('name' => 'cod_subproducto'    , 'type' => 'xsd:string'),
    'cod_analisis'      => array('name' => 'cod_analisis'       , 'type' => 'xsd:string'),
    'cod_tipo_muestra'  => array('name' => 'cod_tipo_muestra'   , 'type' => 'xsd:string'),
    'leyes'             => array('name' => 'leyes'              , 'type' => 'xsd:string'),
    'impurezas'         => array('name' => 'impurezas'          , 'type' => 'xsd:string'),
    'enabal'            => array('name' => 'enabal'             , 'type' => 'xsd:string'),
    'tipo_solicitud'    => array('name' => 'tipo_solicitud'     , 'type' => 'xsd:string'),
    'estado_actual'     => array('name' => 'estado_actual'      , 'type' => 'xsd:string'),
    'rut_proveedor'     => array('name' => 'rut_proveedor'      , 'type' => 'xsd:string'),
    'peso_retalla'      => array('name' => 'peso_retalla'       , 'type' => 'xsd:string'),
    'observacion'       => array('name' => 'observacion'        , 'type' => 'xsd:string'),
    'agrupacion'        => array('name' => 'agrupacion'         , 'type' => 'xsd:int'),
    'fecha_muestra'     => array('name' => 'fecha_muestra'      , 'type' => 'xsd:string'),
    'nro_semana'        => array('name' => 'nro_semana'         , 'type' => 'xsd:string'),
    'ano'               => array('name' => 'ano'                , 'type' => 'xsd:string'),
    'mes'               => array('name' => 'mes'                , 'type' => 'xsd:string'),
    'frx'               => array('name' => 'frx'                , 'type' => 'xsd:string'),
    'tipo'              => array('name' => 'tipo'               , 'type' => 'xsd:int'),
    'nro_sa_lims'       => array('name' => 'nro_sa_lims'        , 'type' => 'xsd:int'),
    'origen_sa'         => array('name' => 'origen_sa'          , 'type' => 'xsd:string')
    )    
);
$server->wsdl->addComplexType('responseConnectionInsertSA','complexType','array','','SOAP-ENC:Array',
        array(),
        array(
            array(
                'ref' => 'SOAP-ENC:arrayType',
                'wsdl:arrayType' => 'tns:responseConnectionInsertSA[]'
            )
        )
);

$server->register("sa_insertar_soap",
    array('datos_sa_entrada' => 'tns:datos_sa_entrada'),
    array('result' => 'xsd:bool', 'response' => 'tns:responseConnectionInsertSA', 'error' => 'xsd:string'),
    'urn:'.$namespace,
    'urn:closingorder#sa_insertar_soap',
    'rpc',
    'encoded',
    'Este metodo es para poder insertar en la tabla solicitud_analisis'
);



//------------------------METODO PARA LA INSERCIÓN DE LOS ESTADOS-------------------------
//grabar estados de solicitud
$server->wsdl->addComplexType('datos_estados_sa_entrada', 
    'complexType', 
    'struct', 
    'all', 
    '',
    array(
    'rut_funcionario'   => array('name' => 'rut_funcionario'    , 'type' => 'xsd:string'),
    'nro_solicitud'     => array('name' => 'nro_solicitud'      , 'type' => 'xsd:string'),
    'recargo'           => array('name' => 'recargo'            , 'type' => 'xsd:string'),
    'cod_estado'        => array('name' => 'cod_estado'         , 'type' => 'xsd:string'),
    'fecha_hora'        => array('name' => 'fecha_hora'         , 'type' => 'xsd:string'),
    'ult_atencion'      => array('name' => 'ult_atencion'       , 'type' => 'xsd:string'),
    'rut_proceso'       => array('name' => 'rut_proceso'        , 'type' => 'xsd:string')
    )
);
$server->wsdl->addComplexType('responseConnectionInsertEstados','complexType','array','','SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:responseConnectionInsertEstados[]'
        )
    )
);
$server->register("sa_insertar_estados_soap",
    array('nro_solicitud' => 'xsd:string','datos_estados_sa_entrada' => 'tns:datos_estados_sa_entrada'),
    array('result' => 'xsd:bool', 'response' => 'tns:responseConnectionInsertEstados', 'error' => 'xsd:string'),
    'urn:'.$namespace,
    'urn:closingorder#sa_insertar_estados_soap',
    'rpc',
    'encoded',
    'Este metodo es para insertar los estados por solicitud'
);


//------------------------METODO PARA LA INSERCIÓN DE LAS LEYES-------------------------
//grabar estados de solicitud
$server->wsdl->addComplexType('datos_leyes_sa_entrada', 
    'complexType', 
    'struct', 
    'all', 
    '',
    array(
    'rut_funcionario'   => array('name' => 'rut_funcionario', 'type' => 'xsd:string'),
    'fecha_hora'        => array('name' => 'fecha_hora'     , 'type' => 'xsd:string'),
    'nro_solicitud'     => array('name' => 'nro_solicitud'  , 'type' => 'xsd:int'),
    'recargo'           => array('name' => 'recargo'        , 'type' => 'xsd:string'),
    'cod_leyes'         => array('name' => 'cod_leyes'      , 'type' => 'xsd:string'),
    'cod_unidad'        => array('name' => 'cod_unidad'     , 'type' => 'xsd:string'),
    'activa'            => array('name' => 'activa'         , 'type' => 'xsd:string'),
    'candado'           => array('name' => 'candado'        , 'type' => 'xsd:string'),
    'valor'             => array('name' => 'valor'          , 'type' => 'xsd:int'),
    'cod_producto'      => array('name' => 'cod_producto'   , 'type' => 'xsd:string'),
    'cod_subproducto'   => array('name' => 'cod_subproducto', 'type' => 'xsd:string'),
    'id_muestra'        => array('name' => 'id_muestra'     , 'type' => 'xsd:string'),
    'peso_humedo'       => array('name' => 'peso_humedo'    , 'type' => 'xsd:string'),
    'peso_seco'         => array('name' => 'peso_seco'      , 'type' => 'xsd:string'),
    'signo'             => array('name' => 'signo'          , 'type' => 'xsd:string'),
    'proceso'           => array('name' => 'proceso'        , 'type' => 'xsd:int'),
    'rut_quimico'       => array('name' => 'rut_quimico'    , 'type' => 'xsd:string'),
    'virtual'            => array('name' => 'virtual'         , 'type' => 'xsd:string'),
    'valor2'            => array('name' => 'valor2'         , 'type' => 'xsd:string'),
    'observacion'       => array('name' => 'observacion'    , 'type' => 'xsd:string'),
    'rut_proceso'       => array('name' => 'rut_proceso'    , 'type' => 'xsd:string'),
    'fecha_hora_reg_leyes'       => array('name' => 'fecha_hora_reg_leyes'    , 'type' => 'xsd:string')
    )
);
$server->wsdl->addComplexType('responseConnectionInsertLeyes','complexType','array','','SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:responseConnectionInsertLeyes[]'
        )
    )
);

$server->register("sa_insertar_leyes_soap",
    array('nro_solicitud' => 'xsd:string','datos_leyes_sa_entrada' => 'tns:datos_leyes_sa_entrada'),
    array('result' => 'xsd:bool', 'response' => 'tns:responseConnectionInsertLeyes', 'error' => 'xsd:string'),
    'urn:'.$namespace,
    'urn:closingorder#sa_insertar_estados_soap',
    'rpc',
    'encoded',
    'Este metodo es para insertar las leyes de la solicitud'
);

$server->service(file_get_contents("php://input"));
exit();
?>