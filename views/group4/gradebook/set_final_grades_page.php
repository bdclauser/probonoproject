<?php $this->session->set_flashdata('students_array', $students_array); ?>


<div class="container">
  <div class="panel panel-warning">
      <div class="panel-heading">
          <h2>Submit Final Grades</h2>
      </div>
      <div class="panel-body">

        <form action="save_finals" method="post" id="set_final_form" onsubmit="return confirm('Are you sure you want to submit final grades? \n\nThis will be irreversible.');" >

          <table class="table table-striped">
              <thead>
                <tr>
                  <td><strong>Student ID</strong></td>
                  <td><strong>Student Name</strong></td>
                  <td><strong>Current Grade</strong></td>
                  <td><strong>Final Grade</strong></td>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($students_array as $student): ?>
                  <tr>
                    <td><?= $student['student_id'] ?></td>
                    <td><?= $student['student_name'] ?></td>
                    <td><?= $student['final_grade'] ?> %</td>
                    <td class="col-md-2">
                      <input type="text" class="form-control" name="letter_grade[<?= $student['student_id'] ?>]" required>
                    </td>
                  </tr>

                <?php endforeach; ?>

              </tbody>
          </table>


        </form>

      </div>
      <div class="panel-footer">
          <button type="submit" form="set_final_form" class="btn btn-success" >Submit</button>
      </div>
  </div>
</div>
