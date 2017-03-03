
ALTER TABLE `account`
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `accountStatus`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `budgetItem`
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `description`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `cashflow`
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `approved_by`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `cashflowType`
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `name`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `cashflowDetail`
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `monthlyBudgetItem_id`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `monthly_budgetItem`
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `closingBalance`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;
