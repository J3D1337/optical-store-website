@extends('layouts.app')

@section('title', 'Interoptika - Optičarski salon')

@section('content')
<!-- Page Content -->
    <main class="p-0">
        <section class="hero fade-bottom">
            <div class="text-center max-w-4xl px-4 w-full">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 font-serif">Vaš pogled nam je najvažniji</h1>
                <p class="text-xl md:text-2xl mb-8">Više od 35 godina brinemo o vašem vidu s ljubavlju i stručnošću</p>
            </div>
        </section>

        <section class="py-16 bg-white fade-bottom">
            <div class="max-w-6xl mx-auto px-4 w-full">
                <!-- Header -->
                <div class="flex justify-start items-center mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 font-serif">
                        <i class="fas fa-newspaper mr-3 text-blue-600"></i>
                        Novosti
                    </h1>
                </div>

                <!-- News List -->
                <div class="space-y-6">
                    @forelse ($news as $item)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden news-card fade-in hover:shadow-lg transition-all">
                            <div class="p-6 space-y-4">
                                <!-- News Header -->
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <span
                                                class="text-sm font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded mr-3">
                                                {{ ucfirst($item->tag ?? 'Novost') }}
                                            </span>
                                            <p class="text-sm text-gray-500">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $item->created_at->format('d.m.Y') }}
                                            </p>
                                        </div>
                                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 font-serif">
                                            {{ $item->title }}</h3>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="mt-4">
                                    <p class="text-gray-700">
                                        {{ $item->content }}
                                    </p>
                                </div>

                                <!-- Images Gallery -->
                                @if ($item->images)
                                    <div class="mt-4">
                                        <div
                                            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                                            @foreach ($item->images as $img)
                                                <div class="relative group image-container">
                                                    <img src="{{ asset('storage/' . $img) }}"
                                                        class="w-full h-40 md:h-48 object-cover rounded-lg cursor-pointer hover:shadow-md transition"
                                                        onclick="openImageModal('{{ asset('storage/' . $img) }}')">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-6 py-4 rounded shadow text-center">
                            <h3 class="text-lg font-semibold mb-1">Trenutno nema dostupnih novosti</h3>
                            <p class="text-sm">Provjerite ponudu uskoro ili nas kontaktirajte za više informacija.</p>
                        </div>
                    @endforelse
                </div>


            </div>



        </section>

        <section class="py-16 bg-white"> <!-- About -->
            <div class="max-w-6xl mx-auto px-4 w-full">
                <div class="flex flex-col md:flex-row items-center gap-12 w-full">
                    <div class="md:w-1/2 w-full">
                        <div class="w-full h-96 rounded-lg overflow-hidden">
                            <img src="{{ asset('images/poslovnica2.jpeg') }}" alt="Optičar pregledava klijenta"
                                class="w-full h-full object-cover fade-bottom">
                        </div>
                    </div>
                    <div class="md:w-1/2 w-full">
                        <h2 class="text-3xl font-bold mb-6 fade-bottom font-serif">Interoptika - tradicija od 1986.
                        </h2>
                        <p class="text-lg mb-6 fade-bottom">Još od 1986. godine, Interoptika s ljubavlju i predanošću
                            brine o vašem vidu. S više od tri desetljeća iskustva, postali smo sinonim za kvalitetu,
                            stručnost i osobni pristup svakom klijentu.</p>
                        <div class="flex items-center space-x-4 fade-bottom">
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <i class="fas fa-check text-indigo-600"></i>
                            </div>
                            <p>Više od 35 godina iskustva</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-3 fade-bottom">
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <i class="fas fa-check text-indigo-600"></i>
                            </div>
                            <p>Stručni i ljubazni tim</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-gray-50 fade-bottom"> <!-- Mission -->
            <div class="max-w-6xl mx-auto px-4 w-full">
                <div class="flex flex-col md:flex-row-reverse items-center gap-12 w-full">
                    <div class="md:w-1/2 w-full">
                        <div class="w-full h-96 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1556306535-38febf6782e7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Različite vrste naočala" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="md:w-1/2 w-full fade-bottom">
                        <h2 class="text-3xl font-bold mb-6 font-serif">Naša misija</h2>
                        <p class="text-lg mb-6">Naša misija je jednostavna – osigurati vam jasan i zdrav pogled na
                            svijet. Bilo da vam trebaju dioptrijske naočale, kontaktne leće ili sunčane naočale, u
                            Interoptici ćete pronaći stručan tim koji će vas savjetovati i pomoći vam odabrati najbolje
                            rješenje za vaš vid i stil života.</p>
                        <div class="grid grid-cols-2 gap-4 mt-8 fade-bottom">
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <i class="fas fa-eye text-4xl text-indigo-600 mb-4"></i>
                                <h3 class="font-bold mb-2 font-serif">Pregled vida</h3>
                                <p class="text-gray-600">Precizna dijagnostika i savjetovanje</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-sm fade-bottom">
                                <i class="fas fa-glasses text-4xl text-indigo-600 mb-4"></i>
                                <h3 class="font-bold mb-2 font-serif">Širok izbor</h3>
                                <p class="text-gray-600">Naočale za sve potrebe i stilove</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-white"> <!-- Technology -->
            <div class="max-w-6xl mx-auto px-4 w-full">
                <div class="flex flex-col md:flex-row items-center gap-12 w-full">
                    <div class="md:w-1/2 w-full">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="h-48 rounded-lg overflow-hidden fade-bottom">
                                <img src="{{ asset('images/poslovnica5.jpeg') }}" alt="Optički instrumenti"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="h-48 rounded-lg overflow-hidden fade-bottom">
                                <img src="{{ asset('images/poslovnica3.jpeg') }}" alt="Optički instrumenti"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="h-48 rounded-lg overflow-hidden col-span-2 fade-bottom">
                                <img src="{{ asset('images/poslovnica4.jpeg') }}" alt="Korisnik s naočalama"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 w-full">
                        <h2 class="text-3xl font-bold mb-6 fade-bottom font-serif">Najnovije tehnologije i modni
                            trendovi</h2>
                        <p class="text-lg mb-6 fade-bottom">Pratimo najnovije tehnologije i modne trendove kako bismo
                            vam uvijek ponudili najkvalitetnije proizvode i usluge – jer vaš pogled zaslužuje samo
                            najbolje.</p>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="bg-indigo-100 p-2 rounded-full mt-1 fade-bottom">
                                    <i class="fas fa-lightbulb text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold font-serif">Inovativna rješenja</h3>
                                    <p class="text-gray-600">Koristimo najmoderniju opremu za precizna mjerenja</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 fade-bottom">
                                <div class="bg-indigo-100 p-2 rounded-full mt-1">
                                    <i class="fas fa-tshirt text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold font-serif">Modni savjeti</h3>
                                    <p class="text-gray-600">Pomognemo vam odabrati naočale koje odgovaraju vašem licu
                                        i stilu</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 fade-bottom">
                                <div class="bg-indigo-100 p-2 rounded-full mt-1">
                                    <i class="fas fa-shield-alt text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold font-serif">Kvalitetna zaštita</h3>
                                    <p class="text-gray-600">Naočale s UV zaštitom i antirefleksnim premazima</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-indigo-50 fade-bottom">
            <div class="max-w-6xl mx-auto px-4 w-full">
                <div class="text-center mb-12 fade-bottom">
                    <h2 class="text-3xl font-bold mb-4 font-serif">Generacije klijenata nam vjeruju</h2>
                    <p class="text-lg max-w-2xl mx-auto fade-bottom">Posjetite nas i uvjerite se zašto nam generacije
                        klijenata poklanjaju svoje povjerenje već više od 35 godina.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Review 1 -->
                    <a href="https://www.google.com/search?tbm=lcl&sxsrf=AE3TifP9eRO_zn5SPYaWT1BgeVr2H7LDPA:1751711405372&q=Interoptika%20Reviews&rflfq=1&num=20&stick=H4sIAAAAAAAAAONgkxI2NjY2NbUwsTQwMjEzMbWwMDY23MDI-IpR2DOvJLUov6AkMztRISi1LDO1vHgRKzZRAH8tZpNGAAAA&rldimm=3335584902464588331&hl=en-HR#lkt=LocalPoiReviews&arid=ChZDSUhNMG9nS0VJQ0FnSURiNWJmMGJBEAE"
                        target="_blank" class="testimonial-card p-8 rounded-lg hover:shadow-lg transition block">
                        <div class="flex items-center mb-4 fade-bottom">
                            <div class="ml-0">
                                <h4 class="font-bold">Marina Bubnić</h4>
                                <div class="flex items-center space-x-2 text-yellow-400 text-sm">
                                    <span class="flex">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="text-gray-600">5/5</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 fade-bottom">"Sve preporuke! Djelatnica stručna, strpljiva i ljubazna.
                            Veliki izbor okvira, odlični popusti! Vraćam se sigurno :)"</p>
                    </a>

                    <!-- Review 2 -->
                    <a href="https://www.google.com/search?tbm=lcl&sxsrf=AE3TifP9eRO_zn5SPYaWT1BgeVr2H7LDPA:1751711405372&q=Interoptika%20Reviews&rflfq=1&num=20&stick=H4sIAAAAAAAAAONgkxI2NjY2NbUwsTQwMjEzMbWwMDY23MDI-IpR2DOvJLUov6AkMztRISi1LDO1vHgRKzZRAH8tZpNGAAAA&rldimm=3335584902464588331&hl=en-HR#lkt=LocalPoiReviews&arid=ChZDSUhNMG9nS0VJQ0FnSURiNWJmMGJBEAE"
                        target="_blank" class="testimonial-card p-8 rounded-lg hover:shadow-lg transition block">
                        <div class="flex items-center mb-4 fade-bottom">
                            <div class="ml-0">
                                <h4 class="font-bold">Iva Nekić</h4>
                                <div class="flex items-center space-x-2 text-yellow-400 text-sm">
                                    <span class="flex">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="text-gray-600">5/5</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 fade-bottom">"Stručne, ljubazne i strpljive djelatnice; obavile
                            detaljan pregled dioptrije + dobila veliku pomoć pri odabiru okvira naočala. Cijene
                            pristupačne. Od mene sve preporuke! :)"</p>
                    </a>

                    <!-- Review 3 -->
                    <a href="https://www.google.com/search?tbm=lcl&sxsrf=AE3TifP9eRO_zn5SPYaWT1BgeVr2H7LDPA:1751711405372&q=Interoptika%20Reviews&rflfq=1&num=20&stick=H4sIAAAAAAAAAONgkxI2NjY2NbUwsTQwMjEzMbWwMDY23MDI-IpR2DOvJLUov6AkMztRISi1LDO1vHgRKzZRAH8tZpNGAAAA&rldimm=3335584902464588331&hl=en-HR#lkt=LocalPoiReviews&arid=ChZDSUhNMG9nS0VJQ0FnSURiNWJmMGJBEAE"
                        target="_blank" class="testimonial-card p-8 rounded-lg hover:shadow-lg transition block">
                        <div class="flex items-center mb-4 fade-bottom">
                            <div class="ml-0">
                                <h4 class="font-bold">Tomislav Stipic</h4>
                                <div class="flex items-center space-x-2 text-yellow-400 text-sm">
                                    <span class="flex">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="text-gray-600">5/5</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 fade-bottom">"Zamjena oštećenih stakala na sunčanim naočalama. Jedan
                            dan čekao. Sve pohvale ..👍"</p>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
