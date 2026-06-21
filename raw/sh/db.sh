#!/usr/bin/env bash

docker exec -i todo-db-1 sh -c 'exec mysql -uroot -proot todo' < sh/todo.sql
