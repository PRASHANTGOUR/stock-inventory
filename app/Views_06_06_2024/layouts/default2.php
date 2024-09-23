<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Craft 
Product Version: 1.1.4
Purchase: https://themes.getbootstrap.com/product/craft-bootstrap-5-admin-dashboard-theme
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../" />
    <title>Airquee Inflatables Project Phoenix 2.0 - <?= $title ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="Craft admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="keywords" content="Craft, bootstrap, bootstrap 5, admin themes, dark mode, free admin themes, bootstrap admin, bootstrap dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Craft | Bootstrap 5 HTML Admin Dashboard Theme - Craft by KeenThemes" />
    <meta property="og:url" content="https://themes.getbootstrap.com/product/craft-bootstrap-5-admin-dashboard-theme" />
    <meta property="og:site_name" content="Craft by Keenthemes" />
    <link rel="canonical" href="https://preview.keenthemes.com/craft" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="/prod/public/assets/plugins/custom/leaflet/leaflet.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/prod/public/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/prod/public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/prod/public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link href="/prod/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid" id="kt_wrapper" style="padding: 20px;">
            <!--begin::Header-->

            <!--end::Header-->

            <!--begin::Content-->

            <div class="content fs-6 d-flex flex-column flex-column-fluid" id="kt_content">

                <?php echo $this->renderSection('content'); ?>

                <!-- SCRIPTS -->

                <?php

                # Output Pagination

                if (isset($pager)) {

                    echo $pager->links();
                } else if (isset($pager_links)) {

                    echo $pager_links;
                }

                ?>



            </div>

            <!--end::Content-->

            <!--begin::Footer-->

            <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">

                <!--begin::Container-->

                <div class="container-fluid d-flex flex-column flex-md-row flex-stack">

                    <!--begin::Copyright-->

                    <div class="text-gray-900 order-2 order-md-1">

                        <span class="text-muted fw-semibold me-2"><?= date("Y"); ?>&copy;</span>

                        <a href="https://airquee.com" target="_blank" class="text-gray-800 text-hover-primary">Airquee Inflatables</a>

                    </div>

                    <!--end::Copyright-->

                    <!--begin::Menu-->

                    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">

                        <li class="menu-item">

                            <a href="#" class="menu-link px-2" data-bs-toggle="modal" data-bs-target="#about_modal">About</a>

                        </li>

                        <li class="menu-item">

                            <a href="mailto:dev@airquee.eu" target="_blank" class="menu-link px-2">Support</a>

                        </li>

                    </ul>

                    <!--end::Menu-->

                </div>

                <!--end::Container-->

            </div>

            <!--end::Footer-->

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">

            <span class="path1"></span>

            <span class="path2"></span>

        </i>

    </div>
    <!--end::Scrolltop-->
    <!--begin::Modals-->
    <!--begin::Modal - Create Project-->
    <div class="modal fade" id="about_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->

        <div class="modal-dialog modal-fullscreen p-9">

            <!--begin::Modal content-->

            <div class="modal-content modal-rounded">

                <!--begin::Modal header-->

                <div class="modal-header">

                    <!--begin::Modal title-->

                    <h2>About Project Phoenix Project</h2>

                    <!--end::Modal title-->

                    <!--begin::Close-->

                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">

                        <i class="ki-duotone ki-cross fs-1">

                            <span class="path1"></span>

                            <span class="path2"></span>

                        </i>

                    </div>

                    <!--end::Close-->

                </div>

                <!--end::Modal header-->

                <!--begin::Modal body-->

                <div class="modal-body scroll-y m-5">

                    <!--begin::Stepper-->

                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">

                        <!--begin::Container-->

                        <div class="container">

                            <h2>Overview</h2>

                            <p>To help people</p>

                            <h3>Support</h3>

                            <p>Email someone</p>

                        </div>

                        <!--begin::Container-->

                    </div>

                    <!--end::Stepper-->

                </div>

                <!--end::Modal body-->

            </div>

            <!--end::Modal content-->

        </div>

        <!--end::Modal dialog-->

    </div>
    <!--end::Modal - Create Project-->
    <div class="modal fade" id="alerts_notifications_modal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-small p-9">

            <div class="modal-content modal-rounded">

                <div class="modal-header">

                    <h2>Message</h2>

                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">

                        <i class="ki-duotone ki-cross fs-1">

                            <span class="path1"></span>

                            <span class="path2"></span>

                        </i>

                    </div>

                </div>

                <div class="modal-body scroll-y m-5">

                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">

                        <div class="container">

                            <h2>System Notification</h2>

                            <div class="text-center pt-15">

                                <p class='h3'>

                                    <?php

                                    # Errors 

                                    if (session()->has("errors")) {

                                        foreach (session("errors") as $error) {

                                            echo $error . "<br>";
                                        }



                                        # Messages

                                    } else if (session()->has("message")) {

                                        echo session("message");
                                    }

                                    ?>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/prod/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/prod/public/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/prod/public/assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="/prod/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/prod/public/assets/js/widgets.bundle.js"></script>
    <script src="/prod/public/assets/js/custom/widgets.js"></script>
    <script src="/prod/public/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/type.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/budget.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/settings.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/team.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/targets.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/files.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/complete.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-project/main.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/prod/public/assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="/prod/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    <?php
    # Errors 
    if (session()->has("errors") or session()->has("message")) { ?>
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('alerts_notifications_modal'), {})
            myModal.toggle()
        </script>
    <?php } ?>
    <script>
        function all_employee_changed(element) {
            if ($(element).prop('checked') == true) {
                $('#employee_id').removeAttr('required');
            } else {
                $('#employee_id').attr("required", true);
            }
        }
        jQuery('#employee_id').select2({
            selectOnClose: true
        });
    </script>
</body>
<!--end::Body-->

</html>