<div ng-show="showSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
    <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
    <span class="alert-inner--text"><strong>Success!</strong> {{responseMsg}}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div ng-show="showError" class="alert alert-danger alert-dismissible fade show" role="alert">
    <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
    <span class="alert-inner--text"><strong>Error!</strong> {{responseMsg}}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div ng-show="showWarning" class="alert alert-warning alert-dismissible fade show" role="alert">
    <span class="alert-inner--icon"><i class="fe fe-info"></i></span>
    <span class="alert-inner--text"><strong>Warning!</strong> {{responseMsg}}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>