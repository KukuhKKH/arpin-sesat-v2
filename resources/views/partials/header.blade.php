<nav class="navbar navbar-expand-md navbar-default fixed-top">
    <div class="navbar-header">
        <div id="mobile-menu">
            <div class="left-nav-toggle">
                <a href="#">
                    <i class="stroke-hamburgermenu"></i>
                </a>
            </div>
        </div>
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            ARPN
            <span>v.2.0</span>
        </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <div class="left-nav-toggle">
            <a href="#">
                <i class="stroke-hamburgermenu"></i>
            </a>
        </div>
        <form class="navbar-form mr-auto">
            <input type="text" class="form-control" placeholder="Search data for analysis" style="width: 175px">
        </form>
        <ul class="nav navbar-nav">
            <li class="nav-item profil-link">
                <a href="login.html">
                    <span class="profile-address">arpin@sesat.io</span>
                    <img src="{{ asset('assets/images/profile.jpg') }}" class="rounded-circle" alt="">
                </a>
            </li>
        </ul>
    </div>
</nav>
