<?php
$host = "0.0.0.0";
$port = "5433";
$database = "postgres";
$user = "localuser";
$password = "cs4640LocalUser!";

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if (!$dbHandle) {
    die("Unable to connect to PostgreSQL database server.\n");
} else {
    echo "Successfully connected to the database server.\n";
}

// Drop tables and sequences
$res = pg_query($dbHandle, "drop table if exists chat CASCADE;");
$res = pg_query($dbHandle, "drop table if exists items CASCADE;");
$res = pg_query($dbHandle, "drop table if exists users CASCADE;");
$res = pg_query($dbHandle, "drop sequence if exists chat_seq;");
$res = pg_query($dbHandle, "drop sequence if exists items_seq;");
$res = pg_query($dbHandle, "drop sequence if exists users_seq;");

// Create sequences
$res = pg_query($dbHandle, "create sequence users_seq;");
$res = pg_query($dbHandle, "create sequence items_seq;");
$res = pg_query($dbHandle, "create sequence chat_seq;");

// Create tables
$res = pg_query($dbHandle, "create table users (
        user_id  int primary key default nextval('users_seq'),
        username    text,
        email      text,
        password   text,
        last_login timestamp
);");

$res = pg_query($dbHandle, "create table items (
    item_id  int primary key default nextval('items_seq'),
    user_id    int,
    item_name    text,
    description      text,
    status boolean,
    date_added timestamp,
    location_found text,
    image text,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);");

$res = pg_query($dbHandle, "create table chat(
    chat_id  int primary key default nextval('chat_seq'),
    sender_id  int,
    receiver_id  int,
    message text,
    FOREIGN KEY (sender_id) REFERENCES users(user_id),
    FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);");
