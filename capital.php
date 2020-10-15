<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Yangon');
//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";

$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position,"is_capital", $connect);
if(!$per_check){
    header("location:errorpage.php");
}

$noti_ok = '';
$noti_error = '';

if(isset($_SESSION['msg-success'])){
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if(isset($_SESSION['msg-error'])){
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

?>
<input type="hidden" class="msg-ok" value="<?=$noti_ok?>">
<input type="hidden" class="msg-error" value="<?=$noti_error?>">


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Capital</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="showaddcapital($(this))"><i
                class="fas fa-plus-circle fa-sm text-white-50"></i> Add New</a>
                <a href="export_capital.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_capital.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" class="form-control search-from-date" id="search-from-date" name="search_from_date"
                           placeholder="From Date">
                    <input type="text" class="form-control search-to-date" id="search-to-date" name="search_to_date"
                           placeholder="To Date">
                    <input type="text" class="form-control search-text" id="search-text" name="search_text"
                           placeholder="Search">
<!--                    <button class="btn btn-primary">Search</button>-->
                    <!--                    <input type="text" class="form-control search-index" id="search-index" name="search_index" placeholder="index">-->
                    <!--                    <input type="text" class="form-control search-plate" id="search-prod" name="search_prod" placeholder="สินค้า">-->
                </div>
            </div>
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Expend Date</th>
                    <th>List</th>
                    <th style="text-align: right">Amount</th>
                    <th style="text-align: right">Price</th>
                    <th style="text-align: right">Total</th>
                    <th>Cashier Name</th>
                    <th style="width: 25%;text-align: center">-</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_capital_data.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New Capital</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Expend Date</label>
                            <input type="text" class="form-control expend-date" name="expend_date" value=""
                                   placeholder="Expend Date">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">List</label>
                            <input type="text" class="form-control list" name="list" value=""
                                   placeholder="List">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Amount</label>
                            <input type="text" class="form-control qty" name="qty" value="0"
                                   placeholder="Amount" onchange="callist($(this))">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Price</label>
                            <input type="text" class="form-control price" name="price" value="0"
                                   placeholder="Price" onchange="callist($(this))">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Cashier Name</label>
                            <input type="text" class="form-control cashier-name" name="cashier_name" value=""
                                   placeholder="Cashier Name">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Price</label>
                            <input type="text" class="form-control total-amount" name="total_amount" value="0"
                                   placeholder="Total" readonly>
                        </div>
                    </div>
                    <br />



                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i class="fa fa-save"></i> Save </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>
    notify();

    $(".expend-date").datepicker({
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        autoclose: true
    });

    $("#search-from-date,#search-to-date").datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    function showaddcapital(e) {
        $(".user-recid").val();
        $(".expend-date").val('');
        $(".list").val('');
        $(".qty").val(0);
        $(".price").val(0);
        $(".total-amount").val(0);
        $(".cashier-name").val('');

        $("#myModal").modal("show");
    }

    function callist(e){
        var total = 0;
        var qty = parseFloat($(".qty").val());
        var price = parseFloat($(".price").val());
        total = qty * price;
        $(".total-amount").val(parseFloat(total).toFixed(0));
    }
    $("#dataTable").append('<tfoot><th></th><th></th><th></th><th></th><th></th><th style="text-align: right"></th><th></th><th></th></tfoot>');
    var dataTablex = $("#dataTable").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "pageLength": 100,
        "filter": false,
        "ajax": {
            url: "capital_fetch.php",
            type: "POST",
            data: function (data) {
                // Read values
                var from_date = $('#search-from-date').val();
                var to_date = $('#search-to-date').val();
                var search_text = $('#search-text').val();
                // var index = $('#search-index').val();
                // // Append to data
                data.searchByFromdate = from_date;
                data.searchByTodate = to_date;
                data.searchByText = search_text;
                // data.searchByIndex = index;
            }
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            {
                targets: [5],
                className: 'text-right'
            },

        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var total = api
                .column(5)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                    //return a + a;
                }, 0 );
            var all_total = addCommas(parseFloat(total));
            // data = api.column(3, { page: 'current'} ).data();
            // pageTotal = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) : 0;

            // Update footer
           // var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '£' ).display;
            $( api.column(0).footer() ).html('<p style="text-align: right">Total</p>');
            $( api.column(5).footer() ).html(all_total);
        }

    });

    // var column = dataTablex.column(3);
    //
    // column.columns(3).every( function () {
    //
    //     var sum = this
    //         .data()
    //         .reduce( function (a,b) {
    //             return a + b;
    //         } );
    //
    //   //  $( this.footer(0) ).html('<p style="text-align: right">Total</p>');
    //     $( this.footer(3) ).html(100);
    // } );

    $("#search-text").change(function(){
        dataTablex.draw();
    });
    $("#search-from-date").change(function(){
        //alert($(this).val());
        dataTablex.draw();
    });
    $("#search-to-date").change(function(){
        dataTablex.draw();
    });

    // $("#dataTable").dataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "bFilter": false,
    //     "order": [[1, "asc"]],
    //     "ajax": {
    //         url: "capital_fetch.php",
    //         type: "POST"
    //     },
    //     "columnDefs": [
    //         {
    //             "targets": [0],
    //             "orderable": false,
    //         },
    //
    //     ],
    // });

    function showupdate(e) {
        var recid = e.attr("data-id");
        if (recid != '') {
            var list = '';
            var qty = 0;
            var price = 0;
            var total = 0;
            var cashier_name = '';
            var x_date = null;
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_capital_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        list = data[0]['list'];
                        qty = data[0]['qty'];
                        price = data[0]['price'];
                        total = data[0]['total'];
                        cashier_name = data[0]['cashier_name'];
                        x_date = data[0]['expend_date'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".list").val(list);
            $(".qty").val(qty);
            $(".price").val(price);
            $(".total-amount").val(total);
            $(".cashier-name").val(cashier_name);
            $(".expend-date").val(x_date);

            $(".modal-title").html('Update Capital');

            $("#myModal").modal("show");
        }
    }

    function recDelete(e) {
        //e.preventDefault();
        var recid = e.attr('data-id');
        $(".delete-id").val(recid);
        swal({
            title: "Are you sure to delete?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {

            $("#form-delete").submit();
            // e.attr("href",url);
            // e.trigger("click");
        });
    }
    function notify() {
        // $.toast({
        //     title: 'Message Notify',
        //     subtitle: '',
        //     content: 'eror',
        //     type: 'success',
        //     delay: 3000,
        //     // img: {
        //     //     src: 'image.png',
        //     //     class: 'rounded',
        //     //     title: 'แจ้งการทำงาน',
        //     //     alt: 'Alternative'
        //     // },
        //     pause_on_hover: false
        // });
        var msg_ok = $(".msg-ok").val();
        var msg_error = $(".msg-error").val();
        if(msg_ok != ''){
            $.toast({
                title: 'แจ้งเตือนการทำงาน',
                subtitle: '',
                content: msg_ok,
                type: 'success',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }
        if(msg_error != ''){
            $.toast({
                title: 'แจ้งเตือนการทำงาน',
                subtitle: '',
                content: msg_error,
                type: 'danger',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }

    }
    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>
