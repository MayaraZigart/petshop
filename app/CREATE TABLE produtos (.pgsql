CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(60),
    categoria VARCHAR(50),
    preco DECIMAL(10,2),
    estoque INT
);