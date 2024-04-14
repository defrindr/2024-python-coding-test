<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS Custom -->
  <style>
    body {
      background-color: #f0f0f0;
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .navbar {
      background-color: #ffffff;
      /* Darker shade for the navbar */
      padding: 10px 100px;
      /* Adjust padding */
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 2rem;
      /* Larger font size */
      color: #4D5B9E;
      /* White color text */
    }

    .navbar-nav .nav-link {
      color: #4D5B9E;
      /* Lighter shade for links */
      font-size: 1.2rem;
      /* Adjust link font size */
      margin-right: 20px;
      /* Spacing between links */
    }

    .main-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
      /* Remove gap if present */
      flex-grow: 1;
      /* Allow main content to grow */
    }

    /* Remove the max-width and margin from the .container to center it properly */
    .content {
      background: #fff;
      padding: 2rem;
      border-radius: 20px;
      /* Adjust as necessary to match the design */
      box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
      margin: 20px;
      width: calc(50% - 40px);
      /* Adjust width as necessary, subtract margin */
    }

    /* Ensure the left and right content fill their columns */
    .left-content,
    .right-content {
      padding: 2rem;
      border-radius: 0px;
      /* Adjusted border radius if needed */
      box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
      /* Adjusted box shadow */
      height: 100%;
      /* Full height */
    }

    /* Remove the specific width and margin settings to allow Bootstrap grid to manage the layout */
    .left-content,
    .right-content {
      margin: 0;
      max-width: 100%;
      /* Allow Bootstrap to control the width */
    }

    /* Remove the gap caused by the row */
    .row {
      margin-left: 0;
      margin-right: 0;
    }

    /* Ensure columns have no padding */
    .row>[class*='col-'] {
      padding: 0;
    }


    .left-content {
      background: #ffffff;
      margin: 40;
      max-width: 90%;
      /* Ensure the container takes the full width of the column */
    }

    .right-section {
      flex-basis: 50%;
      /* Set width to 50% */
      text-align: center;
      max-width: 90%;
    }

    .course-box {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      /* Two equal columns */
      gap: 1rem;
      /* Space between grid items */
      text-align: center;
      margin-top: 1.5rem;
    }

    .course-box>div {
      padding: 1rem;
      background: #F8F9FA;
      /* Bootstrap's light grey */
      border: none;
      border-radius: 10px;
      /* Rounded corners for the course boxes */
      box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
      /* Subtle shadow */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .course-box img.icon {
      width: 60px;
      /* Adjusted size */
      height: auto;
      margin-bottom: .5rem;
    }

    .course-box h3 {
      font-size: 1rem;
      /* Adjusted font size */
      color: #333;
    }

    .course-box p {
      font-size: .875rem;
      color: #666;
    }

    /* Reset padding for columns */
    .row>[class*='col-'] {
      padding: 0;
    }

    /* Other styles remain the same */
    .right-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .large-image {
      border-radius: 50%;
      width: 200px;
      height: 200px;
      margin-bottom: 20px;
    }

    .caption {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .sub-caption {
      font-size: 1rem;
      color: #666;
      margin-bottom: 20px;
    }

    .get-started-btn {
      background: #4D5B9E;
      color: #FFF;
      border: none;
      padding: 16px 32px;
      text-transform: uppercase;
      border-radius: 20px;
      font-weight: 600;
      cursor: pointer;
    }

    .get-started-btn:hover {
      background: #3a4887;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">CODEASY</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          @if (Route::has('login'))

            @auth
              @if (Auth::user()->role == 'super_admin')
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/super-admin/dashboard') }}">Dashboard</a>
                </li>
              @elseif(Auth::user()->role == 'admin')
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                </li>
              @elseif(Auth::user()->role == 'guru')
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/guru/dashboard') }}">Dashboard</a>
                </li>
              @else
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/siswa/dashboard') }}">Dashboard</a>
                </li>
              @endif
            @else
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
              </li>
              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
              @endif
            @endauth
      </div>

      @endif
      </ul>
    </div>
    </div>
  </nav>
  <!-- Main container -->
  <div class="main-container">
    <div class="container">
      <div class="row">
        <!-- Left content column -->
        <div class="col-md-6 px-0">
          <div class="left-content">
            <!-- Content heading -->
            <h1>It's Great To Be A Programmer And Get Caught In The Latest Trends.</h1>
            <div><strong>COURSE</strong></div>
            <div>Mau belajar apa hari ini ?</div>
            <div>Temukan pembelajaran berdasarkan minatmu.</div>
            <div class="course-box">
              <div>
                <div class="icon-container">
                  <img src="{{ asset('halaman_depan/assets/img/portfolio/coding.png') }}"
                    alt="Basic Programming" class="icon" />
                </div>
                <h3>Basic Programming</h3>
                <p>Belajar berbagai dasar pemrograman menggunakan C, C++, C# dan masih banyak lagi.</p>
              </div>
              <div>
                <div class="icon-container">
                  <img src="{{ asset('halaman_depan/assets/img/portfolio/folder.png') }}" alt="Course lainnya"
                    class="icon" />
                </div>
                <h3>Course Lainnya</h3>
                <p>Pelajari berbagai course pemrograman lainnya seperti Game programming IoT, Python dan masih
                  banyak lagi.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Right content column -->
        <div class="col-md-6 px-0">
          <div class="right-content">
            <div class="circle-image" style="margin-bottom: 4rem;">
              <!-- Gambar atau konten dalam lingkaran di sini -->
              <img
                style="width: 250px; height: 250px; border-radius: 50%; border: 1px solid rgb(80, 80, 80); margin-top: 2rem;"
                src="{{ asset('halaman_depan/assets/img/get_started.jpg') }}" alt="Get Started" />
            </div>
            <h2>Every Bit Is Important</h2>
            <p>You Can Develop Your Learning Language At A Faster Pace, Faster.</p>
            <div class="icon-above-button">
              <!-- Add your icon here, example using an img tag -->
              <img src="{{ asset('halaman_depan/assets/img/audio-waves.png') }}" alt="Icon"
                class="icon-above" style="width: 50px; height: auto;" />
            </div>
            <a href="{{ route('login') }}" class="get-started-btn">GET STARTED</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts remain the same -->
</body>

</html>
