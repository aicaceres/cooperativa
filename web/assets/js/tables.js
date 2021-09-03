jQuery(document).ready(function($){
    /*  DataTables  */  
    $('.tablelist').DataTable({
        "retrieve": true,
        "bAutoWidth": false,
        "iDisplayLength": 25,
        "columnDefs": [ {
          "targets"  : 'nosort',
          "orderable": false
        }],
        "oLanguage": {
            "oPaginate": {
                "sFirst": "<<",
                "sNext": "Siguiente",
                "sLast": ">>",
                "sPrevious": "Previo"
            },
            "sLengthMenu": "Mostrar _MENU_ ",
            "sZeroRecords": "Sin datos",
            "sInfo": " _START_ / _END_  -  <strong>Total: _TOTAL_ </strong>",
            "sInfoEmpty": "Sin coincidencias",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Buscar:"
        }
    });   
    
    $('.tableauditoria').dataTable({
        "bAutoWidth": false,
        "iDisplayLength": 25,
        "oLanguage": {
            "oPaginate": {
                "sFirst": "<<",
                "sNext": "Siguiente",
                "sLast": ">>",
                "sPrevious": "Previo"
            },
            "sLengthMenu": "Mostrar _MENU_ ",
            "sZeroRecords": "Sin datos",
            "sInfo": " _START_ / _END_  -  <strong>Total: _TOTAL_ </strong>",
            "sInfoEmpty": "Sin coincidencias",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Buscar:"
        }
    });   
    
   /* Delete record ajax */
    $('body').on('click','.delete_ajax', function() {
        var p = $(this).parents('tr');
        var url = $(this).attr('url');
        r = confirm('Está seguro de eliminar este registro?');
        if (r) {
            $.ajax({
                url: url,
                async: true,
                type: "POST",
                success: function(data) {
                    if (data === '"OK"') {
                        if (p.next().hasClass('togglerow'))
                            p.next().remove();
                        p.fadeOut(function() {
                            $(this).remove();
                        });
                        window.location.reload();
                    } else
                        alert(data);
                }, error: function() {
                    alert('No se puede realizar la operación en este momento');
                }
            });
        }
        return false;
    });    
    
    
});