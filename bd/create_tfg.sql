drop database if exists tfg;
create database tfg;
use tfg;


create table libro (
id_libro int primary key auto_increment unique,
ISBN varchar (13) unique,
titulo varchar (300) not null,
portada varchar (500) not null,
descripcion text not null,
fecha_publicacion date not null,
autor varchar (300) not null,
media_valoraciones double,
check(media_valoraciones <=5)
);

create table genero (
id_genero int primary key auto_increment unique,
nombre_genero varchar (300) not null
);

CREATE TABLE GeneroLibro (
    id_libro int,
    id_genero int,
    FOREIGN KEY (id_libro) REFERENCES libro(id_libro),
    FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

create table usuario (
id_usuario int primary key auto_increment unique,
nombre_completo varchar (300) not null,
usuario varchar (50) not null,
contrasena varchar (500) not null,
admin int not null default 0
);

create table publicacion(
id_publicacion int primary key auto_increment unique,
tipo_publicacion int not null,
texto_publicacion text not null,
id_usuario int not null,
fecha date not null,
isbn varchar (13) not null,
foreign key (isbn) references libro (ISBN),
foreign key (id_usuario) references usuario (id_usuario)
);

create table seguidores (
seguidor int not null,
seguido int not null,
foreign key (seguidor) references usuario (id_usuario),
foreign key (seguido) references usuario (id_usuario)
);

create table biblioteca (
id_usuario int not null,
progreso int not null default 0,
valoracion int,
estado boolean default false,
fecha_actualizado date not null,
isbn varchar (13) not null,
foreign key (isbn) references libro (ISBN),
foreign key (id_usuario) references usuario (id_usuario)
);

create table likes (
id_publicacion int not null,
id_usuario int not null,
foreign key (id_usuario) references usuario (id_usuario),
foreign key (id_publicacion) references publicacion (id_publicacion)
);

create table comentario (
id_comentario int primary key auto_increment unique,
id_usuario int not null,
id_publicacion int not null,
texto text not null,
fecha date not null,
foreign key (id_usuario) references usuario (id_usuario),
foreign key (id_publicacion) references publicacion (id_publicacion)
);