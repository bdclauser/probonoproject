
<?php
  $current = "";
  if($semester_info['current']){
    $current = " - Current Semester";
  }

?>


<div class="container">


  <div class="panel panel-default">
    <div class="panel-heading">
      <!-- put in individual forms linked to individual routes -->
      <div style="width: 100%; text-align: center" class="container">

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#edit_semester_modal">Edit Semester</button>
        </div>



        <form class="col-lg-4 col-md-4 col-sm-4 col-xs-12" action="setCurrent" method="post">
          <input type="hidden" name="semester_id" value="<?php echo $semester_id ?>">
          <button type="submit" class="btn btn-warning">Set as Current</button>

        </form>

        <form class="col-lg-4 col-md-4 col-sm-4 col-xs-12" action="deleteSemester" method="post">
            <input type="hidden" name="semester_id" value="<?php echo $semester_id ?>">
            <button type="submit" class="btn btn-danger">Delete Semester</button>

        </form>

      </div>
      <!-- //************************************ -->
    </div>
    <div class="panel-heading">
      <h3><?php echo $semester_info['semester_name'].' Courses'.$current ?></h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">

          <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th class="col-md-2">Course Name</th>
                    <th class="col-md-2">Instructor</th>
                    <th class="col-md-2">Start Time</th>
                    <th class="col-md-2">End Time</th>
                    <th class="col-md-1">Description</th>
                    <th class="col-md-1">Details</th>
                    <th class="col-md-1">Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($current_courses as $course){
                      echo '<tr>
                      <td>' . $course['course_name'] . '</td>
                      <td>' . $course['first_name'] .' '.$course['middle_initial'].' '.$course['last_name'].' '. '</td>
                      <td>' . $course['time1start'] . '</td>
                      <td>' . $course['time1end'] . '</td>
                      <td>
                        <a href="#myModal" data-toggle="modal" id="'.$course['description'].'" data-target="#edit-modal" class="btn btn-primary">Description</a>
                      </td>
                      <td>
                          <form method="post" role="form" action="course_details">
                              <button type="submit" class="btn btn-primary" name="course_id" value="'.$course['course_id'].'">Details</button>
                              <input type="hidden" value="'.$_SERVER['REQUEST_URI'].'" name="url">
                          </form>
                      </td>
                      <td>
                        <form method="post" role="form" action="remove_class">
                            <input type="hidden" value='.$course['id'].' name="remove_course">
                            <input type="hidden" value='.$semester_info['semester_id'].' name="remove_semester">
                            <input type="submit" class="btn btn-danger" value="Remove">
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

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>Add a Course</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="col-md-2">Course Name</th>
                <th class="col-md-2">Instructor</th>
                <th class="col-md-2">Start Time</th>
                <th class="col-md-2">End Time</th>
                <th class="col-md-1">Description</th>
                <th class="col-md-1">Details</th>
                <th class="col-md-1">Add</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($all_courses as $course){
                echo '<tr>
                <td>' . $course['course_name'] . '</td>
                <td>' . $course['first_name'] .' '.$course['middle_initial'].' '.$course['last_name'].' '. '</td>
                <td>' . $course['time1start'] . '</td>
                <td>' . $course['time1end'] . '</td>
                <td>
                <a href="#myModal" data-toggle="modal" id="'.$course['description'].'" data-target="#edit-modal" class="btn btn-primary">Description</a>
                </td>
                <td>
                <form method="post" role="form" action="course_details">
                <button type="submit" class="btn btn-primary" name="course_id" value="'.$course['id'].'">Details</button>
                <input type="hidden" value="'.$_SERVER['REQUEST_URI'].'" name="url">
                </form>
                </td>
                <td>
                <form method="post" role="form" action="new_class">
                <input type="hidden" value='.$course['id'].' name="add_course">
                <input type="hidden" value='.$semester_info['semester_id'].' name="add_semester">
                <input type="submit" class="btn btn-success" value="Add">
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

<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Course Description</h4>
            </div>
            <div class="modal-body edit-content">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" id="edit_semester_modal" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div style="overflow: auto;" class="modal-content">

      <div class="">
          <h2 style="text-align: center;">Edit Semester Form</h2>

          <br /><br /><br />

          <div class="container col-lg-12 col-md-12 col-sm-12">
              <form class="form-horizontal"  method='post' action='semesterEditor'>
                <input type="hidden" name="semester_id" value="<?php echo $semester_id ?>">
                  <div class="form-group row">
                      <div class="col-md-4 col-sm-4">
                          <label class="control-label" for="semester_name">Semester Name:</label>
                          <input type="text" class="form-control" id="semester_name" name="semester_name" placeholder="Enter semester name" value="<?= $semester_info['semester_name'] ?>" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label" for="start_date">Start Date:</label>
                          <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Enter date as MM/DD/YYYY"  value="<?= $semester_info['start_date'] ?>" required>
                      </div>
                  </div>
                              <div class="form-group row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label" for="end_date">End Date:</label>
                          <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Enter date as MM/DD/YYYY"  value="<?= $semester_info['end_date'] ?>" required>
                      </div>
                  </div>
                      <div style="margin-top: 10px" class="form-group">
                          <div style="width: 100%" class="container">
                              <button type="submit" class="btn btn-primary" name="add_semester">Submit</button>
                          </div>
                      </div>

              </form>
          </div>
      </div>



    </div>
  </div>
</div>
