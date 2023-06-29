<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form action="control.php" method="post">
            <div class="mb-3">
                <label for="todoListText" class="form-label">Insert Todo's</label>
                <input type="text" class="form-control" id="todoListText" name="valueTodo">
            </div>
            <div class="mb-3">
                <input type="hidden" name="action" value="insert">
                <button type="submit" class="btn btn-primary">Insert</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Todo</th>
                        <th scope="col">Condition</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'control.php';
                    $counter = 1;
                    $result = readTodo();
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <th scope="row"><?= $counter ?></th>
                            <?php
                            if ($row['status'] === 0) {
                            ?>
                                <td style="text-decoration: line-through;"><?php echo $row['value'] ?></td>
                            <?php
                            } else {
                            ?>
                                <td><?php echo $row['value'] ?></td>
                            <?php
                            }
                            ?>
                            <td>
                                <form action="control.php" method="post">
                                    <input type="hidden" name="data" value="<?= $row['id'] ?>>">
                                    <button type="submit" class="btn btn-danger" name="action" value="hapus">hapus</button>
                                    <button type="submit" class="btn btn-success" name="action" value="selesai">selesai</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                        $counter++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <form action="control.php" method="get">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="btn btn-primary">Logout</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>