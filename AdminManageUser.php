<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

</head>

<body>

    <?php

    if (!isset($_SESSION['username']) || $USER['user_role'] !== 'admin') {
        echo "<script>window.location.href='error-002.php?allowRedirect=true';</script>";
        exit();
    }

    $sql = "SELECT * FROM auth";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { ?>
        <div class="container-fluid mt-2">
            <table class="user-table col-md-12">
                <thead>
                    <tr>
                        <th>UI</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Join Date & Time</th>
                        <th>User Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display each row of user data
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td> <img src="<?php echo $row['userimage'] ?>" height="20px"> </td>
                            <td> <?php echo $row['username'] ?></td>
                            <td> <?php echo $row['firstname'] ?></td>
                            <td> <?php echo $row['lastname'] ?></td>
                            <td> <?php echo $row['email'] ?></td>
                            <td> <?php echo $row['phone'] ?></td>
                            <td> <?php echo $row['gender'] ?></td>
                            <td> <?php echo $row['joindate'] ?> <?php echo $row['jointime'] ?></td>
                            <td> <?php echo $row['user_role'] ?></td>
                            <td>
                                <button class="btn btn-secondary me-2" onclick="openUser('<?php echo $row['username'] ?>')"><i class='bi bi-pencil-fill'></i></button>
                                <a href="Functions/deleteUser.php?username=<?php echo $row['username'] ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                            </td>
                        </tr>

                        <?php
                        // Modal
                        echo "
                            <div id='User_$row[username]' class='modal'>
                                <div class='modal-content col-md-4'> 
                                <span class='close' onclick='closeUser(\"$row[username]\")'>&times;</span>
                                <form action='Functions/editUserRole.php' method='post'>
                                    <input type='hidden' name='username' value='$row[username]'>
                                    <label for='userRole'>Update User Role</label>
                                    <select name='userRole' class='form-select input' id='userRole'>
                                        <option value='admin' " . ($row['user_role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                        <option class='mb-2' value='user' " . ($row['user_role'] == 'user' ? 'selected' : '') . ">User</option>
                                        <option class='mb-2' value='contentmanager' " . ($row['user_role'] == 'contentmanager' ? 'selected' : '') . ">Content Manager</option>
                                    </select>
                                    <br>
                                    <button type='submit' class='btn btn-secondary'>Update</button>
                                </form>
                                </div>
                            </div>
                            ";
                        ?>

                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } ?>

    <script>
        function openUser(username) {
            $('#User_' + username).show();
        }

        function closeUser(username) {
            $('#User_' + username).hide();
        }
    </script>


    <script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>