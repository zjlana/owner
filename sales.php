<?php
$count_guest = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM guest"));
$count_rooms_reserve = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM room WHERE status = '2'"));
$count_rooms_sale = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM room WHERE STATUS = 'AVAILABLE'"));
$count_reservations = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM room;"));
$count_sales = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM payment"));
?>
<div class="w-100 h-25 p-3">
    <h1 class="fw-bold text-secondary">Sales</h1>
    <hr>
    <div class="row gap-3 mb-3">
        <div class="col bg-white rounded p-3">
            <p>Total Guests</p>
            <div class="d-flex justify-content-end align-items-center gap-2 text-secondary fw-bold fs-4">
                <i class='bx bx-group icon'></i>
                <p class="m-0"><?php echo $count_guest['COUNT(*)'] ?></p>
            </div>
        </div>
        <div class="col bg-white rounded p-3">
            <p>Total Occupied Rooms</p>
            <div class="d-flex justify-content-end align-items-center gap-2 text-secondary fw-bold fs-4">
                <i class='bx bx-hotel'></i>
                <p class="m-0"><?php echo $count_rooms_reserve['COUNT(*)'] + $count_rooms_sale['COUNT(*)'] ?></p>
            </div>
        </div>
        <div class="col bg-white rounded p-3">
            <p>Total Reservations</p>
            <div class="d-flex justify-content-end align-items-center gap-2 text-secondary fw-bold fs-4">
                <i class='bx bx-building icon fs-5'></i>
                <p class="m-0"><?php echo $count_reservations['COUNT(*)'] ?></p>
            </div>
        </div>
        <div class="col bg-white rounded p-3">
            <p>Total Sales</p>
            <div class="d-flex justify-content-end align-items-center gap-2 text-secondary fw-bold fs-4">
                <i class='bx bx-money icon fs-5'></i>
                <p class="m-0"><?php echo $count_sales['COUNT(*)'] ?></p>
            </div>
        </div>
    </div>
</div>
<div class="w-100 h-75 p-3 bg-white rounded">
    <table class="table table-striped table-hover" id="salesTable">
        <thead>
            <tr>
                <th class="bg-success text-white">Payment ID</th>
                <th class="bg-success text-white">Reservation ID</th>
                <th class="bg-success text-white">Guest Name</th>
                <th class="bg-success text-white">Price</th>
                <th class="bg-success text-white">Payment Status</th>
                <th class="bg-success text-white">Room Status</th>
                <th class="bg-success text-white text-center">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT * FROM sales JOIN guest ON sales.guest_id = guest.guest_id";
            $result = $conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                        echo"<tr>";
                        echo"<td>".$row['payment_id']."</td>";
                        echo"<td class='text-capitalize'>".($row['reservation_id'] == '' ? "<p>Walk-In</p>" : $row['reservation_id'])."</td>";
                        echo"<td class='text-capitalize'>".$row['Fname']." ".$row['Lname']."</td>";
                        echo"<td>".$row['price']."</td>";
                        echo "<td width='160px'>" . ($row['status_payment'] == '2' ? "<p class='bg-success text-white rounded-pill text-center'>Paid</p>" : "<p class='bg-danger text-white rounded-pill text-center'>Unpaid</p>") . "</td>";
                        echo "<td width='160px'>" . ($row['status_room'] == '1' ? "<p class='bg-success text-white rounded-pill text-center'>Vacant</p>" : "<p class='bg-danger text-white rounded-pill text-center'>Occupied</p>") . "</td>";
                        echo "<td class='d-flex justify-content-evenly'>
                            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-payment-id='".$row['payment_id']."' data-price='".$row['price']."' data-statuspayment='".$row['status_payment']."' data-statusroom='".$row['status_room']."'><i class='bx bx-edit-alt'></i></button>
                            <button type='button' class='btn btn-danger'  data-bs-toggle='modal' data-bs-target='#delModal' data-payment-id='".$row['payment_id']."'><i class='bx bx-trash' ></i></button>
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
                <h5 class="modal-title">Edit Sale</h5>
            </div>
            <div class="modal-body">
                <form action="./process.php" method="POST">
                    <input type="text" name="action" class="d-none" value="editsale">
                    <input type="text" name="payment_id" id="paymentId" class="d-none">
                    <div class="mb-3">
                        <p class="m-0">Price</p>
                        <input type="text" name="price" id="price" class="form-control bg-input">
                        <?php if(isset($_SESSION['errors']['price'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['price']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <p class="m-0">Payment Status</p>
                        <select name="status_payment" id="statusPayment" class="form-select bg-input">
                            <option value="1">Unpaid</option>
                            <option value="2">Paid</option>
                        </select>
                        <?php if(isset($_SESSION['errors']['paymentStatus'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['paymentStatus']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <p class="m-0">Room Status</p>
                        <select name="status_room" id="statusRoom" class="form-select bg-input">
                            <option value="1">Vacant</option>
                            <option value="2">Occupied</option>
                        </select>
                        <?php if(isset($_SESSION['errors']['roomStatus'])) { ?>
                            <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['roomStatus']; ?></div>
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
            let paymentId = button.data('payment-id');
            let price = button.data('price');
            let statusPayment = button.data('statuspayment'); 
            let statusRoom = button.data('statusroom'); 

            // Set values in the modal inputs
            $('#paymentId').val(paymentId);
            $('#price').val(price);

            // Set status dropdown based on value
            $('#statusPayment').val(statusPayment);
            $('#statusRoom').val(statusRoom);
        });
    });
</script>


<!----- PASS DATA TO DELETE MODAL SCRIPT ----->

<script>
    $(document).ready(function(){
        $('#delModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget); 
            let paymentId = button.data('payment-id');
            let deleteLink = $('#deleteLink');
            deleteLink.attr('href', './process.php?action=deletesale&payment_id=' + paymentId);
        });
    });
</script>

<!----- DATATABLES SCRIPT ----->

<script>
    $(document).ready(function() {
        $('#salesTable').DataTable({
            "pagingType": "full_numbers",
            "lengthChange": false
        });
    });
</script>
