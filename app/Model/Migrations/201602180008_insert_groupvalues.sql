insert into groups(id,name,description,time_created) values(10000,"Message Read Or Unread", "Message readed or unreaded",NOW());

insert into group_values(id,group_id,name,description,time_created) values(10001,10000,"Read","Message readed",NOW());

insert into group_values(id,group_id,name,description,time_created) values(10002,10000,"Unread","Message Unreaded",NOW());




