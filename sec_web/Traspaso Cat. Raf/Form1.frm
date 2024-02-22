VERSION 5.00
Begin VB.Form Form1 
   Caption         =   "Form1"
   ClientHeight    =   3000
   ClientLeft      =   60
   ClientTop       =   345
   ClientWidth     =   6975
   LinkTopic       =   "Form1"
   ScaleHeight     =   3000
   ScaleWidth      =   6975
   StartUpPosition =   3  'Windows Default
   Begin VB.Timer Timer1 
      Left            =   1080
      Top             =   960
   End
End
Attribute VB_Name = "Form1"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Public Instruccion As Long
Public FechaActual As String
Public FechaMenos As String
Public FechaEmbarque As String
Public HoraActual As String
Public Hornada As String
Public Fechahora As String
Public Cod_Paquete As String
Public Num_Paquete As Long
Private Sub Crear_Lote()
   FechaActual = Year(Date) & "-" & Month(Date) & "-" & Day(Date)
 ' FechaActual = "2007-04-03"
 
  FechaMenos = DateAdd("d", -5, Year(FechaActual) & "-" & Month(FechaActual) & "-" & Day(FechaActual))
  HoraActual = Format(Time, "hh:mm:ss")
  Fechahora = FechaActual & " " & HoraActual
   '----------------------------------
    'CAT. DECOBRIZACION PARCIAL.
   ' Consulta = "SELECT IFNULL(count(*),0) AS unidades, IFNULL(sum(peso_produccion),0) AS peso,fecha_produccion as fecha FROM sec_web.produccion_catodo"
   ' Consulta = Consulta & " WHERE cod_producto = '18' AND cod_subproducto = '4'"
   ' poly Consulta = Consulta & " AND fecha_produccion between '" & FechaMenos & "' and  '" & FechaActual & "' group by fecha_produccion"
   ' Consulta = Consulta & " AND fecha_produccion = '" & FechaActual & "' group by fecha_produccion"
    Consulta = "SELECT IFNULL(count(*),0) AS unidades, IFNULL(sum(peso_produccion),0) AS peso FROM sec_web.produccion_catodo"
    Consulta = Consulta & " WHERE cod_producto = '18' AND cod_subproducto = '4'"
    Consulta = Consulta & " AND fecha_produccion = '" & FechaActual & "'"


    Set Rs1 = Conexion.Execute(Consulta)
    
    If (Rs1.Fields("unidades") <> 0) Then
    
        'Obtener la serie para el Lote.
        Consulta = "SELECT cod_subclase, nombre_subclase FROM proyecto_modernizacion.sub_clase"
        Consulta = Consulta & " WHERE cod_clase = '3004' AND cod_subclase = '" & Month(Date) & "'"
        'poly Consulta = Consulta & " WHERE cod_clase = '3004' AND cod_subclase = '" & Month(FechaActual) & "'"

        Set Rs2 = Conexion.Execute(Consulta)
        If Not (Rs2.EOF) Then
            Cod_Paquete = Rs2.Fields("nombre_subclase")
          '  fecha1 = Rs1.Fields("fecha")
            'Serie de Incio.
            Consulta = "SELECT valor_subclase1 AS valor1, valor_subclase2 AS valor2"
            Consulta = Consulta & " FROM proyecto_modernizacion.sub_clase"
            Consulta = Consulta & " WHERE cod_clase = '3013' AND cod_subclase = '2'"
            Set Rs4 = Conexion.Execute(Consulta)
            If Not (Rs4.EOF) Then
                 '2004-12-17 busco si ya existe el paquete para este mes
               '   Dim contador As Integer
                '  Dim i As Integer
                ' i = 10
                ' For contador = 1 To i
                '    Consulta = "select num_paquete as num_paquete"
                '    Consulta = Consulta & " from sec_web.paquete_catodo"
                '    Consulta = Consulta & " where cod_paquete = '" & Cod_Paquete & "'"
                '    Consulta = Consulta & " and substring(fecha_creacion_paquete,1,7) = substring('" & fecha1 & "',1,7)"
                '    Consulta = Consulta & " and num_paquete between '" & Rs4.Fields("valor1") & "' and '" & Rs4.Fields("valor2") & "'"
                '    Set Rs3 = Conexion.Execute(Consulta)
                '    If Not (Rs3.EOF) Then
                '        Num_Paquete = Rs3.Fields("num_paquete")
                '    End If
                '    Next contador
            
            'busco 2004-12-17 si ya existe el paquete para este mes
                Consulta = "SELECT CASE WHEN IFNULL(MAX(num_paquete),0) = 0 THEN " & Rs4.Fields("valor1") & " ELSE (MAX(num_paquete)+1) END AS num_paquete "
                Consulta = Consulta & " FROM sec_web.paquete_catodo"
                Consulta = Consulta & " WHERE SUBSTRING(fecha_creacion_paquete,1,4) = SUBSTRING('" & FechaActual & "',1,4)"
                Consulta = Consulta & " AND cod_paquete = '" & Cod_Paquete & "'"
                Consulta = Consulta & " AND num_paquete BETWEEN '" & Rs4.Fields("valor1") & "' AND '" & Rs4.Fields("valor2") & "'"
                Set Rs3 = Conexion.Execute(Consulta)
                If Not (Rs3.EOF) Then
                    Num_Paquete = Rs3.Fields("num_paquete")
                End If
            End If
        End If
        
        
        'Genera I.E. Virtual.
        Consulta = "SELECT (IFNULL(MAX(corr_virtual),0)+1) AS ie FROM sec_web.instruccion_virtual"
        Set Rs5 = Conexion.Execute(Consulta)
        If Not (Rs5.EOF) Then
            Instruccion = Rs5.Fields("ie")
            FechaEmbarque = Year(FechaActual) & "-12-31"
            'consultar si existe la IE virtual para insertar
            'Inserta I.E.
            Insertar = "INSERT INTO sec_web.instruccion_virtual (corr_virtual, peso_programado, fecha_embarque, cod_producto, cod_subproducto, descripcion, estado)"
            Insertar = Insertar & " VALUES ('" & Instruccion & "','" & Rs1.Fields("peso") & "','" & FechaEmbarque
            Insertar = Insertar & "','18','4','AUTO','T')"
            Conexion.Execute (Insertar)
        End If
        
        'Inserta en Lote Catodo.
        Insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,corr_enm,cod_estado,disponibilidad,fecha_creacion_paquete)"
        Insertar = Insertar & " VALUES ('" & Cod_Paquete & "','" & Num_Paquete & "','" & Cod_Paquete & "','" & Num_Paquete
        Insertar = Insertar & "','" & FechaActual & "','" & Instruccion & "','a','T', '" & FechaActual & "')"
        Conexion.Execute (Insertar)
        
        'Inserta en Paquete Catodo.
        Insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,hora)"
        Insertar = Insertar & " VALUES ('05','" & Cod_Paquete & "','" & Num_Paquete & "','" & FechaActual & "','18','4','a','" & Rs1.Fields("unidades") & "','" & Rs1.Fields("peso") & "','" & HoraActual & "')"
        Conexion.Execute (Insertar)
        
        'Insertar en Traspaso.
'        Insertar = "INSERT INTO sec_web.traspaso (hornada, fecha_traspaso, peso, unidades, fecha_creacion_lote, cod_producto, cod_subproducto, cod_bulto, num_bulto)"
'        Insertar = Insertar & " VALUES ('" & Hornada & "','" & FechaActual & "','" & Rs1.Fields("peso")
'        Insertar = Insertar & "','" & Rs1.Fields("unidades") & "','" & FechaActual & "','18','3'"
'        Insertar = Insertar & ",'" & Cod_Bulto & "','" & Num_Bulto & "')"
'        Conexion.Execute (Insertar)
'
'        Insertar = "INSERT INTO sec_web.det_traspaso (hornada,cod_paquete,num_paquete,fecha_creacion_paquete,peso_paquete)"
'        Insertar = Insertar & " VALUES ('" & Hornada & "','" & Cod_Bulto & "','" & Num_Bulto & "','" & FechaActual & "','" & Rs1.Fields("peso") & "')"
'        Conexion.Execute (Insertar)
    End If
    
    '-------------------------------
    'CAT. ELECTROWING.
    Consulta = "SELECT IFNULL(count(*),0) AS unidades, IFNULL(sum(peso_produccion),0) AS peso FROM sec_web.produccion_catodo"
    Consulta = Consulta & " WHERE cod_producto = '18' AND cod_subproducto = '5'"
    Consulta = Consulta & " AND fecha_produccion = '" & FechaActual & "'"
    Set Rs1 = Conexion.Execute(Consulta)
    
    If (Rs1.Fields("unidades") <> 0) Then
    
        'Obtener la serie para generar el Lote.
        Consulta = "SELECT cod_subclase, nombre_subclase FROM proyecto_modernizacion.sub_clase"
        Consulta = Consulta & " WHERE cod_clase = '3004' AND cod_subclase = '" & Month(Date) & "'"
        Set Rs2 = Conexion.Execute(Consulta)
        If Not (Rs2.EOF) Then
            Cod_Paquete = Rs2.Fields("nombre_subclase")
        
            'Serie de Incio.
            Consulta = "SELECT valor_subclase1 AS valor1, valor_subclase2 AS valor2"
            Consulta = Consulta & " FROM proyecto_modernizacion.sub_clase"
            Consulta = Consulta & " WHERE cod_clase = '3013' AND cod_subclase = '1'"
            Set Rs4 = Conexion.Execute(Consulta)
            If Not (Rs4.EOF) Then
                Consulta = "SELECT CASE WHEN IFNULL(MAX(num_paquete),0) = 0 THEN " & Rs4.Fields("valor1") & " ELSE (MAX(num_paquete)+1) END AS num_paquete "
                Consulta = Consulta & " FROM sec_web.paquete_catodo"
                Consulta = Consulta & " WHERE SUBSTRING(fecha_creacion_paquete,1,4) = SUBSTRING('" & FechaActual & "',1,4)"
                Consulta = Consulta & " AND cod_paquete = '" & Cod_Paquete & "'"
                Consulta = Consulta & " AND num_paquete BETWEEN '" & Rs4.Fields("valor1") & "' AND '" & Rs4.Fields("valor2") & "'"
                Set Rs3 = Conexion.Execute(Consulta)
                If Not (Rs3.EOF) Then
                    Num_Paquete = Rs3.Fields("num_paquete")
                End If
            End If
        End If

        'Genera I.E. Virtual.
        Consulta = "SELECT (IFNULL(MAX(corr_virtual),0)+1) AS ie FROM sec_web.instruccion_virtual"
        Set Rs5 = Conexion.Execute(Consulta)
        If Not (Rs5.EOF) Then
            Instruccion = Rs5.Fields("ie")
            FechaEmbarque = Year(FechaActual) & "-12-31"
            
            'Inserta I.E.
            Insertar = "INSERT INTO sec_web.instruccion_virtual (corr_virtual, peso_programado, fecha_embarque, cod_producto, cod_subproducto, descripcion, estado)"
            Insertar = Insertar & " VALUES ('" & Instruccion & "','" & Rs1.Fields("peso") & "','" & FechaEmbarque
            Insertar = Insertar & "','18','5','AUTO','T')"
            Conexion.Execute (Insertar)
        End If
        
        'Inserta en Lote Catodo.
        Insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,corr_enm,cod_estado,disponibilidad,fecha_creacion_paquete)"
        Insertar = Insertar & " VALUES ('" & Cod_Paquete & "','" & Num_Paquete & "','" & Cod_Paquete & "','" & Num_Paquete
        Insertar = Insertar & "','" & FechaActual & "','" & Instruccion & "','a','T', '" & FechaActual & "')"
        Conexion.Execute (Insertar)
        
        'Inserta en Paquete Catodo.
        Insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,hora)"
        Insertar = Insertar & " VALUES ('05','" & Cod_Paquete & "','" & Num_Paquete & "','" & FechaActual & "','18','5','a','" & Rs1.Fields("unidades") & "','" & Rs1.Fields("peso") & "','" & HoraActual & "')"
        Conexion.Execute (Insertar)
        
        'Insertar en Traspaso.
'        Insertar = "INSERT INTO sec_web.traspaso (hornada, fecha_traspaso, peso, unidades, fecha_creacion_lote, cod_producto, cod_subproducto, cod_bulto, num_bulto)"
'        Insertar = Insertar & " VALUES ('" & Hornada & "','" & FechaActual & "','" & Rs1.Fields("peso")
'        Insertar = Insertar & "','" & Rs1.Fields("unidades") & "','" & FechaActual & "','18','5'"
'        Insertar = Insertar & ",'" & Cod_Bulto & "','" & Num_Bulto & "')"
'        Conexion.Execute (Insertar)
'
'        Insertar = "INSERT INTO sec_web.det_traspaso (hornada,cod_paquete,num_paquete,fecha_creacion_paquete,peso_paquete)"
'        Insertar = Insertar & " VALUES ('" & Hornada & "','" & Cod_Bulto & "','" & Num_Bulto & "','" & FechaActual & "','" & Rs1.Fields("peso") & "')"
'        Conexion.Execute (Insertar)
    End If
    
    
    '-------------------------------
    'DESPUNTES Y LAMINAS (BARRIDO N.E.).
    Consulta = "SELECT IFNULL(count(*),0) AS unidades, IFNULL(sum(peso_produccion),0) AS peso FROM sec_web.produccion_catodo"
    Consulta = Consulta & " WHERE cod_producto = '48' AND cod_subproducto = '10'"
    Consulta = Consulta & " AND fecha_produccion = '" & FechaActual & "'"
    Set Rs1 = Conexion.Execute(Consulta)
    
    If (Rs1.Fields("unidades") <> 0) Then
    
        'Obtener la serie para generar la hornada.
        Consulta = "SELECT cod_subclase, nombre_subclase FROM proyecto_modernizacion.sub_clase"
        Consulta = Consulta & " WHERE cod_clase = '3004' AND cod_subclase = '" & Month(Date) & "'"
        Set Rs2 = Conexion.Execute(Consulta)
        If Not (Rs2.EOF) Then
            Cod_Paquete = Rs2.Fields("nombre_subclase")
        
            'Serie de Incio.
            Consulta = "SELECT valor_subclase1 AS valor1, valor_subclase2 AS valor2"
            Consulta = Consulta & " FROM proyecto_modernizacion.sub_clase"
            Consulta = Consulta & " WHERE cod_clase = '3013' AND cod_subclase = '3'"
            Set Rs4 = Conexion.Execute(Consulta)
            If Not (Rs4.EOF) Then
                Consulta = "SELECT CASE WHEN IFNULL(MAX(num_paquete),0) = 0 THEN " & Rs4.Fields("valor1") & " ELSE (MAX(num_paquete)+1) END AS num_paquete "
                Consulta = Consulta & " FROM sec_web.paquete_catodo"
                Consulta = Consulta & " WHERE SUBSTRING(fecha_creacion_paquete,1,4) = SUBSTRING('" & FechaActual & "',1,4)"
                Consulta = Consulta & " AND cod_paquete = '" & Cod_Paquete & "'"
                Consulta = Consulta & " AND num_paquete BETWEEN '" & Rs4.Fields("valor1") & "' AND '" & Rs4.Fields("valor2") & "'"
                Set Rs3 = Conexion.Execute(Consulta)
                If Not (Rs3.EOF) Then
                    Num_Paquete = Rs3.Fields("num_paquete")
                End If
            End If
        End If

        'Genera Hornada.
        Hornada = Year(FechaActual) & Format(Month(FechaActual), "00") & Num_Paquete & Format(Month(FechaActual), "00")
        
        'Inserta en Lote Catodo.
        Insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,fecha_creacion_paquete,corr_enm,cod_estado,disponibilidad)"
        Insertar = Insertar & " VALUES ('" & Cod_Paquete & "','" & Num_Paquete & "','" & Cod_Paquete & "','" & Num_Paquete
        Insertar = Insertar & "','" & FechaActual & "','" & FechaActual & "','" & Hornada & "','c','T')"
        Conexion.Execute (Insertar)
        
        'Inserta en Paquete Catodo.
        Insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,hora)"
        Insertar = Insertar & " VALUES ('05','" & Cod_Paquete & "','" & Num_Paquete & "','" & FechaActual & "','48','10','c','" & Rs1.Fields("unidades") & "','" & Rs1.Fields("peso") & "','" & HoraActual & "')"
        Conexion.Execute (Insertar)
        
        'Insertar en Traspaso (Unico Producto con Traspaso Director a Raf).
        Insertar = "INSERT INTO sec_web.traspaso (hornada, fecha_traspaso, peso, unidades, fecha_creacion_lote, cod_producto, cod_subproducto, cod_bulto, num_bulto, sw)"
        Insertar = Insertar & " VALUES ('" & Hornada & "','" & FechaActual & "','" & Rs1.Fields("peso")
        Insertar = Insertar & "','" & Rs1.Fields("unidades") & "','" & FechaActual & "','48','10'"
        Insertar = Insertar & ",'" & Cod_Paquete & "','" & Num_Paquete & "','1')"
        Conexion.Execute (Insertar)
        
        Insertar = "INSERT INTO sec_web.det_traspaso (hornada,cod_paquete,num_paquete,fecha_creacion_paquete,peso_paquete)"
        Insertar = Insertar & " VALUES ('" & Hornada & "','" & Cod_Paquete & "','" & Num_Paquete & "','" & FechaActual & "','" & Rs1.Fields("peso") & "')"
        Conexion.Execute (Insertar)
        
        'Insertar en movimientos del sea(Unico producto con traspaso directo a raf)
        Insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,hora)"
        Insertar = Insertar & " VALUES ('1','48','10','" & Hornada & "','0','" & FechaActual & "','9999','9999','" & Rs1.Fields("unidades") & "','442','" & Rs1.Fields("peso") & "','" & Fechahora & "')"
        Conexion.Execute (Insertar)
        
    End If
            
End Sub

Private Sub Form_Load()
    Call Conectar
    Call Crear_Lote
    Call Desconectar
    Timer1_Timer
End Sub

Private Sub Timer1_Timer()
    End
End Sub
