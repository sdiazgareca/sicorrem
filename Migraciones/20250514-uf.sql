CREATE TABLE UF (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mes VARCHAR(20) NOT NULL,
    anio INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL
);

DROP VIEW IF EXISTS vista_uf;

CREATE VIEW vista_uf AS
SELECT 
    uf.id, 
    m.MES AS mes, 
    uf.anio, 
    uf.valor, 
    uf.mes as id_mes
FROM UF uf
INNER JOIN meses m ON m.NUMERO = uf.mes;

CREATE OR REPLACE VIEW contrata_vista AS
SELECT
  contratos.ajuste AS ajuste,
  contratos.f_pago AS f_pago,
  f_pago.descripcion AS des_fpago,
  empresa.empresa AS empresa,
ROUND(
  CASE
    WHEN planes.id_tipo_moneda = 1 THEN planes.v_incor
    WHEN uf.valor IS NOT NULL THEN planes.v_incor * uf.valor
    ELSE 0
  END, 2
) AS v_incor,
  planes.cod_plan AS cod_plan,
  planes.tipo_plan AS tipo_plan,
  planes.desc_plan AS desc_plan,
  contratos.secuencia AS secuencia,
  valor_plan.valor AS mensualidad,
  titulares.nro_doc AS titular,
  titulares.nombre1 AS nombre1,
  titulares.nombre2 AS nombre2,
  titulares.apellido AS apellido,
  contratos.num_solici AS num_solici,
  contratos.d_pago AS d_pago,
  e_contrato.descripcion AS e_contrato_des,
  e_contrato.cod AS e_contrato,
  planes.n_inco_grat AS n_inco_grat,
  uf.valor AS valor_uf,
  planes.id_tipo_moneda AS id_tipo_moneda
FROM contratos
LEFT JOIN planes 
  ON planes.cod_plan = contratos.cod_plan 
  AND planes.tipo_plan = contratos.tipo_plan
LEFT JOIN empresa 
  ON empresa.nro_doc = contratos.empresa
LEFT JOIN valor_plan 
  ON valor_plan.cod_plan = contratos.cod_plan
  AND valor_plan.tipo_plan = planes.tipo_plan
  AND valor_plan.secuencia = contratos.secuencia
LEFT JOIN titulares 
  ON titulares.nro_doc = contratos.titular
JOIN e_contrato 
  ON contratos.estado = e_contrato.cod
JOIN f_pago 
  ON f_pago.codigo = contratos.f_pago
LEFT JOIN uf ON 1=1;


ALTER TABLE planes
MODIFY COLUMN v_incor DECIMAL(10,2) NULL;

ALTER TABLE cta
MODIFY debe DECIMAL(10,2),
MODIFY haber DECIMAL(10,2),
MODIFY importe DECIMAL(10,2);