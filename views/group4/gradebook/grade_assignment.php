<?php if($this->session->flashdata('flash_success')): ?>
    <div class="alert alert-success">
        You've successfully updated grades !
    </div>
<?php endif; ?>



<div style="text-align: center" class="page-header">
    <h2>Grade Assignment</h2>
</div>

<div class="container">

  <div class="panel panel-info">


          <div class="panel-heading">
            <h3><?php echo $assignment["assignment_name"]; ?></h3>
          </div>
          <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="col-md-8">Student Name</th>
                    <th class="col-md-2">Points</th>
                    <th class="col-md-2">View Submission</th>
                  </tr>
                </thead>
            		<tbody>
                  <!-- for loop in here to replace useless $tableHTML -->
            			<?php echo $tableHTML; ?>

            		</tbody>
            </table>
          </div>

        <div class="panel-footer">
              <button form="grade_assignment_form" type="submit" class="btn btn-success">Submit</button>

              <form style="display: inline-block" action="teacher_gradebook" method="post">
                <input type="hidden" name="course" value="<?= $assignment["course_id"] ?>">
                <button type="submit" class="btn btn-info">Return</button>
              </form>
        </div>
  </div>



</div>
