 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link " href="{{ route('AdminDashboard') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li>
         <!-- End Dashboard Nav -->


         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
                 <i class="ri-menu-search-line"></i><span>Category</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="category-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.AddCategory') }}">
                         <i class="bi bi-circle"></i><span>Add New</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.AllCategory') }}">
                         <i class="bi bi-circle"></i><span>Category List</span>
                     </a>
                 </li>

             </ul>
         </li>
         <!-- End Category Nav -->

         <!-- Start User Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                 <i class="ri-group-line"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.AddUser') }}">
                         <i class="bi bi-circle"></i><span>Add User</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.UserList') }}">
                         <i class="bi bi-circle"></i><span>User List</span>
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('Admin.UserSummaryReport') }}">
                         <i class="bi bi-circle"></i><span>User Summary Report</span>
                     </a>
                 </li>
             </ul>
         </li>
         <!-- End User Nav -->

         <!-- Start Property Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#property-nav" data-bs-toggle="collapse" href="#">
                 <i class="ri-building-line"></i><span>Property</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="property-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.AddProperty') }}">
                         <i class="bi bi-circle"></i><span>Add New</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.PropertyList') }}">
                         <i class="bi bi-circle"></i><span>Property List</span>
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('Admin.SetPropertyOrder') }}">
                         <i class="bi bi-circle"></i><span>Set Property Order</span>
                     </a>
                 </li>

             </ul>
         </li>
         <!-- End Property Nav -->

         <!-- Start Mail Content Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="{{ route('Admin.MailContent') }}">
                 <i class="ri-mail-line"></i><span>Mail Content</span>
             </a>
         </li>
         <!-- End Mail Content Nav -->


         <!-- Start Monthly Report Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#monthly-report-nav" data-bs-toggle="collapse"
                 href="#">
                 <i class="ri-folder-chart-line"></i><span>Monthly Report</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="monthly-report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.PropertyMonthlyReport') }}">
                         <i class="bi bi-circle"></i><span>Add Monthly Report</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.PropertyMonthlyReportList') }}">
                         <i class="bi bi-circle"></i><span>Monthly Report List</span>
                     </a>
                 </li>

             </ul>
         </li>
         <!-- End Monthly Report Nav -->

         <!-- Start User Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#personal-report-nav" data-bs-toggle="collapse"
                 href="#">
                 <i class="ri-file-history-line"></i><span>Personal Report</span><i
                     class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="personal-report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.UserPersonalReport') }}">
                         <i class="bi bi-circle"></i><span>Add Personal Report</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.ViewUserPersonalReport') }}">
                         <i class="bi bi-circle"></i><span>View Personal Report</span>
                     </a>
                 </li>

                 <li>
                     <a href="#!">
                         <i class="bi bi-circle"></i><span>View SERO Report</span>
                     </a>
                 </li>
             </ul>
         </li>
         <!-- End User Nav -->

         <!-- Start Rehab Progress Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#rehabprogress-nav" data-bs-toggle="collapse" href="#">
                 <i class="ri-progress-5-line"></i><span>Rehab Progress</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="rehabprogress-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.AddPropertyRehabProgress') }}">
                         <i class="bi bi-circle"></i><span>Add Rehab Progress</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.RehabProgressList') }}">
                         <i class="bi bi-circle"></i><span>View Rehab Progress</span>
                     </a>
                 </li>

             </ul>
         </li>
         <!-- End Monthly Report Nav -->

         <!-- Start Lead Management Nav -->
         {{-- <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#leadmanagement-nav" data-bs-toggle="collapse"
                 href="#">
                 <i class="ri-line-chart-line"></i><span>Lead Management</span><i
                     class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="leadmanagement-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.AddLead') }}">
                         <i class="bi bi-circle"></i><span>Add New Lead</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.LeadList') }}">
                         <i class="bi bi-circle"></i><span>View Lead List</span>
                     </a>
                 </li>

             </ul>
         </li> --}}
         <!-- End Lead Management Nav -->

         <!-- Start Contact Management Nav -->
         {{-- <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#contactmanagement-nav" data-bs-toggle="collapse"
                 href="#">
                 <i class="bi bi-journal-text"></i><span>Contact Management</span><i
                     class="bi bi-chevron-down ms-auto"></i>
             </a>

             <ul id="contactmanagement-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('Admin.AddLead') }}">
                         <i class="bi bi-circle"></i><span>Add New Contact</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('Admin.LeadList') }}">
                         <i class="bi bi-circle"></i><span>View Contact List</span>
                     </a>
                 </li>

             </ul>
         </li> --}}
         <!-- End Contact Management Nav -->
     </ul>

 </aside>

 <main id="main" class="main">
