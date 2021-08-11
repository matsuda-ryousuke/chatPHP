create database chatPHP default charset utf8;
use chatPHP;
create table if not exists users (user_id int not null primary key auto_increment, name varchar(255), mail varchar(255), pass char(60));
create table if not exists comments (comment_id int not null primary key auto_increment, comment varchar(255), user_id int, thread_id int, ts timestamp);
create table if not exists threads (thread_id int not null primary key auto_increment, title varchar(255), user_id int, ts timestamp);

