-- Criação do Schema
CREATE SCHEMA cmp1611_trabalho_final;

-- Tabela VEICULO
CREATE TABLE cmp1611_trabalho_final.VEICULO (
                                                Placa CHAR(7) PRIMARY KEY,
                                                Marca VARCHAR(30) NOT NULL,
                                                Modelo VARCHAR(30) NOT NULL,
                                                Ano_fabric INT NOT NULL,
                                                Capacidade_pass INT NOT NULL,
                                                Cor VARCHAR(30) NOT NULL,
                                                Tipo_combust CHAR(1) NOT NULL CHECK (Tipo_combust IN ('G', 'A', 'D', 'F')),
                                                Potencia_motor INT
);

-- Tabela PESSOAS
CREATE TABLE cmp1611_trabalho_final.PESSOAS (
                                                Cpf_pessoa BIGINT PRIMARY KEY,
                                                Nome VARCHAR(50) NOT NULL,
                                                Endereco VARCHAR(50),
                                                Telefone INT,
                                                Sexo CHAR(1) CHECK (Sexo IN ('M', 'F')),
                                                Email VARCHAR(30)
);

-- Tabela PASSAGEIROS
CREATE TABLE cmp1611_trabalho_final.PASSAGEIROS (
                                                    Cpf_passag BIGINT PRIMARY KEY,
                                                    Cartao_cred VARCHAR(20),
                                                    Bandeira_cartao VARCHAR(20),
                                                    Cidade_orig VARCHAR(30)
);

-- Tabela MOTORISTAS
CREATE TABLE cmp1611_trabalho_final.MOTORISTAS (
                                                   Cpf_motorista BIGINT PRIMARY KEY,
                                                   CNH VARCHAR(15) NOT NULL,
                                                   Banco_mot INT NOT NULL,
                                                   Agencia_mot INT NOT NULL,
                                                   Conta_mot INT NOT NULL
);

-- Tabela PROPRIETARIOS
CREATE TABLE cmp1611_trabalho_final.PROPRIETARIOS (
                                                      Cpf_prop BIGINT PRIMARY KEY,
                                                      CNH_prop VARCHAR(15) NOT NULL,
                                                      Banco_prop INT NOT NULL,
                                                      Agencia_prop INT NOT NULL,
                                                      Conta_prop INT NOT NULL
);

-- Tabela VIAGEM
CREATE TABLE cmp1611_trabalho_final.VIAGEM (
                                               Cpf_pass_viag BIGINT NOT NULL,
                                               Cpf_mot_viag BIGINT NOT NULL,
                                               Placa_veic_viag CHAR(7) NOT NULL,
                                               Local_orig_viag VARCHAR(30),
                                               Local_dest_viag VARCHAR(30),
                                               Dt_hora_inicio DATE NOT NULL,
                                               Dt_hora_fim DATE,
                                               Qtde_pass INT,
                                               Forma_pagto VARCHAR(10) CHECK (Forma_pagto IN ('DINHEIRO', 'CARTAO', 'POSTERIORI')),
                                               Valor_pagto NUMERIC(10, 2),
                                               Cancelam_mot CHAR(1) CHECK (Cancelam_mot IN ('S', 'N')),
                                               Cancelam_pass CHAR(1) CHECK (Cancelam_pass IN ('S', 'N')),
                                               PRIMARY KEY (Cpf_pass_viag, Cpf_mot_viag, Placa_veic_viag),
                                               FOREIGN KEY (Cpf_pass_viag) REFERENCES cmp1611_trabalho_final.PASSAGEIROS(Cpf_passag),
                                               FOREIGN KEY (Cpf_mot_viag) REFERENCES cmp1611_trabalho_final.MOTORISTAS(Cpf_motorista),
                                               FOREIGN KEY (Placa_veic_viag) REFERENCES cmp1611_trabalho_final.VEICULO(Placa)
);

-- Tabela MOTORISTA-VEICULO
CREATE TABLE cmp1611_trabalho_final.MOTORISTA_VEICULO (
                                                          Cpf_motorista BIGINT NOT NULL,
                                                          Placa_veiculo CHAR(7) NOT NULL,
                                                          PRIMARY KEY (Cpf_motorista, Placa_veiculo),
                                                          FOREIGN KEY (Cpf_motorista) REFERENCES cmp1611_trabalho_final.MOTORISTAS(Cpf_motorista),
                                                          FOREIGN KEY (Placa_veiculo) REFERENCES cmp1611_trabalho_final.VEICULO(Placa)
);

-- Tabela TIPO-PAGTO
CREATE TABLE cmp1611_trabalho_final.TIPO_PAGTO (
                                                   COD_PAGTO INT PRIMARY KEY,
                                                   DESC_PAGTO VARCHAR(20) NOT NULL
);
