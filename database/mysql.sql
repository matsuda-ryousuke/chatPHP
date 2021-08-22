create database chatPHP default charset utf8;

grant all privileges on chatPHP.* to 'mysql-user'@'%' identified by '8QLQ"u>P>S89' with grant option;


use chatPHP;

# drop table users;

create table if not exists users (
    user_id int not null primary key auto_increment, 
    user_name varchar(255), 
    mail varchar(255), 
    pass char(60), 
    status int(1), 
    created_at datetime not null default CURRENT_TIMESTAMP,
    updated_at datetime not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
    );

# drop table threads;

create table if not exists threads (
    thread_id int not null primary key auto_increment, 
    title varchar(255), 
    user_id int, 
    user_name varchar(255), 
    comment_count int default 0, 
    created_at datetime not null default CURRENT_TIMESTAMP,
    updated_at datetime not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
    );


# drop table comments;

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

# drop table favorites;
create table if not exists favorites (
    user_id int,
    thread_id int,
    created_at datetime not null default CURRENT_TIMESTAMP,
    updated_at datetime not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    primary key (user_id, thread_id)
);

# insert into threads (title, user_id) values ("thread1", 1);
# insert into threads (title, user_id) values ("thread2", 1);
# insert into threads (title, user_id) values ("thread3", 1);
# insert into threads (title, user_id) values ("thread4", 2);
# insert into threads (title, user_id) values ("thread5", 2);
# insert into threads (title, user_id) values ("thread6", 2);


# ログイン失敗
create table if not exists login_fails (
    user_id int,
    ip varchar(20),
    created_at datetime not null default CURRENT_TIMESTAMP
);

