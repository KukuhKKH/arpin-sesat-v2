<aside class="navigation">
    <nav>
        <ul class="nav luna-nav">
            <li class="nav-category">
                Main
            </li>
            <li class="{{ request()->segment(1) == '' ? 'active' : '' }}">
                <a href="{{ url('/') }}">Dashboard</a>
            </li>

            <li class="{{ request()->segment(2) == 'master' ? 'active' : '' }}">
                <a href="#master" data-toggle="collapse" aria-expanded="{{ request()->segment(2) == 'master' ? 'true' : 'false' }}">
                    Master Data<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="master" class="nav nav-second collapse {{ request()->segment(2) == 'master' ? 'show' : '' }}">
                    @role('admin')
                    <li class="{{ request()->segment(3) == 'coa' ? 'active' : '' }}"><a href="{{ route('master.coa.index') }}"> COA</a></li>
                    @endrole
                    <li class="{{ request()->segment(2) == 'master' && request()->segment(4) == 1 && request()->segment(3) == 'material' ? 'active' : '' }}"><a href="{{ route('master.material.index', 1) }}"> Bahan Baku</a></li>
                    <li class="{{ request()->segment(2) == 'master' && request()->segment(4) == 2 && request()->segment(3) == 'material' ? 'active' : '' }}"><a href="{{ route('master.material.index', 2) }}"> Bahan Penolong</a></li>
                    <li class="{{ request()->segment(2) == 'master' && request()->segment(4) == 1 && request()->segment(3) == 'overhead' ? 'active' : '' }}"><a href="{{ route('master.overhead.index', 1) }}"> Overhead Tetap</a></li>
                    <li class="{{ request()->segment(2) == 'master' && request()->segment(4) == 2 && request()->segment(3) == 'overhead' ? 'active' : '' }}"><a href="{{ route('master.overhead.index', 2) }}"> Overhead Variabel</a></li>
                    <li class="{{ request()->segment(3) == 'product' ? 'active' : '' }}"><a href="{{ route('master.product.index') }}"> Produk</a></li>
                    <li class="{{ request()->segment(3) == 'team' ? 'active' : '' }}"><a href="{{ route('master.team.index') }}"> Tim</a></li>
                    <li class="{{ request()->segment(3) == 'employee' ? 'active' : '' }}"><a href="{{ route('master.employee.index') }}"> Pegawai</a></li>
                    @role('admin')
                    <li class="{{ request()->segment(3) == 'supplier' ? 'active' : '' }}"><a href="{{ route('master.supplier.index') }}"> Pemasok</a></li>
                    <li class="{{ request()->segment(3) == 'user' ? 'active' : '' }}"><a href="{{ route('master.user.index') }}"> User</a></li>
                    @endrole
                </ul>
            </li>
            <li class="{{ request()->segment(2) == 'transaction' ? 'active' : '' }}">
                <a href="#transaction" data-toggle="collapse" aria-expanded="{{ request()->segment(2) == 'transaction' ? 'true' : 'false' }}">
                    Transaksi<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="transaction" class="nav nav-second collapse {{ request()->segment(2) == 'transaction' ? 'show' : '' }}">
                    @role('admin')
                    <li class="{{ request()->segment(3) == 'transaction' && request()->segment(4) == 1 ? 'active' : '' }}"><a href="{{ route('transaction.material.index', 1) }}"> Bahan Baku</a></li>
                    <li class="{{ request()->segment(3) == 'transaction' && request()->segment(4) == 2 ? 'active' : '' }}"><a href="{{ route('transaction.material.index', 2) }}"> Bahan Penolong</a></li>
                    @endrole
                    <li class="{{ request()->segment(3) == 'transaction' && request()->segment(4) == 1 ? 'active' : '' }}"><a href="{{ route('transaction.material-out.index', 1) }}"> Permintaan Bahan Baku</a></li>
                    <li class="{{ request()->segment(3) == 'transaction' && request()->segment(4) == 2 ? 'active' : '' }}"><a href="{{ route('transaction.material-out.index', 2) }}"> Permintaan Bahan Penolong</a></li>
                </ul>
            </li>
            @role('admin')
            <li class="{{ request()->segment(2) == 'report' ? 'active' : '' }}">
                <a href="#report" data-toggle="collapse" aria-expanded="{{ request()->segment(2) == 'report' ? 'true' : 'false' }}">
                    Laporan<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="report" class="nav nav-second collapse {{ request()->segment(2) == 'report' ? 'show' : '' }}">
                    <li class="{{ request()->segment(4) == 1 && request()->segment(3) == 'material' && request()->segment(2) == 'report' ? 'active' : '' }}"><a href="{{ route('report.material.index', 1) }}"> Bahan Baku</a></li>
                    <li class="{{ request()->segment(4) == 2 && request()->segment(3) == 'material' && request()->segment(2) == 'report' ? 'active' : '' }}"><a href="{{ route('report.material.index', 2) }}"> Bahan Penolong</a></li>
                    <li><a href=""> Produksi</a></li>
                </ul>
            </li>
            @endrole
            <li class="nav-info">
                <i class="pe pe-7s-shield text-accent"></i>

                <div class="m-t-xs">
                    <span class="c-white">ARPN</span>
                </div>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</aside>
