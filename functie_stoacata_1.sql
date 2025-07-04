CREATE FUNCTION get_template_name(u_id INT)
RETURNS VARCHAR(20)
DETERMINISTIC
RETURN (SELECT template_name FROM cv_data WHERE user_id = u_id LIMIT 1);
