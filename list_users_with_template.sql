DROP PROCEDURE IF EXISTS list_users_with_template;

CREATE PROCEDURE list_users_with_template(IN t_name VARCHAR(20))
SELECT u.id, u.username, c.template_name
FROM users u
JOIN cv_data c ON u.id = c.user_id
WHERE c.template_name = t_name;
