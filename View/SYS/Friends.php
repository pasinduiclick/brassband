<?php
include '../Common/header.php';
$clib->login_reqired(FALSE);
include '../Common/topmenu.php';
include '../Common/leftmenu.php';
?>
<!-- partial -->

<div class="content-wrapper">

    <div class="card" >
        <?php include '../Common/showMessage.php'; ?>
        <div class="card-body" >
            <h4 class="card-title">All Friends of the Band</h4>
            <div style="display: initial;" data-placement="right" title="Add Friend" data-toggle="tooltip"><button data-toggle="modal" data-target="#AddCutter" type="button"  class="btn btn-inverse-primary btn-fw"><i  class="fa fa-plus"></i></button></div> 

            <!-- Modal Add Customer-->
            <div class="modal fade "   id="AddCutter"  tabindex="-1" role="dialog"
                 aria-labelledby="AddMemberModel" aria-hidden="true">
                <div class="modal-dialog mid-size modal-lg modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 d-sm-flex align-items-end round-corners-center" style="background-image: url('../Common/assets/modal-x/img/band.jpg')">
                                    <div style="display:block;height:200px;"></div>
                                </div>

                                <div class="col-md-8 py-5 px-sm-5 ">
                                    <span class="inner-modal-title" style="text-align:left !important">Add New Friend</span>

                                    <form class="cmxform" id="commentForm" method="post" enctype="multipart/form-data" action="../../Service/MemberService.php">
                                        <div class="form-row">
                                            <div class="form-group col-md-12 icon_input_container">
                                                <label for="name">Name</label>
                                                <input id="name" type="text" name="name" class="form-control" required >
                                            </div><div class="form-group col-md-12 icon_input_container">
                                                <label for="email">Email</label>
                                                <input id="email" type="email" name="email" class="form-control" required >
                                            </div><div class="form-group col-md-12 icon_input_container">
                                                <label for="address">Note</label>
                                                <input id="address" type="text" name="notes" class="form-control" >
                                            </div><div class="form-group col-md-12 icon_input_container">
                                                <label for="membership_type">Member Refere</label>
                                                <select name="mem_id"  class="form-control">
                                                    <option value="">--Please Select--</option>
                                                    <?php
                                                    $query1 = "SELECT * from membership where status=1";
                                                    $result1 = $databaseConnection->openConnection()->query($query1);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        echo '<option value="' . $row1['mem_id'] . '">' . $row1['name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                            </div>                                            
                                        </div>
                                        <button type="submit" class="modal-x-btn" name="serviceFlag" id="serviceFlag" value="ADDNEWFRIEND">ADD FRIEND</button>

<?php echo $clib->get_csrf_token(); ?>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix" ></div>
            <br/>
            
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="IDM" class="table datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Notes</th>
                                    <th>Refered By</th>
                                    <?php
                                    if ($_SESSION['user_type'] == 1) {
                                        echo '<th>Action</th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT *, (SELECT name from membership where mem_id=friends.mem_id) AS refby from friends where status=1";
                                $result = $databaseConnection->openConnection()->query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                                                        <td>' . $row['name'] . '</td>
                                                       <td>' . $row['email'] . '</td>'
                                            . '<td>' . $row['notes'] . '</td>'
                                    . ' <td>' . $row['refby'] . '</td>';
                                    if ($_SESSION['user_type'] == 1) {
                                        echo '<td><div class="btn-group" role="group" aria-label="Basic example">
                                                            <div style="display: initial;" data-placement="left" title="View & Edit Uniform" data-toggle="tooltip"><button type="button" data-toggle="modal" data-target="#updtaccmodal' . $row['friend_id'] . '" class="btn btn-sm btn-inverse-primary btn-fw"><i class="fa fa-pencil"></i></button></div>
                                                            <button class="btn btn-sm btn-inverse-danger btn-fw" data-placement="right" title="Delete Friend" data-toggle="tooltip"  onclick="return showSwal(' . "'warning-message-and-cancel','../../Service/MemberService.php?serviceFlag=DELFRIEND&friend_id=" . $row['friend_id'] . "&csrf_token=" . $clib->get_csrf_token(true) . "'" . ')"><i class="fa fa-trash"></i></button>  
                                                        </div>';
                                    }
                                    echo '<!-- Modal Edit Uniform-->
    <div class="modal fade "  id="updtaccmodal' . $row['friend_id'] . '" tabindex="-1" role="dialog"
         aria-labelledby="AddCutterModel" aria-hidden="true">
        <div class="modal-dialog mid-size modal-lg modal-dialog-centered " role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-md-4 d-sm-flex align-items-end round-corners-center" style="background-image: url(../Common/assets/modal-x/img/uniform.jpg)">
                          <div style="display:block;height:200px;"></div>
                       </div>
                      
                       <div class="col-md-8 py-5 px-sm-5 ">
                           <span class="inner-modal-title" style="text-align:left !important">Edit Instruments</span>
                             
                             <form class="cmxform" id="commentForm" method="post" enctype="multipart/form-data" action="../../Service/MemberService.php">
                                        <div class="form-row">
                                            <div class="form-group col-md-12 icon_input_container">
                                                <label for="name">Name</label>
                                                <input id="name" type="text" name="name" class="form-control" value="'.$row['name'].'" required >
                                            </div><div class="form-group col-md-12 icon_input_container">
                                                <label for="email">Email</label>
                                                <input id="email" type="email" name="email" class="form-control" value="'.$row['email'].'" required >
                                            </div><div class="form-group col-md-12 icon_input_container">
                                                <label for="address">Note</label>
                                                <input id="address" type="text" name="notes" value="'.$row['notes'].'" class="form-control" >
                                            </div><div class="form-group col-md-12 icon_input_container">
                                                <label for="membership_type">Member Refere</label>
                                                <select name="mem_id"  class="form-control">
                                                    <option value="'.$row['mem_id'].'">'.$row['refby'].'</option>';
                                                    
                                                    $query1 = "SELECT * from membership where status=1";
                                                    $result1 = $databaseConnection->openConnection()->query($query1);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        echo '<option value="' . $row1['mem_id'] . '">' . $row1['name'] . '</option>';
                                                    }
                                                    echo '</select>

                                            </div>                                            
                                        </div>
                                        <input id="friend_id" type="hidden" name="friend_id" value="' . $row['friend_id'] . '" />
                                        <button type="submit" class="modal-x-btn" name="serviceFlag" id="serviceFlag" value="EDITFRIEND">EDIT FRIEND</button>';
                                    echo $clib->get_csrf_token();
                                    echo '</form>
                          
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->                                                                                                                                                                                                                  
</td></tr>';
                                }
                                ?>                                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
<!-- content-wrapper ends -->
<?php
include '../Common/footer.php';
include '../Common/jsplugins.php';
?>