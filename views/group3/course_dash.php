

<!-- it would be great if this could be filtered (grade, teacher, course_name, etc..)-->



<div class="container">


    <div class="panel panel-default">
      <div class="panel-heading">
          <h2>Courses</h2>
      </div>
      <div class="panel-body">

        <table class="table table-striped">
            <thead>

                <tr>

                    <td><strong>Grade Level</strong></td>
                    <td><strong>Course Name</strong></td>
                    <td><strong>Teacher</strong></td>
                    <td><strong>Category</strong></td>

                    <td><strong>Time Start</strong></td>

                    <td><strong>Time End</strong></td>

                    <td colspan='2'></td>

                </tr>

            </thead>
            <tbody>

              <?php foreach($course_info as $row): ?>

                <tr>
                    <td>

                        <?php echo $row['min_gradelevel']; ?>

                    </td>

                    <td>

                        <?php
                            echo $row['course_name'];
                            if($row['cancelled']==1){
                              echo '<font color="red"><br>CANCELLED</font>';
                            }
                        ?>

                    </td>

                    <td>

                        <?php echo $row['teacher']; ?>

                    </td>

                    <td>

                        <?php echo @$row['category']['category_name']; ?>

                    </td>

                    <td>

                        <?php echo $row['time1start']; ?>

                    </td>

                    <td>

                        <?php echo $row['time1end']; ?>

                    </td>

              <!-- make these individual forms and tie them to routes************ -->

                    <td>

                        <?php echo form_open('course_details'); ?>

                            <input type="hidden" name="course_id" value="<?php echo $row['id'] ?>">

                            <button type="submit" class="btn btn-info" >details</button>

                        <?php echo form_close(); ?>

                    </td>

                    <td>
                      <?php if($user_permission[0]): ?>
                        <form action="course_delete" method="post" onsubmit="return confirm('Are you sure you want to delete this course?')">

                            <input type="hidden" name="course_id" value="<?php echo $row['id'] ?>">

                            <button type="submit" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i></button>

                        </form>
                      <?php endif; ?>

                    </td>

                </tr>

                <!-- // ********** -->

                    <?php
                        if($row['cancelled']){
                          echo "</font>";
                        }
                    ?>
              <?php endforeach; ?>
            </tbody>

        </table>

      </div>
      <div class="panel-footer">

          <!-- show add class button only if user is admin -->
          <?php if($user_permission[0]): ?>

              <a class="btn btn-default" href='add_class'>Add Course</a>
              <a style="display: inline-block" class="btn btn-default" href='view_categories'>View Categories</a>

          <?php endif; ?>


      </div>
    </div>

















</div>
