<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Eskwela Hub is a centralized digital learning platform built for Mabinay National High School.">
    <meta name="theme-color" content="#0f766e">

    <title>Eskwela Hub | Mabinay National High School</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" type="image/webp" href="https://via.placeholder.com/40">
</head>

<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden selection:bg-teal-500 selection:text-white">

    <header class="fixed top-0 left-0 right-0 z-50">
        <nav aria-label="Main navigation" class="border-b border-teal-100/70 bg-white/90 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">

                    <a href="#" class="group flex items-center gap-3" aria-label="Eskwela Hub home">
                        <span class="relative flex-shrink-0">
                            <img src="https://via.placeholder.com/40" alt="Mabinay National High School logo"
                                width="40" height="40" fetchpriority="high" decoding="async"
                                class="relative h-10 w-10 rounded-full border border-teal-50 bg-white object-contain p-1.5 shadow-sm">
                        </span>
                        <span
                            class="text-xl font-extrabold tracking-tight text-teal-900 transition-colors group-hover:text-teal-700">
                            Eskwela Hub
                        </span>
                    </a>

                    <div class="hidden items-center gap-8 md:flex">
                        <a href="#about"
                            class="text-sm font-semibold text-slate-600 transition-colors hover:text-teal-700">About</a>
                        <a href="#features"
                            class="text-sm font-semibold text-slate-600 transition-colors hover:text-teal-700">Features</a>
                        <a href="#developers"
                            class="text-sm font-semibold text-slate-600 transition-colors hover:text-teal-700">Developers</a>

                        <div class="ml-2 flex items-center gap-2">
                            <a href="#login"
                                class="rounded-xl px-5 py-2.5 text-sm font-bold text-teal-800 transition-colors hover:bg-teal-50">
                                Login
                            </a>
                            <a href="#register"
                                class="rounded-xl bg-teal-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-teal-900/20 transition-all hover:bg-teal-800 active:scale-95">
                                Get Started
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>

    <main>
        <section aria-labelledby="hero-heading" class="relative overflow-hidden bg-white pt-20">
            <div aria-hidden="true"
                class="pointer-events-none absolute right-0 top-0 hidden h-full w-1/2 translate-x-1/4 -skew-x-12 bg-teal-50/70 lg:block">
            </div>

            <div class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid min-h-[calc(100vh-5rem)] items-center gap-12 py-16 lg:grid-cols-2 lg:gap-16 lg:py-20">

                    <div class="max-w-2xl">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-teal-100 bg-teal-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-700">
                            <span aria-hidden="true" class="h-2 w-2 rounded-full bg-teal-500"></span>
                            Official School Learning Platform
                        </div>

                        <h1 id="hero-heading"
                            class="mt-6 text-5xl font-black leading-[1.05] tracking-tight text-slate-900 sm:text-6xl lg:text-7xl">
                            One Hub for
                            <span
                                class="block bg-gradient-to-r from-teal-700 via-teal-600 to-teal-800 bg-clip-text text-transparent">
                                Smarter Learning.
                            </span>
                        </h1>

                        <p class="mt-6 max-w-xl text-lg font-medium leading-relaxed text-slate-600 sm:text-xl">
                            Eskwela Hub is a centralized digital learning platform built for Mabinay National High
                            School — bringing classrooms, learning materials, assessments, and student progress together
                            in one place.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            <a href="#register"
                                class="rounded-2xl bg-teal-700 px-8 py-4 text-center font-bold text-white shadow-xl shadow-teal-700/20 transition-all hover:-translate-y-0.5 hover:bg-teal-800 active:scale-95">
                                Get Started
                            </a>
                            <a href="#login"
                                class="rounded-2xl border-2 border-slate-200 bg-white px-8 py-4 text-center font-bold text-slate-700 transition-all hover:border-teal-200 hover:bg-teal-50 hover:text-teal-800 active:scale-95">
                                Login
                            </a>
                        </div>

                        <p class="mt-5 text-sm font-medium text-slate-400">
                            For students, teachers, and administrators.
                        </p>
                    </div>

                    <div class="relative mx-auto w-full max-w-xl lg:max-w-none">
                        <div aria-hidden="true" class="absolute -inset-4 rounded-[3rem] bg-teal-100/60"></div>
                        <div
                            class="relative overflow-hidden rounded-[2.5rem] border-8 border-white bg-slate-100 shadow-2xl">
                            <img src="https://via.placeholder.com/900" alt="Mabinay National High School"
                                width="900" height="900" fetchpriority="high" decoding="async"
                                class="aspect-square w-full object-cover">
                            <div aria-hidden="true"
                                class="absolute inset-0 bg-gradient-to-t from-teal-950/60 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="absolute -bottom-8 left-1/2 flex h-28 w-28 -translate-x-1/2 items-center justify-center rounded-full border-8 border-white bg-white p-5 shadow-xl sm:h-36 sm:w-36 lg:-left-8 lg:bottom-10 lg:translate-x-0">
                            <img src="https://via.placeholder.com/144" alt="Mabinay National High School logo"
                                width="144" height="144" decoding="async" class="h-full w-full object-contain">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section id="about" aria-labelledby="about-heading"
            class="relative overflow-hidden bg-slate-50 py-24 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center lg:gap-20">

                    <div>
                        <span
                            class="inline-block rounded-lg bg-teal-100/80 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-800">
                            About Eskwela Hub
                        </span>
                        <h2 id="about-heading"
                            class="mt-5 text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl">
                            Built for a more <span class="text-teal-600">connected school.</span>
                        </h2>
                        <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-600">
                            Eskwela Hub brings important academic activities into one centralized digital environment,
                            helping students and teachers manage learning more efficiently.
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <article
                            class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm transition-shadow hover:shadow-lg">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-700">
                                <svg aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 6v12m-3-3 3 3 3-3M4.5 8.25A3.75 3.75 0 018.25 4.5h7.5a3.75 3.75 0 013.75 3.75v7.5a3.75 3.75 0 01-3.75 3.75h-7.5a3.75 3.75 0 01-3.75-3.75v-7.5z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 font-bold text-slate-900">Centralized Learning</h3>
                            <p class="mt-3 text-sm leading-relaxed text-slate-500">Keep classes, materials, activities,
                                and assessments organized in one platform.</p>
                        </article>

                        <article
                            class="rounded-3xl border border-teal-100 bg-teal-50/70 p-7 shadow-sm transition-shadow hover:shadow-lg">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-600 text-white shadow-md shadow-teal-600/30">
                                <svg aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 font-bold text-slate-900">Efficient Assessment</h3>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">Create assessments, monitor
                                activities, and track student performance efficiently.</p>
                        </article>
                    </div>

                </div>
            </div>
        </section>

        <section id="features" aria-labelledby="features-heading" class="bg-white py-24 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <span
                        class="inline-block rounded-lg bg-teal-100/80 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-800">
                        Platform Features
                    </span>
                    <h2 id="features-heading"
                        class="mt-5 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">
                        Everything your school needs, <span class="text-teal-600">in one place.</span>
                    </h2>
                    <p class="mt-5 text-lg leading-relaxed text-slate-500">
                        Designed to simplify everyday academic workflows for students, teachers, and school
                        administrators.
                    </p>
                </div>

                <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <article
                        class="group relative rounded-3xl border border-slate-100 bg-slate-50/50 p-8 transition-all duration-300 hover:border-teal-100 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5">
                        <div class="text-3xl font-black text-teal-600/40 transition-colors group-hover:text-teal-600">
                            01</div>
                        <h3 class="mt-5 text-xl font-bold text-slate-900">Virtual Classrooms</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">Organize classroom activities and
                            provide students with a centralized learning space.</p>
                    </article>

                    <article
                        class="group relative rounded-3xl border border-slate-100 bg-slate-50/50 p-8 transition-all duration-300 hover:border-teal-100 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5">
                        <div class="text-3xl font-black text-teal-600/40 transition-colors group-hover:text-teal-600">
                            02</div>
                        <h3 class="mt-5 text-xl font-bold text-slate-900">Learning Materials</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">Distribute lessons, resources, and
                            learning materials without relying on scattered platforms.</p>
                    </article>

                    <article
                        class="group relative rounded-3xl border border-slate-100 bg-slate-50/50 p-8 transition-all duration-300 hover:border-teal-100 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5">
                        <div class="text-3xl font-black text-teal-600/40 transition-colors group-hover:text-teal-600">
                            03</div>
                        <h3 class="mt-5 text-xl font-bold text-slate-900">Assessments</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">Manage quizzes and assessments while
                            making student performance easier to monitor.</p>
                    </article>

                    <article
                        class="group relative rounded-3xl border border-slate-100 bg-slate-50/50 p-8 transition-all duration-300 hover:border-teal-100 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5">
                        <div class="text-3xl font-black text-teal-600/40 transition-colors group-hover:text-teal-600">
                            04</div>
                        <h3 class="mt-5 text-xl font-bold text-slate-900">Progress Tracking</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">Give teachers and administrators better
                            visibility into learner activities and academic progress.</p>
                    </article>
                </div>
            </div>
        </section>

        <section aria-labelledby="mission-heading" class="bg-slate-50 py-24 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-2">

                    <article class="rounded-[2rem] border border-teal-100 bg-white p-8 shadow-sm md:p-10">
                        <span
                            class="inline-block rounded-lg bg-teal-100/80 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-800">
                            DepEd Mission
                        </span>
                        <h2 id="mission-heading" class="mt-5 text-2xl font-black text-slate-900">Quality education for
                            every learner.</h2>
                        <p class="mt-6 text-base leading-relaxed text-slate-600">
                            To protect and promote the right of every Filipino to quality, equitable, culture-based, and
                            complete basic education where students learn in a child-friendly, gender-sensitive, safe,
                            and motivating environment; teachers facilitate learning and constantly nurture every
                            learner; administrators and staff ensure an enabling and supportive environment; and family,
                            community, and stakeholders are actively engaged in developing lifelong learners.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm md:p-10">
                        <span
                            class="inline-block rounded-lg bg-slate-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-slate-700">
                            DepEd Vision
                        </span>
                        <h2 class="mt-5 text-2xl font-black text-slate-900">Learners reaching their full potential.
                        </h2>
                        <p class="mt-6 text-base leading-relaxed text-slate-600">
                            We dream of Filipinos who passionately love their country and whose values and competencies
                            enable them to realize their full potential and contribute meaningfully to building the
                            nation. As a learner-centered public institution, the Department of Education continuously
                            improves itself to better serve its stakeholders.
                        </p>
                    </article>

                </div>
            </div>
        </section>

        <section aria-labelledby="values-heading" class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span
                            class="inline-block rounded-lg bg-teal-100/80 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-800">
                            Maka-Pilipino
                        </span>
                        <h2 id="values-heading" class="mt-3 text-3xl font-black text-slate-900 sm:text-4xl">Core
                            Values</h2>
                    </div>
                    <p class="max-w-md text-sm leading-relaxed text-slate-500">
                        The values that help guide our conduct, learning environment, and service to the school
                        community.
                    </p>
                </div>

                <div class="mt-14 grid grid-cols-2 gap-8 lg:grid-cols-4">
                    <div class="group">
                        <span
                            class="text-5xl font-black tracking-tighter text-slate-100 transition-colors group-hover:text-teal-100">01</span>
                        <h3 class="mt-3 text-xl font-bold text-slate-900">Maka-Diyos</h3>
                        <div
                            class="mt-4 h-1 w-10 rounded-full bg-teal-500 transition-all duration-300 group-hover:w-24">
                        </div>
                    </div>
                    <div class="group">
                        <span
                            class="text-5xl font-black tracking-tighter text-slate-100 transition-colors group-hover:text-teal-100">02</span>
                        <h3 class="mt-3 text-xl font-bold text-slate-900">Maka-tao</h3>
                        <div
                            class="mt-4 h-1 w-10 rounded-full bg-teal-500 transition-all duration-300 group-hover:w-24">
                        </div>
                    </div>
                    <div class="group">
                        <span
                            class="text-5xl font-black tracking-tighter text-slate-100 transition-colors group-hover:text-teal-100">03</span>
                        <h3 class="mt-3 text-xl font-bold text-slate-900">Makakalikasan</h3>
                        <div
                            class="mt-4 h-1 w-10 rounded-full bg-teal-500 transition-all duration-300 group-hover:w-24">
                        </div>
                    </div>
                    <div class="group">
                        <span
                            class="text-5xl font-black tracking-tighter text-slate-100 transition-colors group-hover:text-teal-100">04</span>
                        <h3 class="mt-3 text-xl font-bold text-slate-900">Makabansa</h3>
                        <div
                            class="mt-4 h-1 w-10 rounded-full bg-teal-500 transition-all duration-300 group-hover:w-24">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="developers" aria-labelledby="developers-heading" class="bg-slate-50 py-24 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <span
                        class="inline-block rounded-lg bg-teal-100/80 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-800">
                        Behind the System
                    </span>
                    <h2 id="developers-heading"
                        class="mt-5 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">
                        Meet the Developers
                    </h2>
                    <p class="mt-5 text-lg text-slate-500">
                        The team behind the design, development, security, and documentation of Eskwela Hub.
                    </p>
                </div>

                <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-6 text-center shadow-sm transition-all hover:border-teal-200 hover:shadow-md">
                        <div class="mx-auto h-32 w-32 overflow-hidden rounded-[2rem] border-4 border-white shadow-md">
                            <img src="https://via.placeholder.com/128" alt="Nathaniel Dalisay" width="128"
                                height="128" loading="lazy" decoding="async" class="h-full w-full object-cover">
                        </div>
                        <h3 class="mt-6 text-xl font-black text-slate-900">Nathaniel Dalisay</h3>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-teal-600">Programmer</p>
                        <p class="mt-4 text-sm italic leading-relaxed text-slate-500">"Building efficient, scalable,
                            and reliable software solutions."</p>
                    </article>

                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-6 text-center shadow-sm transition-all hover:border-teal-200 hover:shadow-md">
                        <div class="mx-auto h-32 w-32 overflow-hidden rounded-[2rem] border-4 border-white shadow-md">
                            <img src="https://via.placeholder.com/128" alt="Jay Ann Molines" width="128"
                                height="128" loading="lazy" decoding="async" class="h-full w-full object-cover">
                        </div>
                        <h3 class="mt-6 text-xl font-black text-slate-900">Jay Ann Molines</h3>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-teal-600">UI/UX Designer
                        </p>
                        <p class="mt-4 text-sm italic leading-relaxed text-slate-500">"Designing intuitive, accessible,
                            and user-centered digital experiences."</p>
                    </article>

                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-6 text-center shadow-sm transition-all hover:border-teal-200 hover:shadow-md">
                        <div class="mx-auto h-32 w-32 overflow-hidden rounded-[2rem] border-4 border-white shadow-md">
                            <img src="https://via.placeholder.com/128" alt="Jino Lariosa" width="128"
                                height="128" loading="lazy" decoding="async" class="h-full w-full object-cover">
                        </div>
                        <h3 class="mt-6 text-xl font-black text-slate-900">Jino Lariosa</h3>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-teal-600">Security
                            Specialist</p>
                        <p class="mt-4 text-sm italic leading-relaxed text-slate-500">"Ensuring data integrity and
                            protecting user privacy."</p>
                    </article>

                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-6 text-center shadow-sm transition-all hover:border-teal-200 hover:shadow-md">
                        <div class="mx-auto h-32 w-32 overflow-hidden rounded-[2rem] border-4 border-white shadow-md">
                            <img src="https://via.placeholder.com/128" alt="Ayin Amorganda" width="128"
                                height="128" loading="lazy" decoding="async" class="h-full w-full object-cover">
                        </div>
                        <h3 class="mt-6 text-xl font-black text-slate-900">Ayin Amorganda</h3>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-teal-600">Documentation
                            Lead</p>
                        <p class="mt-4 text-sm italic leading-relaxed text-slate-500">"Structuring processes and
                            maintaining system clarity."</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-slate-900 text-slate-400">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-8">

                <div class="space-y-4 lg:col-span-5">
                    <div class="flex items-center gap-3">
                        <img src="https://via.placeholder.com/36" alt="Mabinay National High School logo"
                            width="36" height="36" loading="lazy" decoding="async"
                            class="h-9 w-9 rounded-full bg-white p-1">
                        <span class="text-lg font-black tracking-tight text-white">Eskwela Hub</span>
                    </div>
                    <p class="max-w-sm text-sm leading-relaxed text-slate-400">
                        The official digital learning management system of Mabinay National High School. Centralizing
                        classroom workflows, learning materials, and student assessments.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-8 sm:grid-cols-2 lg:col-span-7">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-200">Quick Links</h3>
                        <ul class="mt-4 space-y-2.5 text-sm">
                            <li><a href="#about" class="transition-colors hover:text-teal-400">About Platform</a>
                            </li>
                            <li><a href="#features" class="transition-colors hover:text-teal-400">Features</a></li>
                            <li><a href="#developers" class="transition-colors hover:text-teal-400">Development
                                    Team</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-200">Account Access</h3>
                        <ul class="mt-4 space-y-2.5 text-sm">
                            <li><a href="#login" class="transition-colors hover:text-teal-400">Portal Login</a></li>
                            <li><a href="#register" class="transition-colors hover:text-teal-400">Create Account</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div
                class="mt-12 border-t border-slate-800 pt-8 flex flex-col items-center justify-between gap-4 text-xs sm:flex-row">
                <p>&copy; 2026 Eskwela Hub — Mabinay National High School. All rights reserved.</p>
                <p class="text-slate-500">Built with Tailwind CSS.</p>
            </div>
        </div>
    </footer>
</body>

</html>
