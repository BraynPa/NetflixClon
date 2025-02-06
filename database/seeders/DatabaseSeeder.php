<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $movies = [
            [
                'title' => 'Big Buck Bunny',
                'description' => 'Tres roedores se divierten acosando a las criaturas del bosque. Sin embargo, cuando se meten con un conejo, él decide darles una lección.',
                'video_url' => 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                'thumbnail_url' => 'https://upload.wikimedia.org/wikipedia/commons/7/70/Big.Buck.Bunny.-.Opening.Screen.png',
                'genre' => 'Comedia',
                'duration' => '10 minutos',
            ],
            [
                'title' => 'Sintel',
                'description' => 'Una joven solitaria, Sintel, ayuda y se hace amiga de un dragón, al que llama Escamas. Pero cuando es secuestrado por un dragón adulto, Sintel decide embarcarse en una peligrosa búsqueda para encontrar a su amigo perdido, Escamas.',
                'video_url' => 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4',
                'thumbnail_url' => 'http://uhdtv.io/wp-content/uploads/2020/10/Sintel-3.jpg',
                'genre' => 'Aventura',
                'duration' => '15 minutos',
            ],
            [
                'title' => 'Lágrimas de Acero',
                'description' => 'En un futuro apocalíptico, un grupo de soldados y científicos se refugia en Ámsterdam para intentar detener un ejército de robots que amenaza el planeta.',
                'video_url' => 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4',
                'thumbnail_url' => 'https://mango.blender.org/wp-content/uploads/2013/05/01_thom_celia_bridge.jpg',
                'genre' => 'Acción',
                'duration' => '12 minutos',
            ],
            [
                'title' => "El sueño del elefante",
                'description' => 'Los amigos Proog y Emo viajan dentro de los pliegues de una Máquina aparentemente infinita, explorando el complejo oscuro y retorcido de cables, engranajes y ruedas dentadas, hasta que un momento de conflicto anula todas sus suposiciones.',
                'video_url' => 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
                'thumbnail_url' => 'https://download.blender.org/ED/cover.jpg',
                'genre' => 'Ciencia Ficción',
                'duration' => '15 minutos',
            ],
        ];
        
        collect($movies)->each(function ($movie) {
            Movie::create($movie);
        });
    }
}
