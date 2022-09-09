
CREATE TABLE `sys_lookup_value` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(10) NOT NULL,
	`value` VARCHAR(100) NOT NULL,
	`display` VARCHAR(512) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `value_UNIQUE` (`value` ASC)
);

insert into  `sys_lookup_value` (type,value,display) values ('type','apply','apply the HKID card');
insert into  `sys_lookup_value` (type,value,display) values ('type','change','change new HKID card');


insert into  `sys_lookup_value` (type,value,display) values ('time','9:00','9:00');
insert into  `sys_lookup_value` (type,value,display) values ('time','10:00','10:00');
insert into  `sys_lookup_value` (type,value,display) values ('time','14:00','14:00');
insert into  `sys_lookup_value` (type,value,display) values ('time','16:00','16:00');

insert into  `sys_lookup_value` (type,value,display) values ('venues','kt','Kwun Tong');
insert into  `sys_lookup_value` (type,value,display) values ('venues','st','Shatin');
insert into  `sys_lookup_value` (type,value,display) values ('venues','ct','Central');
insert into  `sys_lookup_value` (type,value,display) values ('venues','wc','Wanchai');

insert into  `sys_lookup_value` (type,value,display) values ('cardtype','bc','Birth certificate');
insert into  `sys_lookup_value` (type,value,display) values ('cardtype','pp','Passport');
insert into  `sys_lookup_value` (type,value,display) values ('cardtype','hkid','HKID');



CREATE TABLE `sys_user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`pwd` VARCHAR(512) NOT NULL,
	`ename` VARCHAR(100) NOT NULL,
	`cname` VARCHAR(100) NOT NULL,
	`dob` DATE NOT NULL,
	`gender` VARCHAR(5) NOT NULL,
	`email` VARCHAR(100) NOT NULL,
	`phone` INT(8),
	`address` VARCHAR(512),
	`salt` VARCHAR(512),
	`role` VARCHAR(100) NOT NULL DEFAULT 'user',
	`retry` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email_UNIQUE` (`email` ASC)
);

alter table sys_user add column `retry` INT NOT NULL DEFAULT 0;
alter table sys_user add column `retry_datetime` VARCHAR(10)  ;


CREATE TABLE `sys_session` (
	`id` VARCHAR(128) NOT NULL,
	`user_id` INT NOT NULL,
	`start` INT NOT NULL,
	`expire` INT NOT NULL,
	`client_ip` VARCHAR(36) NOT NULL,
	PRIMARY KEY (`id`),
	 FOREIGN KEY (user_id) REFERENCES sys_user(id)
);



CREATE TABLE `hkid_appointment` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(10) NOT NULL,
	`card_type` VARCHAR(10) NOT NULL,
	`card_no` VARCHAR(512) NOT NULL,
	`user_id` int NOT NULL,
	`venue` VARCHAR(10) NOT NULL,
	`date` DATE NOT NULL,
	`time` VARCHAR(10) NOT NULL,	
	`query_code` VARCHAR(4) NOT NULL,
	`salt` VARCHAR(512) NOT NULL,
    `status` VARCHAR(10) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (user_id) REFERENCES sys_user(id)
  
);


