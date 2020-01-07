</div>
	</div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	 <!-- DataTables JavaScript -->
    
	<script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	
	<script>
$(document).ready(function() {
    $('#example').DataTable( {
		"responsive":true,
        "processing": true,
		"serverSide": true,
        //"ajax": "sangat-data.php"
		"ajax":{
                url :"sangat-data.php", // json datasource
                type: "post",  // method  , by default get
		},
		"columnDefs": [
		{
			"targets":[0],
			"visible":false,
			"searchable":false
		},{
			"targets":[1],
			"render": function(data,type,row){
				return "<a href= '/attendance/pages/sangat.php?sangat_id="+row['sangat_id']+"'>"+data; 
		}}
		  
		       ],
		 "columns": [
				  {"data":"sangat_id"},
		          { "data": "name" },
				  { "data": "gender" },
		          { "data": "address" },
		          { "data": "phone" },
				  { "data": "bhatti_id_no" },
				  { "data": "nit2_id_no" },
				  
		       ]
		
    } );
} );

$('#example tbody').on('click', 'tr', function () {
	var data = table.row(this).data();
	alert(data[0]);
        $('#sangatDetailModal').modal("show");
    });
</script>
</body>
</html>
