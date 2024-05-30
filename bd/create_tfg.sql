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

insert into libro (titulo,portada,sinopsis,fecha_publicacion,autor,paginas) values ("El Imperio final (Nacidos de la Bruma)","1.jpg",
"Las brumas gobiernan la noche. El lord Legislador domina el mundo. En otros tiempos, un héroe se alzó para salvar la humanidad. 
Fracasó. Desde entonces, el mundo es un erial de ceniza y niebla gobernado por un emperador inmortal conocido como el lord Legislador. 
Pero la esperanza perdura. Una nueva revuelta cobra forma cimentándose en la treta definitiva: la astucia de un brillante genio del crimen y la determinación de una heroína insólita, 
una joven ladrona callejera que deberá aprender a controlar el poder de los nacidos de la bruma.","2006-7-17","Brandon Sanderson","541");
insert into libro (titulo,portada,sinopsis,fecha_publicacion,autor,paginas) values ("El Pozo de la Ascensión (Nacidos de la Bruma)", "2.jpg","
El Pozo de la Ascensión es el segundo volumen de la saga «Nacidos de la Bruma [Mistborn]», una obra iniciada con El imperio final y parte 
imprescindible del Cosmere, el universo destinado a dar forma a la serie más extensa y fascinante jamás escrita en el ámbito de la fantasía épica.
Durante mil años han caído las cenizas y nada florece. Durante mil años los skaa han sido esclavizados y viven sumidos en un miedo inevitable. 
Durante mil años el Lord Legislador reina con un poder absoluto gracias al terror, a sus poderes y a su inmortalidad. Pero vencer y 
matar al Lord Legislador fue la parte sencilla. El verdadero desafío será sobrevivir a las consecuencias de su caída.
Tomar el poder tal vez resultó fácil, pero ¿qué ocurre después?, ¿cómo se utiliza? En ese mundo de aventura épica, la estrategia política y 
religiosa debe lidiar con los siempre misteriosos poderes de la alomancia...","2007-8-21","Brandon Sanderson","784");
insert into libro (titulo,portada,sinopsis,fecha_publicacion,autor,paginas) values ("El Héroe de las Eras (Nacidos de la Bruma)", "3.jpg","El Héroe de las Eras es el tercer volumen de la saga 
«Nacidos de la Bruma [Mistborn]». Una obra iniciada con El imperio final y parte imprescindible del Cosmere, el universo destinado a dar forma a la serie más extensa 
y fascinante jamás escrita en el ámbito de la fantasía épica.Durante mil años los skaa han vivido esclavizados y sumidos en el miedo al Lord Legislador, 
que ha reinado con un poder absoluto gracias al terror y a la poderosa magia de la «alomancia». Kelsier, el «superviviente», el único que ha logrado 
huir de los Pozos de Hathsin, ha encontrado a Vin, una pobre chica skaa con mucha suerte. Los dos se unen a la rebelión que los skaa intentan
desde hace un milenio y vencen al Lord Legislador. Pero acabar con el Lord Legislador es la parte sencilla. El verdadero desafío consistirá e
n sobrevivir a las consecuencias de su caída. En El héroe de las eras se comprende el porqué de la niebla y las cenizas, las tenebrosas 
acciones del Lord Legislador y la naturaleza del Pozo de la Ascensión. Vin y el Rey Elend buscan en los últimos escondites de recursos 
del Lord Legislador y descubren el peligro que acecha a la humanidad. ¿Conseguirán detenerlo a tiempo?","2008-10-14","Brandon Sanderson",760);
insert into libro (titulo,portada,sinopsis,fecha_publicacion,autor,paginas) values ("El Camino de los Reyes (El Archivo de las Tormentas)", "4.jpg","El camino de los reyes es el primer volumen de «El Archivo de las Tormentas», el resultado de más de una década de construcción y escritura de universos, convertido en una obra maestra de la fantasía contemporánea en diez volúmenes. 
Con ella, Brandon Sanderson se postula como el autor del género que más lectores está ganando en todo el mundo.Anhelo los días previos a la Última Desolación.
Los días en que los Heraldos nos abandonaron y los Caballeros Radiantes se giraron en nuestra contra. Un tiempo en que aún había magia en el mundo y honor en el corazón de los hombres.
El mundo fue nuestro, pero lo perdimos. Probablemente no hay nada más estimulante para las almas de los hombres que la victoria.
¿O tal vez fue la victoria una ilusión durante todo ese tiempo? ¿Comprendieron nuestros enemigos que cuanto más duramente luchaban, más resistíamos nosotros? 
Quizá vieron que el fuego y el martillo tan solo producían mejores espadas. Pero ignoraron el acero durante el tiempo suficiente para oxidarse.
Hay cuatro personas a las que observamos. La primera es el médico, quien dejó de curar para convertirse en soldado durante la guerra más brutal de nuestro tiempo. 
La segunda es el asesino, un homicida que llora siempre que mata. La tercera es la mentirosa, una joven que viste un manto de erudita sobre un corazón de ladrona. 
Por último está el alto príncipe, un guerrero que mira al pasado mientras languidece su sed de guerra.
El mundo puede cambiar. La potenciación y el uso de las esquirlas pueden aparecer de nuevo, la magia de los días pasados puede volver a ser nuestra. Esas cuatro personas son la clave.
Una de ellas nos redimirá. Y una de ellas nos destruirá.","2010-8-31","Brandon Sanderson",1200);
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

create table biblioteca (
id_usuario int not null,
progreso int not null default 0,
valoracion int,
estado varchar (500) not null, #Pendiente, leyendo, acabado
id_libro int not null,
foreign key (id_libro) references libro (id_libro),
foreign key (id_usuario) references usuario (id_usuario)
);

select * from biblioteca;
update biblioteca set estado="Leyendo" where id_libro=1 and id_usuario=2;

SELECT AVG(valoracion) AS media_valoraciones
FROM biblioteca
WHERE id_libro = 1 AND valoracion IS NOT NULL;


create table publicacion(
texto varchar (600) not null,
id_publicacion int primary key auto_increment unique,
id_usuario int not null,
fecha datetime not null,
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

create table likes (
id_publicacion int not null,
id_usuario int not null,
foreign key (id_usuario) references usuario (id_usuario),
foreign key (id_publicacion) references publicacion (id_publicacion)
);


select * from publicacion;
select * from likes;