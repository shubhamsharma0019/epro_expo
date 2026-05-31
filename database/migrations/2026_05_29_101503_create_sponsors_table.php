<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('name');
            $table->string('logo_url');
            $table->string('level'); // Platinum, Gold, Silver
            $table->timestamps();
        });

        // Insert initial sponsors for Exhibition 1
        $sponsors = [
            [
                'exhibition_id' => 1,
                'name' => 'IBM',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg',
                'level' => 'Platinum',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Microsoft',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg',
                'level' => 'Platinum',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Intel',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Intel_logo_%282020%29.svg',
                'level' => 'Gold',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Nvidia',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/21/Nvidia_logo.svg',
                'level' => 'Gold',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'AWS',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg',
                'level' => 'Gold',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Google',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
                'level' => 'Gold',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Dell Technologies',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Dell_logo_2016.svg',
                'level' => 'Silver',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Cisco Systems',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg',
                'level' => 'Silver',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Bosch',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/b2/Bosch_logo.svg',
                'level' => 'Silver',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('sponsors')->insert($sponsors);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
