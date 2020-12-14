<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="main.html"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                Mantenimiento
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Empleados</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-people-carry"></i> Empleados</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-file-signature"></i> Contratos</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-bag"></i> Incidencias</a>
                    </li>
                    <li @click="menu='inasistencia'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Solicitudes</a>
                    </li>
                    <li @click="menu='competencia'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Competencias</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="cis-calendar"></i> Estructura</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu='area'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Areas</a>
                    </li>
                    <li @click="menu='departamento'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Departamentos</a>
                    </li>
                    <li @click="menu='puesto'" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Puestos</a>
                    </li>
                    <li @click="menu='evento'" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-bag"></i> Evento</a>
                    </li>
                    <li @click="menu='empresa'" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-bag"></i> Empresas</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="cis-calendar"></i> Parametros</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu='dianolaboral'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Dias No Laborables</a>
                    </li>
                    <li @click="menu='tipoContrato'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Tipo de Contratos</a>
                    </li>

                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu='usuarios'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-user"></i> Usuarios</a>
                    </li>
                    
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu='reporteEmpleado'" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-chart"></i> Empleado Reporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte B</a>
                    </li>
                </ul>
            </li>
            <li @click="menu='alarma2'" class="nav-item">
                <a class="nav-link" href="main.html"><i class="icon-book-open"></i> Alarma <span
                        class="badge badge-danger">!</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="main.html"><i class="icon-book-open"></i> Ayuda <span
                        class="badge badge-danger">PDF</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="main.html"><i class="icon-info"></i> Acerca de...<span
                        class="badge badge-info">IT</span></a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>