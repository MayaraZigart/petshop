-- ALTER TABLE pets ADD COLUMN imagem VARCHAR(255);

-- SELECT id, nome, imagem
-- FROM pets;

-- ALTER TABLE pets
-- ADD COLUMN telefone VARCHAR(20),
-- ADD COLUMN data_banho DATE,
-- ADD COLUMN horario TIME,
-- ADD COLUMN observacoes TEXT,
-- ADD COLUMN imagem VARCHAR(255);

-- SELECT column_name
-- FROM information_schema.columns
-- WHERE table_name = 'pets';
SELECT column_name
FROM information_schema.columns
WHERE table_name = 'pets';