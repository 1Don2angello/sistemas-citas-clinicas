USE [gestion_citas]
GO
/****** Object:  Schema [gestion_citas]    Script Date: 20/07/2023 02:19:35 p. m. ******/
CREATE SCHEMA [gestion_citas]
GO
/****** Object:  Table [gestion_citas].[apl_configuracion]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[apl_configuracion](
	[configuracion_id] [int] IDENTITY(27,1) NOT NULL,
	[configuracion_nombre] [nvarchar](200) NOT NULL,
	[configuracion_clase] [nvarchar](50) NOT NULL,
	[configuracion_valor] [nvarchar](200) NOT NULL,
 CONSTRAINT [PK_apl_configuracion_configuracion_id] PRIMARY KEY CLUSTERED 
(
	[configuracion_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[cat_categorias]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[cat_categorias](
	[categorias_id] [int] IDENTITY(2,1) NOT NULL,
	[categorias_nombre] [nvarchar](200) NOT NULL,
	[categorias_descripcion] [nvarchar](1500) NOT NULL,
 CONSTRAINT [PK_cat_categorias_categorias_id] PRIMARY KEY CLUSTERED 
(
	[categorias_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[cat_clientes]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[cat_clientes](
	[clientes_id] [int] IDENTITY(11,1) NOT NULL,
	[clientes_nombre] [nvarchar](200) NOT NULL,
	[clientes_apellido_p] [nvarchar](200) NOT NULL,
	[clientes_apellido_m] [nvarchar](200) NOT NULL,
	[clientes_telefono] [nvarchar](15) NOT NULL,
	[clientes_correo] [nvarchar](200) NOT NULL,
	[clientes_direccion] [nvarchar](800) NOT NULL,
	[clientes_sexo] [nvarchar](8) NOT NULL,
	[clientes_edad] [int] NOT NULL,
 CONSTRAINT [PK_cat_clientes_clientes_id] PRIMARY KEY CLUSTERED 
(
	[clientes_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[cat_servicios]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[cat_servicios](
	[servicios_id] [int] IDENTITY(3,1) NOT NULL,
	[servicios_categoria_id] [int] NOT NULL,
	[servicios_descripcion] [nvarchar](1500) NOT NULL,
	[servicios_nombre] [nvarchar](200) NOT NULL,
	[servicios_duracion] [nvarchar](50) NOT NULL,
	[servicios_precio] [real] NOT NULL,
 CONSTRAINT [PK_cat_servicios_servicios_id] PRIMARY KEY CLUSTERED 
(
	[servicios_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[cat_usuarios]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[cat_usuarios](
	[usuarios_id] [int] IDENTITY(3,1) NOT NULL,
	[usuarios_nombre] [nvarchar](200) NOT NULL,
	[usuarios_apellido_p] [nvarchar](200) NOT NULL,
	[usuarios_apellido_m] [nvarchar](200) NOT NULL,
	[usuarios_telefono] [nvarchar](15) NOT NULL,
	[usuarios_correo] [nvarchar](200) NOT NULL,
	[usuarios_direccion] [nvarchar](800) NOT NULL,
	[usuarios_usuario] [nvarchar](200) NOT NULL,
	[usuarios_clave] [nvarchar](200) NOT NULL,
	[usuarios_rol] [nvarchar](20) NOT NULL,
 CONSTRAINT [PK_cat_usuarios_usuarios_id] PRIMARY KEY CLUSTERED 
(
	[usuarios_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[historial]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[historial](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [int] NOT NULL,
	[nombre] [varchar](50) NOT NULL,
	[sexo] [varchar](20) NOT NULL,
	[edad] [int] NOT NULL,
	[altura] [float] NOT NULL,
	[peso] [float] NOT NULL,
	[analisisCovid] [varchar](20) NOT NULL,
	[sintomas] [varchar](300) NOT NULL,
	[diagnostico] [varchar](300) NOT NULL,
	[tratamiento] [varchar](300) NOT NULL,
	[instrucciones] [varchar](300) NOT NULL,
	[fecha] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[ope_citas]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[ope_citas](
	[citas_id] [int] IDENTITY(9,1) NOT NULL,
	[citas_servicios_id] [int] NOT NULL,
	[citas_proveedor_id] [int] NOT NULL,
	[citas_clientes_id] [int] NOT NULL,
	[citas_estatus] [nvarchar](15) NOT NULL,
	[citas_fecha] [date] NOT NULL,
	[citas_hora] [nvarchar](5) NOT NULL,
	[citas_notas] [nvarchar](1500) NOT NULL,
	[citas_fecha_creo] [date] NOT NULL,
	[citas_sala] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_ope_citas_citas_id] PRIMARY KEY CLUSTERED 
(
	[citas_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[ope_descansos]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[ope_descansos](
	[descansos_id] [int] IDENTITY(1,1) NOT NULL,
	[descansos_dia] [nvarchar](10) NOT NULL,
	[descansos_inicio] [nvarchar](5) NOT NULL,
	[descansos_final] [nvarchar](5) NOT NULL,
 CONSTRAINT [PK_ope_descansos_descansos_id] PRIMARY KEY CLUSTERED 
(
	[descansos_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[ope_rel_usuario_servicio]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[ope_rel_usuario_servicio](
	[relacion_id] [int] IDENTITY(4,1) NOT NULL,
	[usuarios_id] [int] NOT NULL,
	[servicios_id] [int] NOT NULL,
 CONSTRAINT [PK_ope_rel_usuario_servicio_relacion_id] PRIMARY KEY CLUSTERED 
(
	[relacion_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [gestion_citas].[pacientes]    Script Date: 20/07/2023 02:19:35 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [gestion_citas].[pacientes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [int] NOT NULL,
	[hora] [nvarchar](20) NOT NULL,
	[nombre] [nvarchar](50) NULL,
	[fecha] [nvarchar](10) NULL,
	[edad] [int] NULL,
	[peso] [nvarchar](10) NULL,
	[sexo] [nvarchar](10) NULL,
	[talla] [nvarchar](10) NULL,
	[tensArt] [nvarchar](10) NULL,
	[edoCivil] [nvarchar](100) NULL,
	[frCard] [nvarchar](100) NULL,
	[frResp] [nvarchar](100) NULL,
	[imc] [nvarchar](100) NULL,
	[temp] [nvarchar](100) NULL,
	[ahf] [nvarchar](500) NULL,
	[apnp] [nvarchar](500) NULL,
	[app] [nvarchar](500) NULL,
	[pActual] [nvarchar](500) NULL,
	[eFisica] [nvarchar](500) NULL,
	[fechaN] [nvarchar](20) NULL,
	[puestoS] [nvarchar](100) NULL,
	[escolaridad] [nvarchar](100) NULL,
	[lugarOrigen] [nvarchar](100) NULL,
	[analisisCovid] [nvarchar](500) NULL,
	[indicaciones] [nvarchar](500) NULL,
	[visitarUFM] [nvarchar](10) NULL,
	[observaciones] [nvarchar](500) NULL,
	[cirugias] [nvarchar](500) NULL,
	[traumatismos] [nvarchar](500) NULL,
	[fracturas] [nvarchar](500) NULL,
	[luxaciones] [nvarchar](500) NULL,
	[alergias] [nvarchar](500) NULL,
	[agudezaVisual] [nvarchar](20) NULL,
	[licenciaLentes] [nvarchar](10) NULL,
	[riesgoSalub] [nvarchar](20) NULL,
	[envioOpto] [nvarchar](10) NULL,
	[lentGraduadios] [nvarchar](10) NULL,
	[perAbdominal] [nvarchar](10) NULL,
	[examLab] [nvarchar](20) NULL,
	[tipoSangre] [nvarchar](10) NULL,
	[glucosaCapilar] [nvarchar](20) NULL,
	[iras] [nvarchar](500) NULL,
	[porcentajeOxigeno] [nvarchar](100) NULL,
	[pruevaAplicada] [nvarchar](100) NULL,
	[FechaAplicacion] [nvarchar](20) NULL,
	[horaAplicacion] [nvarchar](20) NOT NULL,
	[resultado] [nvarchar](500) NULL,
	[diagnostico] [nvarchar](500) NULL,
	[indicacionesFinales] [nvarchar](500) NULL,
	[aptos] [nvarchar](10) NULL,
 CONSTRAINT [PK_pacientes_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [gestion_citas].[apl_configuracion] ON 

INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (1, N'nombre_cliente', N'validacion_cliente', N'true')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (2, N'apellido_p_cliente', N'validacion_cliente', N'true')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (3, N'apellido_m_cliente', N'validacion_cliente', N'true')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (4, N'telefono_cliente', N'validacion_cliente', N'false')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (5, N'correo_cliente', N'validacion_cliente', N'true')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (6, N'sexo_cliente', N'validacion_cliente', N'false')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (7, N'edad_cliente', N'validacion_cliente', N'false')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (8, N'direccion_cliente', N'validacion_cliente', N'false')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (9, N'nombre_empresa', N'info_empresa', N'Autocar12')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (10, N'enviar_correo', N'envio_correos', N'true')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (11, N'cuenta_correo', N'envio_correos', N'joseangel@gmail.com')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (12, N'clave_correo', N'envio_correos', N'Autocar')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (13, N'horario_domingo_final', N'horarios', N'')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (14, N'horario_domingo_inicio', N'horarios', N'')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (15, N'horario_sabado_final', N'horarios', N'12')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (16, N'horario_sabado_inicio', N'horarios', N'9')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (17, N'horario_viernes_final', N'horarios', N'17')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (18, N'horario_viernes_inicio', N'horarios', N'10')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (19, N'horario_jueves_final', N'horarios', N'17')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (20, N'horario_jueves_inicio', N'horarios', N'10')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (21, N'horario_miercoles_final', N'horarios', N'17')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (22, N'horario_miercoles_inicio', N'horarios', N'10')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (23, N'horario_martes_final', N'horarios', N'17')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (24, N'horario_martes_inicio', N'horarios', N'10')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (25, N'horario_lunes_final', N'horarios', N'17')
INSERT [gestion_citas].[apl_configuracion] ([configuracion_id], [configuracion_nombre], [configuracion_clase], [configuracion_valor]) VALUES (26, N'horario_lunes_inicio', N'horarios', N'10')
SET IDENTITY_INSERT [gestion_citas].[apl_configuracion] OFF
GO
SET IDENTITY_INSERT [gestion_citas].[cat_categorias] ON 

INSERT [gestion_citas].[cat_categorias] ([categorias_id], [categorias_nombre], [categorias_descripcion]) VALUES (1, N'salud', N'salud')
SET IDENTITY_INSERT [gestion_citas].[cat_categorias] OFF
GO
SET IDENTITY_INSERT [gestion_citas].[cat_servicios] ON 

INSERT [gestion_citas].[cat_servicios] ([servicios_id], [servicios_categoria_id], [servicios_descripcion], [servicios_nombre], [servicios_duracion], [servicios_precio]) VALUES (1, 1, N'salud', N'servicio medico', N'20', 1)
SET IDENTITY_INSERT [gestion_citas].[cat_servicios] OFF
GO
SET IDENTITY_INSERT [gestion_citas].[cat_usuarios] ON 

INSERT [gestion_citas].[cat_usuarios] ([usuarios_id], [usuarios_nombre], [usuarios_apellido_p], [usuarios_apellido_m], [usuarios_telefono], [usuarios_correo], [usuarios_direccion], [usuarios_usuario], [usuarios_clave], [usuarios_rol]) VALUES (1, N'Admin', N'Admin', N'Admin', N'9988776655', N'admin@gmail.com', N'DIRECCION', N'admin', N'admin', N'Administrador')
INSERT [gestion_citas].[cat_usuarios] ([usuarios_id], [usuarios_nombre], [usuarios_apellido_p], [usuarios_apellido_m], [usuarios_telefono], [usuarios_correo], [usuarios_direccion], [usuarios_usuario], [usuarios_clave], [usuarios_rol]) VALUES (2, N'ARQUIMIDES', N'OROZCO', N'MEDINA', N'9988776655', N'DOC@G.COM', N'DIRECCION', N'Doc22', N'12345', N'Proveedor')
SET IDENTITY_INSERT [gestion_citas].[cat_usuarios] OFF
GO
SET IDENTITY_INSERT [gestion_citas].[historial] ON 

INSERT [gestion_citas].[historial] ([id], [clave], [nombre], [sexo], [edad], [altura], [peso], [analisisCovid], [sintomas], [diagnostico], [tratamiento], [instrucciones], [fecha]) VALUES (1002, 11, N'11', N'Masculino', 0, 1, 11, N'Negativo', N'11', N'11', N'11', N'11', CAST(N'2023-07-03T15:33:48.230' AS DateTime))
INSERT [gestion_citas].[historial] ([id], [clave], [nombre], [sexo], [edad], [altura], [peso], [analisisCovid], [sintomas], [diagnostico], [tratamiento], [instrucciones], [fecha]) VALUES (1011, 1111, N'juahn', N'Masculino', 22, 1.07, 12, N'Negativo', N'kjjk22222222222222111111', N'kjk', N'jkjk1111', N'jkjk11111111', CAST(N'2023-07-03T16:34:39.627' AS DateTime))
INSERT [gestion_citas].[historial] ([id], [clave], [nombre], [sexo], [edad], [altura], [peso], [analisisCovid], [sintomas], [diagnostico], [tratamiento], [instrucciones], [fecha]) VALUES (1014, 1030, N'LUIS ALBERTO GOMEZ CANUL', N'Masculino', 22, 1, 77, N'Negativo', N'jjj', N'jjj', N'jjj', N'jjj', CAST(N'2023-07-18T13:45:42.373' AS DateTime))
INSERT [gestion_citas].[historial] ([id], [clave], [nombre], [sexo], [edad], [altura], [peso], [analisisCovid], [sintomas], [diagnostico], [tratamiento], [instrucciones], [fecha]) VALUES (1015, 88964, N'KEVIN ROSADO LOPEZ', N'Masculino', 24, 1, 44, N'Negativo', N'jjjj', N'kjkk', N'jkjk', N'jkk', CAST(N'2023-07-18T15:53:52.013' AS DateTime))
SET IDENTITY_INSERT [gestion_citas].[historial] OFF
GO
SET IDENTITY_INSERT [gestion_citas].[ope_rel_usuario_servicio] ON 

INSERT [gestion_citas].[ope_rel_usuario_servicio] ([relacion_id], [usuarios_id], [servicios_id]) VALUES (3, 2, 1)
INSERT [gestion_citas].[ope_rel_usuario_servicio] ([relacion_id], [usuarios_id], [servicios_id]) VALUES (11, 2, 1)
SET IDENTITY_INSERT [gestion_citas].[ope_rel_usuario_servicio] OFF
GO
SET IDENTITY_INSERT [gestion_citas].[pacientes] ON 

INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5061, 1030, N'', N'LUIS ALBERTO GOMEZ CANUL', N'', 0, N'44', N'Masculino', N'1.2', N'', N'Soltero', N'', N'', N'30.56', N'', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'', N'', N'Primaria', N'', N'', N'33333333333333333333333333333333333333333333333333333333333333333', N'', N'', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5063, 1030, N'', N'LUIS ALBERTO GOMEZ CANUL', N'2023-07-17', 0, N'44', N'Masculino', N'1.13', N'', N'Soltero', N'', N'', N'34.46', N'', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'', N'estoy escribiendo texto rambon', N'Primaria', N'', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'', N'', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'estoy escribiendo texto rambon', N'estoy escribiendo texto rambon', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5065, 1030, N'', N'LUIS ALBERTO GOMEZ CANUL', N'', 17, N'44', N'Masculino', N'1.14', N'', N'Soltero', N'x', N'', N'33.86', N'', N'x', N'x', N'x', N'x', N'x', N'', N'x', N'Primaria', N'', N'x', N'x', N'', N'', N'xx', N'x', N'x', N'x', N'x', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5066, 1030, N'16:29', N'LUIS ALBERTO GOMEZ CANUL', N'2023-07-18', 20, N'44', N'Masculino', N'1.56', N'aaa', N'Soltero', N'aaa', N'', N'18.08', N'aaa', N'aaaa', N'aaaa', N'aaaa', N'aaa', N'aaa', N'2023-07-18', N'aa', N'Primaria', N'', N'aa', N'aaa', N'aaa', N'', N'aa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aa', N'a', N'aaa', N'2023-07-18', N'15:37', N'aaa', N'aaa', N'aaa', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5067, 3190, N'14:40', N'ISMAEL ALCUDIA GONZALEZ', N'2023-07-18', 20, N'11', N'Masculino', N'1', N'aaa', N'Soltero', N'aaa', N'', N'11.00', N'aaa', N'aaaa', N'aaa', N'aaa', N'aaa', N'', N'2023-07-18', N'aaa', N'Primaria', N'', N'aaa', N'aaa', N'aaa', N'aaa', N'aaa', N'aa', N'aaa', N'aaa', N'aaa', N'aaa', N'aa', N'', N'aaa', N'', N'aa', N'a', N'aa', N'aaa', N'aaa', N'aaa', N'aaa', N'2023-07-18', N'16:41', N'aaa', N'aaa', N'aaa', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5068, 88964, N'15:48', N'KEVIN ROSADO LOPEZ', N'2023-07-18', 17, N'44', N'Masculino', N'1', N'aaa', N'Soltero', N'aaa', N'333', N'44.00', N'aaa', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'33333333333333333333333333333333333333333333333333333333333333333', N'', N'', N'', N'', N'Primaria', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5071, 88963, N'19:55', N'ISAAC ACUÑA VILLAFUERTE', N'', 17, N'66', N'Masculino', N'1.5', N'hhh', N'Viudo', N'777', N'77', N'29.33', N'77', N'jhjhj', N'hjhj', N'hjhj', N'hjhj', N'jhjh', N'2023-07-20', N'hjhjh', N'Preparatoria', N'Guanajuato', N'jhjhjh', N'hjhjh', N'Si', N'hjj', N'jhhj', N'', N'hjhjh', N'hjh', N'jhjh', N'hjhj', N'Si', N'jhjhj', N'No', N'No', N'jhjh', N'jhjh', N'A+', N'hjjhj', N'jhjh', N'88', N'hj', N'2023-07-18', N'16:56', N'jhjhj', N'hjhjh', N'hjhjhj', N'apto')
INSERT [gestion_citas].[pacientes] ([id], [clave], [hora], [nombre], [fecha], [edad], [peso], [sexo], [talla], [tensArt], [edoCivil], [frCard], [frResp], [imc], [temp], [ahf], [apnp], [app], [pActual], [eFisica], [fechaN], [puestoS], [escolaridad], [lugarOrigen], [analisisCovid], [indicaciones], [visitarUFM], [observaciones], [cirugias], [traumatismos], [fracturas], [luxaciones], [alergias], [agudezaVisual], [licenciaLentes], [riesgoSalub], [envioOpto], [lentGraduadios], [perAbdominal], [examLab], [tipoSangre], [glucosaCapilar], [iras], [porcentajeOxigeno], [pruevaAplicada], [FechaAplicacion], [horaAplicacion], [resultado], [diagnostico], [indicacionesFinales], [aptos]) VALUES (5073, 2003, N'21:03', N'MOISES MENDOZA CARBAJAL', N'2023-07-18', 17, N'78', N'Masculino', N'1.59', N'7', N'Casado', N'hjhjh', N'gjhj', N'30.85', N'77', N'jhjhj', N'hjhj', N'hjhj', N'hjhj', N'hjjhj', N'2023-07-13', N'jhjh', N'Preparatoria', N'Coahuila', N'hjhj', N'jhjhjh', N'No', N'jhhj', N'jhjhj', N'jhjh', N'jhjhj', N'jh', N'hjjh', N'jhjhj', N'No', N'hjhh', N'No', N'No', N'jhjh', N'', N'B+', N'hjhj', N'jhjh', N'hjhj', N'jhjhj', N'2023-07-19', N'20:01', N'hjhj', N'jhjhj', N'jjhhj', N'apto')
SET IDENTITY_INSERT [gestion_citas].[pacientes] OFF
GO
ALTER TABLE [gestion_citas].[historial] ADD  DEFAULT (getdate()) FOR [fecha]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [nombre]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [fecha]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [edad]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [peso]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [sexo]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [talla]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [tensArt]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [edoCivil]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [frCard]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [frResp]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [imc]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [temp]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [ahf]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [apnp]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [app]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [pActual]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [eFisica]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [fechaN]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [puestoS]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [escolaridad]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [lugarOrigen]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [analisisCovid]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [indicaciones]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [visitarUFM]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [observaciones]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [cirugias]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [traumatismos]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [fracturas]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [luxaciones]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [alergias]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [agudezaVisual]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [licenciaLentes]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [riesgoSalub]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [envioOpto]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [lentGraduadios]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [perAbdominal]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [examLab]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [tipoSangre]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [glucosaCapilar]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [iras]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [porcentajeOxigeno]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [pruevaAplicada]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [FechaAplicacion]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [resultado]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [diagnostico]
GO
ALTER TABLE [gestion_citas].[pacientes] ADD  DEFAULT (NULL) FOR [indicacionesFinales]
GO
ALTER TABLE [gestion_citas].[cat_servicios]  WITH NOCHECK ADD  CONSTRAINT [cat_servicios$fk_servicios_categorias] FOREIGN KEY([servicios_categoria_id])
REFERENCES [gestion_citas].[cat_categorias] ([categorias_id])
GO
ALTER TABLE [gestion_citas].[cat_servicios] CHECK CONSTRAINT [cat_servicios$fk_servicios_categorias]
GO
ALTER TABLE [gestion_citas].[ope_citas]  WITH NOCHECK ADD  CONSTRAINT [ope_citas$fk_citas_proveedor] FOREIGN KEY([citas_proveedor_id])
REFERENCES [gestion_citas].[cat_usuarios] ([usuarios_id])
GO
ALTER TABLE [gestion_citas].[ope_citas] CHECK CONSTRAINT [ope_citas$fk_citas_proveedor]
GO
ALTER TABLE [gestion_citas].[ope_citas]  WITH NOCHECK ADD  CONSTRAINT [ope_citas$fk_citas_servicios] FOREIGN KEY([citas_servicios_id])
REFERENCES [gestion_citas].[cat_servicios] ([servicios_id])
GO
ALTER TABLE [gestion_citas].[ope_citas] CHECK CONSTRAINT [ope_citas$fk_citas_servicios]
GO
ALTER TABLE [gestion_citas].[ope_rel_usuario_servicio]  WITH NOCHECK ADD  CONSTRAINT [ope_rel_usuario_servicio$fk_relacion_servicios] FOREIGN KEY([servicios_id])
REFERENCES [gestion_citas].[cat_servicios] ([servicios_id])
GO
ALTER TABLE [gestion_citas].[ope_rel_usuario_servicio] CHECK CONSTRAINT [ope_rel_usuario_servicio$fk_relacion_servicios]
GO
ALTER TABLE [gestion_citas].[ope_rel_usuario_servicio]  WITH NOCHECK ADD  CONSTRAINT [ope_rel_usuario_servicio$fk_usuarios_servicios] FOREIGN KEY([usuarios_id])
REFERENCES [gestion_citas].[cat_usuarios] ([usuarios_id])
GO
ALTER TABLE [gestion_citas].[ope_rel_usuario_servicio] CHECK CONSTRAINT [ope_rel_usuario_servicio$fk_usuarios_servicios]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.apl_configuracion' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'apl_configuracion'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.cat_categorias' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'cat_categorias'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.cat_clientes' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'cat_clientes'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.cat_servicios' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'cat_servicios'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.cat_usuarios' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'cat_usuarios'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.ope_citas' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'ope_citas'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.ope_descansos' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'ope_descansos'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.ope_rel_usuario_servicio' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'ope_rel_usuario_servicio'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'gestion_citas.pacientes' , @level0type=N'SCHEMA',@level0name=N'gestion_citas', @level1type=N'TABLE',@level1name=N'pacientes'
GO
