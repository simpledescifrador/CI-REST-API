</div>
        <!--Body Emulator End -->
</div>
 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="assets/js/canvasjs.min.js" ></script>
	  <script src="assets/js/lnFjquerychart.js" ></script>
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap-4.0.0.js"></script>
	  <script src="assets/js/Sidebar-Menu.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="assets/raphael/raphael.min.js"></script>
    <script src="assets/morrisjs/morris.min.js"></script>
    <script src="assets/data/morris-data.js"></script><!--returns chart data -->
    <script src="assets/data/returned-item.js"></script><!--returns chart data -->
    <!-- /Morris Charts JavaScript -->

    <!-- DataTables JavaScript -->
    <script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
    <!-- /DataTables JavaScript -->


    <!-- DATATABLES Scripts -->
    <!-- Reported Users table (Dashboard) -->
    <script>
      $(document).ready(function() {
      $('#reported_users_table').DataTable(
        {
        "order": [[ 0, "desc" ]],
        responsive: true
        }
      );
      } );
    </script>
    <!--/Reported Users table (Dashboard) -->

  </body>
</html>
