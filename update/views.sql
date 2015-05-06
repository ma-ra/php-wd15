--
-- Struktura widoku `rap_warehouse`
--
DROP TABLE IF EXISTS `rap_warehouse`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY INVOKER VIEW `rap_warehouse` AS select 
`warehouse`.`article_number` AS `article_number`,
sum(`warehouse`.`article_count`) AS `article_count_sum`,
sum(`warehouse`.`article_price`) AS `article_price_sum` 

from `warehouse` 
group by `warehouse`.`article_number` 
order by `warehouse`.`article_number`;

--
-- Struktura widoku `rap_textile`
--
DROP TABLE IF EXISTS `rap_textile`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY INVOKER VIEW `rap_textile` AS 
select 
`order`.`textil_pair` AS `textil_pair`,
`supplier1`.`supplier_name` AS `supplier1_name`,
`textile1`.`textile_number` AS `supplier1_number`,
sum(if(`order`.`textil_pair`,(`article`.`article_first_textile_amount` * `order`.`article_amount`),(`article`.`article_all_textile_amount` * `order`.`article_amount`))) AS `textile1_selected`,
`rap_warehouse`.`article_count_sum` AS `textile1_warehouse`,
(`rap_warehouse`.`article_count_sum` - sum(if(`order`.`textil_pair`,(`article`.`article_first_textile_amount` * `order`.`article_amount`),(`article`.`article_all_textile_amount` * `order`.`article_amount`)))) AS `textile1_needed`,
`supplier2`.`supplier_name` AS `supplier2_name`,
`textile2`.`textile_number` AS `supplier2_number`,
sum(if(`order`.`textil_pair`,(`article`.`article_second_textile_amount` * `order`.`article_amount`),NULL)) AS `textile1_sum`,
group_concat(concat(' ',cast(`order`.`article_amount` as char charset utf8mb4),'x ',convert(`order`.`order_number` using utf8mb4)) separator ',') AS `order_number`,
group_concat(concat(' (',`textile1`.`textile_name`,ifnull(concat(' ',`textile2`.`textile_name`,')'),')')) separator ',') AS `order_reference` 

from ((((((`order` 

left join `article` 
    on((`order`.`article_article_id` = `article`.`article_id`))) 
left join `textile` `textile1` 
    on((`order`.`textile1_textile_id` = `textile1`.`textile_id`))) 
left join `supplier` `supplier1` 
    on((`textile1`.`supplier_supplier_id` = `supplier1`.`supplier_id`))) 
left join `textile` `textile2` 
    on((`order`.`textile2_textile_id` = `textile2`.`textile_id`))) 
left join `supplier` `supplier2` 
    on((`textile2`.`supplier_supplier_id` = `supplier2`.`supplier_id`))) 
left join `rap_warehouse` 
    on((`rap_warehouse`.`article_number` = `textile1`.`textile_number`))) 

group by `order`.`textil_pair`,`supplier1`.`supplier_name`,`textile1`.`textile_number`,`supplier2`.`supplier_name`,`textile2`.`textile_number` 
order by `supplier1`.`supplier_name`,`supplier2`.`supplier_name`,`textile1`.`textile_number`,`textile2`.`textile_number`;


--
-- Struktura widoku `rap_textile2`
--
DROP TABLE IF EXISTS `rap_textile2`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY INVOKER VIEW `rap_textile2` AS 
select 
`supplier`.`supplier_name` AS `supplier_name`,
`textile`.`textile_number` AS `textile_number`,
`textile`.`textile_name` AS `textile_name`,
`order1`.`order_id` AS `order1_id`,
`order1`.`order_number` AS `order1_number`,
(`article1`.`article_first_textile_amount` * `order1`.`article_amount`) AS `textile1_selected`,
`order2`.`order_id` AS `order2_id`,`order2`.`order_number` AS `order2_number`,
(`article2`.`article_first_textile_amount` * `order2`.`article_amount`) AS `textile2_selected`,
(ifnull((`article1`.`article_first_textile_amount` * `order1`.`article_amount`),0) + ifnull((`article2`.`article_first_textile_amount` * `order2`.`article_amount`),0)) AS `textiles_selected`,
ifnull(`rap_warehouse`.`article_count_sum`,0) AS `textile1_warehouse`,
0 AS `textiles_ordered`,
(ifnull((`article1`.`article_first_textile_amount` * `order1`.`article_amount`),0) + ifnull((`article2`.`article_first_textile_amount` * `order2`.`article_amount`),0)) - ifnull(`rap_warehouse`.`article_count_sum`,0) - 0 AS `textile_yet_need`

from ((((((`textile` 

left join `supplier` 
    on((`textile`.`supplier_supplier_id` = `supplier`.`supplier_id`))) 
left join `rap_warehouse` 
    on((`textile`.`textile_number` = `rap_warehouse`.`article_number`))) 

left join `order` `order1` 
    on((`textile`.`textile_id` = `order1`.`textile1_textile_id`))) 
left join `article` `article1` 
    on((`order1`.`article_article_id` = `article1`.`article_id`))) 

left join `order` `order2` 
    on((`textile`.`textile_id` = `order2`.`textile2_textile_id`))) 
left join `article` `article2` 
    on((`order2`.`article_article_id` = `article2`.`article_id`)));

--
-- Struktura widoku `rap_textile2-1`
--
DROP TABLE IF EXISTS `rap_textile2-1`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY INVOKER VIEW `rap_textile2-1` AS 
select 
`rap_textile2`.`supplier_name` AS `supplier_name`,
`rap_textile2`.`textile_number` AS `textile_number`,
MAX(`rap_textile2`.`textile_name`) as `textile_name`,
sum(`rap_textile2`.`textiles_selected`) AS `textiles_selected`,
`rap_textile2`.`textile1_warehouse` AS `textile1_warehouse`,
`rap_textile2`.`textiles_ordered` AS `textiles_ordered`,
sum(`rap_textile2`.`textiles_selected`) - `rap_textile2`.`textile1_warehouse` - `rap_textile2`.`textiles_ordered` AS `textile_yet_need` 

from `rap_textile2` 
group by `rap_textile2`.`supplier_name`,`rap_textile2`.`textile_number`,`rap_textile2`.`textile1_warehouse`,`rap_textile2`.`textiles_ordered` 
order by `rap_textile2`.`textile_number`;
