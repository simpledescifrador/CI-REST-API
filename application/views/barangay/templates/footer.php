
        </div>
    </div>
</div>


    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" type="text/javascript"></script>
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

    <!-- Lottie Animation JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.5.7/lottie.min.js" type="text/javascript"></script>

    <!-- BEGIN Custom JS -->
    <script type="text/javascript">
        function pill(){
            custom-pill.style.backgroundColor = "#deab02";
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#reports-table').DataTable(
            {
            "order": [[ 0, "desc" ]],
            responsive: true
            }
          );
          });
    </script>
    <!-- END Custom JS -->
    <!-- BEGIN Chart JS Data -->
    <script type="text/javascript">
        $(window).on("load", function(){

            //Get the context of the Chart canvas element we want to select
            var ctx = $("#column-chart");

            // Chart Options
            var chartOptions = {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each bar to be 2px wide and green
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration:500,
                legend: {
                    position: 'top',
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Numbers of Lost & Found'
                }
            };

            // Chart Data
            var chartData = {
                labels: ["January", "February", "March", "April", "May"],
                datasets: [{
                    label: "Lost",
                    data: [65, 59, 80, 81, 56],
                    backgroundColor: "#F6BB42",
                    hoverBackgroundColor: "rgba(246, 186, 65, 0.9)",
                    borderColor: "transparent"
                }, {
                    label: "Found",
                    data: [28, 48, 40, 19, 86],
                    backgroundColor: "#30A487",
                    hoverBackgroundColor: "rgba(48, 164, 135, .9)",
                    borderColor: "transparent"
                }]
            };

            var config = {
                type: 'bar',

                // Chart Options
                options : chartOptions,

                data : chartData
            };

            // Create the chart
            var lineChart = new Chart(ctx, config);
        });
    </script>
    <!-- END Chart JS Data -->
