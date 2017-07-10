<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Febrero 2017 : 11:40                                                            #
#                                                                                    #
###### informacion.php ###############################################################
#                                                                                    #
# Archivo para recabar información de estatus y tipos                                #
# de las diferentes tablas. No es parte del sistema                                  #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 2-FEB-17: 11:45                                                                    #
# IJLM - Actualización de tipos de productos                                         #
# IJLM - Actualizacion de tipos de clientes                                          #
# IJLM - Actualizacion de tipos de usuarios                                          #
# IJLM - Actualizacion de tipos de registro en bancos                                #
# IJLM - Actualizacion de estatus de registro en bancos                              #
# IJLM - Actualizacion de estatus de registro en cuentas por pagar                   #
# IJLM - Actualizacion de estatus de registro en cuentas por cobrar                  #
#                                                                                    #
# 07-FEB-17: 12:02                                                                   #
# IJLM - Actualizacion de estatus de registro en ordenes de compra                   #
#                                                                                    #
# 01-MAR-17: 12:42                                                                   #
# IJLM - Actualización de estatus de tabla permisos                                  #
######################################################################################

/*

2-FEB-17: 11:45

Tipos de productos - Tabla Productos
1 = Orgánico
2 = Convenciona

Tipos de Clientes - Tabla Clientes
1 = Global Direct Custumer
2 = Distribuidor

Tipos de Usuarios - Tabla Usuarios
1 = Administrador
2 = Trabajador

Tipo de registro en Bancos - Tablas usdBancos y mxnBancos
1 = Ingreso
2 = Egreso

Estatus de registro en Bancos - Tablas usdBancos y mxnBancos
1 = Activo
2 = Cancelado

Estatus de registro en Cuentas por Pagar - Tablas usdCuentasP y mxnCuentasP
1 = Activo
2 = Cancelado
3 = Saldado

Estatus de registro en Cuentas por Cobrar - Tablas usdCuentasC y mxnCuentasC
1 = Activo
2 = Cancelado
3 = Saldado

Estatus de Ordenes de Compra
1 = Pendiente a factura
2 = Completada
3 = Cancelada

01-MAR-17: 12:43

Estatus de permisos en tabla Permisos
1 = Consulta (Solo lectura)
2 = Creación
3 = Modificación
4 = Eliminación
12 = Consulta y Creacion 
13 = Consulta y Modificación 
14 = Consulta y Eliminación
23 = Creación y Modificación
24 = Creación y Eliminación 
34 = Modificación y Eliminación 
123 = Consulta, Creación y Modificación
124 = Consulta, Creación y Eliminación  
234 = Creación, Modificación y Eliminación
1234 = Consulta, Creación, Modificación y Eliminación. 


Estatus de Cotizaciones
1 = Vigente
2 = Vencida
3 = Cancelada
4 = Utilizada

Estatus de Pedidos

1 = En camino
2 = Entregado
3 = Cancelado


Estatus de Importaciones

1 = En camino
2 = Finalizada
3 = Cancelada
4 = Esperando pedimento


Estatus de Declaración de Aduanas

1 = Activa
2 = Cancelada
*/

?>
