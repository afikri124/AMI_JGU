<x-guest-layout>
	<!-- Session Status -->
	<x-auth-session-status class="mb-4" :status="session('status')" />

<body data-kt-name="metronic" id="kt_body" class="app-blank app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<!--begin::Form-->
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-600px p-10">
							<!--begin::Form-->
							<form method="POST" class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login3') }}">
							@csrf
							<div class="text-center mb-11">
									<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
									<div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
								</div>
								<!--begin::Input group=-->
								<!--email-->
								<div class="fv-row mb-8">
									<x-input-label for="login_account" :value="__('Email/Username')" />
									<x-text-input id="login_account" class="block mt-1 w-full" type="text" name="login_account" :value="old('login_account')" autocomplete="username" />
									<x-input-error :messages="$errors->get('email')" class="mt-2" />
									<x-input-error :messages="$errors->get('username')" class="mt-2" />
								</div>
								<!--password-->
								<div class="fv-row mb-3">
									<x-input-label for="password" :value="__('Password')" />
									<x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="current-password" />
									<x-input-error :messages="$errors->get('password')" class="mt-2" />
								</div>
								<!--end::Input group=-->
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
									<!--begin::Link-->
									<a href="../../demo1/dist/authentication/layouts/corporate/reset-password.html" class="link-primary">Forgot Password ?</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Submit button-->
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-danger">
										<!--begin::Indicator label-->
										<span class="indicator-label"> {{ __('Log in') }} Sign In</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div>
								<!--end::Submit button-->
								<!--begin::Sign up-->
								<div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
								<a href="../../demo1/dist/authentication/layouts/corporate/sign-up.html" class="link-primary">Sign up</a></div>
								<!--end::Sign up-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Form-->

					<!--begin::Footer-->
					<div class="d-flex flex-center flex-wrap px-5">
						<!--begin::Links-->
						<div class="d-flex fw-semibold text-primary fs-base">
							<a href="" class="px-5" target="_blank">Terms</a>
							<a href="" class="px-5" target="_blank">Plans</a>
							<a href="" class="px-5" target="_blank">Contact Us</a>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->

				</div>
				<!--end::Body-->

				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(assets/media/misc/auth-bg.png)">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center py-15 px-5 px-md-15 w-100">
						<!--begin::Logo-->
						<a href="../../demo1/dist/index.html" class="mb-12">
							<img alt="Logo" src="assets/media/logos/custom-1.png" class="h-75px" />
						</a>
						<!--end::Logo-->
						<!--begin::Image-->
						<img class="mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="assets/media/misc/auth-screens.png" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and Productive</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="text-white fs-base text-center">In this kind of post,
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a person they’ve interviewed
						<br />and provides some background information about
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their
						<br />work following this is a transcript of the interview.</div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Aside-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->

		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used by this page)-->

		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
</x-guest-layout>
