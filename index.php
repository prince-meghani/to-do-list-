<?php
$conn = new mysqli("localhost","root","","todo_app");

// Add
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    if ($task != "") {
        $conn->query("INSERT INTO tasks (task) VALUES ('$task')");
    }
    header("Location: index.php");
}



// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tasks WHERE id=$id");
    header("Location: index.php");
}


// Edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = $conn->query("SELECT * FROM tasks WHERE id=$id")->fetch_assoc();
}


// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $conn->query("UPDATE tasks SET task='$task' WHERE id=$id");
    header("Location: index.php");
}


// Get all
$tasks = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple To-Do</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 40px;
        }
        .box {
            width: 420px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type=text] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 15px;
            border: none;
            background: #28a745;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
        ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        li {
            background: #e5e5e5ff;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        a {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 4px;
            color: white;
        }
        .edit {
            background: #ffc107;
        }
        .delete {
            background: #dc3545;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>To-Do List</h2>

    <form method="POST">
        <input type="text" name="task" 
               value="<?= $edit ? $edit['task'] : '' ?>" required>

        <?php if ($edit) { ?>
            <input type="hidden" name="id" value="<?= $edit['id'] ?>">
            <button name="update">Update</button>
        <?php } else { ?>
            <button name="add">Add</button>
        <?php } ?>
    </form>

    <ul>
        <?php while($row = $tasks->fetch_assoc()) { ?>
            <li>
                <?= $row['task'] ?>

                <div>
                    <a class="edit" href="?edit=<?= $row['id'] ?>">Edit</a>
                    <a class="delete" href="?delete=<?= $row['id'] ?>">Done</a>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>

</body>
</html>
