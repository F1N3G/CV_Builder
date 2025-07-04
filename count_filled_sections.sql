CREATE FUNCTION count_filled_sections(u_id INT)
RETURNS INT
DETERMINISTIC
RETURN (
  SELECT
    (full_name IS NOT NULL) +
    (phone IS NOT NULL) +
    (email IS NOT NULL) +
    (address IS NOT NULL) +
    (liceu IS NOT NULL) +
    (facultate IS NOT NULL) +
    (experienta IS NOT NULL) +
    (cursuri IS NOT NULL) +
    (voluntariat IS NOT NULL) +
    (tehnice IS NOT NULL) +
    (lingvistice IS NOT NULL) +
    (sociale IS NOT NULL)
  FROM cv_data
  WHERE user_id = u_id
  LIMIT 1
);
