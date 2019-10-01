<!-- Confirm Receive Turnover Item Modal -->
<div class="modal fade" id="confirm-receive-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Confirm Request</h4>
      </div>
      <div class="modal-body">
        <label>Turnover item was already received</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="receive-confirm-btn" type="button" class="btn btn-warning">Proceed</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var selectedId;
        var turnoverRequestTable = $('#turnover-request-table').DataTable(
            {
                "order": [[ 0, "desc" ]],
                responsive: true,
                "columnDefs": [
                    { "width": "22%", "targets": 4 },
                    { "width": "15%", "targets": 3 },
                    { "width": "23%", "targets": 2 },
                    { "width": "10%", "targets": 0, "visible": false},
                ]
            }
        );
        var receivedItemsTable = $('#received-items-table').DataTable(
            {
                "order": [[ 0, "desc" ]],
                responsive: true,
                "columnDefs": [
                    { "width": "10%", "targets": 3 },
                    { "width": "25%", "targets": 2 },
                    { "width": "20%", "targets": 1 },
                ]
            }
        );
        //get Selected row id
        $('#turnover-request-table tbody').on( 'click', 'tr', function () {
            var selectedRow = turnoverRequestTable.row( this ).data();
            selectedId = selectedRow[0];
        } );

        $('#receive-confirm-btn').click(function() {
            $('#confirm-receive-modal').modal('toggle');
            $.ajax({
                url: "<?php echo base_url(); ?>barangay/barangay_home/receive_turnover_request/" + selectedId,
                type: 'GET',
                success: function(result) {
                    if (result == 'Success') {
                        alert('Received Successfully');
                    } else {
                        alert('Received Failed')
                    }
                    location.reload(); // then reload the page.

                }
            });
        });
    });

</script>

<script>
$(document).ready(function() {
  var ctx = $("#lost-found-chart");
    //line chart data

    window.chartColors = {
      red: 'rgba(231, 76, 60,1.0)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgba(46, 204, 113,1.0)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(201, 203, 207)'
    };

    var data = {
      labels: [],
      datasets: [{
                    label: "Lost",
                    data: <?php echo $lost_reports; ?>,
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    fill: false
                }, {
                    label: "Found",
                    data: <?php echo $found_reports; ?>,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    fill: false
                }]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        title : {
            display : true,
            position : "top",
            text : "Daily Lost & Found Reports",
        },
        legend : {
            display : true,
            position : "bottom"
        },
          tooltips: {
              mode: 'index',
              intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          scales: {
            xAxes: [{
              type: "time",
              time: {
                unit: 'day',
                unitStepSize: 1,
                round: 'day',
                tooltipFormat: "MMM-DD",
              }
            }],
            yAxes: [{
              gridLines: {
                color: "black",
                borderDash: [2, 5],
              },
              scaleLabel: {
                display: false
              },
              ticks: {
                max: <?php echo $lf_max_count;?>,
                min: 0,
                stepSize: <?php echo ($lf_max_count/4);?>
            }
            }]
          }
    };

    //create Chart class object
    var myChart = new Chart(ctx, {
      type: "line",
      data: data,
      options: options
    });

    $('#lfchart-filter').on('change', function() {
      var typeValue = this.value;
      $.ajax({
        url: "<?php echo base_url();?>barangay/Barangay_home/lf_chart_filter_date",
        type: 'GET',
        dataType: 'json',
        data: {
          type: typeValue
        },
        success: function(json) {
          $("#lf-timeago").html("Last updated on " + moment().format("hh:mm A"));
          var lfMaxCount = json['lf_max_count'];
          var lostReports = json['lost_reports'];
          var foundReports = json['found_reports'];
          myChart.data.datasets[0].data = lostReports;
          myChart.data.datasets[1].data = foundReports;

          switch (typeValue) {
            case "Daily":
            myChart.data.labels = [];
              myChart.options.title.text = "Daily Lost & Found Reports";
              myChart.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'day',
                  unitStepSize: 1,
                  round: 'day',
                  tooltipFormat: "MMM-DD",
                }
              }];
              myChart.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: lfMaxCount,
                    min: 0,
                    stepSize: (lfMaxCount/4)
                }
              }];
              break;
            case "Weekly":
            myChart.options.title.text = "Weekly Lost & Found Reports";
              myChart.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'week',
                  unitStepSize: 1,
                  round: 'week',
                  tooltipFormat: "MMM-DD",
                  displayFormats: {
                        week: 'MMM DD'
                    }
                }
              }];
              myChart.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: lfMaxCount,
                    min: 0,
                    stepSize: (lfMaxCount/4)
                }
              }];
              break;
            case "Monthly":
            myChart.options.title.text = "Monthly Lost & Found Reports";
              myChart.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'month',
                  unitStepSize: 1,
                  round: 'month',
                  tooltipFormat: "MMM",
                }
              }];
              myChart.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: lfMaxCount,
                    min: 0,
                    stepSize: (lfMaxCount/4)
                }
              }];
              break;
            case "Yearly":
            myChart.options.title.text = "Yearly Lost & Found Reports";
              myChart.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'year',
                  unitStepSize: 1,
                  round: 'year',
                  tooltipFormat: "YYYY",
                }
              }];
              myChart.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: lfMaxCount,
                    min: 0,
                    stepSize: (lfMaxCount/4)
                }
              }];
              break;
          }
          myChart.update();
        }
      });
    });
});
</script>

<script>
$(document).ready(function() {
  var trc = $("#turnover-request-chart");
    //line chart data

    window.chartColors = {
      red: 'rgba(231, 76, 60,1.0)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgba(46, 204, 113,1.0)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(201, 203, 207)'
    };


    var data = {
      datasets: [{
                    label: "Turnover",
                    data: <?php echo $turnover_requests; ?>,
                    backgroundColor: window.chartColors.orange,
                    borderColor: window.chartColors.orange,
                    fill: false
                }, {
                    label: "Received",
                    data: <?php echo $received_turnover_items; ?>,
                    backgroundColor: window.chartColors.purple,
                    borderColor: window.chartColors.purple,
                    fill: false
                }]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        title : {
            display : true,
            position : "top",
            text : "Daily Turnover Request & Received Items",
        },
        legend : {
            display : true,
            position : "bottom"
        },
          tooltips: {
              mode: 'index',
              intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          scales: {
            xAxes: [{
              type: "time",
              time: {
                unit: 'day',
                unitStepSize: 1,
                round: 'day',
                tooltipFormat: "MMM-DD",
              }
            }],
            yAxes: [{
              gridLines: {
                color: "black",
                borderDash: [2, 5],
              },
              scaleLabel: {
                display: false
              },
              ticks: {
                max: <?php echo $tr_max_count;?>,
                min: 0,
                stepSize: <?php echo ($tr_max_count/4);?>
            }
            }]
          }
    };

    //create Chart class object
    var trcObject = new Chart(trc, {
      type: "line",
      data: data,
      options: options
    });


    $('#trchart-filter').on('change', function() {
      var typeValue = this.value;

      $.ajax({
        url: "<?php echo base_url();?>barangay/Barangay_home/tr_chart_filter_date",
        type: 'GET',
        dataType: 'json',
        data: {
          type: typeValue
        },
        success: function(json) {
          $("#tr-timeago").html("Last updated on " + moment().format("hh:mm A"));

          var trMaxCount = json['tr_max_count'];
          var turnoverRequests = json['turnover_requests'];
          var receivedItems = json['received_items'];
          trcObject.data.datasets[0].data = turnoverRequests;
          trcObject.data.datasets[1].data = receivedItems;

          switch (typeValue) {
            case "Daily":
            trcObject.data.labels = [];
            trcObject.options.title.text = "Daily Turnover Request & Received Items";
              trcObject.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'day',
                  unitStepSize: 1,
                  round: 'day',
                  tooltipFormat: "MMM-DD",
                }
              }];
              trcObject.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: trMaxCount,
                    min: 0,
                    stepSize: (trMaxCount/4)
                }
              }];
              break;
            case "Weekly":
            trcObject.options.title.text = "Weekly Turnover Request & Received Items";
            trcObject.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'week',
                  unitStepSize: 1,
                  round: 'week',
                  tooltipFormat: "MMM-DD",
                  displayFormats: {
                        week: 'MMM DD'
                    }
                }
              }];
              trcObject.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: trMaxCount,
                    min: 0,
                    stepSize: (trMaxCount/4)
                }
              }];
              break;
            case "Monthly":
            trcObject.options.title.text = "Monthly Turnover Request & Received Items";
            trcObject.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'month',
                  unitStepSize: 1,
                  round: 'month',
                  tooltipFormat: "MMM",
                }
              }];
              trcObject.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: trMaxCount,
                    min: 0,
                    stepSize: (trMaxCount/4)
                }
              }];
              break;
            case "Yearly":
            trcObject.options.title.text = "Yearly Turnover Request & Received Items";
            trcObject.options.scales.xAxes = [{
                type: "time",
                time: {
                  unit: 'year',
                  unitStepSize: 1,
                  round: 'year',
                  tooltipFormat: "YYYY",
                }
              }];
              trcObject.options.scales.yAxes = [{
                  gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                  },
                  scaleLabel: {
                    display: false
                  },
                  ticks: {
                    max: trMaxCount,
                    min: 0,
                    stepSize: (trMaxCount/4)
                }
              }];
              break;
          }
          trcObject.update();
        }
      });
    });
});
</script>

<script>
  $('#logout').click(function() {
    window.location.href = "<?php echo base_url();?>b_logout";
  });

  /* Change Password AJAX */
  $('#change-password').click(function() {
    var form_data = {
        current_password: $('#txt_currentPassword').val(),
        new_password: $('#txt_newPassword').val(),
        repeat_password: $('#txt_repeatPassword').val(),
    };
    $.ajax({
      url: "<?php echo site_url('barangay/Barangay_home/change_password'); ?>",
      type: 'POST',
      data: form_data,
      success: function(msg) {
        console.log(msg);
          if (msg == 'Success') {
              $('#alert-msg').html('<div class="alert alert-success text-center" style="margin: 8px;">Your Password has been change successfully!<br />Please logout to confirm your new password</div>');
              //Clear Form
              $('#txt_currentPassword').val('');
              $('#txt_newPassword').val('');
              $('#txt_repeatPassword').val('');
              setTimeout(function(){// wait for 1 secs
                window.location.reload();
              }, 2000);
          } else if (msg == 'Error') {
              $('#alert-msg').html('<div class="alert alert-danger text-center" style="margin: 8px;">Error in changing your password! Please try again later.</div>');
              //Clear Form
              $('#txt_currentPassword').val('');
              $('#txt_newPassword').val('');
              $('#txt_repeatPassword').val('');
          } else {
              $('#alert-msg').html('<div class="alert alert-danger" style="margin: 8px;">' + msg + '</div>');
          }
      }
  });
  return false;
  });
</script>
</body>
</html>