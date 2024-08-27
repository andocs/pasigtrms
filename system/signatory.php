<?php
if (!hasPermission(3)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?><div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Signatory</li>
    </ol>
    <div class="col-lg-12"><br />
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form role="form" method="post" action="trms.php?page=profiletrans" enctype="multipart/form-data">
                        <div class="col-12 row flex-row">
                            <div class="form-group column col-6 justify-content-between">
                                <div>
                                    <label for="prepared_by" class="form-label">Prepared By</label>
                                    <input class="form-control" id="prepared_by" name="prepared_by">
                                </div>
                                <div class="mt-3">
                                    <label for="prepared_plantilla" class="form-label">Plantilla Position</label>
                                    <input class="form-control" id="prepared_plantilla" name="prepared_plantilla">
                                </div>
                                <div class="mt-3">
                                    <label for="prepared_position" class="form-label">Designated Position</label>
                                    <input class="form-control" id="prepared_position" name="prepared_position">
                                </div>
                                <div class="mt-3">
                                    <label for="prepared_office" class="form-label">Position</label>
                                    <input class="form-control" id="prepared_office" name="prepared_office">
                                </div>
                            </div>
                            <div class="form-group column col-6 justify-content-between">
                                <div>
                                    <label for="prepared_by" class="form-label">Recommended By</label>
                                    <input class="form-control" id="recommended_by" name="recommended_by">
                                </div>
                                <div class="mt-3">
                                    <label for="recommended_plantilla" class="form-label">Plantilla Position</label>
                                    <input class="form-control" id="recommended_plantilla" name="recommended_plantilla">
                                </div>
                                <div class="mt-3">
                                    <label for="recommended_position" class="form-label">Designated Position</label>
                                    <input class="form-control" id="recommended_position" name="recommended_position">
                                </div>
                                <div class="mt-3">
                                    <label for="recommended_office" class="form-label">Position</label>
                                    <input class="form-control" id="recommended_office" name="recommended_office">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>