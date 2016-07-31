<div class="row">
    <div class="col-md-2">
        <form action="" method="post" enctype="multipart/form-data" id="fileupload">
                        <span class="btn btn-lg green fileinput-button">
                            <i class="fa fa-upload"></i>
                            <span> Upload CSV </span>
                            <input id="file_input" type="file" name="file">
                        </span>
        </form>
    </div>
</div>
<hr>
<div class="row">

    <div class="col-md-12">
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <strong>Error!</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="post" id="filter-form">
            <div class="portlet light" style="border: 1px solid #ccc;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-list"></i>
                        <span class="caption-subject bold uppercase"> Data Table</span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions">
                        <button class="btn blue btn-outline" type="submit" name="download_btn"><i class="fa fa-download"></i> Download CSV</button>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="data_table">
                        <thead>
                        <tr>
                            <th>
                                <input data-sign="=" type="text" class="form-control filter-field" name="qty" placeholder="Search..">
                            </th>
                            <th>
                                <input data-sign="=" type="text" class="form-control filter-field" name="part_number" placeholder="Search..">
                            </th>
                            <th>
                                <input data-sign="=" type="text" class="form-control filter-field" name="manufacturer" placeholder="Search..">
                            </th>
                            <th>
                                <input data-sign="=" type="text" class="form-control filter-field" name="product_line" placeholder="Search..">
                            </th>
                            <th>
                                <input data-sign="like" type="text" class="form-control filter-field" name="description" placeholder="Search..">
                            </th>
                            <th>
                                <!--                            <input data-sign="=" type="text" class="form-control filter-field" name="datasheet" placeholder="Search..">-->
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>QTY</th>
                            <th>Part Number</th>
                            <th>Manufacturer</th>
                            <th>Product Line</th>
                            <th>Description</th>
                            <th>Datasheet</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="edit_modal" role="dialog" aria-hidden="true">
    <div class="page-loading page-loading-boxed">
        <img src="<?php echo SITE_DIR; ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
        <span> &nbsp;&nbsp;Chargement... </span>
    </div>
    <div class="modal-dialog">
        <div class="row">
            <div class="col-md-12">
                <form method="post" id="edit_form" class="form-horizontal">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-cogs"></i> Edit Record</div>
                            <div class="actions">
                                <button type="submit" class="btn btn-circle  btn-default btn-sm">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                        <div class="portlet-body" id="edit_form_container">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" role="dialog" aria-hidden="true">
    <div class="page-loading page-loading-boxed">
        <img src="<?php echo SITE_DIR; ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
        <span> &nbsp;&nbsp;Chargement... </span>
    </div>
    <div class="modal-dialog modal-sm">
        <div class="row">
            <div class="col-md-12">
                <form id="delete_form" method="post">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-cogs"></i> Remove</div>
                        </div>
                        <div class="portlet-body">
                            Remove Record from the Data Base?<br><br>
                            <div class="form-group text-center">
                                <button class="btn blue" type="submit">Remove</button>
                                <input type="hidden" id="delete_id" name="delete_id">
                                <button class="btn green btn-outline" data-dismiss="modal" type="button">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#file_input").change(function() {
            $("#fileupload").submit();
        });
        ajax_datatable('data_table');
        $("body").on("click", ".edit_btn", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'get_edit_form',
                'values': {'id': id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#edit_form_container").html(respond.template);
                        },
                        function (respond) { //fail
                            Notifier.error('Unexpected Error');
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("submit", "#edit_form", function () {
            var params = {
                'action': 'edit_record',
                'get_from_form': 'edit_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            Notifier.success('The record has been successfully edited');
                            ajax_datatable('data_table');
                            $("#edit_modal").modal('hide');
                        },
                        function (respond) { //fail
                            Notifier.error('Unexpected Error');
                        }
                    );
                }
            };
            ajax(params);
            return false;
        });

        $("body").on("click", ".delete_btn", function () {
            var id = $(this).attr('data-id');
            $("#delete_id").val(id);
        });

        $("body").on("submit", "#delete_form", function () {
            var params = {
                'action': 'delete_record',
                'get_from_form': 'delete_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            Notifier.success('The record has been successfully deleted');
                            ajax_datatable('data_table');
                            $("#delete_modal").modal('hide');
                        },
                        function (respond) { //fail
                            Notifier.error('Unexpected Error');
                        }
                    );
                }
            };
            ajax(params);
            return false;
        });

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
<style>
    #file_input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        -ms-filter: 'alpha(opacity=0)';
        font-size: 200px;
        direction: ltr;
        cursor: pointer;
    }
    .DTTT {
        display: none;
    }
    #data_table_filter {
        display: none;
    }
</style>