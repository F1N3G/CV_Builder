DROP TRIGGER IF EXISTS delete_cv_on_user_delete;

CREATE TRIGGER delete_cv_on_user_delete
AFTER DELETE ON users
FOR EACH ROW
DELETE FROM cv_data WHERE user_id = OLD.id;
