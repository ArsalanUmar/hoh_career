$(document).ready(function(){

	console.log('cc');

    var id = $('table').attr('id');

    $('#'+id).DataTable({

      "paging": true,

      "lengthChange": false,

      "searching": false,

      "ordering": true,

      "info": true,

      "autoWidth": false,

      "responsive":true,

    });



    $('button#remove').click(function(){

    	console.log('pp');

    	var web = $(this).parents('tr').attr('id');

    	console.log(web);

  //   	$.ajax({

		//   type: "POST",

		//   url: 'manage/remove',

		//   data: data,

		//   success: success,

		//   dataType: dataType

		// });

    })



});