-- DROP TABLE IF EXISTS `department`;
-- CREATE TABLE `department` (
--     `d_id` Int(11) NOT NULL AUTO_INCREMENT,
--     `d_name` Varchar(255) NOT NULL,
--     `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
--     `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
--     `active_status` Int(11) DEFAULT 1,
--     PRIMARY KEY (`d_id`)
-- )
-- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- DROP TABLE IF EXISTS `users`;
-- CREATE TABLE `users`(
--   `id` Int(11) NOT NULL AUTO_INCREMENT,
--   `email` VARBINARY(100) NOT NULL,
--   `password` Varchar(255) NOT NULL,
--   `role_id` Varchar(255) DEFAULT 3,
--   `manager_id` Int(11) NOT NULL,
--   `dept_id` Int(11) NOT NULL,
--   `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
--   `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
--   `active_status` INT(11) DEFAULT 1,
--   PRIMARY KEY (`id`),
--   CONSTRAINT fkey_dept FOREIGN KEY (`dept_id`)
--   REFERENCES department(`d_id`)
-- )
-- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- CREATE TABLE `user_profile`(
--   `id` Int(11) NOT NULL AUTO_INCREMENT,
--   `user_id` INT(11) NOT NULL,
--   `username` Varchar(255) DEFAULT NULL,
--   `phonenumber` Varchar(255) DEFAULT NULL,
--   `dob` DATE DEFAULT NULL,
--   `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
--   `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
--   `active_status` Int(11) DEFAULT 1,
--   PRIMARY KEY (`id`),
--   CONSTRAINT fkey_user FOREIGN KEY (`user_id`)
--   REFERENCES users(`id`)
-- )
-- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- CREATE TABLE `user_session` (
--     `id` INT(11) NOT NULL AUTO_INCREMENT,
--     `user_id` Int(11) NOT NULL,
--     `token` Varchar(255) NOT NULL,
--     `login_time`  datetime DEFAULT CURRENT_TIMESTAMP,
--     `logout_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
--     PRIMARY KEY (`id`),
--     CONSTRAINT f_user FOREIGN KEY (`user_id`)
--   REFERENCES users(`id`)
-- )
-- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



-- DROP TABLE IF EXISTS `certificates`;
-- CREATE TABLE `certificates`(
--   `cert_id` Int(11) NOT NULL AUTO_INCREMENT,
--   `cert_name` Varchar(255) NOT NULL,
--   `levels` Varchar(255) NOT NULL,
--   `description` Varchar(255) NOT NULL,
--   `image` Varchar(255) DEFAULT NULL,
--   `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
--   `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
--   `active_status` Int(11) DEFAULT 1,
--   `references` Varchar(255) NOT NULL,
--   `authorization_status` Varchar(255) DEFAULT 1,
--   PRIMARY KEY (`cert_id`)
-- )
-- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- CREATE TABLE `employee_certificate` (
--    `id` Int(11) NOT NULL AUTO_INCREMENT,
--    `e_id` Int(11) NOT NULL,
--    `c_id` Int(11) NOT NULL,
--    `c_status` Int(11) DEFAULT 0,
--    `attachment` Varchar(255) DEFAULT NULL,
--    `c_start` datetime DEFAULT NULL,
--    `c_end` datetime DEFAULT NULL,
--    `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
--    `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
--    `active_status` Int(11) DEFAULT 1,
--    PRIMARY KEY (`id`),
--     CONSTRAINT fkey_employee FOREIGN KEY (`e_id`)
--   REFERENCES users(`id`),
--   CONSTRAINT fkey_certificate FOREIGN KEY (`c_id`)
--   REFERENCES certificates(`cert_id`)
-- )
-- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- -- CREATE TABLE `tag` (
-- --    `t_id`  Int(11) NOT NULL,
-- --    `t_name`  Varchar(255) NOT NULL,
-- --    `no_of_courses` Int(11),
-- --    `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
-- --    `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
-- --    `active_status` Int(11) NOT NULL,
-- --    PRIMARY KEY (`t_id`)
-- -- )
-- -- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- -- CREATE TABLE `tagged_certificates` (
-- --     `c_id`  Int(11) NOT NULL,
-- --     `t_id` Int(11) NOT NULL,
-- --     `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
-- --     `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
-- --     `active_status` Int(11) NOT NULL,
-- --     CONSTRAINT fkey_certificate FOREIGN KEY (`c_id`)
-- --   REFERENCES certificates(`cert_id`)
-- --   CONSTRAINT fkey_Tag FOREIGN KEY (`t_id`)
-- --   REFERENCES tag(`t_id`)
-- -- )
-- -- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;




-- -- CREATE TABLE `role` (
-- --     `role_id`,
-- --     `role_name`,
-- --     `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
-- --     `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
-- --     `active_status` Int(11) NOT NULL,
-- -- )
-- -- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- -- CREATE TABLE `sharedpost` (
-- --     `e_id`,
-- --     `c_id`,
-- --     `post_url` LONGBLOB DEFAULT,
-- --     `created_time` datetime DEFAULT CURRENT_TIMESTAMP,
-- --     `modify_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
-- --     `active_status` Int(11) NOT NULL,
-- -- )
-- -- ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

