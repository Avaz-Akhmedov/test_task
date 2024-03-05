<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use HasFactory, DatabaseTransactions;

    public function test_to_see_all_tasks()
    {
        Category::factory()->create();
        Task::factory(20)->create();

        $this
            ->getJson(route('tasks.index'))
            ->assertJsonCount(20, 'data')
            ->assertOk();
    }

    public function test_to_see_individual_task()
    {
        Category::factory()->create();
        $task = Task::factory()->create();

        $this
            ->getJson(route('tasks.show', 'not-found'))
            ->assertNotFound();

        $this
            ->getJson(route('tasks.show', $task->id))
            ->assertOk();
    }

    public function test_to_create_new_task()
    {
        $category = Category::factory()->create();

        $this->postJson(route('tasks.store'), [
            'category_id' => $category->id
        ])->assertUnprocessable();

        $this->postJson(route('tasks.store'), [
            'category_id' => $category->id,
            'name' => 'Do something',
            'description' => 'Today at night watch game of Barcelona'
        ])->assertCreated();
    }

    public function test_task_filters()
   {
        Task::factory(5)->create([
            'created_at' => '2024-03-04',
            'status' => 'completed'
        ]);

        $this
            ->getJson(route('tasks.index', ['date' => '2024-03-04']))
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_to_delete_task()
    {
        Category::factory()->create();
        $task = Task::factory()->create();

        $this
            ->getJson(route('tasks.show', 1231321))
            ->assertNotFound();

        $this->deleteJson(route('tasks.destroy', $task->id))
            ->assertNoContent();
    }
}
