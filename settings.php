<div class="w-100 h-100 p-3 bg-white rounded">
    <h1 class="fw-bold text-secondary">Change Password</h1>
    <hr>
    <div class="d-flex h-75 w-100 mt-5">
        <div class="d-flex flex-column justify-content-center h-100 w-50 px-5">
            <form action="./process.php" method="POST" class="d-flex flex-column align-items-center">
                <input type="text" name="action" class="d-none" value="changepass">
                <div class="mb-3 w-100">
                    <p class="m-0">Current Password</p>
                    <input type="password" name="current_pass" id="reservationHrs" class="form-control bg-input" required>
                    <?php if(isset($_SESSION['errors']['currentPass'])) { ?>
                        <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['currentPass']; ?></div>
                    <?php } ?>
                </div>
                <div class="mb-3 w-100">
                    <p class="m-0">New Password</p>
                    <input type="password" name="new_pass" id="reservationHrs" class="form-control bg-input" required>
                    <?php if(isset($_SESSION['errors']['newPass'])) { ?>
                        <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['newPass']; ?></div>
                    <?php } ?>
                </div>
                <div class="mb-3 w-100">
                    <p class="m-0">Confirm New Password</p>
                    <input type="password" name="confirm_pass" id="reservationHrs" class="form-control bg-input" required>
                    <?php if(isset($_SESSION['errors']['confirmPass'])) { ?>
                        <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['confirmPass']; ?></div>
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-primary form-control w-50">Change</button>
            </form>
        </div>
        <div class="d-flex align-items-center h-100 w-50">
            <img src="./img/changepass.jpg" class="w-100">
        </div>
    </div>
</div>