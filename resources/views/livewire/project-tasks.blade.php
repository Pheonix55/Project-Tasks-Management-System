<div class="dark-bg text-light min-h-screen p-6">
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.default.css" rel="stylesheet">

    {{-- to make my livewire component compatible with the starter kit theme and theme switching i created some custom classes and css variables --}}
    <style>
        /* =======================
       |  THEME VARIABLES
       ======================= */
        :root {
            --bg-color: #fafafa;
            /* Light background */
            --sidebar-bg: #fafafa;
            /* Light sidebar background */
            --hover-bg: #262626;
            /* Light hover */
            --border-color: #262626;
            /* Light border */
            --text-color: #262626;
            /* Light text */

            --btn-primary-bg: #636363;
            --btn-primary-color: #ccc;
            --btn-primary-hover-bg: #636363;
            --btn-primary-hover-color: #ccc;

            --btn-success-bg: #16A34A;
            --btn-success-hover-bg: #15803D;
            --btn-success-color: #fff;

            --btn-warning-bg: #F59E0B;
            --btn-warning-hover-bg: #D97706;
            --btn-warning-color: #111;

            --btn-danger-bg: #DC2626;
            --btn-danger-hover-bg: #B91C1C;
            --btn-danger-color: #fff;

            --btn-neutral-bg: #fafafa;
            --btn-neutral-border: #262626;
            --btn-neutral-color: #262626;
            --btn-neutral-hover-bg: #262626;
            --btn-neutral-hover-color: #fff;

            /* Tom Select */
            --ts-bg: #fafafa;
            --ts-border: #262626;
            --ts-color: #262626;
            --ts-hover-bg: #262626;
        }

        /* =======================
       |  DARK MODE OVERRIDES
       ======================= */
        html.dark {
            --bg-color: #262626;
            --sidebar-bg: #171717;
            --hover-bg: #272727;
            --border-color: #333333;
            --text-color: #f5f5f5;

            --btn-primary-bg: #fff;
            --btn-primary-color: #636363;
            --btn-primary-hover-bg: #636363;
            --btn-primary-hover-color: #fff;

            --btn-success-bg: #16A34A;
            --btn-success-hover-bg: #15803D;
            --btn-success-color: #fff;

            --btn-warning-bg: #F59E0B;
            --btn-warning-hover-bg: #D97706;
            --btn-warning-color: #111;

            --btn-danger-bg: #DC2626;
            --btn-danger-hover-bg: #B91C1C;
            --btn-danger-color: #fff;

            --btn-neutral-bg: #171717;
            --btn-neutral-border: #333333;
            --btn-neutral-color: #f5f5f5;
            --btn-neutral-hover-bg: #272727;
            --btn-neutral-hover-color: #f5f5f5;

            /* Tom Select */
            --ts-bg: #171717;
            --ts-border: #333333;
            --ts-color: #f5f5f5;
            --ts-hover-bg: #272727;
        }

        /* =======================
       |  GLOBAL STYLES
       ======================= */
        .dark-bg,
        .tom-select .ts-control,
        .ts-control input {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .dark-sidebar {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
        }

        .hover:bg-gray-200:hover {
            background-color: var(--hover-bg);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--btn-primary-bg);
            color: var(--btn-primary-color);
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--btn-primary-hover-bg);
            color: var(--btn-primary-hover-color);
        }

        .btn-success {
            background-color: var(--btn-success-bg);
            color: var(--btn-success-color);
            transition: background-color 0.2s;
        }

        .btn-success:hover {
            background-color: var(--btn-success-hover-bg);
        }

        .btn-warning {
            background-color: var(--btn-warning-bg);
            color: var(--btn-warning-color);
            transition: background-color 0.2s;
        }

        .btn-warning:hover {
            background-color: var(--btn-warning-hover-bg);
        }

        .btn-danger {
            background-color: var(--btn-danger-bg);
            color: var(--btn-danger-color);
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: var(--btn-danger-hover-bg);
        }

        .btn-neutral {
            background-color: var(--btn-neutral-bg);
            border: 1px solid var(--btn-neutral-border);
            color: var(--btn-neutral-color);
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-neutral:hover {
            background-color: var(--btn-neutral-hover-bg);
            color: var(--btn-neutral-hover-color);
        }

        /* Tom Select */
        .tom-select .ts-control {
            background-color: var(--ts-bg);
            border-color: var(--ts-border);
            color: var(--ts-color) !important;
            box-shadow: unset !important;
            background-image: unset !important;
        }

        .tom-select .ts-dropdown {
            background-color: var(--ts-bg);
            border-color: var(--ts-border);
            color: var(--ts-color);
        }

        .tom-select .ts-dropdown .option:hover {
            background-color: var(--ts-hover-bg);
        }

        .ts-dropdown .active {
            background-color: var(--bg-color);
            color: var(--text-color);
        }
    </style>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" class="p-3 bg-green-200 border border-green-300 rounded  mb-4">
            {{ session('message') }}
            <button @click="show = false" class="ml-2 px-2 py-1  rounded">✕</button>
        </div>
    @endif


    {{-- Add Project Modal --}}
    @if ($showProjectModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showProjectModal', false)">
            </div>

            {{-- Modal --}}
            <div class="relative w-full max-w-md dark-sidebar rounded-xl shadow-xl p-6 text-light">
                {{-- Header --}}
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Create New Project</h3>
                    <button wire:click="$set('showProjectModal', false)" class="text-light hover:text-gray-300">
                        &times;
                    </button>
                </div>

                {{-- Body --}}
                <div class="flex gap-2 items-center mb-4">
                    <input type="text" wire:model.defer="projectName" placeholder="Project Name"
                        class="border dark-border rounded px-3 py-2 flex-1 dark-bg text-light
                       focus:ring focus:ring-gray-500 focus:border-gray-400 outline-none" />

                    <button wire:click="createProject"
                        class="btn-primary px-4 py-2 rounded flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end">
                    <button wire:click="$set('showProjectModal', false)"
                        class="btn-neutral px-4 py-2 rounded text-sm font-medium">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- Projects Table --}}
    <div class="dark-sidebar shadow rounded p-4 mb-6">
        <div class="flex justify-between my-3">
            <h2 class="text-lg font-semibold mb-3 text-light">Projects</h2>
            <button wire:click="$set('showProjectModal', true)" class="btn-primary px-2 py-2 rounded">
                Add Project
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @forelse ($projects as $project)
                <div
                    class="border dark-border rounded p-3 flex justify-between items-center hover:bg-gray-200 transition">
                    <span class="font-medium">{{ $project->name }}</span>
                    <button wire:click="openTaskModal({{ $project->id }})"
                        class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded text-sm transition">
                        Add tasks

                    </button>
                </div>
            @empty
                <p class="text-gray-400">No projects yet.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($projectsTotalPages > 1)
            <div class="flex justify-center gap-1 mt-4">
                @for ($page = 1; $page <= $projectsTotalPages; $page++)
                    <button wire:click="updateProjPage({{ $page }})"
                        class="px-3 py-1 border rounded transition
                            {{ $projectsPage === $page
                                ? 'bg-green-600 text-white border-green-600'
                                : 'dark-sidebar text-light dark-border hover:bg-gray-200' }}">
                        {{ $page }}
                    </button>
                @endfor
            </div>
        @endif
    </div>


    <div class="flex gap-2 items-center mb-4">

        {{-- Searchable Project Select --}}
        <select id="project-filter" wire:model="filterProject"
            class="tom-select border dark-border rounded px-3 py-2 dark-bg text-light outline-none">
            <option value="">All Projects</option>
            @foreach ($allProjects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>

        {{-- Filter Button --}}
        <button wire:click="applyFilter" class="btn-primary px-3 py-2 rounded">
            Filter
        </button>

    </div>



    @if ($filterProject)
        {{-- Tasks Table --}}
        <div class="dark-sidebar shadow rounded p-4">
            <h2 class="text-lg font-semibold mb-3 text-light">Tasks</h2>
            <table class="w-full border-collapse text-light">
                <thead class="dark-bg text-light font-semibold">
                    <tr>
                        <th class="border dark-border px-3 py-2 text-left">-</th>
                        <th class="border dark-border px-3 py-2 text-left">#</th>
                        <th class="border dark-border px-3 py-2 text-left">Task Name</th>
                        <th class="border dark-border px-3 py-2 text-left">Project</th>
                        <th class="border dark-border px-3 py-2 text-left">Priority</th>
                        <th class="border dark-border px-3 py-2 text-left">Created At</th>
                        <th class="border dark-border px-3 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="tasks-list" class="dark-bg text-light">
                    @forelse($tasks as $task)
                        <tr data-id="{{ $task->id }}" data-proj-id="{{ $task->project_id }}"
                            class="hover:bg-gray-200 transition ">
                            <td class="border dark-border px-3 py-2 text-center">
                                <!-- Drag Handle -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 drag-handle cursor-move" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                                </svg>
                            </td>
                            <td class="border dark-border px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="border dark-border px-3 py-2">{{ $task->name }}</td>
                            <td class="border dark-border px-3 py-2">{{ $task->project->name }}</td>
                            <td class="border dark-border px-3 py-2">{{ $task->priority }}</td>
                            <td class="border dark-border px-3 py-2">
                                @if ($task->created_at->lt(now()->subDay()))
                                    {{ $task->created_at->format('d M Y') }}
                                @else
                                    {{ $task->created_at->diffForHumans() }}
                                @endif
                            </td>
                            <td class="border dark-border px-3 py-2 flex gap-2">
                                <button wire:click="openEditTaskModal({{ $task->id }})"
                                    class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-2 py-1 rounded text-sm transition">
                                    Edit
                                </button>
                                <button wire:click="deleteTask({{ $task->id }})"
                                    class="bg-red-600 hover:bg-red-500 text-white px-2 py-1 rounded text-sm transition">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border dark-border px-3 py-2 text-center text-gray-400">
                                No tasks found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($tasksTotalPages > 1)
                <div class="flex justify-center gap-1 mt-4">
                    @for ($page = 1; $page <= $tasksTotalPages; $page++)
                        <button wire:click="updateTaskPage({{ $page }})"
                            class="px-3 py-1 border rounded transition
                            {{ $tasksPage === $page
                                ? 'bg-green-600 text-white border-green-600'
                                : 'dark-sidebar text-light dark-border hover:bg-gray-200' }}">
                            {{ $page }}
                        </button>
                    @endfor
                </div>
            @endif
        </div>
    @else
        <p class="text-gray-400 mt-4">Select a project to view tasks.</p>
    @endif
    {{-- Task Modal --}}
    @if ($showTaskModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeTaskModal"></div>

            <div class="relative w-full max-w-md dark-sidebar rounded-xl shadow-xl p-6 text-light">
                <div class="mb-5">
                    <h3 class="text-lg font-semibold">Add New Task</h3>
                    <p class="text-sm text-gray-300">Create a task under the selected project</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Task name</label>
                    <input type="text" wire:model.defer="taskName" placeholder="e.g. Design landing page"
                        class="w-full rounded-lg border dark-border px-3 py-2 text-sm dark-bg text-light
                                  focus:border-green-500 focus:ring-2 focus:ring-green-400 outline-none" />
                    @error('taskName')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="closeTaskModal"
                        class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 text-light transition">
                        Cancel
                    </button>
                    <button wire:click="createTask"
                        class="px-4 py-2 rounded-lg text-sm font-medium bg-green-600 hover:bg-green-500 text-white transition">
                        Add Task
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Task Modal --}}
    @if ($showEditTaskModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeEditTaskModal"></div>

            <div class="relative w-full max-w-md dark-sidebar rounded-xl shadow-xl p-6 text-light">
                <h3 class="text-lg font-semibold mb-4">Edit Task</h3>
                <input type="text" wire:model.defer="editTaskName" placeholder="Task Name"
                    class="w-full rounded-lg border dark-border px-3 py-2 text-sm dark-bg text-light
                              focus:border-yellow-500 focus:ring-2 focus:ring-yellow-400 outline-none mb-4" />
                @error('editTaskName')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="flex justify-end gap-3">
                    <button wire:click="closeEditTaskModal"
                        class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 text-light transition">
                        Cancel
                    </button>
                    <button wire:click="updateTask"
                        class="px-4 py-2 rounded-lg text-sm font-medium bg-yellow-500 hover:bg-yellow-400 text-gray-900 transition">
                        Update
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Sortable JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            let sortable;

            function initSortable() {
                const el = document.getElementById('tasks-list');
                if (!el) return;
                if (sortable) sortable.destroy();

                sortable = new Sortable(el, {
                    animation: 150,
                    handle: '.drag-handle', // Only drag by this handle
                    onEnd() {
                        let tasks = [];
                        el.querySelectorAll('tr').forEach(row => {
                            tasks.push({
                                id: row.dataset.id,
                                project_id: row.dataset.projId
                            });
                        });

                        // Call Livewire method with full info
                        Livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id'))
                            .call('updateTaskOrder', tasks);
                    }
                });
            }

            initSortable();
            Livewire.on('tasksUpdated', () => setTimeout(initSortable, 0));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#project-filter', {
                placeholder: 'Search projects…',
                allowEmptyOption: true,
                searchField: ['text'], // allows search on option text
            });
        });
    </script>

</div>
