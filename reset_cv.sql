DROP PROCEDURE IF EXISTS reset_cv;

CREATE PROCEDURE reset_cv(IN u_id INT)
MODIFIES SQL DATA
UPDATE cv_data SET
  full_name = NULL,
  phone = NULL,
  email = NULL,
  address = NULL,
  liceu = NULL,
  facultate = NULL,
  experienta = NULL,
  cursuri = NULL,
  voluntariat = NULL,
  tehnice = NULL,
  lingvistice = NULL,
  sociale = NULL
WHERE user_id = u_id;
