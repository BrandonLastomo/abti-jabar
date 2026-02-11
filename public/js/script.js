console.log("[script] loaded", new Date().toLocaleTimeString());
(() => {
    const qs = (sel, root = document) => root.querySelector(sel);
    const qsa = (sel, root = document) => [...root.querySelectorAll(sel)];
    const body = document.body;
    const ddItems = qsa("[data-dd]");
    const closeAllDesktopDD = (except = null) => {
        ddItems.forEach((dd) => {
            if (dd === except) return;
            dd.classList.remove("open");
            const btn = qs(".ddBtn", dd);
            if (btn) btn.setAttribute("aria-expanded", "false");
        });
    };
    ddItems.forEach((dd) => {
        const btn = qs(".ddBtn", dd);
        const panel = qs(".ddPanel", dd);
        if (!btn || !panel) return;
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const willOpen = !dd.classList.contains("open");
            closeAllDesktopDD(dd);
            dd.classList.toggle("open", willOpen);
            btn.setAttribute("aria-expanded", String(willOpen));
        });
        dd.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                dd.classList.remove("open");
                btn.setAttribute("aria-expanded", "false");
                btn.focus();
            }
        });
    });
    document.addEventListener("click", (e) => {
        const inAny = ddItems.some((dd) => dd.contains(e.target));
        if (!inAny) closeAllDesktopDD(null);
    });
    const burger = qs("[data-burger]");
    const overlay = qs("[data-moverlay]");
    const closeEls = qsa("[data-close]");
    const openMobile = () => {
        if (!overlay || !burger) return;
        overlay.classList.add("show");
        overlay.setAttribute("aria-hidden", "false");
        burger.classList.add("isOpen");
        burger.setAttribute("aria-expanded", "true");
        body.classList.add("lock");
    };
    const closeMobile = () => {
        if (!overlay || !burger) return;
        overlay.classList.remove("show");
        overlay.setAttribute("aria-hidden", "true");
        burger.classList.remove("isOpen");
        burger.setAttribute("aria-expanded", "false");
        body.classList.remove("lock");
        qsa("[data-mdd].open").forEach((g) => {
            g.classList.remove("open");
            const b = qs(".mDD", g);
            if (b) b.setAttribute("aria-expanded", "false");
        });
    };
    if (burger) {
        burger.addEventListener("click", () => {
            const isOpen = overlay?.classList.contains("show");
            if (isOpen) closeMobile();
            else openMobile();
        });
    }
    closeEls.forEach((el) => el.addEventListener("click", closeMobile));
    document.addEventListener("keydown", (e) => {
        if (e.key !== "Escape") return;
        if (overlay?.classList.contains("show")) closeMobile();
        closeAllDesktopDD(null);
    });
    const mGroups = qsa("[data-mdd]");
    const closeOtherMobileGroups = (except) => {
        mGroups.forEach((g) => {
            if (g === except) return;
            g.classList.remove("open");
            const b = qs(".mDD", g);
            if (b) b.setAttribute("aria-expanded", "false");
        });
    };
    mGroups.forEach((g) => {
        const b = qs(".mDD", g);
        const panel = qs(".mPanel", g);
        if (!b || !panel) return;
        b.addEventListener("click", () => {
            const willOpen = !g.classList.contains("open");
            closeOtherMobileGroups(g);
            g.classList.toggle("open", willOpen);
            b.setAttribute("aria-expanded", String(willOpen));
        });
    });
    const isSamePage = (href) => {
        const u = new URL(href, location.origin);
        return u.pathname === location.pathname;
    };
    const navH = () => {
        const wrap = qs("[data-navbar]");
        const h = wrap?.getBoundingClientRect().height;
        return Math.max(56, Math.round(h || 72));
    };
    const scrollToId = (hash) => {
        const id = (hash || "").replace("#", "");
        if (!id) return;
        const target = document.getElementById(id);
        if (!target) return;
        const y =
            window.scrollY + target.getBoundingClientRect().top - (navH() + 10);
        window.scrollTo({
            top: y,
            behavior: "smooth",
        });
    };
    qsa("[data-scroll]").forEach((el) => {
        el.addEventListener("click", (e) => {
            const href = el.getAttribute("href");
            if (!href) return;
            const u = new URL(href, location.origin);
            if (u.pathname !== location.pathname) {
                closeAllDesktopDD(null);
                if (overlay?.classList.contains("show")) closeMobile();
                return;
            }
            if (!u.hash) return;
            e.preventDefault();
            closeAllDesktopDD(null);
            scrollToId(u.hash);
            if (
                el.hasAttribute("data-close") ||
                overlay?.classList.contains("show")
            )
                closeMobile();
            history.pushState(null, "", u.hash);
        });
    });
    const clearActiveDesktop = () => {
        qsa(".menu a").forEach((a) => a.classList.remove("is-active"));
        qsa(".menu .ddBtn").forEach((b) => b.classList.remove("is-active"));
    };
    const setActiveByUrl = () => {
        clearActiveDesktop();
        const path = location.pathname;
        const hash = location.hash || "";
        qsa(".menu a.link").forEach((a) => {
            const u = new URL(a.href);
            if (u.pathname !== path) return;
            if (!u.hash || u.hash === hash) a.classList.add("is-active");
        });
        qsa(".menu .dd[data-dd]").forEach((dd) => {
            const btn = qs(".ddBtn", dd);
            if (!btn) return;
            const children = qsa(".ddPanel a", dd).map((a) => new URL(a.href));
            const hit = children.some((u) => {
                if (u.pathname !== path) return false;
                if (!u.hash) return true;
                return u.hash === hash;
            });
            if (hit) btn.classList.add("is-active");
        });
    };
    const getAllSectionIdsFromNav = () => {
        const ids = new Set();
        qsa(".menu a[href], .mBody a[href]").forEach((a) => {
            const href = a.getAttribute("href");
            if (!href) return;
            const u = new URL(href, location.origin);
            if (u.pathname !== location.pathname) return;
            if (!u.hash) return;
            ids.add(u.hash.slice(1));
        });
        return [...ids].filter(Boolean);
    };
    const sectionIds = getAllSectionIdsFromNav();
    const sections = sectionIds
        .map((id) => document.getElementById(id))
        .filter(Boolean);
    const setActiveById = (id) => {
        clearActiveDesktop();
        const direct = qs(`.menu .link[href$="#${CSS.escape(id)}"]`);
        if (direct) direct.classList.add("is-active");
        qsa(".menu .dd[data-dd]").forEach((dd) => {
            const btn = qs(".ddBtn", dd);
            const child = qs(`.ddPanel a[href$="#${CSS.escape(id)}"]`, dd);
            if (btn && child) btn.classList.add("is-active");
        });
    };
    setActiveByUrl();
    window.addEventListener("popstate", () => {
        setActiveByUrl();
    });
    if ("IntersectionObserver" in window && sections.length) {
        const io = new IntersectionObserver(
            (entries) => {
                const visible = entries
                    .filter((en) => en.isIntersecting)
                    .sort(
                        (a, b) => b.intersectionRatio - a.intersectionRatio,
                    )[0];
                if (!visible) return;
                setActiveById(visible.target.id);
            },
            {
                root: null,
                threshold: [0.12, 0.22, 0.35, 0.5, 0.65],
                rootMargin: `-${navH()}px 0px -55% 0px`,
            },
        );
        sections.forEach((sec) => io.observe(sec));
    } else if (sections.length) {
        const onScroll = () => {
            const y = window.scrollY + navH() + 40;
            let current = null;
            for (const sec of sections) {
                if (sec.offsetTop <= y) current = sec.id;
            }
            if (current) setActiveById(current);
        };
        window.addEventListener("scroll", onScroll, {
            passive: true,
        });
        onScroll();
    }
    window.addEventListener("load", () => {
        setActiveByUrl();
        const h = location.hash;
        if (h && qs(h)) {
            setTimeout(() => scrollToId(h), 0);
        }
    });
})();

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('marqueeContainer');
    const track = document.getElementById('marqueeTrack');

    if (!container || !track) return; // Guard clause in case elements aren't loaded

    let currentOffset = 0;
    let isDragging = false;
    let startX = 0;
    let lastX = 0;
    let animationFrameId;
    
    // Config
    const autoSpeed = 0.5; // Positive for moving Right

    function checkBoundaryAndLoop() {
        const containerRect = container.getBoundingClientRect();
        
        // 1. Check Left Gap (for moving RIGHT)
        // If the track moves right, items fall off the right side and a gap appears on the left.
        // We detect if the first item's left edge is > container's left edge.
        const firstItem = track.firstElementChild;
        if (firstItem) {
            const firstRect = firstItem.getBoundingClientRect();
            // If the start of the content is visible (or pushed right), we need to fill the left side
            if (firstRect.left > containerRect.left) {
                const lastItem = track.lastElementChild;
                const lastRect = lastItem.getBoundingClientRect();
                const style = window.getComputedStyle(lastItem);
                const margin = parseFloat(style.marginRight) || 0;
                const width = lastRect.width + margin; // 15px is the gap defined in CSS

                // Move last item to front
                track.prepend(lastItem);
                
                // Adjust offset to prevent visual jump
                currentOffset -= width; 
                track.style.transform = `translateX(${currentOffset}px)`;
            }
        }

        // 2. Check Right Gap (for dragging LEFT)
        // If user drags left manually, we might run out of items on the right.
        const lastItem = track.lastElementChild;
        if (lastItem) {
            const lastRect = lastItem.getBoundingClientRect();
            if (lastRect.right < containerRect.right) {
                const firstItem = track.firstElementChild;
                const firstRect = firstItem.getBoundingClientRect();
                const style = window.getComputedStyle(firstItem);
                const margin = parseFloat(style.marginRight) || 0;
                const width = firstRect.width + margin;

                // Move first item to end
                track.appendChild(firstItem);
                
                // Adjust offset
                currentOffset += width;
                track.style.transform = `translateX(${currentOffset}px)`;
            }
        }
    }

    function animate() {
        if (!isDragging) {
            currentOffset += autoSpeed; // Move Right
            track.style.transform = `translateX(${currentOffset}px)`;
            checkBoundaryAndLoop();
        }
        animationFrameId = requestAnimationFrame(animate);
    }

    // --- Drag Logic ---
    
    function onPointerDown(e) {
        isDragging = true;
        startX = e.pageX || e.touches[0].pageX;
        lastX = startX;
        cancelAnimationFrame(animationFrameId);
    }

    function onPointerMove(e) {
        if (!isDragging) return;
        e.preventDefault(); // Stop text selection

        const clientX = e.pageX || e.touches[0].pageX;
        const deltaX = clientX - lastX;
        lastX = clientX;

        currentOffset += deltaX;
        track.style.transform = `translateX(${currentOffset}px)`;
        
        // Check boundaries continuously while dragging
        checkBoundaryAndLoop();
    }

    function onPointerUp() {
        if (!isDragging) return;
        isDragging = false;
        animate(); // Resume loop
    }

    // Events
    container.addEventListener('mousedown', onPointerDown);
    container.addEventListener('touchstart', onPointerDown);

    window.addEventListener('mousemove', onPointerMove);
    window.addEventListener('touchmove', onPointerMove);

    window.addEventListener('mouseup', onPointerUp);
    window.addEventListener('touchend', onPointerUp);
    
    // Start
    animate();
});

// =========================// YT STRIP: Google Sheets (GVIZ)// =========================
(function () {
    const track = document.querySelector("[data-yt-track]");
    if (!track) return;
    const SHEET_ID = "1PNHq5tj_xQFeia2UQMZ1OpUa7NFEKBUtjoG9Hf-d4IA";
    const GID = 0;
    const MAX_VIDEOS = 8;
    const FALLBACK = Array.from(
        {
            length: 8,
        },
        () => "https://www.youtube.com/watch?v=0cnF0wRv8Uc",
    );
    const TQ = "select B, C";
    const GVIZ_URL = `https://docs.google.com/spreadsheets/d/${SHEET_ID}/gviz/tq?gid=${GID}&tqx=out:json&tq=${encodeURIComponent(TQ)}`;

    function getYouTubeId(url) {
        try {
            const u = new URL(url);
            if (u.searchParams.get("v")) return u.searchParams.get("v");
            if (u.hostname.includes("youtu.be"))
                return u.pathname.replace("/", "");
            const m = u.pathname.match(/\/(shorts|embed)\/([^/]+)/);
            if (m) return m[2];
        } catch (e) {}
        return null;
    }

    function cardHTML(url, title, idx) {
        const id = getYouTubeId(url);
        if (!id) return "";
        const thumb = `https://i.ytimg.com/vi/${id}/hqdefault.jpg`;
        const safeTitle =
            title && String(title).trim()
                ? String(title).trim()
                : `Video ${idx + 1}`;
        return `
      <a class="ytCard" href="${url}" target="_blank" rel="noopener">
        <div class="ytThumb">
          <img src="${thumb}" alt="YouTube video thumbnail ${idx + 1}" loading="lazy">
        </div>
        <div class="ytCap">${safeTitle}</div>
      </a>
    `;
    }

    function extractYouTubeUrl(input) {
        const s = String(input || "").trim();
        let m = s.match(
            /https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([\w-]{6,})/i,
        );
        if (m) return `https://www.youtube.com/watch?v=${m[1]}`;
        m = s.match(/https?:\/\/(?:www\.)?youtu\.be\/([\w-]{6,})/i);
        if (m) return `https://www.youtube.com/watch?v=${m[1]}`;
        m = s.match(
            /https?:\/\/(?:www\.)?youtube\.com\/(?:shorts|embed)\/([\w-]{6,})/i,
        );
        if (m) return `https://www.youtube.com/watch?v=${m[1]}`;
        m = s.match(/(?:^|\s)(?:www\.)?youtube\.com\/watch\?v=([\w-]{6,})/i);
        if (m) return `https://www.youtube.com/watch?v=${m[1]}`;
        m = s.match(/(?:^|\s)(?:www\.)?youtu\.be\/([\w-]{6,})/i);
        if (m) return `https://www.youtube.com/watch?v=${m[1]}`;
        return null;
    }

    function parseGViz(text) {
        const start = text.indexOf("setResponse(");
        if (start === -1) throw new Error("Bad GVIZ response");
        const jsonStart = text.indexOf("{", start);
        const jsonEnd = text.lastIndexOf("}");
        if (jsonStart === -1 || jsonEnd === -1)
            throw new Error("No JSON found");
        const jsonStr = text.slice(jsonStart, jsonEnd + 1);
        return JSON.parse(jsonStr);
    }

    function render(items) {
        const picked = (items || []).slice(0, MAX_VIDEOS);
        const htmlOne = picked
            .map((it, i) => cardHTML(it.url, it.cap, i))
            .join("");
        const fallbackOne = FALLBACK.map((u, i) =>
            cardHTML(u, `Extended Highlights • Video ${i + 1}`, i),
        ).join("");
        const oneSet = htmlOne.trim() ? htmlOne : fallbackOne;
        track.innerHTML = oneSet + oneSet;
        requestAnimationFrame(() => {
            initYTLoop();
        });
    }
    async function load() {
        try {
            const res = await fetch(`${GVIZ_URL}&_cb=${Date.now()}`, {
                cache: "no-store",
            });
            if (!res.ok) throw new Error("Fetch failed");
            const text = await res.text();
            const data = parseGViz(text);
            const rows = data.table && data.table.rows ? data.table.rows : [];
            const items = rows
                .map((r) => {
                    const b = r.c && r.c[0] ? r.c[0] : null;
                    const c = r.c && r.c[1] ? r.c[1] : null;
                    const rawUrl = b ? (b.v ?? b.f ?? "") : "";
                    const rawCap = c ? (c.v ?? c.f ?? "") : "";
                    return {
                        url: extractYouTubeUrl(rawUrl),
                        cap: String(rawCap || "").trim(),
                    };
                })
                .filter((x) => x.url);
            render(items);
        } catch (e) {
            render(
                FALLBACK.map((u) => ({
                    url: u,
                    cap: "",
                })),
            );
        }
    }
    load();

    function initYTLoop() {
        const marquee = document.querySelector(".ytMarquee");
        const track = document.querySelector("[data-yt-track]");
        if (!marquee || !track) return;
        if (marquee.dataset.ytLoopInited === "1") return;
        marquee.dataset.ytLoopInited = "1";
        const SPEED = 18;
        const RESUME_AFTER = 800;
        let lastTs = 0;
        let interactingUntil = 0;
        let isDown = false;
        let startX = 0;
        let startScrollLeft = 0;
        let dragged = false;
        const now = () => performance.now();
        const setInteracting = () => {
            interactingUntil = now() + RESUME_AFTER;
        };
        marquee.addEventListener(
            "pointerdown",
            (e) => {
                isDown = true;
                dragged = false;
                startX = e.clientX;
                startScrollLeft = marquee.scrollLeft;
                setInteracting();
                e.preventDefault();
                marquee.setPointerCapture?.(e.pointerId);
            },
            {
                passive: false,
            },
        );
        marquee.addEventListener("pointermove", (e) => {
            if (!isDown) return;
            const dx = e.clientX - startX;
            if (Math.abs(dx) > 6) dragged = true;
            marquee.scrollLeft = startScrollLeft - dx;
            setInteracting();
        });
        marquee.addEventListener("pointerup", () => {
            isDown = false;
            setInteracting();
        });
        marquee.addEventListener("pointercancel", () => {
            isDown = false;
            setInteracting();
        });
        track.addEventListener(
            "click",
            (e) => {
                if (dragged) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragged = false;
                }
            },
            true,
        );
        marquee.addEventListener("touchstart", setInteracting, {
            passive: true,
        });
        marquee.addEventListener("touchmove", setInteracting, {
            passive: true,
        });

        function loop(ts) {
            if (!lastTs) lastTs = ts;
            const dt = (ts - lastTs) / 1000;
            lastTs = ts;
            const half = track.scrollWidth / 2;
            if (now() > interactingUntil && !isDown) {
                marquee.scrollLeft += SPEED * dt;
            }
            if (marquee.scrollLeft >= half) marquee.scrollLeft -= half;
            if (marquee.scrollLeft < 0) marquee.scrollLeft += half;
            requestAnimationFrame(loop);
        }
        requestAnimationFrame(loop);
    }
})();
// =========================// BIG NEWS // =========================
(function () {
    const bigNews = [
        {
            kicker: "Berita Umum",
            title: "Pengumuman Program Pembinaan dan Kalender Kegiatan Tahun 2026",
            desc: "Dokumen agenda memuat rencana pembinaan, jadwal kegiatan, serta tahapan pelaksanaan program yang ditetapkan Asosiasi Provinsi",
            cta: "Selengkapnya",
            href: "https://google.com",
            img: "img/bnews1.avif",
        },
        {
            kicker: "Berita Umum",
            title: "Penetapan Prioritas Pembinaan Atlet dan Penguatan Kompetisi Daerah",
            desc: "Kebijakan pembinaan diarahkan untuk peningkatan kualitas atlet, penguatan kompetisi berjenjang, serta konsistensi sistem pembinaan.",
            cta: "Selengkapnya",
            href: "https://example.com/berita/2",
            img: "img/bnews2.avif",
        },
        {
            kicker: "Berita Umum",
            title: "Rangkuman Evaluasi Kompetisi: Catatan Teknis dan Hasil Pertandingan",
            desc: "Ringkasan mencakup capaian pertandingan, catatan teknis, serta poin-poin evaluasi sebagai bahan perbaikan program.",
            cta: "Selengkapnya",
            href: "https://example.com/berita/3",
            img: "img/bnews3.avif",
        },
    ];
    const activities = [
        {
            date: "Jan 05, 2026",
            title: "Konsolidasi program kerja dan penyelarasan agenda pembinaan daerah",
            href: "#",
            img: "img/act1.avif",
        },
        {
            date: "Jan 03, 2026",
            title: "Koordinasi lintas instansi untuk penguatan ekosistem olahraga provinsi",
            href: "#",
            img: "img/act2.avif",
        },
        {
            date: "Dec 29, 2025",
            title: "Seleksi dan pendataan peserta untuk pembentukan skuad perwakilan daerah",
            href: "#",
            img: "img/act3.avif",
        },
        {
            date: "Dec 27, 2025",
            title: "Laga ekshibisi antar daerah sebagai bagian dari pembinaan berkelanjutan",
            href: "#",
            img: "img/act4.avif",
        },
        {
            date: "Dec 24, 2025",
            title: "Apresiasi akhir tahun bagi insan olahraga yang berkontribusi dan berprestasi",
            href: "#",
            img: "img/act5.avif",
        },
        {
            date: "Dec 22, 2025",
            title: "Sosialisasi regulasi terbaru serta penertiban administrasi kompetisi daerah",
            href: "#",
            img: "img/act6.avif",
        },
    ];
    const bigViewport = document.getElementById("bigNewsViewport");
    const bigTrack = document.getElementById("bigNewsTrack");
    const bigDots = document.getElementById("bigNewsDots");
    const actViewport = document.getElementById("actViewport");
    const actTrack = document.getElementById("actTrack");
    const actPrev = document.getElementById("actPrev");
    const actNext = document.getElementById("actNext");
    const now = () => performance.now();
    const clamp = (v, a, b) => Math.max(a, Math.min(b, v));
    const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);
    if (bigViewport && bigTrack && bigDots) {
        const bigSlideHTML = (x) => `
      <div class="bigNewsSlide" draggable="false">
        <img src="${x.img}" alt="" draggable="false">
        <div class="bigNewsOverlay"></div>
        <div class="bigNewsContent">
          <p class="bigNewsKicker">${x.kicker}</p>
          <h3 class="bigNewsH">${x.title}</h3>
          <p class="bigNewsP">${x.desc}</p>
          <a class="bigNewsCTALink" href="${x.href}">${x.cta}</a>
        </div>
      </div>
    `;
        bigTrack.innerHTML = bigNews.map(bigSlideHTML).join("");
        bigTrack.addEventListener("dragstart", (e) => e.preventDefault());
        bigDots.innerHTML = bigNews
            .map(() => `<span class="bigDot"><i></i></span>`)
            .join("");
        const dotFill = Array.from(bigDots.querySelectorAll(".bigDot > i"));
        const styleCtaLink = () => {
            const links = bigTrack.querySelectorAll(".bigNewsCTALink");
            links.forEach((a) => {
                a.style.display = "inline-block";
                a.style.textDecoration = "none";
                a.style.color = "inherit";
            });
        };
        styleCtaLink();
        const HOLD_MS = 3000;
        const SNAP_MS = 420;
        const RESUME_AFTER = 900;
        const DRAG_THRESHOLD_PX = 12;
        let activePid = null;
        let bigIndex = 0;
        let bigX = 0;
        let bigTargetX = 0;
        let bigAnimFrom = 0;
        let bigAnimTo = 0;
        let bigAnimT0 = 0;
        let bigAnimating = false;
        let holdT = 0;
        let lastTs = 0;
        let interactingUntil = 0;
        let isDown = false;
        let startX = 0;
        let startBigX = 0;
        let dragged = false;
        const W = () => bigViewport.clientWidth;

        function setX(x) {
            bigX = x;
            bigTrack.style.transform = `translate3d(${bigX}px,0,0)`;
        }

        function goToIndex(idx, smooth = true) {
            const w = W();
            if (!w) return;
            const n = bigNews.length;
            bigIndex = ((idx % n) + n) % n;
            bigTargetX = -bigIndex * w;
            if (!smooth) {
                bigAnimating = false;
                setX(bigTargetX);
                return;
            }
            bigAnimating = true;
            bigAnimFrom = bigX;
            bigAnimTo = bigTargetX;
            bigAnimT0 = now();
        }

        function updateDots() {
            const fill = clamp(holdT / HOLD_MS, 0, 1);
            dotFill.forEach(
                (el, i) =>
                    (el.style.width = i === bigIndex ? `${fill * 100}%` : "0%"),
            );
        }
        requestAnimationFrame(() => {
            setX(0);
            goToIndex(0, false);
            updateDots();
        });
        bigViewport.addEventListener(
            "pointerdown",
            (e) => {
                const link = e.target.closest(".bigNewsCTALink");
                if (link) return;
                isDown = true;
                dragged = false;
                bigViewport.classList.add("isDown");
                activePid = e.pointerId;
                startX = e.clientX;
                startBigX = bigX;
                holdT = 0;
                interactingUntil = now() + RESUME_AFTER;
                bigAnimating = false;
                try {
                    bigViewport.setPointerCapture(activePid);
                } catch (_) {}
            },
            {
                passive: true,
            },
        );
        bigViewport.addEventListener(
            "pointermove",
            (e) => {
                if (!isDown) return;
                const dx = e.clientX - startX;
                if (!dragged) {
                    if (Math.abs(dx) <= DRAG_THRESHOLD_PX) return;
                    dragged = true;
                }
                e.preventDefault();
                setX(startBigX + dx);
                interactingUntil = now() + RESUME_AFTER;
                updateDots();
            },
            {
                passive: false,
            },
        );

        function endBigDrag() {
            if (!isDown) return;
            isDown = false;
            bigViewport.classList.remove("isDown");
            interactingUntil = now() + RESUME_AFTER;
            if (activePid !== null) {
                try {
                    bigViewport.releasePointerCapture(activePid);
                } catch (_) {}
                activePid = null;
            }
            const w = W();
            if (!w) return;
            const delta = bigX - -bigIndex * w;
            const threshold = w * 0.15;
            if (delta > threshold) goToIndex(bigIndex - 1, true);
            else if (delta < -threshold) goToIndex(bigIndex + 1, true);
            else goToIndex(bigIndex, true);
            holdT = 0;
            updateDots();
        }
        bigViewport.addEventListener("pointerup", endBigDrag);
        bigViewport.addEventListener("pointercancel", endBigDrag);
        bigViewport.addEventListener("lostpointercapture", endBigDrag);
        window.addEventListener("pointerup", endBigDrag, {
            passive: true,
        });
        window.addEventListener("pointercancel", endBigDrag, {
            passive: true,
        });
        window.addEventListener("blur", endBigDrag);
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) endBigDrag();
        });
        bigTrack.addEventListener(
            "click",
            (e) => {
                if (e.target.closest(".bigNewsCTALink")) return;
                if (dragged) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragged = false;
                }
            },
            true,
        );

        function bigLoop(ts) {
            if (!lastTs) lastTs = ts;
            const dt = ts - lastTs;
            lastTs = ts;
            if (bigAnimating) {
                const p = clamp((now() - bigAnimT0) / SNAP_MS, 0, 1);
                const ee = easeOutCubic(p);
                setX(bigAnimFrom + (bigAnimTo - bigAnimFrom) * ee);
                if (p >= 1) {
                    bigAnimating = false;
                    setX(bigAnimTo);
                }
            } else {
                if (now() > interactingUntil && !isDown) {
                    holdT += dt;
                    if (holdT >= HOLD_MS) {
                        holdT = 0;
                        goToIndex(bigIndex + 1, true);
                    }
                } else {
                    holdT = 0;
                }
            }
            updateDots();
            requestAnimationFrame(bigLoop);
        }
        requestAnimationFrame(bigLoop);
        window.addEventListener("resize", () => goToIndex(bigIndex, false));
    }
    /* ======================================================
       MINI NEWS / ACT STRIP
       ====================================================== */
    if (!actViewport || !actTrack || !actPrev || !actNext) return;
    const actCardHTML = (x) => `
    <a class="actCard" href="${x.href}" draggable="false">
      <div class="actThumb"><img src="${x.img}" alt="" draggable="false"></div>
      <div class="actBody">
        <p class="actDate">${x.date}</p>
        <p class="actH">${x.title}</p>
      </div>
    </a>
  `;
    const base = activities.slice();
    const triple = base.concat(base, base);
    actTrack.innerHTML = triple.map(actCardHTML).join("");
    actTrack.addEventListener("dragstart", (e) => e.preventDefault());
    const gapPx = () => {
        const cs = getComputedStyle(actTrack);
        const g = parseFloat(cs.gap || cs.columnGap || "0");
        return Number.isFinite(g) ? g : 0;
    };
    const cardW = () => {
        const card = actTrack.querySelector(".actCard");
        return card ? card.getBoundingClientRect().width : 220;
    };
    const step = () => cardW() + gapPx();
    const setWidth = () => actTrack.scrollWidth / 3;

    function normalizeLoop() {
        const sw = setWidth();
        if (!sw) return;
        const x = actViewport.scrollLeft;
        if (x < sw * 0.5) {
            actViewport.scrollLeft = x + sw;
            return;
        }
        if (x > sw * 1.5) {
            actViewport.scrollLeft = x - sw;
        }
    }

    function snapSoftInstant() {
        const s = step();
        const sw = setWidth();
        if (!s || !sw) return;
        normalizeLoop();
        let local = actViewport.scrollLeft - sw;
        local = ((local % sw) + sw) % sw;
        const idx = Math.round(local / s);
        const targetLocal = idx * s;
        actViewport.scrollTo({
            left: sw + targetLocal,
            behavior: "auto",
        });
    }

    function scrollByCards(n) {
        const s = step();
        const sw = setWidth();
        if (!s || !sw) return;
        normalizeLoop();
        const target = actViewport.scrollLeft + n * s;
        actViewport.scrollTo({
            left: target,
            behavior: "auto",
        });
    }

    function syncButtons() {
        actPrev.disabled = false;
        actNext.disabled = false;
    }
    actPrev.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        scrollByCards(-1);
        snapSoftInstant();
    });
    actNext.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        scrollByCards(1);
        snapSoftInstant();
    });

    requestAnimationFrame(() => {
        const sw = setWidth();
        actViewport.scrollLeft = sw;
        normalizeLoop();
        syncButtons();
        snapSoftInstant();
    });
    window.addEventListener("resize", () => {
        const sw = setWidth();
        actViewport.scrollLeft = sw;
        normalizeLoop();
        syncButtons();
        snapSoftInstant();
    });
})();
// ===================== COUNT =====================
(() => {
    const section = document.querySelector("#stats");
    if (!section) return;
    const grid = section.querySelector("#statsGrid");
    const btn = section.querySelector("#statsToggleBtn");
    if (!grid || !btn) return;
    const cards = [...grid.querySelectorAll(".statCard")];
    const ICONS = {
        clubs: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M7 20v-2a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v2"></path>
      <path d="M9 10.5V7.8a3 3 0 0 1 6 0v2.7"></path>
      <path d="M6 13.5h12"></path>
    </svg>
  `,
        school_clubs: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M3 10l9-5 9 5-9 5-9-5Z"></path>
      <path d="M7 12v6"></path>
      <path d="M17 12v6"></path>
      <path d="M7 18h10"></path>
    </svg>
  `,
        university_clubs: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M3 10l9-5 9 5-9 5-9-5Z"></path>
      <path d="M5 12v7h14v-7"></path>
      <path d="M9 19v-5"></path>
      <path d="M12 19v-5"></path>
      <path d="M15 19v-5"></path>
    </svg>
  `,
        atlet: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <circle cx="12" cy="6.5" r="2.2"></circle>
      <path d="M8 21l2-6 3-2 3 2 2 6"></path>
      <path d="M10.5 13.5l1.5-3"></path>
      <path d="M13.5 13.5l-1.5-3"></path>
    </svg>
  `,
        wasit: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M8 3h8v8H8z"></path>
      <path d="M8 7h8"></path>
      <path d="M12 13v8"></path>
      <path d="M9 21h6"></path>
    </svg>
  `,
        pelatih: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <circle cx="10" cy="8" r="2.2"></circle>
      <path d="M4 20a6 6 0 0 1 12 0"></path>
      <path d="M16.5 9.5l4-1.5-1.5 4-2 1"></path>
      <path d="M14 12l3 3"></path>
    </svg>
  `,
        pelatih_gk: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <circle cx="12" cy="7" r="2.2"></circle>
      <path d="M6 21a6 6 0 0 1 12 0"></path>
      <path d="M4 12h16"></path>
      <path d="M6 12v4"></path>
      <path d="M18 12v4"></path>
    </svg>
  `,
        technical_director: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M12 3l8 4v5c0 5-3.2 8.7-8 10-4.8-1.3-8-5-8-10V7l8-4Z"></path>
      <path d="M9 12h6"></path>
      <path d="M12 9v6"></path>
    </svg>
  `,
        tim_manajemen: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M9 6V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1"></path>
      <path d="M4 8h16"></path>
      <path d="M6 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"></path>
      <path d="M10 12h4"></path>
      <path d="M10 16h4"></path>
    </svg>
  `,
        match_official: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M8 3h8v6a4 4 0 0 1-8 0V3Z"></path>
      <path d="M8 6H6a2 2 0 0 0 0 4h2"></path>
      <path d="M16 6h2a2 2 0 0 1 0 4h-2"></path>
      <path d="M12 13v3"></path>
      <path d="M9 21h6"></path>
      <path d="M10 16h4"></path>
    </svg>
  `,
        technical_delegates: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4Z"></path>
      <path d="M9 12l2 2 4-5"></path>
    </svg>
  `,
        volunteer: `
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M12 21s-7-4.6-9-9a5 5 0 0 1 9-3 5 5 0 0 1 9 3c-2 4.4-9 9-9 9Z"></path>
      <path d="M12 9v4"></path>
      <path d="M10 11h4"></path>
    </svg>
  `,
    };
    section.querySelectorAll(".statSvg").forEach((slot) => {
        const key = (slot.dataset.icon || "").trim();
        slot.innerHTML = ICONS[key] || ICONS.clubs;
    });
    const SHEET_ID = "1PNHq5tj_xQFeia2UQMZ1OpUa7NFEKBUtjoG9Hf-d4IA";
    const SHEET_NAME = "Counter";
    const LIMIT = cards.length;
    const RANGE = "C6:C";
    const TQ = `select C limit ${LIMIT}`;
    const GVIZ_URL =
        `https://docs.google.com/spreadsheets/d/${SHEET_ID}/gviz/tq` +
        `?sheet=${encodeURIComponent(SHEET_NAME)}` +
        `&range=${encodeURIComponent(RANGE)}` +
        `&tqx=out:json` +
        `&tq=${encodeURIComponent(TQ)}`;

    function parseGViz(text) {
        const start = text.indexOf("setResponse(");
        if (start === -1) throw new Error("Bad GVIZ response");
        const jsonStart = text.indexOf("{", start);
        const jsonEnd = text.lastIndexOf("}");
        if (jsonStart === -1 || jsonEnd === -1)
            throw new Error("No JSON found");
        return JSON.parse(text.slice(jsonStart, jsonEnd + 1));
    }

    function toNumber(val) {
        const s = String(val ?? "").trim();
        if (!s) return null;
        if (typeof val === "number") return val;
        const cleaned = s
            .replace(/\s+/g, "")
            .replace(/,/g, "")
            .replace(/\./g, "");
        const n = Number(cleaned);
        return Number.isFinite(n) ? n : null;
    }
    async function loadCountersFromSheet() {
        try {
            const res = await fetch(`${GVIZ_URL}&_cb=${Date.now()}`, {
                cache: "no-store",
            });
            if (!res.ok) throw new Error("Fetch failed");
            const text = await res.text();
            const data = parseGViz(text);
            const rows = data?.table?.rows || [];
            for (let i = 0; i < LIMIT; i++) {
                const cell = rows[i]?.c?.[0];
                const raw = cell ? (cell.v ?? cell.f ?? "") : "";
                const v = toNumber(raw);
                if (v === null || v === undefined) continue;
                cards[i].dataset.target = String(v);
            }
            console.log("[stats] loaded range C6:C OK", rows.slice(0, 3));
        } catch (e) {
            console.warn("[stats] sheet load failed, fallback HTML", e);
        }
    }
    const sheetReady = loadCountersFromSheet();
    const format = (n) => n.toLocaleString("en-US");
    const easeOut = (t) => 1 - Math.pow(1 - t, 3);
    const rafMap = new WeakMap();

    function stopAnim(card) {
        const id = rafMap.get(card);
        if (id) cancelAnimationFrame(id);
        rafMap.delete(card);
    }

    function setValue(card, v) {
        const el = card.querySelector(".statValue");
        if (el) el.textContent = v;
    }

    function resetCard(card) {
        stopAnim(card);
        setValue(card, "0");
    }

    function animateCard(card, dur = 2000) {
        stopAnim(card);
        const el = card.querySelector(".statValue");
        if (!el) return;
        const target = Number(card.dataset.target || 0);
        const t0 = performance.now();
        el.textContent = "0";
        const tick = (now) => {
            const p = Math.min(1, (now - t0) / dur);
            el.textContent = format(Math.round(target * easeOut(p)));
            if (p < 1) rafMap.set(card, requestAnimationFrame(tick));
            else rafMap.delete(card);
        };
        rafMap.set(card, requestAnimationFrame(tick));
    }

    function isCardVisible(card) {
        if (!card.offsetParent) return false;
        const r = card.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        return r.bottom > 0 && r.top < vh;
    }
    const visibleCards = () => cards.filter(isCardVisible);
    const notAnimatedYet = (list) => list.filter((c) => !c.dataset.animated);

    function animateVisibleOnEnter() {
        const list = notAnimatedYet(visibleCards());
        if (!list.length) return;
        list.forEach(resetCard);
        list.forEach((c, i) => {
            setTimeout(() => {
                animateCard(c, 2000);
                c.dataset.animated = "1";
            }, i * 60);
        });
    }

    function animateRestRowsOnExpand() {
        const rest = notAnimatedYet(cards);
        if (!rest.length) return;
        rest.forEach(resetCard);
        rest.forEach((c, i) => {
            setTimeout(() => {
                animateCard(c, 2000);
                c.dataset.animated = "1";
            }, i * 40);
        });
    }
    let expanded = false;
    btn.addEventListener("click", () => {
        expanded = !expanded;
        grid.classList.toggle("is-expanded", expanded);
        btn.textContent = expanded ? "Tutup" : "Lihat selengkapnya";
        if (expanded) requestAnimationFrame(animateRestRowsOnExpand);
    });
    let prevTop = null;
    let rearm = true;
    const io = new IntersectionObserver(
        ([entry]) => {
            const top = entry.boundingClientRect.top;
            const goingDown = prevTop !== null ? top < prevTop : true;
            const goingUp = prevTop !== null ? top > prevTop : false;
            prevTop = top;
            if (entry.isIntersecting) {
                if (entry.intersectionRatio >= 0.45 && goingDown && rearm) {
                    sheetReady.then(() => {
                        animateVisibleOnEnter();
                        rearm = false;
                    });
                }
                return;
            }
            if (goingUp) {
                rearm = true;
                visibleCards().forEach((c) => {
                    c.dataset.animated = "";
                    resetCard(c);
                });
            }
            if (expanded) {
                expanded = false;
                grid.classList.remove("is-expanded");
                btn.textContent = "Lihat selengkapnya";
            }
        },
        {
            threshold: [0, 0.45],
        },
    );
    io.observe(section);
    sheetReady.then(() => {
        const r = section.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        const inView = r.bottom > 0 && r.top < vh;
        if (inView) {
            animateVisibleOnEnter();
            rearm = false;
        }
    });
})();
// ===================== SPONSOR =====================
(function () {
    const marquees = document.querySelectorAll("[data-marquee]");
    marquees.forEach((wrap) => {
        const track = wrap.querySelector(".marquee-track");
        if (!track) return;
        let isDown = false;
        let startX = 0;
        let startOffset = 0;

        function getOffset() {
            const v = getComputedStyle(track)
                .getPropertyValue("--offset")
                .trim();
            const n = parseFloat(v.replace("px", "")) || 0;
            return n;
        }

        function setOffset(px) {
            track.style.setProperty("--offset", `${px}px`);
        }
        const pause = () => wrap.classList.add("is-paused");
        const resume = () => wrap.classList.remove("is-paused");
        wrap.addEventListener("pointerdown", (e) => {
            isDown = true;
            wrap.setPointerCapture(e.pointerId);
            pause();
            startX = e.clientX;
            startOffset = getOffset();
        });
        wrap.addEventListener("pointermove", (e) => {
            if (!isDown) return;
            const dx = e.clientX - startX;
            setOffset(startOffset + dx);
        });

        function end(e) {
            if (!isDown) return;
            isDown = false;
            const cards = track.children;
            if (cards.length > 0) {
                const halfWidth = track.scrollWidth / 2;
                let off = getOffset();
                if (halfWidth > 0) {
                    off = ((off % halfWidth) + halfWidth) % halfWidth;
                    if (off > halfWidth / 2) off = off - halfWidth;
                    setOffset(off);
                }
            }
            resume();
        }
        wrap.addEventListener("pointerup", end);
        wrap.addEventListener("pointercancel", end);
        wrap.addEventListener("mouseleave", end);
        wrap.addEventListener("mouseenter", pause);
        wrap.addEventListener("mouseleave", () => {
            if (!isDown) resume();
        });
    });
})();
// ===== CMS override helper (minimal) =====
async function getHomeCMS() {
    try {
        const r = await fetch("/api/get.php?page=home", {
            cache: "no-store",
        });
        if (!r.ok) return null;
        return await r.json(); // key-value: "home.xxx.yyy": "..."
    } catch {
        return null;
    }
}
const cmsVal = (cms, k) => (cms && cms[k] != null ? String(cms[k]) : "");

// ===================== ABOUT =====================
const reveals = document.querySelectorAll(".reveal");
const io = new IntersectionObserver(
    (entries) => {
        entries.forEach(
            (e) => e.isIntersecting && e.target.classList.add("is-in"),
        );
    },
    {
        threshold: 0.12,
    },
);
reveals.forEach((el) => io.observe(el));

const aboutData = {
    history: {
        tag: "A",
        kicker: "HISTORY",
        title: "Perjalanan ABTI Jawa Barat",
        bg: "assetsimg/about1.avif",
        mobileTitle: "History",
        mobileDesc: "Perjalanan & milestone",
        html: `
      <p>ABTI Jawa Barat hadir sebagai wadah pembinaan dan pengembangan bola tangan melalui kompetisi,
      pelatihan, serta kolaborasi dengan berbagai pihak.</p>
      <div class="miniTimeline">
        <div class="tItem"><span class="dot"></span><div><b>Awal</b><br/>Membangun komunitas & kompetisi.</div></div>
        <div class="tItem"><span class="dot"></span><div><b>Penguatan</b><br/>Program pembinaan & lisensi.</div></div>
        <div class="tItem"><span class="dot"></span><div><b>Ekspansi</b><br/>Kolaborasi & prestasi daerah.</div></div>
      </div>
    `,
    },
    vision: {
        tag: "B",
        kicker: "VISION & MISSION",
        title: "Arah Pembinaan & Pengembangan",
        bg: "img/about2.avif",
        mobileTitle: "Vision & Mission",
        mobileDesc: "Arah pembinaan",
        html: `
      <p><b>Vision</b><br/>Menjadi organisasi yang mendorong prestasi dan ekosistem bola tangan Jawa Barat yang berkelanjutan.</p>
      <p><b>Mission</b></p>
      <ul>
        <li>Pembinaan atlet, pelatih, dan ofisial secara konsisten</li>
        <li>Menyelenggarakan kompetisi terstruktur</li>
        <li>Kolaborasi sekolah, kampus, komunitas, dan stakeholder</li>
      </ul>
    `,
    },
    org: {
        tag: "C",
        kicker: "ORGANIZATION",
        title: "Struktur & Peran Organisasi",
        bg: "img/about3.avif",
        mobileTitle: "Organization",
        mobileDesc: "Struktur & peran",
        html: `
      <p>Organisasi ABTI Jawa Barat bekerja melalui divisi/divisi untuk memastikan pembinaan, kompetisi,
      regulasi, dan kolaborasi berjalan efektif.</p>
      <div class="pillGrid">
        <span class="pill">Pembinaan</span>
        <span class="pill">Kompetisi</span>
        <span class="pill">Wasit & Lisensi</span>
        <span class="pill">Kemitraan</span>
        <span class="pill">Media</span>
        <span class="pill">Administrasi</span>
      </div>
    `,
    },
};

async function overrideAboutFromCMS() {
    const cms = await getHomeCMS();
    if (!cms) return;

    ["history", "vision", "org"].forEach((k) => {
        const base = `home.about.${k}.`;

        const kickerCMS = cmsVal(cms, base + "kicker").trim();
        const titleCMS = cmsVal(cms, base + "title").trim();
        const bgCMS = cmsVal(cms, base + "bg").trim();
        const mTitleCMS = cmsVal(cms, base + "mobile_title").trim();
        const mDescCMS = cmsVal(cms, base + "mobile_desc").trim();
        const htmlCMS = cmsVal(cms, base + "html").trim();

        if (kickerCMS) aboutData[k].kicker = kickerCMS;
        if (titleCMS) aboutData[k].title = titleCMS;
        if (bgCMS) aboutData[k].bg = bgCMS;
        if (mTitleCMS) aboutData[k].mobileTitle = mTitleCMS;
        if (mDescCMS) aboutData[k].mobileDesc = mDescCMS;
        if (htmlCMS) aboutData[k].html = htmlCMS;
    });
}

const cards = document.querySelectorAll(".aboutXCard");
const banner = document.querySelector(".aboutXBanner");
const kicker = document.getElementById("aboutKicker");
const title = document.getElementById("aboutTitle");
const content = document.getElementById("aboutContent");

function setAbout(key) {
    const d = aboutData[key];
    if (!d || !banner || !kicker || !title || !content) return;
    cards.forEach((c) =>
        c.classList.toggle("is-active", c.dataset.about === key),
    );
    content.classList.add("is-fading");
    setTimeout(() => {
        kicker.textContent = d.kicker;
        title.textContent = d.title;
        banner.style.backgroundImage = `url("${d.bg}")`;
        content.innerHTML = d.html;
        requestAnimationFrame(() => content.classList.remove("is-fading"));
    }, 160);
}

cards.forEach((c) =>
    c.addEventListener("click", () => setAbout(c.dataset.about)),
);

const px = document.querySelector("[data-parallax]");
window.addEventListener(
    "scroll",
    () => {
        if (!px) return;
        const rect = px.getBoundingClientRect();
        const offset = Math.min(18, Math.max(-18, rect.top * 0.04));
        px.style.backgroundPosition = `center calc(50% + ${offset}px)`;
    },
    {
        passive: true,
    },
);

function buildMobileAboutAccordion() {
    const wrap = document.querySelector(".aboutAccWrap");
    if (!wrap) return;
    const keys = Object.keys(aboutData);

    wrap.innerHTML = `
    <div class="aboutAccHead reveal">
      <h2>About ABTI Jawa Barat</h2>
      <p>Perjalanan, arah, dan struktur organisasi untuk membangun ekosistem bola tangan di Jawa Barat.</p>
    </div>
    <div class="aboutAccList"></div>
  `;

    const head = wrap.querySelector(".reveal");
    if (head) io.observe(head);

    const list = wrap.querySelector(".aboutAccList");
    keys.forEach((key, i) => {
        const d = aboutData[key];
        const item = document.createElement("article");
        item.className = "accItem reveal" + (i === 0 ? " is-open" : "");
        item.innerHTML = `
      <button class="accBtn" type="button" aria-expanded="${i === 0}">
        <span class="num">${String(i + 1).padStart(2, "0")}</span>
        <span class="txt">
          <span class="t">${d.mobileTitle}</span>
          <span class="d">${d.mobileDesc}</span>
        </span>
        <span class="ic" aria-hidden="true">
          <svg class="icSvg" viewBox="0 0 24 24" focusable="false" aria-hidden="true">
            <path class="h" d="M5 12h14"></path>
            <path class="v" d="M12 5v14"></path>
          </svg>
        </span>
      </button>
      <div class="accPanel" style="max-height:${i === 0 ? "999px" : "0px"};">
        <div class="accBanner" style="background-image:url('${d.bg}')">
          <div class="overlay"></div>
        </div>
        <div class="accBody">${d.html}</div>
      </div>
    `;
        list.appendChild(item);
        io.observe(item);
    });

    const items = Array.from(list.querySelectorAll(".accItem"));
    items.forEach((item, idx) => {
        const btn = item.querySelector(".accBtn");
        const panel = item.querySelector(".accPanel");
        if (!btn || !panel) return;
        if (idx === 0) panel.style.maxHeight = panel.scrollHeight + "px";
        btn.addEventListener("click", () => {
            const isOpen = item.classList.contains("is-open");
            items.forEach((o) => {
                if (o === item) return;
                o.classList.remove("is-open");
                const b = o.querySelector(".accBtn");
                const p = o.querySelector(".accPanel");
                if (b) b.setAttribute("aria-expanded", "false");
                if (p) p.style.maxHeight = "0px";
            });
            if (!isOpen) {
                item.classList.add("is-open");
                btn.setAttribute("aria-expanded", "true");
                panel.style.maxHeight = panel.scrollHeight + "px";
            } else {
                item.classList.remove("is-open");
                btn.setAttribute("aria-expanded", "false");
                panel.style.maxHeight = "0px";
            }
        });
    });
}

// init ABOUT after CMS override (so desktop+mobile uses overridden data)
document.addEventListener("DOMContentLoaded", async () => {
    await overrideAboutFromCMS();
    setAbout("history");
    buildMobileAboutAccordion();
});

// ===================== MEMBER =====================
(() => {
    const MEMBERS = [
        {
            id: "abti-1",
            name: "ABTI Kab. Bandung Barat",
            logo: "img/member/1.avif",
            ketua: "Hendra Pratama",
            sekretaris: "Ayu Lestari",
            email: "bandungbarat@abti.or.id",
            link: "https://abti.or.id/bandungbarat",
        },
        {
            id: "abti-2",
            name: "ABTI Kab. Bogor",
            logo: "img/member/2.avif",
            ketua: "Rudi Santoso",
            sekretaris: "Nina Handayani",
            email: "bogor@abti.or.id",
            link: "https://abti.or.id/bogor",
        },
        {
            id: "abti-3",
            name: "ABTI Kota Bogor",
            logo: "img/member/3.avif",
            ketua: "Dewi Marlina",
            sekretaris: "Fajar Wicaksono",
            email: "kotabogor@abti.or.id",
            link: "https://abti.or.id/kotabogor",
        },
        {
            id: "abti-4",
            name: "ABTI Kota Bandung",
            logo: "img/member/4.avif",
            ketua: "Andi Wijaya",
            sekretaris: "Siti Rahma",
            email: "kotabandung@abti.or.id",
            link: "https://abti.or.id/kotabandung",
        },
        {
            id: "abti-5",
            name: "ABTI Kab. Bandung",
            logo: "img/member/5.avif",
            ketua: "Budi Hartono",
            sekretaris: "Maya Putri",
            email: "kabbandung@abti.or.id",
            link: "https://abti.or.id/kabbandung",
        },
        {
            id: "abti-6",
            name: "ABTI Kab. Bekasi",
            logo: "img/member/6.avif",
            ketua: "Rina Kurnia",
            sekretaris: "Dedi Saputra",
            email: "kabbekasi@abti.or.id",
            link: "https://abti.or.id/kabbekasi",
        },
        {
            id: "abti-7",
            name: "ABTI Kota Cimahi",
            logo: "img/member/7.avif",
            ketua: "Agus Prabowo",
            sekretaris: "Lia Amalia",
            email: "cimahi@abti.or.id",
            link: "https://abti.or.id/cimahi",
        },
        {
            id: "abti-8",
            name: "ABTI Kota Cirebon",
            logo: "img/member/8.avif",
            ketua: "Yusuf Maulana",
            sekretaris: "Rani Safitri",
            email: "cirebon@abti.or.id",
            link: "https://abti.or.id/cirebon",
        },
        {
            id: "abti-9",
            name: "ABTI Kota Depok",
            logo: "img/member/9.avif",
            ketua: "Sari Wulandari",
            sekretaris: "Imam Hidayat",
            email: "depok@abti.or.id",
            link: "https://abti.or.id/depok",
        },
        {
            id: "abti-10",
            name: "ABTI Kab. Indramayu",
            logo: "img/member/10.avif",
            ketua: "Fikri Ramadhan",
            sekretaris: "Nadia Permata",
            email: "indramayu@abti.or.id",
            link: "https://abti.or.id/indramayu",
        },
        {
            id: "abti-11",
            name: "ABTI Kota Bekasi",
            logo: "img/member/11.avif",
            ketua: "Rizal Hakim",
            sekretaris: "Tika Salsabila",
            email: "kotabekasi@abti.or.id",
            link: "https://abti.or.id/kotabekasi",
        },
        {
            id: "abti-12",
            name: "ABTI Kab. Garut",
            logo: "img/member/12.avif",
            ketua: "Novi Andriani",
            sekretaris: "Arif Nugroho",
            email: "garut@abti.or.id",
            link: "https://abti.or.id/garut",
        },
        {
            id: "abti-13",
            name: "ABTI Kab. Kuningan",
            logo: "img/member/13.avif",
            ketua: "Dani Setiawan",
            sekretaris: "Vina Rahmadani",
            email: "kuningan@abti.or.id",
            link: "https://abti.or.id/kuningan",
        },
        {
            id: "abti-14",
            name: "ABTI Kab. Subang",
            logo: "img/member/14.avif",
            ketua: "Farhan Akbar",
            sekretaris: "Nisa Khairunnisa",
            email: "subang@abti.or.id",
            link: "https://abti.or.id/subang",
        },
        {
            id: "abti-15",
            name: "ABTI Kab. Majalengka",
            logo: "img/member/15.avif",
            ketua: "Intan Maharani",
            sekretaris: "Bayu Firmansyah",
            email: "majalengka@abti.or.id",
            link: "https://abti.or.id/majalengka",
        },
        {
            id: "abti-16",
            name: "ABTI Kab. Karawang",
            logo: "img/member/16.avif",
            ketua: "Seno Adityawan",
            sekretaris: "Mila Anggraini",
            email: "karawang@abti.or.id",
            link: "https://abti.or.id/karawang",
        },
        {
            id: "abti-17",
            name: "ABTI Kab. Ciamis",
            logo: "img/member/17.avif",
            ketua: "Hadi Prasetyo",
            sekretaris: "Salsa Nabila",
            email: "ciamis@abti.or.id",
            link: "https://abti.or.id/ciamis",
        },
        {
            id: "abti-18",
            name: "ABTI Kota Sukabumi",
            logo: "img/member/18.avif",
            ketua: "Dimas Wicaksana",
            sekretaris: "Dini Larasati",
            email: "kotasukabumi@abti.or.id",
            link: "https://abti.or.id/kotasukabumi",
        },
        {
            id: "abti-19",
            name: "ABTI Kab. Sukabumi",
            logo: "img/member/19.avif",
            ketua: "Robby Kurniawan",
            sekretaris: "Rara Kusuma",
            email: "kabsukabumi@abti.or.id",
            link: "https://abti.or.id/kabsukabumi",
        },
        {
            id: "abti-20",
            name: "ABTI Kab. Purwakarta",
            logo: "img/member/20.avif",
            ketua: "Taufik Hidayat",
            sekretaris: "Nadya Azzahra",
            email: "purwakarta@abti.or.id",
            link: "https://abti.or.id/purwakarta",
        },
        {
            id: "abti-21",
            name: "ABTI Kab. Tasikmalaya",
            logo: "img/member/21.avif",
            ketua: "Ahmad Fauzi",
            sekretaris: "Dewi Puspita",
            email: "tasikmalaya@abti.or.id",
            link: "https://abti.or.id/tasikmalaya",
        },
        {
            id: "abti-22",
            name: "ABTI Kota Tasikmalaya",
            logo: "img/member/22.avif",
            ketua: "Sinta Mulyani",
            sekretaris: "Hendra Gunawan",
            email: "kotatasik@abti.or.id",
            link: "https://abti.or.id/kotatasik",
        },
        {
            id: "abti-23",
            name: "ABTI Kab. Cirebon",
            logo: "img/member/23.avif",
            ketua: "Yoga Pratama",
            sekretaris: "Anisa Rahman",
            email: "kabcirebon@abti.or.id",
            link: "https://abti.or.id/kabcirebon",
        },
        {
            id: "abti-24",
            name: "ABTI Kab. Cianjur",
            logo: "img/member/24.avif",
            ketua: "Miko Saputra",
            sekretaris: "Rifka Amelia",
            email: "cianjur@abti.or.id",
            link: "https://abti.or.id/cianjur",
        },
        {
            id: "abti-25",
            name: "ABTI Kab. Sumedang",
            logo: "img/member/25.avif",
            ketua: "Lutfi Aulia",
            sekretaris: "Nabila Putri",
            email: "sumedang@abti.or.id",
            link: "https://abti.or.id/sumedang",
        },
        {
            id: "abti-26",
            name: "ABTI Kota Banjar",
            logo: "img/member/26.avif",
            ketua: "Arman Yulianto",
            sekretaris: "Citra Lestari",
            email: "banjar@abti.or.id",
            link: "https://abti.or.id/banjar",
        },
        {
            id: "abti-27",
            name: "ABTI Kab. Pangandaran",
            logo: "img/member/27.avif",
            ketua: "Sandy Prakoso",
            sekretaris: "Putri Ayuningtyas",
            email: "pangandaran@abti.or.id",
            link: "https://abti.or.id/pangandaran",
        },
        {
            id: "abti-28",
            name: "ABTI Jawa Barat",
            logo: "img/member/28.avif",
            ketua: "Naufal Pratama",
            sekretaris: "Wulan Sari",
            email: "jabar@abti.or.id",
            link: "https://abti.or.id/jabar",
        },
    ];

    async function overrideMembersFromCMS() {
        const cms = await getHomeCMS();
        if (!cms) return;

        for (let i = 1; i <= 28; i++) {
            const base = `home.members.${i}.`;
            const m = MEMBERS[i - 1];
            if (!m) continue;

            const name = cmsVal(cms, base + "name").trim();
            const logo = cmsVal(cms, base + "logo").trim();
            const ketua = cmsVal(cms, base + "ketua").trim();
            const sekretaris = cmsVal(cms, base + "sekretaris").trim();
            const email = cmsVal(cms, base + "email").trim();
            const link = cmsVal(cms, base + "link").trim();

            if (name) m.name = name;
            if (logo) m.logo = logo;
            if (ketua) m.ketua = ketua;
            if (sekretaris) m.sekretaris = sekretaris;
            if (email) m.email = email;
            if (link) m.link = link;
        }
    }

    const state = {
        query: "",
        sort: "city_asc",
        page: 1,
        perPage: 6,
        selected: null,
    };

    const elRows = document.getElementById("abtiRows");
    const elCount = document.getElementById("abtiCount");
    const elMeta = document.getElementById("abtiMeta");
    const elSearch = document.getElementById("abtiSearch");
    const elSearchClear = document.getElementById("abtiSearchClear");
    const elPrev = document.getElementById("abtiPrev");
    const elNext = document.getElementById("abtiNext");
    const elPageInfo = document.getElementById("abtiPageInfo");
    const elDrawer = document.getElementById("abtiDrawer");
    const elDrawerBackdrop = document.getElementById("abtiDrawerBackdrop");
    const elDrawerClose = document.getElementById("abtiDrawerClose");
    const elDrawerTitle = document.getElementById("abtiDrawerTitle");
    const elDrawerSubtitle = document.getElementById("abtiDrawerSubtitle");
    const elDrawerBody = document.getElementById("abtiDrawerBody");
    const elDrawerPrimary = document.getElementById("abtiDrawerPrimary");
    const elDrawerSecondary = document.getElementById("abtiDrawerSecondary");
    const elSortDD = document.getElementById("abtiSortDD");
    const elSortBtn = document.getElementById("abtiSortBtn");
    const elSortMenu = document.getElementById("abtiSortMenu");
    const elSortLabel = document.getElementById("abtiSortLabel");

    const REQUIRED = [
        elRows,
        elCount,
        elMeta,
        elSearch,
        elPrev,
        elNext,
        elPageInfo,
        elDrawer,
        elDrawerBackdrop,
        elDrawerClose,
        elDrawerTitle,
        elDrawerSubtitle,
        elDrawerBody,
        elDrawerPrimary,
        elDrawerSecondary,
    ];
    if (REQUIRED.some((x) => !x)) return;

    const normalize = (s) => (s || "").toString().toLowerCase().trim();

    function applyFilter(data) {
        const q = normalize(state.query);
        if (!q) return data;
        return data.filter((m) => {
            const hay = [m.name, m.ketua, m.sekretaris, m.email, m.link]
                .map(normalize)
                .join(" ");
            return hay.includes(q);
        });
    }

    function applySort(data) {
        const copy = [...data];
        const sortAsc = (key) =>
            copy.sort((a, b) => {
                const av = normalize(a[key]);
                const bv = normalize(b[key]);
                if (av < bv) return -1;
                if (av > bv) return 1;
                return 0;
            });
        switch (state.sort) {
            case "name_asc":
                return sortAsc("ketua");
            case "city_asc":
            default:
                return sortAsc("name");
        }
    }

    function paginate(data) {
        const total = data.length;
        const totalPages = Math.max(1, Math.ceil(total / state.perPage));
        state.page = Math.min(state.page, totalPages);
        const start = (state.page - 1) * state.perPage;
        const end = start + state.perPage;
        return {
            pageData: data.slice(start, end),
            total,
            totalPages,
        };
    }

    function safeLink(url) {
        try {
            const u = new URL(url);
            return u.href;
        } catch {
            return "";
        }
    }

    async function copyToClipboard(text) {
        const t = (text || "").trim();
        if (!t) return false;
        try {
            await navigator.clipboard.writeText(t);
            return true;
        } catch {
            const ta = document.createElement("textarea");
            ta.value = t;
            ta.style.position = "fixed";
            ta.style.left = "-9999px";
            document.body.appendChild(ta);
            ta.select();
            try {
                document.execCommand("copy");
                document.body.removeChild(ta);
                return true;
            } catch {
                document.body.removeChild(ta);
                return false;
            }
        }
    }

    function maskEmail(email) {
        const e = (email || "").trim();
        const at = e.indexOf("@");
        if (at <= 1) return "••••@••••";
        const left = e.slice(0, at);
        const domain = e.slice(at + 1);
        const maskedLeft =
            left[0] +
            "•".repeat(Math.max(2, left.length - 2)) +
            left[left.length - 1];
        const maskedDomain = domain
            ? domain[0] + "•".repeat(Math.max(2, domain.length - 1))
            : "•••";
        return `${maskedLeft}@${maskedDomain}`;
    }

    function render() {
        const filtered = applyFilter(MEMBERS);
        const sorted = applySort(filtered);
        const { pageData, total, totalPages } = paginate(sorted);

        elCount.textContent = total.toString();
        elMeta.textContent = `${total} anggota • terakhir diperbarui: ${new Date().toLocaleDateString(
            "id-ID",
        )}`;
        elPrev.disabled = state.page <= 1;
        elNext.disabled = state.page >= totalPages;
        elPageInfo.textContent = `Page ${state.page}/${totalPages}`;

        if (pageData.length === 0) {
            elRows.innerHTML = `
        <div class="abti-detail-card">
          <p class="abti-v" style="margin:0;">Tidak ada hasil untuk pencarian tersebut.</p>
        </div>
      `;
            return;
        }

        elRows.innerHTML = pageData
            .map((m) => {
                const logoAlt = (m.name || "Logo").replace(/"/g, "");
                return `
          <article class="abti-row" data-id="${m.id}">
            <div class="abti-logo">
              <img src="${m.logo}" alt="${logoAlt}" loading="lazy" />
            </div>
            <div class="abti-main">
              <h4 class="abti-name" title="${m.name}">${m.name}</h4>
              <p class="abti-meta">Ketua: ${m.ketua || "—"}</p>
            </div>
            <div class="abti-actions">
              <button class="abti-btn abti-btn-ghost" type="button" data-action="open" data-id="${m.id}">
                Detail
              </button>
            </div>
          </article>
        `;
            })
            .join("");
    }

    function openDrawer(member) {
        state.selected = member;
        elDrawerTitle.textContent = member.name || "Member Detail";
        elDrawerSubtitle.textContent = "Informasi keanggotaan";

        const url = safeLink(member.link);
        const hasEmail = !!(member.email || "").trim();

        elDrawerBody.innerHTML = `
      <div class="abti-detail-card">
        <div class="abti-kv">
          <p class="abti-k">Ketua</p>
          <p class="abti-v">${member.ketua || "—"}</p>
          <p class="abti-k">Sekretaris</p>
          <p class="abti-v">${member.sekretaris || "—"}</p>
          <p class="abti-k">Email</p>
          <p class="abti-v">
            ${
                hasEmail
                    ? `<span class="abti-reveal">
                    <span id="abtiEmailMasked">${maskEmail(member.email)}</span>
                    <button class="abti-chip" type="button" id="abtiRevealEmail">Reveal</button>
                  </span>`
                    : "—"
            }
          </p>
          <p class="abti-k">Link</p>
          <p class="abti-v">
            ${
                url
                    ? `<a class="abti-link" href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>`
                    : "—"
            }
          </p>
        </div>
      </div>
    `;

        elDrawerPrimary.disabled = !url;
        elDrawerSecondary.disabled = !hasEmail;

        elDrawer.setAttribute("aria-hidden", "false");
        elDrawer.classList.add("is-open");
        elDrawerClose.focus();

        const btnReveal = document.getElementById("abtiRevealEmail");
        if (btnReveal) {
            btnReveal.addEventListener(
                "click",
                () => {
                    const elMasked = document.getElementById("abtiEmailMasked");
                    if (elMasked) elMasked.textContent = member.email;
                    btnReveal.remove();
                },
                {
                    once: true,
                },
            );
        }
    }

    function closeDrawer() {
        elDrawer.setAttribute("aria-hidden", "true");
        elDrawer.classList.remove("is-open");
        state.selected = null;
    }

    function setSort(sortValue) {
        state.sort = sortValue;
        state.page = 1;
        if (sortValue === "name_asc")
            elSortLabel.textContent = "Sort: Nama Ketua (A–Z)";
        else elSortLabel.textContent = "Sort: Kota/Kab (A–Z)";

        if (elSortMenu) {
            [...elSortMenu.querySelectorAll(".abti-dd-item")].forEach((btn) => {
                btn.classList.toggle(
                    "is-active",
                    btn.dataset.sort === sortValue,
                );
            });
        }
        render();
    }

    function openDD() {
        if (!elSortDD || !elSortBtn) return;
        elSortDD.classList.add("is-open");
        elSortBtn.setAttribute("aria-expanded", "true");
    }

    function closeDD() {
        if (!elSortDD || !elSortBtn) return;
        elSortDD.classList.remove("is-open");
        elSortBtn.setAttribute("aria-expanded", "false");
    }

    if (elSortBtn && elSortDD && elSortMenu && elSortLabel) {
        elSortBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            const isOpen = elSortDD.classList.contains("is-open");
            if (isOpen) closeDD();
            else openDD();
        });
        elSortMenu.addEventListener("click", (e) => {
            const item = e.target.closest(".abti-dd-item");
            if (!item) return;
            setSort(item.dataset.sort);
            closeDD();
        });
        window.addEventListener("click", () => closeDD());
    }

    function toggleSearchClear() {
        if (!elSearchClear) return;
        const hasValue = !!(elSearch.value || "").trim();
        elSearchClear.classList.toggle("is-visible", hasValue);
    }

    elSearch.addEventListener("input", (e) => {
        state.query = e.target.value;
        state.page = 1;
        toggleSearchClear();
        render();
    });

    if (elSearchClear) {
        elSearchClear.addEventListener("click", () => {
            elSearch.value = "";
            state.query = "";
            state.page = 1;
            toggleSearchClear();
            render();
            elSearch.focus();
        });
    }

    elPrev.addEventListener("click", () => {
        state.page = Math.max(1, state.page - 1);
        render();
    });

    elNext.addEventListener("click", () => {
        state.page = state.page + 1;
        render();
    });

    elRows.addEventListener("click", (e) => {
        const btn = e.target.closest("[data-action='open']");
        if (!btn) return;
        const id = btn.getAttribute("data-id");
        const member = MEMBERS.find((m) => m.id === id);
        if (member) openDrawer(member);
    });

    elDrawerBackdrop.addEventListener("click", closeDrawer);
    elDrawerClose.addEventListener("click", closeDrawer);

    elDrawerPrimary.addEventListener("click", () => {
        if (!state.selected) return;
        const url = safeLink(state.selected.link);
        if (url) window.open(url, "_blank", "noopener,noreferrer");
    });

    elDrawerSecondary.addEventListener("click", async () => {
        if (!state.selected) return;
        const ok = await copyToClipboard(state.selected.email || "");
        if (!ok) return;
        const original = elDrawerSecondary.textContent;
        elDrawerSecondary.textContent = "Copied";
        setTimeout(() => (elDrawerSecondary.textContent = original), 900);
    });

    window.addEventListener("keydown", (e) => {
        if (e.key !== "Escape") return;
        closeDD();
        if (elDrawer.classList.contains("is-open")) closeDrawer();
    });

    // init after CMS override
    (async () => {
        await overrideMembersFromCMS();
        setSort("city_asc");
        toggleSearchClear();
    })();
})();

// ===================== PROGRAM KERJA =====================
(() => {
    const DUMMY_IMAGES = [
        "img/act1.avif",
        "img/act2.avif",
        "img/act3.avif",
        "img/act4.avif",
        "img/act5.avif",
        "img/act6.avif",
    ];

    const PROGRAMS = Array.from(
        {
            length: 24,
        },
        (_, i) => {
            const id = i + 1;
            const category =
                id % 3 === 1 ? "Pembinaan" : id % 3 === 2 ? "Kompetisi" : "SDM";
            const title =
                id === 1
                    ? "Pembinaan Atlet Berjenjang"
                    : id === 2
                      ? "Penguatan Kompetisi Daerah"
                      : id === 3
                        ? "Sertifikasi & Upskilling Pelatih"
                        : `Program Kerja ${id}`;
            return {
                id,
                title,
                category,
                year: "2026",
                short: "Standarisasi format liga/turnamen untuk meningkatkan intensitas kompetisi dan kualitas pertandingan.",
                detail: "Program ini mencakup penyusunan rencana kerja, eksekusi kegiatan inti, monitoring-evaluasi, serta pelaporan. Fokus pada output yang terukur, koordinasi lintas stakeholder, dan peningkatan kualitas penyelenggaraan.",
                image: DUMMY_IMAGES[i % DUMMY_IMAGES.length],
                docUrl: "https://example.com/dokumen-proker.pdf",
                // tambahan opsional (akan diisi CMS jika ada)
                meta: "",
                thumb_text: "",
            };
        },
    );

    async function overrideProgramsFromCMS() {
        const cms = await getHomeCMS();
        if (!cms) return;

        for (let i = 1; i <= 24; i++) {
            const base = `home.programs.${i}.`;
            const p = PROGRAMS[i - 1];
            if (!p) continue;

            const title = cmsVal(cms, base + "title").trim();
            const image = cmsVal(cms, base + "image").trim();
            const category = cmsVal(cms, base + "category").trim();
            const year = cmsVal(cms, base + "year").trim();
            const docUrl = cmsVal(cms, base + "docUrl").trim();

            const meta = cmsVal(cms, base + "meta").trim();
            const desc = cmsVal(cms, base + "desc").trim();
            const thumbText = cmsVal(cms, base + "thumb_text").trim();

            if (title) p.title = title;
            if (image) p.image = image;
            if (category) p.category = category;
            if (year) p.year = year;
            if (docUrl) p.docUrl = docUrl;

            if (meta) p.meta = meta;
            if (desc) p.detail = desc; // reuse existing logic (hero desc)
            if (thumbText) p.thumb_text = thumbText;
        }
    }

    const PAGE_SIZE = 6;
    const HERO_BG_DEFAULT =
        'linear-gradient(135deg, rgba(255,59,48,.42), rgba(255,106,0,.10)), url("img/mainlogo.avif")';

    const sectionEl = document.getElementById("program-kerja");
    const heroEl = document.getElementById("pk-hero");

    const scrollToHeroWithOffset = () => {
        const nav = document.querySelector("[data-navbar]");
        const navHeight = nav
            ? Math.ceil(nav.getBoundingClientRect().height)
            : 72;
        const extraGap = 12;
        const y =
            window.scrollY +
            heroEl.getBoundingClientRect().top -
            (navHeight + extraGap);
        window.scrollTo({
            top: y,
            behavior: "smooth",
        });
    };

    const scrollToGridWithOffset = () => {
        const nav = document.querySelector("[data-navbar]");
        const navHeight = nav
            ? Math.ceil(nav.getBoundingClientRect().height)
            : 72;
        const extraGap = 12;
        const y =
            window.scrollY +
            gridEl.getBoundingClientRect().top -
            (navHeight + extraGap);
        window.scrollTo({
            top: y,
            behavior: "smooth",
        });
    };

    const heroMetaEl = document.getElementById("pk-hero-meta");
    const heroTitleEl = document.getElementById("pk-hero-title");
    const heroDescEl = document.getElementById("pk-hero-desc");
    const heroDocEl = document.getElementById("pk-hero-doc");
    const heroCloseBtn = document.getElementById("pk-hero-close");
    const gridEl = document.getElementById("pk-grid");
    const prevBtn = document.getElementById("pk-prev");
    const nextBtn = document.getElementById("pk-next");
    const pageLabel = document.getElementById("pk-page-label");
    const totalCountEl = document.getElementById("pk-total-count");
    const visibleCountEl = document.getElementById("pk-visible-count");
    const searchInput = document.getElementById("pk-search-input");

    if (
        !sectionEl ||
        !heroEl ||
        !gridEl ||
        !prevBtn ||
        !nextBtn ||
        !pageLabel ||
        !totalCountEl ||
        !visibleCountEl ||
        !searchInput
    )
        return;

    let page = 1;
    let query = "";
    let activeId = null;

    const escapeHtml = (s) =>
        String(s)
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");

    const setHeroBackground = (imgUrl) => {
        heroEl.style.backgroundImage = `linear-gradient(135deg, rgba(255,59,48,.42), rgba(255,106,0,.10)), url("${imgUrl}")`;
        heroEl.style.backgroundSize = "cover";
        heroEl.style.backgroundPosition = "center";
    };

    const resetHero = () => {
        activeId = null;
        heroEl.classList.remove("is-detail");
        heroEl.style.backgroundImage = HERO_BG_DEFAULT;
        gridEl
            .querySelectorAll(".pk-card.is-active")
            .forEach((c) => c.classList.remove("is-active"));
    };

    const openHeroDetail = (program) => {
        gridEl
            .querySelectorAll(".pk-card.is-active")
            .forEach((c) => c.classList.remove("is-active"));
        activeId = program.id;

        // meta: CMS override if provided
        heroMetaEl.textContent =
            (program.meta && program.meta.trim()) ||
            `PROGRAM KERJA • ${program.category} • ${program.year}`;

        heroTitleEl.textContent = program.title;
        heroDescEl.textContent = program.detail || program.short || "";

        if (program.docUrl && program.docUrl !== "#") {
            heroDocEl.href = program.docUrl;
            heroDocEl.style.pointerEvents = "auto";
            heroDocEl.style.opacity = "1";
            heroDocEl.setAttribute("aria-disabled", "false");
        } else {
            heroDocEl.href = "#";
            heroDocEl.style.pointerEvents = "none";
            heroDocEl.style.opacity = ".55";
            heroDocEl.setAttribute("aria-disabled", "true");
        }

        setHeroBackground(program.image);
        heroEl.classList.add("is-detail");

        const card = gridEl.querySelector(`.pk-card[data-id="${program.id}"]`);
        if (card) card.classList.add("is-active");

        scrollToHeroWithOffset();
    };

    const toggleProgram = (id) => {
        const program = PROGRAMS.find((p) => p.id === id);
        if (!program) return;
        if (activeId === id) resetHero();
        else openHeroDetail(program);
    };

    const getFiltered = () => {
        const q = query.trim().toLowerCase();
        if (!q) return PROGRAMS;
        return PROGRAMS.filter(
            (p) =>
                p.title.toLowerCase().includes(q) ||
                (p.category || "").toLowerCase().includes(q) ||
                (p.short || "").toLowerCase().includes(q) ||
                (p.detail || "").toLowerCase().includes(q),
        );
    };

    const getTotalPages = (items) =>
        Math.max(1, Math.ceil(items.length / PAGE_SIZE));
    const clampPage = (n, totalPages) => Math.min(Math.max(1, n), totalPages);

    const render = () => {
        const items = getFiltered();
        const totalPages = getTotalPages(items);
        page = clampPage(page, totalPages);

        const start = (page - 1) * PAGE_SIZE;
        const slice = items.slice(start, start + PAGE_SIZE);

        totalCountEl.textContent = String(items.length);
        visibleCountEl.textContent = String(slice.length);

        gridEl.innerHTML = slice
            .map((p) => {
                const isActive = activeId === p.id;
                return `
        <article class="pk-card ${isActive ? "is-active" : ""}" data-id="${p.id}" tabindex="0" role="button" aria-label="Buka ${escapeHtml(
            p.title,
        )}">
          <div class="pk-thumb">
            <img src="${escapeHtml(p.image)}" alt="${escapeHtml(p.title)}" loading="lazy" />
          </div>
          <div class="pk-overlay">
            <h4 class="pk-overlay__title">${escapeHtml(p.thumb_text || p.title)}</h4>
            <div class="pk-overlay__line"></div>
            <div class="pk-overlay__footer">
              <span class="pk-overlay__read">Baca Selengkapnya</span>
              <span class="pk-overlay__chip">${isActive ? "Tutup" : "Detail"}</span>
            </div>
          </div>
        </article>
      `;
            })
            .join("");

        prevBtn.disabled = page <= 1;
        nextBtn.disabled = page >= totalPages;
        pageLabel.textContent = `Page ${page}/${totalPages}`;
    };

    prevBtn.addEventListener("click", () => {
        page = Math.max(1, page - 1);
        resetHero();
        render();
        requestAnimationFrame(scrollToGridWithOffset);
    });

    nextBtn.addEventListener("click", () => {
        page = page + 1;
        resetHero();
        render();
        requestAnimationFrame(scrollToGridWithOffset);
    });

    let t = null;
    searchInput.addEventListener("input", (e) => {
        clearTimeout(t);
        t = setTimeout(() => {
            query = e.target.value || "";
            page = 1;
            resetHero();
            render();
        }, 160);
    });

    gridEl.addEventListener("click", (e) => {
        const card = e.target.closest(".pk-card");
        if (!card) return;
        toggleProgram(Number(card.getAttribute("data-id")));
    });

    gridEl.addEventListener("keydown", (e) => {
        const card = e.target.closest(".pk-card");
        if (!card) return;
        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            toggleProgram(Number(card.getAttribute("data-id")));
        }
    });

    heroCloseBtn?.addEventListener("click", resetHero);

    const io = new IntersectionObserver(
        (entries) => {
            const entry = entries[0];
            if (!entry) return;
            if (entry.intersectionRatio < 0.35) resetHero();
        },
        {
            threshold: [0, 0.15, 0.35, 0.6, 1],
        },
    );
    io.observe(sectionEl);

    // init after CMS override
    (async () => {
        await overrideProgramsFromCMS();
        heroEl.style.backgroundImage = HERO_BG_DEFAULT;
        render();
    })();
})();

/* =========================================================================
   WEST JAVA CORNER (CMS override + fallback hardcode)
   - CMS source: /api/get.php?page=westjava  (ubah PAGE_NAME kalau beda)
   - Fallback: data hardcode di bawah tetap dipakai kalau key kosong / fetch gagal
   - Guard: aman kalau file digabung dengan section lain (tidak bentrok)
========================================================================= */

/* ===================== WEST JAVA CORNER ===================== */
(() => {
    const root = document.getElementById("newsVideoSection");
    if (!root) return;
    if (root.dataset.wjcInited === "1") return;
    root.dataset.wjcInited = "1";

    // ====== CONFIG ======
    const API_URL = "/api/get.php?page=westjava"; // ganti kalau page kamu namanya lain

    // ====== DEFAULT (FALLBACK) ======
    const DEFAULT_NEWS = [
        {
            time: "10:00 AM – 11:00 AM",
            category: "Informasi Organisasi",
            title: "Rapat Koordinasi Pengurus: Penyesuaian Agenda Kegiatan Triwulan I",
            desc: "Asosiasi Provinsi menyampaikan pembaruan agenda kegiatan untuk memastikan koordinasi program berjalan tertib serta sesuai kebutuhan daerah.",
            ctaText: "Lihat di youtube",
            youtubeUrl: "https://www.youtube.com/shorts/puhHGTBjSFI",
        },
        {
            time: "11:30 AM – 12:00 PM",
            category: "Pembinaan & Prestasi",
            title: "Pendataan Atlet dan Verifikasi Keanggotaan untuk Program Pembinaan",
            desc: "Proses pendataan dilakukan guna memastikan kelengkapan administrasi, validasi data atlet, serta kesiapan peserta pada kegiatan pembinaan.",
            ctaText: "Lihat di youtube",
            youtubeUrl: "https://www.youtube.com/shorts/8LOZUn-AgJ0",
        },
        {
            time: "01:00 PM – 02:00 PM",
            category: "Kompetisi Daerah",
            title: "Persiapan Kejuaraan Tingkat Provinsi: Informasi Teknis dan Tahapan Pelaksanaan",
            desc: "Informasi awal disusun sebagai pedoman pelaksanaan, termasuk ketentuan peserta, jadwal pelaksanaan, serta koordinasi teknis antar pihak terkait.",
            ctaText: "Lihat di youtube",
            youtubeUrl: "https://www.youtube.com/shorts/8LOZUn-AgJ0",
        },
        {
            time: "03:00 PM – 04:00 PM",
            category: "Berita Umum",
            title: "Rangkuman Evaluasi Kompetisi: Catatan Teknis dan Hasil Pertandingan",
            desc: "Ringkasan mencakup capaian pertandingan, catatan teknis, serta poin-poin evaluasi sebagai bahan perbaikan program.",
            ctaText: "Lihat di youtube",
            youtubeUrl: "https://www.youtube.com/shorts/8LOZUn-AgJ0",
        },
    ];

    const DEFAULT_SHORTS_FEED = [
        "https://www.youtube.com/shorts/vLNy-6_qrjU",
        "https://www.youtube.com/shorts/VrrD9TSpds8",
        "https://www.youtube.com/shorts/2FLXtf0BltA",
        "https://www.youtube.com/shorts/fbMkbGB0L14",
    ];

    // ====== DOM ======
    const listEl = document.getElementById("envNewsList");
    const reelsEl = document.getElementById("envReels");
    const shortCtaEl = document.getElementById("envShortCta");
    const prevBtn = document.getElementById("envNewsPrev");
    const nextBtn = document.getElementById("envNewsNext");
    const mqMobile = window.matchMedia("(max-width: 768px)");

    // ====== HELPERS ======
    const clamp = (n, min, max) => Math.max(min, Math.min(max, n));

    const escapeHtml = (str) =>
        String(str ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");

    const safeStr = (v) => (typeof v === "string" ? v.trim() : "");
    const safeUrl = (u) => (typeof u === "string" && u.trim() ? u.trim() : "");

    function extractShortsId(url) {
        if (!url) return null;
        const match = String(url).match(
            /youtube\.com\/shorts\/([a-zA-Z0-9_-]{6,})/,
        );
        return match ? match[1] : null;
    }

    function toEmbedSrc(id, autoplay) {
        const ap = autoplay ? 1 : 0;
        return `https://www.youtube.com/embed/${id}?rel=0&modestbranding=1&playsinline=1&mute=1&autoplay=${ap}`;
    }

    function setCta(id) {
        if (!shortCtaEl || !id) return;
        shortCtaEl.href = `https://www.youtube.com/shorts/${id}`;
    }

    // ====== CMS PARSER ======
    // Expected keys (contoh):
    // westjava.news.1.time
    // westjava.news.1.category
    // westjava.news.1.title
    // westjava.news.1.desc
    // westjava.news.1.ctaText
    // westjava.news.1.youtubeUrl
    //
    // westjava.shorts.1.url
    // westjava.youtube_all_url  (untuk link "Lihat semua update di YouTube" kalau mau)
    function buildNewsFromCms(cmsObj) {
        const out = [];
        for (let i = 1; i <= 4; i++) {
            const base = `westjava.news.${i}.`;
            const time = safeStr(cmsObj[base + "time"]);
            const category = safeStr(cmsObj[base + "category"]);
            const title = safeStr(cmsObj[base + "title"]);
            const desc = safeStr(cmsObj[base + "desc"]);
            const ctaText = safeStr(cmsObj[base + "ctaText"]);
            const youtubeUrl = safeUrl(cmsObj[base + "youtubeUrl"]);

            // Kalau semua kosong, skip (biar fallback hardcode bisa kepake)
            if (
                !time &&
                !category &&
                !title &&
                !desc &&
                !ctaText &&
                !youtubeUrl
            )
                continue;

            out.push({
                time: time || DEFAULT_NEWS[i - 1]?.time || "",
                category: category || DEFAULT_NEWS[i - 1]?.category || "",
                title: title || DEFAULT_NEWS[i - 1]?.title || "",
                desc: desc || DEFAULT_NEWS[i - 1]?.desc || "",
                ctaText:
                    ctaText ||
                    DEFAULT_NEWS[i - 1]?.ctaText ||
                    "Lihat di youtube",
                youtubeUrl:
                    youtubeUrl || DEFAULT_NEWS[i - 1]?.youtubeUrl || "#",
            });
        }
        return out;
    }

    function buildShortsFromCms(cmsObj) {
        const urls = [];
        for (let i = 1; i <= 10; i++) {
            const u = safeUrl(cmsObj[`westjava.shorts.${i}.url`]);
            if (u) urls.push(u);
        }
        return urls.length ? urls : DEFAULT_SHORTS_FEED;
    }

    async function loadCms() {
        try {
            const res = await fetch(API_URL, {
                cache: "no-store",
            });
            if (!res.ok) throw new Error(`CMS fetch failed (${res.status})`);
            const data = await res.json();
            return data && typeof data === "object" ? data : {};
        } catch {
            return {};
        }
    }

    // ====== RENDER NEWS ======
    function renderNews(newsItems) {
        if (!listEl) return;

        const items = (
            newsItems && newsItems.length ? newsItems : DEFAULT_NEWS
        ).slice(0, 4);

        listEl.innerHTML = items
            .map((item) => {
                const safeTime = escapeHtml(item.time);
                const safeCategory = escapeHtml(item.category);
                const safeTitle = escapeHtml(item.title);
                const safeDesc = escapeHtml(item.desc);
                const safeCta = escapeHtml(item.ctaText);
                const safeYt = safeUrl(item.youtubeUrl) || "#";

                return `
          <div class="env-newsitem">
            <div class="env-newsitem__meta">
              <span>${safeTime}</span>
              <span class="env-dot" aria-hidden="true"></span>
              <span>${safeCategory}</span>
            </div>
            <h3 class="env-newsitem__title">${safeTitle}</h3>
            <p class="env-newsitem__desc">${safeDesc}</p>
            <div class="env-newsitem__actions">
              <a class="env-btn env-btn--ghost" href="${safeYt}" target="_blank" rel="noopener">
                ${safeCta}
              </a>
            </div>
          </div>
        `;
            })
            .join("");

        applyNewsPager();
    }

    function applyNewsPager() {
        if (!listEl) return;
        const items = Array.from(listEl.querySelectorAll(".env-newsitem"));
        if (!items.length) return;

        if (!mqMobile.matches) {
            items.forEach((el) => {
                el.classList.remove("is-active");
                el.style.display = "";
            });
            if (prevBtn) prevBtn.style.display = "none";
            if (nextBtn) nextBtn.style.display = "none";
            return;
        }

        if (prevBtn) prevBtn.style.display = "";
        if (nextBtn) nextBtn.style.display = "";

        let idx = Number(listEl.dataset.activeIndex || 0);
        idx = clamp(idx, 0, items.length - 1);
        listEl.dataset.activeIndex = String(idx);
        items.forEach((el, i) => el.classList.toggle("is-active", i === idx));

        if (prevBtn && !prevBtn.dataset.bound) {
            prevBtn.dataset.bound = "1";
            prevBtn.addEventListener("click", () => {
                idx = (idx - 1 + items.length) % items.length;
                listEl.dataset.activeIndex = String(idx);
                items.forEach((el, i) =>
                    el.classList.toggle("is-active", i === idx),
                );
            });
        }

        if (nextBtn && !nextBtn.dataset.bound) {
            nextBtn.dataset.bound = "1";
            nextBtn.addEventListener("click", () => {
                idx = (idx + 1) % items.length;
                listEl.dataset.activeIndex = String(idx);
                items.forEach((el, i) =>
                    el.classList.toggle("is-active", i === idx),
                );
            });
        }
    }

    mqMobile.addEventListener?.("change", applyNewsPager);
    window.addEventListener("resize", applyNewsPager);

    // ====== RENDER SHORTS ======
    function renderShorts(shortsFeedUrls) {
        if (!reelsEl) return;

        const shortsIds = (shortsFeedUrls || [])
            .map((url) => extractShortsId(url))
            .filter(Boolean);

        if (!shortsIds.length) return;

        reelsEl.innerHTML = shortsIds
            .map((id, idx) => {
                const src = toEmbedSrc(id, idx === 0);
                return `
          <div class="env-reel" data-id="${id}" data-index="${idx}">
            <iframe
              class="env-reel__iframe"
              title="YouTube Shorts ${idx + 1}"
              src="${src}"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen
              loading="lazy"
            ></iframe>
            <div class="env-reel__meta" aria-hidden="true">
              <span class="env-reel__pill">Shorts ${idx + 1} / ${shortsIds.length}</span>
              <span class="env-reel__pill">Scroll untuk next</span>
            </div>
          </div>
        `;
            })
            .join("");

        let activeIndex = 0;
        setCta(shortsIds[activeIndex]);

        let wheelLock = false;
        reelsEl.addEventListener(
            "wheel",
            (e) => {
                e.preventDefault();
                if (wheelLock) return;

                const dir = Math.sign(e.deltaY);
                if (dir === 0) return;

                const next = clamp(
                    activeIndex + (dir > 0 ? 1 : -1),
                    0,
                    shortsIds.length - 1,
                );
                if (next === activeIndex) return;

                wheelLock = true;
                goToIndex(next);
                window.setTimeout(() => {
                    wheelLock = false;
                }, 520);
            },
            {
                passive: false,
            },
        );

        reelsEl.addEventListener("keydown", (e) => {
            if (e.key === "ArrowDown" || e.key === "PageDown") {
                e.preventDefault();
                goToIndex(clamp(activeIndex + 1, 0, shortsIds.length - 1));
            }
            if (e.key === "ArrowUp" || e.key === "PageUp") {
                e.preventDefault();
                goToIndex(clamp(activeIndex - 1, 0, shortsIds.length - 1));
            }
        });

        let scrollTick = null;
        reelsEl.addEventListener("scroll", () => {
            if (scrollTick) window.clearTimeout(scrollTick);
            scrollTick = window.setTimeout(() => {
                const idx = nearestIndexByScroll(reelsEl);
                if (idx !== activeIndex) goToIndex(idx, true);
            }, 120);
        });

        function goToIndex(idx, fromScroll) {
            activeIndex = idx;

            const page = reelsEl.querySelector(
                `.env-reel[data-index="${idx}"]`,
            );
            if (page && !fromScroll) {
                page.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }

            const pages = reelsEl.querySelectorAll(".env-reel");
            pages.forEach((p) => {
                const id = p.getAttribute("data-id");
                const frame = p.querySelector("iframe");
                if (!frame) return;

                const pIdx = Number(p.getAttribute("data-index"));
                if (pIdx === activeIndex) {
                    const desired = toEmbedSrc(id, true);
                    if (!frame.src || !frame.src.includes(`/embed/${id}`))
                        frame.src = desired;
                    if (!frame.src.includes("autoplay=1")) frame.src = desired;
                } else {
                    if (frame.src && frame.src !== "about:blank")
                        frame.src = "about:blank";
                }
            });

            setCta(shortsIds[activeIndex]);
        }

        function nearestIndexByScroll(container) {
            const h = container.clientHeight || 1;
            return clamp(
                Math.round(container.scrollTop / h),
                0,
                shortsIds.length - 1,
            );
        }
    }

    // ====== OPTIONAL: override link "Lihat semua update di YouTube" via CMS ======
    function applyYoutubeAllLink(cmsObj) {
        const a = root.querySelector(".env-link");
        if (!a) return;
        const cmsUrl = safeUrl(cmsObj["westjava.youtube_all_url"]);
        if (cmsUrl) a.href = cmsUrl;
    }

    // ====== INIT ======
    (async () => {
        // render fallback dulu biar cepat muncul
        renderNews(DEFAULT_NEWS);
        renderShorts(DEFAULT_SHORTS_FEED);

        // lalu coba override dari CMS
        const cms = await loadCms();
        if (cms && Object.keys(cms).length) {
            applyYoutubeAllLink(cms);

            const cmsNews = buildNewsFromCms(cms);
            if (cmsNews.length) renderNews(cmsNews);

            const cmsShorts = buildShortsFromCms(cms);
            renderShorts(cmsShorts);
        }
    })();
})();
// Podcast data - replace with your actual YouTube video IDs
const podcastVideos = [
    {
        link: "https://www.youtube.com/embed/NvNsGD7W7WQ",
    },
    {
        link: "https://www.youtube.com/embed/NvNsGD7W7WQ",
    },
    {
        link: "https://www.youtube.com/embed/NvNsGD7W7WQ",
    },
    {
        link: "https://www.youtube.com/embed/NvNsGD7W7WQ",
    },
    {
        link: "https://www.youtube.com/embed/NvNsGD7W7WQ",
    },
];

// Podcast Carousel Controller
class PodcastCarousel {
    constructor() {
        this.currentIndex = 0;
        this.autoSlideInterval = null;
        this.autoSlideDelay = 8000; // 8 seconds
        this.isTransitioning = false;

        this.track = document.getElementById("podcastTrack");
        this.prevBtn = document.getElementById("podcastPrev");
        this.nextBtn = document.getElementById("podcastNext");
        this.indicatorsContainer = document.getElementById("podcastIndicators");

        if (!this.track) return;

        this.init();
    }

    init() {
        this.renderPodcasts();
        this.renderIndicators();
        this.attachEventListeners();
        this.startAutoSlide();
        this.updateCarousel();
    }

    renderPodcasts() {
        this.track.innerHTML = podcastVideos
            .map(
                (podcast, index) => `
            <article class="podcast__slide">
                <div class="podcast__iframe-wrapper">
                    <iframe 
                        id="podcastIframe${index}"
                        class="podcast__iframe"
                        src="${podcast.link}"
                        title="Podcast ${index + 1}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            </article>
        `,
            )
            .join("");
    }

    renderIndicators() {
        this.indicatorsContainer.innerHTML = podcastVideos
            .map(
                (_, index) => `
            <button class="podcast__dot ${index === 0 ? "podcast__dot--active" : ""}" 
                    data-index="${index}" 
                    type="button"
                    aria-label="Go to podcast ${index + 1}"></button>
        `,
            )
            .join("");
    }

    attachEventListeners() {
        // Previous button
        this.prevBtn?.addEventListener("click", () => {
            this.stopAutoSlide();
            this.prev();
            this.startAutoSlide();
        });

        // Next button
        this.nextBtn?.addEventListener("click", () => {
            this.stopAutoSlide();
            this.next();
            this.startAutoSlide();
        });

        // Indicator dots
        this.indicatorsContainer?.addEventListener("click", (e) => {
            if (e.target.classList.contains("podcast__dot")) {
                this.stopAutoSlide();
                const index = parseInt(e.target.dataset.index);
                this.goToSlide(index);
                this.startAutoSlide();
            }
        });

        // Pause auto-slide when user interacts with carousel
        const carouselWrapper = document.querySelector(
            ".podcast__carousel-wrapper",
        );
        carouselWrapper?.addEventListener("mouseenter", () =>
            this.stopAutoSlide(),
        );
        carouselWrapper?.addEventListener("mouseleave", () =>
            this.startAutoSlide(),
        );

        // Touch events for mobile swipe
        let touchStartX = 0;
        let touchEndX = 0;

        this.track?.addEventListener("touchstart", (e) => {
            touchStartX = e.changedTouches[0].screenX;
            this.stopAutoSlide();
        });

        this.track?.addEventListener("touchend", (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
            this.startAutoSlide();
        });

        const handleSwipe = () => {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
        };

        this.handleSwipe = handleSwipe;
    }

    updateCarousel() {
        if (this.isTransitioning) return;

        this.isTransitioning = true;

        // Single slide at a time (full container width)
        const offset = -(this.currentIndex * 100);

        this.track.style.transform = `translateX(${offset}%)`;

        // Update indicators
        const dots =
            this.indicatorsContainer?.querySelectorAll(".podcast__dot");
        dots?.forEach((dot, index) => {
            dot.classList.toggle(
                "podcast__dot--active",
                index === this.currentIndex,
            );
        });

        // Update button visibility
        this.prevBtn?.classList.toggle(
            "podcast__nav--hidden",
            this.currentIndex === 0,
        );
        this.nextBtn?.classList.toggle(
            "podcast__nav--hidden",
            this.currentIndex >= podcastVideos.length - 1,
        );

        setTimeout(() => {
            this.isTransitioning = false;
        }, 500);
    }

    next() {
        if (this.currentIndex < podcastVideos.length - 1) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0; // Loop back to start
        }

        this.updateCarousel();
    }

    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = podcastVideos.length - 1; // Loop to end
        }

        this.updateCarousel();
    }

    goToSlide(index) {
        this.currentIndex = index;
        this.updateCarousel();
    }

    startAutoSlide() {
        this.stopAutoSlide();
        this.autoSlideInterval = setInterval(() => {
            this.next();
        }, this.autoSlideDelay);
    }

    stopAutoSlide() {
        if (this.autoSlideInterval) {
            clearInterval(this.autoSlideInterval);
            this.autoSlideInterval = null;
        }
    }
}

// Initialize carousel when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    new PodcastCarousel();
});

/* ========================= BERITA LAINNYA (GRID CARDS) ========================= */
(() => {
    const root = document.getElementById("moreNews");
    const grid = document.getElementById("moreNewsGrid");
    if (!root || !grid) return;

    if (root.dataset.moreNewsInited === "1") return;
    root.dataset.moreNewsInited = "1";

    // ====== CONFIG ======
    const API_URL = "/api/get.php?page=westjava"; // konsisten dengan atas

    // ====== DEFAULT (FALLBACK) ======
    const PAGE_SIZE = 6;

    const categories = ["Lainnya", "Pertandingan", "Organisasi", "Event"];
    const titles = [
        "Ketum ABTI Resmikan Program Pembinaan Atlet Muda di Jawa Barat",
        "Evaluasi Liga Indoor: Fokus Perbaikan Wasit dan Standar Venue",
        "ABTI Jabar Dorong Kolaborasi Klub untuk Pembinaan Berjenjang",
        "Pelatihan Pelatih Level Dasar: Materi Teknik dan Taktik Modern",
        "Tim Beach Jabar Menang Dramatis di Laga Penentuan Grup",
        "Rapat Koordinasi Pengurus: Penegasan Struktur dan Jobdesk",
        "Workshop Sport Science: Monitoring Beban Latihan Atlet",
        "Tryout Nasional: ABTI Jabar Kirim Talenta Potensial",
        "Update Database Atlet: Verifikasi Data dan Dokumen",
        "Program Kerja 2026: Target Medali dan Peningkatan Kompetisi",
        "Sparring Antar Klub: Uji Skema dan Rotasi Pemain",
        "Sosialisasi Peraturan Baru: Penekanan Safety dan Fair Play",
    ];

    const DEFAULT_MORE_NEWS = Array.from({
        length: 24,
    }).map((_, i) => {
        const cat = categories[i % categories.length];
        const title = titles[i % titles.length] + ` (#${i + 1})`;
        const day = (i % 28) + 1;
        const month = "January";
        const year = 2026;
        const date = `${day} ${month} ${year}`;
        const img = `img/javacorner/${i + 1}.avif`;
        const url = `https://portal-berita.com/berita/${i + 1}`;
        const youtube = `https://www.youtube.com/watch?v=VIDEO_ID_${i + 1}`;
        return {
            category: cat,
            date,
            title,
            img,
            url,
            youtube,
        };
    });

    // ====== HELPERS ======
    const esc = (s) =>
        String(s ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");

    const safeUrl = (u) => (typeof u === "string" && u.trim() ? u.trim() : "");

    async function loadCms() {
        try {
            const res = await fetch(API_URL, {
                cache: "no-store",
            });
            if (!res.ok) throw new Error(`CMS fetch failed (${res.status})`);
            const data = await res.json();
            return data && typeof data === "object" ? data : {};
        } catch {
            return {};
        }
    }

    // Expected keys (contoh):
    // westjava.more_news.1.date
    // westjava.more_news.1.title
    // westjava.more_news.1.img
    // westjava.more_news.1.url
    // westjava.more_news.1.youtube
    function buildMoreNewsFromCms(cmsObj) {
        const out = [];
        for (let i = 1; i <= 24; i++) {
            const base = `westjava.more_news.${i}.`;
            const date = safeUrl(cmsObj[base + "date"]) || "";
            const title = safeUrl(cmsObj[base + "title"]) || "";
            const img = safeUrl(cmsObj[base + "img"]) || "";
            const url = safeUrl(cmsObj[base + "url"]) || "";
            const youtube = safeUrl(cmsObj[base + "youtube"]) || "";

            // kalau kosong semua: skip (fallback default dipakai)
            if (!date && !title && !img && !url && !youtube) continue;

            // category optional
            const category = safeUrl(cmsObj[base + "category"]) || "";

            out.push({
                category: category || DEFAULT_MORE_NEWS[i - 1]?.category || "",
                date: date || DEFAULT_MORE_NEWS[i - 1]?.date || "",
                title: title || DEFAULT_MORE_NEWS[i - 1]?.title || "",
                img: img || DEFAULT_MORE_NEWS[i - 1]?.img || "",
                url: url || DEFAULT_MORE_NEWS[i - 1]?.url || "",
                youtube: youtube || DEFAULT_MORE_NEWS[i - 1]?.youtube || "",
            });
        }
        return out;
    }

    // ====== PAGER UI ======
    const pager = document.createElement("div");
    pager.className = "moreNewsPager";
    pager.innerHTML = `
    <button class="moreNewsPager__btn" type="button" id="moreNewsPrev" aria-label="Prev page">Prev</button>
    <div class="moreNewsPager__nums" id="moreNewsNums" aria-label="Pagination"></div>
    <button class="moreNewsPager__btn" type="button" id="moreNewsNext" aria-label="Next page">Next</button>
  `;
    root.querySelector(".moreNews__container")?.appendChild(pager);

    const prevBtn = pager.querySelector("#moreNewsPrev");
    const nextBtn = pager.querySelector("#moreNewsNext");
    const numsWrap = pager.querySelector("#moreNewsNums");

    let page = 1;
    let DATA = DEFAULT_MORE_NEWS.slice();
    let totalPages = Math.max(1, Math.ceil(DATA.length / PAGE_SIZE));

    function renderGrid() {
        const start = (page - 1) * PAGE_SIZE;
        const items = DATA.slice(start, start + PAGE_SIZE);

        grid.innerHTML = items
            .map((x) => {
                const newsUrl = safeUrl(x.url);
                const ytUrl = safeUrl(x.youtube);

                return `
          <article class="moreNewsCard">
            <div class="moreNewsCard__media">
              <img src="${esc(x.img)}" alt="" loading="lazy">
            </div>
            <div class="moreNewsCard__overlay" aria-hidden="true"></div>
            <div class="moreNewsCard__content">
              <p class="moreNewsCard__date">${esc(x.date)}</p>
              <h3 class="moreNewsCard__title">
                <a class="moreNewsCard__titleLink"
                   href="${esc(newsUrl || "#")}"
                   ${newsUrl ? 'target="_blank" rel="noopener noreferrer"' : 'aria-disabled="true" tabindex="-1"'}
                   aria-label="Buka berita: ${esc(x.title)}">
                  ${esc(x.title)}
                </a>
              </h3>
              ${
                  ytUrl
                      ? `<a class="moreNewsCard__source"
                        href="${esc(ytUrl)}"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Buka video YouTube: ${esc(x.title)}">
                        youtube
                     </a>`
                      : `<span class="moreNewsCard__source is-disabled" aria-disabled="true">youtube</span>`
              }
            </div>
          </article>
        `;
            })
            .join("");
    }

    function renderNums() {
        numsWrap.innerHTML = "";
        for (let i = 1; i <= totalPages; i++) {
            const b = document.createElement("button");
            b.type = "button";
            b.className =
                "moreNewsPager__num" + (i === page ? " is-active" : "");
            b.textContent = String(i);
            b.setAttribute("aria-label", `Page ${i}`);
            b.addEventListener("click", () => {
                page = i;
                update();
                root.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            });
            numsWrap.appendChild(b);
        }
    }

    function updateNavState() {
        prevBtn.disabled = page <= 1;
        nextBtn.disabled = page >= totalPages;
    }

    function update() {
        totalPages = Math.max(1, Math.ceil(DATA.length / PAGE_SIZE));
        page = Math.max(1, Math.min(page, totalPages));
        renderGrid();
        renderNums();
        updateNavState();
    }

    prevBtn.addEventListener("click", () => {
        if (page > 1) {
            page--;
            update();
            root.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });

    nextBtn.addEventListener("click", () => {
        if (page < totalPages) {
            page++;
            update();
            root.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });

    // ====== INIT ======
    (async () => {
        // render fallback dulu
        update();

        // override dari CMS kalau ada
        const cms = await loadCms();
        if (cms && Object.keys(cms).length) {
            const cmsData = buildMoreNewsFromCms(cms);
            if (cmsData.length) {
                DATA = cmsData;
                page = 1;
                update();
            }
        }
    })();
})();

// ========================= EVENT (CMS override + fallback hardcode) =========================
(() => {
    const evRoot = document.getElementById("events");
    if (!evRoot) return; // guard: cuma jalan di halaman event
    if (evRoot.dataset.evInited === "1") return;
    evRoot.dataset.evInited = "1";

    // ========= DEFAULT (fallback hardcode) =========
    const EVENTS_DEFAULT = [
        {
            id: "ev-001",
            name: "Kejuaraan Bola Tangan Indoor ABTI Jabar 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Final%20-%20Germany%20vs%20Norway__1JC0752-.JPG?itok=E5gZ7d1i",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Final%20-%20Germany%20vs%20Norway__1JC0408-.JPG?itok=tCwHFnKZ",
            category: ["INDOOR"],
            location: "Kota Bandung",
            athletes: 168,
            coaches: 28,
            teams: 14,
            management: 18,
            audienceOfflinePerDay: 750,
            website: "https://example.com/abti-jabar-indoor-bandung-2026",
            administrator: "Sekretariat ABTI Jawa Barat",
        },
        {
            id: "ev-002",
            name: "Piala Wali Kota Bogor Bola Tangan Indoor 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Final%20-%20Germany%20vs%20Norway__1JC0272-.JPG?itok=2WOaaXm5",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Final%20-%20Germany%20vs%20Norway__1JC0522-.JPG?itok=AkzBC029",
            category: ["INDOOR"],
            location: "Kota Bogor",
            athletes: 144,
            coaches: 24,
            teams: 12,
            management: 14,
            audienceOfflinePerDay: 600,
            website: "https://example.com/piala-walikota-bogor-indoor-2026",
            administrator: "Panitia Kota Bogor",
        },
        {
            id: "ev-003",
            name: "Kejuaraan Antar-Kabupaten/Kota ABTI Jabar 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands__1JC6236-.JPG?itok=GoRN1gnh",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands_SP9_7731-.JPG?itok=MNC1oA88",
            category: ["INDOOR"],
            location: "Kota Cirebon",
            athletes: 192,
            coaches: 32,
            teams: 16,
            management: 20,
            audienceOfflinePerDay: 820,
            website: "https://example.com/abti-jabar-zona-timur-cirebon-2026",
            administrator: "Pengprov ABTI Jabar - Korwil Timur",
        },
        {
            id: "ev-004",
            name: "Bekasi Indoor Handball Open 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Final%20-%20Germany%20vs%20Norway__1JC0104-.JPG?itok=NaKh3t6z",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands__1JC6950-.JPG?itok=-NzVn0gQ",
            category: ["INDOOR"],
            location: "Kota Bekasi",
            athletes: 156,
            coaches: 26,
            teams: 13,
            management: 16,
            audienceOfflinePerDay: 680,
            website: "https://example.com/bekasi-indoor-open-2026",
            administrator: "Panitia Kota Bekasi",
        },
        {
            id: "ev-005",
            name: "Pangandaran Beach Handball Series 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands_SP9_8867-.JPG?itok=qNp2Lgzv",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Medal%20Ceremony_SP7_9976-.jpg?itok=g9ly0Bfb",
            category: ["BEACH"],
            location: "Kabupaten Pangandaran",
            athletes: 120,
            coaches: 20,
            teams: 10,
            management: 14,
            audienceOfflinePerDay: 1400,
            website: "https://example.com/pangandaran-beach-series-2026",
            administrator: "Panitia Beach Pangandaran",
        },
        {
            id: "ev-006",
            name: "Beach Handball Challenge 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands_SP7_6710-.JPG?itok=8PcAmgB9",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Medal%20Ceremony__C4_9962-.jpg?itok=9XW6Yull",
            category: ["BEACH"],
            location: "Kabupaten Sukabumi",
            athletes: 132,
            coaches: 22,
            teams: 11,
            management: 13,
            audienceOfflinePerDay: 1100,
            website: "https://example.com/sukabumi-beach-challenge-2026",
            administrator: "Korwil Beach Sukabumi",
        },
        {
            id: "ev-007",
            name: "Garut Coastal Beach Handball Cup 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Medal%20Ceremony__UH17198-.jpg?itok=576GHCW-",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Medal%20Ceremony__C4_0276-.jpg?itok=eh7aMiqk",
            category: ["BEACH"],
            location: "Kabupaten Garut",
            athletes: 108,
            coaches: 18,
            teams: 9,
            management: 12,
            audienceOfflinePerDay: 950,
            website: "https://example.com/garut-beach-cup-2026",
            administrator: "Panitia Pantai Garut",
        },
        {
            id: "ev-008",
            name: "Wheelchair Handball Invitational 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Medal%20Ceremony__C4_0341-.jpg?itok=dR7xNgXd",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Medal%20Ceremony__C4_0011-.jpg?itok=BvFRCbGm",
            category: ["WHEELCHAIR"],
            location: "Kota Bandung",
            athletes: 72,
            coaches: 14,
            teams: 8,
            management: 12,
            audienceOfflinePerDay: 420,
            website: "https://example.com/bandung-wheelchair-invitational-2026",
            administrator: "Koordinator Disabilitas ABTI Jabar",
        },
        {
            id: "ev-009",
            name: "Depok Inclusive Handball Cup 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands__1JC6537-.JPG?itok=IeaRGT3L",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands_SP7_5940-.JPG?itok=dqo7fEjZ",
            category: ["WHEELCHAIR"],
            location: "Kota Depok",
            athletes: 64,
            coaches: 12,
            teams: 7,
            management: 10,
            audienceOfflinePerDay: 360,
            website: "https://example.com/depok-inclusive-cup-2026",
            administrator: "Panitia Inklusi Kota Depok",
        },
        {
            id: "ev-010",
            name: "Tasikmalaya Wheelchair Friendly Tournament 2026",
            logo: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands_SP9_7466-.JPG?itok=UC_yDlMe",
            cover: "https://www.ihf.info/sites/default/files/styles/gallery_details/public/2025-12/GERNED25-Bronze%20Medal%20-%20France%20vs%20Netherlands__1JC6236-.JPG?itok=GoRN1gnh",
            category: ["WHEELCHAIR"],
            location: "Kota Tasikmalaya",
            athletes: 56,
            coaches: 10,
            teams: 6,
            management: 9,
            audienceOfflinePerDay: 300,
            website: "https://example.com/tasik-wheelchair-tournament-2026",
            administrator: "Panitia Kota Tasikmalaya",
        },
    ];

    // ========= CMS fetch (override) =========
    // Struktur key yang dipakai:
    // events.header.title_black
    // events.header.title_red
    // events.header.subtitle
    // events.items.1.id
    // events.items.1.name
    // events.items.1.logo
    // events.items.1.cover
    // events.items.1.category   (contoh: "INDOOR,BEACH")
    // events.items.1.location
    // events.items.1.athletes
    // events.items.1.coaches
    // events.items.1.teams
    // events.items.1.management
    // events.items.1.audience
    // events.items.1.website
    // events.items.1.administrator
    async function loadCMS() {
        const tryPages = ["events", "event"]; // jaga-jaga kalau kamu pakai page name beda
        for (const p of tryPages) {
            try {
                const res = await fetch(
                    `/api/get.php?page=${encodeURIComponent(p)}`,
                    {
                        cache: "no-store",
                    },
                );
                if (!res.ok) continue;
                const data = await res.json();
                if (data && typeof data === "object")
                    return {
                        page: p,
                        data,
                    };
            } catch {
                // ignore -> fallback
            }
        }
        return null;
    }

    function pick(obj, key) {
        const v = obj?.[key];
        return typeof v === "string" ? v.trim() : "";
    }

    function numOrZero(v) {
        const n = Number(String(v ?? "").replace(/[^\d.-]/g, ""));
        return Number.isFinite(n) ? n : 0;
    }

    function parseCats(s) {
        const raw = String(s || "").trim();
        if (!raw) return [];
        return raw
            .split(/[,\|]/)
            .map((x) => x.trim().toUpperCase())
            .filter(Boolean);
    }

    function applyHeaderCMS(flat) {
        const header = document.getElementById("eventHeader");
        if (!header) return;

        const black = pick(flat, "events.header.title_black");
        const red = pick(flat, "events.header.title_red");
        const sub = pick(flat, "events.header.subtitle");

        const elBlack = header.querySelector(".page-header__title-black");
        const elRed = header.querySelector(".page-header__title-red");
        const elSub = header.querySelector(".page-header__subtitle");

        if (elBlack && black) elBlack.textContent = black;
        if (elRed && red) elRed.textContent = red;
        if (elSub && sub) elSub.textContent = sub;
    }

    function buildEventsFromCMS(flat, maxItems = 20) {
        const out = [];
        for (let i = 1; i <= maxItems; i++) {
            const base = `events.items.${i}.`;
            const name = pick(flat, base + "name");
            if (!name) continue; // item kosong => skip

            const id = pick(flat, base + "id") || `ev-cms-${i}`;
            const logo = pick(flat, base + "logo");
            const cover = pick(flat, base + "cover");
            const category = parseCats(pick(flat, base + "category"));
            const location = pick(flat, base + "location");
            const website = pick(flat, base + "website");
            const administrator = pick(flat, base + "administrator");

            out.push({
                id,
                name,
                logo: logo || "", // boleh kosong -> UI tetep jalan
                cover: cover || "",
                category: category.length ? category : ["INDOOR"], // default jika kosong
                location: location || "-",
                athletes: numOrZero(pick(flat, base + "athletes")),
                coaches: numOrZero(pick(flat, base + "coaches")),
                teams: numOrZero(pick(flat, base + "teams")),
                management: numOrZero(pick(flat, base + "management")),
                audienceOfflinePerDay: numOrZero(pick(flat, base + "audience")),
                website: website || "#",
                administrator: administrator || "-",
            });
        }
        return out;
    }

    // ========= APP STATE =========
    let EVENTS = [...EVENTS_DEFAULT];

    const grid = document.getElementById("eventsGrid");
    const searchInput = document.getElementById("eventSearch");
    const tools = document.getElementById("eventsTools");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const pagerCount = document.getElementById("pagerCount");
    const modal = document.getElementById("eventModal");
    const modalLogo = document.getElementById("modalLogo");
    const modalTitle = document.getElementById("modalTitle");
    const modalBadges = document.getElementById("modalBadges");
    const modalBody = document.getElementById("modalBody");
    const modalWebsite = document.getElementById("modalWebsite");

    if (
        !grid ||
        !searchInput ||
        !tools ||
        !prevBtn ||
        !nextBtn ||
        !pagerCount ||
        !modal
    )
        return;

    const PAGE_SIZE = 6;
    let activeFilter = "ALL";
    let query = "";
    let page = 1;
    let lastFocus = null;

    function esc(s) {
        return String(s ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function fmt(n) {
        const num = Number(n);
        if (Number.isNaN(num)) return "0";
        return num.toLocaleString("id-ID");
    }

    function capital(s) {
        const x = String(s || "").toLowerCase();
        return x ? x[0].toUpperCase() + x.slice(1) : "";
    }

    function renderBadges(cats) {
        return (cats || [])
            .map((c) => `<span class="pill">${esc(capital(c))}</span>`)
            .join("");
    }

    function normalize(str) {
        return String(str || "")
            .trim()
            .toLowerCase();
    }

    function applyFilters() {
        const q = normalize(query);
        return EVENTS.filter((ev) => {
            const inCategory =
                activeFilter === "ALL"
                    ? true
                    : (ev.category || []).some(
                          (c) => String(c).toUpperCase() === activeFilter,
                      );

            if (!inCategory) return false;
            if (!q) return true;

            const hay = normalize(
                `${ev.name} ${ev.location} ${(ev.category || []).join(" ")} ${ev.administrator}`,
            );
            return hay.includes(q);
        });
    }

    function paginate(items) {
        const total = items.length;
        const totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
        page = Math.min(Math.max(1, page), totalPages);
        const start = (page - 1) * PAGE_SIZE;
        return {
            total,
            totalPages,
            pageItems: items.slice(start, start + PAGE_SIZE),
        };
    }

    function setPager(total, totalPages) {
        prevBtn.disabled = page <= 1;
        nextBtn.disabled = page >= totalPages;
        pagerCount.textContent = `Page ${page} of ${totalPages} • ${total} result${total === 1 ? "" : "s"}`;
    }

    function renderCards(items) {
        if (!items.length) {
            grid.innerHTML = `<div class="events__empty">No events found.</div>`;
            return;
        }

        grid.innerHTML = items
            .map((ev, idx) => {
                const cats = renderBadges(ev.category);
                const delay = Math.min(220, idx * 55);

                // cover/logo boleh kosong -> jangan bikin broken UI
                const cover = ev.cover ? esc(ev.cover) : "";
                const logo = ev.logo ? esc(ev.logo) : "";

                return `
          <article class="event-card" style="animation-delay:${delay}ms" aria-label="${esc(ev.name)}">
            <div class="event-card__media">
              ${
                  cover
                      ? `<img class="event-card__img" src="${cover}" alt="${esc(ev.name)}" loading="lazy" />`
                      : `<div class="event-card__img" aria-hidden="true"></div>`
              }
            </div>

            <div class="event-card__body">
              <div class="event-card__head">
                <div class="event-card__logoWrap">
                  ${
                      logo
                          ? `<img class="event-card__logo" src="${logo}" alt="Logo ${esc(ev.name)}" loading="lazy" />`
                          : ``
                  }
                </div>
                <div class="event-card__titleWrap">
                  <h3 class="event-card__title">${esc(ev.name)}</h3>
                </div>
              </div>

              <div class="event-card__metaRow">
                <div class="event-card__loc">
                  <span class="icon icon--pin" aria-hidden="true"></span>
                  <span class="event-card__locText">${esc(ev.location)}</span>
                </div>
                <div class="event-card__badges">${cats}</div>
              </div>

              <button class="btn-primary" type="button" data-ev-open="${esc(ev.id)}">Detail Event</button>
            </div>
          </article>
        `;
            })
            .join("");
    }

    const ICONS = {
        "map-pin": `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true"
           fill="none" stroke="currentColor" stroke-width="1.6"
           stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="8">
        <path d="M12 22s7-6 7-12a7 7 0 1 0-14 0c0 6 7 12 7 12Z"></path>
        <circle cx="12" cy="10" r="2.3"></circle>
      </svg>
    `,
        users: `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true">
        <path d="M16 11a3 3 0 1 0-3-3 3 3 0 0 0 3 3Z"></path>
        <path d="M8.5 12.5a3 3 0 1 0-3-3 3 3 0 0 0 3 3Z"></path>
        <path d="M20 20a6 6 0 0 0-8-5"></path>
        <path d="M13 20a7 7 0 0 0-10 0"></path>
      </svg>
    `,
        whistle: `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true">
        <path d="M10 10h4"></path>
        <path d="M14 8v4"></path>
        <path d="M8.5 12.5A5.5 5.5 0 1 0 14 18H9a4 4 0 0 1-.5-5.5Z"></path>
        <path d="M16 14h5"></path>
      </svg>
    `,
        briefcase: `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true">
        <path d="M9 6V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1"></path>
        <path d="M3 10h18"></path>
        <path d="M5 10v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10"></path>
      </svg>
    `,
        eye: `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true">
        <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"></path>
        <circle cx="12" cy="12" r="2.5"></circle>
      </svg>
    `,
        globe: `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true">
        <circle cx="12" cy="12" r="9"></circle>
        <path d="M3 12h18"></path>
        <path d="M12 3c3 3.2 3 14.8 0 18"></path>
      </svg>
    `,
        "badge-check": `
      <svg viewBox="0 0 24 24" class="ico" aria-hidden="true">
        <path d="M12 2l2.2 2.1 3-.4.8 2.9 2.6 1.6-1.6 2.6.4 3-2.9.8-1.6 2.6-2.6-1.6-3 .4-.8-2.9-2.6-1.6 1.6-2.6-.4-3 2.9-.8L12 2Z"></path>
        <path d="M8.5 12l2.2 2.2L15.8 9"></path>
      </svg>
    `,
    };

    function row(iconKey, label, value) {
        return `
      <div class="detail-row">
        <div class="detail-ico" aria-hidden="true">${ICONS[iconKey] || ""}</div>
        <div class="detail-text">
          <div class="detail-label">${esc(label)}</div>
          <div class="detail-value">${esc(value)}</div>
        </div>
      </div>
    `;
    }

    function openModal(id, opener) {
        const ev = EVENTS.find((x) => x.id === id);
        if (!ev) return;

        lastFocus = opener || document.activeElement;

        if (modalLogo) {
            modalLogo.src = ev.logo || "";
            modalLogo.alt = ev.name ? `Logo ${ev.name}` : "Logo event";
        }
        if (modalTitle) modalTitle.textContent = ev.name || "Detail Event";
        if (modalBadges) modalBadges.innerHTML = renderBadges(ev.category);

        if (modalBody) {
            modalBody.innerHTML = [
                row("map-pin", "Lokasi", ev.location || "-"),
                row("users", "Jumlah Atlet", `${fmt(ev.athletes)} atlet`),
                row("whistle", "Jumlah Pelatih", `${fmt(ev.coaches)} pelatih`),
                row("users", "Jumlah Tim", `${fmt(ev.teams)} tim`),
                row(
                    "briefcase",
                    "Tim Manajemen",
                    `${fmt(ev.management)} orang`,
                ),
                row(
                    "eye",
                    "Penonton Offline per Hari",
                    `${fmt(ev.audienceOfflinePerDay)} orang`,
                ),
                row("globe", "Website", ev.website || "-"),
                row("badge-check", "Administrator", ev.administrator || "-"),
            ].join("");
        }

        const web = ev.website || "#";
        if (modalWebsite) modalWebsite.href = web;

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";

        const closeBtn = modal.querySelector("[data-ev-close]");
        closeBtn?.focus?.();
    }

    function closeModal() {
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
        if (lastFocus && typeof lastFocus.focus === "function")
            lastFocus.focus();
    }

    function refresh() {
        const filtered = applyFilters();
        const { total, totalPages, pageItems } = paginate(filtered);

        grid.classList.remove("is-ready");
        renderCards(pageItems);
        requestAnimationFrame(() => grid.classList.add("is-ready"));

        setPager(total, totalPages);
    }

    // ========= Bind events (tetap mirip JS kamu) =========
    tools.addEventListener("click", (e) => {
        const btn = e.target.closest("[data-filter]");
        if (!btn || !tools.contains(btn)) return;

        tools
            .querySelectorAll(".chip")
            .forEach((b) => b.classList.remove("is-active"));
        btn.classList.add("is-active");

        activeFilter = btn.getAttribute("data-filter") || "ALL";
        page = 1;
        refresh();
    });

    let t = null;
    searchInput.addEventListener("input", () => {
        clearTimeout(t);
        t = setTimeout(() => {
            query = searchInput.value || "";
            page = 1;
            refresh();
        }, 180);
    });

    prevBtn.addEventListener("click", (e) => {
        e.preventDefault();
        page -= 1;
        refresh();
    });
    nextBtn.addEventListener("click", (e) => {
        e.preventDefault();
        page += 1;
        refresh();
    });

    evRoot.addEventListener("click", (e) => {
        const openBtn = e.target.closest("[data-ev-open]");
        if (!openBtn || !evRoot.contains(openBtn)) return;
        e.preventDefault();
        openModal(openBtn.getAttribute("data-ev-open"), openBtn);
    });

    modal.addEventListener("click", (e) => {
        const closeBtn = e.target.closest("[data-ev-close]");
        if (!closeBtn) return;
        e.preventDefault();
        closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (!modal.classList.contains("is-open")) return;

        // jaga-jaga kalau ada modal lain di page (kamu punya rdsMobileModal)
        const rdsDialog = document.getElementById("rdsMobileModal");
        if (rdsDialog && (rdsDialog.open || rdsDialog.hasAttribute("open")))
            return;

        if (e.key === "Escape") {
            e.preventDefault();
            closeModal();
            return;
        }

        if (e.key === "Tab") {
            const focusable = modal.querySelectorAll(
                'button, a[href], [tabindex]:not([tabindex="-1"])',
            );
            if (!focusable.length) return;
            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    });

    // ========= Init: load CMS -> override -> refresh =========
    (async () => {
        const cms = await loadCMS();
        if (cms?.data) {
            applyHeaderCMS(cms.data);

            const cmsEvents = buildEventsFromCMS(cms.data, 50);
            if (cmsEvents.length) {
                EVENTS = cmsEvents; // override only if ada item
            }
        }
        refresh();
    })();
})();

// =========================// RESOURCES // =========================
(() => {
    const section = document.getElementById("rds");
    if (!section) return;
    if (section.dataset.rdsInited === "1") return;
    section.dataset.rdsInited = "1";
    const cards = [...section.querySelectorAll("[data-rds-card]")];
    const panel = section.querySelector("[data-rds-panel]");
    const nums = [...section.querySelectorAll("[data-rds-count]")];
    const tabs = [...section.querySelectorAll(".rdsTab")];
    const panes = [...section.querySelectorAll(".rdsPane")];
    const easeOut = (t) => 1 - Math.pow(1 - t, 3);

    function setZero() {
        nums.forEach((n) => (n.textContent = "0"));
    }

    function animateNum(el, dur = 1300) {
        const target = Number(el.dataset.rdsCount || 0);
        let t0 = null;
        const tick = (ts) => {
            if (!t0) t0 = ts;
            const p = Math.min(1, (ts - t0) / dur);
            const v = Math.round(target * easeOut(p));
            el.textContent = v.toLocaleString("en-US");
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    }

    function reveal() {
        cards.forEach((c, i) =>
            setTimeout(() => c.classList.add("is-in"), i * 80),
        );
        if (panel) setTimeout(() => panel.classList.add("is-in"), 220);
    }

    function play() {
        cards.forEach((c) => c.classList.remove("is-in"));
        if (panel) panel.classList.remove("is-in");
        setZero();
        reveal();
        nums.forEach((el, i) =>
            setTimeout(() => animateNum(el), 140 + i * 120),
        );
    }
    section._rdsPlay = play;
    section._rdsSetZero = setZero;
    section._rdsDataReady = false;

    function activate(name) {
        tabs.forEach((t) => {
            const on = t.dataset.rdsTab === name;
            t.classList.toggle("is-active", on);
            t.setAttribute("aria-selected", on ? "true" : "false");
        });
        panes.forEach((p) => {
            const on = p.dataset.rdsPane === name;
            p.classList.toggle("is-active", on);
            p.hidden = !on;
        });
        const pane = panes.find((p) => p.dataset.rdsPane === name);
        if (pane) {
            pane.classList.remove("is-active");
            void pane.offsetWidth;
            pane.classList.add("is-active");
        }
    }
    tabs.forEach((btn) =>
        btn.addEventListener("click", () => activate(btn.dataset.rdsTab)),
    );
    section.querySelector(".rdsTabs")?.addEventListener("keydown", (e) => {
        if (e.key !== "ArrowRight" && e.key !== "ArrowLeft") return;
        const i = tabs.findIndex((t) => t.classList.contains("is-active"));
        if (i < 0) return;
        e.preventDefault();
        const next =
            e.key === "ArrowRight"
                ? (i + 1) % tabs.length
                : (i - 1 + tabs.length) % tabs.length;
        tabs[next].focus();
        activate(tabs[next].dataset.rdsTab);
    });
    activate("atlet");
    let prevTop = null;
    let rearm = true;
    let playedOnce = false;
    const io = new IntersectionObserver(
        ([entry]) => {
            const top = entry.boundingClientRect.top;
            const goingDown = prevTop !== null ? top < prevTop : true;
            const goingUp = prevTop !== null ? top > prevTop : false;
            prevTop = top;
            if (entry.isIntersecting) {
                if (goingDown && rearm && entry.intersectionRatio >= 0.3) {
                    play();
                    playedOnce = true;
                    rearm = false;
                } else if (playedOnce) {
                    cards.forEach((c) => c.classList.add("is-in"));
                    if (panel) panel.classList.add("is-in");
                }
                return;
            }
            if (goingUp) {
                rearm = true;
                playedOnce = false;
                cards.forEach((c) => c.classList.remove("is-in"));
                if (panel) panel.classList.remove("is-in");
                if (!section._rdsDataReady) setZero();
            }
        },
        {
            threshold: [0, 0.3, 0.55],
        },
    );
    io.observe(section);
})();
(function () {
    const rdsRoot = document.querySelector("#rds");
    if (!rdsRoot) return;
    const modal = document.getElementById("rdsMobileModal");
    const modalBody = document.getElementById("rdsModalBody");
    const modalTitle = document.getElementById("rdsModalTitle");
    const modalSub = document.getElementById("rdsModalSub");
    if (!modal || !modalBody || !modalTitle || !modalSub) return;
    const mq = window.matchMedia("(max-width:560px)");

    function getActivePane() {
        return (
            rdsRoot.querySelector(".rdsPane.is-active") ||
            rdsRoot.querySelector(".rdsPane")
        );
    }

    function openTableMobile() {
        if (!mq.matches) return;
        const pane = getActivePane();
        if (!pane) return;
        const titleEl = pane.querySelector(".rdsPane__title");
        const metaEl = pane.querySelector(".rdsPane__meta");
        const wrap = pane.querySelector(".rdsTableWrap");
        modalTitle.textContent = titleEl ? titleEl.textContent.trim() : "Tabel";
        modalSub.textContent = metaEl
            ? metaEl.textContent.trim()
            : "Spreadsheet";
        modalBody.innerHTML = "";
        if (wrap) {
            const clone = wrap.cloneNode(true);
            clone.style.display = "block";
            modalBody.appendChild(clone);
        } else {
            modalBody.innerHTML = `<div style="padding:12px;font-weight:900;color:#111;">Tidak ada tabel.</div>`;
        }
        if (typeof modal.showModal === "function") modal.showModal();
        else modal.setAttribute("open", "open");
    }

    function closeTableMobile() {
        modalBody.innerHTML = "";
        if (typeof modal.close === "function") modal.close();
        else modal.removeAttribute("open");
    }
    rdsRoot.addEventListener("click", (e) => {
        const openBtn = e.target.closest("[data-rds-open-table]");
        if (openBtn && rdsRoot.contains(openBtn)) openTableMobile();
        const closeBtn = e.target.closest("[data-rds-close-table]");
        if (closeBtn && rdsRoot.contains(closeBtn)) closeTableMobile();
    });
    modal.addEventListener("click", (e) => {
        const sheet = modal.querySelector(".rdsModal__sheet");
        if (!sheet) return;
        if (!sheet.contains(e.target)) closeTableMobile();
    });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.hasAttribute("open"))
            closeTableMobile();
    });
    mq.addEventListener?.("change", (ev) => {
        if (!ev.matches) closeTableMobile();
    });
})();
/* =====================================================
   RDS: AUTO UPDATE FROM GOOGLE SHEETS (Sheet: "Tabel")
===================================================== */
(function () {
    const section = document.getElementById("rds");
    if (!section) return;
    const SPREADSHEET_ID = "1PNHq5tj_xQFeia2UQMZ1OpUa7NFEKBUtjoG9Hf-d4IA";
    const SHEET_NAME = "Tabel";
    const GVIZ_QUERY = "select B,C,D,E,F,G,H,I,J where B is not null";
    const TAB_TO_KEY = {
        atlet: "atlet",
        pelatih: "pelatih",
        pelatihgk: "pelatihGK",
        td: "td",
        manajemen: "manajemen",
        wasit: "wasit",
        delegates: "delegates",
        volunteer: "volunteer",
    };

    function gvizUrl() {
        const tq = encodeURIComponent(GVIZ_QUERY);
        return `https://docs.google.com/spreadsheets/d/${SPREADSHEET_ID}/gviz/tq?tqx=out:json&sheet=${encodeURIComponent(
            SHEET_NAME,
        )}&tq=${tq}`;
    }
    async function fetchGviz() {
        const res = await fetch(gvizUrl(), {
            cache: "no-store",
        });
        if (!res.ok) throw new Error(`Fetch failed: ${res.status}`);
        const text = await res.text();
        const m = text.match(
            /google\.visualization\.Query\.setResponse\(([\s\S]*?)\);\s*$/,
        );
        if (!m)
            throw new Error(
                "GVIZ not setResponse() (sheet not public / got HTML)",
            );
        return JSON.parse(m[1]);
    }

    function numCell(cell) {
        if (!cell) return 0;
        const raw = cell.v ?? cell.f ?? "";
        if (typeof raw === "number" && Number.isFinite(raw)) return raw;
        const s = String(raw).trim();
        if (!s) return 0;
        const cleaned = s.replace(/[^\d.,-]/g, "");
        const normalized =
            cleaned.includes(",") && !cleaned.includes(".")
                ? cleaned.replace(",", ".")
                : cleaned.replace(/,/g, "");
        const n = Number(normalized);
        return Number.isFinite(n) ? n : 0;
    }

    function parseRows(gvizJson) {
        const rows = gvizJson?.table?.rows || [];
        const out = [];
        for (const r of rows) {
            const c = r.c || [];
            const wilayah = c[0]?.v ? String(c[0].v).trim() : "";
            if (!wilayah) continue;
            if (wilayah.toLowerCase() === "wilayah") continue;
            out.push({
                wilayah,
                atlet: numCell(c[1]),
                pelatih: numCell(c[2]),
                pelatihGK: numCell(c[3]),
                td: numCell(c[4]),
                manajemen: numCell(c[5]),
                wasit: numCell(c[6]),
                delegates: numCell(c[7]),
                volunteer: numCell(c[8]),
            });
        }
        return out;
    }

    function sum(data, key) {
        return data.reduce((acc, row) => acc + (row[key] || 0), 0);
    }

    function setOverviewCounts(data) {
        const ovEls = [
            ...section.querySelectorAll(".rds__ov .rds__value[data-rds-count]"),
        ];
        if (ovEls.length < 4) return;
        const atletTotal = sum(data, "atlet");
        const coachingTotal =
            sum(data, "pelatih") + sum(data, "pelatihGK") + sum(data, "td");
        const officialsTotal = sum(data, "wasit") + sum(data, "delegates");
        const opsTotal = sum(data, "manajemen") + sum(data, "volunteer");
        const values = [atletTotal, coachingTotal, officialsTotal, opsTotal];
        ovEls.forEach((el, i) => {
            el.dataset.rdsCount = String(values[i] ?? 0);
        });
    }

    function statusBadge(value) {
        if (value > 0) return `<span class="rdsBadge ok">Aktif</span>`;
        return `<span class="rdsBadge warn">Perlu Update</span>`;
    }

    function escapeHtml(str) {
        return String(str)
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function renderPaneTable(paneName, key, data) {
        const pane = section.querySelector(
            `.rdsPane[data-rds-pane="${paneName}"]`,
        );
        if (!pane) return;
        const tbody = pane.querySelector("tbody");
        if (!tbody) return;
        tbody.innerHTML = data
            .map((row) => {
                const v = row[key] ?? 0;
                return `
          <tr>
            <td>${escapeHtml(row.wilayah)}</td>
            <td>${Number(v).toLocaleString("en-US")}</td>
            <td>${statusBadge(v)}</td>
          </tr>
        `.trim();
            })
            .join("");
    }
    async function initSpreadsheetSync() {
        try {
            const hint = section.querySelector(".rds__hint");
            if (hint) hint.style.opacity = "0.85";
            const gviz = await fetchGviz();
            const data = parseRows(gviz);
            setOverviewCounts(data);
            Object.entries(TAB_TO_KEY).forEach(([paneName, key]) => {
                renderPaneTable(paneName, key, data);
            });
            section._rdsDataReady = true;
            const visibleNow =
                section.getBoundingClientRect().top < window.innerHeight * 0.85;
            if (visibleNow && typeof section._rdsPlay === "function") {
                section._rdsPlay();
            } else {
                const numsNow = [
                    ...section.querySelectorAll("[data-rds-count]"),
                ];
                numsNow.forEach((el) => {
                    const target = Number(el.dataset.rdsCount || 0);
                    el.textContent = target.toLocaleString("en-US");
                });
            }
            if (hint) hint.style.opacity = "1";
        } catch (err) {
            console.error("[RDS] Spreadsheet sync failed:", err);
            const hint = section.querySelector(".rds__hint");
            if (hint)
                hint.innerHTML = `<span class="rds__dot"></span> Spreadsheet error`;
        }
    }
    initSpreadsheetSync();
})();
// =========================
// PROFILE (CMS-READY)
// =========================
(function () {
    "use strict";
    if (window.__PROFILE_V2_INIT__) return;
    window.__PROFILE_V2_INIT__ = true;

    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
    const mod = (n, m) => ((n % m) + m) % m;

    function escapeHtml(str) {
        return String(str)
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    // -------------------------------------
    // CMS fetch + parsing helpers
    // -------------------------------------
    async function fetchJson(url, timeoutMs = 7000) {
        const ctrl = new AbortController();
        const t = window.setTimeout(() => ctrl.abort(), timeoutMs);
        try {
            // cache-buster biar gak ke-cache browser/proxy
            const u = url + (url.includes("?") ? "&" : "?") + "v=" + Date.now();
            const res = await fetch(u, {
                signal: ctrl.signal,
                credentials: "same-origin",
            });
            if (!res.ok) throw new Error("HTTP " + res.status);
            return await res.json();
        } finally {
            window.clearTimeout(t);
        }
    }

    function cleanStr(v) {
        const s = v == null ? "" : String(v);
        const trimmed = s.trim();
        return trimmed;
    }

    function hasValue(v) {
        return cleanStr(v) !== "";
    }

    // CMS keys -> structured data
    // expects flat map: { "clubs.items.1.name": "...", ... }
    function parseClubsCMS(map) {
        if (!map || typeof map !== "object") return null;

        // Header
        const header = {
            title_black: cleanStr(map["clubs.header.title_black"]),
            title_red: cleanStr(map["clubs.header.title_red"]),
            subtitle: cleanStr(map["clubs.header.subtitle"]),
        };

        // Slides: indoor/beach 1..10
        function collectSlides(prefix) {
            const out = [];
            for (let i = 1; i <= 10; i++) {
                const title = cleanStr(map[`clubs.${prefix}.${i}.title`]);
                const desc = cleanStr(map[`clubs.${prefix}.${i}.desc`]);
                const img = cleanStr(map[`clubs.${prefix}.${i}.img`]);

                // rule: minimal harus ada img atau title biar dianggap "diisi"
                if (!hasValue(title) && !hasValue(desc) && !hasValue(img))
                    continue;

                out.push({
                    kicker: prefix === "indoor" ? "INDOOR TEAM" : "BEACH TEAM",
                    title:
                        title ||
                        (prefix === "indoor"
                            ? `Program Indoor Slide ${i}`
                            : `Program Beach Slide ${i}`),
                    desc: desc || "",
                    image: img || "", // nanti fallback kalau kosong
                    fit: "cover",
                    pos: "50% 50%",
                    bgColor: "#0f1117",
                });
            }
            return out;
        }

        const indoor = collectSlides("indoor");
        const beach = collectSlides("beach");

        // Clubs items 1..100
        const clubs = [];
        for (let i = 1; i <= 100; i++) {
            const name = cleanStr(map[`clubs.items.${i}.name`]);
            const city = cleanStr(map[`clubs.items.${i}.city`]);
            const logo = cleanStr(map[`clubs.items.${i}.logo`]);

            const director = cleanStr(map[`clubs.items.${i}.director`]);
            const admin = cleanStr(map[`clubs.items.${i}.admin`]);
            const tech = cleanStr(map[`clubs.items.${i}.tech`]);
            const venue = cleanStr(map[`clubs.items.${i}.venue`]);
            const email = cleanStr(map[`clubs.items.${i}.email`]);
            const contact = cleanStr(map[`clubs.items.${i}.contact`]);
            const link = cleanStr(map[`clubs.items.${i}.link`]);

            // rule: club dianggap ada kalau minimal ada name atau city atau logo (biar fleksibel)
            if (!hasValue(name) && !hasValue(city) && !hasValue(logo)) continue;

            clubs.push({
                id: `club-${String(i).padStart(3, "0")}`,
                logo: logo || "", // nanti fallback
                name: name || `Club ${String(i).padStart(2, "0")}`,
                city: city || "-",
                director: director || "-",
                admin: admin || "-",
                techDirector: tech || "-",
                venue: venue || "-",
                email: email || "",
                contact: contact || "-",
                link: link || "#",
            });
        }

        const anyHeader =
            hasValue(header.title_black) ||
            hasValue(header.title_red) ||
            hasValue(header.subtitle);
        const anySlides = indoor.length > 0 || beach.length > 0;
        const anyClubs = clubs.length > 0;

        // Kalau semuanya kosong, anggap CMS belum dipakai
        if (!anyHeader && !anySlides && !anyClubs) return null;

        return {
            header,
            indoor,
            beach,
            clubs,
        };
    }

    function setHeaderFromCMS(header) {
        if (!header) return;

        const blackEl = $(".page-header__title-black");
        const redEl = $(".page-header__title-red");
        const subEl = $(".page-header__subtitle");

        if (blackEl && hasValue(header.title_black))
            blackEl.textContent = header.title_black;
        if (redEl && hasValue(header.title_red))
            redEl.textContent = header.title_red;

        // subtitle di DB pakai <br> -> tampilkan sebagai HTML
        if (subEl && hasValue(header.subtitle)) {
            subEl.innerHTML = header.subtitle; // admin-only input (dari CMS). sesuai pola kamu di page lain.
        }
    }

    // -------------------------------------
    // HERO (virtual 3 slides)
    // -------------------------------------
    function initHeroVirtual(sliderEl, slidesData, opts) {
        if (!sliderEl) return;
        const track = $("[data-hero-track]", sliderEl);
        const dotsWrap = $("[data-hero-dots]", sliderEl);
        if (!track || !Array.isArray(slidesData) || slidesData.length < 2)
            return;

        const reduceMotion = window.matchMedia(
            "(prefers-reduced-motion: reduce)",
        ).matches;
        const intervalMs = (opts && opts.intervalMs) || 4500;

        let idx = 0;
        let timer = null;
        let busy = false;

        if (dotsWrap) {
            dotsWrap.innerHTML = "";
            slidesData.forEach((_, i) => {
                const b = document.createElement("button");
                b.type = "button";
                b.className = "hero__dot";
                b.setAttribute("aria-label", `Go to slide ${i + 1}`);
                b.setAttribute("aria-current", i === idx ? "true" : "false");
                b.addEventListener("click", () => {
                    if (busy) return;
                    idx = i;
                    render3();
                    restart();
                });
                dotsWrap.appendChild(b);
            });
        }

        function setDots() {
            if (!dotsWrap) return;
            const dots = $$(".hero__dot", dotsWrap);
            dots.forEach((d, i) =>
                d.setAttribute("aria-current", i === idx ? "true" : "false"),
            );
        }

        function slideHTML(item) {
            const src = item.image;
            const fit = item.fit || "contain";
            const pos = item.pos || "50% 50%";
            const bg = item.bgColor || "#0f1117";
            return `
        <div class="hero__slide" style="background-color:${bg};">
          <img class="hero__img" src="${src}" alt="" loading="lazy"
               style="object-fit:${fit}; object-position:${pos};" />
          <div class="hero__content">
            <div class="hero__text">
              <p class="hero__kicker">${escapeHtml(item.kicker)}</p>
              <h4 class="hero__title">${escapeHtml(item.title)}</h4>
              <p class="hero__desc">${escapeHtml(item.desc)}</p>
            </div>
          </div>
        </div>
      `;
        }

        function render3() {
            const prev = slidesData[mod(idx - 1, slidesData.length)];
            const cur = slidesData[idx];
            const next = slidesData[mod(idx + 1, slidesData.length)];

            track.style.transition = "none";
            track.innerHTML =
                slideHTML(prev) + slideHTML(cur) + slideHTML(next);
            track.style.transform = "translate3d(-100%,0,0)";

            void track.offsetHeight;
            track.style.transition = "";

            setDots();
        }

        function goNext() {
            if (busy) return;
            busy = true;
            track.style.transform = "translate3d(-200%,0,0)";
            const onEnd = () => {
                idx = mod(idx + 1, slidesData.length);
                render3();
                busy = false;
            };
            track.addEventListener("transitionend", onEnd, {
                once: true,
            });
        }

        function goPrev() {
            if (busy) return;
            busy = true;
            track.style.transform = "translate3d(0%,0,0)";
            const onEnd = () => {
                idx = mod(idx - 1, slidesData.length);
                render3();
                busy = false;
            };
            track.addEventListener("transitionend", onEnd, {
                once: true,
            });
        }

        function start() {
            if (reduceMotion) return;
            stop();
            timer = window.setInterval(goNext, intervalMs);
        }

        function stop() {
            if (timer) window.clearInterval(timer);
            timer = null;
        }

        function restart() {
            stop();
            start();
        }

        sliderEl.addEventListener("mouseenter", stop);
        sliderEl.addEventListener("mouseleave", start);
        sliderEl.addEventListener("focusin", stop);
        sliderEl.addEventListener("focusout", start);

        let startX = 0;
        let dragging = false;

        sliderEl.addEventListener("pointerdown", (e) => {
            dragging = true;
            startX = e.clientX;
            sliderEl.setPointerCapture?.(e.pointerId);
            stop();
        });

        sliderEl.addEventListener("pointerup", (e) => {
            if (!dragging) return;
            dragging = false;
            const dx = e.clientX - startX;
            const threshold = 45;
            if (dx < -threshold) goNext();
            else if (dx > threshold) goPrev();
            start();
        });

        sliderEl.addEventListener("pointercancel", () => {
            dragging = false;
            start();
        });

        render3();
        start();
    }

    /* --------------------------
       CLUBS: search/filter + drawer
       custom dropdown + pagination (16/page)
       UPDATED: accepts clubsData (from CMS or fallback)
    --------------------------- */
    function initClubs(clubsData, fallbackLogo) {
        const section = document.getElementById("profile");
        if (!section) return;

        const grid = $("[data-clubs-grid]", section);
        const searchInput = $("[data-club-search]", section);

        const cselect = $("[data-city-select]", section);
        const cityBtn = $("[data-city-btn]", section);
        const cityPanel = $("[data-city-panel]", section);
        const cityLabel = $("[data-city-label]", section);

        const pager = $("[data-clubs-pager]", section);
        const pageNums = $("[data-page-nums]", section);
        const pagePrev = $("[data-page-prev]", section);
        const pageNext = $("[data-page-next]", section);

        const drawer = $("[data-drawer]", section);

        if (
            !grid ||
            !drawer ||
            !cselect ||
            !cityBtn ||
            !cityPanel ||
            !cityLabel
        )
            return;

        const pagerEnabled = !!(pager && pageNums && pagePrev && pageNext);

        const closeEls = $$("[data-drawer-close]", drawer);
        const logoEl = $("[data-drawer-logo]", drawer);
        const nameEl = $("[data-drawer-name]", drawer);
        const cityEl = $("[data-drawer-city]", drawer);
        const directorEl = $("[data-drawer-director]", drawer);
        const adminEl = $("[data-drawer-admin]", drawer);
        const techEl = $("[data-drawer-tech]", drawer);
        const venueEl = $("[data-drawer-venue]", drawer);
        const emailEl = $("[data-drawer-email]", drawer);
        const contactEl = $("[data-drawer-contact]", drawer);
        const linkEl = $("[data-drawer-link]", drawer);

        const PAGE_SIZE = 16;

        // normalize clubs (ensure logo fallback)
        const clubs = (Array.isArray(clubsData) ? clubsData : []).map(
            (c, idx) => ({
                id: c.id || `club-${String(idx + 1).padStart(3, "0")}`,
                logo: c.logo && String(c.logo).trim() ? c.logo : fallbackLogo,
                name: c.name || `Club ${String(idx + 1).padStart(2, "0")}`,
                city: c.city || "-",
                director: c.director || "-",
                admin: c.admin || "-",
                techDirector: c.techDirector || "-",
                venue: c.venue || "-",
                email: c.email || "",
                contact: c.contact || "-",
                link: c.link || "#",
            }),
        );

        const ALL_CITIES = Array.from(
            new Set(clubs.map((c) => c.city).filter(Boolean)),
        ).sort((a, b) => a.localeCompare(b));

        let selectedCity = "";
        let filtered = [...clubs];
        let currentPage = 1;

        function openDrawer(club) {
            if (logoEl) {
                logoEl.src = club.logo;
                logoEl.alt = `${club.name} logo`;
            }
            if (nameEl) nameEl.textContent = club.name;
            if (cityEl) cityEl.textContent = club.city;
            if (directorEl) directorEl.textContent = club.director || "-";
            if (adminEl) adminEl.textContent = club.admin || "-";
            if (techEl) techEl.textContent = club.techDirector || "-";
            if (venueEl) venueEl.textContent = club.venue || "-";
            if (contactEl) contactEl.textContent = club.contact || "-";

            if (emailEl) {
                const email = club.email || "";
                emailEl.textContent = email || "-";
                emailEl.href = email ? `mailto:${email}` : "#";
            }

            if (linkEl) {
                const link = club.link || "";
                linkEl.textContent = link && link !== "#" ? "Open link" : "-";
                linkEl.href = link || "#";
            }

            drawer.classList.add("is-open");
            drawer.setAttribute("aria-hidden", "false");
            document.documentElement.style.overflow = "hidden";
            const closeBtn = $("[data-drawer-close]", drawer);
            closeBtn?.focus?.();
        }

        function closeDrawer() {
            drawer.classList.remove("is-open");
            drawer.setAttribute("aria-hidden", "true");
            document.documentElement.style.overflow = "";
        }

        closeEls.forEach((el) => el.addEventListener("click", closeDrawer));
        const backdrop = $(".drawer__backdrop", drawer);
        backdrop?.addEventListener("click", closeDrawer);

        function openSelect() {
            cselect.classList.add("is-open");
            cityBtn.setAttribute("aria-expanded", "true");
        }

        function closeSelect() {
            cselect.classList.remove("is-open");
            cityBtn.setAttribute("aria-expanded", "false");
        }

        function toggleSelect() {
            if (cselect.classList.contains("is-open")) closeSelect();
            else openSelect();
        }

        cityBtn.addEventListener("click", toggleSelect);

        document.addEventListener("click", (e) => {
            if (!cselect.contains(e.target)) closeSelect();
        });

        document.addEventListener("keydown", (e) => {
            if (e.key !== "Escape") return;
            if (drawer.classList.contains("is-open")) closeDrawer();
            if (cselect.classList.contains("is-open")) closeSelect();
        });

        function countByCity(cityValue) {
            const q = (searchInput?.value || "").trim().toLowerCase();
            return clubs.filter((c) => {
                const matchQ =
                    !q ||
                    c.name.toLowerCase().includes(q) ||
                    c.city.toLowerCase().includes(q);
                const matchCity = !cityValue || c.city === cityValue;
                return matchQ && matchCity;
            }).length;
        }

        function cityOptionEl(label, value, count) {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "cselect__opt";
            btn.setAttribute("role", "option");
            btn.setAttribute("data-city-value", value);
            btn.setAttribute(
                "aria-selected",
                value === selectedCity ? "true" : "false",
            );
            btn.innerHTML = `
        <span>${escapeHtml(label)}</span>
        <span class="cselect__count" data-city-count>${count}</span>
      `;
            btn.addEventListener("click", () => {
                selectedCity = value;
                cityLabel.textContent = value ? value : "Semua kota/kab.";
                closeSelect();
                applyFilters();
            });
            return btn;
        }

        function renderCityOptions() {
            cityPanel.innerHTML = "";
            cityPanel.appendChild(
                cityOptionEl("Semua kota/kab.", "", countByCity("")),
            );
            ALL_CITIES.forEach((city) => {
                cityPanel.appendChild(
                    cityOptionEl(city, city, countByCity(city)),
                );
            });
        }

        function updateCityCounts() {
            const opts = $$("[data-city-value]", cityPanel);
            opts.forEach((opt) => {
                const val = opt.getAttribute("data-city-value") || "";
                const cnt = countByCity(val);
                const countEl = $("[data-city-count]", opt);
                if (countEl) countEl.textContent = String(cnt);
                opt.setAttribute(
                    "aria-selected",
                    val === selectedCity ? "true" : "false",
                );
            });
        }

        function totalPagesFor(list) {
            return Math.max(1, Math.ceil(list.length / PAGE_SIZE));
        }

        function renderPager(totalPages) {
            if (!pagerEnabled) return;
            pager.style.display = totalPages > 1 ? "flex" : "none";
            pagePrev.disabled = currentPage <= 1;
            pageNext.disabled = currentPage >= totalPages;

            const items = [];
            const push = (v) => items.push(v);
            push(1);

            const left = Math.max(2, currentPage - 2);
            const right = Math.min(totalPages - 1, currentPage + 2);

            if (left > 2) push("sep");
            for (let p = left; p <= right; p++) push(p);
            if (right < totalPages - 1) push("sep");
            if (totalPages > 1) push(totalPages);

            pageNums.innerHTML = "";
            items.forEach((it) => {
                if (it === "sep") {
                    const sep = document.createElement("span");
                    sep.className = "pager__sep";
                    sep.textContent = "…";
                    pageNums.appendChild(sep);
                    return;
                }
                const b = document.createElement("button");
                b.type = "button";
                b.className =
                    "pager__num" + (it === currentPage ? " is-active" : "");
                b.textContent = String(it);
                b.setAttribute("aria-label", `Page ${it}`);
                b.addEventListener("click", () => {
                    currentPage = it;
                    renderGridPaged(filtered);
                    pager.scrollIntoView({
                        behavior: "smooth",
                        block: "nearest",
                    });
                });
                pageNums.appendChild(b);
            });
        }

        if (pagerEnabled) {
            pagePrev.addEventListener("click", () => {
                currentPage = Math.max(1, currentPage - 1);
                renderGridPaged(filtered);
                pager.scrollIntoView({
                    behavior: "smooth",
                    block: "nearest",
                });
            });
            pageNext.addEventListener("click", () => {
                const tp = totalPagesFor(filtered);
                currentPage = Math.min(tp, currentPage + 1);
                renderGridPaged(filtered);
                pager.scrollIntoView({
                    behavior: "smooth",
                    block: "nearest",
                });
            });
        }

        function clubCardEl(club) {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "club";
            btn.setAttribute("data-club-id", club.id);
            btn.setAttribute("aria-label", `Open details for ${club.name}`);
            btn.innerHTML = `
        <img class="club__logo" src="${club.logo}" alt="${escapeHtml(club.name)} logo" loading="lazy"/>
        <div>
          <p class="club__name">${escapeHtml(club.name)}</p>
          <p class="club__city">${escapeHtml(club.city)}</p>
        </div>
      `;
            btn.addEventListener("click", () => openDrawer(club));
            return btn;
        }

        function renderGridPaged(list) {
            grid.innerHTML = "";
            const frag = document.createDocumentFragment();

            if (!pagerEnabled) {
                list.forEach((club) => frag.appendChild(clubCardEl(club)));
                grid.appendChild(frag);
                return;
            }

            const totalPages = totalPagesFor(list);
            currentPage = Math.min(currentPage, totalPages);

            const start = (currentPage - 1) * PAGE_SIZE;
            const pageItems = list.slice(start, start + PAGE_SIZE);

            pageItems.forEach((club) => frag.appendChild(clubCardEl(club)));
            grid.appendChild(frag);

            renderPager(totalPages);
        }

        function applyFilters() {
            const q = (searchInput?.value || "").trim().toLowerCase();
            filtered = clubs.filter((c) => {
                const matchQ =
                    !q ||
                    c.name.toLowerCase().includes(q) ||
                    c.city.toLowerCase().includes(q);

                const matchCity = !selectedCity || c.city === selectedCity;
                return matchQ && matchCity;
            });

            currentPage = 1;
            updateCityCounts();
            renderGridPaged(filtered);
        }

        searchInput?.addEventListener("input", applyFilters);

        renderCityOptions();
        updateCityCounts();
        renderGridPaged(filtered);
    }

    // -------------------------------------
    // Main init (now CMS-aware)
    // -------------------------------------
    async function initProfile() {
        const section = document.getElementById("profile");
        if (!section) return;

        // fallback data (your old defaults)
        const heroimg = "img/evsection.avif";
        const fallbackLogo = "img/mainlogo.avif";

        // Build fallback slides (your old dummy)
        const fallbackIndoorSlides = Array.from(
            {
                length: 8,
            },
            (_, i) => ({
                kicker: "INDOOR TEAM",
                title: `Program Indoor Slide ${i + 1}`,
                desc: "Narasi singkat untuk menjelaskan fokus program, agenda, dan standar pembinaan.",
                image: heroimg,
                fit: "cover",
                pos: "50% 50%",
                bgColor: "#0f1117",
            }),
        );

        const fallbackBeachSlides = Array.from(
            {
                length: 8,
            },
            (_, i) => ({
                kicker: "BEACH TEAM",
                title: `Program Beach Slide ${i + 1}`,
                desc: "Narasi singkat untuk menjelaskan adaptasi, endurance, dan karakter permainan.",
                image: heroimg,
                fit: "cover",
                pos: "50% 50%",
                bgColor: "#0f1117",
            }),
        );

        // Build fallback clubs (your old dummy 20)
        const cities = [
            "Kota Bandung",
            "Kota Surabaya",
            "Kota Jakarta",
            "Kab. Badung",
            "Kab. Sleman",
            "Kota Makassar",
            "Kab. Bantul",
            "Kota Medan",
        ];

        const fallbackClubs = Array.from(
            {
                length: 20,
            },
            (_, i) => {
                const n = i + 1;
                const city = cities[i % cities.length];
                return {
                    id: `club-${String(n).padStart(2, "0")}`,
                    logo: fallbackLogo,
                    name: `Club ${String(n).padStart(2, "0")}`,
                    city,
                    director: `Direktur Club ${n}`,
                    admin: `Administrator Club ${n}`,
                    techDirector: `Direktur Teknik Club ${n}`,
                    venue: `Venue Latihan ${n}, ${city}`,
                    email: `club${String(n).padStart(2, "0")}@example.com`,
                    contact: `+62 81${String(20000000 + n * 173).padStart(8, "0")}`,
                    link: "#",
                };
            },
        );

        // 1) Load CMS if available
        let cms = null;
        try {
            const raw = await fetchJson("/api/get.php?page=clubs");
            cms = parseClubsCMS(raw);
        } catch (e) {
            // silent fallback
            cms = null;
        }

        // 2) Apply header override (outside #profile too)
        if (cms && cms.header) {
            setHeaderFromCMS(cms.header);
        }

        // 3) Determine slides (CMS if provided, else fallback)
        let indoorSlides = fallbackIndoorSlides;
        let beachSlides = fallbackBeachSlides;

        if (cms && Array.isArray(cms.indoor) && cms.indoor.length >= 2) {
            // ensure image fallback if admin only fills text
            indoorSlides = cms.indoor.map((s, idx) => ({
                ...s,
                image: hasValue(s.image) ? s.image : heroimg,
                title: hasValue(s.title)
                    ? s.title
                    : `Program Indoor Slide ${idx + 1}`,
                desc: s.desc || "",
            }));
        }

        if (cms && Array.isArray(cms.beach) && cms.beach.length >= 2) {
            beachSlides = cms.beach.map((s, idx) => ({
                ...s,
                image: hasValue(s.image) ? s.image : heroimg,
                title: hasValue(s.title)
                    ? s.title
                    : `Program Beach Slide ${idx + 1}`,
                desc: s.desc || "",
            }));
        }

        // 4) Init sliders
        const indoorEl = section.querySelector('[data-hero="indoor"]');
        const beachEl = section.querySelector('[data-hero="beach"]');

        initHeroVirtual(indoorEl, indoorSlides, {
            intervalMs: 4300,
        });
        initHeroVirtual(beachEl, beachSlides, {
            intervalMs: 4700,
        });

        // 5) Determine clubs list (CMS if provided, else fallback)
        const clubsList =
            cms && Array.isArray(cms.clubs) && cms.clubs.length > 0
                ? cms.clubs
                : fallbackClubs;

        initClubs(clubsList, fallbackLogo);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initProfile);
    } else {
        initProfile();
    }
})();

/* ===== GALLERY =====*/
(function () {
    var roots = document.querySelectorAll("[data-ihf-gallery]");
    if (!roots || !roots.length) return;
    if (!window.__IHF_GALLERY_KEYBINDS__) {
        window.__IHF_GALLERY_KEYBINDS__ = true;
        document.addEventListener("keydown", function (e) {
            var openGallery = document.querySelector(
                "[data-ihf-gallery] [data-gallery]:not([hidden])",
            );
            if (!openGallery) return;
            var root = openGallery.closest("[data-ihf-gallery]");
            if (!root || !root.__ihfApi) return;
            if (e.key === "Escape") {
                root.__ihfApi.close();
                return;
            }
            if (e.key === "ArrowLeft") {
                root.__ihfApi.prev();
                return;
            }
            if (e.key === "ArrowRight") {
                root.__ihfApi.next();
                return;
            }
        });
    }

    function init(root) {
        if (!root || root.dataset.ihfInited === "1") return;
        root.dataset.ihfInited = "1";
        var cardTrack = root.querySelector("[data-card-track]");
        var btnPrevCards = root.querySelector("[data-card-prev]");
        var btnNextCards = root.querySelector("[data-card-next]");
        var gallery = root.querySelector("[data-gallery]");
        var closeBtn = root.querySelector("[data-gallery-close]");
        var titleEl = root.querySelector("[data-gallery-title]");
        var dateEl = root.querySelector("[data-gallery-date]");
        var stageimg = root.querySelector("[data-stage-img]");
        var stageLoad = root.querySelector("[data-stage-load]");
        var thumbsWrap = root.querySelector("[data-thumbs]");
        var btnPrevPhoto = root.querySelector("[data-stage-prev]");
        var btnNextPhoto = root.querySelector("[data-stage-next]");
        if (!cardTrack || !gallery || !stageimg || !thumbsWrap) return;
        var state = {
            images: [],
            index: 0,
            activeCard: null,
        };

        function getCardStep() {
            var first = cardTrack.querySelector(".ihf-card");
            if (!first)
                return Math.max(240, Math.floor(cardTrack.clientWidth * 0.9));
            var cs = window.getComputedStyle(cardTrack);
            var gap = parseFloat(cs.columnGap || cs.gap || "0") || 0;
            var w = first.getBoundingClientRect().width;
            return Math.max(240, Math.floor(w + gap));
        }

        function safeParseImages(json) {
            try {
                var arr = JSON.parse(json || "[]");
                return Array.isArray(arr) ? arr : [];
            } catch (e) {
                return [];
            }
        }

        function setLoading(on) {
            if (!stageLoad) return;
            stageLoad.classList.toggle("is-on", !!on);
        }

        function preload(src) {
            return new Promise(function (resolve, reject) {
                var im = new Image();
                im.onload = function () {
                    resolve(src);
                };
                im.onerror = reject;
                im.src = src;
            });
        }

        function scrollCards(dir) {
            var step = getCardStep();
            var maxScroll = cardTrack.scrollWidth - cardTrack.clientWidth;
            var left = cardTrack.scrollLeft;
            var EPS = 2;
            if (maxScroll <= 0) return;
            if (dir > 0) {
                if (left >= maxScroll - EPS) {
                    cardTrack.scrollTo({
                        left: 0,
                        behavior: "smooth",
                    });
                    return;
                }
            } else {
                if (left <= EPS) {
                    cardTrack.scrollTo({
                        left: maxScroll,
                        behavior: "smooth",
                    });
                    return;
                }
            }
            cardTrack.scrollBy({
                left: dir * step,
                behavior: "smooth",
            });
        }

        function updateCardNavDisabled() {
            var maxScroll = cardTrack.scrollWidth - cardTrack.clientWidth;
            var disabled = maxScroll <= 2;
            if (btnPrevCards) btnPrevCards.disabled = disabled;
            if (btnNextCards) btnNextCards.disabled = disabled;
        }

        function renderThumbs(images) {
            thumbsWrap.innerHTML = "";
            images.forEach(function (src, i) {
                var btn = document.createElement("button");
                btn.type = "button";
                btn.className =
                    "ihf-thumb" + (i === state.index ? " is-active" : "");
                btn.setAttribute("aria-label", "Open photo " + (i + 1));
                var img = document.createElement("img");
                img.loading = "lazy";
                img.alt = "Thumbnail " + (i + 1);
                img.src = src;
                btn.appendChild(img);
                btn.addEventListener("click", function () {
                    goTo(i, {
                        scrollThumbIntoView: true,
                    });
                });
                thumbsWrap.appendChild(btn);
            });
            requestAnimationFrame(layoutThumbs);
        }

        function setActiveThumb() {
            var thumbs = thumbsWrap.querySelectorAll(".ihf-thumb");
            thumbs.forEach(function (el, i) {
                el.classList.toggle("is-active", i === state.index);
            });
        }

        function scrollThumbIntoView() {
            var active = thumbsWrap.querySelector(".ihf-thumb.is-active");
            if (!active || !state.thumbW) return;
            var idx = state.index;
            var left = thumbsWrap.scrollLeft;
            var viewLeft = left;
            var viewRight = left + thumbsWrap.clientWidth;
            var itemLeft = idx * state.thumbW;
            var itemRight = itemLeft + state.thumbW;
            if (itemLeft < viewLeft) {
                thumbsWrap.scrollTo({
                    left: itemLeft,
                    behavior: "smooth",
                });
                return;
            }
            if (itemRight > viewRight) {
                var newLeft = itemRight - thumbsWrap.clientWidth;
                newLeft = Math.round(newLeft / state.thumbW) * state.thumbW;
                thumbsWrap.scrollTo({
                    left: newLeft,
                    behavior: "smooth",
                });
                return;
            }
            if (rightInside < EDGE) {
                thumbsWrap.scrollBy({
                    left: EDGE - rightInside,
                    behavior: "smooth",
                });
                return;
            }
        }

        function layoutThumbs() {
            var thumbs = thumbsWrap.querySelectorAll(".ihf-thumb");
            if (!thumbs.length) return;
            var isMobile = window.matchMedia("(max-width: 720px)").matches;
            var perView = isMobile ? 2 : 4;
            var w = Math.floor(thumbsWrap.clientWidth / perView);
            state.thumbW = w;
            thumbs.forEach(function (btn) {
                btn.style.flex = "0 0 " + w + "px";
                btn.style.width = w + "px";
            });
            snapThumbScroll();
        }

        function snapThumbScroll() {
            if (!state.thumbW) return;
            var maxScroll = thumbsWrap.scrollWidth - thumbsWrap.clientWidth;
            var s =
                Math.round(thumbsWrap.scrollLeft / state.thumbW) * state.thumbW;
            s = Math.max(0, Math.min(s, maxScroll));
            thumbsWrap.scrollLeft = s;
        }

        function goTo(nextIndex, opts) {
            if (!state.images.length) return;
            var len = state.images.length;
            var idx = ((nextIndex % len) + len) % len;
            state.index = idx;
            var src = state.images[idx];
            setLoading(true);
            stageimg.classList.remove("is-ready");
            preload(src)
                .then(function () {
                    stageimg.alt = "Photo " + (idx + 1);
                    stageimg.src = src;
                    requestAnimationFrame(function () {
                        stageimg.classList.add("is-ready");
                        setLoading(false);
                    });
                    setActiveThumb();
                    if (opts && opts.scrollThumbIntoView) scrollThumbIntoView();
                })
                .catch(function () {
                    stageimg.alt = "Photo " + (idx + 1);
                    stageimg.src = src;
                    stageimg.classList.add("is-ready");
                    setLoading(false);
                    setActiveThumb();
                });
        }

        function openGalleryFromCard(card) {
            if (!card) return;
            if (state.activeCard)
                state.activeCard.classList.remove("is-active");
            state.activeCard = card;
            state.activeCard.classList.add("is-active");
            var eventTitle =
                card.getAttribute("data-event-title") ||
                (card.querySelector(".ihf-cardtitle")
                    ? card.querySelector(".ihf-cardtitle").textContent
                    : "Gallery");
            var eventDate =
                card.getAttribute("data-event-date") ||
                (card.querySelector(".ihf-cardsub")
                    ? card.querySelector(".ihf-cardsub").textContent
                    : "");
            var images = safeParseImages(
                card.getAttribute("data-event-images"),
            );
            if (titleEl) titleEl.textContent = eventTitle;
            if (dateEl) dateEl.textContent = eventDate;
            state.images = images;
            state.index = 0;
            renderThumbs(images);
            gallery.hidden = false;
            gallery.classList.add("is-open");
            if (images.length)
                goTo(0, {
                    scrollThumbIntoView: false,
                });
            var frame =
                gallery.querySelector(".ihfGalleryIHF__frame") ||
                gallery.querySelector(".ihfGalleryIHF__main") ||
                gallery;
            var thumbbar =
                gallery.querySelector(".ihfGalleryIHF__thumbbar") ||
                root.querySelector(".ihfGalleryIHF__thumbbar");
            var navH = 72;
            var topGap = navH + 12;
            var bottomGap = 18;
            var vh = window.innerHeight;
            var fRect = frame.getBoundingClientRect();
            var tRect = thumbbar ? thumbbar.getBoundingClientRect() : null;
            var delta1 = fRect.top - topGap;
            var targetY = window.pageYOffset + delta1;
            if (tRect) {
                var thumbBottomAfter = tRect.bottom - delta1;
                var overflow = thumbBottomAfter - (vh - bottomGap);
                if (overflow > 0) {
                    targetY += overflow;
                }
            }
            var maxY = Math.max(0, document.documentElement.scrollHeight - vh);
            if (targetY < 0) targetY = 0;
            if (targetY > maxY) targetY = maxY;
            window.scrollTo({
                top: targetY,
                behavior: "smooth",
            });
        }

        function closeGallery() {
            gallery.classList.remove("is-open");
            window.setTimeout(function () {
                gallery.hidden = true;
            }, 180);
        }

        function onCardActivate(e) {
            var card = e.target.closest(".ihf-card");
            if (!card) return;
            openGalleryFromCard(card);
        }
        root.__ihfApi = {
            prev: function () {
                goTo(state.index - 1, {
                    scrollThumbIntoView: true,
                });
            },
            next: function () {
                goTo(state.index + 1, {
                    scrollThumbIntoView: true,
                });
            },
            close: function () {
                closeGallery();
            },
        };
        if (btnPrevCards)
            btnPrevCards.addEventListener("click", function () {
                scrollCards(-1);
            });
        if (btnNextCards)
            btnNextCards.addEventListener("click", function () {
                scrollCards(1);
            });
        cardTrack.addEventListener("click", onCardActivate);
        cardTrack.addEventListener("keydown", function (e) {
            if (e.key === "Enter" || e.key === " ") {
                var card = e.target.closest(".ihf-card");
                if (card) {
                    e.preventDefault();
                    openGalleryFromCard(card);
                }
            }
        });
        if (btnPrevPhoto)
            btnPrevPhoto.addEventListener("click", function () {
                goTo(state.index - 1, {
                    scrollThumbIntoView: true,
                });
            });
        if (btnNextPhoto)
            btnNextPhoto.addEventListener("click", function () {
                goTo(state.index + 1, {
                    scrollThumbIntoView: true,
                });
            });
        if (closeBtn) closeBtn.addEventListener("click", closeGallery);
        updateCardNavDisabled();
        window.addEventListener("resize", function () {
            updateCardNavDisabled();
            if (gallery && !gallery.hidden) {
                layoutThumbs();
            }
        });
    }
    for (var i = 0; i < roots.length; i++) init(roots[i]);
})();
/* =========================
   GALLERY (CMS LOADER)
   - apply header
   - render cards
   - support DB keys: gallery.items.i.photos.j OR gallery.items.i.images
========================= */
(function () {
    "use strict";
    if (window.__GALLERY_CMS_INIT__) return;
    window.__GALLERY_CMS_INIT__ = true;

    const $ = (sel, root = document) => root.querySelector(sel);

    function cleanStr(v) {
        return v == null ? "" : String(v).trim();
    }

    function hasValue(v) {
        return cleanStr(v) !== "";
    }

    async function fetchJson(url, timeoutMs = 8000) {
        const ctrl = new AbortController();
        const t = setTimeout(() => ctrl.abort("timeout"), timeoutMs);
        try {
            const res = await fetch(
                url + (url.includes("?") ? "&" : "?") + "v=" + Date.now(),
                {
                    signal: ctrl.signal,
                    credentials: "same-origin",
                },
            );
            if (!res.ok) throw new Error("HTTP " + res.status);
            return await res.json();
        } finally {
            clearTimeout(t);
        }
    }

    function applyGalleryHeader(map) {
        const blackEl = document.querySelector(".page-header__title-black");
        const redEl = document.querySelector(".page-header__title-red");
        const subEl = document.querySelector(".page-header__subtitle");

        const tb = cleanStr(map["gallery.header.title_black"]);
        const tr = cleanStr(map["gallery.header.title_red"]);
        const sub = cleanStr(map["gallery.header.subtitle"]);

        if (blackEl && hasValue(tb)) blackEl.textContent = tb;
        if (redEl && hasValue(tr)) redEl.textContent = tr;
        if (subEl && hasValue(sub)) subEl.innerHTML = sub; // admin-only input
    }

    function safeParseImages(json) {
        try {
            const arr = JSON.parse(json || "[]");
            return Array.isArray(arr) ? arr : [];
        } catch {
            return [];
        }
    }

    // Ambil images dari:
    // 1) gallery.items.i.images (JSON string)
    // 2) fallback: gallery.items.i.photos.1..50 (string path)
    function collectImages(map, i, maxPhotos = 50) {
        const imagesJson = cleanStr(map[`gallery.items.${i}.images`]);
        let images = safeParseImages(imagesJson).map(cleanStr).filter(Boolean);

        if (images.length) return images;

        // fallback dari photos.*
        const out = [];
        for (let j = 1; j <= maxPhotos; j++) {
            const p = cleanStr(map[`gallery.items.${i}.photos.${j}`]);
            if (p) out.push(p);
        }
        return out;
    }

    function renderCardsFromCMS(root, map, maxItems = 10) {
        const cardTrack = root.querySelector("[data-card-track]");
        if (!cardTrack) return;

        const frag = document.createDocumentFragment();

        for (let i = 1; i <= maxItems; i++) {
            const title = cleanStr(map[`gallery.items.${i}.title`]);
            const date = cleanStr(map[`gallery.items.${i}.date`]);
            const cover = cleanStr(map[`gallery.items.${i}.cover`]);

            // kumpulin images
            const images = collectImages(map, i, 50);

            // rule: dianggap ada kalau minimal title/date/cover/images ada
            const any =
                hasValue(title) ||
                hasValue(date) ||
                hasValue(cover) ||
                images.length > 0;
            if (!any) continue;

            const card = document.createElement("button");
            card.type = "button";
            card.className = "ihf-card";
            card.setAttribute("data-event-title", title || `Gallery ${i}`);
            card.setAttribute("data-event-date", date || "");
            card.setAttribute("data-event-images", JSON.stringify(images)); // ini penting buat UI lu

            // markup card (sesuaikan class CSS lu kalau beda)
            card.innerHTML = `
  <div class="ihf-cardimg">
    <img src="${cover || images[0] || ""}" alt="" loading="lazy">
  </div>
  <div class="ihf-cardmeta">
    <p class="ihf-cardtitle">${title || `Gallery ${i}`}</p>
    <p class="ihf-cardsub">${date || ""}</p>
  </div>
`;

            frag.appendChild(card);
        }

        // replace isi track
        cardTrack.innerHTML = "";
        cardTrack.appendChild(frag);
    }

    async function initGalleryCMS() {
        const roots = document.querySelectorAll("[data-ihf-gallery]");
        if (!roots || !roots.length) return;

        let map = null;
        try {
            map = await fetchJson("/api/get.php?page=gallery");
        } catch (e) {
            // kalau gagal, biarin fallback hardcode/HTML lama yang tampil
            return;
        }

        // header di luar root pun di-apply
        applyGalleryHeader(map);

        // render cards per root
        roots.forEach((root) => renderCardsFromCMS(root, map, 10));
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initGalleryCMS);
    } else {
        initGalleryCMS();
    }
})();
// =========================
// ARCHIVE (CMS hydrator + accordion)
// =========================
(async function abtiArchivesPageInit() {
    const section = document.querySelector("#archives.abti-archives");
    if (!section) return;

    // ---------- 1) LOAD CMS DATA (fallback-safe) ----------
    let data = null;
    try {
        const res = await fetch("/api/get.php?page=archives", {
            cache: "no-store",
        });
        if (res.ok) data = await res.json();
    } catch (e) {
        // kalau error, biarin hardcode (fallback)
        data = null;
    }

    function val(key) {
        const v =
            data && Object.prototype.hasOwnProperty.call(data, key)
                ? data[key]
                : "";
        return typeof v === "string" ? v : "";
    }

    // Header override (only if not empty)
    const eyebrow = val("archives.header.eyebrow");
    const title = val("archives.header.title");
    const sub = val("archives.header.subtitle");

    const elEyebrow = section.querySelector(".archives-eyebrow");
    const elTitle = section.querySelector(".archives-title");
    const elSub = section.querySelector(".archives-subtitle");

    if (elEyebrow && eyebrow.trim() !== "") elEyebrow.textContent = eyebrow;
    if (elTitle && title.trim() !== "") elTitle.textContent = title;
    if (elSub && sub.trim() !== "") {
        // subtitle di DB kamu simpen pakai <br>, jadi render sebagai HTML
        elSub.innerHTML = sub;
    }

    // Groups + docs override by DOM order (acc-item ke-1 = group 1, dst)
    const items = Array.from(
        section.querySelectorAll(".archives-accordion .acc-item"),
    );
    items.forEach((item, idx) => {
        const g = idx + 1;

        // Category title/meta
        const gTitle = val(`archives.groups.${g}.title`);
        const gMeta = val(`archives.groups.${g}.meta`);

        const elAccTitle = item.querySelector(".acc-title");
        const elAccMeta = item.querySelector(".acc-meta");

        if (elAccTitle && gTitle.trim() !== "") elAccTitle.textContent = gTitle;

        // Meta: kalau meta kosong tapi ada docs CMS terisi, auto hitung
        let filledDocs = 0;
        for (let d = 1; d <= 10; d++) {
            const dn = val(`archives.groups.${g}.docs.${d}.name`).trim();
            const du = val(`archives.groups.${g}.docs.${d}.url`).trim();
            if (dn !== "" && du !== "") filledDocs++;
        }

        if (elAccMeta) {
            if (gMeta.trim() !== "") {
                elAccMeta.textContent = gMeta;
            } else if (filledDocs > 0) {
                elAccMeta.textContent = `${filledDocs} dokumen`;
            }
            // kalau gMeta kosong & filledDocs 0 => biarin hardcode meta
        }

        // Docs override: berdasarkan urutan <li> yang sudah ada di HTML (fallback)
        const lis = Array.from(item.querySelectorAll(".doc-list .doc-item"));
        lis.forEach((li, liIdx) => {
            const d = liIdx + 1;
            const dn = val(`archives.groups.${g}.docs.${d}.name`).trim();
            const du = val(`archives.groups.${g}.docs.${d}.url`).trim();

            // hanya override kalau dua-duanya keisi
            if (dn !== "" && du !== "") {
                const nameEl = li.querySelector(".doc-name");
                const linkEl = li.querySelector(".doc-download");
                if (nameEl) nameEl.textContent = dn;
                if (linkEl) linkEl.setAttribute("href", du);
            }
            // kalau kosong => biarin hardcode li tersebut (fallback)
        });
    });

    // ---------- 2) EXISTING ANIMATION READY ----------
    const prefersReducedMotion = window.matchMedia?.(
        "(prefers-reduced-motion: reduce)",
    )?.matches;
    if (!prefersReducedMotion) {
        window.requestAnimationFrame(() => {
            setTimeout(() => document.body.classList.add("is-ready"), 80);
        });
    } else {
        document.body.classList.add("is-ready");
    }

    // ---------- 3) EXISTING ACCORDION LOGIC (UNCHANGED) ----------
    const root = section.querySelector('[data-accordion="abti-archives"]');
    if (!root) return;

    const triggers = Array.from(root.querySelectorAll(".acc-trigger"));

    function getPanel(trigger) {
        const panelId = trigger.getAttribute("aria-controls");
        if (!panelId) return null;
        return document.getElementById(panelId);
    }

    function animatePanel(panel, open) {
        if (prefersReducedMotion) {
            panel.hidden = !open;
            panel.style.height = "";
            panel.style.overflow = "";
            return;
        }
        panel.style.overflow = "hidden";
        if (open) {
            panel.hidden = false;
            panel.style.height = "0px";
            panel.getBoundingClientRect();
            panel.style.height = panel.scrollHeight + "px";
            const onEnd = (e) => {
                if (e.target !== panel) return;
                panel.style.height = "";
                panel.style.overflow = "";
                panel.removeEventListener("transitionend", onEnd);
            };
            panel.addEventListener("transitionend", onEnd);
        } else {
            panel.style.height = panel.scrollHeight + "px";
            panel.getBoundingClientRect();
            panel.style.height = "0px";
            const onEnd = (e) => {
                if (e.target !== panel) return;
                panel.hidden = true;
                panel.style.height = "";
                panel.style.overflow = "";
                panel.removeEventListener("transitionend", onEnd);
            };
            panel.addEventListener("transitionend", onEnd);
        }
    }

    function setOpen(trigger, open) {
        const panel = getPanel(trigger);
        if (!panel) return;
        trigger.setAttribute("aria-expanded", String(open));
        animatePanel(panel, open);
    }

    function closeSiblings(activeTrigger) {
        triggers.forEach((t) => {
            if (t === activeTrigger) return;
            if (t.getAttribute("aria-expanded") === "true") setOpen(t, false);
        });
    }

    root.querySelectorAll(".acc-panel").forEach((panel) => {
        panel.style.transition = prefersReducedMotion
            ? ""
            : "height 240ms ease";
    });

    triggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const isOpen = trigger.getAttribute("aria-expanded") === "true";
            closeSiblings(trigger);
            setOpen(trigger, !isOpen);
        });
        trigger.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                trigger.click();
            }
        });
    });
})();
