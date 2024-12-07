 <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!-- User details -->


                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="{{route('dashboard')}}" class="waves-effect">
                                    <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-building-4-fill"></i>
                                    <span>Organigation</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url('organizations')}}">All Organigation</a></li>
                                    <li><a href="{{url('organizations/create')}}">Add Organigation</a></li>
                                </ul>
                            </li>
                            {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-image-add-line"></i>
                                    <span>Media</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url('media-libraries')}}">Library</a></li>
                                </ul>
                            </li> --}}
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-shape-2-fill"></i>
                                    <span>Projects</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url('projects')}}">All Projects</a></li>
                                    <li><a href="{{url('projects/create')}}">Add New Projects</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-file-add-fill"></i>
                                    <span>Files</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url('projectfiles')}}">All Projects Files</a></li>
                                    <li><a href="{{url('projectfiles/create')}}">Add New Projects File</a></li>
                                </ul>
                            </li>
                            {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-mail-send-line"></i>
                                    <span>Pages</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="#">All Pages</a></li>
                                    <li><a href="#">Add New</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-mail-send-line"></i>
                                    <span>Services</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url('services')}}">All Services</a></li>
                                    <li><a href="{{url('services/create')}}">Add New</a></li>
                                    <li><a href="{{url('service-categories')}}">Categories</a></li>
                                </ul>
                            </li> --}}
                            <li>
                                <a href="#" class=" waves-effect">
                                    <i class="ri-download-2-line"></i>
                                    <span>Downloads</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-mail-send-line"></i>
                                    <span>Contacts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="#">All Contacts</a></li>
                                    <li><a href="#">Add New</a></li>
                                </ul>
                            </li>

                            {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-mail-send-line"></i>
                                    <span>Appearance</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="#">Menus</a></li>
                                    <li><a href="#">Widgets</a></li>
                                </ul>
                            </li> --}}

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-account-circle-line"></i>
                                    <span>Users</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{url('users')}}">All Users</a></li>
                                    <li><a href="{{url('modules')}}">Modules</a></li>
                                    <li><a href="{{url('permissions')}}">Permissions</a></li>
                                    <li><a href="{{url('roles')}}">Roles</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
