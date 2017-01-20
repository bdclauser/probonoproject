<?php if($this->session->flashdata('error') != null): ?>
  <div class="alert alert-warning">
      <?php echo $this->session->flashdata('error'); ?>
  </div>
<?php endif; ?>

	<div class="container">

    <div class="panel panel-info">
      <div class="panel-heading">
        <h3>Registered Courses: <?php echo $semester_info['semester_name'] ?></h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">

            <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th class="col-md-2">Course ID</th>
                      <th class="col-md-2">Course Name</th>
                      <th class="col-md-2">Instructor</th>
                      <th class="col-md-2">Start Time</th>
                      <th class="col-md-2">End Time</th>
                      <th class="col-md-2">Waitlist Position</th>
                      <th class="col-md-1">Description</th>
                      <th class="col-md-1">Delete</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach ($current_courses as $course){

                  $waitlist_array = explode(',', $course["waitlist_students"]);
                  $wait_pos = 0;

                  for($i = 0; $i < count($waitlist_array); $i++){
                    if($waitlist_array[$i] == $student_id){
                      $wait_pos = $i + 1;
                      break;
                    }
                  }

                    echo '<tr>
                <td>'. $course['id'] .'</td>
                <td>' . $course['course_name'] . '</td>
                <td>' . $course['first_name'] .' '.$course['middle_initial'].' '.$course['last_name'].' '. '</td>
                <td>' . $course['time1start'] . '</td>
                <td>' . $course['time1end'] . '</td>
                <td>'. $wait_pos .'</td>
                <td>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#'.$course['id'].'">
                    Description
                  </button>
                </td>
                <td><form method="post" role="form" action="drop" onsubmit="return confirm(\'Are you sure you want to drop this course?\')">
                      <input type="hidden" value='.$course['course_id'].' name="remove_course">
                <input type="hidden" value='.$student_id.' name="remove_user">
                          <input type="hidden" value='.$semester_info['semester_id'].' name="remove_semester">
                <input type="submit" class="btn btn-danger" value="Drop">
                </form>
                </td>
              </tr>';
                };
                ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>


	</div>


	<div class="container">



    <div class="panel panel-info">
      <div class="panel-heading">
        <h3>Register for Courses</h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="col-md-2">Course ID</th>
                    <th class="col-md-2">Course Name</th>
                    <th class="col-md-2">Instructor</th>
                    <th class="col-md-2">Start Time</th>
                    <th class="col-md-2">End Time</th>
                    <th class="col-md-1">Students Enrolled</th>
                    <th class="col-md-1">Students Allowed</th>
                    <th class="col-md-1">Waitlist</th>
                    <th class="col-md-1">Description</th>
                    <th class="col-md-1">Register</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($all_courses as $course){
                  $disabled = '';
                  if($course['max_waitlist'] == $course['current_waitlist']){
                    $disabled = 'disabled';
                  }

                  echo '<tr>
                    <td>'. $course['id'] .'</td>
                    <td>' . $course['course_name'] . '</td>
                    <td>' . $course['first_name'] .' '.$course['middle_initial'].' '.$course['last_name'].' '. '</td>
                    <td>' . $course['time1start'] . '</td>
                    <td>' . $course['time1end'] . '</td>
                    <td>'.$course['num_students'].'</td>
                    <td>'.$course['max_students'].'</td>
                    <td>'. $course['current_waitlist'] .' / '. $course['max_waitlist'] .'</td>
                    <td>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#'.$course['id'].'">
                        Description
                      </button>
                    </td>
                    <td>
                      <form method="post" role="form" action="register">
                        <input type="hidden" value="'.$course['time1start'].'" name="start_time">
                        <input type="hidden" value="'. $course['id'] .'" name="add_course">
                        <input type="hidden" value="'. $student_id .'" name="add_user">
                        <input type="hidden" value="'. $semester_id .'" name="add_semester">
                        <input type="submit" class="'. $disabled .' btn btn-success" value="Register">
                      </form>
                    </td>
                  </tr>';
                };
                ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>

	</div>



<?php  foreach ($current_courses as $course): ?>

    <!-- build unique modal for each registered course -->
    <div class="modal fade" id="<?php echo $course['id']; ?>" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><strong>Course Description</strong> - <?php echo $course['course_name'] ?></h4>
          </div>
          <div class="modal-body">
            <?php echo $course['description'] ?>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<?php endforeach; ?>



<?php  foreach ($all_courses as $course): ?>

    <!-- build unique modal for each un-registered course -->
    <div class="modal fade" id="<?php echo $course['id']; ?>" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><strong>Course Description</strong> - <?php echo $course['course_name'] ?></h4>
          </div>
          <div class="modal-body">
            <?php echo $course['description'] ?>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<?php endforeach; ?>
