CREATE DATABASE classificados;

USE classificados;

CREATE TABLE usuarios(
    id int primary key auto_increment,
    nome varchar(100) not null,
    email varchar(100) not null,
    senha varchar(32) not null,
    telefone varchar(11)
);

CREATE TABLE categorias(
    id int primary key auto_increment,
    nome varchar(100) not null
);

CREATE TABLE anuncios(
    id int primary key auto_increment,
    id_usuario int not null,
    id_categoria int not null,
    titulo varchar(150) not null,
    descricao text,
    valor decimal(10, 2) not null,
    estado enum('1', '2', '3') not null,
    foreign key(id_usuario) references usuarios(id),
    foreign key(id_categoria) references categorias(id)
);

CREATE TABLE anuncios_imagens(
    id int primary key auto_increment,
    id_anuncio int not null,
    url varchar(50) not null,
    foreign key (id_anuncio) references anuncios(id)
);