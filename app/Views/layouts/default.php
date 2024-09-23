<?php
$User = auth()->user()->username;
$Intial = substr($User, 0, 1);
$Email = auth()->user()->email;
function menuActive($URL) {
	return current_url() == $URL ? ' active':'';
}
$uri = new \CodeIgniter\HTTP\URI(current_url());
$uri_array = parse_url($uri);
$url_path = isset($uri_array['path']) ? $uri_array['path'] : '';
?>
<br>
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
		<title>Airquee Inflatables Project Phoenix 2.0 - <?=$title?></title>
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
        <link href="/stock/public/assets/plugins/custom/leaflet/leaflet.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/stock/public/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
        <!--end::Vendor Stylesheets-->
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="/stock/public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/stock/public/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        <!--end::Global Stylesheets Bundle-->
        <link href="/stock/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside aside-default aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
					<!--begin::Brand-->
					<div class="aside-logo flex-column-auto px-10 pt-9 pb-5" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="<?= url_to("Home::index");?>">
                            <img src="https://airquee.com/images/Airquee-Inflatables-logo.png" width="100%">
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					<div class="aside-menu flex-column-fluid ps-3 pe-1">
						<!--begin::Aside Menu-->
						<!--begin::Menu-->
						<div class="menu menu-sub-indention menu-column menu-rounded menu-title-gray-600 menu-icon-gray-500 menu-active-bg menu-state-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
							<div class="hover-scroll-y mx-4" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="20px" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer">
                            <!--begin:Menu item-->
								<?php 
								$login_user_id = auth()->user()->id;
								?>
                                <?php if (auth()->user()->can('airqueedashboard.access') OR auth()->user()->can('airparxdashboard.access') OR auth()->user()->can('productiondashboard.access')) { ?>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion<?= $uri->getSegment(1) === 'dashboard' ? ' show':'';?>">
										<span class="menu-link">
											<span class="menu-icon">
												<i class="ki-duotone ki-element-11 fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
												</i>
											</span>
											<span class="menu-title"><?= lang('Menu.Boards'); ?></span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<?php if (auth()->user()->can('airqueedashboard.access')) { ?>
											<div class="menu-sub menu-sub-accordion">
												<div class="menu-item">
													<a class="menu-link" href="#">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.AirqueeSales'); ?></span>
													</a>
												</div>
											</div>
										<?php } ?>
										<?php if (auth()->user()->can('airparxdashboard.access')) { ?>
											<div class="menu-sub menu-sub-accordion">
												<div class="menu-item">
													<a class="menu-link" href="#">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.AirparxSales'); ?></span>
													</a>
												</div>
											</div>
										<?php } ?>
										<?php if (auth()->user()->can('productiondashboard.access')) { ?>
											<div class="menu-sub menu-sub-accordion">
												<div class="menu-item">							
													<a class="menu-link<?= menuActive(url_to('ProductionDashboard::index')) ?>" href="<?php echo url_to('ProductionDashboard::index');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Production'); ?></span>
													</a>
												</div>
											</div>
										<?php } ?>
									</div>
                                <?php } ?>
								<!--begin:Menu item-->
								<div class="menu-item pt-5">
									<!--begin:Menu content-->
									<div class="menu-content">
										<span class="fw-bold text-muted text-uppercase fs-7"><?= lang('Menu.Modules'); ?></span>
									</div>
									<!--end:Menu content-->
								</div>
								<!--end:Menu item-->
								<?php if (auth()->user()->can('crm.access')) { ?>
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-icon">
												<i class="ki-duotone ki-briefcase fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title"><?= lang('Menu.CRM'); ?></span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion">
											<!--begin:Menu item-->
											<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<!--begin:Menu link-->
												<span class="menu-link">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title"><?= lang('Menu.Customers'); ?></span>
													<span class="menu-arrow"></span>
												</span>
												<!--end:Menu link-->
												<!--begin:Menu sub-->
												<div class="menu-sub menu-sub-accordion">
													<!--begin:Menu item-->
													<div class="menu-item">
														<!--begin:Menu link-->
														<a class="menu-link" href="#">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title"><?= lang('Menu.View Customers'); ?></span>
														</a>
														<!--end:Menu link-->
													</div>
													<!--end:Menu item-->
													<!--begin:Menu item-->
													<div class="menu-item">
														<!--begin:Menu link-->
														<a class="menu-link" href="#">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title"><?= lang('Menu.Add Customers'); ?></span>
														</a>
														<!--end:Menu link-->
													</div>
													<!--end:Menu item-->
												</div>
												<!--end:Menu sub-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion">
											<!--begin:Menu item-->
											<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<!--begin:Menu link-->
												<span class="menu-link">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Orders</span>
													<span class="menu-arrow"></span>
												</span>
												<!--end:Menu link-->
												<!--begin:Menu sub-->
												<div class="menu-sub menu-sub-accordion">
													<!--begin:Menu item-->
													<div class="menu-item">
														<!--begin:Menu link-->
														<a class="menu-link" href="#">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
															<span class="menu-title">View Orders</span>
														</a>
														<!--end:Menu link-->
													</div>
													<!--end:Menu item-->
												</div>
												<!--end:Menu sub-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
								<?php } ?>
								<?php if (auth()->user()->can('admin.access')) { ?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="bi bi-inboxes"></i>
											</span>
                                            <span class="menu-title">Admin</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'admin' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Admin::addUnit')) ?>" href="<?= url_to('Admin::addUnit');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Add Unit</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
											<!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Admin::units')) ?>" href="<?= url_to('Admin::units');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">View Unit</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
								<?php }elseif (auth()->user()->can('employees.access')) { 
									if(UserPermissionCHeck($login_user_id, 'admin_view') == 1 || UserPermissionCHeck($login_user_id, 'admin_edit') == 1){
									?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="bi bi-inboxes"></i>
											</span>
                                            <span class="menu-title">Admin</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'admin' ? ' show':'';?>">
											<?php if(UserPermissionCHeck($login_user_id, 'admin_edit') == 1){?>
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Admin::addUnit')) ?>" href="<?= url_to('Admin::addUnit');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Add Unit</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
											<?php } ?>
											<?php if(UserPermissionCHeck($login_user_id, 'admin_view')){?>
											<!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Admin::units')) ?>" href="<?= url_to('Admin::units');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">View Unit</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
											<?php } ?>
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
								<?php } ?>
								<?php if (auth()->user()->can('design.access')) { ?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="bi bi-easel"></i>
											</span>
                                            <span class="menu-title">Design</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'design' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Design::unit')) ?>" href="<?= url_to('Design::unit');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">View Units</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php }elseif (auth()->user()->can('employees.access')) { 
									if(UserPermissionCHeck($login_user_id, 'design_view') == 1){
									?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="bi bi-easel"></i>
											</span>
                                            <span class="menu-title">Design</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'design' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Design::unit')) ?>" href="<?= url_to('Design::unit');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">View Units</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
								<?php } ?>
                                <?php if (auth()->user()->can('catalogue.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-duotone ki-handcart fs-2"></i>
											</span>
                                            <span class="menu-title">Products</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'catalogue' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Catalogue::index')) ?>" href="<?= url_to('Catalogue::index');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">View Products</span>
                                                </a>
                                                <!--end:Menu link-->
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="<?= url_to('Category::index');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Categories</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php }elseif (auth()->user()->can('employees.access')) { 
									if(UserPermissionCHeck($login_user_id, 'products_view') == 1){
									?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-duotone ki-handcart fs-2"></i>
											</span>
                                            <span class="menu-title">Products</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'catalogue' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <a class="menu-link<?= menuActive(url_to('Catalogue::index')) ?>" href="<?= url_to('Catalogue::index');?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">View Products</span>
                                                </a>
                                                <!--end:Menu link-->
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="#">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Categories</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
								<?php } ?>
								<?php if (auth()->user()->can('finance.access')) { ?>
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="#">
											<span class="menu-icon">
												<i class="bi bi-cash-coin">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title">Finance</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								<?php } ?>
								<?php if (auth()->user()->can('production.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Production'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'production' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('productiondashboard.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('ProductionDashboard::index')) ?>" href="<?php echo url_to('ProductionDashboard::index');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Dashboard'); ?></span>
													</a>
												<?php } ?>
												<?php if (auth()->user()->can('production.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Production::units')) ?>" href="<?php echo url_to('Production::units');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Units'); ?></span>
													</a>
												<?php } ?>
												<?php if (auth()->user()->can('production.super')) { ?>
													<a class="menu-link<?= menuActive(url_to('Production::teams')) ?>" href="<?php echo url_to('Production::teams');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Teams'); ?></span>
													</a>
												<?php } ?>
												<?php if (auth()->user()->can('production.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Production::daily')) ?>" href="<?php echo url_to('Production::daily');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Daily'); ?></span>
													</a>
												<?php } ?>
												<?php if (auth()->user()->can('production.super')) { ?>
													<a class="menu-link<?= menuActive(url_to('Production::viewModifications')) ?>" href="<?php echo url_to('Production::viewModifications');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.ModificationsReport'); ?></span>
													</a>
												<?php } ?>
												<?php if (auth()->user()->can('production.super')) { ?>
													<a class="menu-link<?= menuActive(url_to('Production::eventLog')) ?>" href="<?php echo url_to('Production::eventLog');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Log'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php }elseif (auth()->user()->can('employees.access')) { 
									if(UserPermissionCHeck($login_user_id, 'production_view') == 1){
									?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Production'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'production' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
													<a class="menu-link<?= menuActive(url_to('ProductionDashboard::index')) ?>" href="<?php echo url_to('ProductionDashboard::index');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Dashboard'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Production::units')) ?>" href="<?php echo url_to('Production::units');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Units'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Production::teams')) ?>" href="<?php echo url_to('Production::teams');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Teams'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Production::daily')) ?>" href="<?php echo url_to('Production::daily');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Daily'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Production::viewModifications')) ?>" href="<?php echo url_to('Production::viewModifications');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.ModificationsReport'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Production::eventLog')) ?>" href="<?php echo url_to('Production::eventLog');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Log'); ?></span>
													</a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
								<?php } ?>
                                <?php if (auth()->user()->can('production.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Departments'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'department' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('productiondashboard.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Department::list')) ?>" href="<?php echo url_to('Department::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Department List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Department::addDepartment')) ?>" href="<?php echo url_to('Department::addDepartment');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Department'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php }else if (auth()->user()->can('employees.access')) { ?>
                                    <!--begin:Menu item-->
									<?php
									if(UserPermissionCHeck($login_user_id, 'departments_view') == 1 || UserPermissionCHeck($login_user_id, 'departments_edit') == 1){	
									?>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Departments'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'department' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php
												if(UserPermissionCHeck($login_user_id, 'departments_view') == 1){	
												?>
													<a class="menu-link<?= menuActive(url_to('Department::list')) ?>" href="<?php echo url_to('Department::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Department List'); ?></span>
													</a>
													<?php } ?>	
													<?php
													if(UserPermissionCHeck($login_user_id, 'departments_edit') == 1){	
													?>
													<a class="menu-link<?= menuActive(url_to('Department::addDepartment')) ?>" href="<?php echo url_to('Department::addDepartment');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Department'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
                                <?php } ?>
                                <?php if (auth()->user()->can('production.access')) { ?>
	                                  <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Employees'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= ($uri->getSegment(1) === 'employee' || $uri->getSegment(1) === 'employees') ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('productiondashboard.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Employees::list')) ?>" href="<?php echo url_to('Employees::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Employee List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Employees::permission_list')) ?>" href="<?php echo url_to('Employees::permission_list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Employee Permission'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Employees::addEmployee')) ?>" href="<?php echo url_to('Employees::addEmployee');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Employee'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } else if (auth()->user()->can('employees.access')) { ?>
									<?php
									if(UserPermissionCHeck($login_user_id, 'employees_view') == 1 || UserPermissionCHeck($login_user_id, 'employees_edit') == 1){	
									?>
	                                  <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Employees'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= ($uri->getSegment(1) === 'employee' || $uri->getSegment(1) === 'employees') ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
													<?php
													if(UserPermissionCHeck($login_user_id, 'employees_view') == 1){	
													?>
													<a class="menu-link<?= menuActive(url_to('Employees::list')) ?>" href="<?php echo url_to('Employees::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Employee List'); ?></span>
													</a>
													<?php } ?>
													<?php
													if(UserPermissionCHeck($login_user_id, 'employees_edit') == 1){	
													?>
													<a class="menu-link<?= menuActive(url_to('Employees::permission_list')) ?>" href="<?php echo url_to('Employees::permission_list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Employee Permission'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Employees::addEmployee')) ?>" href="<?php echo url_to('Employees::addEmployee');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Employee'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
                                <?php } ?>
                                <?php if (auth()->user()->can('production.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.EmployeesLeave'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'employees_leave' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('productiondashboard.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('EmployeesLeave::list')) ?>" href="<?php echo url_to('EmployeesLeave::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.EmployeesLeave List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('EmployeesLeave::LeaveTotallist')) ?>" href="<?php echo url_to('EmployeesLeave::LeaveTotallist');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Leave Total List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('EmployeesLeave::loglist')) ?>" href="<?php echo url_to('EmployeesLeave::loglist');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Leave Log List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('EmployeesLeave::addEmployeesLeave')) ?>" href="<?php echo url_to('EmployeesLeave::addEmployeesLeave');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add EmployeesLeave'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } ?>
                                <?php /* if (auth()->user()->can('production.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.EmployeesTask'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'employees_task' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('productiondashboard.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('EmployeesTask::list')) ?>" href="<?php echo url_to('EmployeesTask::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.EmployeesTask List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('EmployeesTask::addEmployeesTask')) ?>" href="<?php echo url_to('EmployeesTask::addEmployeesTask');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add EmployeesTask'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } */ ?>
                                <?php if (auth()->user()->can('production.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Calendar'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'calendar' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('productiondashboard.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Calendar::list')) ?>" href="<?php echo url_to('Calendar::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Calendar List'); ?></span>
													</a>
													<!--<a class="menu-link<?= menuActive(url_to('Calendar::addCalendar')) ?>" href="<?php echo url_to('Calendar::addCalendar');?>">-->
													<!--	<span class="menu-bullet">-->
													<!--		<span class="bullet bullet-dot"></span>-->
													<!--	</span>-->
													<!--	<span class="menu-title"><?= lang('Menu.Add Calendar'); ?></span>-->
													<!--</a>-->
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } ?>
                                <?php if (auth()->user()->can('employees.access')) { ?>
									<?php
									if(UserPermissionCHeck($login_user_id, 'leave_view') == 1 || UserPermissionCHeck($login_user_id, 'leave_edit') == 1){	
									?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Leave'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'leave' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
													<?php
													if(UserPermissionCHeck($login_user_id, 'leave_view') == 1){	
													?>
													<a class="menu-link<?= menuActive(url_to('Leave::list')) ?>" href="<?php echo url_to('Leave::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Leave List'); ?></span>
													</a>
													<?php } ?>
													<?php
													if(UserPermissionCHeck($login_user_id, 'leave_edit') == 1){	
													?>
													<a  style="display:none;" class="menu-link<?= menuActive(url_to('Leave::addLeave')) ?>" href="<?php echo url_to('Leave::addLeave');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Leave'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('EmployeesLeave::addEmployeesLeave')) ?>" href="<?php echo url_to('EmployeesLeave::addEmployeesLeave');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Leave'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
                                <?php } ?>
                                <?php if (auth()->user()->can('employees.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Calendar'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'employeescalendar' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('employees.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Calendaremployees::list')) ?>" href="<?php echo url_to('Calendaremployees::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Calendar List'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } ?>
                                <?php if (auth()->user()->can('employees.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion" style="display:none;">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-gift fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"><?= lang('Menu.Task'); ?></span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'task' ? ' show':'';?>">
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
												<?php if (auth()->user()->can('employees.access')) { ?>
													<a class="menu-link<?= menuActive(url_to('Task::list')) ?>" href="<?php echo url_to('Task::list');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Task List'); ?></span>
													</a>
													<a class="menu-link<?= menuActive(url_to('Task::addTask')) ?>" href="<?php echo url_to('Task::addTask');?>">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title"><?= lang('Menu.Add Task'); ?></span>
													</a>
												<?php } ?>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } ?>
								<?php if (auth()->user()->can('logistics.access')) { ?>
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="#">
											<span class="menu-icon">
												<i class="bi bi-truck">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title">Logistics</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								<?php } ?>
								<?php if (auth()->user()->can('projects.access')) { ?>
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="#">
											<span class="menu-icon">
												<i class="ki-duotone ki-rocket fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title">Projects</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								<?php } ?>
								<?php if (auth()->user()->can('reporting.access')) { ?>
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="#">
											<span class="menu-icon">
												<i class="bi bi-file-earmark-bar-graph">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title">Reporting</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								<?php } ?>
								<!--begin:Menu item-->
								<div class="menu-item">
									<!--begin:Menu content-->
									<div class="menu-content">
										<div class="separator mx-1 my-4"></div>
									</div>
									<!--end:Menu content-->
								</div>
								<!--end:Menu item-->
								<?php 
								if (auth()->user()->can('support.access') OR auth()->user()->can('users.edit') OR auth()->user()->can('log.access')) { 
								?>
                                <!--begin:Menu item-->
								<div class="menu-item pt-5">
									<!--begin:Menu content-->
									<div class="menu-content">
										<span class="fw-bold text-muted text-uppercase fs-7">Settings</span>
									</div>
									<!--end:Menu content-->
								</div>
								<!--end:Menu item-->
								<?php 
								} 
                                if (auth()->user()->can('users.edit')) { ?>
                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-duotone ki-shield-tick fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
                                            <span class="menu-title">User Management</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'user-management' ? ' show':'';?>">
												<!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link<?= menuActive(url_to('UserManagement::index')) ?>" href="<?= url_to('UserManagement::index')?>">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">View Users</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
													<!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                       <a class="menu-link<?= menuActive(url_to('Hr::listStaff')) ?>" href="<?= url_to('Hr::listStaff')?>">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">View Staff</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
											<?php /* ?>
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <span class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Roles</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link" href="pages/social/feeds.html">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">View Roles</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <!--end:Menu item-->
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <span class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Permissions</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link" href="pages/social/feeds.html">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">View Permissions</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <!--end:Menu sub-->
											<?php */ ?>
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php }elseif (auth()->user()->can('employees.access')) { 
									if(UserPermissionCHeck($login_user_id, 'staff_view') == 1){
									?>
									<!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-duotone ki-shield-tick fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
                                            <span class="menu-title">User Management</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion<?= $uri->getSegment(1) === 'user-management' ? ' show':'';?>">
												<!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                   <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                       <a class="menu-link<?= menuActive(url_to('Hr::listStaff')) ?>" href="<?= url_to('Hr::listStaff')?>">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">View Staff</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
									<?php } ?>
								<?php } ?>
							   <?php 
                                if (auth()->user()->can('support.access')) { ?>
                                <!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-duotone ki-chart fs-2">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
										</span>
										<span class="menu-title">Support</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
											<!--begin:Menu link-->
											<span class="menu-link">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Support Tickets</span>
												<span class="menu-arrow"></span>
											</span>
											<!--end:Menu link-->
											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link" href="pages/user-profile/overview.html">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">View Support Tickets</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
											</div>
											<!--end:Menu sub-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
											<!--begin:Menu link-->
											<span class="menu-link">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Tutorials</span>
												<span class="menu-arrow"></span>
											</span>
											<!--end:Menu link-->
											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link" href="pages/social/feeds.html">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">View Tutorials</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
											</div>
											<!--end:Menu sub-->
										</div>
										<!--end:Menu item-->
                                        <!--begin:Menu item-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
											<!--begin:Menu link-->
											<span class="menu-link">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">FAQ</span>
												<span class="menu-arrow"></span>
											</span>
											<!--end:Menu link-->
											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link" href="#">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">View FAQs</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
											</div>
											<!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu sub-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								<?php } ?>
                                <?php 
                                # Restrict to Super User and Dev
                                if (auth()->user()->can('log.access')) { ?>
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="<?php echo site_url('/admin/event-log');?>">
											<span class="menu-icon">
												<i class="ki-duotone ki-code fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
												</i>
											</span>
                                            <span class="menu-title">User Log</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                <?php } ?>
							</div>
						</div>
						<!--end::Menu-->
					</div>
					<!--end::Aside menu-->
					<!--begin::Footer-->
					<div class="aside-footer flex-column-auto pb-5 d-none" id="kt_aside_footer">
						<a href="#" class="btn btn-light-primary w-100">Button</a>
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Logo bar-->
							<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
								<!--begin::Aside Toggle-->
								<div class="d-flex align-items-center d-lg-none">
									<div class="btn btn-icon btn-active-color-primary ms-n2 me-1" id="kt_aside_toggle">
										<i class="ki-duotone ki-abstract-14 fs-1">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
									</div>
								</div>
								<!--end::Aside Toggle-->
								<!--begin::Logo-->
								<a href="/" class="d-lg-none">
                                    <img src="https://airquee.com/images/Airquee-Inflatables-logo.png" width="100%">
								</a>
								<!--end::Logo-->
								<!--begin::Aside toggler-->
								<div class="btn btn-icon w-auto ps-0 btn-active-color-primary d-none d-lg-inline-flex me-2 me-lg-5" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
									<i class="ki-duotone ki-black-left-line fs-1 rotate-180">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
								<!--end::Aside toggler-->
							</div>
							<!--end::Logo bar-->
							<!--begin::Topbar-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<!--begin::Search-->
								<div class="d-flex align-items-stretch me-1">
								<?php /* ?>
									<!--begin::Search-->
									<div id="kt_header_search" class="header-search d-flex align-items-center w-100 w-lg-300px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
										<!--begin::Tablet and mobile search toggle-->
										<div data-kt-search-element="toggle" class="search-toggle-mobile d-flex d-lg-none align-items-center">
											<div class="d-flex">

												<i class="ki-duotone ki-magnifier fs-1">

													<span class="path1"></span>

													<span class="path2"></span>

												</i>

											</div>

										</div>

										<!--end::Tablet and mobile search toggle-->

										<!--begin::Form(use d-none d-lg-block classes for responsive search)-->

										<form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">

											<!--begin::Hidden input(Added to disable form autocomplete)-->

											<input type="hidden" />

											<!--end::Hidden input-->

											<!--begin::Icon-->

											<i class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">

												<span class="path1"></span>

												<span class="path2"></span>

											</i>

											<!--end::Icon-->

											<!--begin::Input-->

											<input type="text" class="search-input form-control form-control-solid ps-13" name="search" value="" placeholder="Search..." data-kt-search-element="input" />

											<!--end::Input-->

											<!--begin::Spinner-->

											<span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">

												<span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>

											</span>

											<!--end::Spinner-->

											<!--begin::Reset-->

											<span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">

												<i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">

													<span class="path1"></span>

													<span class="path2"></span>

												</i>

											</span>

											<!--end::Reset-->

										</form>

										<!--end::Form-->

									</div>

									<!--end::Search-->

																	<?php */ ?>



								</div>

								<!--end::Search-->

								<!--begin::Toolbar wrapper-->

								<div class="d-flex align-items-stretch flex-shrink-0">

									<!--begin::Theme mode-->
									<div class="d-flex align-items-center ms-1 ms-lg-2">
										<?php echo date('Y-m-d H:i:s A');?>
									</div>
									<div class="d-flex align-items-center ms-1 ms-lg-2">

										<!--begin::Menu toggle-->

										<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

											<i class="ki-duotone ki-night-day theme-light-show fs-1">

												<span class="path1"></span>

												<span class="path2"></span>

												<span class="path3"></span>

												<span class="path4"></span>

												<span class="path5"></span>

												<span class="path6"></span>

												<span class="path7"></span>

												<span class="path8"></span>

												<span class="path9"></span>

												<span class="path10"></span>

											</i>

											<i class="ki-duotone ki-moon theme-dark-show fs-1">

												<span class="path1"></span>

												<span class="path2"></span>

											</i>

										</a>

										<!--begin::Menu toggle-->

										<!--begin::Menu-->

										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">

											<!--begin::Menu item-->

											<div class="menu-item px-3 my-0">

												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">

													<span class="menu-icon" data-kt-element="icon">

														<i class="ki-duotone ki-night-day fs-2">

															<span class="path1"></span>

															<span class="path2"></span>

															<span class="path3"></span>

															<span class="path4"></span>

															<span class="path5"></span>

															<span class="path6"></span>

															<span class="path7"></span>

															<span class="path8"></span>

															<span class="path9"></span>

															<span class="path10"></span>

														</i>

													</span>

													<span class="menu-title">Light</span>

												</a>

											</div>

											<!--end::Menu item-->

											<!--begin::Menu item-->

											<div class="menu-item px-3 my-0">

												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">

													<span class="menu-icon" data-kt-element="icon">

														<i class="ki-duotone ki-moon fs-2">

															<span class="path1"></span>

															<span class="path2"></span>

														</i>

													</span>

													<span class="menu-title">Dark</span>

												</a>

											</div>

											<!--end::Menu item-->

											<!--begin::Menu item-->

											<div class="menu-item px-3 my-0">

												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">

													<span class="menu-icon" data-kt-element="icon">

														<i class="ki-duotone ki-screen fs-2">

															<span class="path1"></span>

															<span class="path2"></span>

															<span class="path3"></span>

															<span class="path4"></span>

														</i>

													</span>

													<span class="menu-title">System</span>

												</a>

											</div>

											<!--end::Menu item-->

										</div>

										<!--end::Menu-->

									</div>

									<!--end::Theme mode-->



									<!--begin::User-->

									<div class="d-flex align-items-center ms-2 ms-lg-3" id="kt_header_user_menu_toggle">

										<!--begin::Menu wrapper-->

										<div class="cursor-pointer symbol symbol-35px symbol-lg-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

                                            <span style="color: white; background: #2f51a0; padding: 8px 12px; border-radius: 20px;"><?php echo $Intial?></span>

										</div>

										<!--begin::User account menu-->

										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">

											<!--begin::Menu item-->

											<div class="menu-item px-3">

												<div class="menu-content d-flex align-items-center px-3">

													<!--begin::Avatar-->

													<div class="symbol symbol-50px me-5">

                                                        <span style="color: white; background: #2f51a0; padding: 8px 12px; border-radius: 20px;"><?php echo $Intial?></span>

													</div>

													<!--end::Avatar-->

													<!--begin::Username-->

													<div class="d-flex flex-column">

														<div class="fw-bold d-flex align-items-center fs-5"><?php echo $User;?>

														<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"></span></div>

														<span class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $Email;?></span>

													</div>

													<!--end::Username-->

												</div>

											</div>

											<!--end::Menu item-->

											<!--begin::Menu separator-->

											<?php /* ?>

											<div class="separator my-2"></div>

											<!--end::Menu separator-->

											<!--begin::Menu item-->

											<div class="menu-item px-5">

												<a href="account/overview.html" class="menu-link px-5">My Profile</a>

											</div>

											<!--end::Menu item-->

											<!--begin::Menu separator-->

											<?php */?>

											<div class="separator my-2"></div>

											<!--end::Menu separator-->



											<?php 

												$language = session("language");

												switch ($language) {

													case "English":

														$flag = "united-kingdom";

														break;

													case "Română":

														$flag = "romania";

														break;

													case "Maghiară":

														$flag = "hungary";

														break;

													default:

														$flag = "united-kingdom";

												}

											?>

											<!--begin::Menu item-->

											<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">

												<a href="#" class="menu-link px-5">

													<span class="menu-title position-relative">Language 

													<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0"><?= $language; ?> 

													<img class="w-15px h-15px rounded-1 ms-2" src="/stock/public/assets/media/flags/<?=$flag?>.svg" alt="" /></span></span>

												</a>

												<!--begin::Menu sub-->



												<div class="menu-sub menu-sub-dropdown w-175px py-4">

													<!--begin::Menu item-->

													<div class="menu-item px-3">

														<a href="<?= site_url('lang/en'); ?>" class="menu-link d-flex px-5 <?= $language === 'English' ? ' active' : '';?>">

														<span class="symbol symbol-20px me-4">

															<img class="rounded-1" src="/stock/public/assets/media/flags/united-kingdom.svg" alt="" />

														</span>English</a>

													</div>

													<!--end::Menu item-->

													<!--begin::Menu item-->

													<div class="menu-item px-3">

														<a href="<?= site_url('lang/ro'); ?>" class="menu-link d-flex px-5 <?= $language === 'Română' ? ' active' : '';?>">

														<span class="symbol symbol-20px me-4">

															<img class="rounded-1" src="/stock/public/assets/media/flags/romania.svg" alt="" />

														</span>Română</a>

													</div>

													<!--end::Menu item-->

                                                    <!--begin::Menu item-->

													<div class="menu-item px-3">

														<a href="<?= site_url('lang/hu'); ?>" class="menu-link d-flex px-5 <?= $language === 'Maghiară' ? ' active' : '';?>">

														<span class="symbol symbol-20px me-4">

															<img class="rounded-1" src="/stock/public/assets/media/flags/hungary.svg" alt="" />

														</span>Maghiară</a>

													</div>

													<!--end::Menu item-->

												</div>

												<!--end::Menu sub-->

											</div>

											<!--end::Menu item-->

											<!--begin::Menu item-->

											<div class="menu-item px-5 my-1">

												<a href="<?= url_to('UserManagement::resetPassword'); ?>" class="menu-link px-5">Change Password</a>

											</div>

											<!--end::Menu item-->

											<!--begin::Menu item-->

											<div class="menu-item px-5">

												<a href="<?php echo site_url('/logout');?>" class="menu-link px-5">Sign Out</a>

											</div>

											<!--end::Menu item-->

										</div>

										<!--end::User account menu-->

										<!--end::Menu wrapper-->

									</div>

									<!--end::User -->

								</div>

								<!--end::Toolbar wrapper-->

							</div>

							<!--end::Topbar-->

						</div>

						<!--end::Container-->

					</div>

					<!--end::Header-->

					<!--begin::Content-->

					<div class="content fs-6 d-flex flex-column flex-column-fluid" id="kt_content">
							<?php
							$url_path = str_replace('/prod','',$url_path);
							if($url_path == '/employee/view-attendances'){
								$go_back_action = url_to('Employees::list');
							}elseif($url_path == '/calendar/detail'){
								$go_back_action = url_to('Calendar::list');
							}else{
								$go_back_action = 'javascript:window.history.go(-1);';
							}
							?>
							
							<h1 style="padding-left: 1.3em;"><a href="<?php echo $go_back_action;?>"><i class="bi bi-arrow-90deg-left"></i></a> <?php echo $this->renderSection('heading'); ?></h1>

                            <?php echo $this->renderSection('content'); ?>

                            <!-- SCRIPTS -->

                            <?php

								# Output Pagination

								if(isset($pager)) {

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

								<span class="text-muted fw-semibold me-2"><?= date("Y");?>&copy;</span>

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

										if (session() -> has("errors")) {

											foreach(session("errors") as $error) {

												echo $error."<br>";

											}



										# Messages

										} else if (session() -> has("message")) {

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
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="/stock/public/assets/plugins/global/plugins.bundle.js"></script>
        <script src="/stock/public/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
        <script src="/stock/public/assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
        <script src="/stock/public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
        <script src="/stock/public/assets/js/widgets.bundle.js"></script>
        <script src="/stock/public/assets/js/custom/widgets.js"></script>
        <script src="/stock/public/assets/js/custom/apps/chat/chat.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/type.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/budget.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/settings.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/team.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/targets.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/files.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/complete.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-project/main.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/select-location.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/create-app.js"></script>
        <script src="/stock/public/assets/js/custom/utilities/modals/users-search.js"></script>
        <script src="/stock/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
		<?php
		# Errors 
		if (session() -> has("errors") OR session() -> has("message")) { ?>
			<script>
			var myModal = new bootstrap.Modal(document.getElementById('alerts_notifications_modal'), {})
			myModal.toggle()
			</script>
		<?php } ?>
<script>
    function all_employee_changed(element)
    {
        if($(element).prop('checked') == true){
            $('#employee_id').removeAttr('required');
        }else{
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
