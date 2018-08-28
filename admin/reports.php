<div class="panel">
<!-- <div class="panel panel-primary"> -->
  <div class="panel-heading">
    <h3 class="panel-title">Reports</h3>
    <div class="pull-right">
      <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
        <i class="glyphicon glyphicon-search"></i>
      </span>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#reports_table" placeholder="Filter" />
      <input type="text" class="form-control" id="today_date" name="" value="<?php echo date('Y-m-d'); ?>">
    </div>
  </div>
  <table class="table table-hover" id="reports_table">
    <thead class="">
      <tr class="">
        <th>Name</th>
        <th width="15%">Phone #</th>
        <th width="19%">Date</th>
        <th width="15%">In-Time</th>
        <th width="15%">Out-Time</th>
        <th width="15%">Duration</th>
      </tr>
    </thead>
    <tbody class="">

    </tbody>
  </table>
  <script>
    $(document).ready(function(){
      fetch_reports();
      // alert($('.today_date').val());
    });

    $(function() {
        $( "#today_date" ).datepicker({
          dateFormat: "yy-mm-dd",
          onSelect: function (date) {
            fetch_reports();
          }
        });
    });


    (function(){
        'use strict';
      var $ = jQuery;
      $.fn.extend({
        filterTable: function(){
          return this.each(function(){
            $(this).on('keyup', function(e){
              $('.filterTable_no_results').remove();
              var $this = $(this),
                            search = $this.val().toLowerCase(),
                            target = $this.attr('data-filters'),
                            $target = $(target),
                            $rows = $target.find('tbody tr');

              if(search == '') {
                $rows.show();
              } else {
                $rows.each(function(){
                  var $this = $(this);
                  $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
                })
                // if($target.find('tbody tr:visible').size() === 0) {
                //   var col_count = $target.find('tr').first().find('td').size();
                //   var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
                //   $target.find('tbody').append(no_results);
                // }
              }
            });
          });
        }
      });
      $('[data-action="filter"]').filterTable();
    })(jQuery);

    $(function(){
        // attach table filter plugin to inputs
      $('[data-action="filter"]').filterTable();

      $('#search').on('click', '.panel-heading span.filter', function(e){
        var $this = $(this),
          $panel = $this.parents('.panel');

        $panel.find('.panel-body').slideToggle();
        if($this.css('display') != 'none') {
          $panel.find('.panel-body input').focus();
        }
      });
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
</div>
