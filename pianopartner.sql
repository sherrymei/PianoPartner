DROP DATABASE IF EXISTS `pianopartner`;
CREATE DATABASE `pianopartner`;
USE `pianopartner`;

DROP TABLE IF EXISTS users ;

CREATE TABLE users (
	id int AUTO_INCREMENT PRIMARY KEY not null,
    tracking_num int not null UNIQUE,
    full_name varchar(256) not null,
    mail_from varchar(256) not null,
    piece_name varchar(256) not null,
    imslp varchar(256) not null,
    music_file varchar(256) not null,
    tuning_note varchar(256) not null,
    bpm int not null,
    custom_bpm varchar(256) not null,
    note_type varchar(256) not null,
    recording varchar(256) not null,
    questions varchar(256) not null
);

INSERT INTO users (tracking_num, full_name, mail_from, piece_name, imslp, music_file, tuning_note, bpm, custom_bpm, note_type, recording, questions)
VALUES (11001100, 'Sherry', 'sherry@pianopartner.com', 'Cinderella', 'https://www.google.com', '', 'A', 70, '', 'half note', 'youtube', 'no questions');


INSERT INTO users (tracking_num, full_name, mail_from, piece_name, imslp, music_file, tuning_note, bpm, custom_bpm, note_type, recording, questions)
      SELECT 1000, '$full_name', '$mail_from', '$piece_name', '$imslp', '$music_file', '$tuning_note', 40, '$custom_bpm', '$note_type', '$recording', '$questions' 
      WHERE NOT EXISTS (SELECT * FROM users
        WHERE tracking_num= 1000) LIMIT 1;