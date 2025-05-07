<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sash – Bootstrap 5  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">

    <!-- TITLE -->
    <title>E 4 Earning</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="../assets/css/plugins.css" rel="stylesheet">

    <!--- FONT-ICONS CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet">

    <!-- INTERNAL Switcher css -->
    <link href="../assets/switcher/css/switcher.css" rel="stylesheet">
    <link href="../assets/switcher/demo.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="app sidebar-mini ltr light-mode" ng-app="myAngularApp" ng-controller="adminController" ng-init="getAllUsers()">


    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <?php
            require('header.php');
            ?>
            <!-- /app-Header -->

            <!--APP-SIDEBAR-->
            <?php require('sidebar.php'); ?>
            <!--/APP-SIDEBAR-->

            <!--app-content open-->

            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">

                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <h1 class="page-title">All Users</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">All users</li>
                                </ol>
                            </div>
                        </div>
                        <!-- PAGE-HEADER END -->


                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title mb-0">All users</h3>
                                    </div>
                                    <div class="card-body pt-4">
                                        <div class="grid-margin">
                                            <div class="">
                                                <div class="panel panel-primary">
                                                    <div class="tab-menu-heading border-0 p-0">
                                                        <div class="tabs-menu1">
                                                            <!-- Tabs -->
                                                            <ul class="nav panel-tabs product-sale">
                                                                <!-- <li><a href="#tab5" class="active"
                                                                        data-bs-toggle="tab">All products</a></li>
                                                                <li><a href="#tab6" data-bs-toggle="tab"
                                                                        class="text-dark">Shipped</a></li>
                                                                <li><a href="#tab7" data-bs-toggle="tab"
                                                                        class="text-dark">Pending</a></li>
                                                                <li><a href="#tab8" data-bs-toggle="tab"
                                                                        class="text-dark">Cancelled</a></li> -->
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="panel-body tabs-menu-body border-0 pt-0">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="tab5">
                                                                <div class="table-responsive">
                                                                    <table id="data-table" class="table table-bordered text-nowrap mb-0">
                                                                        <thead class="border-top">
                                                                            <tr>
                                                                                <th class="bg-transparent border-bottom-0" style="width: 5%;">Name</th>
                                                                                <th class="bg-transparent border-bottom-0">Mobile</th>
                                                                                <th class="bg-transparent border-bottom-0">Coins</th>
                                                                                <th class="bg-transparent">status</th>
                                                                                <th class="bg-transparent">Delete</th>
                                                                                <!-- <th class="bg-transparent border-bottom-0">
                                                                                    Delete</th> -->

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="border-bottom" ng-repeat="p in allUsers | filter:{isDeleted:'!1'}">
                                                                                <td class=" text-center">
                                                                                    <div class="mt-0 mt-sm-2 d-block">
                                                                                        <h6 class="mb-0 fs-14 fw-semibold">
                                                                                            {{p.name}}
                                                                                        </h6>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div class="mt-0 mt-sm-2 d-block">
                                                                                            <h6 class="mb-0 fs-14 fw-semibold">
                                                                                                {{p.mobile_no}}
                                                                                            </h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div class="mt-0 mt-sm-2 d-block">
                                                                                            <h6 class="mb-0 fs-14 fw-semibold">
                                                                                                {{p.coin_balance}}
                                                                                            </h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div class="mt-0 mt-sm-2 d-block">
                                                                                            <!-- Show "Disable" button if isActive is 1 -->
                                                                                            <button class="btn btn-danger" ng-if="p.isActive == 1" ng-click="deactivateUser(p.id)">Disable</button>

                                                                                            <!-- Show "Disabled" button if isActive is not 1 -->
                                                                                            <button class="btn btn-secondary" ng-if="p.isActive != 1" ng-click="activateUser(p.id)">Enable</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div class="mt-0 mt-sm-3 d-block">

                                                                                            <button class="btn btn-dark" ng-if="p.isDeleted == 0" ng-click="deleteUser(p.id)">Delete</button>


                                                                                        </div>
                                                                                    </div>
                                                                                </td>


                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- CONTAINER END -->
                    </div>
                </div>
                <!--app-content close-->

            </div>




            <!-- FOOTER -->
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-md-12 col-sm-12 text-center">
                            Copyright © <span id="year"></span> . Designed with <span class="fa fa-heart text-danger"></span> by <a href="javascript:void(0)"> High On Cyber </a> All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- FOOTER END -->

            <!-- BACK-TO-TOP -->
            <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

            <!-- JQUERY JS -->
            <script src="../assets/js/jquery.min.js"></script>

            <!-- BOOTSTRAP JS -->
            <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
            <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

            <!-- SPARKLINE JS-->
            <script src="../assets/js/jquery.sparkline.min.js"></script>

            <!-- CHART-CIRCLE JS-->
            <script src="../assets/js/circle-progress.min.js"></script>

            <!-- MORRIS CHART JS-->
            <script src="../assets/plugins/morris/raphael-min.js"></script>
            <script src="../assets/plugins/morris/morris.js"></script>

            <!-- CHARTJS CHART JS-->
            <script src="../assets/plugins/chart/Chart.bundle.js"></script>
            <script src="../assets/plugins/chart/utils.js"></script>

            <!-- C3 CHART JS-->
            <script src="../assets/plugins/charts-c3/d3.v5.min.js"></script>
            <script src="../assets/plugins/charts-c3/c3-chart.js"></script>

            <!-- INPUT MASK JS-->
            <script src="../assets/plugins/input-mask/jquery.mask.min.js"></script>

            <!-- TypeHead js -->
            <script src="../assets/plugins/bootstrap5-typehead/autocomplete.js"></script>
            <script src="../assets/js/typehead.js"></script>

            <!-- PIETY CHART JS-->
            <script src="../assets/plugins/peitychart/jquery.peity.min.js"></script>
            <script src="../assets/plugins/peitychart/peitychart.init.js"></script>

            <!-- GALLERY JS -->
            <script src="../assets/plugins/gallery/picturefill.js"></script>
            <script src="../assets/plugins/gallery/lightgallery.js"></script>
            <script src="../assets/plugins/gallery/lightgallery-1.js"></script>
            <script src="../assets/plugins/gallery/lg-pager.js"></script>
            <script src="../assets/plugins/gallery/lg-autoplay.js"></script>
            <script src="../assets/plugins/gallery/lg-fullscreen.js"></script>
            <script src="../assets/plugins/gallery/lg-zoom.js"></script>
            <script src="../assets/plugins/gallery/lg-hash.js"></script>
            <script src="../assets/plugins/gallery/lg-share.js"></script>

            <!-- INTERNAL INDEX JS -->
            <script src="../assets/js/widget.js"></script>

            <!-- Perfect SCROLLBAR JS-->
            <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>
            <script src="../assets/plugins/p-scroll/pscroll.js"></script>
            <script src="../assets/plugins/p-scroll/pscroll-1.js"></script>

            <!-- SIDE-MENU JS -->
            <script src="../assets/plugins/sidemenu/sidemenu.js"></script>

            <!-- SIDEBAR JS -->
            <script src="../assets/plugins/sidebar/sidebar.js"></script>

            <!-- Color Theme js -->
            <script src="../assets/js/themeColors.js"></script>

            <!-- Sticky js -->
            <script src="../assets/js/sticky.js"></script>

            <!-- CUSTOM JS -->
            <script src="../assets/js/custom.js"></script>

            <!-- Custom-switcher -->
            <script src="../assets/js/custom-swicher.js"></script>

            <!-- Switcher js -->
            <script src="../assets/switcher/js/switcher.js"></script>


            <!-- SELECT2 JS -->
            <script src="../assets/plugins/select2/select2.full.min.js"></script>
            <script src="../assets/js/select2.js"></script>

            <?php
            require('scripts.php');
            ?>

</body>

</html>