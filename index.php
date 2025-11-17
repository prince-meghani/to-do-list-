<?php
$conn = new mysqli("localhost","root","","todo_app");

// Add
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($title != "" && $description != "") {
        $conn->query("INSERT INTO tasks (title, description) VALUES ('$title', '$description')");
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
    $title = $_POST['title'];
    $description = $_POST['description'];

    $conn->query("UPDATE tasks SET title='$title', description='$description' WHERE id=$id");
    header("Location: index.php");
}

// Get all
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
            width: 450px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type=text], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 10px;
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
            background: #e5e5e5;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        a {
            text-decoration: none;
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
        }
        .edit { background: #ffc107; }
        .delete { background: #dc3545; }
        .title { font-weight: bold; font-size: 16px; }
        .desc { font-size: 14px; color: #555; margin-top: 4px; }
    </style>
</head>

<body>

<div class="box">
    <h2>To-Do List</h2>

    <form method="POST">
        <input type="text" name="title" placeholder="Enter Title"
               value="<?= $edit ? $edit['title'] : '' ?>" required>

        <textarea name="description" rows="2" placeholder="Enter Description" required><?= $edit ? $edit['description'] : '' ?></textarea>

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
                <div class="title"><?= $row['title'] ?></div>
                <div class="desc"><?= $row['description'] ?></div>

                <br>

                <a class="edit" href="?edit=<?= $row['id'] ?>">Edit</a>
                <a class="delete" href="?delete=<?= $row['id'] ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>
</div>

</body>
</html>
