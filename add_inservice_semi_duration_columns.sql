-- Run once if you already added semi_emergency_1 / semi_emergency_2 without durations.

ALTER TABLE `tbl_inservice_logs`
  ADD COLUMN `semi_duration_1` VARCHAR(50) DEFAULT '1 hour' AFTER `semi_emergency_1`,
  ADD COLUMN `semi_duration_2` VARCHAR(50) DEFAULT '1 hour' AFTER `semi_emergency_2`;
