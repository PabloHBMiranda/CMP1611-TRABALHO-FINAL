--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: cmp1611_trabalho_final; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA cmp1611_trabalho_final;


ALTER SCHEMA cmp1611_trabalho_final OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: motorista_veiculo; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.motorista_veiculo (
    cpf_motorista bigint NOT NULL,
    placa_veiculo character(7) NOT NULL
);


ALTER TABLE cmp1611_trabalho_final.motorista_veiculo OWNER TO postgres;

--
-- Name: motoristas; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.motoristas (
    cpf_motorista bigint NOT NULL,
    cnh character varying(15) NOT NULL,
    banco_mot integer NOT NULL,
    agencia_mot integer NOT NULL,
    conta_mot integer NOT NULL
);


ALTER TABLE cmp1611_trabalho_final.motoristas OWNER TO postgres;

--
-- Name: passageiros; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.passageiros (
    cpf_passag bigint NOT NULL,
    cartao_cred character varying(20),
    bandeira_cartao character varying(20),
    cidade_orig character varying(30)
);


ALTER TABLE cmp1611_trabalho_final.passageiros OWNER TO postgres;

--
-- Name: pessoas; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.pessoas (
    cpf_pessoa bigint NOT NULL,
    nome character varying(50) NOT NULL,
    endereco character varying(50),
    telefone bigint,
    sexo character(1),
    email character varying(30),
    CONSTRAINT pessoas_sexo_check CHECK ((sexo = ANY (ARRAY['M'::bpchar, 'F'::bpchar])))
);


ALTER TABLE cmp1611_trabalho_final.pessoas OWNER TO postgres;

--
-- Name: proprietarios; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.proprietarios (
    cpf_prop bigint NOT NULL,
    cnh_prop character varying(15) NOT NULL,
    banco_prop integer NOT NULL,
    agencia_prop integer NOT NULL,
    conta_prop integer NOT NULL
);


ALTER TABLE cmp1611_trabalho_final.proprietarios OWNER TO postgres;

--
-- Name: tipo_pagto; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.tipo_pagto (
    cod_pagto integer NOT NULL,
    desc_pagto character varying(20) NOT NULL
);


ALTER TABLE cmp1611_trabalho_final.tipo_pagto OWNER TO postgres;

--
-- Name: veiculo; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.veiculo (
    placa character(7) NOT NULL,
    marca character varying(30) NOT NULL,
    modelo character varying(30) NOT NULL,
    ano_fabric integer NOT NULL,
    capacidade_pass integer NOT NULL,
    cor character varying(30) NOT NULL,
    tipo_combust character(1) NOT NULL,
    potencia_motor integer,
    veiculo_proprietarios__fk bigint,
    CONSTRAINT veiculo_tipo_combust_check CHECK ((tipo_combust = ANY (ARRAY['G'::bpchar, 'A'::bpchar, 'D'::bpchar, 'F'::bpchar])))
);


ALTER TABLE cmp1611_trabalho_final.veiculo OWNER TO postgres;

--
-- Name: viagem; Type: TABLE; Schema: cmp1611_trabalho_final; Owner: postgres
--

CREATE TABLE cmp1611_trabalho_final.viagem (
    cpf_pass_viag bigint NOT NULL,
    cpf_mot_viag bigint NOT NULL,
    placa_veic_viag character(7) NOT NULL,
    local_orig_viag character varying(30),
    local_dest_viag character varying(30),
    dt_hora_inicio date NOT NULL,
    dt_hora_fim date,
    qtde_pass integer,
    forma_pagto character varying(10),
    valor_pagto numeric(10,2),
    cancelam_mot character(1),
    cancelam_pass character(1),
    CONSTRAINT viagem_cancelam_mot_check CHECK ((cancelam_mot = ANY (ARRAY['S'::bpchar, 'N'::bpchar]))),
    CONSTRAINT viagem_cancelam_pass_check CHECK ((cancelam_pass = ANY (ARRAY['S'::bpchar, 'N'::bpchar]))),
    CONSTRAINT viagem_forma_pagto_check CHECK (((forma_pagto)::text = ANY (ARRAY[('DINHEIRO'::character varying)::text, ('CARTAO'::character varying)::text, ('POSTERIORI'::character varying)::text])))
);


ALTER TABLE cmp1611_trabalho_final.viagem OWNER TO postgres;

--
-- Data for Name: motorista_veiculo; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.motorista_veiculo (cpf_motorista, placa_veiculo) FROM stdin;
\.


--
-- Data for Name: motoristas; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.motoristas (cpf_motorista, cnh, banco_mot, agencia_mot, conta_mot) FROM stdin;
\.


--
-- Data for Name: passageiros; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.passageiros (cpf_passag, cartao_cred, bandeira_cartao, cidade_orig) FROM stdin;
\.


--
-- Data for Name: pessoas; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.pessoas (cpf_pessoa, nome, endereco, telefone, sexo, email) FROM stdin;
\.


--
-- Data for Name: proprietarios; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.proprietarios (cpf_prop, cnh_prop, banco_prop, agencia_prop, conta_prop) FROM stdin;
\.


--
-- Data for Name: tipo_pagto; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.tipo_pagto (cod_pagto, desc_pagto) FROM stdin;
\.


--
-- Data for Name: veiculo; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.veiculo (placa, marca, modelo, ano_fabric, capacidade_pass, cor, tipo_combust, potencia_motor, veiculo_proprietarios__fk) FROM stdin;
\.


--
-- Data for Name: viagem; Type: TABLE DATA; Schema: cmp1611_trabalho_final; Owner: postgres
--

COPY cmp1611_trabalho_final.viagem (cpf_pass_viag, cpf_mot_viag, placa_veic_viag, local_orig_viag, local_dest_viag, dt_hora_inicio, dt_hora_fim, qtde_pass, forma_pagto, valor_pagto, cancelam_mot, cancelam_pass) FROM stdin;
\.


--
-- Name: motorista_veiculo motorista_veiculo_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.motorista_veiculo
    ADD CONSTRAINT motorista_veiculo_pkey PRIMARY KEY (cpf_motorista, placa_veiculo);


--
-- Name: motoristas motoristas_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.motoristas
    ADD CONSTRAINT motoristas_pkey PRIMARY KEY (cpf_motorista);


--
-- Name: passageiros passageiros_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.passageiros
    ADD CONSTRAINT passageiros_pkey PRIMARY KEY (cpf_passag);


--
-- Name: pessoas pessoas_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.pessoas
    ADD CONSTRAINT pessoas_pkey PRIMARY KEY (cpf_pessoa);


--
-- Name: proprietarios proprietarios_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.proprietarios
    ADD CONSTRAINT proprietarios_pkey PRIMARY KEY (cpf_prop);


--
-- Name: tipo_pagto tipo_pagto_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.tipo_pagto
    ADD CONSTRAINT tipo_pagto_pkey PRIMARY KEY (cod_pagto);


--
-- Name: veiculo veiculo_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.veiculo
    ADD CONSTRAINT veiculo_pkey PRIMARY KEY (placa);


--
-- Name: viagem viagem_pkey; Type: CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.viagem
    ADD CONSTRAINT viagem_pkey PRIMARY KEY (cpf_pass_viag, cpf_mot_viag, placa_veic_viag);


--
-- Name: motorista_veiculo motorista_veiculo_cpf_motorista_fkey; Type: FK CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.motorista_veiculo
    ADD CONSTRAINT motorista_veiculo_cpf_motorista_fkey FOREIGN KEY (cpf_motorista) REFERENCES cmp1611_trabalho_final.motoristas(cpf_motorista);


--
-- Name: motorista_veiculo motorista_veiculo_placa_veiculo_fkey; Type: FK CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.motorista_veiculo
    ADD CONSTRAINT motorista_veiculo_placa_veiculo_fkey FOREIGN KEY (placa_veiculo) REFERENCES cmp1611_trabalho_final.veiculo(placa);


--
-- Name: veiculo veiculo_proprietarios_cpf_prop_fk; Type: FK CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.veiculo
    ADD CONSTRAINT veiculo_proprietarios_cpf_prop_fk FOREIGN KEY (veiculo_proprietarios__fk) REFERENCES cmp1611_trabalho_final.proprietarios(cpf_prop);


--
-- Name: viagem viagem_cpf_mot_viag_fkey; Type: FK CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.viagem
    ADD CONSTRAINT viagem_cpf_mot_viag_fkey FOREIGN KEY (cpf_mot_viag) REFERENCES cmp1611_trabalho_final.motoristas(cpf_motorista);


--
-- Name: viagem viagem_cpf_pass_viag_fkey; Type: FK CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.viagem
    ADD CONSTRAINT viagem_cpf_pass_viag_fkey FOREIGN KEY (cpf_pass_viag) REFERENCES cmp1611_trabalho_final.passageiros(cpf_passag);


--
-- Name: viagem viagem_placa_veic_viag_fkey; Type: FK CONSTRAINT; Schema: cmp1611_trabalho_final; Owner: postgres
--

ALTER TABLE ONLY cmp1611_trabalho_final.viagem
    ADD CONSTRAINT viagem_placa_veic_viag_fkey FOREIGN KEY (placa_veic_viag) REFERENCES cmp1611_trabalho_final.veiculo(placa);


--
-- PostgreSQL database dump complete
--

