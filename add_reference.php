<?php
// Connect to the database
// $con = mysqli_connect("localhost", "root", "", "your_database_name");
include('includes/config.php');
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// // Get data from POST
// $name = mysqli_real_escape_string($con, $_POST['userName']);
// $phone = mysqli_real_escape_string($con, $_POST['phoneNumber']);

// // Insert into tblreference
// $query = "INSERT INTO tblreference (Name, PhoneNumber) VALUES ('$name', '$phone')";
// if (mysqli_query($con, $query)) {
//     // Redirect back to form or show success message
//     echo "Reference saved successfully!";
// } else {
//     echo "Error: " . $query . "<br>" . mysqli_error($con);
// }

// mysqli_close($con);



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reference'])) {
    $reference = trim($_POST['reference']);

    if (!empty($reference)) {
        $stmt = $con->prepare("INSERT INTO tblreference (Name) VALUES (?)");
        $stmt->bind_param("s", $reference);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "empty";
    }
}
?>