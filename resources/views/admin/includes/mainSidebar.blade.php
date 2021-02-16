<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @php($profile_picture_path = Auth::user() -> image_name == 'default.png' ? 'storage' .DIRECTORY_SEPARATOR. 'default.png' : Auth::user() -> profile_picture_path)
                <img src="{{ asset($profile_picture_path)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>--}}
        <!-- /.search form -->
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ __('trans.main pages') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <!-- Home Page Route -->
            <li class="active">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span>@lang('trans.home')</span>
                </a>
            </li>

            <!-- Create Check Route -->
{{--            <li>--}}
{{--                <a href="{{ route('admin.check.create') }}">--}}
{{--                    <i class="fa fa-plus"></i>--}}
{{--                    <span>@lang('trans.create check')</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            <!-- Check Route -->
            <li>
                <a href="{{ route('admin.check.index') }}">
                    <i class="fa fa-wrench"></i>
                    <span>@lang('trans.all check')</span>
                </a>
            </li>

            <!-- Clients Route -->
            @if(auth()->user()->hasPermission('read-clients'))
                <li>
                    <a href="{{ route('admin.clients.index') }}">
                        <i class="fa fa-user-secret"></i>
                        <span>@lang('trans.all client')</span>
                    </a>
                </li>
            @endif

            <!-- Users Route -->
            @if(auth()->user()->hasPermission('read-users'))
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fa fa-users"></i>
                        <span>@lang('trans.all user')</span>
                    </a>
                </li>
            @endif


            <!-- Branches Route -->
            @if(auth()->user()->hasPermission('read-branches'))
                <li>
                    <a href="{{ route('admin.branches.index') }}">
                        <i class="fa fa-building-o"></i>
                        <span>@lang('trans.all branch')</span>
                    </a>
                </li>
            @endif


            <!-- Technicals Route -->
            @if(auth()->user()->hasPermission('read-technicals'))
                <li>
                    <a href="{{ route('admin.technicals.index') }}">
                        <i class="fa fa-child"></i>
                        <span>@lang('trans.all technical')</span>
                    </a>
                </li>
            @endif


            <!-- Engineers Route -->
            @if(auth()->user()->hasPermission('read-engineers'))
                <li>
                    <a href="{{ route('admin.engineers.index') }}">
                        <i class="fa fa-cogs"></i>
                        <span>@lang('trans.all engineer')</span>
                    </a>
                </li>
            @endif


{{--            <li class="header">{{ __('trans.extra pages') }}</li>--}}

        {{--            <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>--}}

            <!-- Multiple Links -->
            @if(!auth()->user()->hasRole(['accountant']))
                <li class="treeview">
                    <a href="#"><i class="fa fa-list"></i> <span>{{ __('trans.extra pages') }}</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <!-- Check Status Route -->
                        @if(auth()->user()->hasPermission('read-checkStatus'))
                            <li>
                                <a href="{{ route('admin.checkStatus.index') }}">
                                    <i class="fa fa-plus"></i>
                                    <span>@lang('trans.all checkStatus')</span>
                                </a>
                            </li>
                        @endif


                    <!-- Job Title Route -->
                        @if(auth()->user()->hasPermission('read-jobTitle'))
                            <li>
                                <a href="{{ route('admin.jobTitle.index') }}">
                                    <i class="fa fa-briefcase"></i>
                                    <span>@lang('trans.all job title')</span>
                                </a>
                            </li>
                        @endif


                    <!-- Car Type Route -->
                        @if(auth()->user()->hasPermission('read-carType'))
                            <li>
                                <a href="{{ route('admin.carType.index') }}">
                                    <i class="fa fa-car"></i>
                                    <span>@lang('trans.all car type')</span>
                                </a>
                            </li>
                        @endif


                    <!-- Car Size Route -->
                        @if(auth()->user()->hasPermission('read-carSize'))
                            <li>
                                <a href="{{ route('admin.carSize.index') }}">
                                    <i class="fa fa-car"></i>
                                    <span>@lang('trans.all car size')</span>
                                </a>
                            </li>
                        @endif


                    <!-- Car Model Route -->
                        @if(auth()->user()->hasPermission('read-carModel'))
                            <li>
                                <a href="{{ route('admin.carModel.index') }}">
                                    <i class="fa fa-car"></i>
                                    <span>@lang('trans.all car model')</span>
                                </a>
                            </li>
                        @endif


                    <!-- Car Engine Route -->
                        @if(auth()->user()->hasPermission('read-carEngine'))
                            <li>
                                <a href="{{ route('admin.carEngine.index') }}">
                                    <i class="fa fa-car"></i>
                                    <span>@lang('trans.all car engine')</span>
                                </a>
                            </li>
                        @endif

                    <!-- Car Development Code Route -->
                        @if(auth()->user()->hasPermission('read-carDevelopmentCode'))
                            <li>
                                <a href="{{ route('admin.carDevelopmentCode.index') }}">
                                    <i class="fa fa-car"></i>
                                    <span>@lang('trans.all car development code')</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
