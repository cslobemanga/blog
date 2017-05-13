-- Table: pages
DROP TABLE IF EXISTS pages;
CREATE TABLE pages(
    
    PageId tinyint(3) unsigned not null auto_increment,
    Alias varchar(100) not null,
    Title varchar(100) not null,
    Content text default null,
    IsPublished tinyint(1) unsigned default 0,
    primary key (PageId)

)Engine=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Adding data to table pages
INSERT INTO pages (Alias,Title,Content,IsPublished)
    values
    ('about', 'About Us', 'Test Content', 1),
    ('impressum', 'Impressum', 'AGB', 1),
    ('test', 'Test page', 'Another Test Content', 1);
    
-- Table: users
DROP TABLE IF EXISTS users;
CREATE TABLE users(
    
    UserId smallint(5) unsigned not null auto_increment,
    Login varchar(32) not null,
    Password varchar(64) not null,
    Email varchar(100) not null,
    Role varchar(32) not null default 'admin',
    IsActive tinyint(1) unsigned default 1,
    primary key (UserId),
    unique (Login)

)Engine=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;  

-- Table: messages
DROP TABLE IF EXISTS messages;
CREATE TABLE messages(
    
    MessageId smallint(5) unsigned not null auto_increment,
    Name varchar(100) not null,
    Email varchar(100) not null,
    Message text default null,
    primary key (MessageId)
--     constraint fk_login foreign key (Name) references users (Login)

)Engine=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;    