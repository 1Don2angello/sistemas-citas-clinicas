USE gestion_citas;

DROP TABLE IF EXISTS gestion_citas.historial;

CREATE TABLE [gestion_citas].[historial]
(
    [id] INT IDENTITY(1,1) PRIMARY KEY,
   clave int NOT NULL,
  nombre varchar(50) NOT NULL,
  sexo varchar(20) NOT NULL,
  edad int NOT NULL,
  altura int NOT NULL,
  peso int NOT NULL,
  analisisCovid varchar(20) NOT NULL,
  sintomas varchar(300) NOT NULL,
  diagnostico varchar(300) NOT NULL,
  tratamiento varchar(300) NOT NULL,
  instrucciones varchar(300) NOT NULL,
  fecha datetime NOT NULL DEFAULT GETDATE()
);