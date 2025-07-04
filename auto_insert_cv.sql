DROP TRIGGER IF EXISTS auto_insert_cv;

CREATE TRIGGER auto_insert_cv
AFTER INSERT ON users
FOR EACH ROW
INSERT INTO cv_data (user_id) VALUES (NEW.id);
