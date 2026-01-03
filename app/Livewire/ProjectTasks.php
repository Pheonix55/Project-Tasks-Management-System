<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use App\Models\{Project, Task};
use Livewire\Component;

class ProjectTasks extends Component
{
    /* =======================
       |  FILTERS
       ======================= */
    public $filterProject = null; // currently selected project filter

    /* =======================
       |  PAGINATION STATE
       ======================= */
    public int $tasksPage = 1;

    public int $tasksPerPage = 10;

    public int $tasksTotalPages = 1;

    public int $projectsPage = 1;

    public int $projectsPerPage = 5;

    public int $projectsTotalPages = 1;

    /* =======================
       |  DATA
       ======================= */
    public $tasks = [];       // tasks currently loaded

    public $projects = [];    // paginated list of projects

    public $allProjects = []; // all projects for dropdowns

    public $taskSearch = '';  // search term for tasks

    /* =======================
       |  UI STATE
       ======================= */
    public $projectName = '';         // new project input

    public $taskName = '';            // new task input

    public $showProjectModal = false; // show/hide project creation modal

    public $taskProjectId = null;     // selected project id for task modal

    public bool $showTaskModal = false;       // task creation modal

    public bool $showEditTaskModal = false;   // task edit modal

    public $editTaskId = null;        // task id being edited

    public $editTaskName = '';        // edited task name

    /* =======================
       |  LIFECYCLE
       ======================= */
    public function mount()
    {
        // Load all projects and initial tasks/projects for UI
        $this->loadAllProjects();
        $this->loadProjects();
        $this->loadTasks();
    }

    /* =======================
       |  LOADERS
       ======================= */
    public function loadAllProjects()
    {
        // Get all projects (for select dropdowns)
        $this->allProjects = Project::orderBy('name')->get();
    }

    public function loadProjects()
    {
        // Get paginated projects
        $query = Project::orderBy('name');
        $total = $query->count();

        $this->projects = $query
            ->skip(($this->projectsPage - 1) * $this->projectsPerPage)
            ->take($this->projectsPerPage)
            ->get();

        $this->projectsTotalPages = (int) ceil($total / $this->projectsPerPage);
    }

    public function updateProjPage($page)
    {
        // Change current projects page
        $this->projectsPage = $page;
        $this->loadProjects();
    }

    public function loadTasks()
    {
        // Only load tasks if a project is selected
        if (! $this->filterProject) {
            $this->tasks = [];
            $this->tasksTotalPages = 0;

            return;
        }

        // Base query for tasks in selected project
        $query = Task::with('project')
            ->where('project_id', $this->filterProject)
            ->orderBy('priority');

        // Apply search filter if provided
        if ($this->taskSearch) {
            $query->where('name', 'like', '%'.$this->taskSearch.'%');
        }

        $total = $query->count();

        // Paginate tasks
        $this->tasks = $query
            ->skip(($this->tasksPage - 1) * $this->tasksPerPage)
            ->take($this->tasksPerPage)
            ->get();

        $this->tasksTotalPages = (int) ceil($total / $this->tasksPerPage);

        // Trigger frontend event for SortableJS
        $this->dispatch('tasksUpdated');
    }

    public function updateTaskPage($page)
    {
        $this->tasksPage = $page;
        $this->loadTasks();
    }

    /* =======================
       |  FILTER
       ======================= */
    public function applyFilter()
    {
        // Reset to first page whenever filter is applied
        $this->tasksPage = 1;
        $this->loadTasks();
    }

    /* =======================
       |  CRUD
       ======================= */
    public function createProject()
    {
        $this->validate(['projectName' => 'required|string|max:255']);

        Project::create(['name' => $this->projectName]);
        $this->projectName = '';
        $this->showProjectModal = false;

        // Reload projects after creation
        $this->loadAllProjects();
        $this->loadProjects();

        // Flash message for UI
        session()->flash('message', 'Project created successfully.');
    }

    public function openTaskModal($projectId)
    {
        // Set project for new task
        $this->taskProjectId = $projectId;
        $this->taskName = '';
        $this->showTaskModal = true;
    }

    public function createTask()
    {
        $this->validate(['taskName' => 'required|string|max:255']);

        DB::transaction(function () {
            // Get max priority in this project
            $max = Task::where('project_id', $this->taskProjectId)->max('priority') ?? 0;

            // Create new task at the end
            Task::create([
                'project_id' => $this->taskProjectId,
                'name' => $this->taskName,
                'priority' => $max + 1,
            ]);
        });

        $this->showTaskModal = false;
        $this->loadTasks();

        session()->flash('message', 'Task created successfully.');
    }

    public function openEditTaskModal($taskId)
    {
        $task = Task::findOrFail($taskId);

        $this->editTaskId = $task->id;
        $this->editTaskName = $task->name;
        $this->showEditTaskModal = true;
    }

    public function closeTaskModal()
    {
        $this->showTaskModal = false;
    }

    public function updateTask()
    {
        $this->validate(['editTaskName' => 'required|string|max:255']);

        Task::where('id', $this->editTaskId)
            ->update(['name' => $this->editTaskName]);

        $this->showEditTaskModal = false;
        $this->loadTasks();

        session()->flash('message', 'Task updated successfully.');
    }

    public function deleteTask($taskId)
    {
        // Fetch the task to delete
        $task = Task::findOrFail($taskId);

        DB::transaction(function () use ($task) {
            $projectId = $task->project_id;
            $priority = $task->priority;

            // Delete the task
            $task->delete();

            // Shift all tasks with higher priority one step up to fill the gap
            Task::where('project_id', $projectId)
                ->where('priority', '>', $priority)
                ->decrement('priority');
        });

        session()->flash('message', 'Task deleted successfully.');

        // Reload tasks for frontend
        $this->loadTasks();
    }

    /* =======================
       |  WATCHERS
       ======================= */
    public function updatedFilterProject($value)
    {
        // Reset pagination and search whenever project filter changes
        $this->tasksPage = 1;
        $this->taskSearch = '';
        $this->loadTasks();
    }

    /* =======================
       |  SORTING
       ======================= */
    public function updateTaskOrder(array $tasks)
    {
        // Only reorder if a project is selected
        if (! $this->filterProject) {
            return;
        }

        DB::transaction(function () use ($tasks) {
            $projectId = $this->filterProject;

            // Step 1: nullify all priorities to avoid duplicate key conflicts
            Task::where('project_id', $projectId)->update(['priority' => null]);

            // Step 2: assign new priority values in the order received from frontend
            foreach ($tasks as $index => $taskData) {
                Task::where('project_id', $projectId)
                    ->where('id', $taskData['id'])
                    ->update(['priority' => $index + 1]);
            }
        });

        $this->loadTasks();

        session()->flash('message', 'Task order updated successfully.');
    }

    /* =======================
       |  RENDER
       ======================= */
    public function render()
    {
        return view('livewire.project-tasks');
    }
}
