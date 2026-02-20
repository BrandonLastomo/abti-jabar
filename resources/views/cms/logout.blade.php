<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CMS Login</title>
  <style>
    :root{
      --bg:#ffffff;
      --bg-soft:#f7f7f9;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --shadow:0 14px 34px rgba(17,24,39,.08);
      --red:#d61f2c;
      --ring:0 0 0 4px rgba(214,31,44,.14);
      --radius:18px;
      --font: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial;
    }
    *{ box-sizing:border-box; }
    html,body{ height:100%; }
    body{
      margin:0;
      font-family:var(--font);
      color:var(--text);
      background: url("https://images.unsplash.com/photo-1495329356033-eb76e0af9fd9?q=80&w=1920&auto=format&fit=crop&ixlib=rb-4.1.0")
              center/cover no-repeat fixed;
      display:grid;
      place-items:center;
      padding:24px;
    }
    body::before{
      content:"";
      position: fixed;
      inset: 0;
      background: rgba(255,255,255,.72);
      backdrop-filter: blur(6px);
      z-index: -1;
    }

    .wrap{ width:min(420px, 100%); }
    .brand{
      display:flex;
      align-items:center;
      gap:12px;
      justify-content:center;
      margin-bottom:14px;
    }
    .dot{
      width:12px;height:12px;border-radius:999px;background:var(--red);
      box-shadow:0 0 0 6px rgba(214,31,44,.10);
    }
    .brandText{ text-align:left; }
    .brandTitle{ font-weight:900; letter-spacing:.2px; line-height:1.1; }
    .brandSub{ margin-top:2px; font-size:12px; color:var(--muted); }

    .card{
      background:#fff;
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:18px;
    }
    h2{
      margin:0 0 6px;
      font-size:18px;
      letter-spacing:.2px;
    }
    .desc{
      margin:0 0 14px;
      color:var(--muted);
      font-size:13px;
      line-height:1.45;
    }
    .alert{
      border-radius:14px;
      padding:10px 12px;
      font-size:13px;
      margin:0 0 12px;
      border:1px solid rgba(214,31,44,.30);
      background: rgba(214,31,44,.06);
      color:#b1121f;
      font-weight:800;
    }
    .field{
      display:grid;
      gap:8px;
      margin-bottom:12px;
    }
    label{
      font-size:13px;
      font-weight:900;
    }
    input{
      width:100%;
      padding:11px 12px;
      border:1px solid var(--border);
      border-radius:12px;
      font:inherit;
      background:#fff;
      transition: border-color .12s ease, box-shadow .12s ease;
    }
    input:focus{
      outline:none;
      border-color: rgba(214,31,44,.55);
      box-shadow: var(--ring);
    }
    .btn{
      width:100%;
      border:1px solid rgba(214,31,44,.55);
      background: linear-gradient(180deg, var(--red) 0%, #c51623 100%);
      color:#fff;
      padding:12px 14px;
      border-radius:14px;
      font-weight:900;
      letter-spacing:.2px;
      cursor:pointer;
      transition: transform .12s ease, box-shadow .12s ease;
      box-shadow: 0 14px 26px rgba(214,31,44,.18);
    }
    .btn:hover{
      transform: translateY(-1px);
      box-shadow: 0 16px 30px rgba(214,31,44,.22);
    }
    .btn:active{
      transform: translateY(0);
      box-shadow: none;
    }
    .foot{
      margin-top:12px;
      text-align:center;
      font-size:12px;
      color:var(--muted);
    }
    .foot b{ color: var(--text); }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="brand" aria-label="CMS Panel">
      <div class="dot" aria-hidden="true"></div>
      <div class="brandText">
        <div class="brandTitle">CMS Panel</div>
        <div class="brandSub">Login Administrator</div>
      </div>
    </div>

    <div class="card">
      <h2>Login CMS</h2>
      <p class="desc">Masukkan akun admin untuk mengakses panel editor.</p>

      
      <form method="POST" autocomplete="off">
        <div class="field">
          <label for="username">Username</label>
          <input id="username" name="username" placeholder="Username" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Password" required>
        </div>

        <button class="btn" type="submit">Masuk</button>
      </form>

      <div class="foot">© 2026 <b>DB Panel</b></div>
    </div>
  </div>
</body>
</html>
