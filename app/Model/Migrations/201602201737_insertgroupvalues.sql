insert into groups(id,name,description,time_created) values(20000,"Message Type", "Message inbox or outbox",NOW());

insert into group_values(id,group_id,name,description,time_created) values(20001,20000,"Inbox","Message Inbox",NOW());

insert into group_values(id,group_id,name,description,time_created) values(20002,20000,"Outbox","Message Outbox",NOW());

insert into group_values(id,group_id,name,description,time_created) values(20003,20000,"trash","Message deeleted",NOW());

alter table message_receivers add column type int(11) after status;
