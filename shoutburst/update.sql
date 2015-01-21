DELIMITER $$

CREATE TRIGGER nps_update 
BEFORE UPDATE ON surveys
FOR EACH ROW BEGIN
IF NEW.nps_question = 1 THEN
	SET NEW.nps_score = NEW.q1;
ELSEIF NEW.nps_question = 2 THEN
	SET NEW.nps_score = NEW.q2;
ELSEIF NEW.nps_question = 3 THEN
	SET NEW.nps_score = NEW.q3;
ELSEIF NEW.nps_question = 4 THEN
	SET NEW.nps_score = NEW.q4;
ELSEIF NEW.nps_question = 5 THEN
	SET NEW.nps_score = NEW.q5;
END IF;
END;$$

delimiter ;
