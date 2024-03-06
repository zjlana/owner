<?php
// Short Time
$bookings_shorttime_table_headers = array(
    "Reservation ID",
    "Guest ID",
    "Room Number",
    "Check-in",
    "Check-out",
);

$bookings_shorttime_sql_query_fetch = "SELECT * FROM shortime;";

// Overnight
$bookings_overnight_table_headers = array(
    "Reservation ID",
    "Guest ID",
    "Book Date",
    "Room Number",
    "Check-in",
    "Check-out",
    "Status",
);

$bookings_overnight_sql_query_fetch = "SELECT * FROM overnight;";

// Daily
$bookings_daily_table_headers = array(
    "Reservation ID",
    "Guest ID",
    "Book Date",
    "Room Number",
    "Check-in",
    "Check-out",
    "Status",
);

$bookings_daily_sql_query_fetch = "SELECT * FROM daily;";


function populatePage($ui_title, $usable_id, $headers, $sql_query_fetch)
{
    // includes
    include("connection.php");

    echo ' <div class="h-100 p-3 bg-white rounded">';
    echo '     <h1 class="fw-bold text-secondary">' . $ui_title . '</h1>';
    echo '     <hr>';
    echo '     <table class="table table-striped table-hover" id="mainTable">';
    echo '         <thead>';
    echo '             <tr>';
    foreach ($headers as $header) {
        echo '<th scope="col" class="bg-success text-white">' . $header . '</th>';
    }
    echo '<th scope="col" class="bg-success text-white">' . "Action" . '</th>';
    echo '            </tr>';
    echo '        </thead>';
    echo '        <tbody>';
    $result = $conn->query($sql_query_fetch);
    $length = count($headers);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_row()) {
            echo '<tr>';
            for ($i = 0; $i < $length; $i++) {
                echo '  <td>' . $row[$i] . '</td>';
            }

            echo '<td class="d-flex justify-content-evenly">';

            // Edit Button
            // echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" ' .
            // 'data-bs-target="' . '#editModal' . '" ';
            // for ($i = 0; $i < $length; $i++) {
            //     echo 'data-' . $i . '="' . $row[$i] . '" ';
            // }
            // echo '>' . 
            // '<span class="bx bx-edit-alt"></span></button>';

            // Delete Button
            echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" ' .
                'data-bs-target="#delModal" ' .
                'data-id="' . $row[0] . '">' .

                '<span class="bx bx-trash"></span></button>';

            echo '</td>';

            echo '</tr>';
        }
    }
    echo '         </tbody>';
    echo '     </table>';
    echo ' </div>';
    echo ' ';
    echo ' <!-- Edit Modal -->';
    echo ' ';
    echo ' <!-- Delete Modal -->';
    echo ' <div class="modal fade" tabindex="-1" id="delModal">';
    echo '     <div class="modal-dialog modal-dialog-centered">';
    echo '         <div class="modal-content">';
    echo '             <div class="modal-body text-center">';
    echo '                 <span class="bx bx-info-circle fs-1 text-danger"></span>';
    echo '                 <p class="fs-5 fw-semibold m-0">Are you sure you want to delete this item?</p>';
    echo '             </div>';
    echo '             <div class="modal-footer">';
    echo '                 <a class="btn btn-danger" id="deleteLink" href="#" role="button">Yes</a>';
    echo '                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>';
    echo '             </div>';
    echo '         </div>';
    echo '     </div>';
    echo ' </div>';
    echo ' ';
    echo ' <!-- Deletion Logic -->';
    echo ' <script>';
    echo '     $(document).ready(function() {';
    echo '         $("#delModal").on("show.bs.modal", function(event) {';
    echo '             let button = $(event.relatedTarget);';
    echo '             let dataId = button.data("id");';
    echo '             let deleteLink = $("#deleteLink");';
    echo '             deleteLink.attr("href", "./process.php?action=delete' . $usable_id . '&id=" + dataId);';
    echo '             console.log("Preparing to delete: " + dataId);';
    echo '         });';
    echo '     });';
    echo ' </script>';
    echo ' ';
    echo ' <!----- SEARCH ----->';
    echo ' <script>';
    echo '     $(document).ready(function() {';
    echo '         $("#mainTable").DataTable({';
    echo '             "pagingType": "full_numbers",';
    echo '             "lengthChange": true';
    echo '         });';
    echo '     });';
    echo ' </script>';
}

$get_page_type = $_GET['type'];
switch ($get_page_type) {
    case 'shortTime':
        populatePage("Short Time", "ShortTime", $bookings_shorttime_table_headers, $bookings_shorttime_sql_query_fetch);
        break;
    case 'overnight':
        populatePage("Overnight", "Overnight", $bookings_overnight_table_headers, $bookings_overnight_sql_query_fetch);
        break;
    case 'daily':
        populatePage("Daily", "Daily", $bookings_daily_table_headers, $bookings_daily_sql_query_fetch);
        break;
    default:
        populatePage("Short Time", "ShortTime", $bookings_shorttime_table_headers, $bookings_shorttime_sql_query_fetch);
}
