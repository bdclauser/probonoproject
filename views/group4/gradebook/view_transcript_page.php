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
              <th>Final Grade</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($semester as $class): ?>
              <tr>
                <td><?= $class['course_id'] ?></td>
                <td><?= $class['course_name'] ?></td>
                <td><?= $class['teacher_name'] ?></td>
                <td><?= $class['final_grade'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>

  <?php endforeach; ?>

</div>
