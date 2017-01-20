<div class="container">


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3>Student Courses</h3>
      </div>
      <div class="panel-body">
        <form role="form" method="post" action="student_gradebook" id="student_form">
          <input type="hidden" name="user_id" value="<?= $student_id ?>">
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
          <input type="hidden" name="user_id" value="<?= $student_id ?>">

          <button class="btn btn_default" type="submit" name="button">View Transcript</button>
        </form>

        <?php if ($reg_clearance[0]): ?>
          <form style="display: inline-block" action="edit_transcript" method="post">
            <input type="hidden" name="user_id" value="<?= $student_id ?>">

            <button class="btn btn_default" type="submit" name="button">Edit Transcript</button>
          </form>
        <?php endif; ?>
      </div>
    </div>

</div>
