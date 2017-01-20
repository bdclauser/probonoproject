<?php if($this->session->flashdata('new_assignment')): ?>
  <div class="alert alert-success">
    <strong>Successfully created new assignment!</strong>
  </div>
<?php endif; ?>

<?php if($this->session->flashdata('edit_assignment')): ?>
  <div class="alert alert-success">
    <strong>Successfully edited assignment!</strong>
  </div>
<?php endif; ?>

<div class="container">

  <div class="panel panel-warning">
    <div class="panel-heading">
        <h2>Assignments - View</h2>
    </div>
    <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="col-md-1">Grade</th>
                <th class="col-md-4">Name</th>
                <th class="col-md-2">Maximum Points</th>
                <th class="col-md-2">Due Date</th>
                <th class="col-md-1">Notes</th>
                <th class="col-md-1">Edit</th>
                <th class="col-md-1">Delete</th>
              </tr>
            </thead>
            <tbody id="assignmentTable">
                <?php
                  //Tabulate all the assignments for this course.
                  //The actions for each button are handled in the JavaScript, main.js.
                  foreach($assignments as $row){

                      echo '
                        <tr>
                          <td>
                            <form class="" action="teacher_grade_assignment" method="post">
                              <input type="hidden" name="assignment" value="' . $row['assignment_id'] . '">
                              <input type="hidden" name="course" value="' . $courseID . '">
                              <button type="submit" class="btn btn-info grade">Grade</button>
                            </form>
                          </td>
                          <td>' . $row['assignment_name'] . '</td>
                          <td>' . $row['max_points'] . '</td>
                          <td>' . $row['due_date'] . '</td>
                          <td>
                            <button data-toggle="modal" data-target="#' . $row['assignment_id'] . '" class="btn btn-primary notes">Notes</button>

                          </td>
                          <td>
                            <form class="" action="teacher_edit_assignment" method="post">
                              <input type="hidden" name="assignment" value="' . $row['assignment_id'] . '">
                              <input type="hidden" name="course" value="' . $courseID . '">
                              <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                          </td>
                          <td>
                            <form class="" action="teacher_gradebook" method="post" onsubmit="return confirm(\'Are you sure you want to delete this assignment?\')">
                              <input type="hidden" value="1" name="delete">
                              <input type="hidden" name="assignment" value="' . $row['assignment_id'] . '">
                              <input type="hidden" name="course" value="' . $courseID . '">
                              <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                            </form>
                          </td>
                        </tr>';

                  };?>
            </tbody>
          </table>
    </div>
    <div class="panel-footer">

      <form style="display:inline-block" action="teacher_new_assignment" method="post">
        <input type="hidden" name="course" value="<?= $courseID ?>">
        <button type="submit" class="btn btn-success">Add New</button>
      </form>

      <form style="display:inline-block" action="submit_final_grade" method="post">
          <input type="hidden" name="course" value="<?= $courseID ?>">
          <button class="btn btn-default" type="submit" name="button">Submit Final Grade</button>
      </form>

    </div>
  </div>



</div>


<?php  foreach ($assignments as $row): ?>

    <!-- build unique modal for each registered course -->
    <div class="modal fade" id="<?php echo $row['assignment_id']; ?>" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><strong>Assignment Notes</strong> - <?php echo $row['assignment_name'] ?></h4>
          </div>
          <div class="modal-body">
            <?php echo $row['notes']; ?>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<?php endforeach; ?>
