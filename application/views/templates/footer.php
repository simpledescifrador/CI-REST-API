    

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="https://momentjs.com/downloads/moment.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/Chart/Chart.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->

    <!-- BEGIN ROBUST JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/app.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->

    <!--BEGIN DATATABLES JS-->
    <script src="<?php echo base_url(); ?>assets/DataTables/datatables.min.js" type="text/javascript"></script>
    <!--END DATATABLES JS-->

    <!-- BEGIN Lightbox JS for imag viewer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
    <script>
    lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        })
    </script>
    <!-- END Lightbox JS -->

    <!-- BEGIN PAGE LEVEL JS-->
    
    
    
    <script type="text/javascript">
        $(window).on("load", function(){

        
            var ctx = $("#area-chart");

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        type: "time",
                        time: {
                            unit: 'day',
                            unitStepSize: 0,
                            round: 'day',
                            tooltipFormat: "MMM-DD"
                        },
                        gridLines: {
                            color: "transparent",
                            drawTicks: false,
                        },
                        ticks:{
                            padding: 15,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "transparent",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Number of Reports'
                        },
                        ticks:{
                        min: 0,
                        stepSize:1
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Lost and Found Items'
                }
            };

            // Chart Data
            var chartData = {
                // labels: cData_item.label,
                datasets: [{
                    label: "Lost",
                    data: <?php echo $lost_graph_data; ?>,
                    backgroundColor: "rgba(251,192,45,0.3)",
                    borderColor: "#F6BB42",
                    pointBorderColor: "#F6BB42",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }, {
                    label: "Found",
                    data: <?php echo $found_graph_data; ?>,
                    backgroundColor: "rgba(76,175,80,0.4)",
                    borderColor: "#1DE9B6",
                    pointBorderColor: "#1DE9B6",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }]
            };

            var config = {
                type: 'line',

                // Chart Options
                options : chartOptions,

                // Chart Data
                data : chartData
            };

            // Create the chart
            var areaChart = new Chart(ctx, config);

        });
    </script>
    <script type="text/javascript">
        $(window).on("load", function(){

            //Get the context of the Chart canvas element we want to select
            var ctx = $("#simple-doughnut-chart");

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration:500,
            };

            // Chart Data
            var chartData = {
                labels: ["Pets", "Persons", "Personal Items"],
                datasets: [{
                    label: "My First dataset",
                    data: [ <?php echo $dnnt_petCounts; ?>, <?php echo $dnnt_personCounts; ?>,
                    <?php echo $dnnt_personalThingCounts; ?> ],
                    backgroundColor: ["#FF847C","#E84A5F","#2A363B"],
                }]
            };

            var config = {
                type: 'doughnut',

                // Chart Options
                options : chartOptions,

                data : chartData
            };

            // Create the chart
            var doughnutSimpleChart = new Chart(ctx, config);

        });
    </script>
    <!-- END PAGE LEVEL JS-->

    <!-- BEGIN CUSTOM JS -->
    <script type="text/javascript">
      window.setTimeout(function() {
        $(".alert").slideUp(500, function(){
            $(this).remove(); 
        });
    }, 6000);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#table1').DataTable(
            {
            "order": [[ 0, "desc" ]],
            responsive: true
            }
          );
          });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#table2').DataTable(
            {
            "order": [[ 0, "desc" ]],
            responsive: true
            }
          );
          });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#table3').DataTable(
            {
            "order": [[ 0, "desc" ]],
            responsive: true
            }
          );
          });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#transaction1').DataTable(
            {
            responsive: true,
            ordering: false,
            }
          );
          });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#transaction2').DataTable(
            {
            responsive: true,
            ordering: false,
            }
          );
          });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#transaction3').DataTable(
            {
            responsive: true,
            ordering: false,
            }
          );
          });
    </script>
    <!-- END CUSTOM JS -->
  </body>
</html>