create table anketa(
login int(10) not null,
password varchar(128) not null,
name varchar(128) not null default '',
email varchar(128) not null default '',
date varchar(128) not null default '',
gender varchar(128) not null default '',
limb varchar(128) not null default '',
super1 varchar(128) not null default '',
super2 varchar(128) not null default '',
super3 varchar(128) not null default '',
message varchar(128) not null default '',
checker varchar(128) not null default '',
PRIMARY KEY (login)
);
