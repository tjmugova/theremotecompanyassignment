<?php

namespace Tests\Feature;

use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_resources_list_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_view_admin_page()
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_can_create_pdf_resource()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');
        $response = $this->post('/admin/resource/store', [
            'resource_type' => 'pdf',
            'title' => 'A test pdf',
            'file' => $file,
        ]);
        $response->assertStatus(200);
        Storage::disk('public')->assertExists($file->hashName());
    }

    public function test_can_create_html_resource()
    {
        $response = $this->post('/admin/resource/store', [
            'resource_type' => 'html',
            'title' => 'A test html',
            'description' => 'A test description',
            'html' => '<p>A test html</p>',
        ]);
        $response->assertStatus(200);
    }

    public function test_can_create_link_resource()
    {
        $response = $this->post('/admin/resource/store', [
            'resource_type' => 'link',
            'title' => 'A test link',
            'link' => 'https://webstudio.co.zw',
            'open_in_new_tab' => 1,
        ]);
        $response->assertStatus(200);
    }

    public function test_can_update_pdf_resource()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');
        $resource = Resource::factory()->create([
            'resource_type' => 'pdf',
            'title' => 'a random pdf title',
        ]);
        $response = $this->put('/admin/resource/' . $resource->id . '/update', [
            'title' => 'changed pdf title',
            'file' => $file,
        ]);
        $resource->refresh();
        $response->assertStatus(200);
        $this->assertSame('changed pdf title', $resource->title);
    }

    public function test_can_update_html_resource()
    {
        $resource = Resource::factory()->create([
            'resource_type' => 'html',
            'title' => 'a random html title',
            'description' => 'A test html description',
            'html' => '<p>A test html</p>',
        ]);
        $response = $this->put('/admin/resource/' . $resource->id . '/update', [
            'title' => 'changed html title',
            'description' => 'A changed html description',
            'html' => '<p>A changed html</p>',
        ]);
        $resource->refresh();
        $response->assertStatus(200);
        $this->assertSame('changed html title', $resource->title);
        $this->assertSame('A changed html description', $resource->description);
        $this->assertSame('<p>A changed html</p>', $resource->html);
    }

    public function test_can_update_link_resource()
    {
        $resource = Resource::factory()->create([
            'resource_type' => 'link',
            'title' => 'A random link',
            'link' => 'https://webstudio.co.zw',
            'open_in_new_tab' => 1,
        ]);
        $response = $this->put('/admin/resource/' . $resource->id . '/update', [
            'title' => 'changed link title',
            'link' => 'https://theremotecompany.com',
            'open_in_new_tab' => 0,
        ]);
        $resource->refresh();
        $response->assertStatus(200);
        $this->assertSame('changed link title', $resource->title);
        $this->assertSame('https://theremotecompany.com', $resource->link);
        $this->assertFalse($resource->open_in_new_tab);
    }

    public function test_can_delete_resource()
    {
        $resource = Resource::factory()->create();
        $response = $this->delete('/admin/resource/' . $resource->id . '/destroy');
        $response->assertStatus(200);
        $this->assertModelMissing($resource);
    }
}
