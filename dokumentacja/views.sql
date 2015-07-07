--
-- Struktura widoku `rap_warehouse`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_warehouse`
 AS SELECT
`warehouse`.`article_number` AS `article_number`,
SUM(`warehouse`.`article_count`) AS `article_count_sum`,
SUM(`warehouse`.`article_price`) AS `article_price_sum`

FROM `warehouse`
GROUP BY `warehouse`.`article_number`
ORDER BY `warehouse`.`article_number`;

--
-- Struktura widoku `rap_shopping`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_shopping`
 AS SELECT
`textile`.`textile_number`,
SUM(`article_amount`) as article_amount_sum,
SUM(`article_calculated_amount`) as article_calculated_amount_sum

FROM `shopping`
LEFT JOIN `textile`
   ON `shopping`.`textile_textile_id` = `textile`.`textile_id`
LEFT JOIN `warehouse`
   ON `shopping`.`shopping_id` = `warehouse`.`shopping_shopping_id`

WHERE `warehouse`.`article_count` IS NULL
GROUP BY `textile`.`textile_number`
ORDER BY `textile`.`textile_number` ASC;

--
-- Struktura widoku `rap_textile2`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_textile2`
 AS SELECT
`supplier`.`supplier_name` AS `supplier_name`,
`textile`.`textile_number` AS `textile_number`,
`textile`.`textile_name` AS `textile_name`,
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
-- @textile1_warehouse := ifnull(`rap_warehouse`.`article_count_sum`,0) AS `textile1_warehouse`,
ifnull(`rap_warehouse`.`article_count_sum`,0) AS `textile1_warehouse`,
-- @textiles_ordered := ifnull(`rap_shopping`.`article_amount_sum`,0) AS `textiles_ordered`,
ifnull(`rap_shopping`.`article_amount_sum`,0) AS `textiles_ordered`,
-- @textile_yet_need := @textiles_selected -  @textile1_warehouse - @textiles_ordered AS `textile_yet_need`
IFNULL(IF(`order1`.`textil_pair`,`article1`.`article_first_textile_amount` * `order1`.`article_amount`,`article1`.`article_all_textile_amount` * `order1`.`article_amount`),0)
    + IFNULL(`article2`.`article_second_textile_amount` * `order2`.`article_amount`,0)
    - ifnull(`rap_warehouse`.`article_count_sum`,0)
    - ifnull(`rap_shopping`.`article_amount_sum`,0)
    AS `textile_yet_need`

FROM`textile`

LEFT JOIN `supplier`
    ON `textile`.`supplier_supplier_id` = `supplier`.`supplier_id`
LEFT JOIN `rap_warehouse`
    ON `textile`.`textile_number` = `rap_warehouse`.`article_number`
LEFT JOIN `rap_shopping`
    ON `textile`.`textile_number` = `rap_shopping`.`textile_number`

LEFT JOIN `order` `order1`
    ON `textile`.`textile_id` = `order1`.`textile1_textile_id`
LEFT JOIN `article` `article1`
    ON `order1`.`article_article_id` = `article1`.`article_id`

LEFT JOIN `order` `order2`
    ON `textile`.`textile_id` = `order2`.`textile2_textile_id`
LEFT JOIN `article` `article2`
    ON `order2`.`article_article_id` = `article2`.`article_id`;

--
-- Struktura widoku `rap_textile2-1`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_textile2-1`
 AS SELECT
`rap_textile2`.`supplier_name` AS `supplier_name`,
`rap_textile2`.`textile_number` AS `textile_number`,
MAX(`rap_textile2`.`textile_name`) as `textile_name`,
SUM(`rap_textile2`.`textiles_selected`) AS `textiles_selected`,
`rap_textile2`.`textile1_warehouse` AS `textile1_warehouse`,
`rap_textile2`.`textiles_ordered` AS `textiles_ordered`,
IF((SUM(textiles_selected) - textile1_warehouse -  textiles_ordered)>0, SUM(textiles_selected) - textile1_warehouse -  textiles_ordered, NULL) as textile_yet_need,
IF((SUM(textiles_selected) - textile1_warehouse -  textiles_ordered)<0, (SUM(textiles_selected) - textile1_warehouse -  textiles_ordered) * -1, NULL) as textile_yet_remained,
CONCAT(IFNULL(GROUP_CONCAT(order1_id),""),IF(GROUP_CONCAT(order1_id),",",""),IFNULL(GROUP_CONCAT(order2_id),"")) as order_ids,
CONCAT(IFNULL(GROUP_CONCAT(order1_id),""),IF(GROUP_CONCAT(order1_id),",","")) as order1_ids,
CONCAT(IFNULL(GROUP_CONCAT(order2_id),""),IF(GROUP_CONCAT(order2_id),",","")) as order2_ids

FROM `rap_textile2`
WHERE `order1_checked` = 1 OR `order2_checked` = 1
GROUP BY `rap_textile2`.`supplier_name`,`rap_textile2`.`textile_number`,`rap_textile2`.`textile1_warehouse`,`rap_textile2`.`textiles_ordered`
ORDER BY `rap_textile2`.`textile_number`;

--
-- Struktura widoku `rap_textile`
--
CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 SQL SECURITY INVOKER
 VIEW `rap_textile`
 AS SELECT
`order`.`textil_pair` AS `textil_pair`,
`supplier1`.`supplier_name` AS `supplier1_name`,
`textile1`.`textile_number` AS `supplier1_number`,
`supplier2`.`supplier_name` AS `supplier2_name`,
`textile2`.`textile_number` AS `supplier2_number`,

-- textile1_selected
SUM(IF(`order`.`textil_pair`,(`article`.`article_first_textile_amount` * `order`.`article_amount`),(`article`.`article_all_textile_amount` * `order`.`article_amount`))) AS `textile1_selected`,
-- textile2_selected
SUM(IF(`order`.`textil_pair`,(`article`.`article_second_textile_amount` * `order`.`article_amount`),NULL)) AS `textile2_selected`,
-- to check
group_concat(concat(' ',cast(`order`.`article_amount` as char),'x ',`order`.`order_number`) separator ',') AS `order_number`,
group_concat(concat(' (',`textile1`.`textile_name`,ifnull(concat(' ',`textile2`.`textile_name`,')'),')')) separator ',') AS `order_reference`

FROM `order`
LEFT JOIN `article`
    ON `order`.`article_article_id` = `article`.`article_id`
LEFT JOIN `textile` `textile1`
    ON `order`.`textile1_textile_id` = `textile1`.`textile_id`
LEFT JOIN `supplier` `supplier1`
    ON `textile1`.`supplier_supplier_id` = `supplier1`.`supplier_id`
LEFT JOIN `textile` `textile2`
    ON `order`.`textile2_textile_id` = `textile2`.`textile_id`
LEFT JOIN `supplier` `supplier2`
    ON `textile2`.`supplier_supplier_id` = `supplier2`.`supplier_id`
LEFT JOIN `rap_warehouse`
    ON `rap_warehouse`.`article_number` = `textile1`.`textile_number`
    
WHERE `order`.`checked` =1
GROUP BY `order`.`textil_pair`,`supplier1`.`supplier_name`,`textile1`.`textile_number`,`supplier2`.`supplier_name`,`textile2`.`textile_number`
ORDER BY `supplier1`.`supplier_name`,`supplier2`.`supplier_name`,`textile1`.`textile_number`,`textile2`.`textile_number`;


