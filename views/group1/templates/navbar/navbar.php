<style>
    .row {
        padding: 0;
        margin: 0;
        width: 100%;
    }
    .navbar {
        margin: 0 0 10px 0;
        width: 100%;
    }
    .box {
        padding: 0;
    }
</style>

<!-- navbar start -->
    <div class="row">
        <nav class="navbar navbar-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand" >hheducators</div>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo base_url(); ?>">Dashboard<span class="sr-only">(current)</span></a></li>
                    <li><a href="gradebook">Gradebook</a></li>
                </ul>


                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo base_url('courses'); ?>">Courses</a></li>
                    <!-- this will be full of group specific links -->
                    <!--to be added on completion of entire project-->
						<?php if($reg_clearance[0] || $reg_clearance[2]): ?>
							<li><a href="<?php echo base_url('registration') ?>">Registration</a></li>
                        <?php endif; ?>
						
                        <li role="separator" class="divider"></li>
                        <li><a href="log_out">Log Out</a></li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
<!-- navbar end -->

<!-- responsive project box start -->

<div class="row">
        <div class="box col-centered col-lg-11 col-md-11 col-sm-12 col-xs-12">

            <!-- insert content || other group projects here

            **** this will be a controller file of sorts ****
            **** will decide which page to display based on button clicked **** -->
