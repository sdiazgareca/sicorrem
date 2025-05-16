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