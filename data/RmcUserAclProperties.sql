use wespresslocal;

-- USER
CREATE TABLE rcm_user_user (
  id VARCHAR(255) NOT NULL UNIQUE,
	username VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	-- email    VARCHAR(255) DEFAULT NULL UNIQUE,
	-- state VARCHAR(255) DEFAULT 'disabled', -- 'enabled', 'disabled', etc... 
	PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE rcm_user_user_role (
	id INT AUTO_INCREMENT NOT NULL, 
	userId VARCHAR(255) NOT NULL,
	roleId INT NOT NULL,
	PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- ACL
CREATE TABLE rcm_user_acl_role (
	id INT AUTO_INCREMENT NOT NULL, 
	parentId INT DEFAULT 0,
	roleIdentity VARCHAR(255) NOT NULL,
	description VARCHAR(255) DEFAULT NULL, 
	PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

INSERT INTO `rcm_user_acl_role`
(`id`,
`parentId`,
`roleIdentity`,
`description`)
VALUES
('1', '0', 'guest', NULL),
('2', '1', 'user', NULL),
('3', '2', 'manager', NULL),
('4', '3', 'admin', NULL);

CREATE TABLE rcm_user_acl_rule (
	id INT AUTO_INCREMENT NOT NULL,
	roleId INT NOT NULL,
	rule VARCHAR(32) NOT NULL, -- allow or deny or ignore
	resource VARCHAR(255) NOT NULL, -- some resource value
	privilege VARCHAR(255) NOT NULL, -- some privilege value (created, read, update, delete, execute)
	-- description VARCHAR(255) DEFAULT NULL, 
	PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

INSERT INTO `rcm_user_acl_rule`
(`id`,
`roleId`,
`rule`,
`resource`,
`privilege`)
VALUES
(1, 4, 'allow', 'core', '');

/*
CREATE TABLE rcm_user_user_metadata (
	id INT AUTO_INCREMENT NOT NULL,

	userCreateDate DATETIME DEFAULT NULL,
	userCreatedById BIGINT DEFAULT NULL,
	userModifiedDate DATETIME DEFAULT NULL,
	userModifiedById BIGINT DEFAULT NULL,

	PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
*/
