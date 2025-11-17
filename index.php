<?php
$conn = new mysqli("localhost","root","","todo_app");

//add
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    if ($task != "") {
        $conn->query("INSERT INTO tasks (task) VALUES ('$task')");
    }
}

//delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tasks WHERE id=$id");
    header("Location: index.php");
    exit;
}

//edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM tasks WHERE id=$id")->fetch_assoc();
}

//update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $conn->query("UPDATE tasks SET task='$task' WHERE id=$id");
    header("Location: index.php");
    exit;
}


$tasks = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>

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
            padding: 25px;
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
            background: #f8f8f8;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .editBtn {
            background: #ffc107;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .deleteBtn {
            background: #dc3545;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
        }
        .btns {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>To-Do List</h2>

    
    <form method="POST">
        <input type="text" name="task" 
               value="<?= $editData ? $editData['task'] : '' ?>" 
               placeholder="Enter task..." required>

        <?php if ($editData) { ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <button name="update">Update</button>
        <?php } else { ?>
            <button name="add">Add</button>
        <?php } ?>
    </form>

    
    <ul>
        <?php while($row = $tasks->fetch_assoc()) { ?>
            <li>
                <?= $row['task'] ?>

                <div class="btns">
                    <a href="?edit=<?= $row['id'] ?>">
                        <button class="editBtn">Edit</button>
                    </a>

                    <a href="?delete=<?= $row['id'] ?>">
                        <button class="deleteBtn">Delete</button>
                    </a>
                </div>
            </li>
        <?php } ?>
    </ul>

</div>

</body>
</html>
