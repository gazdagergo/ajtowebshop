<?php
switch ($_SERVER["HTTP_HOST"]) {
    case 'ajtowebshop.hu':
        define('ENVIRONMENT', 'production');
        break;
    
    case 'ajtowebshop.local':
        define('ENVIRONMENT', 'development');
        break;
        
    case 'ajtowebshop.effektivart.com':
        define('ENVIRONMENT', 'testing');
        break;
        
    default:
        define('ENVIRONMENT', 'production');
        
}
