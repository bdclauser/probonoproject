<?php if ($this->session->flashdata('final_grades_submitted')): ?>
    <div class="alert alert-success">
        ! You've successfully submitted final grades !
    </div>
<?php endif; ?>

<div class="container">


  <div style="text-align: center" class="page-header">
    <h2>Gradebook</h2>
  </div>

<!-- Create Admin Panel -->
<?php if($user['isAdmin']): ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
          Administrator - Gradebook
        </div>
        <div class="panel-body">

              <div class="row">

                <div style="padding:0" class="panel panel-default col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel-heading">
                        <strong>Select Student</strong>
                    </div>
                    <div class="panel-body">
                          <form action="pick_student_course" role="form" method="post" id="admin_student_form">

                            <div class="row">
                              <div class="form-group col-md-12">
                                <div class="form-group">
                                    <label for="student_id">Enter Student ID</label>
                                    <input class="form-control" type="number" name="student_id">
                                </div>
                              </div>
                            </div>

                          </form>
                    </div>
                    <div class="panel-footer">
                      <button type="submit" form="admin_student_form" class="btn btn-success" tabindex="10" name="parentview" value="1">Submit</button>
                    </div>
                </div>
                <div style="padding:0" class="panel panel-default col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel-heading">
                        <strong>Select Teacher</strong>
                    </div>
                    <div class="panel-body">
                        <form action="pick_teacher_course" role="form" method="post" id="admin_teacher_form">

                          <div class="row">
                            <div class="form-group col-md-12">
                              <div class="form-group">
                                  <label for="teacher_id">Enter Teacher ID</label>
                                  <input class="form-control" type="number" name="teacher_id">
                              </div>
                            </div>
                          </div>

                        </form>
                    </div>
                    <div class="panel-footer">
                      <button type="submit" form="admin_teacher_form" class="btn btn-success" tabindex="10" name="parentview" value="1">Submit</button>
                    </div>
                </div>


              </div>



        </div>
    </div>
<?php endif; ?>
<!-- Admin Panel End -->



  <!-- Teacher Panel Start -->
	<?php if($user['isTeacher']) : ?>

    <div class="panel panel-warning">
      <div class="panel-heading">
        Teacher - Grade Assignments
      </div>
      <div class="panel-body">
        <form role="form" method="post" action="teacher_gradebook" id="teacher_form">

      		<div class="row">
      			<div class="form-group col-md-4">


      				<label for="course">Select a course</label>
      				<select class="form-control" id="course" name="course" tabindex="5">
      					<?php //Populate the select element with options containing the course ids and names.
      						foreach($returnT as $row){
      							echo "<option value=\"" . $row["id"] . "\">" . $row["course_name"] . "</option>";
      						};
      					?>
      				</select>


      			</div>
      		</div>

      	</form>
      </div>
      <div class="panel-footer">
        <button type="submit" form="teacher_form" class="btn btn-success" tabindex="10">View Assignments</button>
      </div>
    </div>

	<?php endif; ?>
  <!-- Teacher Panel End -->



<!-- Parent Panel Start -->
	<?php if($user["isParent"]) : ?>


    <div class="panel panel-success">
      <div class="panel-heading">
        Parent - View Child Grades
      </div>
      <div class="panel-body">
        <form action="pick_student_course" role="form" method="post" id="parent_form">
    			<input type="hidden" name="id" value="<?php echo $userID; ?>">
    			<div class="row">
    				<div class="form-group col-md-4">
    					<label for="course">Select a family member</label>
    					<select class="form-control" id="member" name="student_id" tabindex="15">
    						<?php //Populate the select element with options containing the course ids and names.
    							foreach($returnP as $row){
    								echo "<option value=\"" . $row["user_id"] . "\">" . $row["last_name"] . ", " . $row["first_name"] . "</option>";
    							};
    						?>
    					</select>
    				</div>
    			</div>
    		</form>
      </div>
      <div class="panel-footer">
        <button type="submit" form="parent_form" class="btn btn-success" tabindex="10" name="parentview" value="1">View Assignments</button>
      </div>
    </div>

	<?php endif; ?>
<!-- Parent Panel End -->




<!-- Student Panel Start -->
  <?php if($user['isStudent']) : ?>

    <div class="panel panel-primary">
      <div class="panel-heading">
        Student - View Grades
      </div>
      <div class="panel-body">
        <form role="form" method="post" action="student_gradebook" id="student_form">
          <input type="hidden" name="user_id" value="<?= $this->session->userID ?>">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="course">Select a course</label>
              <select class="form-control" id="course" name="course" tabindex="10">
                <?php //Populate the select element with options containing the course ids and names.
                  foreach($returnS as $row){
                    echo "<option value=\"" . $row["course_id"] . "\">" . $row["course_name"] . " - " . $row["semester_name"] . "</option>";
                  };
                ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="panel-footer">
        <button type="submit" class="btn btn-success" tabindex="10" form="student_form">View Assignments</button>

        <form style="display: inline-block" action="view_transcript" method="post">
          <input type="hidden" name="user_id" value="<?= $this->session->userID ?>">

          <button class="btn btn_default" type="submit" name="button">View Transcript</button>
        </form>
      </div>
    </div>

	<?php endif; ?>
<!-- Student Panel End -->


</div>
