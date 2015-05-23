UPDATE `ext_graadmeter` SET
	`lijst` = 'top41'
	WHERE `lijst` = 'top30';
UPDATE `ext_graadmeter_beheer` SET
	`lijst` = 'top41'
	WHERE `lijst` = 'top30';
ALTER TABLE `ext_graadmeter_stemmen`
	CHANGE COLUMN `ref_top30_voor` `ref_top41_voor` VARCHAR(25),
	CHANGE COLUMN `ref_top30_tegen` `ref_top41_tegen` VARCHAR(25);