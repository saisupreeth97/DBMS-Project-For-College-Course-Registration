# DBMS-Project-For-College-Course-Registration
Created a website for college course registration using database and php
/* Instructions to be followed */

Install xampp app in the desktop

start all the servers in the xampp

open hotdocs in xampp files and place the loginSystem file there

Now open the browser and type localhost and select phpMyadmin from there

now create the schema with the name loginSystem

create the tables as follows

create table users(
user_id int(11) not null auto_increment,
user_first varchar(255) not null,
user_last varchar(255) not null,
user_email varchar(255) not null,
user_uid varchar(255) not null,
user_pwd varchar(255) not null,
depart varchar(255) not null,
primary key(user_id)
);

create table course(
c_id int(11) not null auto_increment,
c_no varchar(255) not null,
c_name varchar(255) not null,
sem int(11) not null,
credits int(11) not null,
dept varchar(255) not null,
primary key(c_id)
);

create table rtype(
r_id int(11) not null auto_increment,
c_id int(11) not null,
type varchar(255) not null,
price int(11) not null,
primary key(r_id),
foreign key(c_id) references course(c_id)
);

create table register(
r_id int(11) not null,
c_id int(11) not null,
price int(11) not null,
primary key(r_id,c_id),
foreign key(r_id) references rtype(r_id),
foreign key(c_id) references course(c_id)
);

create table p_register(
pr_id int(11) not null auto_increment,
user_id int(11) not null,
nos int(11) not null,
type varchar(255) not null,
t_price int(11) not null,
primary key(pr_id),
foreign key(user_id) references users(user_id)
);

and run the code in the browser
