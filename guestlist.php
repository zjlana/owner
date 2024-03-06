    <?php
    // use vars para kapag may changes sa table names
    // sa db, madali imodify
    $ns_db_tables = array(
        "GUESTID",
        "FIRSTNAME",
        "MIDDLEINITIAL",
        "LASTNAME",
        "PHONENUMBER",
        "STATUS",
    );
    ?>

    <div class="w-100 h-100 p-3 bg-white rounded">
        <h1 class="fw-bold text-secondary">Guest List</h1>
        <hr>
        <table class="table table-striped table-hover" id="guestTable">
            <thead>
                <tr>
                    <th class="bg-success text-white">Customer ID</th>
                    <th class="bg-success text-white">First Name</th>
                    <th class="bg-success text-white">Last Name</th>
                    <th class="bg-success text-white">Phone Number</th>
                    <!-- <th class="bg-success text-white">Age</th>
                    <th class="bg-success text-white">Gender</th> -->
                    <th class="bg-success text-white">Status</th>
                    <th class="bg-success text-white text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM guest";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row[$ns_db_tables[0]] . "</td>";
                        echo "<td class='text-capitalize'>" . $row[$ns_db_tables[1]] . "</td>";
                        echo "<td class='text-capitalize'>" . $row[$ns_db_tables[3]] . "</td>";
                        echo "<td class='text-capitalize'>" . $row[$ns_db_tables[4]] . "</td>";
                        echo "<td class='text-capitalize'>" . $row[$ns_db_tables[5]] . "</td>";
                        // done: drop
                        // echo "<td>" . $row[$ns_db_tables[4]] . "</td>";
                        // echo "<td>" . $row[$ns_db_tables[5]] . "</td>";
                        // echo"<td class='text-capitalize'>".$row['Gender']."</td>";
                        echo "<td class='d-flex justify-content-evenly'>" .
                            "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' " .
                            "data-guest-id='" . $row[$ns_db_tables[0]] . "' " .
                            "data-fname='" . $row[$ns_db_tables[1]] . "' " .
                            "data-mname='" . $row[$ns_db_tables[2]] . "' " .
                            "data-lname='" . $row[$ns_db_tables[3]] . "' " .
                            "data-phone='" . $row[$ns_db_tables[4]] . "' " .
                            // done: additional
                            "data-status='" . $row[$ns_db_tables[5]] . "' " .
                            // "data-age='" . $row[$ns_db_tables[5]] . "' " .
                            // "data-gender='" . $row['Gender'] . "' ".
                            ">" .
                            "<i class='bx bx-edit-alt'></i></button>
                            <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delModal' data-guest-id='" . $row[$ns_db_tables[0]] . "'><i class='bx bx-trash'></i></button>
                            </td>";
                        echo "</tr>";
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
                    <h5 class="modal-title">Edit Guest</h5>
                </div>
                <div class="modal-body">
                    <form action="./process.php" method="POST">
                        <input type="text" name="action" class="d-none" value="editguest">
                        <input type="text" name="guest_id" id="guestId" class="d-none">
                        <div class="mb-3">
                            <p class="m-0">Firstname</p>
                            <input type="text" name="Fname" id="fname" class="form-control bg-input">
                            <?php if (isset($_SESSION['errors']['fname'])) { ?>
                                <div class="text-danger ml-3 warn-string"><?php echo $_SESSION['errors']['fname']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <p class="m-0">Middlename</p>
                            <input type="text" name="Mname" id="mname" class="form-control bg-input">
                            <?php if (isset($_SESSION['errors']['mname'])) { ?>
                                <div class="text-danger ml-3 warn-string"><?php echo $_SESSION['errors']['mname']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <p class="m-0">Lastname</p>
                            <input type="text" name="Lname" id="lname" class="form-control bg-input">
                            <?php if (isset($_SESSION['errors']['lname'])) { ?>
                                <div class="text-danger ml-3 warn-string"><?php echo $_SESSION['errors']['lname']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <p class="m-0">Phone Number</p>
                            <input type="text" name="phone" id="phone" class="form-control bg-input">
                            <?php if (isset($_SESSION['errors']['phone'])) { ?>
                                <div class="text-danger ml-3 warn-string"><?php echo $_SESSION['errors']['phone']; ?></div>
                            <?php } ?>
                        </div>
                        <!-- <div class="mb-3">
                            <p class="m-0">Age</p>
                            <input type="text" name="age" id="age" class="form-control bg-input">
                            <?php if (isset($_SESSION['errors']['age'])) { ?>
                                <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['age']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <p class="m-0">Gender</p>
                            <div class="d-flex justify-content-around">
                            <div class="d-flex gap-2"><input type="radio" name="gender" id="maleRadio" class="form-check-input" value="male">Male</div>
                            <div class="d-flex gap-2"><input type="radio" name="gender" id="femaleRadio" class="form-check-input" value="female">Female</div>
                            </div>
                            <?php if (isset($_SESSION['errors']['gender'])) { ?>
                                <div class="text-danger ml-3" style="font-size:12px;"><?php echo $_SESSION['errors']['gender']; ?></div>
                            <?php } ?>
                        </div> -->
                        <div class="mb-3">
                            <p class="m-0">Status</p>
                            <div class="d-flex justify-content-around">
                                <div class="d-flex gap-2"><input type="radio" name="status" id="cinRadio" class="form-check-input" value="Check-in">Check-in</div>
                                <div class="d-flex gap-2"><input type="radio" name="status" id="coutRadio" class="form-check-input" value="Check-out">Check-out</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
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
                    <i class="bx bx-info-circle fs-1 text-danger"></i>
                    <p class="fs-5 fw-semibold m-0">Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" id="deleteLink" href="#" role="button">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <!----- PASS DATA TO EDIT MODAL SCRIPT ----->

    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let guestId = button.data('guest-id');
                let fname = button.data('fname');
                let mname = button.data('mname');
                let lname = button.data('lname');
                let phone = button.data('phone');
                let status = button.data('status');

                // done: drop
                // let age = button.data('age');
                // let gender = button.data('gender');

                // Set values in the modal inputs
                $('#guestId').val(guestId);
                $('#fname').val(fname);
                $('#mname').val(mname);
                $('#lname').val(lname);
                $('#phone').val(phone);
                // $('#age').val(age);

                // Set radio button based on gender value
                // if (gender == 'male') {
                //     $('#maleRadio').prop('checked', true);
                // } else if (gender == 'female') {
                //     $('#femaleRadio').prop('checked', true);
                // }

                if (status == 'Check-in') {
                    $('#cinRadio').prop('checked', true);
                } else {
                    $('#coutRadio').prop('checked', true);
                }
            });
        });
    </script>

    <!----- PASS DATA TO DELETE MODAL SCRIPT ----->

    <script>
        $(document).ready(function() {
            $('#delModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let guestId = button.data('guest-id');
                let deleteLink = $('#deleteLink');
                deleteLink.attr('href', './process.php?action=deleteguest&guest_id=' + guestId);
            });
        });
    </script>

    <!----- DATATABLES SCRIPT ----->
    <!----- SEARCH ----->

    <script>
        $(document).ready(function() {
            $('#guestTable').DataTable({
                "pagingType": "full_numbers",
                "lengthChange": true
            });
        });
    </script>