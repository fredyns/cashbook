
ALTER TABLE `budgetItem`
ADD COLUMN `parent_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `description`,
ADD COLUMN `status` ENUM('active', 'suspended') NULL DEFAULT 'active' AFTER `parent_id`,
ADD INDEX `index2` (`parent_id` ASC);

ALTER TABLE `budgetItem`
ADD CONSTRAINT `fk_budgetItem_1`
  FOREIGN KEY (`parent_id`)
  REFERENCES `budgetItem` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
