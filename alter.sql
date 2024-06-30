-- Revisi 1

-- ALTER TABLE `penilaian_modul_siswa` ADD `source` TEXT NOT NULL AFTER `updated_at`, ADD `output` TEXT NOT NULL AFTER `source`, ADD `attemp` INT NOT NULL DEFAULT '1' AFTER `output`, ADD `answered_time` INT NOT NULL COMMENT 'in second' AFTER `attemp`;
-- ALTER TABLE `penilaian_modul_siswa` ADD `point` INT NULL DEFAULT NULL AFTER `answered_time`;
-- ALTER TABLE `penilaian_modul_siswa` CHANGE `attemp` `attempt` INT(11) NOT NULL DEFAULT '1';
-- ALTER TABLE `penilaian_modul_siswa` ADD `raw_result` TEXT NOT NULL AFTER `point`;

-- Revisi 2

ALTER TABLE `siswa` ADD `deleted_at` TIMESTAMP NULL AFTER `updated_at`;
ALTER TABLE `users` ADD `deleted_at` TIMESTAMP NULL AFTER `updated_at`;