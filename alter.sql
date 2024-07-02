-- Revisi 1

-- ALTER TABLE `penilaian_modul_siswa` ADD `source` TEXT NOT NULL AFTER `updated_at`, ADD `output` TEXT NOT NULL AFTER `source`, ADD `attemp` INT NOT NULL DEFAULT '1' AFTER `output`, ADD `answered_time` INT NOT NULL COMMENT 'in second' AFTER `attemp`;
-- ALTER TABLE `penilaian_modul_siswa` ADD `point` INT NULL DEFAULT NULL AFTER `answered_time`;
-- ALTER TABLE `penilaian_modul_siswa` CHANGE `attemp` `attempt` INT(11) NOT NULL DEFAULT '1';
-- ALTER TABLE `penilaian_modul_siswa` ADD `raw_result` TEXT NOT NULL AFTER `point`;

-- Revisi 2

-- ALTER TABLE `siswa` ADD `deleted_at` TIMESTAMP NULL AFTER `updated_at`;
-- ALTER TABLE `users` ADD `deleted_at` TIMESTAMP NULL AFTER `updated_at`;

-- Revisi 3

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `modul_id` int(11) NOT NULL,
  `min_value` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
ALTER TABLE `nilai` ADD `tipe` VARCHAR(15) NOT NULL AFTER `modul_id`;

ALTER TABLE `nilai` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `nilai` CHANGE `modul_id` `modul_id` BIGINT(20) NOT NULL;