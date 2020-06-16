ALTER TABLE `ls_superlinks` ADD COLUMN `nofollow` TINYINT(1) DEFAULT 0 NULL;
UPDATE ls_system SET `value`=2.55 where `name`='version';