
<div class="mainContent">

    <h1>Edit Course</h1>

    <?php echo form_open('course_update'); ?>

        <table class="table table-striped">
            <tr>

                <td>Course ID</td>

                <td><input class="form-control" type='text' maxlength='5' name='id' value='<?= $course_info['id']?>' required/></td>

            </tr>

            <tr>

                <td>Course Name</td>

                <td><input class="form-control" type='text' name='course_name' value='<?= $course_info['course_name']?>' required/></td>

            </tr>
            <tr>

                <td>Teacher</td>

                <td>
                  <?php echo '<select name="teacher" class="form-control" >';

                    foreach ($teachers as $teacher) {
                    			if($course_info['teacher'] == $teacher['user_id']){

                    				  echo "<option selected value=".$teacher['user_id']."> {".$teacher['user_id']."}  ".$teacher['last_name'].   " , ".$teacher['first_name']."</option>";

                  				} else {

                              echo "<option value=".$teacher['user_id']."> {".$teacher['user_id']."}  ".$teacher['last_name'].   " , ".$teacher['first_name']."</option>";

                    			}

                    }

                    echo '</select> ';

                  ?>
                </td>

            </tr>
			            <tr>

                <td>Category</td>

                <td><?php echo '<select name="category" class="form-control" required>';

                    foreach ($categories as $cat) {

						if($course_info['category'] == $cat->CID){

							echo "<option selected value=".$cat->CID.">".$cat->category_name."</option>";

						}

						else{

							echo "<option value=".$cat->CID.">".$cat->category_name."</option>";

						}

                    }

                    echo '</select>';

                ?></td>

            </tr>
            <tr>

                <td>Description</td>

                <td><input class="form-control" type='text' name='description' value='<?= $course_info['description']?>'/></td>

            </tr>
            <tr>

                <td>Start Time</td>

                <td><input class="form-control" type='time' name='time1start' value='<?= $course_info['time1start']?>' required/></td>

            </tr>
            <tr>

                <td>End Time</td>

                <td><input class="form-control" type='time' name='time1end' value='<?= $course_info['time1end']?>' required/></td>

            </tr>
            <tr>

                <td>Secondary Start Time</td>

                <td><input class="form-control" type='time' name='time2start' value='<?= $course_info['time2start']?>'/></td>

            </tr>
            <tr>

                <td>Secondary End Time</td>

                <td><input class="form-control" type='time' name='time2end' value='<?= $course_info['time2end']?>'/></td>

            </tr>
            <tr>

                <td>Tuition Cost</td>

                <td><input class="form-control" type='number' min='0' name='tuition' value='<?= $course_info['tuition']?>'/></td>

            </tr>
            <tr>

                <td>Fees</td>

                <td><input class="form-control" type='number' min='0' name='fees' value='<?= $course_info['fees']?>'/></td>

            </tr>
            <tr>

                <td>Minimum Grade Level</td>

                <td><input class="form-control" type='text' maxlength='3' name='min_gradelevel' value='<?= $course_info['min_gradelevel']?>'/></td>

            </tr>
            <tr>

                <td>Maximum Grade Level</td>

                <td><input class="form-control" type='text' maxlength='3' name='max_gradelevel' value='<?= $course_info['max_gradelevel']?>'/></td>

            </tr>
            <tr>

                <td>Minimum Class Size</td>

                <td><input class="form-control" type='number' min='0' name='min_students' value='<?= $course_info['min_students']?>'/></td>

            </tr>
            <tr>

                <td>Maximum Class Size</td>

                <td><input class="form-control" type='number' min='0' name='max_students' value='<?= $course_info['max_students']?>'/></td>

            </tr>
            <tr>

                <td>Maximum Waitlist Size</td>

                <td><input class="form-control" type='number' min='0' name='max_waitlist' value='<?= $course_info['max_waitlist']?>'/></td>

            </tr>
            <tr>

                <td>Homework Hours</td>

                <td><input class="form-control" type='number' min='0' name='homework_hours' value='<?= $course_info['homework_hours']?>'/></td>

            </tr>
            <tr>

                <td>Notes</td>

                <td><input class="form-control" type='text' name='notes' value='<?= $course_info['notes']?>'/></td>

            </tr>
            <tr>

                <td>Highschool Class</td>

                <input type='hidden' name='highschool_class' value='0'/>

                <td><input class="form-control" type='checkbox' name='highschool_class' value='1' <?= $highschool?>/></td>

            </tr>

            <tr>

                <td>Cancelled</td>

                <input type='hidden' name='cancelled' value='0'/>

                <td><input class="form-control" type='checkbox' name='cancelled' value='1' <?= $cancelled?>/></td>

            </tr>

            <tr>

                <td><input class="btn btn-warning" type='submit' name='editClass' value='Update' /></td>

            </tr>

        </table>
    <?php echo form_close(); ?>
</div>
