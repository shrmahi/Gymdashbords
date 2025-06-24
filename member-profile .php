<?php
$catid = intval($_GET['cid']);
$query = mysqli_query($con, "Select tblmember.id as catid, `MemberBid`, `FirstName`, `LastName`, `Gender`, `Email`, `Mobile`, `AlterNumber`, `DoctorName`, `DoctorNumber`, `MedicalHistory`, `Address`, `PermnentAddress`, `DrivingNumber`, `PanNumber`, `AadharNumber`, `Dob`, `JoinDate`, `MaritalStatus`, `AssignStaff`, `ShiftType`, `PakageType`, `PaymentMode`, `ReceiptType`, `ReceiptDate`, `PostImage` from  tblmember where id='$catid'");
$cnt = 1;
while ($row = mysqli_fetch_array($query)) {
    ?>
    <div class="container form-container">
        <div class="row">
            <div class="col-8">
                <h4><strong><?php echo htmlentities($row['FirstName']); ?>&nbsp;<?php echo htmlentities($row['LastName']); ?></strong>
                </h4>
                <div class="mb-2">
                    <label>Member Id:</label>
                    <input type="text" value="<?php echo htmlentities($row['MemberBid']); ?>"
                        class="form-control form-control-sm w-50 d-inline-block" readonly>
                </div>
                <div class="mb-2">
                    <label>Date of Issue:</label>
                    <input type="text" class="form-control form-control-sm w-25 d-inline-block">
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="photo-box">Photo Here</div>
            </div>
        </div>

        <div class="section-heading">ADMISSION FORM</div>

        <div class="row mb-2">
            <div class="col-md-6">
                <label>Surname:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Name:</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <label>Father’s Name:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Mother’s Name:</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <label>Aadhar Card No.:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Date of Birth:</label>
                <input type="text" class="form-control" placeholder="DD/MM/YY e.g. 07/12/2000">
            </div>
        </div>

        <div class="row mb-2 align-items-center">
            <div class="col-md-3">
                <label>Gender:</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label>Phone:</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <label>Place of Birth:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label>City:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Dist.:</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <label>State:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Physical problems/Disability (if any):</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Name of School:</label>
            <input type="text" class="form-control">
        </div>
    </div>
<?php } ?>