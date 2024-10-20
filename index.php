<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $task_date = $_POST['task_date'];

    if (!empty($task_name) && !empty($task_date)) {
        $stmt = $conn->prepare('INSERT INTO tasks (task_name, created_At) VALUES (?, ?)');
        $stmt->bind_param('ss', $task_name, $task_date);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
        exit();
    }
}


$open_tasks = $conn->query('SELECT * FROM tasks WHERE is_completed = 0');
$closed_tasks = $conn->query('SELECT * FROM tasks WHERE is_completed = 1');
$inProgress_tasks = $conn->query('SELECT * FROM tasks WHERE is_completed = 2');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO LIST | By Yassir Benjima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5"> To Do List | By Yassir Benjima</h1>
        <form class="mb-4" action="index.php" method="POST">
            <div class="input-group mb-3">
                <div class="row w-100">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="task_name" placeholder="New Task" required>
                    </div>
                    <div class="col-md-4">
                        <input type="datetime-local" class="form-control" name="task_date" placeholder="Due Date and Time" required>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>


        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Open Tasks</h2>
                <ul class="list-group">
                    <?php
                    if ($open_tasks->num_rows > 0) {
                        while ($row = $open_tasks->fetch_assoc()) {
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $row['task_name']; ?> | <?php echo $row['created_At']; ?>
                                <div>
                                    <a href="inProgress_task.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">In Progress</a>
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Complete</a>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </li>

                    <?php
                        }
                    } else {
                        echo "<li class='list-group-item'>No tasks found</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="col-md-6">
                <h2 class="text-center">In Progress Tasks</h2>
                <ul class="list-group">
                    <?php
                    if ($inProgress_tasks->num_rows > 0) {
                        while ($row = $inProgress_tasks->fetch_assoc()) {
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $row['task_name']; ?>
                                <div>
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Complete</a>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </li>
                    <?php
                        }
                    } else {
                        echo "<li class='list-group-item'>No tasks in progerss found</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <h2 class="text-center">Closed Tasks</h2>
                <ul class="list-group">
                    <?php
                    if ($closed_tasks->num_rows > 0) {
                        while ($row = $closed_tasks->fetch_assoc()) {
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $row['task_name']; ?>
                                <div>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </li>
                    <?php
                        }
                    } else {
                        echo "<li class='list-group-item'>No closed tasks found</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>