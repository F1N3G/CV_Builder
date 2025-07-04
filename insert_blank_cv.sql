DROP PROCEDURE IF EXISTS insert_blank_cv;

CREATE PROCEDURE insert_blank_cv(IN u_id INT)
INSERT INTO cv_data (user_id) VALUES (u_id);
