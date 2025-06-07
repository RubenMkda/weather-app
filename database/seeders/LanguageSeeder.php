<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            ['code' => 'ar', 'name' => 'Arabic', 'is_default' => false],
            ['code' => 'bn', 'name' => 'Bengali', 'is_default' => false],
            ['code' => 'bg', 'name' => 'Bulgarian', 'is_default' => false],
            ['code' => 'zh', 'name' => 'Chinese Simplified', 'is_default' => false],
            ['code' => 'zh_tw', 'name' => 'Chinese Traditional', 'is_default' => false],
            ['code' => 'cs', 'name' => 'Czech', 'is_default' => false],
            ['code' => 'da', 'name' => 'Danish', 'is_default' => false],
            ['code' => 'nl', 'name' => 'Dutch', 'is_default' => false],
            ['code' => 'fi', 'name' => 'Finnish', 'is_default' => false],
            ['code' => 'fr', 'name' => 'French', 'is_default' => false],
            ['code' => 'de', 'name' => 'German', 'is_default' => false],
            ['code' => 'el', 'name' => 'Greek', 'is_default' => false],
            ['code' => 'hi', 'name' => 'Hindi', 'is_default' => false],
            ['code' => 'hu', 'name' => 'Hungarian', 'is_default' => false],
            ['code' => 'it', 'name' => 'Italian', 'is_default' => false],
            ['code' => 'ja', 'name' => 'Japanese', 'is_default' => false],
            ['code' => 'jv', 'name' => 'Javanese', 'is_default' => false],
            ['code' => 'ko', 'name' => 'Korean', 'is_default' => false],
            ['code' => 'zh_cmn', 'name' => 'Mandarin', 'is_default' => false],
            ['code' => 'mr', 'name' => 'Marathi', 'is_default' => false],
            ['code' => 'pl', 'name' => 'Polish', 'is_default' => false],
            ['code' => 'pt', 'name' => 'Portuguese', 'is_default' => false],
            ['code' => 'pa', 'name' => 'Punjabi', 'is_default' => false],
            ['code' => 'ro', 'name' => 'Romanian', 'is_default' => false],
            ['code' => 'ru', 'name' => 'Russian', 'is_default' => false],
            ['code' => 'sr', 'name' => 'Serbian', 'is_default' => false],
            ['code' => 'si', 'name' => 'Sinhalese', 'is_default' => false],
            ['code' => 'sk', 'name' => 'Slovak', 'is_default' => false],
            ['code' => 'es', 'name' => 'Spanish', 'is_default' => true],  
            ['code' => 'sv', 'name' => 'Swedish', 'is_default' => false],
            ['code' => 'ta', 'name' => 'Tamil', 'is_default' => false],
            ['code' => 'te', 'name' => 'Telugu', 'is_default' => false],
            ['code' => 'tr', 'name' => 'Turkish', 'is_default' => false],
            ['code' => 'uk', 'name' => 'Ukrainian', 'is_default' => false],
            ['code' => 'ur', 'name' => 'Urdu', 'is_default' => false],
            ['code' => 'vi', 'name' => 'Vietnamese', 'is_default' => false],
            ['code' => 'zh_wuu', 'name' => 'Wu (Shanghainese)', 'is_default' => false],
            ['code' => 'zh_hsn', 'name' => 'Xiang', 'is_default' => false],
            ['code' => 'zh_yue', 'name' => 'Yue (Cantonese)', 'is_default' => false],
            ['code' => 'zu', 'name' => 'Zulu', 'is_default' => false],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']], 
                ['name' => $language['name'], 'is_default' => $language['is_default']]
            );
        }
    }
}
