<div class="dual-list list-left">
          <div class="well text-right">
            <h3>User Type Register</h3>
              <div class="row">
                  <div class="col-md-10">
                      <div class="input-group">
                          <span class="input-group-addon glyphicon glyphicon-search"></span>
                          <input style="margin-top: 1px;" type="text" name="SearchDualList2" class="form-control" placeholder="search" />
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="btn-group">
                          <a class="btn btn-default selector" title="select all" data-toggle="modal" data-target="#uTypeModal"><i class="glyphicon glyphicon-unchecked"></i></a>
                      </div>
                  </div>
              </div>
              <ul id="uType_select" class="list-group">

              </ul>
          </div>
</div>


<div class="modal fade" id="uTypeModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Register User Type</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input style="margin-top: 6px;" type="text" name="" id="uType_register" class="form-control input-sm" placeholder="User Type Register">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-utype-register" name="button">Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function () {
    fetch_user_type_register(1);
  });

  $(function () {
    $('[name="SearchDualList2"]').keyup(function (e) {
        var code = e.keyCode || e.which;
        if (code == '9') return;
        if (code == '27') $(this).val(null);
        var $rows = $(this).closest('.dual-list').find('.list-group li');
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

});
</script>
