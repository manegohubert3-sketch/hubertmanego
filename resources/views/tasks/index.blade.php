<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Scheduler</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #1d1d1d;
        }

        .topbar {
            height: 74px;
            background: #f1f1f1;
            border-bottom: 1px solid #d9d9d9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px 0 18px;
            gap: 16px;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            font-size: 18px;
        }

        .browser-address {
            flex: 1;
            max-width: 1040px;
            height: 42px;
            border-radius: 22px;
            background: #f7f7f7;
            border: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            font-size: 14px;
            overflow: hidden;
        }

        .browser-address span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 18px;
        }

        .user-pill {
            min-width: 150px;
            height: 42px;
            border-radius: 999px;
            background: #f6f6f6;
            border: 1px solid #d7d7d7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2d2d2d;
            font-weight: 600;
            font-size: 14px;
        }

        .page {
            max-width: 1260px;
            margin: 0 auto;
            padding: 24px 18px 40px;
        }

        .menu {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            padding: 8px 18px 18px;
            font-size: clamp(1.1rem, 2vw, 2.2rem);
            letter-spacing: -0.04em;
            color: #1e1e1e;
            font-weight: 500;
        }

        .menu-items {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: clamp(12px, 3vw, 60px);
            width: 100%;
            margin-right: 28px;
        }

        .menu-item {
            white-space: nowrap;
        }

        .chat-bubble {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2px solid #000;
            background: #f7f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
        }

        .chat-bubble::before {
            content: "";
            width: 24px;
            height: 24px;
            border: 4px solid #1b1b1b;
            border-top: 0;
            border-left: 0;
            transform: rotate(45deg);
            position: absolute;
            bottom: 17px;
            right: 15px;
            background: transparent;
            border-radius: 3px;
        }

        .header {
            margin: 0 auto 24px;
            width: 100%;
            max-width: 1100px;
            background: #0f79ea;
            color: #fff;
            height: 114px;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(2rem, 4vw, 4rem);
            font-weight: 700;
            letter-spacing: -0.06em;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
        }

        .task-panel {
            max-width: 1100px;
            margin: 0 auto;
            background: transparent;
        }

        .task-form {
            display: grid;
            grid-template-columns: 1.8fr 0.9fr 0.7fr auto;
            gap: 8px;
            align-items: center;
            margin-bottom: 28px;
        }

        .task-input,
        .task-select,
        .task-date,
        .task-button {
            height: 54px;
            border: 2px solid #a9a9a9;
            border-radius: 10px;
            background: #fafafa;
            font-size: 1.08rem;
            padding: 0 16px;
            color: #1b1b1b;
        }

        .task-input {
            width: 100%;
        }

        .task-select,
        .task-date {
            width: 100%;
        }

        .task-button {
            background: #f3f3f3;
            color: #1d1d1d;
            font-weight: 700;
            cursor: pointer;
            padding: 0 24px;
            min-width: 140px;
        }

        .task-list {
            border: 2px solid #b7b7b7;
            background: #f3f3f3;
            border-radius: 0;
            overflow: hidden;
        }

        .task-row {
            display: grid;
            grid-template-columns: 2.4fr 1.5fr 1.5fr auto;
            align-items: center;
            min-height: 100px;
            border-bottom: 2px solid #b7b7b7;
            padding: 0 18px 0 18px;
            background: rgba(255,255,255,0.18);
        }

        .task-row:last-child {
            border-bottom: 0;
        }

        .task-name {
            font-size: clamp(1.2rem, 2vw, 2.2rem);
            font-weight: 600;
            letter-spacing: -0.04em;
        }

        .task-priority,
        .task-deadline {
            font-size: clamp(1rem, 1.6vw, 1.8rem);
            text-align: center;
            letter-spacing: -0.04em;
            color: #242424;
        }

        .task-priority {
            font-weight: 500;
        }

        .task-deadline {
            font-weight: 500;
        }

        .task-action {
            display: flex;
            justify-content: flex-end;
        }

        .done-btn {
            background: #39bf6e;
            color: white;
            border: 0;
            border-radius: 8px;
            padding: 12px 22px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            min-width: 130px;
        }

        @media (max-width: 900px) {
            .menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .menu-items {
                width: auto;
                flex-wrap: wrap;
                justify-content: center;
                margin-right: 0;
            }

            .task-form {
                grid-template-columns: 1fr;
            }

            .task-row {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 18px 20px;
                text-align: left;
            }

            .task-priority,
            .task-deadline,
            .task-action {
                text-align: left;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="nav-left">
            <div class="nav-icons">
                <span>◁</span>
                <span>▷</span>
                <span>⟳</span>
            </div>
        </div>

        <div class="browser-address">
        </div>

        <div class="user-pill">Incognito</div>
    </div>

    <div class="page">
        <nav class="menu" aria-label="Main navigation">
            <div class="chat-bubble" aria-label="Chat"></div>
        </nav>

        <header class="header">Task Scheduler</header>

        <section class="task-panel">
            <form class="task-form" action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input class="task-input" name="task_name" type="text" placeholder="Enter task..." required>

                <select class="task-select" name="status">
                    <option value="pending">Top Priority</option>
                    <option value="completed">Completed</option>
                </select>

                <input class="task-date" name="due_date" type="date">

                <button class="task-button" type="submit">Add Task</button>
            </form>

            @php
                $displayTasks = $tasks->isNotEmpty() ? $tasks : collect([
                    ['task_name' => 'DSA Practice', 'status' => 'pending', 'due_date' => '2023-08-24'],
                    ['task_name' => 'Js Practice', 'status' => 'pending', 'due_date' => '2023-09-01'],
                    ['task_name' => 'Maths Practice', 'status' => 'pending', 'due_date' => '2023-08-31'],
                ]);
            @endphp

            <div class="task-list">
                @foreach ($displayTasks as $task)
                    <div class="task-row">
                        <div class="task-name">{{ $task['task_name'] ?? $task->task_name }}</div>
                        <div class="task-priority">Priority: {{ strtoupper($task['status'] ?? $task->status) === 'COMPLETED' ? 'low' : 'top' }}</div>
                        <div class="task-deadline">Deadline: {{ ($task['due_date'] ?? $task->due_date) ?: 'Not set' }}</div>
                        <div class="task-action">
                            <button class="done-btn" type="button">Mark Done</button>
                            @if (is_object($task))
                                <a class="edit-link" href="{{ route('tasks.edit', $task) }}">Edit</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</body>
</html>
