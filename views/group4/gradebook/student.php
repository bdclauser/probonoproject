
<?php if($this->session->flashdata('submitted')): ?>
    <div class="alert alert-success">
      You've Submitted your assignment !
    </div>
<?php endif; ?>


<div class="container">

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h2>Grades</h2>
    </div>
    <div class="panel-body">
              <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th class="col-md-4">Assignments Name</th>
                      <th class="col-md-2">Due Date</th>
                      <th class="col-md-2">Points</th>
                      <th class="col-md-2">Maximum Points</th>
                      <th class="col-md-2">Submit Assignment</th>
                  </tr>
                  </thead>
                  <tbody id="gradesTable">

          <?php
          		$totalEarned = 0;
          		$totalAvailable = 0;
          		foreach ($grades_list as $grades_item) {

                $var = new DateTime($grades_item['due_date'], new DateTimeZone('America/New_York'));
                //$var->setTimezone(new DateTimeZone('America/New_York'));
                $due = $var->getTimestamp();

                $is_disabled = $due < $now ? 'disabled' : '';

          			$totalEarned += $grades_item['scored_points'];
          			$totalAvailable += $due < $now ? $grades_item['max_points'] : 0;
          			echo '<tr>';
          			echo '<td>'.$grades_item['assignment_name'].'</td>';
                echo '<td>'.$grades_item['due_date'].'</td>';
          			echo '<td>'.$grades_item['scored_points'].'</td>';
          			echo '<td>'.$grades_item['max_points'].'</td>';
                echo '<td style="text-align: center">
                          <form action="student_submit_assignment_page" method="post">
                            <input type="hidden" name="user_id" value="'.$grades_item['user_id'].'">
                            <input type="hidden" name="assignment_id" value="'.$grades_item['assignment_id'].'">
                            <input type="hidden" name="assignment_name" value="'.$grades_item['assignment_name'].'">
                            <input type="hidden" name="course_id" value="'.$grades_item['course_id'].'">

                            <button type="submit" class="btn btn-primary '.$is_disabled.'">Submit</button>
                          </form>
                      </td>';
          			echo '</tr>';
          		}
          		echo '</tbody></table>';
          		if($totalAvailable > 0){
          			$percent = round($totalEarned / $totalAvailable * 100, 2);

          			echo '<p>Total: ' . $totalEarned . '/' . $totalAvailable . ' (' . $percent . '%)</p>';
          		}else{
          			echo '<p>No grades.</p>';
          		}
          ?>
    </div>
    <div class="panel-footer">
        <a href="gradebook"><input  type="button" value="Done" class="btn btn-success"></a>
    </div>
  </div>
</div>
