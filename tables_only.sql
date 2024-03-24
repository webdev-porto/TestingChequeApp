DROP TABLE IF EXISTS table0_admin;
DROP TABLE IF EXISTS list1_cheque_currancy;
DROP TABLE IF EXISTS table6_saved_cheque_data;
DROP TABLE IF EXISTS table5_cheque_image;
DROP TABLE IF EXISTS table4_bank;

DROP TABLE IF EXISTS table3_user_account;
DROP TABLE IF EXISTS table2_apikey;
DROP TABLE IF EXISTS table1_client;

CREATE TABLE table0_admin(
    admin_id INT NOT NULL AUTO_INCREMENT,
    admin_username VARCHAR(255),
    admin_password TEXT,
    admin_role TEXT,
    PRIMARY KEY(admin_id)
);
/*
4Li302~$
*/
INSERT INTO table0_admin(admin_id, admin_username, admin_password, admin_role)
VALUES
(1, "SUPERcheque_admin","$argon2i$v=19$m=65536,t=4,p=1$U2o1bGRTN25kb3IwZGJQSw$iXKeSXuCThbuCue+ELIUqKEuNR9SQx2WCkMcLbgqxqc","Super Admin");

CREATE TABLE table1_client(
    client_id INT NOT NULL AUTO_INCREMENT,
    client_name VARCHAR(255),
    client_type VARCHAR(255),
    PRIMARY KEY(client_id)
);

INSERT INTO table1_client (client_id,client_name,client_type)
VALUES
(1,"Ministry Of Education","Goverment"),
(2,"Porto Group","Group"),
(3,"Mohammed Ali","Individual");


CREATE TABLE table2_apikey(
    apikey_id INT NOT NULL AUTO_INCREMENT,
    apikey_number VARCHAR(255),
    apikey_generation_date DATE,
    apikey_expiary_date DATE,
    apikey_duration INT,
    apikey_duration_unite VARCHAR(20),
    fk_client_id INT,
    PRIMARY KEY(apikey_id),
    FOREIGN KEY(fk_client_id) REFERENCES table1_client(client_id)
    ON DELETE CASCADE
);
/*
Date Format 1999-08-13
*/
INSERT INTO table2_apikey (apikey_id, 
apikey_number, apikey_generation_date, 
apikey_expiary_date, fk_client_id)
VALUES
(1,"147MINSEDU789455", "2012-07-12", "2024-01-13", 1),
(2,"135ALMAGRO298754", "2023-08-20", "2024-06-12", 2),
(3,"120MOHAALI896411", "2023-08-20", "2024-02-21", 3);
CREATE TABLE table3_user_account( 
    user_account_id INT NOT NULL AUTO_INCREMENT,
    logedin TINYINT(1),
    user_account_username VARCHAR(255),
    user_account_password TEXT,
    user_account_email TEXT,
    fk_client_id INT,
    PRIMARY KEY(user_account_id),
    FOREIGN KEY(fk_client_id) REFERENCES table1_client(client_id)
    ON DELETE CASCADE
);

INSERT INTO table3_user_account(user_account_id, user_account_username, user_account_password,fk_client_id)
VALUES
(1,"user1","$argon2id$v=19$m=65536,t=4,p=1$dEJRcTVVWUFmMy4vdHJ2UA$RFDgqEt67k2lRmct/d0Pio+sEYtrMiDwawzeWs0FS+w", 1),
(2, "user2","$argon2id$v=19$m=65536,t=4,p=1$Q2oySnc2VlE1b0JGRUQyVQ$5tqMvsYcvECO/pY9ShPJsloZFxEebQB1HUIIxvdgBqs", 2),
(3,"user3","$argon2id$v=19$m=65536,t=4,p=1$czB1UmFiWFdtUVhQL0Fwag$2Y+lR8xvyewxda7Ew5xOkQoyXGLCTsnFrOaPpPKEUOA", 3),
(4,"user4","$argon2id$v=19$m=65536,t=4,p=1$czB1UmFiWFdtUVhQL0Fwag$2Y+lR8xvyewxda7Ew5xOkQoyXGLCTsnFrOaPpPKEUOA", 3);

CREATE TABLE table4_bank(
    bank_id INT NOT NULL AUTO_INCREMENT,
    bank_name TEXT,
    fk_user_account_id INT,
    PRIMARY KEY(bank_id)
);

CREATE TABLE table5_cheque_image(
    cheque_image_id INT NOT NULL AUTO_INCREMENT,
    cheque_image_file TEXT,
    cheque_image_file_name TEXT,
    upload_date DATE,
    fk_bank_id INT,
    PRIMARY KEY(cheque_image_id),
    FOREIGN KEY(fk_bank_id) REFERENCES table4_bank(bank_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE list1_cheque_currancy(
    cheque_currency_id INT NOT NULL AUTO_INCREMENT,
    cheque_currency VARCHAR(6),
    cheque_currency_words VARCHAR(100),
    PRIMARY KEY(cheque_currency_id)
);

INSERT INTO list1_cheque_currancy (cheque_currency_id, cheque_currency, cheque_currency_words)
VALUES
(1,"QAR","Qatari Riyals"),
(2,"USD","American Dollar");

CREATE TABLE table6_saved_cheque_data(
    cheque_data_id INT NOT NULL AUTO_INCREMENT,
    cheque_date DATE,
    cheque_pay_name TEXT,
    cheque_amount DECIMAL(20,2),
    cheque_currency VARCHAR(6),
    cheque_words_amount TEXT,
    cheque_crossing VARCHAR(100),
    fk_user_account_id INT,
    PRIMARY KEY(cheque_data_id),
    FOREIGN KEY (fk_user_account_id) REFERENCES table3_user_account(user_account_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

/*
adds font size to table saved data
*/

/*
INSERT INTO table4_bank(bank_id,bank_name,fk_user_account_id)
VALUES 
(1,"Ahli Bank",3);
INSERT INTO table5_cheque_image(cheque_image_id,cheque_image_file,cheque_image_file_name,fk_bank_id)
VALUES(1,"../images/templates/Ahli Bank/template1.jpg","template1",1);


*/