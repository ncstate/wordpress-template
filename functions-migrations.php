<?php

 /**
 *
 * Checks the theme's /migrations directory for previously unexecuted
 * migration files.
 *
 * See the markdown file in /migrations for more information.
 *
 */
 function ncsu_migrations($version) {

    // Get all migration files from /migrations
    $migrations_dir = opendir(dirname(__FILE__) . '/migrations');
    // Loop over migration files
    while (false !== ( $migration_file = readdir($migrations_dir) )) {
        // If the file is .php, store the migration version number
        if ( false !== strpos($migration_file, '.php') ) {
            $migrations[] = str_replace('.php', '', $migration_file);
        }
    }

    // Get completed migrations
    if ( get_site_option( 'ncstate_theme_migrations' ) ) {
        $completed_migrations = get_site_option( 'ncstate_theme_migrations' );
    } else {
        $completed_migrations = array();
    }

     foreach ($migrations as $migration) {
        if ( ! in_array($migration, $completed_migrations) && version_compare($migration, $version, '<=')) {
            include 'migrations/' . $migration . '.php';
            $completed_migrations[] = $migration;
        }
     }

     // Update the complete migrations records
     update_site_option( 'ncstate_theme_migrations', $completed_migrations );
 }
 
 // Update theme version option and run migrations unless version number hasn't changed
 function ncsu_update_theme() {
    $theme = wp_get_theme();
    $current_version = $theme->get('Version');

    if ( get_site_option( 'ncstate_theme_version' ) !== $current_version ) {
         update_site_option( 'ncstate_theme_version', $current_version );
         ncsu_migrations($current_version);
     }
 }
 add_action( 'after_setup_theme', 'ncsu_update_theme' );