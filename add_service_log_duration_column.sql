-- Fix invalid default on date_updated, then add Duration column (run in order)

-- Step 1: Fix date_updated invalid default (fixes #1067 error)
ALTER TABLE `tbl_inservice_logs` MODIFY COLUMN `date_updated` DATETIME NULL DEFAULT NULL;

-- Step 2: Add duration column (skip if it already exists)
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration` VARCHAR(100) DEFAULT NULL AFTER `pdf_path`;

-- Step 3: Add per-topic duration columns (default 1 hour)
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_1` VARCHAR(50) DEFAULT '1 hour' AFTER `duration`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_2` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_1`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_3` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_2`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_4` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_3`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_5` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_4`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_6` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_5`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_7` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_6`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_8` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_7`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_9` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_8`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_10` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_9`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_11` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_10`;
ALTER TABLE `tbl_inservice_logs` ADD COLUMN `duration_12` VARCHAR(50) DEFAULT '1 hour' AFTER `duration_11`;
