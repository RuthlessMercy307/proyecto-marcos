create database users;
use users;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(14) NOT NULL,
    usuario VARCHAR(100) NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);
CREATE TABLE redefinir_senha (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  token VARCHAR(64) NOT NULL,
  expiracao DATETIME NOT NULL,
  usado BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON users.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
SELECT * FROM usuarios;
DESCRIBE usuarios;
ALTER TABLE usuarios
ADD COLUMN token_recuperacao VARCHAR(255),
ADD COLUMN token_expira DATETIME;
INSERT INTO usuarios (usuario, email, cpf, telefone, senha)
VALUES ('usuario_teste', 'teste@teste.com', '12345678900', '11999999999', 
        '$2y$10$Zq6nR0Q3h/vJY2HklT1Z8uOSqU3Yw.LK05zX4c53hHlDbKjEOYOTK');







CREATE TABLE pizzas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255) NOT NULL
);

INSERT INTO pizzas (nome, descricao, preco, imagem) VALUES
('5 queijos', 'Molho de tomate especial, mussarela ralada, provolone, parmesão, catupiry, cheddar, oregano e azeitonas', 37.00, '5_queijos.png'),
('3 Porquinhos', 'Molho de tomate especial, mussarela, lombo canadense, calabresa fatiada, bacon, oregano e azeitonas', 37.00, '3_porcos.png'),
('Bauru', 'Molho de tomate especial, mussarela ralada, coxão mole em tiras, tomate em rodelas, orégano e azeitonas', 40.00, 'bauru.png'),
('Brocolis Especial', 'Molho de tomate especial, mussarela ralada, Brocolis refogado, bacon em cubos, catupiry, alho frito, orégano e azeitonas', 40.00, 'brocolis.png'),
('California', 'Molho de tomate especial, mussarela ralada, calabresa fatiada, abacaxi cortado, catupiry, orégano e azeitonas', 40.00, 'california.png');

INSERT INTO usuarios (cpf, usuario, telefone, email, senha)
VALUES ('00000000000', 'admin', '11999999999', 'admin@pizza.com', '$2b$12$E2Heh4DCP29xkGGRMCxuRez62Ne7yRg.r.QoOmt.2MRriyqF/wU56');
