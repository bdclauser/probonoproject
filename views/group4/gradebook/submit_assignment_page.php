
<div class="container">



  <div class="panel panel-default">


    <div class="panel-heading">
      <h2><strong>Assignment</strong> - <?= $assignment_name ?></h2>
    </div>
    <div class="panel-body">
      <form action="student_submit_assignment" method="post" id="submit_assignment">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="assignment_id" value="<?= $assignment_id ?>">
        <input type="hidden" name="course_id" value="<?= $course_id ?>">

        <textarea rows="5" class="form-control" name="assignment_comments" form="submit_assignment"></textarea>
      </form>
    </div>
    <div class="panel-footer">
      <button type="submit" form="submit_assignment" class="btn btn-success">Submit</button>
    </div>


  </div>






</div>
