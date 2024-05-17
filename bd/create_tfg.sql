drop database if exists tfg;
create database tfg;
use tfg;


create table libro (
id_libro int primary key auto_increment unique,
titulo varchar (300) not null,
portada varchar (500) not null,
sinopsis text not null,
fecha_publicacion date not null,
autor varchar (300) not null,
media_valoraciones double default 0,
paginas int not null,
check(media_valoraciones <=5)
);

insert into libro (titulo,portada,sinopsis,fecha_publicacion,autor,paginas) values ("El imperio final (Nacidos de la Bruma)","1.jpg",
"Las brumas gobiernan la noche. El lord Legislador domina el mundo. En otros tiempos, un héroe se alzó para salvar la humanidad. 
Fracasó. Desde entonces, el mundo es un erial de ceniza y niebla gobernado por un emperador inmortal conocido como el lord Legislador. 
Pero la esperanza perdura. Una nueva revuelta cobra forma cimentándose en la treta definitiva: la astucia de un brillante genio del crimen y la determinación de una heroína insólita, 
una joven ladrona callejera que deberá aprender a controlar el poder de los nacidos de la bruma.","2006-7-17","Brandon Sanderson","541");
insert into libro (titulo,portada,sinopsis,fecha_publicacion,autor,paginas) values ("El pozo de la ascensión (Nacidos de la Bruma)", "2.jpg","
El Pozo de la Ascensión es el segundo volumen de la saga «Nacidos de la Bruma [Mistborn]», una obra iniciada con El imperio final y parte 
imprescindible del Cosmere, el universo destinado a dar forma a la serie más extensa y fascinante jamás escrita en el ámbito de la fantasía épica.
Durante mil años han caído las cenizas y nada florece. Durante mil años los skaa han sido esclavizados y viven sumidos en un miedo inevitable. 
Durante mil años el Lord Legislador reina con un poder absoluto gracias al terror, a sus poderes y a su inmortalidad. Pero vencer y 
matar al Lord Legislador fue la parte sencilla. El verdadero desafío será sobrevivir a las consecuencias de su caída.
Tomar el poder tal vez resultó fácil, pero ¿qué ocurre después?, ¿cómo se utiliza? En ese mundo de aventura épica, la estrategia política y 
religiosa debe lidiar con los siempre misteriosos poderes de la alomancia...","2007-8-21","Brandon Sanderson","784");
select * from libro;

create table usuario (
id_usuario int primary key auto_increment unique,
nombre_completo varchar (300) not null,
usuario varchar (50) not null,
contrasena varchar (500) not null,
administrador int not null default 0,
foto_perfil varchar(500) DEFAULT NULL
);

insert into usuario (nombre_completo,usuario,contrasena,administrador,foto_perfil) values ("Administrador", "admin","admin","1","admin.jpg");
insert into usuario (nombre_completo,usuario,contrasena,foto_perfil) values ("Maria Gil", "maria","maria","maria.jpg");

create table publicacion(
id_publicacion int primary key auto_increment unique,
tipo_publicacion int not null,
texto_publicacion text not null,
id_usuario int not null,
fecha date not null,
id_libro int not null,
FOREIGN KEY (id_libro) REFERENCES libro(id_libro),
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
id_libro int not null,
foreign key (id_libro) references libro (id_libro),
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

select * from usuario;