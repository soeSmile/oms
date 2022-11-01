CREATE DATABASE oms;
CREATE USER oms WITH PASSWORD 'qwerty12';
grant usage on schema public to oms;
grant all on database oms to oms;
alter database oms owner to oms;
CREATE EXTENSION IF NOT EXISTS pg_trgm;