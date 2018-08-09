<div class="container">
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-user-add"><span class="glyphicon glyphicon-plus"></span> Add</button>
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table user-register-table header-fixed">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Name" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Phone #" disabled></th>
                    </tr>
                </thead>
                <tbody class="user-register-tbody">

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="userRegisterModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Register User</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="" class="member_mId" value="">
            <input type="text" name="" class="form-control input-sm member_name" placeholder="FullName">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_age" placeholder="Age">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_school" placeholder="School">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_address" placeholder="Address">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_emergencyname" placeholder="Emergency Name">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_emergencycontact" placeholder="Emergency Contact">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_contact" placeholder="Phone Number">
          </div>
          <div class="form-group">
            <input type="text" name="" class="form-control input-sm member_msp" placeholder="MSP">
          </div>
          <div class="form-group">
            <select id="userRegister_select" class="form-control">

            </select>
          </div>
          <div class="form-group">
            <textarea class="form-control input-sm member_allergy" rows="5" id="" placeholder="Allergy"></textarea>
          </div>
          <div class="form-group">
            <textarea class="form-control input-sm member_memo" rows="5" id="" placeholder="Memo"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-member-delete" name="button">Delete</button>
          <button type="button" class="btn btn-default btn-member-update" name="button">Update</button>
          <button type="button" class="btn btn-default btn-member-register" name="button">Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function () {
    fetch_timecard_member();
    fetch_user_type_register(2)
  });


$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.user-register-table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.user-register-table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>
