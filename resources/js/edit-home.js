(function () {
  // =========================
  // Persist scroll (nav + page)
  // =========================
  var nav = document.querySelector(".nav");
  var NAV_SCROLL_KEY = "cms_nav_scroll_top";
  var PAGE_SCROLL_KEY = "cms_page_scroll_y";

  if ("scrollRestoration" in history) {
    history.scrollRestoration = "manual";
  }

  function markReady() {
    document.documentElement.classList.remove("cms-loading");
    document.documentElement.classList.add("cms-ready");
  }

  function restoreNavScroll() {
    if (!nav) return;
    var saved = sessionStorage.getItem(NAV_SCROLL_KEY);
    if (saved !== null) nav.scrollTop = parseInt(saved, 10) || 0;
  }

  function restorePageScroll() {
    var savedY = sessionStorage.getItem(PAGE_SCROLL_KEY);
    if (savedY !== null) {
      var y = parseInt(savedY, 10) || 0;
      window.scrollTo(0, y);
    }
  }

  restoreNavScroll();
  restorePageScroll();

  requestAnimationFrame(function () {
    restoreNavScroll();
    restorePageScroll();
    markReady();
  });

  if (nav) {
    nav.addEventListener("scroll", function () {
      sessionStorage.setItem(NAV_SCROLL_KEY, String(nav.scrollTop));
    });
  }

  window.addEventListener(
    "scroll",
    function () {
      sessionStorage.setItem(PAGE_SCROLL_KEY, String(window.scrollY || 0));
    },
    { passive: true }
  );

  // =========================
  // Tabs (sidebar navigation)
  // =========================
  var btns = document.querySelectorAll("[data-tab]");
  var panels = document.querySelectorAll("[data-panel]");

  function show(key) {
    for (var i = 0; i < btns.length; i++) {
      btns[i].classList.toggle("active", btns[i].dataset.tab === key);
    }
    for (var j = 0; j < panels.length; j++) {
      panels[j].classList.toggle("hidden", panels[j].dataset.panel !== key);
    }
  }

  for (var b = 0; b < btns.length; b++) {
    btns[b].addEventListener("click", function () {
      if (nav) sessionStorage.setItem(NAV_SCROLL_KEY, String(nav.scrollTop));
      sessionStorage.setItem(PAGE_SCROLL_KEY, String(window.scrollY || 0));

      var key = this.dataset.tab;
      show(key);

      var activeTabInput = document.getElementById("active_tab");
      if (activeTabInput) activeTabInput.value = key;
    });
  }

  function getInitialTab() {
    var activeTabInput = document.getElementById("active_tab");
    var fromInput = activeTabInput ? activeTabInput.value : "";

    if (fromInput && document.querySelector('[data-tab="' + fromInput + '"]')) {
      return fromInput;
    }

    var h = (location.hash || "").replace("#", "");
    if (h && document.querySelector('[data-tab="' + h + '"]')) {
      return h;
    }

    return "hero";
  }

  var initKey = getInitialTab();
  show(initKey);

  requestAnimationFrame(function () {
    restoreNavScroll();
    restorePageScroll();
  });

  // =========================
  // Upload bar behavior
  // =========================
  var bars = document.querySelectorAll("[data-uploadbar]");

  function basename(path) {
    if (!path) return "";
    var s = path.split("/").pop();
    return s || path;
  }

  for (var i = 0; i < bars.length; i++) {
    (function (bar) {
      var inp = bar.querySelector("[data-upload-input]");
      var pick = bar.querySelector("[data-upload-pick]");
      var name = bar.querySelector("[data-upload-name]");
      var remove = bar.querySelector("[data-upload-remove]");

      if (!inp || !pick || !name || !remove) return;

      var current = inp.getAttribute("data-current") || "";
      if (current) {
        name.textContent = "Current: " + basename(current);
        remove.disabled = false;
      } else {
        name.textContent = "No file chosen";
        remove.disabled = true;
      }

      pick.addEventListener("click", function () {
        inp.click();
      });

      inp.addEventListener("change", function () {
        var file = inp.files && inp.files[0];
        if (file) {
          name.textContent = file.name;
          remove.disabled = false;

          var clearName = remove.getAttribute("data-clear-name");
          if (clearName) {
            var hidden = document.querySelector(
              'input[type="hidden"][name="' + clearName + '"]'
            );
            if (hidden) hidden.value = "0";
          }
        } else {
          if (!current) {
            name.textContent = "No file chosen";
            remove.disabled = true;
          }
        }
      });

      remove.addEventListener("click", function () {
        var clearName = remove.getAttribute("data-clear-name");
        if (clearName) {
          var hidden = document.querySelector(
            'input[type="hidden"][name="' + clearName + '"]'
          );
          if (hidden) hidden.value = "1";
        }

        inp.value = "";
        current = "";
        inp.setAttribute("data-current", "");

        name.textContent = "No file chosen";
        remove.disabled = true;
      });
    })(bars[i]);
  }

  // =========================
  // Activities Date Dropdown (Month/Date/Year -> "Jan 05, 2026")
  // FIX:
  // - per-item closure (biar event handler ga ngikut item terakhir)
  // - days mengikuti global month/year (Feb 28/29; Apr/Jun/Sep/Nov 30)
  // - hidden hanya update kalau sudah lengkap (biar gak "kehapus" pas submit)
  // =========================
  (function initActivitiesDateDropdown() {
    var MONTHS = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    function pad2(n) {
      return String(n).padStart(2, "0");
    }

    function daysInMonth(year, monthIndex0) {
      // monthIndex0: 0..11
      return new Date(year, monthIndex0 + 1, 0).getDate();
    }

    function parseDateText(s) {
      s = String(s || "").trim();
      var m = s.match(/^([A-Za-z]{3})\s+(\d{1,2}),\s*(\d{4})$/);
      if (!m) return null;

      var mon = m[1];
      var dayNum = parseInt(m[2], 10);
      var yearNum = parseInt(m[3], 10);

      if (MONTHS.indexOf(mon) === -1) return null;
      if (!isFinite(dayNum) || dayNum < 1 || dayNum > 31) return null;
      if (!isFinite(yearNum) || yearNum < 1900 || yearNum > 2100) return null;

      return { mon: mon, day: pad2(dayNum), year: String(yearNum) };
    }

    function buildDateText(mon, day, year) {
      return mon + " " + day + ", " + year;
    }

    function setOptionsDay(selectEl, maxDay, keepDay) {
      var current = keepDay || "";

      // keep placeholder
      var first = selectEl.querySelector('option[value=""]');
      selectEl.innerHTML = "";
      if (first) selectEl.appendChild(first);
      else {
        var opt0 = document.createElement("option");
        opt0.value = "";
        opt0.textContent = "Date";
        selectEl.appendChild(opt0);
      }

      for (var d = 1; d <= maxDay; d++) {
        var v = pad2(d);
        var opt = document.createElement("option");
        opt.value = v;
        opt.textContent = v;
        selectEl.appendChild(opt);
      }

      if (current) {
        var dn = parseInt(current, 10);
        selectEl.value = (dn >= 1 && dn <= maxDay) ? current : "";
      } else {
        selectEl.value = "";
      }
    }

    var yearNow = String(new Date().getFullYear());

    for (var idxItem = 1; idxItem <= 6; idxItem++) {
      (function (i) {
        var hidden = document.querySelector('[data-act-date-hidden="' + i + '"]');
        var mSel = document.querySelector('[data-act-date="' + i + '"][data-part="m"]');
        var dSel = document.querySelector('[data-act-date="' + i + '"][data-part="d"]');
        var ySel = document.querySelector('[data-act-date="' + i + '"][data-part="y"]');
        if (!hidden || !mSel || !dSel || !ySel) return;

        function ensureYearDefault() {
          var hasMonth = !!mSel.value;
          var hasDay = !!dSel.value;
          if ((hasMonth || hasDay) && !ySel.value) {
            ySel.value = yearNow;
          }
        }

        function refreshDays() {
          var mon = mSel.value;
          var year = ySel.value || yearNow;

          var maxDay = 31;
          var mi = MONTHS.indexOf(mon);
          if (mi >= 0) {
            var yNum = parseInt(year, 10);
            if (isFinite(yNum)) {
              maxDay = daysInMonth(yNum, mi);
            }
          }

          setOptionsDay(dSel, maxDay, dSel.value);
        }

        function syncHiddenIfComplete() {
          var mon = mSel.value;
          var day = dSel.value;
          var year = ySel.value;

          // penting: jangan overwrite value lama kalau belum lengkap
          if (mon && day && year) {
            hidden.value = buildDateText(mon, day, year);
          }
        }

        // Prefill dari hidden existing (kalau format match)
        var parsed = parseDateText(hidden.value);
        if (parsed) {
          mSel.value = parsed.mon;
          ySel.value = parsed.year;
          refreshDays();
          dSel.value = parsed.day;

          // normalize (pastikan pad2 konsisten)
          hidden.value = buildDateText(parsed.mon, parsed.day, parsed.year);
        } else {
          // jangan sentuh hidden; tapi days harus siap
          refreshDays();
        }

        // Handlers
        mSel.addEventListener("change", function () {
          ensureYearDefault();
          refreshDays();
          syncHiddenIfComplete();
        });

        ySel.addEventListener("change", function () {
          refreshDays();
          syncHiddenIfComplete();
        });

        dSel.addEventListener("change", function () {
          ensureYearDefault();
          syncHiddenIfComplete();
        });

        // init: jangan paksa sync kalau belum lengkap
        ensureYearDefault();
        refreshDays();
        syncHiddenIfComplete();
      })(idxItem);
    }
  })();

  // =========================
  // Toast auto-hide
  // =========================
  var t = document.getElementById("toastSaved");
  if (t) setTimeout(function () { t.classList.remove("show"); }, 1400);
})();

(function () {
  const form = document.getElementById("homeForm");
  if (!form) return;

  const activeTabInput = document.getElementById("active_tab");
  const navBtns = Array.from(document.querySelectorAll(".navBtn[data-tab]"));

  function getActiveTab() {
    const btn = navBtns.find(b => b.classList.contains("active"));
    return btn ? btn.getAttribute("data-tab") : "hero";
  }

  function setActiveTab(tab) {
    if (activeTabInput) activeTabInput.value = tab;
  }

  function disableInactivePanels(activeTab) {
    const panels = Array.from(document.querySelectorAll("[data-panel]"));

    panels.forEach(panel => {
      const tab = panel.getAttribute("data-panel");
      const isActive = tab === activeTab;

      const fields = panel.querySelectorAll("input, textarea, select, button");
      fields.forEach(el => {
        el.disabled = !isActive;
      });
    });
  }

  navBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      setActiveTab(btn.getAttribute("data-tab"));
    });
  });

  form.addEventListener("submit", () => {
    const nav = document.querySelector(".nav");
    if (nav) sessionStorage.setItem("cms_nav_scroll_top", String(nav.scrollTop));
    sessionStorage.setItem("cms_page_scroll_y", String(window.scrollY || 0));

    const tab = getActiveTab();
    setActiveTab(tab);
    disableInactivePanels(tab);
  });
})();

