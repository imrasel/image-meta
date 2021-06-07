<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    // use RefreshDatabase;
    
    public function test_can_upload_photo()
    {
        $formData = [
            'url' => 'https://www.scisports.com/wp-content/uploads/2019/07/ContributionRatings-Visual-Messi-1920-1280x720.jpg'
        ];

        $this->post('/api/photos', $formData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'photo' => ['url', 'camera', 'copyrights', 'exifs']
            ]);
    }
    public function test_can_download_photo()
    {
        $response = $this->get('/api/download/test.jpg');

        $this->assertEquals('attachment; filename=test.jpg', $response->headers->get('content-disposition')); 
    }
    
    public function test_can_get_photos()
    {
        $this->get('/api/photos')
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'photos' => ['data']
            ]);
    }
}
