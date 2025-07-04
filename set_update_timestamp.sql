DROP TRIGGER IF EXISTS set_update_timestamp;

CREATE TRIGGER set_update_timestamp
BEFORE UPDATE ON cv_data
FOR EACH ROW
SET NEW.updated_at = CURRENT_TIMESTAMP;
