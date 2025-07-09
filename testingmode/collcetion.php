<?php
require_once '../Navbar.php';
require_once '../config.php';

$SelUser = array('email' => '', 'phone' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["username"])) {
        $selectedUsername = $_POST["username"];
        $selectUser = "SELECT * FROM auth WHERE username = '$selectedUsername'";
        $userData = mysqli_query($conn, $selectUser);

        if ($userData && mysqli_num_rows($userData) > 0) {
            $SelUser = mysqli_fetch_assoc($userData);
        }
    }
}

// Fetch all users
$selectUser = "SELECT * FROM auth";
$userData = mysqli_query($conn, $selectUser);
?>

<div class="container-fluid d-flex justify-content-center">
    <div class="col-md-5 mt-5">
        <form id="userForm">
            <div class="form-group">
                <select name="username" id="username" class="form-select input" required onchange="fetchUserData()">
                    <option selected disabled value="">-- Select Username --</option>
                    <?php
                    while ($user = mysqli_fetch_assoc($userData)) {
                        echo "<option value='" . $user['username'] . "'>" . $user['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" id="email" name="email" class="form-control input" value="<?php echo $SelUser['email'] ?>" placeholder="Email" />
            </div>
            <div class="form-group">
                <input type="text" id="phone" name="phone" class="form-control input" value="<?php echo $SelUser['phone'] ?>" placeholder="Phone" />
            </div>
        </form>
    </div>
</div>

<script>
    function fetchUserData() {
        var selectedUsername = document.getElementById('username').value;
        var formData = new FormData();
        formData.append('username', selectedUsername);

        fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                var parser = new DOMParser();
                var htmlDoc = parser.parseFromString(data, 'text/html');
                var email = htmlDoc.getElementById('email').value;
                var phone = htmlDoc.getElementById('phone').value;

                document.getElementById('email').value = email;
                document.getElementById('phone').value = phone;
            })
            .catch(error => console.error('Error:', error));
    }
</script>