
  <div style="text-align: center" class="page-header">
    <h2>Assignments - Add New</h2>
  </div>

<div class="container">

  <div class="panel panel-success">
    <div class="panel-heading">
      <h3><?php echo $course['course_name']; ?></h3>
    </div>
    <div class="panel-body">
          <form role="form" action="teacher_new_assignment" method="post" id="new_assignment">
            <input type="hidden" name="course" value="<?= $courseID ?>">
        		<div class="row">
        			<div class="form-group">
        				<label for="name">Name</label>
        				<input class="form-control" name="name" tabindex="10" required>
        			</div>
        		</div>
        		<div class="row">
        			<div class="form-group">
        				<label for="maxPoints">Maximum Points</label>
        				<input type="number" min="0" max="30000" class="form-control" name="maxPoints" tabindex="20" required>
        			</div>
        			<div class="form-group">
        				<label for="dueDate">Due Date</label>
        				<input type="date" class="form-control" name="dueDate" tabindex="30" required>
        			</div>
        		</div>
        		<div class="row">
        			<div class="form-group">
        				<label for="notes">Notes (optional)</label>
        				<textarea class="form-control" name="notes" tabindex="40"></textarea>
        			</div>
        		</div>
        	</form>
    </div>
    <div class="panel-footer">
      <input type="submit" form="new_assignment" name="submit" value="Create Assignment" class="btn btn-success" tabindex="50">
      
      <form style="display: inline-block" action="teacher_gradebook" method="post">
        <input type="hidden" name="course" value="<?= $courseID ?>">
        <button type="submit" class="btn btn-info">Return</button>
      </form>
    </div>
  </div>



</div>
