CREATE TABLE Alarm
(
	boardId			integer PRIMARY KEY,
	alarmActivated		boolean,
	alarmAlert		boolean,
	shutdownAlarm		boolean,
	pswd			integer,
	pswdTryConnect		integer,
	pswdCorrect		boolean
);

INSERT INTO Alarm VALUES (0, false, false, false, 1234, 0000, false);

CREATE OR REPLACE FUNCTION check_pass()
RETURNS TRIGGER AS
$$
BEGIN
    IF(NEW.pswdTryConnect = OLD.pswd)THEN
        UPDATE Alarm SET pswdCorrect = True WHERE boardid = 0;
    ELSE
        UPDATE Alarm SET pswdCorrect = False WHERE boardid = 0;
    END IF;
    RETURN NEW;
END;
$$
LANGUAGE plpgsql;
  
CREATE TRIGGER check_pass
AFTER UPDATE OF pswdTryConnect ON Alarm
FOR EACH ROW EXECUTE PROCEDURE check_pass();