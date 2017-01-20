
    <div style="display: none" id="<?php echo $dispButton ?>" class="clickBait"></div>

    <div class="panel panel-danger">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  Administration
                </div>

                <!-- group 4 addition -->
                <div style="text-align: right" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        		        <button class="btn btn-default" name="selection" data-toggle="modal" data-target="#add_semester_modal" id="add_user">Add Semester</button>
                    <form action="edit_semester" method="post" style="display: inline-block">
                            <button type="submit" class="btn btn-default">Edit Semesters</button>
                    </form>
                </div>
            </div>
            <!-- g4 end -->

        </div>
        <div class="panel-body">
            <div class="row">
                <!-- Duties Panel START -->
                <div style="padding:0;" class="panel panel-default col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel-heading">
                        Misc Duties
                    </div>
                    <div class="panel-body">
                        <button class="btn btn-primary" name="selection" data-toggle="modal" data-target="#add_duty_modal" id="add_user">Add Duty</button>

                        <form action="browse_duties" method="post" style="display: inline-block">
                            <button type="submit" class="btn btn-info">Browse Duties</button>
                        </form>

                        <br><br>
                        <!-- search for duties -->
                        <form action="filter_duties" method="post">
                            <input type="hidden" name="duty_name" value="null">
                            <label>Find a Duty:</label>
                            <div class="input-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <input placeholder="Enter duty ID" class="form-control" type="number" name="duty_id">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Duties Panel END -->

                <!-- Users Panel START -->
                <div style="padding:0;" class="panel panel-default col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel-heading">
                        Users
                    </div>
                    <div class="panel-body">

                        <button class="btn btn-primary" name="selection" data-toggle="modal" data-target="#add_user_modal" id="add_user">Add User</button>

                        <form action="./browse_users" method="post" style="display: inline-block">
                            <button type="submit" class="btn btn-info">Browse Users</button>
                        </form>
                        <form action="./reg_accounting" method="post" style="display: inline-block">
                            <button type="submit" class="btn btn-info">Registration Payment</button>
                        </form>
                        <br><br>
                        <!-- search for users -->
                        <form action="./browse_users" method="post">
                            <label>Find a user:</label>
                            <div class="input-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <input placeholder="Enter user ID" class="form-control" type="number" name="user_id">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </span>
                            </div>
                        </form>
                            <!-- removed table && kept buttons -->
                    </div>
                </div>
                <!-- Users Panel END -->
            </div>


        </div>
    </div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="add_user_modal" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div style="overflow: auto;" class="modal-content">
        <?php include('application/views/group1/registration/registration_main.php'); ?>
    </div>
  </div>
</div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="add_duty_modal" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div style="overflow: auto;" class="modal-content">
                <?php include('application/views/group1/duties/duties_main.php'); ?>
            </div>
        </div>
    </div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="add_semester_modal" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div style="overflow: auto;" class="modal-content">
        <?php include('application/views/group4/semesters/add.php'); ?>
    </div>
  </div>
</div>
