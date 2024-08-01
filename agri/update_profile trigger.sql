CREATE TABLE profile_log (
    id SERIAL PRIMARY KEY,
    user_id INT,
    field_name VARCHAR(255),
    old_value VARCHAR(255),
    new_value VARCHAR(255),
    change_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE OR REPLACE FUNCTION log_profile_change()
RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'UPDATE' THEN
        -- Check if the field you are interested in has changed
        IF NEW.name <> OLD.name THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'name', OLD.name, NEW.name);
        END IF;
        
        IF NEW.email <> OLD.email THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'email', OLD.email, NEW.email);
        END IF;
		 IF NEW.password <> OLD.password THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'password', OLD.password, NEW.password);
        END IF;
        
        
        -- Repeat the above for other fields

        RETURN NEW;
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER profile_change_trigger
AFTER UPDATE ON buyer
FOR EACH ROW
EXECUTE FUNCTION log_profile_change();
CREATE TRIGGER profile_change_trigger
AFTER UPDATE ON farmer
FOR EACH ROW
EXECUTE FUNCTION log_profile_change();

select * from profile_log;

