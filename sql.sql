
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
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email_UNIQUE` (`email` ASC)
);


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
	`hkid` VARCHAR(512),
	`ename` TEXT(100),
	`cname` VARCHAR(100),
	`dob` DATE,
	`gender` VARCHAR(5),
	`email` VARCHAR(100),
	`phone` INT,
	`address` VARCHAR(200),
	`salt` VARCHAR(255),
    `status` VARCHAR(10),
	PRIMARY KEY (`hkid`),
    UNIQUE(`email`)
);


