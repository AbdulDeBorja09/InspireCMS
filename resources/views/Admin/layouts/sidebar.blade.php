<div class="sidebar">
    <!-- ISA LOGO -->
    <div class="logo">
        <img src="{{asset('../images/logo/primary-logo.png')}}" alt="INSPIRE SPORTS ACADEMY" />
    </div>

    <!-- SIDEBAR TABS -->
    <div class="sidebar-tabs" role="tablist">
        <!-- Dashboard Tab -->
        <a class="nav-link  {{ Route::currentRouteName() == '' ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
            <i class="bi bi-bar-chart-line-fill"></i> Dashboard
        </a>

        <!-- Request Tab -->
        <a class="nav-link {{ Route::currentRouteName() == '' ? 'active' : '' }}"
            href="{{route('admin.ShowRequests')}}">
            <i class="bi bi-quote"></i> Requests
        </a>

        <!-- Request Tab -->
        <a class="nav-link {{ Route::currentRouteName() == '' ? 'active' : '' }}"
            href="{{route('admin.ShowRequests')}}">
            <i class="bi bi-quote"></i> Payments
        </a>


        <!-- Contact Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.ShowContactus' ? 'active' : '' }}"
            href="{{route('admin.ShowContactus')}}">
            <i class="bi bi-person-circle"></i> Contacts
        </a>


        <h6 class="text-center">---------Website Settings---------</h6>

        <!-- Home Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.home' ? 'active' : '' }}"
            href="{{route('admin.home')}}">
            <i class="bi bi-house-door"></i> Home
        </a>

        <!-- Header -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.header' ? 'active' : '' }}"
            href="{{route('admin.header')}}">
            <i class="bi bi-house-door"></i> Headers
        </a>

        <!-- Facilities Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.facilities' ? 'active' : '' }}"
            href="{{route('admin.facilities')}}">
            <i class="bi bi-building"></i> Facilities
        </a>

        <!-- Academies Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.academies' ? 'active' : '' }}"
            href="{{route('admin.academies')}}">
            <i class="bi bi-people"></i> Academies
        </a>

        <!-- Membership Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.Membership' ? 'active' : '' }}"
            href="{{route('admin.Membership')}}">
            <i class="bi bi-people"></i> Membership
        </a>

        <!-- Articles Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.articles' ? 'active' : '' }}"
            href="{{route('admin.articles')}}">
            <i class="bi bi-file-text"></i> Articles
        </a>


        <!-- FAQ Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.faq' ? 'active' : '' }}"
            href="{{route('admin.faq')}}">
            <i class="bi bi-question-circle"></i> FAQ
        </a>

        <!-- About Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.about' ? 'active' : '' }}"
            href="{{route('admin.about')}}">
            <i class="bi bi-info-circle"></i> About
        </a>

        <h6 class="text-center">---------Account Settings---------</h6>

        <!-- Settings Tab -->
        <a class="nav-link {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}"
            href="{{route('admin.settings')}}">
            <i class="bi bi-gear"></i> Settings
        </a>
    </div>

    <!-- LOGOUT -->

    <form class="logout" action="{{ route('logout') }}" method="POST" style="display: inline;" id="logout-form">
        @csrf
        <a type="submit" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="nav-link  "><i class="bi bi-box-arrow-right"></i> Logout</a>
    </form>

</div>
{{-- <script>
    function showTab(event, tabId) {
      event.preventDefault();
      document
        .querySelectorAll(".content")
        .forEach((content) => content.classList.remove("active"));
      document
        .querySelectorAll(".nav-link")
        .forEach((link) => link.classList.remove("active"));
      document.getElementById(tabId).classList.add("active");
      event.currentTarget.classList.add("active");
    }
</script> --}}