create table impress_users (
    id int(11) not null unique AUTO_INCREMENT,
    fname varchar(255) not null,
    lname varchar(255) not null default '@impress',
    username varchar(255) not null unique,
    email varchar(255) not null unique,
    contact varchar(255) not null,
    cpf varchar(255) not null unique,
    company varchar(255) default 'Não_Informado',
    address varchar(255) not null,
    password varchar(255) not null,
    status varchar(255) not null,
    permissions varchar(255) not null,
    canbuy varchar(255) not null default '1',
    buylimit varchar(255) not null default '-1',
    banned varchar(255) not null default '0',
    primary key(id)
) default charset = "utf8";

create table impress_products (
    id int(11) not null unique AUTO_INCREMENT,
    name varchar(255) not null,
    file varchar(255) not null,
    description varchar(255) not null default 'Produto vendido pela Industria IMPRESS',
    vm varchar(255) not null default '0',
    vp varchar(255) not null default '0',
    fv varchar(255) not null default '0',
    status varchar(255) default '0' not null,
    timep varchar(255) not null default 'Não_informado',
    primary key(id)
) default charset = "utf8";

create table impress_orders (
    id int(11) not null unique AUTO_INCREMENT,
    userid varchar(255) not null,
    file varchar(255) not null,
    date varchar(255) not null,
    description varchar(255) not null default 'Produto vendido pela Industria IMPRESS',
    value varchar(255) not null default '0',
    status varchar(255) not null default '0',
    epp varchar(255) not null default '0',
    pg varchar(255) default '0' not null,
    timep varchar(255) not null default 'Não_informado',
    cancelmsg varchar(255),
    primary key(id)
) default charset = "utf8";

