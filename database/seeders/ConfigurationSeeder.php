<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            [
                'configuration_id'  => '1',
                'key'                 => 'base_url',
                'value'             => 'https://utama.sttbandung.ac.id/',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],
            [
                'configuration_id'  => '2',
                'key'                 => 'image_path',
                'value'             => 'storage/uploads/images/',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],
            [
                'configuration_id'  => '3',
                'key'                 => 'file_path',
                'value'             => 'storage/uploads/files/',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],

            [
                'configuration_id'  => '4',
                'key'                 => 'news_headline',
                'value'             => '3',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],
            [
                'configuration_id'  => '5',
                'key'                 => 'base_url_utama',
                'value'             => 'fe.sttbandung.ac.id',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],

            [
                'configuration_id'  => '6',
                'key'                 => 'url_profile',
                'value'             => 'img/avatars/profile.jpg',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],

            [
                'configuration_id'  => '7',
                'key'                 => 'access_token',
                'value'             => 'sttbandung',
                'created_by'        => '1',
                'created_at'        => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
