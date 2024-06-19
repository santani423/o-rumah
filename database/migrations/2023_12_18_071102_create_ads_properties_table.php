<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ads_id')->nullable()->constrained('ads')->onDelete('cascade');
            $table->foreignId('district_id')->nullable()->constrained(config('laravolt.indonesia.table_prefix') . 'districts')->onDelete('set null'); // kecamatan id
            $table->string('district_name', 255)->nullable(); // nama kecamatan
            $table->decimal('lat', 10, 7)->nullable(); // latitude
            $table->decimal('lng', 10, 7)->nullable(); // longitude
            $table->point('location')->nullable(); // POINT(lat, lng)
            $table->string('area')->nullable(); // nama wilayah
            $table->string('address')->nullable(); // alamat
            $table->string('ads_type')->nullable(); // jual, sewa, lelang
            $table->string('property_type')->nullable(); // rumah, apartemen, kos
            $table->string('rent_type')->nullable(); // Bulanan / tahunan
            $table->unsignedInteger('price')->nullable(); // harga jual / sewa
            $table->string('certificate')->nullable(); // sertifikat
            $table->string('housing_name')->nullable(); // nama komplek
            $table->string('cluster_name')->nullable(); // nama cluster
            $table->year('year_built')->nullable(); // tahun dibangun
            $table->unsignedMediumInteger('lt')->nullable(); // luas tanah
            $table->unsignedMediumInteger('lb')->nullable(); // luas bangunan
            $table->unsignedMediumInteger('dl')->nullable(); // daya listrik
            $table->unsignedMediumInteger('jl')->nullable(); // jumlah lantai
            $table->unsignedMediumInteger('jk')->nullable(); // jumlah kamar
            $table->unsignedMediumInteger('jkm')->nullable(); // jumlah kamar mandi
            $table->string('apartment_type')->nullable(); // tipe apartemen
            $table->unsignedMediumInteger('floor_location')->nullable(); // lokasi lantai
            $table->string('furniture_condition')->nullable(); // kondisi furniture
            $table->json('house_facility')->nullable(); // fasilitas rumah : ac, kamar mandi, wifi
            $table->json('other_facility')->nullable(); // fasilitas daerah : dekat jalan tol, dekat rumah sakit umum
            $table->string('video')->nullable(); // video youtube url
            $table->string('image')->nullable(); // image jilid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ads_properties');
        Schema::enableForeignKeyConstraints();
    }
};
