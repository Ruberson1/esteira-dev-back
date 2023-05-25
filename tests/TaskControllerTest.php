<?php

use App\Http\Controllers\V1\Task\TaskController;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task\Task;
use App\Repositories\Task\TaskRepository;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;

class TaskControllerTest extends TestCase
{
//    public function testCrudTask()
//    {
//        // Cria a tarefa
//        $taskData = [
//            'user_id' => 2,
//            'status_id' => 1,
//            'task_date' => '2023-03-17',
//            'test_date' => '2023-03-18',
//            'title' => 'Test Task',
//            'deadline' => '36 hrs',
//            'description' => 'This is a test task'
//        ];
//
//        $taskService = $this->createMock(TaskService::class);
//        $taskService->method('create')->willReturn([Task::create($taskData)]);
//
//        $request = new Request($taskData);
//        $taskController = new TaskController($taskService);
//        $response = $taskController->create($request);
//
//        $this->assertEquals(201, $response->getStatusCode());
//
//        // Armazena o ID da tarefa criada
//        $task = Task::where('title', 'Test Task')->first();
//        $taskId = $task->id;
//
//        // Atualiza a tarefa
//        $updatedTaskData = [
//            'title' => 'Updated Test Task',
//            'description' => 'This is an updated test task'
//        ];
//        $request = new Request($updatedTaskData);
//        $taskRepository = $this->createMock(TaskRepository::class);
//        $taskRepository->method('editBy')->willReturn([Task::update($updatedTaskData)]);
//        $taskService = $this->createMock(TaskService::class);
//        $taskService->method('editBy')->willReturn([Task::update($taskData)]);
//
//        $taskController = new TaskController($taskService);
//        $response = $taskController->editBy($request, $taskId);
//
//        $this->assertEquals(true, $response->getStatusCode());
//
//        // Deleta a tarefa
//        $taskService = $this->createMock(TaskService::class);
//        $taskService->method('delete')->willReturn(true);
//
//        $request = new Request();
//        $taskController = new TaskController($taskService);
//        $response = $taskController->delete($request, $taskId);
//
//        $this->assertEquals(true, $response->getStatusCode());
//    }

}