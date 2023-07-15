<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (){
    return redirect('/task/index') ;
});

Route::get('/task/index', function () {
    return view('index',['tasks'=> Task::latest()->paginate(10)]);
})->name('task-index');

Route::fallback(function () {
    return 'Still got somewhere!';
});



Route::view('/task/create', 'create')->name('task-create');

Route::get('/task/edit/{task}', function (Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks-edit');

Route::get('/task/show/{task}', function (Task $task) {
    return view('show',['task'=> $task]);
})->name('task-show');


Route::post('/task', function (TaskRequest $request) {
    $task = Task::create($request->validated());
    return redirect()->route('task-show',['task'=>$task->id])->with('success', 'Task created successfully!');  
})->name('task-store');

Route::put('/task/{task}', function (Task $task,TaskRequest $request) {
    $task->update($request->validated());
    return redirect()->route('task-show',['task'=>$task->id])->with('success', 'Task update successfully!');  
})->name('task-update');

Route::delete('/task/delete/{task}', function (Task $task) {
    $task->delete();
    return redirect()->route('task-index')->with('success', 'Task delete successfully!');  
})->name('task-delete');

Route::put('tasks/toggle-complete/{task}', function (Task $task) {
    $task->toggleComplete();

    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks-toggle-complete');






