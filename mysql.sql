create database chatPHP default charset utf8;
use chatPHP;
create table if not exists users (user_id int not null primary key auto_increment, user_name varchar(255), mail varchar(255), pass char(60));
create table if not exists comments (comment_id int not null primary key auto_increment, comment varchar(255), user_id int, thread_id int, ts timestamp);
create table if not exists threads (thread_id int not null primary key auto_increment, title varchar(255), user_id int, ts timestamp);

drop table threads;

drop table users;

create table if not exists users (
    user_id int not null primary key auto_increment, 
    user_name varchar(255), 
    mail varchar(255), 
    pass char(60), 
    status int(1), 
    created_at datetime not null default CURRENT_TIMESTAMP,
    updated_at datetime not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
    );


create table if not exists threads (
    thread_id int not null primary key auto_increment, 
    title varchar(255), 
    user_id int, 
    created_at datetime not null default CURRENT_TIMESTAMP,
    updated_at datetime not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
    );

insert into threads (title, user_id) values ("test1", 1);
insert into threads (title, user_id) values ("test2", 1);
insert into threads (title, user_id) values ("test3", 1);
insert into threads (title, user_id) values ("test4", 2);
insert into threads (title, user_id) values ("test5", 2);
insert into threads (title, user_id) values ("test6", 2);




drop table comments;

create table if not exists comments (
    comment_id int not null, 
    thread_id int not null,
    comment varchar(255), 
    user_id int, 
    user_name varchar(255), 
    created_at datetime not null default CURRENT_TIMESTAMP,
    updated_at datetime not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    primary key (comment_id, thread_id)
    );

insert into comments (comment, user_id, user_name, comment_id, thread_id) values ("test1への書き込み", 1, "ゲスト", 1, 3);
insert into comments (comment, user_id, user_name, comment_id, thread_id) values ("test1への書き込み", 1, "ゲスト", 2, 3);
insert into comments (comment, user_id, user_name, comment_id, thread_id) values ("test1への書き込み", 1, "ゲスト", 3, 3);
insert into comments (comment, user_id, user_name, comment_id, thread_id) values ("test1への書き込み", 1, "ゲスト", 1, 4);
insert into comments (comment, user_id, user_name, comment_id, thread_id) values ("test1への書き込み", 1, "ゲスト", 2, 4);
