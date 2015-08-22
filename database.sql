
create database todo_dotinstall;

grant all on todo_dotinstall.* to dbuser@localhost identified by 'rwrwrwrw0521';


use todo_dotinstall;

create table tasks (
	id int not null auto_increment primary key,
	seq int not null,
	type enum('notyet', 'done', 'deleted') default 'notyet',
	title text,
	created datetime,
	modified datetime,
	KEY type(type),
	KEY seq(seq)
);

insert into tasks 
	(seq, type, title, created, modified) 
	values 
	(1, 'notyet', '牛乳買う', now(), now()),
	(2, 'notyet', '提案書作る', now(), now()),
	(3, 'done', '映画見る', now(), now());
