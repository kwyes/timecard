    <div class="vertical-center">
      <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-bookmark"></span>Quick Shortcuts</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                              <a data-toggle="tab" href="#menu1" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-list-alt"></span> <br/>Info</a>
                              <a data-toggle="tab" href="#menu2" href="#" class="btn btn-warning btn-lg" role="button"><span class="glyphicon glyphicon-bookmark"></span> <br/>T-type</a>
                              <a data-toggle="tab" href="#menu3" href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-signal"></span> <br/>Reports</a>
                              <a data-toggle="tab" href="#menu4" href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span> <br/>U-type</a>
                            </div>
                            <div class="col-xs-6 col-md-6">
                              <a data-toggle="tab" href="#menu5" href="#" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-user"></span> <br/>Users</a>
                              <a data-toggle="tab" onclick="signout();" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-file"></span> <br/>Sign Out</a>
                              <a data-toggle="tab" href="#menu7" href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-picture"></span> <br/>Image</a>
                              <a data-toggle="tab" href="#menu8" href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-tag"></span> <br/>None</a>
                            </div>
                        </div>
                        <a href="/timecard" class="btn btn-success btn-lg btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                  <?php include_once("companyinfo.php"); ?>
                </div>
                <div id="menu2" class="tab-pane fade">
                  <?php include_once("timecard_type_register.php"); ?>
                </div>
                <div id="menu3" class="tab-pane fade">
                  <?php include_once("reports.php"); ?>
                </div>
                <div id="menu4" class="tab-pane fade">
                  <?php include_once("user_type_register.php"); ?>
                </div>
                <div id="menu5" class="tab-pane fade">
                  <?php include_once("user_register.php"); ?>
                </div>
                <div id="menu6" class="tab-pane fade">

                </div>
                <div id="menu7" class="tab-pane fade">
                  <h3>Menu 3</h3>
                  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
                <div id="menu8" class="tab-pane fade">
                  <h3>Menu 3</h3>
                  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
