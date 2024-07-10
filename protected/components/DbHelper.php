<?php 
// protected/components/DbHelper.php
class DbHelper {
    public static function getTableAlias($tableName) {
        $aliases = array(
            'users' => 'u',
            'blog_posts' => 'bp',
            // Add more aliases as needed
        );
        return isset($aliases[$tableName]) ? $aliases[$tableName] : null;
    }
}
