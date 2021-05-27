<aside class="navigation">
    <nav>
        <ul class="nav luna-nav">
            <li class="nav-category">
                Main
            </li>
            <li class="active">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>

            <li>
                <a href="#master" data-toggle="collapse" aria-expanded="false">
                    Master Data<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="master" class="nav nav-second collapse">
                    <li><a href="{{ route('master.coa.index') }}"> COA</a></li>
                    <li><a href=""> Bahan Baku</a></li>
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
