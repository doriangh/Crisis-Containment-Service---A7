create table PERSON
(
	ID NUMBER not null
		primary key,
	NAME VARCHAR2(64) not null
	SURNAME VARCHAR2(64) not null
	ADDRESS VARCHAR2(64) not null
	ORAS VARCHAR2(64) not null
	SESIZARI VARCHAR2(64) not null
	DESCRIERE VARCHAR2(1000) not null
)
/