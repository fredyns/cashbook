
ALTER TABLE `profile`
ADD CONSTRAINT `fk_profile_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_profile_picture`
  FOREIGN KEY (`picture_id`)
  REFERENCES `uploaded_file` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `social_account`
ADD CONSTRAINT `fk_social_account_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `token`
ADD CONSTRAINT `fk_token_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `cashflow`
ADD CONSTRAINT `fk_cashflow_1`
  FOREIGN KEY (`cashflowType_id`)
  REFERENCES `cashflowType` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cashflow_2`
  FOREIGN KEY (`account_id`)
  REFERENCES `account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `cashflowDetail`
ADD CONSTRAINT `fk_cashflowDetail_1`
  FOREIGN KEY (`cashflow_id`)
  REFERENCES `cashflow` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cashflowDetail_2`
  FOREIGN KEY (`budgetItem_id`)
  REFERENCES `budgetItem` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cashflowDetail_3`
  FOREIGN KEY (`monthlyBudgetItem_id`)
  REFERENCES `monthly_budgetItem` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `monthly_budgetItem`
ADD CONSTRAINT `fk_monthly_budgeting_1`
  FOREIGN KEY (`budgetItem_id`)
  REFERENCES `budgetItem` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

