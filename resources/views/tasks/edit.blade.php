<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main class="edit-page">
        <h1 class="edit-header">Edit Task</h1>

        <form class="edit-form" action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="task_name">Task name</label>
                <input id="task_name" name="task_name" type="text" value="{{ old('task_name', $task->task_name) }}" required>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $task->description) }}</textarea>
            </div>

            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div>
                <label for="due_date">Due date</label>
                <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $task->due_date) }}">
            </div>

            <button type="submit">Update task</button>
        </form>
    </main>
</body>
</html>
