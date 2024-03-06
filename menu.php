<?php

include('connection.php');
include('session.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="./datatables/datatables.min.css" rel="stylesheet">
  <script src="./datatables/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="./CSS/bootstrap/css/bootstrap.min.css">
  <script src="./CSS/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="CSS/style2.css">
  <link rel="stylesheet" href="CSS/sidebarstyle.css">

  <title> Dashboard Sidebar MENU </title>
</head>

<body>
  <div class="d-flex">

    <?php include('sidebar.php'); ?>

    <div class="margin-left">
      <?php
      // fixed this one :D

      // if (isset($_GET['page'])) {
      //   if ($_GET['page'] == 'guestlist') {
      //     include('guestlist.php');
      //   } else if ($_GET['page'] == 'bookings') {
      //     include('bookings.php');
      //   } else if ($_GET['page'] == 'sales') {
      //     include('sales.php');
      //   } else if ($_GET['page'] == 'settings') {
      //     include('settings.php');
      //   } else {
      //     include('error.php');
      //   }
      // } else {
      //   include('guestlist.php');
      // }

      $get_page = $_GET['page'];
      if (isset($_GET['page'])) {
        switch ($get_page) {
          case 'guestlist':
            include('guestlist.php');
            break;
          case 'bookings':
            include('bookings.php');
            break;
          case 'additionals':
            include('additionals.php');
            break;
          case 'sales':
            include('newsales.php');
            break;
          case 'settings':
            include('settings.php');
            break;
          default:
            include('error.php');
        }
      } else {
        include('guestlist.php');
      }


      ?>
    </div>
  </div>

  <!----- SWEETALERTS SCRIPT ----->

  <?php
  if (isset($_SESSION['flash-msg'])) {
    if ($_SESSION['flash-msg'] == 'success-edit') {
      echo "
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Item edited successfully',
                showConfirmButton: false,
                timer: 2500,
                heightAuto: false
                })
            </script>
            ";
      unset($_SESSION['flash-msg']);
    } elseif ($_SESSION['flash-msg'] == 'success-delete') {
      echo "
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Item deleted successfully',
                showConfirmButton: false,
                timer: 2500,
                heightAuto: false
                })
            </script>
            ";
      unset($_SESSION['flash-msg']);
    } elseif ($_SESSION['flash-msg'] == 'error-edit') {
      echo "
          <script>
          Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Please try again',
              showConfirmButton: false,
              timer: 2500,
              heightAuto: false
              })
          </script>
          ";
      unset($_SESSION['flash-msg']);
    } elseif ($_SESSION['flash-msg'] == 'error-changepass') {
      echo "
          <script>
          Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Invalid current password',
              showConfirmButton: false,
              timer: 2500,
              heightAuto: false
              })
          </script>
          ";
      unset($_SESSION['flash-msg']);
    } elseif ($_SESSION['flash-msg'] == 'success-changepass') {
      echo "
          <script>
          Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Password changed successfully',
              showConfirmButton: false,
              timer: 2500,
              heightAuto: false
              })
          </script>
          ";
      unset($_SESSION['flash-msg']);
    }
  }
  ?>

</body>

</html>