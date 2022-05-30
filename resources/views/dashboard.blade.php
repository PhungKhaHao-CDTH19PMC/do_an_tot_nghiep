@extends('master')
@section('page-content')
@include('inc.notification')

<div class="table-responsive mb-3">
    <table id="table-contract" class="table mb-0 table-custom-text">
        <thead class="table-light">
            <tr>
                <th><input name="select_all" value="1" type="checkbox"></th>
                <th></th>
                <th>Mã HĐ</th>
                <th>Tên nhân viên</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    var rows_selected = [];
    var table;
    table = $('#table-contract').DataTable({
        processing  : true,
        serverSide  : true,
        autoWidth   : false,
        pageLength  : 25,
        language: {
            emptyTable: "Không tồn tại dữ liệu",
            zeroRecords: "Không tìm thấy dữ liệu",
            info: "Hiển thị từ _START_ đến _END_ trong _TOTAL_ mục",
            infoEmpty: "0 bảng ghi được hiển thị",
            infoFiltered: "",
            processing: "<span class='text-primary'>Đang tải dữ liệu...</span>",
            oPaginate: {
                sNext: '<i class="bi bi-caret-right-fill"></i>',
                sPrevious: '<i class="bi bi-caret-left-fill"></i>',
                sFirst: '<i class="fa fa-step-backward"></i>',
                sLast: '<i class="fa fa-step-forward"></i>'
            },
            lengthMenu: "Hiển thị _MENU_ mục"
        },
        ajax: {
            url: "{{route('contract.load_ajax_contract')}}",
            type: "get"
        },
        initComplete: function(settings, json) {

        $('#table-contract tbody').on('click', 'input[type="checkbox"]', function(e){
                var $row = $(this).closest('tr');

                // Get row data
                var data = table.row($row).data();

                // Get row ID
                var rowId = data[0];

                // Determine whether row ID is in the list of selected row IDs 
                var index = $.inArray(rowId, rows_selected);

                // If checkbox is checked and row ID is not in list of selected row IDs
                if(this.checked && index === -1){
                    rows_selected.push(rowId);

                // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                } else if (!this.checked && index !== -1){
                    rows_selected.splice(index, 1);
                }

                if(this.checked){
                    $row.addClass('selected');
                } else {
                    $row.removeClass('selected');
                }

                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(table);
                if (table.rows('.selected').data().length == 0) {
                $("#btn-ap-dung").attr('disabled', true)
                }
                else {
                    $("#btn-ap-dung").attr('disabled', false)
                }
                if (table.rows('.selected').data().length == 0) {
                    $("#btn-ap-dung-2").attr('disabled', true)
                }
                else {
                    $("#btn-ap-dung-2").attr('disabled', false)
                }
                    // Prevent click event from propagating to parent
                    e.stopPropagation();
            });

            // Handle click on table cells with checkboxes
            $('#table-contract').on('click', 'tbody td, thead th:first-child', function(e){
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

            // Handle click on "Select all" control
            $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
                if(this.checked){
                    $('#table-contract tbody input[type="checkbox"]:not(:checked)').trigger('click');
                } else {
                    $('#table-contract tbody input[type="checkbox"]:checked').trigger('click');
                }

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle table draw event
            table.on('draw', function(){
                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(table);
            });


        $("#table-doctor").parent().addClass(' table-responsive');
        $("#table-doctor").parent().parent().addClass(' d-inline');

        },
        drawCallback: function(oSettings) {
            if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
            } else {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
            }

            if (oSettings.fnRecordsDisplay() == 0) {
                $(oSettings.nTableWrapper).find('.dataTables_info').hide();
            }
        },
        columns: [

            { data: null, defaultContent: '', bSortable: false },
            { name: 'id', data: 'id',bSortable: true, visible: false},
            { name: 'code', defaultContent: '',  data: 'code',bSortable: true},
            { name: 'fullname', defaultContent: '',  data: 'user.fullname',bSortable: true},
            { name: 'start_date', defaultContent: '',  data: 'start_date',bSortable: true},
            { name: 'finish_date', defaultContent: '',  data: 'finish_date',bSortable: true},
        ],
        columnDefs: [
            {
                orderable: false,
                className: 'dt-body-center',
                targets:   0,
                render: function (data, type, columns, meta){
                    return '<input type="checkbox">';
                }
            },
            {
                targets: 6,   // choose the correct column
                render: function ( data, type, columns, meta ) {
                    var urlCapNhat = "./hop-dong/cap-nhat/"+ columns.id;
                    var urlThanhToan = "./hop-dong/thanh-toan/"+ columns.id;
                    return '<div class="d-flex order-actions">'
                        +'<a href="'+ urlCapNhat +'" data-toggle="tooltip" data-placement="top" title="Cập nhật"class="btn-edit">Cập nhật | </a>'
                        +'<a href="javascript:;" data-toggle="tooltip" data-placement="top" title="Xóa"class="text-danger ms-3 btn-del"id="remove" data-id="'+ columns.id +'"  onclick="deleteRow(this)">Xóa</a>'
                        +'</div>'
                        ;
                }
            },
            
        ],
        ordering: true,
        order: [[ 2, 'desc' ]],
    });   
    
</script>
@endsection