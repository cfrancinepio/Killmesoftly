<?php
// ==============================
// CoCurr System (Final PHP Version)
// ==============================

// USER CLASS
class User {
    private $userID;
    private $username;
    private $password;
    private $email;

    public function __construct($userID, $username, $password, $email) {
        $this->userID = $userID;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function login() {
        echo "✅ User <b>$this->username</b> logged in.<br>";
    }

    public function logout() {
        echo "🚪 User <b>$this->username</b> logged out.<br>";
    }

    public function register() {
        echo "🧾 User <b>$this->username</b> registered successfully.<br>";
    }
}

// TASK CLASS
class Task {
    private $taskID;
    private $taskTitle;
    private $taskDescription;
    private $dueDate;
    private $taskStatus;
    private $taskCourse; // Related to Course

    public function __construct($taskID, $taskTitle, $desc, $dueDate, $taskCourse) {
        $this->taskID = $taskID;
        $this->taskTitle = $taskTitle;
        $this->taskDescription = $desc;
        $this->dueDate = $dueDate;
        $this->taskStatus = false; // Default: not completed
        $this->taskCourse = $taskCourse;
    }

    public function completed() {
        $this->taskStatus = true;
    }

    public function updateDetails($newTitle, $newDesc, $newDueDate) {
        $this->taskTitle = $newTitle;
        $this->taskDescription = $newDesc;
        $this->dueDate = $newDueDate;
    }

    public function getStatus() {
        return $this->taskStatus ? "✅ Completed" : "🕓 Pending";
    }

    public function getTaskTitle() {
        return $this->taskTitle;
    }

    public function getTaskID() {
        return $this->taskID;
    }

    public function getCourse() {
        return $this->taskCourse;
    }

    public function __toString() {
        return "{$this->taskTitle} ({$this->getStatus()}) - {$this->dueDate}";
    }
}

// COURSE CLASS
class Course {
    private $courseID;
    private $courseName;
    private $description;
    private $teacher;
    private $time;
    private $day;

    public function __construct($id, $name, $desc, $teacher, $time, $day) {
        $this->courseID = $id;
        $this->courseName = $name;
        $this->description = $desc;
        $this->teacher = $teacher;
        $this->time = $time;
        $this->day = $day;
    }

    public function getCourse() {
        return $this->courseName;
    }

    public function updateDetails($desc, $teacher, $time, $day) {
        $this->description = $desc;
        $this->teacher = $teacher;
        $this->time = $time;
        $this->day = $day;
    }

    public function getSched() {
        return "{$this->day} at {$this->time}";
    }

    public function __toString() {
        return "{$this->courseName} ({$this->getSched()}) - {$this->teacher}";
    }
}

// TO-DO LIST CLASS (Manages multiple Tasks)
class ToDoList {
    private $tasks = [];

    // Add a task to the list
    public function addTask(Task $task) {
        $this->tasks[] = $task;
    }

    public function editTask($taskID, $newTitle, $newDesc, $newDueDate) {
        foreach ($this->tasks as $task) {
            if ($task->getTaskID() === $taskID) {
                $task->updateDetails($newTitle, $newDesc, $newDueDate);
            }
        }
    }

    public function deleteTask($taskID) {
        foreach ($this->tasks as $index => $task) {
            if ($task->getTaskID() === $taskID) {
                unset($this->tasks[$index]);
            }
        }
    }

    public function viewTasks() {
        echo "<h3>🗒️ To-Do List:</h3>";
        foreach ($this->tasks as $task) {
            echo "- " . $task . "<br>";
        }
    }

    public function toggleCompleted($index) {
        if (isset($this->tasks[$index])) {
            $this->tasks[$index]->completed();
        }
    }
}

// COURSE FOLDER CLASS (Manages multiple Courses)
class CourseFolder {
    private $courses = [];

    public function addCourse(Course $course) {
        $this->courses[] = $course;
    }

    public function editCourse($index, $desc, $teacher, $time, $day) {
        if (isset($this->courses[$index])) {
            $this->courses[$index]->updateDetails($desc, $teacher, $time, $day);
        }
    }

    public function deleteCourse($index) {
        if (isset($this->courses[$index])) {
            unset($this->courses[$index]);
        }
    }

    public function viewCourses() {
        echo "<h3>📚 Courses:</h3>";
        foreach ($this->courses as $course) {
            echo "- " . $course . "<br>";
        }
    }

    public function getCourses() {
        return $this->courses;
    }
}

// CALENDAR CLASS
class Calendar {
    private $calendarID;
    private $weekSchedule = [];

    public function __construct($id) {
        $this->calendarID = $id;
    }

    public function addToSchedule($day, $item) {
        $this->weekSchedule[$day][] = $item;
    }

    public function checkCalendarView() {
        echo "<h3>📅 Weekly Calendar:</h3>";
        foreach ($this->weekSchedule as $day => $items) {
            echo "<b>$day:</b><br>";
            foreach ($items as $item) {
                echo "- $item<br>";
            }
        }
    }
}

// ==============================
// TESTING SECTION
// ==============================

echo "<h2> CoCurr System Simulation</h2>";

// Create User
$user = new User(1, "Xavier", "1234", "xavier@example.com");
$user->register();
$user->login();

// Create Course Folder and Add Courses
$courseFolder = new CourseFolder();
$course1 = new Course(101, "Software Engineering", "Learn UML & SDLC", "Prof. Santos", "9:00 AM", "Monday");
$course2 = new Course(102, "Web Development", "Learn PHP & HTML", "Prof. Reyes", "11:00 AM", "Wednesday");
$courseFolder->addCourse($course1);
$courseFolder->addCourse($course2);

// Create To-Do List and Add Tasks
$todo = new ToDoList();
$task1 = new Task(1, "Finish UML Diagram", "Create CoCurr class diagram", "2025-11-01", $course1->getCourse());
$task2 = new Task(2, "Build PHP Prototype", "Develop PHP code for CoCurr", "2025-11-05", $course2->getCourse());
$todo->addTask($task1);
$todo->addTask($task2);

// Create Calendar and Add Entries
$calendar = new Calendar(1);
$calendar->addToSchedule("Monday", $course1);
$calendar->addToSchedule("Wednesday", $course2);
$calendar->addToSchedule("Tuesday", $task1);
$calendar->addToSchedule("Thursday", $task2);

// Display Everything
$courseFolder->viewCourses();
$todo->viewTasks();
$calendar->checkCalendarView();

$user->logout();
?>
