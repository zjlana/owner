<div class="w-100 h-100 p-3 bg-white rounded">
    <h1 class="fw-bold text-secondary">Reservations</h1>
    <hr>
    <table class="table table-striped table-hover" id="reservationTable">
        <thead>
            <tr>
                <th class="bg-success text-white">Reservation No</th>
                <th class="bg-success text-white">Reservation Hours</th>
                <th class="bg-success text-white">Guest Name</th>
                <th class="bg-success text-white">Check-In</th>
                <th class="bg-success text-white">Check-Out</th>
                <th class="bg-success text-white">Addons</th>
                <th class="bg-success text-white">Status</th>
                <th class="bg-success text-white text-center">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT * FROM reservations JOIN guest ON reservations.guest_id = guest.guest_id";
            $result = $conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                        echo"<tr>";
                        echo"<td>".$row['reservation_id']."</td>";
                        echo"<td class='text-capitalize'>".$row['reservation_hrs']."</td>";
                        echo"<td class='text-capitalize'>".$row['Fname']." ".$row['Lname']."</td>";
                        echo"<td>".$row['checkin']."</td>";
                        echo"<td>".$row['checkout']."</td>";
                        echo"<td class='text-capitalize'>".$row['addons']."</td>";
                        echo "<td width='160px'>" . ($row['status'] == '1' ? "<p class='bg-success text-white rounded-pill text-center'>Vacant</p>" : "<p class='bg-danger text-white rounded-pill text-center'>Occupied</p>") . "</td>";
                        echo "<td class='d-flex justify-content-evenly'>
                            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-reservation-id='".$row['reservation_id']."' data-reservationhrs='".$row['reservation_hrs']."' data-checkin='".$row['checkin']."' data-checkout='".$row['checkout']."' data-addons='".$row['addons']."' data-status='".$row['status']."'><i class='bx bx-edit-alt'></i></button>
                            <button type='button' class='btn btn-danger'  data-bs-toggle='modal' data-bs-target='#delModal' data-reservation-id='".$row['reservation_id']."'><i class='bx bx-trash' ></i></button>
                            </td>";
                        echo"</tr>";
                    }
                }
        ?>
        </tbody>
    </table>    
</div>

<!----- EDIT MODAL ----->

<div class="modal fade" tabindex="-1" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Reservation</h5>
            </div>
            <div class="modal-body">
                <form action="./process.php" method="POST">
                    <input type="text" name="action" class="d-none" value="editreservation">
                    <input type="text" name="reservation_id" id="reservationId" class="d-none">
                    <div class="mb-3">
                        <p class="m-0">Reservation Hours</p>
                        <input type="text" name="reservation_hrs" id="reservationHrs" class="form-control bg-input">
                        <?php if(isset($_SESSION['errors']['reservationHrs'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['reservationHrs']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <p class="m-0">Check-In</p>
                        <input type="datetime-local" name="checkin" id="checkin" class="form-control bg-input">
                        <?php if(isset($_SESSION['errors']['checkin'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['checkin']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <p class="m-0">Check-Out</p>
                        <input type="datetime-local" name="checkout" id="checkout" class="form-control bg-input">
                        <?php if(isset($_SESSION['errors']['checkout'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['checkout']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <p class="m-0">Addons</p>
                        <input type="text" name="addons" id="addons" class="form-control bg-input">
                        <?php if(isset($_SESSION['errors']['addons'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['addons']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <p class="m-0">Status</p>
                        <select name="status" id="status" class="form-select bg-input">
                            <option value="1">Vacant</option>
                            <option value="2">Occupied</option>
                        </select>
                        <?php if(isset($_SESSION['errors']['status'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['status']; ?></div>
                        <?php } ?>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!----- DELETE MODAL ----->

<div class="modal fade" tabindex="-1" id="delModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <i class='bx bx-info-circle fs-1 text-danger'></i>
                <p class="fs-5 fw-semibold m-0">Are you sure you want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <a id="deleteLink" href="#"><button type="button" class="btn btn-danger">Yes</button></a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!----- PASS DATA TO EDIT MODAL SCRIPT ----->

<script>
    $(document).ready(function(){
        $('#editModal').on('show.bs.modal', function(event){
            let button = $(event.relatedTarget);
            let reservationId = button.data('reservation-id');
            let reservationHrs = button.data('reservationhrs');
            let checkin = button.data('checkin');
            let checkout = button.data('checkout');
            let addons = button.data('addons');
            let status = button.data('status');

            // Set values in the modal inputs
            $('#reservationId').val(reservationId);
            $('#reservationHrs').val(reservationHrs);
            $('#checkin').val(checkin);
            $('#checkout').val(checkout);
            $('#addons').val(addons);

            // Set status dropdown based on value
            $('#status').val(status);
        });
    });
</script>

<!----- PASS DATA TO DELETE MODAL SCRIPT ----->

<script>
    $(document).ready(function(){
        $('#delModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget); 
            let reservationId = button.data('reservation-id');
            let deleteLink = $('#deleteLink');
            deleteLink.attr('href', './process.php?action=deletereservation&reservation_id=' + reservationId);
        });
    });
</script>

<!----- DATATABLES SCRIPT ----->

<script>
    $(document).ready(function() {
        $('#reservationTable').DataTable({
            "pagingType": "full_numbers",
            "lengthChange": false
        });
    });
</script>
