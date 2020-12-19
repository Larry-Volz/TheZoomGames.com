<?php
namespace database\migrations;

Class config
{
    /**
     * create table.
     */
    public function create()
    {
        return "CREATE TABLE `config` (
          `key` varchar(255) NOT NULL COMMENT 'config key',
          `value` text DEFAULT NULL COMMENT 'config value',
          `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'data type 0:notjson;1:json'
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4";
    }
}