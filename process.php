<?php
require_once('connection.php');
session_start();

function inject_debug($message)
{
    echo '<script>alert("' . $message . '");</script>';
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'editguest') {
        $guestId = $_POST['guest_id'];
        $fname = $_POST['Fname'];
        $mname = $_POST['Mname'];
        $lname = $_POST['Lname'];
        $phone = $_POST['phone'];
        $status = $_POST['status'];

        // $age = $_POST['age'];
        // $gender = $_POST['gender'];
        // debug
        // echo '<script>alert("Editing data: ' . $gender . '");</script>';
        // exit();
        if (empty($fname)) {
            $errors['fname'] = "First name is required.";
        }

        if (empty($lname)) {
            $errors['lname'] = "Last name is required.";
        }

        if (empty($phone)) {
            $errors['phone'] = "Phone number is required.";
        }

        if (empty($status)) {
            $errors['status'] = "No status found.";
        }

        // if (empty($age)) {
        //     $errors['age'] = "Age is required.";
        // }

        // if (empty($gender)) {
        //     $errors['gender'] = "Gender is required.";
        // }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['input'] = $_POST;
            $_SESSION['flash-msg'] = 'error-edit';
            header("Location: menu.php?page=guestlist");
            die();
        }

        $sql = "UPDATE guest SET " .
            "FIRSTNAME = '" . $fname . "', MIDDLEINITIAL = '" . $mname . "', LASTNAME = '" . $lname . "', PHONENUMBER = '" . $phone . "', STATUS = '" . $status . "' WHERE GUESTID = '" . $guestId . "';";

        // inject_debug($sql);
        // exit();
        if ($conn->query($sql) === TRUE) {
            unset($_SESSION['input']);
            unset($_SESSION['errors']);
            $_SESSION['flash-msg'] = 'success-edit';
            header("Location: menu.php?page=guestlist");
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else if ($_POST['action'] == 'editreservation') {
        $reservationId = $_POST['reservation_id'];
        $reservationHrs = $_POST['reservation_hrs'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $addons = $_POST['addons'];
        $status = $_POST['status'];

        if (empty($reservationHrs)) {
            $errors['reservationHrs'] = "Reservation Hours is required.";
        }

        if (empty($checkin)) {
            $errors['checkin'] = "Check-In is required.";
        }

        if (empty($checkout)) {
            $errors['checkout'] = "Check-Out is required.";
        }

        if (empty($addons)) {
            $errors['addons'] = "Addons is required.";
        }

        if (empty($status)) {
            $errors['status'] = "Status is required.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['input'] = $_POST;
            $_SESSION['flash-msg'] = 'error-edit';
            header("Location: menu.php?page=reservations");
            die();
        }

        $sql = "UPDATE reservations SET reservation_hrs = '" . $reservationHrs . "', checkin = '" . $checkin . "', checkout = '" . $checkout . "', status = '" . $status . "' WHERE reservation_id = '" . $reservationId . "'";

        if ($conn->query($sql) === TRUE) {
            unset($_SESSION['input']);
            unset($_SESSION['errors']);
            $_SESSION['flash-msg'] = 'success-edit';
            header("Location: menu.php?page=reservations");
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($_POST['action'] == 'editsale') {
        $paymentId = $_POST['payment_id'];
        $price = $_POST['price'];
        $paymentstatus = $_POST['status_payment'];
        $roomstatus = $_POST['status_room'];

        if (empty($price)) {
            $errors['price'] = "Price is required.";
        }

        if (empty($paymentstatus)) {
            $errors['paymentStatus'] = "Payment Status is required.";
        }

        if (empty($roomstatus)) {
            $errors['roomStatus'] = "Room Status is required.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['input'] = $_POST;
            $_SESSION['flash-msg'] = 'error-edit';
            header("Location: menu.php?page=sales");
            die();
        }

        $sql = "UPDATE sales SET price = '" . $price . "', status_payment = '" . $paymentstatus . "', status_room = '" . $roomstatus . "' WHERE payment_id = '" . $paymentId . "'";

        if ($conn->query($sql) === TRUE) {
            unset($_SESSION['input']);
            unset($_SESSION['errors']);
            $_SESSION['flash-msg'] = 'success-edit';
            header("Location: menu.php?page=sales");
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($_POST['action'] == 'changepass') {
        $currentPass = $_POST['current_pass'];
        $newPass = $_POST['new_pass'];
        $confirmPass = $_POST['confirm_pass'];

        if (empty($currentPass)) {
            $errors['currentPass'] = "Current Password is required.";
        }

        if (empty($newPass)) {
            $errors['newPass'] = "New Password is required.";
        }

        if (empty($confirmPass)) {
            $errors['confirmPass'] = "Confirm Password is required.";
        } elseif ($newPass !== $confirmPass) {
            $errors['confirmPass'] = "New Password and Confirm Password do not match.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['input'] = $_POST;
            header("Location: menu.php?page=settings");
            die();
        }

        $sql = "SELECT * FROM login WHERE username = '" . $_SESSION['username'] . "' AND password = '" . $currentPass . "'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {

            $sql = "UPDATE login SET password = '" . $newPass . "' WHERE username = '" . $_SESSION['username'] . "'";

            if ($conn->query($sql) === TRUE) {
                unset($_SESSION['input']);
                unset($_SESSION['errors']);
                $_SESSION['flash-msg'] = 'success-changepass';
                header("Location: menu.php?page=settings");
                die();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $_SESSION['flash-msg'] = 'error-changepass';
            header("Location: menu.php?page=settings");
            die();
        }
    } else {
        die();
        header("Location: menu.php?page=error");
    }
}

if (isset($_GET['action'])) {
    $get_action = $_GET['action'];
    $data_id = $_GET['id'];
    $is_using_optimized_algo = TRUE;

    $table_name = '';
    $table_id_name = '';
    $page_fallback = '';

    switch ($get_action) {
        case 'deleteguest':
            // flag for legacy code
            $is_using_optimized_algo = FALSE;
            $guestId = $_GET['guest_id'];
            if (!isset($guestId) || empty(($guestId))) {
                echo '<script>console.log("Deleting guest error for : ' . $guestId . '");</script>';
                echo "Error: " . $sql . "<br>" . $conn->error;
                exit();
            }
            $sql = "DELETE FROM guest WHERE GUESTID = '" . $guestId . "'";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['flash-msg'] = 'success-delete';
                header("Location: menu.php?page=guestlist");
                die();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            break;


        case 'deleteShortTime':
            $table_name = 'shortime';
            $table_id_name = 'RESERVATIONID';
            $page_fallback = 'bookings&type=shortTime';
            break;
        case 'deleteOvernight':
            $table_name = 'overnight';
            $table_id_name = 'RESERVATIONID';
            $page_fallback = 'bookings&type=overnight';
            break;
        case 'deleteDaily':
            $table_name = 'daily';
            $table_id_name = 'RESERVATIONID';
            $page_fallback = 'bookings&type=daily';
            break;
        case 'deleteMainAddons':
            $table_name = 'adds_on';
            $table_id_name = 'ADDSONID';
            $page_fallback = 'additionals&type=mainAddons';
            break;
        case 'deleteGuestAddons':
            $table_name = 'guest_addson';
            $table_id_name = 'RESERVATIONID';
            $page_fallback = 'additionals&type=guestAddons';
            break;
        case 'deleteSales':
            $table_name = 'payment';
            $table_id_name = 'PAYMENTID';
            $page_fallback = 'sales';
            break;
        case 'logout':
            $is_using_optimized_algo = FALSE;
            session_start();
            session_unset();
            session_destroy();
            header("Location: index.php");
            die();
    }

    if ($is_using_optimized_algo) {
        $sql = "DELETE FROM " . $table_name . " WHERE " . $table_id_name . " = '" . $data_id . "';";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['flash-msg'] = 'success-delete';
            header("Location: menu.php?page=" . $page_fallback);
            die();
        }
    }

    // if ($_GET['action'] == 'deleteguest') {
    //     $guestId = $_GET['guest_id'];
    //     if (!isset($guestId) || empty(($guestId))) {
    //         echo '<script>console.log("Deleting guest error for : ' . $guestId . '");</script>';
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //         exit();
    //     }
    //     $sql = "DELETE FROM guest WHERE GUESTID = '" . $guestId . "'";

    //     if ($conn->query($sql) === TRUE) {
    //         $_SESSION['flash-msg'] = 'success-delete';
    //         header("Location: menu.php?page=guestlist");
    //         die();
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //     }
    // } else if ($_GET['action'] == 'deletereservation') {
    //     $reservationId = $_GET['reservation_id'];

    //     $sql = "DELETE FROM reservations WHERE reservation_id = '" . $reservationId . "'";

    //     if ($conn->query($sql) === TRUE) {
    //         $_SESSION['flash-msg'] = 'success-delete';
    //         header("Location: menu.php?page=reservations");
    //         die();
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //     }
    // } else if ($_GET['action'] == 'deletesale') {
    //     $paymentId = $_GET['payment_id'];

    //     $sql = "DELETE FROM sales WHERE payment_id = '" . $paymentId . "'";

    //     if ($conn->query($sql) === TRUE) {
    //         $_SESSION['flash-msg'] = 'success-delete';
    //         header("Location: menu.php?page=sales");
    //         die();
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //     }
} else if ($_GET['action'] == 'logout') {
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    die();
}
