<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Create Custom Field Group Table 
$table_name = db_prefix() . 'cfg_manage';
// Check if the table exists
if (!$CI->db->table_exists($table_name)) {
    $query = 'CREATE TABLE `' . $table_name . "` (
        `id` bigint(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `status` INT(11) NOT NULL,
        `created_by` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';';

    $CI->db->query($query);
}

// Create Custom Field Table Gorup ID 
$customfields = db_prefix() . 'customfields';
$new_field = 'cfg_id';
$new_field_type = 'VARCHAR(255) NULL';

// Check if the field exists
if (!$CI->db->field_exists($new_field, $customfields)) {
    // Add the new field to the table
    $query = "ALTER TABLE `$customfields` ADD `$new_field` $new_field_type";
    $CI->db->query($query);
}
