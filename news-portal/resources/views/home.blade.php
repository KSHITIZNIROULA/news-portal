<!-- resources/views/articles/index.blade.php -->
@extends('layouts.app')

@section('content')

    <main class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- hero page probably --}}
        <section class="bg-blue-600 from-primary-900 to-primary-800 text-white py-12 rounded-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&amp;h=500&amp;fit=crop"
                            alt="Breaking news coverage" keywords="news, journalism, breaking news, media"
                            class="w-full h-96 object-cover rounded-lg shadow-2xl transform hover:scale-105 transition-transform duration-300" />
                        <div
                            class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                            BREAKING
                        </div>
                    </div>
                    <div class="space-y-6">
                        <h2 class="text-4xl lg:text-5xl font-bold leading-tight">
                            Global Climate Summit Reaches Historic Agreement
                        </h2>
                        <p class="text-xl text-primary-100 leading-relaxed">
                            World leaders unite on groundbreaking environmental policies that could reshape the
                            future of our planet. The agreement includes unprecedented commitments to renewable
                            energy and carbon reduction.
                        </p>
                        <div class="flex items-center space-x-4 text-primary-200">
                            {{-- <span class="material-symbols-outlined">schedule</span> <span>{{ $breakingArticle->published_at->diffForHumans() }}</span> --}}
                            <span class="material-symbols-outlined">schedule</span> <span>2 days ago.</span>
                            {{-- <span class="material-symbols-outlined">person</span> <span>{{ $breaking->author->name }}</span> --}}
                        </div>
                        <button
                            class="bg-black text-primary-800 px-6 py-3 rounded-full font-semibold hover:bg-primary-50 transition-all duration-200 transform hover:scale-105">
                            Read Full Story
                        </button>
                    </div>
                </div>
            </div>
        </section>
        {{-- latest news section --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-3xl font-bold text-slate-800">Latest News</h3>
                <a href="{{ route('articles.index') }}"
                    class="text-primary-600 hover:text-primary-700 font-medium flex items-center transition-colors duration-200">
                    View All <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 inline" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            @if ($articles->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No articles found</h3>
                    <p class="mt-1 text-gray-500">There are currently no published articles available.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($articles as $article)
                        <article
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            @if ($article->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $article->images->first()->path) }}"
                                    alt="{{ $article->title }}" class="w-full h-48 object-cover" loading="lazy">
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    @if ($article->category)
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $article->category->name }}
                                        </span>
                                    @endif
                                    <span class="text-slate-500 ml-auto text-sm">
                                        {{ $article->published_at->diffForHumans() }}
                                    </span>
                                </div>

                                <h4
                                    class="text-xl font-bold text-slate-800 mb-3 hover:text-primary-600 transition-colors duration-200">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h4>

                                <p class="text-slate-600 mb-4 line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        @if ($article->author)
                                            <div
                                                class="w-8 h-8 bg-slate-300 rounded-full flex items-center justify-center text-sm font-medium">
                                                {{ strtoupper(substr($article->author->name, 0, 1)) }}
                                            </div>
                                            <span class="text-sm text-slate-600">{{ $article->author->name }}</span>
                                        @endif
                                    </div>
                                    <button class="text-primary-600 hover:text-primary-700 transition-colors duration-200">
                                        <span class="material-symbols-outlined">bookmark_add</span>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- @if ($articles->hasPages()) --}}
                <div class="mt-8">
                    {{-- {{ $articles->links() }} --}}
                </div>
                {{-- @endif --}}
            @endif
        </section>

        {{-- editors pick section --}}
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Editor's Picks Section -->
                <div class="lg:col-span-2">
                    <h3 class="text-3xl font-bold text-slate-800 mb-8">Editor's Picks</h3>
                    <div class="space-y-6">
                        @foreach ($articles as $Latestarticles)
                            <article
                                class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <img src="{{ asset('storage/' . $article->images->first()->path) }}"
                                        alt="{{ $article->title }}"
                                        class="w-full sm:w-32 h-24 object-cover rounded-lg flex-shrink-0">
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <span
                                                class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                                                {{ $article->category->name }}</span>
                                            <span class="text-slate-500 text-sm ml-auto">
                                                {{ $article->published_at->diffForHumans() }}</span>
                                        </div>
                                        <h4
                                            class="text-lg font-semibold text-slate-800 mb-2 hover:text-primary-600 transition-colors duration-200">
                                            <a href="{{ route('articles.show', $article->slug) }}">
                                                {{ $article->title }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-slate-600 line-clamp-2">

                                            {{ $article->content }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="space-y-6">
                    <!-- Trending Topics -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h4 class="text-xl font-bold text-slate-800 mb-4">Trending Topics</h4>
                        <div class="space-y-3">
                            @foreach ($trendingCategories as $category)
                                <a href="#"
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                                    <span class="font-medium text-slate-700">
                                        {{ $category->name }}
                                    </span>
                                    <span class="text-primary-600 font-semibold">
                                        {{ $category->articles_count }}
                                        {{ Str::plural('article', $category->articles_count) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter Subscription -->
                    <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl shadow-lg p-6 ">
                        <h4 class="text-xl font-bold mb-4">Stay Informed</h4>
                        <p class="mb-4 text-primary-100 opacity-90">
                            Get the latest news delivered to your inbox every morning.
                        </p>
                        <form class="space-y-3">
                            <input type="email" placeholder="Enter your email"
                                class="w-full px-4 py-2 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                                required />
                            <button type="submit"
                                class="w-full bg-white text-primary-700 px-4 py-2 rounded-lg font-semibold hover:bg-primary-50 transition-colors duration-200">
                                Subscribe Now
                            </button>
                        </form>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h4 class="text-xl font-bold text-slate-800 mb-4">Follow Us</h4>
                        <div class="grid grid-cols-3 gap-3">
                            <a href="#"
                                class="flex items-center justify-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="flex items-center justify-center p-3 bg-sky-50 rounded-lg hover:bg-sky-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#"
                                class="flex items-center justify-center p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
