DROP FUNCTION IF EXISTS get_email_domain;

CREATE FUNCTION get_email_domain(u_id INT)
RETURNS VARCHAR(50)
DETERMINISTIC
RETURN (
  SELECT SUBSTRING_INDEX(email, '@', -1)
  FROM cv_data
  WHERE user_id = u_id
  LIMIT 1
);
