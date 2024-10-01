<?php
  ob_start();
  session_start();

  if (!isset($_SESSION["userName"])) {
      // Redirect to the login page if not logged in
      header("location: login.php");
      exit();
  }else{
    // echo "Welcome, " . $_SESSION["username"] . "!";
    // echo "<script>alert('admin login');</script>";
  }
  
  ?>

<?php
include("templates/connection.php");
include "delete_student_data.php"; // to delete in database 
include "update_student_data.php"; // to update in database 


$sql_read = "SELECT * FROM attendance_table ORDER BY attendance_timedate DESC";
$sql_get = $conn->query($sql_read) or die($conn->error);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>
    

    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- style for printing -->
    <style>
        @media print{
            @page{
            size: A4 landscape;
            border: initial;
            margin-left: .5rem;
            margin-right: .5rem;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
            }
            .table{
            border-collapse: collapse;
            }
            #thead th:last-child, #tbody td:last-child{
            display: none;
            }
        }
    </style>

    <script src="js/jquery3.7.js"></script>
    <!-- <script src="js/jquery-ui.min.js"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src = "js/dtPicker.js"></script> -->
      
</head>
<body>
    <div class="container-full-height container-custom">
    <nav class="navbar navbar-dark navbar-custom">
            <a class="navbar-brand ms-2" href="#"><img src=https://cdn-icons-png.flaticon.com/512/2313/2313427.png width="30" height="30" class="d-inline-block align-top" alt="face icon"><span style="padding-left: 10px;"></span>Attendance System</span></a>
            <ul class="navbar-nav d-flex flex-row me-3">
                <li class="nav-item me-3 me-lg-3">
                    <div class="dropdown">
                        <!-- <a href="#" class="nav-link text-white">
                            <i class="fas fa-bell text-white"></i><span class="badge rounded-pill badge-notification bg-danger">1</span>
                        </a> -->
                    </div>
                </li>
                <li class="nav-item me-3 me-lg-0 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-mdb-toggle="dropdown" aria-expanded="false">
                        <!-- <i class="fas fa-user text-white"></i> -->
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="#">Settings</a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item" href="#">Sign Out</a>
                        </li>
                    </ul>
                </li>
            </ul>      
        </nav>       
            <!-- Sidebar -->
        <div class="d-flex vh-100">
            <div class="col-auto sidebar-custom">
                <ul class="nav nav-pills flex-column">
                    <li class="nav item me-2 mt-2">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-house ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav item me-2">
                        <a href="index.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-list ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">View Attendance</span>
                        </a>
                    </li>
                    <li class="nav item me-2">
                        <a href="users.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-user ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">List of Residents</span>
                        </a>
                    </li>
                    <li class="nav item me-2">
                        <a href="curfew.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-triangle-exclamation ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">Curfew Violations</span>
                        </a>
                    </li>
                    <li class="nav item me-2">
                        <a href="adminList.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-lock ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">List of Admins</span>
                        </a>
                    </li>
                    <li class="nav item me-2">
                        <a href="messageList.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-message ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">Resident Messages</span>
                        </a>
                    </li>
                    <li class="nav item me-2">
                        <a href="logout.php" class="nav-link text-white">
                            <i class="fs-6 fa fa-door-open ms-1"></i><span class="fs-6 ms-2 d-none d-sm-inline">Sign Out</span>
                        </a>
                    </li>          
                </ul>
            </div>
            <!-- Content -->
            <div class="content m-3 w-100 table-responsive">
              <p class="ms-3 mt-3 fs-5">Attendance List</span></p>
              <hr>
              <form class="ms-3 form-check-inline">
                <div class="input-group d-flex align-self-center">
                    <input type="search" class="form-control me-2" placeholder="Search...Name" id="top-search">
                    
                    <button type="button" class="btn btn-light border me-2"><a href="index.php"><i class="fa fa-arrows-rotate"></i></a></button>
                    <!-- <span class="mdi mdi-magnify search-icon"></span> -->
                    <!-- <button class="btn btn-primary" type="submit">Search</button> -->
                        
                    <input type="text" name = "From" id="From" class="form-control me-2" placeholder="From Date"/>
                    <input type="text" name = "To" id="To" class="form-control me-2" placeholder="To Date" />
                    <input type="button" name = "range" id ="range" value="Search Date" class="btn btn-success"/>
                </div>
                
            </form>
            <!-- <input type="text" id= "getSearch"> -->
            <a type="button" class="btn btn-info m-2 ms-3" id="printing"><i class="fa fa-print"></i><span class="fs-6 ms-2 d-none d-sm-inline">Print Attendance Report</span></a>
            <a type="button" class="btn btn-success m-2 ms-3" data-bs-toggle="modal" data-bs-target= "#modalAdd"><i class="fa fa-plus"></i><span class="fs-6 ms-2 d-none d-sm-inline">Add Attendance Data</span></a>

            <hr>
            <div class="m-3" id="printTable">
            <!-- TABLE -->
                <table class='table table-bordered table-hover' >
                    <thead class="table-dark" id="thead">
                        <tr>
                            <th >No.</th>
                            <th>Resident's Name</th>
                            <th>In or Out</th>
                            <th>Time of attendance</th>
                            <th>Going To</th>
                            <th>Captured Image</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                        <?php
                    $ctr = 1;
                    while ($view_row = $sql_get->fetch_assoc()) {
                        ?>
                        <tbody id="tbody">
                            <tr>
                                <td ><?= $ctr; ?></td>
                                <td><?= $view_row["Name"]; ?></td>
                                <?php
                                if($view_row["InOrOut"] == 'Time In'){
                                    ?>
                                    <td style="color:blue"><?= $view_row["InOrOut"]; ?></td>
                                    <?php
                                }
                                elseif($view_row["InOrOut"] == 'Time Out'){
                                    ?>
                                    <td style="color:red"><?= $view_row["InOrOut"]; ?></td>
                                    <?php
                                }
                                ?>
                                
                                <td><?= $view_row["attendance_timedate"]; ?></td>
                                <!-- <td><?= $view_row["going_where"]; ?></td> -->
                                <?php
                                if(($view_row["going_where"] == 'Forgot to Time Out') or ($view_row["going_where"] == 'Forget to Time In') ){
                                    $backgroundColor = "LightSalmon";
                                    ?>
                                    <!-- <td style="color:red"><?= $view_row["going_where"]; ?></td> -->
                                    <td style="background-color: <?= $backgroundColor; ?>;"> 
                                    <?= $view_row["going_where"]; ?>
                                    </td>
                                    <?php
                                    
                                }
                                else{
                                    ?>
                                    <td><?= $view_row["going_where"]; ?></td>
                                    <?php
                                }
                                ?>
                                <td class="text-center"> 
                                    <a href= "<?=$view_row["image"]; ?>" target = "_blank">
                                        <img src= "<?=$view_row["image"]; ?>" width = "70em" height = "50em">
                                    </a>
                                </td>

                                <td>
                                <a href="#" id=<?php echo $view_row['idattendance_table']; ?> type="button" data-bs-toggle="modal" data-bs-target= "#modalDelete" class=" deleteStudentBtn btn btn-outline-danger">
                                    <i class="fa fa-eraser"></i>
                                </a> 
                                
                                <a href="#" id=<?php echo $view_row['idattendance_table']; ?> type="button" data-bs-toggle="modal" data-bs-target= "#modalUpdate" class=" updateStudentBtn btn btn-outline-success">
                                    <i class="fa fa-underline"></i>
                                </a> 


                            </td>
                            </tr>
                        </tbody>
                    <?php
                    $ctr++;
                    }
                    ?>
                </table>

                  </div>                
            </div>
        </div>
    </div>

<!-- modal for Delete button -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reminder</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <h1>Are you sure you want to Delete?</h1>
					<div class="table-responsive">
						<table class = "table table-condensed table-hover">
							<thead>
								<tr>
                                    <!-- <th >No.</th> -->
                                    <th>Resident's Name</th>
                                    <th>In or Out</th>
                                    <th>Time of attendance</th>
                                    <th>Going To</th>
                                    <!-- <th>Option</th> -->
								</tr>
							</thead>
                            <tbody>
                               <tr>
                                 <!-- <td id="property1"></td> -->
                                 <td id="property2"></td>
                                 <td id="property3"></td>
                                 <td id="property4"></td>
                                 <td id="property5"></td>
                                 <!-- <td id="property5"></td> -->
                               </tr>
                            </tbody>

						</table>
					</div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Delete Data</button> -->
        <form action="<?php htmlspecialchars('PHP_SELF'); ?>" method="POST">
            <input type="text" name="del_id" id="del-id" style="visibility: hidden">
            <input type="submit" class="btn btn-outline-danger" name="deleteForever" id="btn-delete" value = "Delete">
    
        </form>
      </div> 
    </div>
  </div>
</div>


<!-- modal for Update button -->
<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" class = "row needs-validation" method = "POST" novalidate action="<?php htmlspecialchars("PHP_SELF") ; ?>" >
            <div class="col-md-12">
                <label for="ResName" class="form-label">Resident's Name:</label>
                <input type="text" class="form-control" name = "ResName" id="ResName">                   
            </div>
            <div class="col-md-12">
                <label for="timeAtt" class="form-label">Time Of Attendance:</label>
                <input type="text" class="form-control"  id="timeAtt" name="timeAtt">                   
            </div>
            <div class="col-md-12">
                <label for="inOut" class="form-label">In or Out:</label>
                <input type="text" class="form-control"  id="inOut" name="inOut" >                   
            </div>
            <div class="col-md-12">
                <label for="goingTo" class="form-label">Going To:</label>
                <input type="text" class="form-control"  id="goingTo" name="goingTo" >                   
            </div>

           
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Delete Data</button> -->
        
            <input type="text" name="upd_id" id="upd-id" style="visibility: hidden">
            <input type="submit" class="btn btn-outline-success" name="updateBut" id="btn-update" value = "Update">
    
        </form>
      </div> 
    </div>
  </div>
</div>
 
<!-- modal for add attendance -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Attendance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class = "row needs-validation" method = "POST" action="<?php htmlspecialchars("PHP_SELF") ; ?>" >
                <div class="row">
                    <div class="col-12">
                        <label for="inputName" class="form-label">Resident's Name:</label>
                        <input type="text" class="form-control" name="inputName" id="inputName" required>
                        
                    </div>
                    <div class="col-7">
                        <label for="inputInOut" class="form-label">In or Out:</label>
                        <input type="text" name="inputInOut" class="form-control" id="inputInOut" required>
                    </div>
                    <div class="col-12">
                        <label for="inputAtt" class="form-label">Time of Attendance:</label>
                        <input type="text" name="inputAtt" class="form-control" id="inputAtt" required>
                    </div>
                    <div class="col-12">
                        <label for="inputgoing" class="form-label">Going To:</label>
                        <input type="text" name="inputgoing" class="form-control" id="inputgoing" required>
                    </div>

                    <div class="col-12">
                        <label >Captured Image</label>
                                <div class="col-12">
                                <input type="file" name="file" class="form-control" accept="image/*" required>
                                </div>
                        </div>
                    </div>
                
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Delete Data</button> -->
        <div class="col-12 text-center"> 
            <input type="submit" class="btn btn-outline-primary" value="Add" name="btnSubmit">
        </div>
        </form>  
      </div> 
    </div>
  </div>
</div>

<!-- script for delete button  -->
<script>
        $(document).on('click','.deleteStudentBtn' ,function (e) {
        
        e.preventDefault();
        let del_id = $(this).attr('id');
        console.log($(this))   
        $.ajax({
            url: "get_student_data.php", 
            method: "POST",
            data: { del_id: del_id },
            dataType: "json", 
            success: function (data) {
              console.log("asdad")
                $("#del-id").val(data.idattendance_table);
                // $("#property1").html(data.Name);
                $("#property2").html(data.Name);
                $("#property3").html(data.InOrOut);
                $("#property4").html(data.attendance_timedate);
                $("#property5").html(data.going_where);
                // $("#property5").html(data.date_received);
                                }
            });
        });

</script>
<!-- script for update button -->
<script>
        $(document).on('click','.updateStudentBtn' ,function (e) {
        e.preventDefault();
        let upd_id = $(this).attr('id');
           
        $.ajax({
            url: "get_update_data.php", 
            method: "POST",
            data: { upd_id: upd_id },
            dataType: "json", 
            success: function (data) {

                $("#upd-id").val(data.idattendance_table);
                $("#ResName").val(data.Name);
                $("#timeAtt").val(data.InOrOut);
                $("#inOut").val(data.attendance_timedate);
                $("#goingTo").val(data.going_where);
                                }
            });
        });     

</script>

<!-- script for add button -->
 <!-- php for insert -->
 <?php
    if(isset($_POST["btnSubmit"])){
        
        $inputName = $conn->escape_string(trim($_POST["inputName"]));
        $inputinout = $conn->escape_string(trim($_POST["inputInOut"]));
        $inputatt = $conn->escape_string(trim($_POST["inputAtt"]));
        $inputgoing = $conn->escape_string(trim($_POST["inputgoing"]));
        $upload_file = $_FILES["file"];

        echo '<script>';
        echo 'console.log("Input Name: ' . $inputName . '");';
        echo 'console.log("Input In/Out: ' . $inputinout . '");';
        echo 'console.log("Input Attendance: ' . $inputatt . '");';
        echo 'console.log("Input Going: ' . $inputgoing . '");';
        echo '</script>';
        
        // $at = $upload_file["tmp_name"];
        $originalName = $upload_file["name"];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $newName = $inputName;
        $dot = ".";
        $destination = "ThesisFaceRecog/attendanceFaceFolder/".$newName.$dot.$extension;

        move_uploaded_file($upload_file["tmp_name"],$destination);

        $sql_add = "INSERT INTO attendance_table(`Name`, InOrOut, attendance_timedate, going_where, `image`) VALUES(?,?,?,?,?)";
        $stmt_add = $conn->prepare($sql_add) or die($conn->error);
        $timedInValue = 0;
        $stmt_add->bind_param("sssss",$inputName, $inputinout, $inputatt,$inputgoing, $destination);
        $stmt_add->execute();
        $stmt_add->close();
        echo "<script> window.location.href = 'index.php';</script>";
              
    
        
    }
?>

<!-- script for printing -->
<script>
  let btn = document.querySelector("#printing");

  btn.addEventListener("click", ()=>{
    let restore = document.body.innerHTML;
    let printable = document.querySelector("#printTable").innerHTML;

    document.body.innerHTML = printable;
    window.print();

    document.body.innerHTML = restore;
    location.reload(); 

  },false);
</script>

<!-- script for searching with name, ajax -->
<script>
    $(document).ready(function(){
        var defaultTableURL = "defaultTable.php";
        var searchTableURL = "searchajax.php";

        $("#top-search").keyup(function(){
            var input = $(this).val();
            // alert(input);
            var url = input !== "" ? searchTableURL : defaultTableURL;

            $.ajax({
                url: url,
                method: "POST",
                data: { input: input },
                success: function(data){
                    $("#printTable").html(data);
                }
            });
        });
    });
</script>

<!-- script for searching with date picker -->
<script>
    $(document).ready(function(){
        $.datepicker.setDefaults({
            dateFormat: 'yy:mm:dd',

        });
        $(function(){
            $("#From").datepicker();
            $("#To").datepicker();
        });
        $('#range').click(function(){
            var From = $('#From').val();
            var to = $('#To').val();
            var name12 = $('#top-search').val();
            if(From !='' && to != '')
            {
                $.ajax({
                    url:"rangeajax.php",
                    method:"POST",
                    data:{From:From, to:to, name12:name12},
                    success:function(data)
                    {
                        $("#printTable").html(data);
                    }
                })
            }
            else{
                alert("Please Select Date");
            }
        })
    });
</script>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>