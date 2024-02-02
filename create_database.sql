-- execute this scrpit to create an sqlite DB
drop table if exists todo;

create table todo
(
    id          integer primary key autoincrement,
    title       varchar(255) not null,
    description text,
    due_at      timestamp,
    finished    boolean default false
);

-- Insert some fake coder todos
insert into todo (title, description, due_at)
values ('Learn Python', 'Learn Python to be able to write some cool scripts', '2019-12-31 23:59:59'),
       ('Learn Flask', 'Learn Flask to be able to write some cool web apps', '2019-12-31 23:59:59'),
       ('Learn Django', 'Learn Django to be able to write some cool web apps', '2019-12-31 23:59:59'),
       ('Learn React', 'Learn React to be able to write some cool web apps', '2019-12-31 23:59:59'),
       ('Learn Vue', 'Learn Vue to be able to write some cool web apps', '2019-12-31 23:59:59'),
       ('Learn Angular', 'Learn Angular to be able to write some cool web apps', '2019-12-31 23:59:59');
