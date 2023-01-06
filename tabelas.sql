create table TelaPrincipal (
    id int Auto_Increment Primary Key,
    nome varchar(100) not null,
    curso varchar(100) not null,
    localidade varchar(30) not null,
    img varchar(200)
)

create table SobreMim (
    id int Auto_Increment Primary Key,
    texto varchar(1200) not null,
)

create table Projetos (
    id int Auto_Increment Primary Key,
    titulo varchar(100) not null,
    descricao varchar(500) not null,
    img varchar(200),
    link varchar(300),
)

create table percursoAcademico (
    id int Auto_Increment Primary Key,
    ano int not null,
    descricao varchar(50) not null
)
create table certificacoes (
    id int Auto_Increment Primary Key,
    titulo varchar(50),
    img varchar(200) 
)
create table SoftSkills(
    id int Auto_Increment Primary Key,
    softskill varchar(50) not null
)

create table HardSkills(
    id int Auto_Increment Primary key,
    titulo varchar(50) not null,
    percentagem int not null
)

create table Idiomas (
    id int Auto_Increment Primary Key,
    titulo varchar(75) not null,
    percentagem int not null
)

create table Contactos (
    id int Auto_Increment Primary Key,
    icon varchar(100) not null,
    tipo int not null,
    descricao varchar(100) not null 
)

create table mensagens (
    id int Auto_Increment Primary Key,
    nome varchar(100) not null,
    email varchar(150) not null,
    assunto varchar(150) not null,
    mensagem varchar(1000) not null,
    estado int not null
)
