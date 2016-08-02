<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" action="<?php echo SITE_DIR; ?>results/" style="margin: 30px 0;">
                <label class="control-label col-md-2">Search</label>
                <div class="col-md-6">
                    <input type="text" class="form-control input-lg" name="search" value="<?php echo $_POST['search']; ?>" placeholder="Search..">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info btn-lg" name="search_btn"><i class="fa fa-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>
    <br><br>
    <?php if ($_POST['search']): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel panel-heading">
                        <h3 class="panel-title">Data Table</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" id="filter-form">
                                    <div class="portlet light" style="border: 1px solid #ccc;">
                                        <div class="portlet-body custom-datatable">
                                            <input type="hidden" class="form-control" id="global_search" placeholder="Search.." value="<?php echo $_POST['search']; ?>">
                                            <table class="table table-bordered" id="data_table">
                                                <thead>
                                                <tr>
                                                    <th>QTY</th>
                                                    <th>Part Number</th>
                                                    <th>Manufacturer</th>
                                                    <th>Product Line</th>
                                                    <th>Description</th>
                                                    <th>Datasheet</th>
                                                    <th>Link</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('data_table');
        var $filter_form = $("#filter-form");
        $filter_form.keydown(function(e) {
            if(e.keyCode == 13) {
                e.preventDefault();
                $(e.target).change();
            }
        });
        $filter_form.submit(function() {
            var $form = $(this);
            var $table = $('#data_table');
            var id = $table.attr('id');
            $("#" + id + ' .filter-field, .filter-field[data-id="' + id + '"]').each(function(){
                if($(this).val()) {
                    $("#" + $(this).attr('name') + "_sign").remove();
                    $("#" + $(this).attr('name') + "_value").remove();
                    $form.append('<input type="hidden" id="' + $(this).attr('name') + '_sign" name="params[' + $(this).attr('name') + '][sign]" value="' + $(this).attr('data-sign') + '">');
                    $form.append('<input type="hidden" id="' + $(this).attr('name') + '_value" name="params[' + $(this).attr('name') + '][value]" value="' + $(this).val() + '">');
                }
            });
        });
    });
</script>
