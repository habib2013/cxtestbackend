
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Savings</title>
  <!-- Favicon -->
  <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="../assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="/dashboard">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/savings">
                <i class="ni ni-books text-orange"></i>
                <span class="nav-link-text">Savings</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/benefits">
                <i class="ni ni-bag-17 text-primary"></i>
                <span class="nav-link-text">Benefits</span>
              </a>
            </li>



          </ul>
          <!-- Divider -->

        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->


          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="../assets/img/theme/team-4.jpg">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->merchant_name}}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">

          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Savings</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">User email</th>
                    <th scope="col" class="sort" data-sort="budget">Amount</th>
                    <th scope="col" class="sort" data-sort="status">Title</th>
                    <th scope="col" class="sort" data-sort="status">Payback date</th>

                    <th scope="col" class="sort" data-sort="completion">Interest</th>
                    <th scope="col" class="sort" data-sort="completion">How often</th>
                  </tr>
                </thead>
                <tbody class="list">
                    @if(!empty($savings) && $savings->count())
@foreach ($savings as $savers)
<tr>
    <th scope="row">
      <div class="media align-items-center">
        <div class="media-body">
          <span class="name mb-0 text-sm">{{$savers->userMail}}</span>
        </div>
      </div>
    </th>
    <td class="budget">
        {{$savers->amount}}
    </td>
    <td>
      <span class="badge badge-dot mr-4">

        <span class="status">{{$savers->title}}</span>
      </span>
    </td>
    <td>
        <span class="status">{{$savers->payback_date}}</span>
    </td>
    <td>
      <div class="d-flex align-items-center">
        <span class="completion mr-2">{{$savers->interest}}%</span>
        <div>
          <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{$savers->interest}}%;"></div>
          </div>
        </div>
      </div>
    </td>
    <td class="text-left">
        <span class="status">{{$savers->howoften}}</span>
    </td>
  </tr>
@endforeach
@endif

                </tbody>
              </table>
              {{-- {!! $savings->links() !!} --}}
            </div>
            <!-- Card footer -->

          </div>
        </div>
      </div>
    
    </div>
  </div>

  <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="../assets/js/argon.js?v=1.2.0"></script>
</body>

</html>
