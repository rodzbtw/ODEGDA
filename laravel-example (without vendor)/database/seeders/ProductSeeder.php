<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::factory()->count(10)->create();
    
        \App\Models\Product::create([
            'name' => 'РќРѕСѓС‚Р±СѓРє Dell XPS 15',
            'description' => 'РџРѕС‚СѓР¶РЅРёР№ РЅРѕСѓС‚Р±СѓРє РґР»СЏ СЂРѕР±РѕС‚Рё С‚Р° РЅР°РІС‡Р°РЅРЅСЏ',
            'price' => 45999.99,
            'quantity' => 5,
            'is_active' => true,
        ]);
    }
}
