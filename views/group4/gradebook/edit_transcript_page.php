<div class="container">


  <?php foreach ($semesters as $semester): ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <?= @$semester[0]['semester_name'] ?>
      </div>
      <div class="panel-body">

        <table class="table table-striped">
          <thead>
            <tr>
              <th>Course ID</th>
              <th>Course name</th> <!--  -->
              <th>Teacher</th>
              <th>Current Final Grade</th>
              <th>Change Final Grade</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($semester as $class): ?>
              <tr>
                <td><?= $class['course_id'] ?></td>
                <td><?= $class['course_name'] ?></td>
                <td><?= $class['teacher_name'] ?></td>
                <td><?= $class['final_grade'] ?></td>
                <td>
                  <form class="form-inline" action="submit_new_transcript" method="post">
                    <input type="hidden" name="semester_id" value="<?= $class['semester_id'] ?>">
                    <input type="hidden" name="course_id" value="<?= $class['course_id'] ?>">
                    <input type="hidden" name="user_id" value="<?= $class['user_id'] ?>">
                    <div class="input-group">
                        <input class="form-control" type="text" name="new_final">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </span>
                    </div>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>

  <?php endforeach; ?>

</div>
