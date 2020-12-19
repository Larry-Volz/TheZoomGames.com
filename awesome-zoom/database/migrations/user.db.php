<?php
namespace database\migrations;

Class user
{
    /**
     * create table.
     */
    public function create()
    {
        return "CREATE TABLE `user` (
          `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'row id',
          `name` varchar(100) NOT NULL COMMENT 'player name',
          `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'status',
          `session_id` varchar(100) NOT NULL COMMENT 'session id',
          `create_time` int(10) NOT NULL COMMENT 'create time',
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4";
    }
}