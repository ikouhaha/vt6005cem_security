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


