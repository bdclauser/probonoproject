<div style="text-align: center" class="page-header">
  <h2>Assignments - Edit</h2>
</div>


<div class="container">

  <div class="panel panel-warning">
    <div class="panel-heading">
      <h3><?php echo $assignment["assignment_name"]; ?></h3>
    </div>
    <div class="panel-body">
          <form role="form" action="teacher_edit_assignment" method="post" id="edit_assignment">

            <input type="hidden" name="course" value="<?php echo $assignment["course_id"]; ?>">
            <input type="hidden" name="assignment" value="<?php echo $assignment["assignment_id"]; ?>">

            <div class="row">
              <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="name" tabindex="10" value="<?php echo $assignment["assignment_name"]; ?>" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label for="maxPoints">Maximum Points</label>
                <input type="number" min="0" max="30000" class="form-control" name="maxPoints" tabindex="20" value="<?php echo $assignment["max_points"]; ?>" required>
              </div>
              <div class="form-group">
                <label for="dueDate">Due Date</label>
                <input type="date" class="form-control" name="dueDate" tabindex="30" value="<?php echo $assignment["due_date"]; ?>" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label for="notes">Notes (optional)</label>
                <textarea class="form-control" name="notes" tabindex="40"><?php echo $assignment["notes"]; ?></textarea>
              </div>
            </div>

          </form>
    </div>
    <div class="panel-footer">
      <input type="submit" form="edit_assignment" name="submit" value="Save Changes" class="btn btn-success" tabindex="50">
      <form style="display: inline-block" action="teacher_gradebook" method="post">
        <input type="hidden" name="course" value="<?= $assignment["course_id"] ?>">
        <button type="submit" class="btn btn-info">Return</button>
      </form>
    </div>
  </div>





</div>
