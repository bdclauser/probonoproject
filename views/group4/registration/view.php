
	<div class="container">

        <div class="panel panel-info">
          <div class="panel-heading">
              <h2>Registration</h2>
          </div>
          <div class="panel-body">
            <form role="form" method="post" action="select_registration">

              <?php if($exists){ ?>
                <!-- select user -->
                <label>Select Student:</label>

                <?php if($reg_clearance[0]){ ?> <!-- if admin -->
                    <!-- number input that accepts user_id of choice -->
                    <input class="form-control" type="number" name="student_id">

                <?php } else if($reg_clearance[2]) { ?> <!-- if parent -->
                    <?php if($studentExists): ?><!-- if parents have students -->
                        <!-- show dropdown of all students in family -->
                        <select class="form-control" name="student_id">
                          <?php

                              foreach($students as $student){
                                echo '<option value="'. $student->user_id .'">'. $student->first_name .' '. $student->middle_initial .'</option>';
                              }

                          ?>
                        </select>
                    <?php endif; ?>
                <?php } /*else if($studentExists){ ?> <!-- if parents have students -->
                    <!-- show dropdown of all students in family -->
                    <select class="form-control" name="student_id">
                      <?php

                          foreach($students as $student){
                            echo '<option value="'. $student->user_id .'">'. $student->first_name .' '. $student->middle_initial .'</option>';
                          }

                      ?>
                    </select>
                  <?php } */?>
                <?php } ?>

              <br><br>
              <label>Select Semester:</label>
        			<select class="form-control" name="semester_id" id="semester_control">
        				<?php
                      foreach ($semester as $row)
                      {

                        if ($row['semester_id'] === $current_semester) {
                          $options = 'selected="selected"';
                        } else {
                          $options = '';
                        }
                                  echo sprintf('<option %s value="%s" >%s</option>', $options, $row['semester_id'].'', $row['semester_name']);
                      }

        				?>
        			</select><br>

              <?php if($exists){ ?>
                <?php if($reg_clearance[0]){ ?>
                  <button type="submit" class="btn btn-primary" >Submit</button>
                <?php } else if($studentExists){ ?>
                  <button type="submit" class="btn btn-primary" >Submit</button>
                <?php } ?>
              <?php } else if(!$exists) { ?>
                <div class="alert alert-danger">
                  <strong>! ADMINISTRATOR CREATE NEW SEMESTER ON DASHBOARD !</strong>
                </div>
              <?php } ?>

              <?php if(!$studentExists){ ?>
                <div class="alert alert-danger">
                  <strong>! Register Some Students !</strong>
                </div>
              <?php } ?>

    	      </form>
          </div>
        </div>
	</div>
