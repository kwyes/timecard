<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Update Your Info <small>Creative!</small></h3>
  </div>
  <div class="panel-body">
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
            <input type="text" name="company_name" id="company_name" class="form-control input-sm" placeholder="Place Name">
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
            <input type="text" name="company_phone" id="company_phone" class="form-control input-sm" placeholder="Phone Number">
          </div>
        </div>
      </div>

      <div class="form-group">
        <input type="text" name="address" id="company_address" class="form-control input-sm" placeholder="Address">
      </div>

      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8">
          <div class="form-group">

          </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
          <div class="form-group">
            <label for="tType">TIMECARD TYPE</label>
            <select class="form-control" id="tType">

            </select>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-info btn-block btn-update" name="button">Update</button>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    fetch_company_info();
    // fetch_timecard_type();
  });
</script>
