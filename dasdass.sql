SELECT `easyii_banks`.*, `cdt`.*, `ca`.`country_id` AS `ca_id`, `cra`.*, `cr`.`name` AS `region_name`
FROM `easyii_banks`
LEFT JOIN `country_assign` `ca` ON  `ca`.`item_id` = `bank_id` AND `ca`.`class`
  LIKE 'frontend\\\\modules\\\\banks\\\\models\\\\Banks'
LEFT JOIN `country_data` `cdt` ON  cdt.`country_id` = ca.`country_id`
LEFT JOIN `country_region_assign` `cra` ON  cra.`country_id` = ca.`country_id`
LEFT JOIN `country_region` `cr` ON  `cr`.`id` = `cra`.`region_id`
WHERE (`status`=1)
  AND ( `cr`.`is_unep` = '1' )
ORDER BY `cr`.`sort_order`, `cdt`.`country_id` DESC
