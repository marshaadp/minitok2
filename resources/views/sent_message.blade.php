
<!doctype html>
<html lang="en">

    <head>
        <title>Sent Message</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        @include('template.import_datatable')
        <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
        <link href="{{ asset('resources/css/form.css') }}" rel="stylesheet">
        <!-- <script src="{{ asset('resources/js/validation.js') }}"></script> -->
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap');

            .popup_box,
            .popup_box2 {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                border-radius: 5px;
            }

            .popup_box,
            .popup_box2 {
                width: 450px;
                background: #f2f2f2;
                text-align: center;
                align-items: center;
                padding: 40px;
                border: 1px solid #b3b3b3;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, .2);
                z-index: 9999;
                display: none;
            }

            .popup_box i,
            .popup_box2 i {
                font-size: 60px;
                color: #eb9447;
                border: 5px solid #eb9447;
                padding: 20px 40px;
                border-radius: 50%;
                margin: -10px 0 20px 0;
            }

            .popup_box h1,
            .popup_box2 h1 {
                font-size: 30px;
                color: #1b2631;
                margin-bottom: 5px;
            }

            .popup_box label,
            .popup_box2 label {
                font-size: 23px;
                color: #404040;
            }

            li {
                display: block
            }

            .table {
                font-size: 13px;
            }

            th {
                text-align: center;
            }

            .navbar-left {
                height: 100%;
                /* Full-height: remove this if you want "auto" height */
                width: 100px;
                /* Set the width of the sidebar */
                position: fixed;
                /* Fixed Sidebar (stay in place on scroll) */
                z-index: 1;
                /* Stay on top */
                top: 0;
                /* Stay at the top */
                left: 0;
                background-color: #111;
                /* Black */
                overflow-x: hidden;
                /* Disable horizontal scroll */
                padding-top: 20px;
            }

            .first-col {
                left: 0px;
                min-width: 100px;
                background-color: white !important;
            }

            .sticky-col {
                position: -webkit-sticky;
                position: sticky;
                background-color: white;
            }

            /* Header fixed to the top of the modal */
            .modal-header--sticky {
                /*display: flex;*/
                /*align-items: flex-start;*/
                justify-content: space-between;
                padding: 1rem 1rem;
                border-bottom: 1px solid #e3e6f0;
                border-top-left-radius: calc(0.3rem - 1px);
                border-top-right-radius: calc(0.3rem - 1px);
                position: sticky;
                top: 0;
                background-color: inherit;
                /* [1] */
                z-index: 1055;
                /* [2] */
            }

            /* Footer fixed to the bottom of the modal */
            .modal-footer--sticky {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                /*justify-content: flex-end;*/
                padding: 0.75rem;
                border-top: 1px solid #e3e6f0;
                border-bottom-right-radius: calc(0.3rem - 1px);
                border-bottom-left-radius: calc(0.3rem - 1px);
                position: sticky;
                bottom: 0;
                background-color: inherit;
                /* [1] */
                z-index: 1055;
                /* [2] */
            }

            .first-col-modal {
                min-width: 250px;
            }

            .colon-col {
                min-width: 20px;
                max-width: 20px;
            }

            .dataTables_filter {
                float: right;
                text-align: right;
            }

            .text-align-custom
            {
                vertical-align: middle !important;
            }

            .text-center-align-custom
            {
                text-align: center !important;
                vertical-align: middle !important;
            }

            .text-center-align-custom-sent
            {
                text-align: center !important;
                vertical-align: middle !important;
                color: orange;
            }

            .text-center-align-custom-approve
            {
                text-align: center !important;
                vertical-align: middle !important;
                color: green;
            }

            .text-center-align-custom-reject
            {
                text-align: center !important;
                vertical-align: middle !important;
                color: red;
            }

        </style>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
        <script>
            $(document).ready(function() {
                $('.click').click(function() {
                    $('.popup_box').css("display", "block");
                });
                $('.btn1').click(function() {
                    $('.popup_box').css("display", "none");
                });
                $('.btn2').click(function() {
                    $('.popup_box2').css("display", "block");
                    $('.popup_box').css("display", "none");
                });
                $('.btn3').click(function() {
                    $('.popup_box2').css("display", "none");
                });
                $('.btn4').click(function() {
                    $('.popup_box2').css("display", "none");
                });
            });
        </script>
    </head>

    <body>
        <div class="wrapper d-flex align-items-stretch">
            @include('template.sidebar')
            <div id="content" style=" margin: 0 auto;  box-sizing: border-box; ">
                <div class="container-fluid" style=" width: 105.5%">
                    @include('template.navbar')

                    @if ($message = Session::get('message'))
                        <div class="alert alert-success alert-dismissible fade show ml-3 mr-3 mb-3 mt-5" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    
                    <div class="card mb-3 mt-3">
                        <div class="card-body mb-2">
                            <div class="row mb-3">
                                <div class="col-md-6 col-lg-5">
                                    
                                </div>
                                <div class="col-md-6 col-lg-7 col-xl-7">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <a class='btn btn-primary btn-sm mx-1' data-toggle="modal"
                                            data-target="#addMessageModal">Add Message</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="dataTable-message-sent">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 15px">Message No</th>
                                            <th style="width: 100px">To</th>
                                            <th style="width: 800px">Message</th>
                                            <th style="width: 200px">Created Date</th>
                                            <th style="width: 100px">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Isi tabel disini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Message -->
        <div class="modal fade" id="addMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header--sticky">
                        <div class="row">
                            <div class="col-4">
                            </div>
                            <div class="col-4">
                                <h5 class="modal-title w-100 text-center">Add Message</h5>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                    <form name='form_edit' method='POST' action="{{URL('add_message')}}" accept-charset='UTF-8' enctype='multipart/form-data'id='form_edit'>
                        @csrf
                        <div class="modal-body" id="modal-hapus-body">
                            <div class="row">
                                <div class="col-6">
                                    <label>To</label>
                                    <select name="nama_penerima" class="form-control" required>
                                        @foreach($data as $item)
                                            <option value="{{ $item->username }}">{{ $item->fullname }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" class="form-control" name="nama_penerima" required></input> --}}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label>Message</label>
                                    <textarea type="textarea" class="form-control" name="message" rows="10" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer--sticky">
                            <div class="col-3 ml-auto">
                                <div class="d-flex flex-row-reverse ml-4">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <button class="btn btn-secondary mr-1" type="button"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script type="text/javascript">
        var table = $('#dataTable-message-sent').DataTable({
        "ajax": "{{ url('/get_all_message_with_status_sent') }}",
        "searching": true,
        "deferRender": true,
        "ordering": false,
        "scrollX": true,
        "columns": [
                {
                    "data": 'id'
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "message"
                },
                {
                    "data": "created_date"
                },
                {
                    "data": "status"
                },
            ],
            columnDefs: [
                {
                    "searchable": true,
                    "orderable": false,
                    "targets": [1, 2],
                    "className": "text-align-custom"
                },
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0, 3, 4],
                    "className": "text-center-align-custom"
                },
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [4],
                    "render": function(data, type, row) {
                        var btn = '';

                        if (data == 'Sent') {
                            btn += '<lable class="text-center-align-custom-sent">' + data + '</lable>';
                        }
                        else if (data == 'Approve') {
                            btn += '<lable class="text-center-align-custom-approve">' + data + '</lable>';
                        }
                        else {
                            btn += '<lable class="text-center-align-custom-reject">' + data + '</lable>';
                        }

                        return btn;
                    }
                },
            ],
        });
    </script>

</html>
