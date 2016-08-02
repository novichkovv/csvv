<div class="row">
    <div class="col-md-2">
        <form action="" method="post">
            <button type="submit" name="download_btn" class="btn btn-lg green"><i class="fa fa-upload"></i> Download CSV</button>
        </form>
    </div>
</div>
<hr>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#file_input").change(function() {
            $("#fileupload").submit();
        });
    });
</script>