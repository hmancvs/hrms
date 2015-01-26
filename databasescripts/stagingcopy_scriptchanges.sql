-- Reset all email addresses to development addresses and the password to the word password
-- UPDATE useraccount set email =  INSERT(email,LOCATE('@', email)+1, 22,'erpmastersltd.com'), password = sha1('password');
UPDATE useraccount set email =  concat(username,'@erpmastersltd.com'), password = sha1('password') WHERE email like '%devmail%';
UPDATE useraccount set email =  'admin@erpmastersltd.com', username = 'admin' where id = 1;
UPDATE useraccount set email =  'test1@erpmastersltd.com', username = 'test1' where id = 15;

UPDATE appconfig set optionvalue = 'hrms@erpmastersltd.com' where optionname = 'emailmessagesender';
UPDATE appconfig set optionvalue = 'admin@erpmastersltd.com' where optionname = 'supportemailaddress';
UPDATE appconfig set optionvalue = 'hrms@erpmastersltd.com' where optionname = 'defaultadminemail';
UPDATE appconfig set optionvalue = 'hrms@erpmastersltd.com' where optionname = 'errorlogemail';