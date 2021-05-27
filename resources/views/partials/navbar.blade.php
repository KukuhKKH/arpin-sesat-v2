<aside class="navigation">
    <nav>
        <ul class="nav luna-nav">
            <li class="nav-category">
                Main
            </li>
            <li class="{{ request()->segment(1) == '' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>

            <li class="{{ request()->segment(2) == 'master' ? 'active' : '' }}">
                <a href="#master" data-toggle="collapse" aria-expanded="{{ request()->segment(2) == 'master' ? 'true' : 'false' }}">
                    Master Data<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="master" class="nav nav-second collapse {{ request()->segment(2) == 'master' ? 'show' : '' }}">
                    <li class="{{ request()->segment(3) == 'coa' ? 'active' : '' }}"><a href="{{ route('master.coa.index') }}"> COA</a></li>
                    <li><a href="{{ route('master.material.index') }}"> Bahan Baku</a></li>
                    <li><a href=""> Bahan Penolong</a></li>
                    <li><a href=""> Overhead</a></li>
                    <li><a href=""> Tim</a></li>
                    <li><a href=""> Pegawai</a></li>
                </ul>
            </li>
            <li>
                <a href="#transaction" data-toggle="collapse" aria-expanded="false">
                    Transaksi<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="transaction" class="nav nav-second collapse">

                </ul>
            </li>
        </ul>
    </nav>
</aside>
