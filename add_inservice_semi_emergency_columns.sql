-- Run once on the database that hosts tbl_inservice_logs.
-- Adds dates for the semi-annual emergency training block (separate from main topic list).

ALTER TABLE `tbl_inservice_logs`
  ADD COLUMN `semi_emergency_1` VARCHAR(50) DEFAULT NULL AFTER `duration_12`,
  ADD COLUMN `semi_duration_1` VARCHAR(50) DEFAULT '1 hour' AFTER `semi_emergency_1`,
  ADD COLUMN `semi_emergency_2` VARCHAR(50) DEFAULT NULL AFTER `semi_duration_1`,
  ADD COLUMN `semi_duration_2` VARCHAR(50) DEFAULT '1 hour' AFTER `semi_emergency_2`;
