<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Handball')</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     <script>
      function toggleSidebar() {
    document.querySelector('.side').classList.toggle('show');
    document.querySelector('.overlay').classList.toggle('show');
  }
     </script>
</head>
<body>
    <div class="app">
      <div class="overlay" onclick="toggleSidebar()"></div>

        @include('cms.layouts.sidebar', ['page' => $page])
    
        <main class="main">
            
    <div class="topbar">
      <button class="hamburger" onclick="toggleSidebar()">☰</button>

      <div class="topTitle">
        <b>Home Editor</b>
        <span>Website ABTI Jabar</span>
      </div>

      <!-- <div class="status">
                <button type="button" class="btn primary" onclick="document.getElementById('saveBtn').click()">Save Changes</button>
      </div> -->
    </div>
    <div class="content">
        <div class="section">
            <div class="sectionHead">
            <div>
                <h2>Content Form</h2>
                <p>Jika field dikosongkan, maka akan menampilkan konten default bawaan</p>
            </div>
            <div class="pill">Page: home</div>
            </div>
            <div class="sectionBody">

                @yield('content')

            </div>
        </div>
        <div class="note">
        Setelah Save, buka halaman utama. <b>/</b>. Jika belum berubah, → <i>lakukan refresh paksa halaman</i> (Ctrl + F5).
      </div>
    </div>
  </main>

    </div>

</body>
</html>