<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Enums\TaskStatuses;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_get_task(): void
    {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
    }

    public function test_post_task(): void
    {
        $data = [
            'text' => 'Сделать домашку',
        ];

        $response = $this->post('/api/tasks', $data);

        $response->assertStatus(201);

        $res = $response->getContent();
        $this->assertEquals(json_decode($res, true)['object']['text'], $data['text']);
    }

    public function test_put_task(): void
    {
        $data = [
            'text' => 'Сделать домашку',
        ];

        $response = $this->post('/api/tasks', $data);
        $id       = $response->offsetGet('object')['id'];

        $data = [
            'id'     => $id,
            'text'   => 'Сделать домашку 1',
            'status' => TaskStatuses::DONE->value,
        ];

        $response = $this->put('/api/tasks/' . $id, $data);

        $response->assertStatus(200);
        $res = json_decode($response->getContent(), true);
        $this->assertEquals($res['text'], $data['text']);
        $this->assertEquals($res['status'], $data['status']);
        $this->assertEquals($res['id'], $data['id']);
    }

    public function test_delete_task(): void
    {
        $data = [
            'text' => 'Сделать домашку',
        ];

        $response = $this->post('/api/tasks', $data);
        $id       = $response->offsetGet('object')['id'];
        $response = $this->delete("/api/tasks/$id");
        $response->assertStatus(204);
    }

    public function test_search_task(): void
    {
        $delIds   = [];
        $data     = [
            'text'   => 'Сделать',
            'status' => TaskStatuses::DONE->value,
        ];
        $res      = $this->post('/api/tasks/', $data);
        $delIds[] = $res->offsetGet('object')['id'];
        $response = $this->get('/api/tasks?'.http_build_query($data));
        $tasks    = $response->offsetGet('tasks');

        foreach ($tasks as $task) {
            self::assertContains('Сделать', $task['text']);
            self::assertEquals(TaskStatuses::DONE->value, $task['status']);
        }

        $response->assertStatus(200);
        foreach ($delIds as $delId) {
            $this->delete("/api/tasks/$delId");
        }
    }
}
