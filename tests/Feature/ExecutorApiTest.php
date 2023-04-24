<?php declare(strict_types=1);

namespace Tests\Feature;

class ExecutorApiTest extends \Tests\TestCase
{
    public function test_get_executor(): void
    {
        $response = $this->get('/api/executors');

        $response->assertStatus(200);
    }

    public function test_post_executor(): void
    {
        $data = [
            'name'    => 'Сделать домашку',
            'surname' => 'Сделать домашку',
            'email'   => 'asd@aasd.com',
        ];

        $response = $this->post('/api/executors', $data);

        $response->assertStatus(201);

        $res = $response->getContent();
        $this->assertEquals(json_decode($res, true)['object']['email'], $data['email']);
        $this->assertEquals(json_decode($res, true)['object']['name'], $data['name']);
        $this->assertEquals(json_decode($res, true)['object']['surname'], $data['surname']);
    }

    public function test_put_executor(): void
    {
        $data = [
            'text' => 'Сделать домашку',
        ];

        $response = $this->post('/api/executors', $data);
        $id       = $response->offsetGet('object')['id'];

        $data = [
            'id'      => $id,
            'name'    => 'name',
            'surname' => 'surname',
            'email'   => 'email@aw.com',
        ];

        $response = $this->put('/api/executors/' . $id, $data);

        $response->assertStatus(200);
        $res = json_decode($response->getContent(), true);
        $this->assertEquals($res['email'], $data['email']);
        $this->assertEquals($res['name'], $data['name']);
        $this->assertEquals($res['surname'], $data['surname']);
        $this->assertEquals($res['id'], $data['id']);
    }

    public function test_delete_executor(): void
    {
        $data = [
            'name'    => 'name',
            'email'   => 'email@em.cd',
            'surname' => 'surname',
        ];

        $response = $this->post('/api/executors', $data);
        $id       = $response->offsetGet('object')['id'];
        $response = $this->delete("/api/executors/$id");
        $response->assertStatus(204);
    }
}
