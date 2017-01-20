
	<div class="container">

      <div class="panel panel-info">
        <div class="panel-heading">

          <h2>Edit Semester</h2><br>

        </div>
        <div class="panel-body">

          <label>Select semester:</label>
          <form role="form" method="post" action="select_semester">

              <select class="form-control" name="semester_id" id="semester_control">
                  <?php

                  if(count($semester)){
                      $exists = 1;
                      foreach ($semester as $row)
                      {

                        if ($row['semester_id'] === $current_semester) {
                          $options = 'selected="selected"';
                        } else {
                          $options = '';
                        }
                                  echo sprintf('<option %s value="%s" >%s</option>', $options, $row['semester_id'].'', $row['semester_name']);
                      }
                  } else {
                    $exists = 0;
                  }

                  ?>

              </select><br>

              <!-- I should select the semester I would like to edit, then the option to select should go away -->
              <!-- And I should be presented with the 2 tables and 3 buttons -->
              <!-- go to different page -->

              <?php if($exists){ ?>
                <button type="submit" class="btn btn-primary">Select Semester</button>
              <?php } else { ?>
                <div class="alert alert-danger">
                  <strong>! CREATE NEW SEMESTER ON DASHBOARD !</strong>
                </div>
              <?php } ?>

          </form>

        </div> <!-- end panel body -->
      </div>  <!-- end panel -->

	</div>
