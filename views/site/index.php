<?php

/** @var yii\web\View $this */

$this->title = 'Shopify CSV converter'; ?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Convert Ecolight to Shopify</h1>
    </div>

    <div class="body-content container">
        <form action="/converter" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Upload File</label>
                            <div class="preview-zone hidden">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <div><b>Preview</b></div>
                                    </div>
                                    <div class="box-body"></div>
                                </div>
                            </div>
                            <div class="dropzone-wrapper" style="margin-top: 1em;">
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>Choose an image file or drag it here.</p>
                                </div>
                                <input required type="file" name="UploadForm[file]" class="dropzone" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Upload</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
