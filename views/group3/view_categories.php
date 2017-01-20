<div>

    <div style="padding: 0" class="panel panel-default col-centered col-lg-6 col-md-6 col-sm-8 col-xs-12">
        <div class="panel-heading">
            <h2>Course Categories</h2>
            <a class="btn btn-success" href='add_category'>Add Category</a>
        </div>

        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                  <?php

                    $flashdata = $this->session->flashdata();

                    if($this->session->flashdata('MTZ')){
                      echo '<div class="alert alert-danger">';
                      echo '<strong>There are courses currently assigned to this category. Please re-assign them before deleting this category</strong>';
                      echo '<ul>';
                      foreach($flashdata['MTZ'] as $cat){
                        echo '<li>'.$cat['course_name'].'</li>';
                      }
                      echo '</ul>';
                      echo '</div>';
                    } else if($this->session->flashdata('LTZ')){
                      echo '<div class="alert alert-success">';
                      echo '<strong>'.$flashdata['LTZ'].'</strong>';
                      echo '</div>';
                    }

                  ?>

                    <?php foreach($categories as $category): ?>
                        <tr>
                            <td><?php echo $category->CID; ?></td>
                            <td><?php echo $category->category_name; ?></td>
                            <td>
                                <form action="delete_category" method="post" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    <input type="hidden" name="CID" value="<?php echo $category->CID; ?>">
                                    <button type="submit" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
