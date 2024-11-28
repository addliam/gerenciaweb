-- Tabla Usuario
CREATE TABLE Usuario (
    usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

-- Tabla CategoriaGasto
CREATE TABLE CategoriaGasto (
    categoriagasto_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla Gasto
CREATE TABLE Gasto (
    gasto_id INT PRIMARY KEY AUTO_INCREMENT,
    categoriagasto_id INT,
    usuario_id INT,
    nombre VARCHAR(100) NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    fecha DATE NOT NULL,
    FOREIGN KEY (categoriagasto_id) REFERENCES CategoriaGasto(categoriagasto_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(usuario_id)
);

DELIMITER //
CREATE PROCEDURE insertar_gasto (
    IN p_usuario_id INT,
    IN p_nombre VARCHAR(100),
    IN p_monto DECIMAL(10, 2),
    IN p_categoria_id INT
)
BEGIN
        -- Insertar el gasto en la tabla Gasto con la fecha actual
        INSERT INTO Gasto (usuario_id, categoriagasto_id, nombre, monto, fecha)
        VALUES (p_usuario_id, p_categoria_id, p_nombre, p_monto, CURDATE());
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE obtener_gastos()
BEGIN
    SELECT 
        g.gasto_id,
        cg.nombre AS categoria_nombre,
        g.nombre AS gasto_nombre,
        g.monto,
        g.fecha
    FROM 
        Gasto g
    JOIN 
        CategoriaGasto cg ON g.categoriagasto_id = cg.categoriagasto_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertar_categoria_gasto(IN nombre_categoria VARCHAR(100))
BEGIN
    DECLARE categoria_existente INT;
    -- Verificar si la categoría ya existe
    SELECT COUNT(*) INTO categoria_existente
    FROM CategoriaGasto
    WHERE nombre = nombre_categoria;
    -- Si la categoría existe, mostrar mensaje
    IF categoria_existente > 0 THEN
        SELECT CONCAT('La categoría "', nombre_categoria, '" ya existe.') AS mensaje;
    ELSE
        -- Si no existe, insertar la nueva categoría
        INSERT INTO CategoriaGasto (nombre) 
        VALUES (nombre_categoria);
        SELECT CONCAT('La categoría "', nombre_categoria, '" ha sido insertada exitosamente.') AS mensaje;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE obtener_categorias_gasto()
BEGIN
    SELECT categoriagasto_id, nombre
    FROM CategoriaGasto;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_categoria_gasto(IN p_categoriagasto_id INT, IN p_nombre VARCHAR(100))
BEGIN
    DECLARE categoria_existente INT;

    -- Verificar si la categoría existe
    SELECT COUNT(*) INTO categoria_existente
    FROM CategoriaGasto
    WHERE categoriagasto_id = p_categoriagasto_id;

    -- Si la categoría existe, proceder a actualizar
    IF categoria_existente > 0 THEN
        UPDATE CategoriaGasto
        SET nombre = p_nombre
        WHERE categoriagasto_id = p_categoriagasto_id;
        SELECT CONCAT('La categoría con ID "', p_categoriagasto_id, '" ha sido actualizada a "', p_nombre, '".') AS mensaje;
    ELSE
        -- Si no existe, mostrar mensaje
        SELECT CONCAT('No se encontró la categoría con ID "', p_categoriagasto_id, '".') AS mensaje;
    END IF;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertar_gasto (
    IN p_usuario_id INT,
    IN p_nombre VARCHAR(100),
    IN p_monto DECIMAL(10, 2),
    IN p_categoria_id INT
)
BEGIN
        -- Insertar el gasto en la tabla Gasto con la fecha actual
        INSERT INTO Gasto (usuario_id, categoriagasto_id, nombre, monto, fecha)
        VALUES (p_usuario_id, p_categoria_id, p_nombre, p_monto, CURDATE());
END //
DELIMITER ;