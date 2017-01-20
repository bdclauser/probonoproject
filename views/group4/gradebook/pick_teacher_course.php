<div class="container">

  <div class="panel panel-warning">
    <div class="panel-heading">
      <h3>Teacher Courses</h3>
    </div>
    <div class="panel-body">
      <form role="form" method="post" action="teacher_gradebook" id="teacher_form">
        <input type="hidden" name="teacher_id" value="<?= $teacher_id ?>">
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


</div>
