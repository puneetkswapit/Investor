 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link " href="{{ route('UserDashboard') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li>
         <!-- End Dashboard Nav -->
         @hasPermission('add_user,edit_user,delete_user')
             <li class="nav-item">
                 <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                     <i class="ri-group-line"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
                 </a>

                 <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                     @hasPermission('add_user')
                         <li>
                             <a href="{{ route('User.AddUser') }}">
                                 <i class="bi bi-circle"></i><span>Add User</span>
                             </a>
                         </li>
                     @endhasPermission

                     @hasPermission('edit_user,delete_user')
                         <li>
                             <a href="{{ route('User.UserList') }}">
                                 <i class="bi bi-circle"></i><span>User List</span>
                             </a>
                         </li>
                     @endhasPermission


                 </ul>
             </li>
         @endhasPermission
         <!-- End User Nav -->

         <!-- Start Property Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#property-nav" data-bs-toggle="collapse" href="#">
                 <i class="ri-building-line"></i><span>Property</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="property-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 @hasPermission('add_property')
                     <li>
                         <a href="{{ route('User.AddProperty') }}">
                             <i class="bi bi-circle"></i><span>Add New</span>
                         </a>
                     </li>
                 @endhasPermission
                 @hasPermission('edit_property,delete_property')
                     <li>
                         <a href="{{ route('User.PropertyList') }}">
                             <i class="bi bi-circle"></i><span>Property List</span>
                         </a>
                     </li>
                 @endhasPermission
                 @hasPermission('add_monthly_report')
                     <li>
                         <a href="{{ route('User.PropertyMonthlyReport') }}">
                             <i class="bi bi-circle"></i><span>Add Monthly Report</span>
                         </a>
                     </li>
                 @endhasPermission

                 <li>
                     <a href="{{ route('User.PropertyMonthlyReportList') }}">
                         <i class="bi bi-circle"></i><span>View Monthly Report</span>
                     </a>
                 </li>
             </ul>
         </li>

         <!-- End Property Nav -->

         <!-- Start User Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#personal-report-nav" data-bs-toggle="collapse"
                 href="#">
                 <i class="ri-file-history-line"></i><span>Personal Report</span><i
                     class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="personal-report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 @hasPermission('upload_personal_reports')
                     <li>
                         <a href="{{ route('User.UserPersonalReport') }}">
                             <i class="bi bi-circle"></i><span>Add Personal Report</span>
                         </a>
                     </li>
                 @endhasPermission
                 <li>
                     <a href="{{ route('User.ViewUserPersonalReport') }}">
                         <i class="bi bi-circle"></i><span>View Report</span>
                     </a>
                 </li>
             </ul>
         </li>

         <!-- End User Nav -->

     </ul>

 </aside>

 <main id="main" class="main">
