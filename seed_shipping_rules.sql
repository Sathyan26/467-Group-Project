USE autoparts_online;
INSERT INTO shipping_rules (min_weight, max_weight, charge) VALUES
(0.00, 1.00, 5.99),
(1.01, 5.00, 8.99),
(5.01, 10.00, 12.99),
(10.01, 20.00, 18.99),
(20.01, 9999.99, 29.99);
