DROP DATABASE IF EXISTS `pianopartner`;
CREATE DATABASE `pianopartner`;
USE `pianopartner`;

DROP TABLE IF EXISTS users ;
DROP TABLE IF EXISTS feedback ;

CREATE TABLE users (
	user_id 	 INT 		  NOT NULL PRIMARY KEY AUTO_INCREMENT,
	status_msg   VARCHAR(256) NOT NULL,
	order_num INT          NOT NULL UNIQUE,
    full_name    VARCHAR(256) NOT NULL,
    mail_from    VARCHAR(256) NOT NULL ,
	piece_name   VARCHAR(256) NOT NULL,
    imslp        VARCHAR(256) NOT NULL,
    music_file   VARCHAR(256) NOT NULL,
    tuning_note  VARCHAR(256) NOT NULL,
    note_type    VARCHAR(256) NOT NULL,
    bpm          INT          NOT NULL,
    custom_bpm   VARCHAR(256) NOT NULL,
    recording    VARCHAR(256) NOT NULL,
    questions    VARCHAR(256) NOT NULL
);

CREATE TABLE feedback (
	feedback_id  INT 		  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    feedback_msg TEXT	 	  NOT NULL
)