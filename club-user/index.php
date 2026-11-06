<?php
require_once __DIR__ . '/lib.php';
$student = require_student();

/** Font Awesome 5 names for the shared club icons. */
function fa5(string $icon): string
{
    return ['fa-shield' => 'fa-shield-alt'][$icon] ?? $icon;
}

$myClubs = club_list($student['club_user']);
$myTypes = [];
foreach ($myClubs as $k) {
    if ($c = club_by_keyword($k)) $myTypes[] = $c['type'];
}

// Activities: upcoming (soonest first), then past (most recent first)
$today = strtotime('today');
$upcoming = [];
$past = [];
foreach (rows("SELECT * FROM club_activity ORDER BY club_date ASC, club_id ASC") as $a) {
    if (!isset(CLUBS[$a['club_type']])) continue;
    $a['ts'] = strtotime($a['club_date']) ?: 0;
    if ($a['ts'] >= $today) $upcoming[] = $a; else $past[] = $a;
}
$past = array_reverse($past);
$next = null;
foreach ($upcoming as $a) {
    if (in_array($a['club_type'], $myTypes, true)) { $next = $a; break; }
}

$firstName = explode(' ', trim($student['name_user']))[0] ?: 'there';
$initial = strtoupper(substr($firstName, 0, 1));
$flashes = take_flashes();

function days_label(int $ts): string
{
    $d = (int)round(($ts - strtotime('today')) / 86400);
    return $d === 0 ? 'Today' : ($d === 1 ? 'Tomorrow' : ($d > 1 ? "In $d days" : abs($d) . ' days ago'));
}

function activity_card(array $a, bool $mine, bool $isPast): void
{
    $c = CLUBS[$a['club_type']]; ?>
    <div class="col-md-6 col-lg-4 mb-4 cb-act-col" data-club="<?= $a['club_type'] ?>" data-mine="<?= $mine ? 1 : 0 ?>" data-past="<?= $isPast ? 1 : 0 ?>">
        <article class="cb-activity<?= $isPast ? ' is-past' : '' ?>">
            <div class="cb-activity-media" style="background:linear-gradient(135deg, <?= $c['color'] ?>, #0f172a)">
                <i class="fas <?= fa5($c['icon']) ?>"></i>
                <?php if (!empty($a['club_image'])) { ?>
                    <img src="<?= e($a['club_image']) ?>" alt="" loading="lazy" onerror="this.remove()">
                <?php } ?>
                <?php if ($a['ts']) { ?>
                <div class="cb-date"><strong><?= date('d', $a['ts']) ?></strong><span><?= date('M Y', $a['ts']) ?></span></div>
                <span class="cb-when<?= $isPast ? ' past' : '' ?>"><?= $isPast ? 'Past' : days_label($a['ts']) ?></span>
                <?php } ?>
            </div>
            <div class="cb-activity-body">
                <div class="d-flex align-items-center justify-content-between" style="gap:.5rem">
                    <span class="cb-activity-tag" style="color:<?= $c['color'] ?>"><?= e($c['name']) ?></span>
                    <?php if ($mine) { ?><span class="cb-mine"><i class="fas fa-check"></i> Your club</span><?php } ?>
                </div>
                <h3><?= e($a['club_content']) ?></h3>
                <p><?= e($a['club_content_2']) ?></p>
                <div class="cb-meta">
                    <span><i class="far fa-clock"></i><?= e($a['club_time']) ?></span>
                    <span><i class="far fa-user"></i><?= e($a['club_name']) ?></span>
                    <?php if ($a['club_contact']) { ?><span><i class="fas fa-phone-alt"></i><?= e($a['club_contact']) ?></span><?php } ?>
                </div>
                <?php if (!$isPast) { ?>
                <a href="ics.php?id=<?= (int)$a['club_id'] ?>" class="cb-cal"><i class="far fa-calendar-plus"></i> Add to calendar</a>
                <?php } ?>
            </div>
        </article>
    </div>
<?php }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ClubHub · Student Portal</title>
    <link rel="icon" type="image/svg+xml" href="img/logo.svg" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/clubhub.css" />
    <script>document.documentElement.classList.add('js');</script>
</head>

<body id="home">

    <!-- Navbar -->
    <nav class="cb-nav" id="cbNav">
        <div class="container">
            <a class="cb-brand" href="#home"><img src="img/logo.svg" alt=""> ClubHub</a>
            <button class="cb-burger" id="cbBurger" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
            <ul class="cb-nav-links" id="cbLinks">
                <li><a href="#home">Home</a></li>
                <li><a href="#profile">My Profile</a></li>
                <li><a href="#activities">Activities</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="logout.php" class="cb-logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero -->
    <header class="cb-hero">
        <video autoplay loop muted playsinline>
            <source src="videos/city-night-blur-01.mp4" type="video/mp4" />
        </video>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="cb-badge"><i class="fas fa-hand-sparkles"></i> Student Portal</span>
                    <h1>Hi <?= e($firstName) ?>, <span>welcome back.</span></h1>
                    <p class="lead">Everything about your clubs in one place: memberships, upcoming meetings and the people to contact.</p>
                    <div class="cb-hero-actions">
                        <a href="#activities" class="cb-btn cb-btn-primary"><i class="fas fa-calendar-alt"></i> View activities</a>
                        <a href="#profile" class="cb-btn cb-btn-ghost"><i class="far fa-user"></i> My profile</a>
                    </div>
                    <div class="cb-hero-stats">
                        <div><strong><?= count($myClubs) ?></strong><span>Clubs joined</span></div>
                        <div><strong><?= count(array_filter($upcoming, function ($a) use ($myTypes) { return in_array($a['club_type'], $myTypes, true); })) ?></strong><span>Upcoming in your clubs</span></div>
                        <div><strong><?= count(CLUBS) ?></strong><span>Clubs available</span></div>
                    </div>
                </div>
                <div class="col-lg-5 mt-5 mt-lg-0">
                    <div class="cb-next">
                        <?php if ($next) { $c = CLUBS[$next['club_type']]; ?>
                        <span class="cb-next-label"><i class="fas fa-bolt"></i> Next up in your clubs</span>
                        <div class="cb-next-count" data-date="<?= date('Y-m-d', $next['ts']) ?>"><?= days_label($next['ts']) ?></div>
                        <h3><?= e($next['club_content']) ?></h3>
                        <p><i class="fas <?= fa5($c['icon']) ?>" style="color:<?= $c['color'] ?>"></i> <?= e($c['name']) ?></p>
                        <p><i class="far fa-calendar"></i> <?= date('l, d M Y', $next['ts']) ?> · <?= e($next['club_time']) ?></p>
                        <a href="ics.php?id=<?= (int)$next['club_id'] ?>" class="cb-btn cb-btn-ghost mt-2"><i class="far fa-calendar-plus"></i> Add to calendar</a>
                        <?php } else { ?>
                        <span class="cb-next-label"><i class="far fa-calendar"></i> Next up in your clubs</span>
                        <h3>Nothing scheduled yet</h3>
                        <p>When your clubs post a meeting or event, it will show up here.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <a href="#profile" class="cb-scroll-cue" aria-label="Scroll down"><i class="fas fa-chevron-down fa-lg"></i></a>
    </header>

    <!-- Profile -->
    <section class="cb-section" id="profile">
        <div class="container">
            <div class="cb-section-head cb-reveal">
                <span class="cb-badge"><i class="far fa-id-badge"></i> Profile</span>
                <h2>Student information</h2>
                <p>Your registered details and the clubs you're part of.</p>
            </div>

            <div class="row">
                <div class="col-lg-5 mb-4 cb-reveal">
                    <div class="cb-card">
                        <div class="cb-profile-head">
                            <div class="cb-avatar"><?= e($initial) ?></div>
                            <div>
                                <h3><?= e($student['name_user']) ?></h3>
                                <p>Member since <?= e(date('M Y', strtotime($student['created_at'] ?? 'now'))) ?></p>
                            </div>
                        </div>
                        <ul class="cb-info-list">
                            <li><i class="far fa-id-card"></i>
                                <div><small>Student ID</small><span><?= e(strtoupper($student['studentid_user'])) ?></span></div>
                            </li>
                            <li><i class="far fa-envelope"></i>
                                <div><small>Email</small><span><?= e($student['email_user']) ?></span></div>
                            </li>
                            <li><i class="fas fa-phone-alt"></i>
                                <div class="flex-grow-1"><small>Phone</small>
                                    <span id="phoneView"><?= e($student['phone_user']) ?>
                                        <button type="button" class="cb-link" onclick="togglePhone(true)"><i class="fas fa-pen"></i> Edit</button></span>
                                    <form method="post" action="account.php" id="phoneForm" class="cb-inline-form" hidden>
                                        <?= csrf_field() ?><input type="hidden" name="action" value="phone">
                                        <input type="tel" name="phone" id="phone" value="<?= e($student['phone_user']) ?>" maxlength="13" required aria-label="Phone number">
                                        <button class="cb-btn cb-btn-primary cb-btn-sm">Save</button>
                                        <button type="button" class="cb-link" onclick="togglePhone(false)">Cancel</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-7 mb-4 cb-reveal">
                    <div class="cb-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:.75rem">
                            <div>
                                <div class="cb-card-title"><i class="fas fa-users"></i> My clubs</div>
                                <div class="cb-card-sub">Clubs you registered for this semester.</div>
                            </div>
                            <button type="button" class="cb-btn cb-btn-soft" onclick="document.getElementById('clubDialog').showModal()"><i class="fas fa-sliders-h"></i> Manage clubs</button>
                        </div>
                        <div class="cb-chips">
                            <?php if (!$myClubs) { ?>
                                <span class="cb-empty">You haven't joined any clubs yet.</span>
                            <?php } ?>
                            <?php foreach ($myClubs as $k) { $c = club_by_keyword($k); ?>
                                <span class="cb-chip"><i class="fas <?= fa5($c['icon'] ?? 'fa-users') ?>" style="background:<?= $c['color'] ?? '#6366f1' ?>"></i><?= e($c['name'] ?? $k) ?></span>
                            <?php } ?>
                        </div>

                        <hr class="my-4">

                        <div class="cb-card-title"><i class="fas fa-compass"></i> Explore other clubs</div>
                        <div class="cb-card-sub">Tap a club to see its activities, or use Manage clubs to join.</div>
                        <div class="cb-chips">
                            <?php foreach (CLUBS as $type => $c) { if (in_array($type, $myTypes, true)) continue; ?>
                                <a href="#activities" class="cb-chip cb-chip-link" data-filter-link="<?= $type ?>"><i class="fas <?= fa5($c['icon']) ?>" style="background:<?= $c['color'] ?>"></i><?= e($c['name']) ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Manage clubs dialog -->
    <dialog id="clubDialog" class="cb-dialog">
        <form method="post" action="account.php">
            <?= csrf_field() ?><input type="hidden" name="action" value="clubs">
            <div class="cb-dialog-head">
                <h3>Manage your clubs</h3>
                <button type="button" class="cb-link" onclick="this.closest('dialog').close()" aria-label="Close"><i class="fas fa-times fa-lg"></i></button>
            </div>
            <p class="cb-card-sub mb-3">Tick the clubs you want to be part of.</p>
            <div class="cb-dialog-grid">
                <?php foreach (CLUBS as $type => $c) { ?>
                <label class="cb-pick">
                    <input type="checkbox" name="clubs[]" value="<?= e($c['keyword']) ?>" <?= in_array($type, $myTypes, true) ? 'checked' : '' ?>>
                    <span><i class="fas <?= fa5($c['icon']) ?>" style="background:<?= $c['color'] ?>"></i><span><strong><?= e($c['name']) ?></strong><small><?= e($c['desc']) ?></small></span></span>
                </label>
                <?php } ?>
            </div>
            <div class="cb-dialog-foot">
                <button type="button" class="cb-btn cb-btn-soft" onclick="this.closest('dialog').close()">Cancel</button>
                <button class="cb-btn cb-btn-primary"><i class="fas fa-check"></i> Save clubs</button>
            </div>
        </form>
    </dialog>

    <!-- Activities -->
    <section class="cb-section alt" id="activities">
        <div class="container">
            <div class="cb-section-head cb-reveal">
                <span class="cb-badge"><i class="far fa-calendar-alt"></i> What's on</span>
                <h2>Club activities</h2>
                <p>Upcoming meetings and events across all clubs.</p>
            </div>

            <div class="cb-filters" role="toolbar" aria-label="Filter activities">
                <button class="active" data-filter="all">All clubs</button>
                <button data-filter="mine"><i class="fas fa-star"></i> My clubs</button>
                <?php foreach (CLUBS as $type => $c) { ?>
                <button data-filter="<?= $type ?>" style="--c:<?= $c['color'] ?>"><i class="fas <?= fa5($c['icon']) ?>"></i> <?= e($c['keyword']) ?></button>
                <?php } ?>
            </div>

            <div class="row" id="actGrid">
                <?php foreach ($upcoming as $a) activity_card($a, in_array($a['club_type'], $myTypes, true), false); ?>
                <?php foreach ($past as $a) activity_card($a, in_array($a['club_type'], $myTypes, true), true); ?>
            </div>
            <p class="text-center cb-empty" id="actEmpty" hidden>No activities for this club yet.</p>
            <?php if ($past) { ?>
            <div class="text-center"><button class="cb-btn cb-btn-soft" id="togglePast"><i class="fas fa-history"></i> Show past activities (<?= count($past) ?>)</button></div>
            <?php } ?>
        </div>
    </section>

    <!-- About -->
    <section class="cb-section cb-about" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 cb-reveal">
                    <div class="cb-about-img"><img src="img/img-05.jpg" alt=""></div>
                </div>
                <div class="col-lg-6 pl-lg-5 cb-reveal">
                    <span class="cb-badge"><i class="fas fa-info-circle"></i> About us</span>
                    <h2>Built for students, run by students.</h2>
                    <p>Our club community is driven by a shared purpose: to help every student discover their passions,
                        build friendships and grow beyond the classroom through activities, events and teamwork.</p>
                    <p>Whether you love technology, the arts, the outdoors or business, there's a club where you belong.</p>

                    <div class="cb-tabs" role="tablist">
                        <button class="active" data-tab="vision" role="tab">Vision</button>
                        <button data-tab="mission" role="tab">Mission</button>
                    </div>
                    <div class="cb-tab-pane active" id="vision">
                        To build a vibrant, inclusive campus community where every student finds a place to belong.
                    </div>
                    <div class="cb-tab-pane" id="mission">
                        To provide meaningful activities that develop leadership, creativity and lifelong friendships
                        among our members.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="cb-section alt" id="contact">
        <div class="container">
            <div class="cb-section-head cb-reveal">
                <span class="cb-badge"><i class="far fa-comments"></i> Get in touch</span>
                <h2>Contact us</h2>
                <p>Questions about clubs or activities? We're happy to help.</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4 cb-reveal">
                    <div class="cb-card cb-contact-card"><i class="fas fa-phone-alt"></i>
                        <div><h4>Phone</h4><p>+00 000-000 0000</p></div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 cb-reveal">
                    <div class="cb-card cb-contact-card"><i class="far fa-envelope"></i>
                        <div><h4>Email</h4><p>clubs@example.com</p></div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 cb-reveal">
                    <div class="cb-card cb-contact-card"><i class="fas fa-map-marker-alt"></i>
                        <div><h4>Office</h4><p>Student Affairs Office, Main Campus</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="cb-footer">
        <div class="container">
            <a class="cb-brand" href="#home"><img src="img/logo.svg" alt=""> ClubHub</a>
            <span>&copy; <?= date('Y') ?> ClubHub &middot; Club Registration System</span>
        </div>
    </footer>

    <button class="cb-to-top" id="cbTop" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>
    <div class="cb-toast-stack">
        <?php foreach ($flashes as $f) { ?>
        <div class="cb-toast<?= $f['type'] === 'error' ? ' error' : '' ?>"><i class="fas <?= $f['type'] === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle' ?>"></i><span><?= e($f['message']) ?></span></div>
        <?php } ?>
    </div>

    <script>
    function togglePhone(edit) {
        document.getElementById('phoneView').hidden = edit;
        document.getElementById('phoneForm').hidden = !edit;
        if (edit) document.getElementById('phone').focus();
    }

    (function() {
        var nav = document.getElementById('cbNav');
        var top = document.getElementById('cbTop');
        var links = document.getElementById('cbLinks');

        function onScroll() {
            var y = window.scrollY;
            nav.classList.toggle('scrolled', y > 40);
            top.classList.toggle('show', y > 500);
            var current = 'home';
            document.querySelectorAll('section[id]').forEach(function(s) {
                if (s.getBoundingClientRect().top < 120) current = s.id;
            });
            links.querySelectorAll('a[href^="#"]').forEach(function(a) {
                a.classList.toggle('active', a.getAttribute('href') === '#' + current);
            });
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        document.getElementById('cbBurger').addEventListener('click', function() { links.classList.toggle('open'); });
        links.querySelectorAll('a').forEach(function(a) { a.addEventListener('click', function() { links.classList.remove('open'); }); });
        top.addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });

        // Vision / mission tabs
        document.querySelectorAll('.cb-tabs button').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.cb-tabs button').forEach(function(b) { b.classList.remove('active'); });
                document.querySelectorAll('.cb-tab-pane').forEach(function(p) { p.classList.remove('active'); });
                btn.classList.add('active');
                document.getElementById(btn.dataset.tab).classList.add('active');
            });
        });

        // Activity filters
        var filter = 'all', showPast = false;
        var cols = document.querySelectorAll('.cb-act-col');
        function applyFilter() {
            var shown = 0;
            cols.forEach(function(col) {
                var ok = filter === 'all' || (filter === 'mine' ? col.dataset.mine === '1' : col.dataset.club === filter);
                if (col.dataset.past === '1' && !showPast) ok = false;
                col.hidden = !ok;
                if (ok) shown++;
            });
            document.getElementById('actEmpty').hidden = shown > 0;
            document.querySelectorAll('.cb-filters button').forEach(function(b) { b.classList.toggle('active', b.dataset.filter === filter); });
        }
        document.querySelectorAll('.cb-filters button').forEach(function(b) {
            b.addEventListener('click', function() { filter = b.dataset.filter; applyFilter(); });
        });
        document.querySelectorAll('[data-filter-link]').forEach(function(a) {
            a.addEventListener('click', function() { filter = a.dataset.filterLink; applyFilter(); });
        });
        var tp = document.getElementById('togglePast');
        if (tp) tp.addEventListener('click', function() {
            showPast = !showPast;
            tp.innerHTML = showPast ? '<i class="fas fa-eye-slash"></i> Hide past activities' : '<i class="fas fa-history"></i> Show past activities (<?= count($past) ?>)';
            applyFilter();
        });
        applyFilter();

        // Reveal on scroll
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function(entries) {
                entries.forEach(function(en) { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
            }, { threshold: 0.12 });
            document.querySelectorAll('.cb-reveal').forEach(function(el) { io.observe(el); });
        } else {
            document.querySelectorAll('.cb-reveal').forEach(function(el) { el.classList.add('in'); });
        }

        // Toasts
        document.querySelectorAll('.cb-toast').forEach(function(t, i) {
            setTimeout(function() { t.classList.add('show'); }, 300 + i * 150);
            setTimeout(function() { t.classList.remove('show'); }, 5000 + i * 150);
        });

        // Close the dialog by clicking the backdrop
        var dlg = document.getElementById('clubDialog');
        dlg.addEventListener('click', function(ev) { if (ev.target === dlg) dlg.close(); });
    })();
    </script>
</body>

</html>
