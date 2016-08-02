<div class="row">
    <div class="col-md-8">
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <strong>Error!</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="fileupload">
                        <span style="float: left" class="btn btn-lg green fileinput-button">
                            <i class="fa fa-upload"></i>
                            <span> Upload CSV </span>
                            <input id="file_input" type="file" name="file">

                        </span><img id="preloader" style="float: left; height: 45px; display: none;" src="<?php echo SITE_DIR; ?>images/preloader.GIF">
        </form>
    </div>

</div>
<hr>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#file_input").change(function() {
            $("#fileupload").submit();
            $(".fileinput-button").attr('disabled', 'disabled')
            $("#preloader").show();
        });
    });
</script>