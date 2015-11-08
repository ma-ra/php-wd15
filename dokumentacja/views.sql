--
-- Struktura widoku `rap_shopping`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_shopping`
 AS SELECT 
   fabric_number,
   SUM(IFNULL(article_amount,0) - IFNULL(article_delivered_amount,0)) as article_ordered
FROM `shopping`
JOIN `fabric_collection`
   ON `shopping`.`fabric_collection_fabric_id` = `fabric_collection`.`fabric_id`
WHERE `shopping`.`shopping_status` LIKE 'now%' OR `shopping`.`shopping_status` LIKE 'wydrukowa%' OR `shopping`.`shopping_status` LIKE 'częściow%'
GROUP BY fabric_number
ORDER BY fabric_number;

--
-- Struktura widoku `rap_textiles`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_textiles`
 AS SELECT
`supplier`.`supplier_name` AS `supplier_name`,
`textile`.`textile_number` AS `textile_number`,
`fabric_collection`.`fabric_name` AS `fabric_name`,
`order1`.`order_id` AS `order1_id`,
`order1`.`order_number` AS `order1_number`,
`order1`.`checked` AS `order1_checked`,
`order2`.`order_id` AS `order2_id`,
`order2`.`order_number` AS `order2_number`,
`order2`.`checked` AS `order2_checked`,

-- @textile1_selected := IF(`order1`.`textil_pair`,`article1`.`article_first_textile_amount` * `order1`.`article_amount`,`article1`.`article_all_textile_amount` * `order1`.`article_amount`) AS `textile1_selected`,
IF(`order1`.`textil_pair`,`article1`.`article_first_textile_amount` * `order1`.`article_amount`,`article1`.`article_all_textile_amount` * `order1`.`article_amount`) AS `textile1_selected`,
-- @textile2_selected := `article2`.`article_second_textile_amount` * `order2`.`article_amount` AS `textile2_selected`,
`article2`.`article_second_textile_amount` * `order2`.`article_amount` AS `textile2_selected`,
-- @textiles_selected := IFNULL(@textile1_selected,0) + IFNULL(@textile2_selected,0) AS `textiles_selected`,
IFNULL(IF(`order1`.`textil_pair`,`article1`.`article_first_textile_amount` * `order1`.`article_amount`,`article1`.`article_all_textile_amount` * `order1`.`article_amount`),0)
    + IFNULL(`article2`.`article_second_textile_amount` * `order2`.`article_amount`,0)
    AS `textiles_selected`,
IF(`rap_shopping`.`article_ordered`=0,NULL, `rap_shopping`.`article_ordered`) as textiles_ordered

FROM`textile`

LEFT JOIN `fabric_collection`
    ON `textile`.`textile_number` = `fabric_collection`.`fabric_number`
LEFT JOIN `supplier`
    ON `fabric_collection`.`supplier_supplier_id` = `supplier`.`supplier_id`
    
LEFT JOIN `rap_shopping`
    ON `fabric_collection`.`fabric_number` = `rap_shopping`.`fabric_number`

LEFT JOIN `order` `order1`
    ON `textile`.`textile_id` = `order1`.`textile1_textile_id`
LEFT JOIN `article` `article1`
    ON `order1`.`article_article_id` = `article1`.`article_id`

LEFT JOIN `order` `order2`
    ON `textile`.`textile_id` = `order2`.`textile2_textile_id`
LEFT JOIN `article` `article2`
    ON `order2`.`article_article_id` = `article2`.`article_id`
