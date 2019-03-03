<section id="middle">

    <header id="page-header">
        <h1>การแจ้งเตือน</h1>
    </header>

    <div class="panel-body">
        <div id="ttab1_nobg" class="tab-pane active"><!-- TAB 1 CONTENT -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 3%;"></th>
                        <th>Confirmation</th>
                        <th style="width: 5%;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <span class="label label-danger"><i class="fa fa-bell-o size-15"></i></span>
                            อมุนัติการเพิ่มโครงงานรายวิชา 00000
                        </td>
                        <td><button class="btn btn-default btn-sm" data-toggle="modal" data-target="#bs-example-modal-lg">View</button></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <span class="label label-warning"><i class="fa fa-comment size-15"></i></span>
                            อมุนัติการนัดหมายโครงงานทดสอบ 1
                        </td>
                        <td><button class="btn btn-default btn-sm" data-toggle="modal" data-target="#bs-example-modal-lg">View</button></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <span class="label label-warning"><i class="fa fa-comment size-15"></i></span>
                            อมุนัติการนัดหมายโครงงานทดสอบ 2
                        </td>
                        <td><button class="btn btn-default btn-sm" data-toggle="modal" data-target="#bs-example-modal-lg">View</button></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <span class="label label-danger"><i class="fa fa-bell-o size-15"></i></span>
                            อมุนัติการเพิ่มโครงงานรายวิชา 000111
                        </td>
                        <td><button class="btn btn-default btn-sm" data-toggle="modal" data-target="#bs-example-modal-lg">View</button></td>
                    </tr>
                    </tbody>
                </table>

            </div>
    </div>

        <div class="row"
             style="margin-top: 20px;">
            <div class="col-md-12">
                <button type="button" class="btn btn-green" >อนุมัติ</button>
                <button type="submit" href="" class="btn btn-red">ไม่อนุมัติ</button>
            </div>
        </div>

</section>

<!-- ////////////////////////////////////////////////////// View /////////////////////////////////////////////////////// -->

<div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- header modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">รายละเอียด</h4>
            </div>
            <!-- body modal -->
            <div class="modal-body">

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3">
                            <label>อมุนัติการเพิ่มโครงงานรายวิชา 000000</label>
                            ทดสอบรายละเอียด 1
                        </div>
                    </div>
                </div>

                <div class="row"
                     style="margin-top: 20px;">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-green" >อนุมัติ</button>
                        <button type="submit" href="" class="btn btn-red">ไม่อนุมัติ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////////////////// View /////////////////////////////////////////////////////// -->
