<div id="content">
    <div class="container-fluid">
        <div class="lock-container">
            <h1>ICPAK - Kenya, social</h1>
            <?php 
			  echo form_open($this->uri->uri_string(),"class='form-horizontal'"); 
			 ?>
            <div class="panel panel-default text-center">
                <img src="<?php echo base_url();?>assets/themes/themekit/images/logo/download.png" class="img-circle" style="height:125px;">
                <div class="panel-body">
                    <input class="form-control" type="text" placeholder="Username">
                    <input class="form-control" type="password" placeholder="Enter Password">
                    <a href="<?php echo base_url()?>site/home" class="btn btn-primary">Login <i class="fa fa-fw fa-unlock-alt"></i></a>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>