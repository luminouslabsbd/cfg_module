<?php
defined('BASEPATH') or exit('No direct script access allowed');

// $config['csrf_token_name']   = defined('APP_CSRF_TOKEN_NAME') ? APP_CSRF_TOKEN_NAME : 'csrf_token_name';

$config['csrf_exclude_uris_cfg_module'] = ['forms/wtl/[0-9a-z]+', 'forms/ticket', 'forms/quote/[0-9a-z]+', 'admin/tasks/timer_tracking', 'api\/.+', 
'razorpay/success\/.+','admin/cfg_module/cfg_module/custom_fields_group','admin/cfg_module/cfg_module/delete_group',
'cfg_module/cfg_module/update_fields_group','admin/clients/load_custom_fields','admin/clients/custom_field_order_update'];
