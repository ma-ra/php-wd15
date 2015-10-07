SELECT COUNT(model_name) as 'szt.', model_name as 'model', model_type as 'typ', article_all_textile_amount as 'ilość mat.', article_first_textile_amount as 'deseń 1 - ilość mat.', article_second_textile_amount as 'deseń 2 - ilość mat.', textile1.textile_price_group as 'deseń 1 - grupa', textile2.textile_price_group as 'deseń 2 - grupa', order_total_price as 'cena za szt.',  SUM(order_total_price) as 'suma cen'
FROM `order`

LEFT JOIN article
ON order.article_article_id = article.article_id

LEFT JOIN textile textile1
ON order.textile1_textile_id = textile1.textile_id

LEFT JOIN textile textile2
ON order.textile2_textile_id = textile2.textile_id

WHERE checked=1

GROUP BY model_name, model_type, article_all_textile_amount, article_first_textile_amount, article_second_textile_amount, textile1.textile_price_group, textile2.textile_price_group, order_total_price
