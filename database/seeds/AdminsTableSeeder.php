<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commands = [
            'DROP TABLE IF EXISTS `admins`;',
            'CREATE TABLE `admins` (`id` bigint(20) UNSIGNED NOT NULL,`email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,`password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;',
            'ALTER TABLE `admins` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`);',
            'ALTER TABLE `admins` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;',
        ];

        DB::statement($commands[0]);
        DB::statement($commands[1]);
        DB::statement($commands[2]);
        DB::statement($commands[3]);

        $commands = [
            'DROP TABLE IF EXISTS `daily_stats`;',
            'CREATE TABLE `daily_stats` (`id` bigint(20) UNSIGNED NOT NULL, `date` date NOT NULL, `pasiondb` json NOT NULL, `slumi` json NOT NULL, `erosguiadb` json NOT NULL, `mileroticos` json NOT NULL, `mundosexanuncio` json NOT NULL, `nuevoloquo` json NOT NULL, `sexobarato` json NOT NULL, `sustitutas` json NOT NULL, `skokka` json NOT NULL, `comparision` json NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;',
            'ALTER TABLE `daily_stats` ADD PRIMARY KEY (`id`);',
            'ALTER TABLE `daily_stats` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;'
        ];

        DB::statement($commands[0]);
        DB::statement($commands[1]);
        DB::statement($commands[2]);
        DB::statement($commands[3]);
    }
}
