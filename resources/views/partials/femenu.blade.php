<ul class="nav-main">
  <li class="nav-main-item">
      <a class="nav-main-link {{ request()->is("home") ? 'active' : '' }}" href="{{ route('frontend.home') }}">
          <i class="nav-main-link-icon fa fa-rocket"></i>
          <span class="nav-main-link-name">{{ __('Dashboard') }}</span>
      </a>
  </li>
  @can('user_management_access')
    <li class="nav-main-item {{ (request()->is("permissions*") || request()->is("roles*") || request()->is("users*") || request()->is("user-alerts*")) ? 'open' : '' }}">
      <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-users"></i>
          <span class="nav-main-link-name">{{ trans('cruds.userManagement.title') }}</span>
      </a>
      <ul class="nav-main-submenu">
        @can('permission_access')
        <li class="nav-main-item">
          <a class="nav-main-link {{ request()->is("permissions*") ? 'active' : '' }}" href="{{ route('frontend.permissions.index') }}">
            <span class="nav-main-link-name">{{ trans('cruds.permission.title') }}</span>
          </a>
        </li>
        @endcan
        @can('role_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("roles*") ? 'active' : '' }}" href="{{ route('frontend.roles.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.role.title') }}</span>
            </a>
          </li>
        @endcan
        @can('user_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("users*") ? 'active' : '' }}" href="{{ route('frontend.users.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.user.title') }}</span>
            </a>
          </li>
        @endcan
        @can('user_alert_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("user-alerts*") ? 'active' : '' }}" href="{{ route('frontend.user-alerts.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.userAlert.title') }}</span>
            </a>
          </li>
        @endcan
      </ul>
    </li>
  @endcan
  @can('umkm_access')
    <li class="nav-main-item {{ (request()->is("type-of-businesses*") || request()->is("enterprises*") || request()->is("enterprise-docs*")) ? 'open' : '' }}">
      <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-boxes"></i>
          <span class="nav-main-link-name">{{ trans('cruds.umkm.title') }}</span>
      </a>
      <ul class="nav-main-submenu">
        @can('type_of_business_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("type-of-businesses*") ? 'active' : '' }}" href="{{ route('frontend.type-of-businesses.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.typeOfBusiness.title') }}</span>
            </a>
          </li>
        @endcan
        @can('enterprise_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("enterprises*") ? 'active' : '' }}" href="{{ route('frontend.enterprises.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.enterprise.title') }}</span>
            </a>
          </li>
        @endcan
        @can('enterprise_doc_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("enterprise-docs*") ? 'active' : '' }}" href="{{ route('frontend.enterprise-docs.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.enterpriseDoc.title') }}</span>
            </a>
          </li>
        @endcan
      </ul>
    </li>
  @endcan
  @can('time_management_access')
    <li class="nav-main-item {{ (request()->is("financial-access-types*") || 
                                request()->is("market-access-types*") || 
                                request()->is("project-statuses*") ||
                                request()->is("time-work-types*") ||
                                request()->is("time-projects*") ||
                                request()->is("project-docs*") ||
                                request()->is("time-entries*") ||
                                request()->is("tasks*")) ? 'open' : '' }}">
      <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-clock"></i>
          <span class="nav-main-link-name">{{ trans('cruds.timeManagement.title') }}</span>
      </a>
      <ul class="nav-main-submenu">
        @can('financial_access_type_access')
        <li class="nav-main-item">
          <a class="nav-main-link {{ request()->is("financial-access-types*") ? 'active' : '' }}" href="{{ route('frontend.financial-access-types.index') }}">
            <span class="nav-main-link-name">{{ trans('cruds.financialAccessType.title') }}</span>
          </a>
        </li>
        @endcan
        @can('market_access_type_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("market-access-types*") ? 'active' : '' }}" href="{{ route('frontend.market-access-types.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.marketAccessType.title') }}</span>
            </a>
          </li>
        @endcan
        @can('project_status_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("project-statuses*") ? 'active' : '' }}" href="{{ route('frontend.project-statuses.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.projectStatus.title') }}</span>
            </a>
          </li>
        @endcan
        @can('time_work_type_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("time-work-types*") ? 'active' : '' }}" href="{{ route('frontend.time-work-types.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.timeWorkType.title') }}</span>
            </a>
          </li>
        @endcan
        @can('time_project_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("time-projects*") ? 'active' : '' }}" href="{{ route('frontend.time-projects.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.timeProject.title') }}</span>
            </a>
          </li>
        @endcan
        @can('project_doc_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("project-docs*") ? 'active' : '' }}" href="{{ route('frontend.project-docs.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.projectDoc.title') }}</span>
            </a>
          </li>
        @endcan
        @can('time_entry_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("time-entries*") ? 'active' : '' }}" href="{{ route('frontend.time-entries.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.timeEntry.title') }}</span>
            </a>
          </li>
        @endcan
        @can('task_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("taskss*") ? 'active' : '' }}" href="{{ route('frontend.tasks.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.task.title') }}</span>
            </a>
          </li>
        @endcan
      </ul>
    </li>
  @endcan
  @can('task_management_access')
    <li class="nav-main-item {{ (request()->is("task-statuses*") || request()->is("task-tags*")) ? 'open' : '' }}">
      <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-list-alt"></i>
          <span class="nav-main-link-name">{{ trans('cruds.taskManagement.title') }}</span>
      </a>
      <ul class="nav-main-submenu">
        @can('task_status_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("task-statuses*") ? 'active' : '' }}" href="{{ route('frontend.task-statuses.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.taskStatus.title') }}</span>
            </a>
          </li>
        @endcan
        @can('task_tag_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("task-tags*") ? 'active' : '' }}" href="{{ route('frontend.task-tags.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.taskTag.title') }}</span>
            </a>
          </li>
        @endcan
      </ul>
    </li>
  @endcan
  @can('content_management_access')
    <li class="nav-main-item {{ (request()->is("content-categories*") || request()->is("content-tags*")) ? 'open' : '' }}">
      <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-border-all"></i>
          <span class="nav-main-link-name">{{ trans('cruds.contentManagement.title') }}</span>
      </a>
      <ul class="nav-main-submenu">
        @can('content_category_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("content-categories*") ? 'active' : '' }}" href="{{ route('frontend.content-categories.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.contentCategory.title') }}</span>
            </a>
          </li>
        @endcan
        @can('content_tag_access')
          <li class="nav-main-item">
            <a class="nav-main-link {{ request()->is("content-tags*") ? 'active' : '' }}" href="{{ route('frontend.content-tags.index') }}">
              <span class="nav-main-link-name">{{ trans('cruds.contentTag.title') }}</span>
            </a>
          </li>
        @endcan
      </ul>
    </li>
  @endcan
</ul>