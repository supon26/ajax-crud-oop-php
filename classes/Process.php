<?php

$conn = new mysqli("localhost","root","","ajax_crud");

$action = $_POST['action'];
$action();

// Employee add
function insert(){
    global $conn;
    $empName   = $_POST['emp_name'];
    $empEmail  = $_POST['emp_email'];
    $empPhone  = $_POST['emp_phone'];
    $empStatus = $_POST['emp_status'];

    $sql = "INSERT INTO `employee`(`id`,`emp_name`, `emp_email`, `emp_phone`, `emp_status`) VALUES (NULL,'$empName','$empEmail','$empPhone','$empStatus')";
    $insResult = $conn->query($sql);

    if($insResult){
        echo "
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data Inserted Successfully',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
        ";
    }   
}

// Employee show
function show(){
    global $conn;
    $showResult = $conn->query("SELECT * FROM `employee`");
    $i = 1;
    foreach($showResult as $employee){?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $employee['emp_name']?></td>
            <td><?= $employee['emp_email']?></td>
            <td><?= $employee['emp_phone']?></td>
            <td>
                <?php
                if($employee['emp_status'] == 1){?>
                    <button id="activeBtn" value="<?= $employee['id']?>" class="btn btn-success btn-sm"><i class="fa-solid fa-user-check"></i></button>
                <?php }
                else{?>
                    <button id="inactiveBtn" value="<?= $employee['id']?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-user-xmark"></i></button>
                <?php }
                
                ?>
            </td>
            <td>
                <button id="editBtn" value="<?= $employee['id']?>" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-warning btn-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button id="deleteBtn" value="<?= $employee['id']?>" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    <?php }
}

// Active to Inactive id
function active_to_inactive(){
    global $conn;
    $id = $_POST['id']; 
    $result = $conn->query("UPDATE `employee` SET `emp_status` ='0' WHERE id='$id'"); 
}

// Active to Inactive id
function inactive_to_active(){
    global $conn;
    $id = $_POST['id']; 
    $result = $conn->query("UPDATE `employee` SET `emp_status` ='1' WHERE id='$id'"); 
}

// Delete Employee
function destroy(){
    global $conn;
    $id = $_POST['id'];
    $result = $conn->query("DELETE FROM `employee` WHERE id='$id'");
}

// Edit Employee
function edit(){
    global $conn;
    $id = $_POST['id'];
    $result = $conn->query("SELECT * FROM `employee` WHERE id='$id'");
    $finalRes = $result->fetch_assoc();
    // print_r($finalRes);
    echo json_encode($finalRes);
}

function update(){
    global $conn;
    $id = $_POST['id'];
    $updName = $_POST['updName'];
    $updEmail = $_POST['updEmail']; 
    $updPhone = $_POST['updPhone'];

    $sql = "UPDATE `employee` SET `emp_name`='$updName',`emp_email`='$updEmail',`emp_phone`='$updPhone' WHERE id='$id'";
    $result = $conn->query($sql);

    if($result){
        echo "
            <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data Uploaded Successfully',
                showConfirmButton: false,
                timer: 1500
                })
            </script>
        ";
    }

}

?>